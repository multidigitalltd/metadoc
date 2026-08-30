<?php
/**
 * מחלקת נדל"ן והשקעות — טעינה מותנית, נכסי תמונה ניתנים להחלפה,
 * קישורים בין העמודים ויצירת העמודים בעת הפעלת התבנית.
 *
 * שתי התבניות: template-realestate.php (עמוד המחלקה) ו-template-project.php
 * (עמוד פרויקט "שער המפרץ"). ה-CSS/JS שלהן נטענים אך ורק בעמודים אלה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_RealEstate
 */
final class Metadoc_RealEstate {

	public const TPL_DEPT    = 'template-realestate.php';
	public const TPL_PROJECT = 'template-project.php';

	/**
	 * מזהי חריצי התמונה הניתנים להחלפה דרך ההתאמה האישית.
	 * key => array( label, description, default_file ).
	 *
	 * @return array<string,array<string,string>>
	 */
	public static function image_slots(): array {
		return array(
			'hero'     => array(
				'label' => __( 'ראשי — פנורמה (יחס 16:5.5)', 'metadoc' ),
				'desc'  => __( 'תמונה רחבה של פרויקט או קו רקיע. מומלץ 2400×825.', 'metadoc' ),
				'file'  => '',
			),
			'about'    => array(
				'label' => __( 'אודות — צוות / משרד (יחס 4:3)', 'metadoc' ),
				'desc'  => __( 'מומלץ 1200×900.', 'metadoc' ),
				'file'  => '',
			),
			'process'  => array(
				'label' => __( 'התהליך — ליווי משקיעים (יחס 4:5)', 'metadoc' ),
				'desc'  => __( 'מומלץ 900×1125.', 'metadoc' ),
				'file'  => '',
			),
			'band'     => array(
				'label' => __( 'רצועת CTA — תמונה רחבה', 'metadoc' ),
				'desc'  => __( 'מומלץ 2400×700, עם שמיים בהירים בחלק העליון.', 'metadoc' ),
				'file'  => '',
			),
			'proj1'    => array(
				'label' => __( 'כרטיס פרויקט 1', 'metadoc' ),
				'desc'  => __( 'יחס 16:10.', 'metadoc' ),
				'file'  => '',
			),
			'proj2'    => array(
				'label' => __( 'כרטיס פרויקט 2', 'metadoc' ),
				'desc'  => __( 'יחס 16:10.', 'metadoc' ),
				'file'  => '',
			),
			'proj3'    => array(
				'label' => __( 'כרטיס פרויקט 3', 'metadoc' ),
				'desc'  => __( 'יחס 16:10.', 'metadoc' ),
				'file'  => '',
			),
			'pr_hero'  => array(
				'label' => __( 'פרויקט — תמונת Hero', 'metadoc' ),
				'desc'  => __( 'ברירת מחדל: הדמיית המרקם העירוני המצורפת לתבנית.', 'metadoc' ),
				'file'  => 're/project-hero.webp',
			),
			'pr_mass'  => array(
				'label' => __( 'פרויקט — הדמיית בינוי', 'metadoc' ),
				'desc'  => __( 'ברירת מחדל: הדמיית הבינוי המצורפת לתבנית.', 'metadoc' ),
				'file'  => 're/project-massing.webp',
			),
			'pr_heigh' => array(
				'label' => __( 'פרויקט — מפת גבהי בנייה', 'metadoc' ),
				'desc'  => __( 'ברירת מחדל: מפת הגבהים המצורפת לתבנית.', 'metadoc' ),
				'file'  => 're/project-heights.webp',
			),
		);
	}

