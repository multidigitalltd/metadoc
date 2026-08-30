<?php
/**
 * ניהול לידים — CPT פרטי + REST endpoint מאובטח + התראת מייל.
 *
 * אבטחה (תקן Multi Digital): Nonce (wp_rest), Sanitization מלאה,
 * Honeypot, Rate limiting (transient), permission_callback, Escaping בפלט.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Leads
 */
final class Metadoc_Leads {

	private const CPT          = 'md_lead';
	private const RATE_SECONDS = 30; // מקסימום פנייה אחת לכל 30 שניות לכל IP.
	private const NONCE_ACTION = 'metadoc_lead'; // nonce ייעודי (לא wp_rest) למניעת התנגשות עם בדיקת ה-cookie של הליבה.

	/**
	 * אתחול ה-hooks.
	 */
	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register_cpt' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
		add_filter( 'manage_' . self::CPT . '_posts_columns', array( __CLASS__, 'admin_columns' ) );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', array( __CLASS__, 'admin_column_content' ), 10, 2 );
		add_filter( 'manage_edit-' . self::CPT . '_sortable_columns', array( __CLASS__, 'sortable_columns' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_boxes' ) );
		add_action( 'restrict_manage_posts', array( __CLASS__, 'admin_filters' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'filter_query' ) );
		add_action( 'admin_post_metadoc_export_leads', array( __CLASS__, 'export_csv' ) );
	}

	/* --------------------------------------------------------------------
	 * סינון וייצוא במסך הלידים
	 * ----------------------------------------------------------------- */

	/**
	 * מחזיר את ערכי הפרויקט/הטופס הקיימים בלידים (לרשימות הסינון).
	 *
	 * @param string $meta מפתח המטא.
	 * @return string[]
	 */
	private static function distinct_meta( string $meta ): array {
		global $wpdb;
		$values = wp_cache_get( 'md_lead_vals_' . $meta, 'metadoc' );
		if ( false === $values ) {
			$values = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
					 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
					 WHERE pm.meta_key = %s AND pm.meta_value <> '' AND p.post_type = %s
					 ORDER BY pm.meta_value ASC LIMIT 100",
					$meta,
					self::CPT
				)
			);
			wp_cache_set( 'md_lead_vals_' . $meta, $values, 'metadoc', 5 * MINUTE_IN_SECONDS );
		}
		return array_map( 'strval', (array) $values );
	}

	/**
	 * ההרשאה הנדרשת לצפייה בכל הלידים (פוסטים פרטיים של אחרים).
	 * edit_posts לבדה אינה מספיקה — היא קיימת גם לתורמים ולכותבים.
	 *
	 * @return string
	 */
	private static function read_all_cap(): string {
		$type = get_post_type_object( self::CPT );
		if ( $type && isset( $type->cap->read_private_posts ) ) {
			return (string) $type->cap->read_private_posts;
		}
		return 'read_private_posts';
	}

	/**
	 * תיבות הסינון וכפתור הייצוא מעל טבלת הלידים.
	 *
	 * @param string $post_type סוג התוכן במסך הנוכחי.
	 */
	public static function admin_filters( string $post_type ): void {
		if ( self::CPT !== $post_type || ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$filters = array(
			'md_project' => array( '_md_project', __( 'כל הפרויקטים', 'metadoc' ) ),
			'md_form'    => array( '_md_form', __( 'כל הטפסים', 'metadoc' ) ),
		);
		foreach ( $filters as $param => $filter ) {
			$current = isset( $_GET[ $param ] ) ? sanitize_text_field( wp_unslash( (string) $_GET[ $param ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- סינון תצוגה בלבד.
			printf( '<select name="%s"><option value="">%s</option>', esc_attr( $param ), esc_html( $filter[1] ) );
			foreach ( self::distinct_meta( $filter[0] ) as $value ) {
				printf(
					'<option value="%1$s"%2$s>%3$s</option>',
					esc_attr( $value ),
					selected( $current, $value, false ),
					esc_html( $value )
				);
			}
			echo '</select>';
		}

		if ( ! current_user_can( self::read_all_cap() ) ) {
			return; // ייצוא זמין רק למי שרשאי לקרוא את כל הלידים.
		}

		$export = wp_nonce_url(
			add_query_arg(
				array_filter(
					array(
						'action'     => 'metadoc_export_leads',
						'md_project' => isset( $_GET['md_project'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['md_project'] ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						'md_form'    => isset( $_GET['md_form'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['md_form'] ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					)
				),
				admin_url( 'admin-post.php' )
			),
			'metadoc_export_leads'
		);
		printf(
			' <a href="%1$s" class="button">%2$s</a>',
			esc_url( $export ),
			esc_html__( 'ייצוא לאקסל (CSV)', 'metadoc' )
		);
	}

	/**
	 * החלת הסינון על שאילתת הרשימה.
	 *
	 * @param WP_Query $query השאילתה.
	 */
	public static function filter_query( $query ): void {
		if ( ! is_admin() || ! $query->is_main_query() || self::CPT !== $query->get( 'post_type' ) ) {
			return;
		}
		$meta = array();
		foreach ( array( 'md_project' => '_md_project', 'md_form' => '_md_form' ) as $param => $key ) {
			$value = isset( $_GET[ $param ] ) ? sanitize_text_field( wp_unslash( (string) $_GET[ $param ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- סינון תצוגה בלבד.
			if ( '' !== $value ) {
				$meta[] = array(
					'key'     => $key,
					'value'   => $value,
					'compare' => '=',
				);
			}
		}
		if ( ! empty( $meta ) ) {
			$query->set( 'meta_query', $meta ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- מסך ניהול בלבד.
		}
	}

	/**
	 * ייצוא הלידים (לפי הסינון הנוכחי) לקובץ CSV הנפתח באקסל.
	 */
	public static function export_csv(): void {
		if ( ! current_user_can( self::read_all_cap() ) ) {
			wp_die( esc_html__( 'אין הרשאה.', 'metadoc' ), '', array( 'response' => 403 ) );
		}
		check_admin_referer( 'metadoc_export_leads' );

		$args = array(
			'post_type'      => self::CPT,
			'post_status'    => array( 'private', 'publish', 'draft' ),
			'posts_per_page' => 500, // נשלף במנות; הייצוא כולל את *כל* הרשומות.
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
			'offset'         => 0,
		);
		$meta = array();
		foreach ( array( 'md_project' => '_md_project', 'md_form' => '_md_form' ) as $param => $key ) {
			$value = isset( $_GET[ $param ] ) ? sanitize_text_field( wp_unslash( (string) $_GET[ $param ] ) ) : '';
			if ( '' !== $value ) {
				$meta[] = array(
					'key'     => $key,
					'value'   => $value,
					'compare' => '=',
				);
			}
		}
		if ( ! empty( $meta ) ) {
			$args['meta_query'] = $meta; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- ייצוא ידני.
		}

		$headers = array(
			__( 'תאריך', 'metadoc' ),
			__( 'שם', 'metadoc' ),
			__( 'טלפון', 'metadoc' ),
			__( 'אימייל', 'metadoc' ),
			__( 'פרויקט', 'metadoc' ),
			__( 'טופס', 'metadoc' ),
			__( 'פרטים', 'metadoc' ),
			__( 'מקור', 'metadoc' ),
			__( 'עמוד', 'metadoc' ),
		);

		nocache_headers();
		header( 'Content-Type: text/csv; charset=UTF-8' );
		header( 'Content-Disposition: attachment; filename=metadoc-leads-' . gmdate( 'Y-m-d' ) . '.csv' );

		/**
		 * מנטרל הזרקת נוסחאות ל-CSV: תא שמתחיל ב-= + - @ מתפרש באקסל כנוסחה.
		 *
		 * @param string $value ערך התא.
		 * @return string
		 */
		$escape = static function ( string $value ): string {
			return ( '' !== $value && strpbrk( $value[0], "=+-@\t\r" ) ) ? "'" . $value : $value;
		};

		$out = fopen( 'php://output', 'w' );
		// BOM — כדי שאקסל יזהה UTF-8 ויציג עברית כראוי.
		fwrite( $out, "\xEF\xBB\xBF" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite -- פלט לזרם, לא לקובץ.
		fputcsv( $out, $headers );

		// שליפה במנות: אתר עם עשרות אלפי פניות מיוצא במלואו, בלי לנפח זיכרון.
		do {
			$leads = get_posts( $args );
			foreach ( $leads as $lead ) {
				$row = array( get_the_date( 'Y-m-d H:i', $lead ) );
				foreach ( array( '_md_name', '_md_phone', '_md_email', '_md_project', '_md_form', '_md_note', '_md_src_utm_source', '_md_src_page' ) as $meta_key ) {
					$row[] = $escape( (string) get_post_meta( $lead->ID, $meta_key, true ) );
				}
				fputcsv( $out, $row );
			}
			$args['offset'] += $args['posts_per_page'];
			$fetched         = count( $leads );
			unset( $leads );
		} while ( $fetched === $args['posts_per_page'] );
		fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose -- פלט לזרם.
		exit;
	}

	/**
	 * עמודות מיון.
	 *
	 * @param array $cols עמודות.
	 * @return array
	 */
	public static function sortable_columns( array $cols ): array {
		$cols['date'] = 'date';
		return $cols;
	}

	/**
	 * תיבת פרטי ליד במסך העריכה.
	 */
	public static function meta_boxes(): void {
		add_meta_box( 'metadoc_lead_details', __( 'פרטי הליד', 'metadoc' ), array( __CLASS__, 'render_details' ), self::CPT, 'normal', 'high' );
	}

	/**
	 * רינדור פרטי הליד (קריאה בלבד) + פעולות מהירות.
	 *
	 * @param WP_Post $post הפוסט.
	 */
	public static function render_details( WP_Post $post ): void {
		$fields = array(
			'_md_name'    => __( 'שם', 'metadoc' ),
			'_md_phone'   => __( 'טלפון', 'metadoc' ),
			'_md_email'   => __( 'אימייל', 'metadoc' ),
			'_md_project' => __( 'פרויקט', 'metadoc' ),
			'_md_form'    => __( 'טופס', 'metadoc' ),
			'_md_note'    => __( 'פרטים', 'metadoc' ),
			'_md_consent' => __( 'אישור מדיניות פרטיות', 'metadoc' ),
			'_md_ip'      => __( 'כתובת IP', 'metadoc' ),
			'_md_ua'      => __( 'דפדפן', 'metadoc' ),
		);
		echo '<table class="widefat striped"><tbody>';
		foreach ( $fields as $meta => $label ) {
			$value = (string) get_post_meta( $post->ID, $meta, true );
			if ( '_md_consent' === $meta ) {
				$value = $value ? __( 'כן', 'metadoc' ) : __( 'לא', 'metadoc' );
			}
			printf(
				'<tr><th style="width:170px;text-align:right">%s</th><td>%s</td></tr>',
				esc_html( $label ),
				esc_html( '' !== $value ? $value : '—' )
			);
		}
		echo '</tbody></table>';

		// מקור הגעה.
		$src_rows = '';
		foreach ( self::source_labels() as $meta => $label ) {
			$value = (string) get_post_meta( $post->ID, $meta, true );
			if ( '' === $value ) {
				continue;
			}
			$display   = ( 0 === strpos( $value, 'http' ) )
				? '<a href="' . esc_url( $value ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $value ) . '</a>'
				: esc_html( $value );
			$src_rows .= sprintf( '<tr><th style="width:170px;text-align:right">%s</th><td>%s</td></tr>', esc_html( $label ), $display );
		}
		echo '<h2 style="margin:18px 0 6px;font-size:14px">' . esc_html__( 'מקור הגעה', 'metadoc' ) . '</h2>';
		if ( '' !== $src_rows ) {
			echo '<table class="widefat striped"><tbody>' . $src_rows . '</tbody></table>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- כל שורה נבנתה עם esc_html/esc_url.
		} else {
			echo '<p>' . esc_html__( 'ישיר / לא ידוע (ללא פרמטרי מעקב).', 'metadoc' ) . '</p>';
		}

		$phone = (string) get_post_meta( $post->ID, '_md_phone', true );
		$email = (string) get_post_meta( $post->ID, '_md_email', true );
		echo '<p style="margin-top:12px">';
		if ( '' !== $phone ) {
			$wa = preg_replace( '/\D/', '', '972' . ltrim( $phone, '0' ) );
			printf(
				'<a class="button button-primary" href="tel:%1$s">%2$s</a> <a class="button" href="https://wa.me/%3$s" target="_blank" rel="noopener noreferrer">%4$s</a> ',
				esc_attr( $phone ),
				esc_html__( 'חיוג ללקוח', 'metadoc' ),
				esc_attr( (string) $wa ),
				esc_html__( 'וואטסאפ', 'metadoc' )
			);
		}
		if ( '' !== $email ) {
			printf(
				'<a class="button" href="mailto:%1$s">%2$s</a>',
				esc_attr( $email ),
				esc_html__( 'שליחת מייל', 'metadoc' )
			);
		}
		echo '</p>';
	}

	/**
	 * רישום סוג תוכן פרטי ללידים.
	 */
	public static function register_cpt(): void {
		register_post_type(
			self::CPT,
			array(
				'labels'              => array(
					'name'          => __( 'לידים', 'metadoc' ),
					'singular_name' => __( 'ליד', 'metadoc' ),
					'menu_name'     => __( 'לידים', 'metadoc' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => false,
				'menu_icon'           => 'dashicons-email-alt',
				'menu_position'       => 26, // 25 תפוס ע"י "תגובות" — התנגשות מסתירה את התפריט.
				// הרשאות תקן של 'post' (כל מנהל/עורך תוכן ניגש). הלידים נוצרים רק
				// דרך ה-endpoint, ולכן create_posts מושבת.
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'capabilities'        => array(
					'create_posts' => 'do_not_allow',
				),
				'supports'            => array( 'title' ),
				'exclude_from_search' => true,
				'has_archive'         => false,
				'rewrite'             => false,
			)
		);
	}

	/**
	 * רישום ה-REST route.
	 */
	public static function register_routes(): void {
		register_rest_route(
			'metadoc/v1',
			'/lead',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( __CLASS__, 'handle' ),
				'permission_callback' => array( __CLASS__, 'permission' ),
				'args'                => array(
					'name'   => array( 'required' => true, 'type' => 'string' ),
					// טלפון או אימייל — לפחות אחד מהם חובה, נבדק ב-handle().
					'phone'  => array( 'required' => false, 'type' => 'string' ),
					'email'  => array( 'required' => false, 'type' => 'string' ),
					// מקור הפנייה — פרויקט והטופס שממנו נשלחה. לעולם לא חוסם שליחה.
					'project' => array( 'required' => false, 'type' => 'string' ),
					'form'    => array( 'required' => false, 'type' => 'string' ),
					'note'   => array( 'required' => false, 'type' => 'string' ),
					'source' => array( 'required' => false ), // אופציונלי — מקור הגעה; לעולם לא חוסם שליחה.
				),
			)
		);

		// מנפיק nonce טרי בזמן ריצה — מונע 403 כשה-HTML מוגש מ-full-page cache/CDN
		// וה-nonce המוטמע פג. ה-endpoint אינו ניתן למטמון.
		register_rest_route(
			'metadoc/v1',
			'/nonce',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'nonce' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * מחזיר nonce עדכני ל-REST, עם כותרות מניעת מטמון.
	 *
	 * @return WP_REST_Response
	 */
	public static function nonce(): WP_REST_Response {
		nocache_headers();
		$response = new WP_REST_Response( array( 'nonce' => wp_create_nonce( self::NONCE_ACTION ) ), 200 );
		$response->header( 'Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0' );
		return $response;
	}

	/**
	 * בדיקת הרשאה — אימות nonce ייעודי משלנו (מונע CSRF). פתוח לציבור אך חתום.
	 * משתמשים ב-nonce ייעודי (לא wp_rest) ובשדה גוף ייעודי (לא X-WP-Nonce),
	 * כדי שבדיקת ה-cookie של ליבת ה-REST לא תיכשל עבור משתמשים מחוברים.
	 *
	 * @param WP_REST_Request $request הבקשה.
	 * @return bool|WP_Error
	 */
	public static function permission( WP_REST_Request $request ) {
		$nonce = (string) $request->get_param( 'md_nonce' );
		if ( '' === $nonce ) {
			$nonce = (string) $request->get_header( 'X-Metadoc-Nonce' );
		}
		if ( '' === $nonce || ! wp_verify_nonce( $nonce, self::NONCE_ACTION ) ) {
			return new WP_Error( 'metadoc_bad_nonce', __( 'אימות נכשל. רעננו את העמוד ונסו שוב.', 'metadoc' ), array( 'status' => 403 ) );
		}
		return true;
	}

	/**
	 * טיפול בשליחת ליד.
	 *
	 * @param WP_REST_Request $request הבקשה.
	 * @return WP_REST_Response|WP_Error
	 */
	public static function handle( WP_REST_Request $request ) {
		// Honeypot — שדה שאמור להישאר ריק. בוטים ממלאים אותו.
		if ( '' !== trim( (string) $request->get_param( 'website' ) ) ) {
			return new WP_REST_Response( array( 'ok' => true ), 200 ); // בליעה שקטה.
		}

		// Rate limiting לפי IP.
		$ip  = self::client_ip();
		$key = 'md_lead_rl_' . md5( $ip );
		if ( get_transient( $key ) ) {
			return new WP_Error( 'metadoc_rate', __( 'נא להמתין רגע לפני שליחה נוספת.', 'metadoc' ), array( 'status' => 429 ) );
		}

		// Sanitization.
		$name  = sanitize_text_field( (string) $request->get_param( 'name' ) );
		$phone = sanitize_text_field( (string) $request->get_param( 'phone' ) );
		$email = sanitize_email( (string) $request->get_param( 'email' ) );
		$note    = sanitize_textarea_field( (string) $request->get_param( 'note' ) );
		$project = sanitize_text_field( (string) $request->get_param( 'project' ) );
		$form    = sanitize_text_field( (string) $request->get_param( 'form' ) );

		// אימות צד-שרת (לא לסמוך על הדפדפן).
		if ( mb_strlen( $name ) < 2 || mb_strlen( $name ) > 60 ) {
			return new WP_Error( 'metadoc_name', __( 'נא להזין שם מלא', 'metadoc' ), array( 'status' => 422 ) );
		}
		// אימות טלפון לפי ספרות בלבד — תומך מקומי (0...) ובינלאומי (972...).
		$phone_digits = (string) preg_replace( '/\D/', '', $phone );
		$phone_ok     = ( '' !== $phone_digits )
			&& ( preg_match( '/^0\d{7,9}$/', $phone_digits ) || preg_match( '/^972\d{8,9}$/', $phone_digits ) );
		$email_ok     = ( '' !== $email && is_email( $email ) );

		// לפחות אמצעי קשר אחד תקין. הטפסים הקצרים מאפשרים אימייל במקום טלפון.
		if ( ! $phone_ok && ! $email_ok ) {
			$message = '' !== $email
				? __( 'נא להזין טלפון או אימייל תקינים', 'metadoc' )
				: __( 'מספר טלפון לא תקין', 'metadoc' );
			return new WP_Error( 'metadoc_phone', $message, array( 'status' => 422 ) );
		}
		if ( ! $phone_ok ) {
			$phone = '';
		}
		if ( ! $email_ok ) {
			$email = '';
		}
		if ( mb_strlen( $note ) > 1000 ) {
			$note = mb_substr( $note, 0, 1000 );
		}

		// אישור מדיניות פרטיות — חובה (נבדק גם בצד השרת).
		if ( empty( $request->get_param( 'consent' ) ) ) {
			return new WP_Error( 'metadoc_consent', __( 'יש לאשר את מדיניות הפרטיות', 'metadoc' ), array( 'status' => 422 ) );
		}

		// אימות Cloudflare Turnstile (אם מופעל בהגדרות).
		$captcha = self::verify_turnstile( $request, $ip );
		if ( is_wp_error( $captcha ) ) {
			return $captcha;
		}

		// מקור הגעה (UTM / referrer / קמפיין) — מהדפדפן, מסונן בצד שרת.
		$src  = self::sanitize_source( (array) $request->get_param( 'source' ) );
		$meta = array(
			'_md_name'    => $name,
			'_md_phone'   => $phone,
			'_md_email'   => $email,
			'_md_note'    => $note,
			'_md_project' => mb_substr( $project, 0, 120 ),
			'_md_form'    => mb_substr( $form, 0, 60 ),
			'_md_consent' => '1',
			'_md_ip'      => $ip,
			'_md_ua'      => sanitize_text_field( (string) $request->get_header( 'user_agent' ) ),
		);
		foreach ( $src as $sk => $sv ) {
			if ( '' !== $sv ) {
				$meta[ '_md_src_' . $sk ] = $sv;
			}
		}

		// שמירה כ-CPT.
		$post_id = wp_insert_post(
			array(
				'post_type'   => self::CPT,
				'post_status' => 'private',
				'post_title'  => sprintf( '%s · %s', $name, '' !== $phone ? $phone : $email ),
				'meta_input'  => $meta,
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'metadoc_save', __( 'אירעה שגיאה. נסו שוב.', 'metadoc' ), array( 'status' => 500 ) );
		}

		set_transient( $key, 1, self::RATE_SECONDS );
		self::notify( $name, $phone, $note, $src, $email, $project, $form );
		self::send_webhook(
			array(
				'name'       => $name,
				'phone'      => $phone,
				'email'      => $email,
				'note'       => $note,
				'project'    => $project,
				'form'       => $form,
				'source'     => $src,
				'site'       => home_url( '/' ),
				'created_at' => current_time( 'c' ),
			)
		);

		return new WP_REST_Response( array( 'ok' => true ), 201 );
	}

	/**
	 * שליחת Webhook עם נתוני הליד (אם הוגדרה כתובת בהגדרות).
	 * נשלח ללא חסימה (fire-and-forget) כדי לא להשהות את תגובת הטופס.
	 *
	 * @param array $data נתוני הליד.
	 */
	private static function send_webhook( array $data ): void {
		if ( ! class_exists( 'Metadoc_Settings' ) ) {
			return;
		}
		$url = Metadoc_Settings::get( 'webhook_url' );
		if ( '' === $url || ! wp_http_validate_url( $url ) ) {
			return;
		}
		wp_remote_post(
			$url,
			array(
				'timeout'  => 5,
				'blocking' => false, // לא מעכב את המשתמש.
				'headers'  => array( 'Content-Type' => 'application/json; charset=utf-8' ),
				'body'     => wp_json_encode( $data ),
			)
		);
	}

	/**
	 * אימות טוקן Cloudflare Turnstile מול שרת Cloudflare.
	 * אם Turnstile אינו מופעל — מדלג ומחזיר true.
	 *
	 * @param WP_REST_Request $request הבקשה.
	 * @param string          $ip      כתובת ה-IP של הלקוח.
	 * @return true|WP_Error
	 */
	private static function verify_turnstile( WP_REST_Request $request, string $ip ) {
		if ( ! class_exists( 'Metadoc_Settings' ) || ! Metadoc_Settings::turnstile_enabled() ) {
			return true;
		}
		$secret = Metadoc_Settings::get( 'turnstile_secret_key' );
		if ( '' === $secret ) {
			return true; // הוגדר site key בלבד — לא ניתן לאמת בצד שרת, לא חוסמים.
		}

		$token = sanitize_text_field( (string) $request->get_param( 'captcha' ) );
		if ( '' === $token ) {
			return new WP_Error( 'metadoc_captcha', __( 'נא להשלים את אימות ה-CAPTCHA', 'metadoc' ), array( 'status' => 422 ) );
		}

		$resp = wp_remote_post(
			'https://challenges.cloudflare.com/turnstile/v0/siteverify',
			array(
				'timeout' => 8,
				'body'    => array(
					'secret'   => $secret,
					'response' => $token,
					'remoteip' => $ip,
				),
			)
		);

		if ( is_wp_error( $resp ) ) {
			// כשל בתקשורת מול Cloudflare — לא חוסמים ליד לגיטימי בגלל תקלת רשת.
			return true;
		}

		$body = json_decode( (string) wp_remote_retrieve_body( $resp ), true );
		if ( empty( $body['success'] ) ) {
			return new WP_Error( 'metadoc_captcha', __( 'אימות ה-CAPTCHA נכשל. נסו שוב.', 'metadoc' ), array( 'status' => 422 ) );
		}

		return true;
	}

	/**
	 * שליחת התראת מייל למשרד.
	 *
	 * @param string $name  שם.
	 * @param string $phone טלפון.
	 * @param string $note  הערה.
	 */
	private static function notify( string $name, string $phone, string $note, array $src = array(), string $email = '', string $project = '', string $form = '' ): void {
		$contact = metadoc_contact();

		// יעד: מההגדרות אם תקין, אחרת ברירת המחדל. ניתן לעקיפה דרך פילטר.
		$to = class_exists( 'Metadoc_Settings' ) ? Metadoc_Settings::get( 'lead_email' ) : '';
		if ( '' === $to || ! is_email( $to ) ) {
			$to = $contact['email'];
		}
		$to = apply_filters( 'metadoc_lead_email', $to );

		$subject = sprintf( '[מטאדוק] ליד חדש מהאתר — %s', $name );

		$lines = array(
			'התקבלה פנייה חדשה לבדיקת זכאות:',
			'',
			'שם: ' . $name,
			'טלפון: ' . ( '' !== $phone ? $phone : '—' ),
			'אימייל: ' . ( '' !== $email ? $email : '—' ),
			'פרויקט: ' . ( '' !== $project ? $project : '—' ),
			'טופס: ' . ( '' !== $form ? $form : '—' ),
			'פרטים: ' . ( '' !== $note ? $note : '—' ),
		);

		$src_lines = self::source_email_lines( $src );
		if ( ! empty( $src_lines ) ) {
			$lines[] = '';
			$lines[] = '— מקור הגעה —';
			$lines   = array_merge( $lines, $src_lines );
		}

		$lines[] = '';
		$lines[] = 'נשלח מ-' . home_url( '/' );

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

		// כתובת שולח (From) מההגדרות, אם הוגדרה ותקינה.
		$from_email = class_exists( 'Metadoc_Settings' ) ? Metadoc_Settings::get( 'from_email' ) : '';
		if ( '' !== $from_email && is_email( $from_email ) ) {
			$from_name = Metadoc_Settings::get( 'from_name' );
			$from_name = '' !== $from_name ? $from_name : get_bloginfo( 'name' );
			$headers[] = sprintf( 'From: %s <%s>', $from_name, $from_email );
		}

		wp_mail( $to, $subject, implode( "\n", $lines ), $headers );
	}

	/**
	 * סניטציה לנתוני מקור ההגעה (מהדפדפן — לא אמין).
	 *
	 * @param array $s קלט גולמי.
	 * @return array<string,string>
	 */
	private static function sanitize_source( array $s ): array {
		$url = static function ( $v ): string {
			return mb_substr( esc_url_raw( trim( (string) $v ) ), 0, 300 );
		};
		$txt = static function ( $v ): string {
			return mb_substr( sanitize_text_field( (string) $v ), 0, 150 );
		};
		return array(
			'page'         => $url( $s['page'] ?? '' ),
			'landing'      => $url( $s['landing'] ?? '' ),
			'referrer'     => $url( $s['referrer'] ?? '' ),
			'utm_source'   => $txt( $s['utm_source'] ?? '' ),
			'utm_medium'   => $txt( $s['utm_medium'] ?? '' ),
			'utm_campaign' => $txt( $s['utm_campaign'] ?? '' ),
			'utm_term'     => $txt( $s['utm_term'] ?? '' ),
			'utm_content'  => $txt( $s['utm_content'] ?? '' ),
			'cId'          => $txt( $s['cId'] ?? '' ),
			'sId'          => $txt( $s['sId'] ?? '' ),
			'aId'          => $txt( $s['aId'] ?? '' ),
			'type'         => $txt( $s['type'] ?? '' ),
		);
	}

	/**
	 * תוויות תצוגה לשדות מקור ההגעה (meta key => label).
	 *
	 * @return array<string,string>
	 */
	private static function source_labels(): array {
		return array(
			'_md_src_utm_source'   => __( 'מקור (utm_source)', 'metadoc' ),
			'_md_src_utm_medium'   => __( 'מדיום (utm_medium)', 'metadoc' ),
			'_md_src_utm_campaign' => __( 'קמפיין (utm_campaign)', 'metadoc' ),
			'_md_src_utm_term'     => __( 'utm_term', 'metadoc' ),
			'_md_src_utm_content'  => __( 'utm_content', 'metadoc' ),
			'_md_src_referrer'     => __( 'Referrer', 'metadoc' ),
			'_md_src_landing'      => __( 'דף כניסה', 'metadoc' ),
			'_md_src_page'         => __( 'דף השליחה', 'metadoc' ),
			'_md_src_cId'          => __( 'מזהה קמפיין (cId)', 'metadoc' ),
			'_md_src_sId'          => __( 'מזהה sId', 'metadoc' ),
			'_md_src_aId'          => __( 'מזהה aId', 'metadoc' ),
			'_md_src_type'         => __( 'סוג (type)', 'metadoc' ),
		);
	}

	/**
	 * שורות מקור הגעה למייל (לא ריקות בלבד).
	 *
	 * @param array $src נתוני מקור.
	 * @return string[]
	 */
	private static function source_email_lines( array $src ): array {
		$map = array(
			'utm_source'   => 'מקור',
			'utm_medium'   => 'מדיום',
			'utm_campaign' => 'קמפיין',
			'utm_term'     => 'utm_term',
			'utm_content'  => 'utm_content',
			'referrer'     => 'Referrer',
			'landing'      => 'דף כניסה',
			'page'         => 'דף השליחה',
			'cId'          => 'cId',
			'sId'          => 'sId',
			'aId'          => 'aId',
			'type'         => 'type',
		);
		$out = array();
		foreach ( $map as $key => $label ) {
			if ( ! empty( $src[ $key ] ) ) {
				$out[] = $label . ': ' . $src[ $key ];
			}
		}
		return $out;
	}

	/**
	 * זיהוי IP הלקוח בזהירות (לא לסמוך עיוור על כותרות proxy).
	 *
	 * @return string
	 */
	private static function client_ip(): string {
		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0.0.0.0';
		return filter_var( $ip, FILTER_VALIDATE_IP ) ? $ip : '0.0.0.0';
	}

	/**
	 * עמודות מותאמות בטבלת הלידים בניהול.
	 *
	 * @param array $cols עמודות.
	 * @return array
	 */
	public static function admin_columns( array $cols ): array {
		$new = array( 'cb' => $cols['cb'] ?? '' );
		$new['md_name']  = __( 'שם', 'metadoc' );
		$new['md_phone'] = __( 'טלפון', 'metadoc' );
		$new['md_email']  = __( 'אימייל', 'metadoc' );
		$new['md_project'] = __( 'פרויקט', 'metadoc' );
		$new['md_form']    = __( 'טופס', 'metadoc' );
		$new['md_note']   = __( 'פרטים', 'metadoc' );
		$new['md_source'] = __( 'מקור', 'metadoc' );
		$new['date']      = __( 'התקבל', 'metadoc' );
		return $new;
	}

	/**
	 * תוכן עמודה מותאמת.
	 *
	 * @param string $column  מזהה עמודה.
	 * @param int    $post_id מזהה הפוסט.
	 */
	public static function admin_column_content( string $column, int $post_id ): void {
		$map = array(
			'md_name'  => '_md_name',
			'md_phone' => '_md_phone',
			'md_email' => '_md_email',
			'md_project' => '_md_project',
			'md_form'    => '_md_form',
			'md_note'  => '_md_note',
		);
		if ( isset( $map[ $column ] ) ) {
			echo esc_html( (string) get_post_meta( $post_id, $map[ $column ], true ) );
			return;
		}
		if ( 'md_source' === $column ) {
			$utm = (string) get_post_meta( $post_id, '_md_src_utm_source', true );
			if ( '' !== $utm ) {
				echo esc_html( $utm );
				return;
			}
			$ref = (string) get_post_meta( $post_id, '_md_src_referrer', true );
			if ( '' !== $ref ) {
				$host = wp_parse_url( $ref, PHP_URL_HOST );
				echo esc_html( $host ? (string) $host : $ref );
				return;
			}
			echo esc_html__( 'ישיר', 'metadoc' );
		}
	}
}

Metadoc_Leads::init();
