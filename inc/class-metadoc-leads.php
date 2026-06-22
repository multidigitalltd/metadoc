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

		$phone = (string) get_post_meta( $post->ID, '_md_phone', true );
		$wa    = preg_replace( '/\D/', '', '972' . ltrim( $phone, '0' ) );
		printf(
			'<p style="margin-top:12px"><a class="button button-primary" href="tel:%1$s">%2$s</a> <a class="button" href="https://wa.me/%3$s" target="_blank" rel="noopener noreferrer">%4$s</a></p>',
			esc_attr( $phone ),
			esc_html__( 'חיוג ללקוח', 'metadoc' ),
			esc_attr( (string) $wa ),
			esc_html__( 'וואטסאפ', 'metadoc' )
		);
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
				'menu_position'       => 25,
				// לידים מכילים PII — כל גישה (תפריט/צפייה/עריכה/מחיקה) למנהלים בלבד,
				// כדי שעורכים/תפקידים אחרים עם הרשאות post לא יגיעו לשמות וטלפונים.
				'capability_type'     => 'post',
				'capabilities'        => array(
					'edit_post'           => 'manage_options',
					'read_post'           => 'manage_options',
					'delete_post'         => 'manage_options',
					'edit_posts'          => 'manage_options',
					'edit_others_posts'   => 'manage_options',
					'delete_posts'        => 'manage_options',
					'delete_others_posts' => 'manage_options',
					'publish_posts'       => 'manage_options',
					'read_private_posts'  => 'manage_options',
					'create_posts'        => 'do_not_allow', // נוצרים רק דרך ה-endpoint.
				),
				'map_meta_cap'        => true,
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
					'name'  => array( 'required' => true, 'type' => 'string' ),
					'phone' => array( 'required' => true, 'type' => 'string' ),
					'note'  => array( 'required' => false, 'type' => 'string' ),
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
		$response = new WP_REST_Response( array( 'nonce' => wp_create_nonce( 'wp_rest' ) ), 200 );
		$response->header( 'Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0' );
		return $response;
	}

	/**
	 * בדיקת הרשאה — אימות nonce של REST (מונע CSRF). פתוח לציבור אך חתום.
	 *
	 * @param WP_REST_Request $request הבקשה.
	 * @return bool|WP_Error
	 */
	public static function permission( WP_REST_Request $request ) {
		$nonce = $request->get_header( 'X-WP-Nonce' );
		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
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
		$note  = sanitize_textarea_field( (string) $request->get_param( 'note' ) );

		// אימות צד-שרת (לא לסמוך על הדפדפן).
		if ( mb_strlen( $name ) < 2 || mb_strlen( $name ) > 60 ) {
			return new WP_Error( 'metadoc_name', __( 'נא להזין שם מלא', 'metadoc' ), array( 'status' => 422 ) );
		}
		if ( ! preg_match( '/^0\d[\d-]{7,11}$/', $phone ) ) {
			return new WP_Error( 'metadoc_phone', __( 'מספר טלפון לא תקין', 'metadoc' ), array( 'status' => 422 ) );
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

		// שמירה כ-CPT.
		$post_id = wp_insert_post(
			array(
				'post_type'   => self::CPT,
				'post_status' => 'private',
				'post_title'  => sprintf( '%s · %s', $name, $phone ),
				'meta_input'  => array(
					'_md_name'    => $name,
					'_md_phone'   => $phone,
					'_md_note'    => $note,
					'_md_consent' => '1',
					'_md_ip'      => $ip,
					'_md_ua'      => sanitize_text_field( (string) $request->get_header( 'user_agent' ) ),
				),
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'metadoc_save', __( 'אירעה שגיאה. נסו שוב.', 'metadoc' ), array( 'status' => 500 ) );
		}

		set_transient( $key, 1, self::RATE_SECONDS );
		self::notify( $name, $phone, $note );

		return new WP_REST_Response( array( 'ok' => true ), 201 );
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
	private static function notify( string $name, string $phone, string $note ): void {
		$contact = metadoc_contact();
		$to      = apply_filters( 'metadoc_lead_email', $contact['email'] );
		$subject = sprintf( '[מטאדוק] ליד חדש מהאתר — %s', $name );

		$lines = array(
			'התקבלה פנייה חדשה לבדיקת זכאות:',
			'',
			'שם: ' . $name,
			'טלפון: ' . $phone,
			'פרטים: ' . ( '' !== $note ? $note : '—' ),
			'',
			'נשלח מ-' . home_url( '/' ),
		);

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		wp_mail( $to, $subject, implode( "\n", $lines ), $headers );
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
		$new['md_note']  = __( 'פרטים', 'metadoc' );
		$new['date']     = __( 'התקבל', 'metadoc' );
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
			'md_note'  => '_md_note',
		);
		if ( isset( $map[ $column ] ) ) {
			echo esc_html( (string) get_post_meta( $post_id, $map[ $column ], true ) );
		}
	}
}

Metadoc_Leads::init();