	/**
	 * אתחול ה-hooks.
	 */
	public static function init(): void {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ), 20 );
		add_action( 'customize_register', array( __CLASS__, 'customize' ) );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
		add_action( 'after_switch_theme', array( __CLASS__, 'install_pages' ) );
		add_action( 'admin_init', array( __CLASS__, 'maybe_install_pages' ) );
		add_action( 'save_post_page', array( __CLASS__, 'flush_urls' ) );
		add_action( 'deleted_post', array( __CLASS__, 'flush_urls' ) );
	}

	/**
	 * האם העמוד הנוכחי הוא אחת משתי תבניות הנדל"ן.
	 *
	 * @return bool
	 */
	public static function is_re_page(): bool {
		if ( class_exists( 'Metadoc_Projects' ) && is_singular( Metadoc_Projects::CPT ) ) {
			return true;
		}
		return is_page_template( array( self::TPL_DEPT, self::TPL_PROJECT ) );
	}

	/**
	 * הוספת מחלקה ל-body לזיהוי העמודים (מיקום ווידג'טים צפים).
	 *
	 * @param array $classes מחלקות קיימות.
	 * @return array
	 */
	public static function body_class( array $classes ): array {
		if ( self::is_re_page() ) {
			$classes[] = 'md-re-page';
		}
		return $classes;
	}

	/**
	 * טעינה מותנית של הסגנון והסקריפט — רק בשני העמודים האלה.
	 */
	public static function enqueue(): void {
		if ( ! self::is_re_page() ) {
			return;
		}

		wp_enqueue_style(
			'metadoc-realestate',
			METADOC_URI . '/assets/css/realestate.min.css',
			array( 'metadoc-app' ),
			metadoc_asset_ver( 'assets/css/realestate.min.css' )
		);

		wp_enqueue_script(
			'metadoc-realestate',
			METADOC_URI . '/assets/js/realestate.js',
			array( 'metadoc-main' ),
			metadoc_asset_ver( 'assets/js/realestate.js' ),
			true
		);
	}

	/**
	 * שדות ההתאמה האישית — תמונות התוכן של שני העמודים.
	 *
	 * @param WP_Customize_Manager $wp_customize מנהל ההתאמה האישית.
	 */
	public static function customize( $wp_customize ): void {
		$wp_customize->add_section(
			'metadoc_realestate',
			array(
				'title'       => __( 'מחלקת נדל"ן — תמונות', 'metadoc' ),
				'priority'    => 45,
				'description' => __( 'תמונות עמוד מחלקת הנדל"ן ועמוד הפרויקט. חריץ ריק מציג מסגרת מציין-מקום ואינו שובר את הפריסה.', 'metadoc' ),
			)
		);

		foreach ( self::image_slots() as $key => $slot ) {
			$id = 'metadoc_re_img_' . $key;
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => 0,
					'sanitize_callback' => 'absint',
					'transport'         => 'refresh',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					$id,
					array(
						'label'       => $slot['label'],
						'description' => $slot['desc'],
						'section'     => 'metadoc_realestate',
						'mime_type'   => 'image',
					)
				)
			);
		}
	}

	/**
	 * מחזיר כתובת עמוד לפי תבנית (עם מטמון קצר, ללא שאילתה בכל טעינה).
	 *
	 * @param string $template שם קובץ התבנית.
	 * @return string כתובת, או '' אם אין עמוד כזה.
	 */
	public static function page_url( string $template ): string {
		static $cache = array();
		if ( isset( $cache[ $template ] ) ) {
			return $cache[ $template ];
		}

		$key = 'md_re_url_' . md5( $template );
		$url = get_transient( $key );
		if ( false === $url ) {
			$pages = get_posts(
				array(
					'post_type'        => 'page',
					'post_status'      => 'publish',
					'posts_per_page'   => 1,
					'meta_key'         => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- שאילתה יחידה, נשמרת ב-transient.
					'meta_value'       => $template, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value -- כנ"ל.
					'fields'           => 'ids',
					'no_found_rows'    => true,
					'suppress_filters' => false,
				)
			);
			$url = $pages ? (string) get_permalink( (int) $pages[0] ) : '';
			set_transient( $key, $url, DAY_IN_SECONDS );
		}

		$cache[ $template ] = (string) $url;
		return $cache[ $template ];
	}

	/**
	 * ניקוי מטמון הכתובות כשעמוד נשמר.
	 */
	public static function flush_urls(): void {
		delete_transient( 'md_re_url_' . md5( self::TPL_DEPT ) );
		delete_transient( 'md_re_url_' . md5( self::TPL_PROJECT ) );
	}

	/**
	 * יוצר את שני העמודים אם אינם קיימים, ומצמיד להם את התבניות.
	 */
	public static function install_pages(): void {
		$pages = array(
			'real-estate'    => array(
				'title'    => __( 'מחלקת נדל"ן והשקעות', 'metadoc' ),
				'template' => self::TPL_DEPT,
			),
			'shaar-hamifratz' => array(
				'title'    => __( 'שער המפרץ — תמ"א 75', 'metadoc' ),
				'template' => self::TPL_PROJECT,
			),
		);

		foreach ( $pages as $slug => $page ) {
			// רק עמוד *מפורסם* נחשב קיים. עמוד טיוטה/פרטי/באשפה באותו slug אינו
			// נגיש לגולשים, ולכן יוצרים עמוד חדש (וורדפרס יבחר slug פנוי).
			$existing = get_posts(
				array(
					'post_type'        => 'page',
					'post_status'      => 'publish',
					'name'             => $slug,
					'posts_per_page'   => 1,
					'fields'           => 'ids',
					'no_found_rows'    => true,
					'suppress_filters' => false,
				)
			);
			if ( ! empty( $existing ) ) {
				update_post_meta( (int) $existing[0], '_wp_page_template', $page['template'] );
				continue;
			}
			wp_insert_post(
				array(
					'post_title'  => $page['title'],
					'post_name'   => $slug,
					'post_status' => 'publish',
					'post_type'   => 'page',
					'meta_input'  => array( '_wp_page_template' => $page['template'] ),
				)
			);
		}

		self::flush_urls();
	}

	/**
	 * יצירה חד-פעמית גם בהתקנות קיימות (לא רק בהפעלת התבנית).
	 */
	public static function maybe_install_pages(): void {
		if ( '1' === get_option( 'metadoc_re_pages_v1' ) ) {
			return;
		}
		self::install_pages();
		update_option( 'metadoc_re_pages_v1', '1' );
	}
}

