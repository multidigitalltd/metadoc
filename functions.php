<?php
/**
 * Metadoc theme bootstrap.
 *
 * פותח לפי תקן Multi Digital: ביצועים, אבטחה, נגישות.
 * טעינות מותנות בלבד, ללא ספריות צד ג', JS וניל.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // לא לאפשר גישה ישירה.
}

define( 'METADOC_VERSION', '1.0.0' );
define( 'METADOC_DIR', get_template_directory() );
define( 'METADOC_URI', get_template_directory_uri() );

require_once METADOC_DIR . '/inc/icons.php';
require_once METADOC_DIR . '/inc/helpers.php';
require_once METADOC_DIR . '/inc/class-metadoc-leads.php';
require_once METADOC_DIR . '/inc/class-metadoc-setup.php';

/**
 * תמיכות תבנית.
 */
function metadoc_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );

	// תמיכת WebP/AVIF להעלאות.
	add_filter(
		'upload_mimes',
		static function ( array $mimes ): array {
			$mimes['webp'] = 'image/webp';
			$mimes['avif'] = 'image/avif';
			return $mimes;
		}
	);

	register_nav_menus( array( 'primary' => __( 'תפריט ראשי', 'metadoc' ) ) );
	load_theme_textdomain( 'metadoc', METADOC_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'metadoc_setup' );

/**
 * מחזיר מחרוזת גרסה מבוססת זמן-שינוי לשבירת מטמון, עם נפילה לגרסת התבנית.
 *
 * @param string $relative_path נתיב יחסי לשורש התבנית.
 * @return string
 */
function metadoc_asset_ver( string $relative_path ): string {
	$file = METADOC_DIR . '/' . ltrim( $relative_path, '/' );
	$mtime = is_readable( $file ) ? filemtime( $file ) : false;
	return $mtime ? (string) $mtime : METADOC_VERSION;
}

/**
 * טעינת CSS/JS לכל עמודי הפרונט.
 * נטענים סטית-וויד כי הניווט, הפוטר וווידג'ט הנגישות מופיעים בכל עמוד.
 * חבילה אחת מוקטנת (CSS ~48KB + JS קטן), בהתאם לתקן הביצועים.
 */
function metadoc_enqueue_assets(): void {
	wp_enqueue_style(
		'metadoc-app',
		METADOC_URI . '/assets/css/app.min.css',
		array(),
		metadoc_asset_ver( 'assets/css/app.min.css' )
	);

	wp_enqueue_script(
		'metadoc-main',
		METADOC_URI . '/assets/js/main.js',
		array(),
		metadoc_asset_ver( 'assets/js/main.js' ),
		true // בתחתית, יקבל defer דרך הפילטר למטה.
	);

	wp_localize_script(
		'metadoc-main',
		'metadocData',
		array(
			'restUrl'  => esc_url_raw( rest_url( 'metadoc/v1/lead' ) ),
			'nonceUrl' => esc_url_raw( rest_url( 'metadoc/v1/nonce' ) ),
			'nonce'    => wp_create_nonce( 'wp_rest' ), // נפילה בלבד; ה-JS שולף nonce טרי.
			'i18n'     => array(
				'invalidName'  => __( 'נא להזין שם מלא', 'metadoc' ),
				'invalidPhone' => __( 'מספר טלפון לא תקין', 'metadoc' ),
				'sending'      => __( 'שולח...', 'metadoc' ),
				'success'      => __( 'הפרטים נשלחו! מומחה יחזור אליכם בהקדם.', 'metadoc' ),
				'error'        => __( 'אירעה שגיאה. נסו שוב או התקשרו אלינו.', 'metadoc' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'metadoc_enqueue_assets' );

/**
 * הוספת defer לסקריפט הראשי (מניעת render-blocking).
 *
 * @param string $tag    תגית הסקריפט.
 * @param string $handle המזהה.
 * @return string
 */
function metadoc_defer_scripts( string $tag, string $handle ): string {
	if ( 'metadoc-main' === $handle && false === strpos( $tag, 'defer' ) ) {
		$tag = str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'metadoc_defer_scripts', 10, 2 );

/**
 * preconnect/preload לפונטים מקומיים — שיפור LCP.
 */
function metadoc_resource_hints(): void {
	if ( ! is_front_page() ) {
		return;
	}
	// פונטים קריטיים ל-LCP: כותרת ה-Hero (Anomalia) וטקסט הגוף (Atlas).
	$fonts = array( 'anomalia-bold', 'atlas-regular', 'atlas-medium' );
	foreach ( $fonts as $font ) {
		// העדפת woff2; נפילה ל-woff. טוענים מראש רק את הקובץ שקיים בפועל.
		foreach ( array( 'woff2', 'woff' ) as $ext ) {
			$path = '/assets/fonts/' . $font . '.' . $ext;
			if ( is_readable( METADOC_DIR . $path ) ) {
				printf(
					'<link rel="preload" href="%s" as="font" type="font/%s" crossorigin>' . "\n",
					esc_url( METADOC_URI . $path ),
					esc_attr( $ext )
				);
				break;
			}
		}
	}
}
add_action( 'wp_head', 'metadoc_resource_hints', 1 );

/**
 * ניקוי head מפלטים מיותרים (ביצועים + צמצום משטח חשיפה).
 */
function metadoc_clean_head(): void {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	// השבתת emojis (בקשת HTTP + JS מיותרים).
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'metadoc_clean_head' );

/**
 * כותרות אבטחה בסיסיות.
 *
 * @param array $headers כותרות קיימות.
 * @return array
 */
function metadoc_security_headers( array $headers ): array {
	$headers['X-Content-Type-Options'] = 'nosniff';
	$headers['Referrer-Policy']        = 'strict-origin-when-cross-origin';
	$headers['X-Frame-Options']        = 'SAMEORIGIN';
	$headers['Permissions-Policy']     = 'geolocation=(), microphone=(), camera=()';
	return $headers;
}
add_filter( 'wp_headers', 'metadoc_security_headers' );

/**
 * פרטי יצירת קשר ותוכן גלובלי — מקור אמת יחיד (DRY).
 *
 * @return array<string,string>
 */
function metadoc_contact(): array {
	return array(
		'phone_tel'     => '0506001032',
		'phone_display' => '050-600-1032',
		'email'         => 'office@metadoc.co.il',
		'address'       => 'הדובדבן 9, קריית אונו',
		'whatsapp'      => 'https://wa.me/972506001032?text=' . rawurlencode( 'שלום, אשמח לבדיקת זכאות למשכנתא' ),
		'hours_week'    => 'א׳–ה׳ · 09:00–18:00',
		'hours_fri'     => 'ו׳ · 09:00–13:00',
	);
}