Metadoc_RealEstate::init();

/* -------------------------------------------------------------------------
 * פונקציות עזר לתצוגה (משמשות את קבצי ה-template-parts).
 * ---------------------------------------------------------------------- */

/**
 * מדפיס תמונה לחריץ עיצובי. אם לא הוגדרה תמונה — מציג מציין-מקום
 * שאינו שובר את הפריסה (ללא CLS, ללא תמונה חסרה).
 *
 * @param string $slot        מפתח החריץ (ראו Metadoc_RealEstate::image_slots()).
 * @param string $alt         טקסט חלופי.
 * @param string $placeholder טקסט מציין-המקום.
 * @param array  $args        sizes, dark (מציין-מקום כהה), eager (טעינה מיידית).
 */
function metadoc_re_image( string $slot, string $alt, string $placeholder = '', array $args = array() ): void {
	$slots = Metadoc_RealEstate::image_slots();
	$id    = (int) get_theme_mod( 'metadoc_re_img_' . $slot, 0 );
	$eager = ! empty( $args['eager'] );

	if ( $id > 0 && wp_attachment_is_image( $id ) ) {
		echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- פלט מוכן ומאובטח של הליבה.
			$id,
			'full',
			false,
			array(
				'alt'           => $alt,
				'class'         => '',
				'loading'       => $eager ? 'eager' : 'lazy',
				'decoding'      => 'async',
				'sizes'         => isset( $args['sizes'] ) ? (string) $args['sizes'] : '100vw',
				'fetchpriority' => $eager ? 'high' : 'auto',
			)
		);
		return;
	}

	$file = isset( $slots[ $slot ]['file'] ) ? (string) $slots[ $slot ]['file'] : '';
	if ( '' !== $file && is_readable( METADOC_DIR . '/assets/img/' . $file ) ) {
		printf(
			'<img src="%1$s" alt="%2$s" %3$s decoding="async"%4$s />',
			esc_url( METADOC_URI . '/assets/img/' . $file ),
			esc_attr( $alt ),
			$eager ? 'loading="eager" fetchpriority="high"' : 'loading="lazy"',
			'' === $alt ? ' aria-hidden="true"' : ''
		);
		return;
	}

	printf(
		'<span class="md-re-ph%1$s" aria-hidden="true"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4.5" width="18" height="15" rx="2"></rect><circle cx="8.5" cy="10" r="1.6"></circle><path d="m4 17 5-4.5 4 3.5 3-2.5 4 3.5"></path></svg><span>%2$s</span></span>',
		empty( $args['dark'] ) ? '' : ' md-re-ph--dark',
		esc_html( '' !== $placeholder ? $placeholder : __( 'ממתין לתמונה', 'metadoc' ) )
	);
}

/**
 * כתובת עמוד המחלקה (לקישור החוזר מעמוד הפרויקט).
 *
 * @return string
 */
function metadoc_re_dept_url(): string {
	$url = Metadoc_RealEstate::page_url( Metadoc_RealEstate::TPL_DEPT );
	return '' !== $url ? $url : home_url( '/real-estate/' );
}

/**
 * כתובת עמוד הפרויקט (לקישור מעמוד המחלקה).
 *
 * @return string
 */
function metadoc_re_project_url(): string {
	if ( class_exists( 'Metadoc_Projects' ) ) {
		$projects = Metadoc_Projects::published( 1 );
		if ( ! empty( $projects ) ) {
			return (string) get_permalink( (int) $projects[0] );
		}
	}
	$url = Metadoc_RealEstate::page_url( Metadoc_RealEstate::TPL_PROJECT );
	return '' !== $url ? $url : home_url( '/shaar-hamifratz/' );
}

/**
 * כתובת וואטסאפ עם הודעה פותחת מותאמת.
 *
 * @param string $text ההודעה.
 * @return string
 */
function metadoc_re_whatsapp( string $text ): string {
	$digits = (string) preg_replace( '/\D/', '', metadoc_text( 'phone_tel' ) );
	$intl   = '972' . ltrim( $digits, '0' );
	return 'https://wa.me/' . $intl . '?text=' . rawurlencode( $text );
}
