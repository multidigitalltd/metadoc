<?php
/**
 * פונקציות עזר לתצוגה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * מחזיר את היעד לעוגן טופס הלידים.
 * בעמוד הבית — עוגן מקומי (#form). בעמודים אחרים — ניווט לעמוד הבית + עוגן.
 *
 * @return string
 */
function metadoc_form_url(): string {
	return is_front_page() ? '#form' : home_url( '/#form' );
}

/**
 * מחזיר את כתובת עמוד מדיניות הפרטיות.
 * מעדיף את העמוד שהוגדר בהגדרות → פרטיות, אחרת נופל ל-/privacy-policy/.
 *
 * @return string
 */
function metadoc_privacy_url(): string {
	$url = get_privacy_policy_url();
	return $url ? $url : home_url( '/privacy-policy/' );
}

/**
 * מחזיר את כתובת עמוד תקנון האתר.
 * מעדיף את העמוד שנוצר (slug: terms), אחרת נופל ל-/terms/.
 *
 * @return string
 */
function metadoc_terms_url(): string {
	$page = get_page_by_path( 'terms' );
	return $page instanceof WP_Post ? (string) get_permalink( $page ) : home_url( '/terms/' );
}

/**
 * מחזיר URL לנכס מדיה בתבנית, עם העדפת WebP אם קיים.
 *
 * @param string $file שם קובץ יחסי ל-assets/img (למשל 'family-home.jpg').
 * @return string
 */
function metadoc_img_url( string $file ): string {
	$webp = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $file );
	if ( $webp && is_readable( METADOC_DIR . '/assets/img/' . $webp ) ) {
		$file = $webp;
	}
	return METADOC_URI . '/assets/img/' . ltrim( $file, '/' );
}

/**
 * מחזיר URL ללוגו (SVG מועדף, אחרת PNG).
 *
 * @return string
 */
function metadoc_logo_url(): string {
	// 1) לוגו שהועלה דרך התאמה אישית → זהות האתר (העדפה ראשונה).
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$url = wp_get_attachment_image_url( (int) $custom_logo_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	// 2) קובץ לוגו בתיקיית התבנית.
	foreach ( array( 'metadoc-logo.svg', 'metadoc-logo.png' ) as $candidate ) {
		if ( is_readable( METADOC_DIR . '/assets/img/' . $candidate ) ) {
			return METADOC_URI . '/assets/img/' . $candidate;
		}
	}
	// 3) נפילה לקובץ הצפוי גם אם טרם הועלה — יוחלף מיד עם העלאת הלוגו.
	return METADOC_URI . '/assets/img/metadoc-logo.png';
}

/**
 * הדפסת תמונה רספונסיבית עם lazy-load ומידות קבועות (מניעת CLS).
 *
 * @param string $file    שם קובץ ב-assets/img.
 * @param string $alt     טקסט חלופי (ריק = דקורטיבי).
 * @param int    $width   רוחב מקור.
 * @param int    $height  גובה מקור.
 * @param string $class   מחלקות.
 * @param bool   $eager   טעינה מיידית (לתמונת ה-LCP בלבד).
 */
function metadoc_image( string $file, string $alt, int $width, int $height, string $class = '', bool $eager = false ): void {
	printf(
		'<img src="%1$s" alt="%2$s" width="%3$d" height="%4$d" class="%5$s" %6$s decoding="async"%7$s />',
		esc_url( metadoc_img_url( $file ) ),
		esc_attr( $alt ),
		$width,
		$height,
		esc_attr( $class ),
		$eager ? 'loading="eager" fetchpriority="high"' : 'loading="lazy"',
		'' === $alt ? ' aria-hidden="true"' : ''
	);
}

/**
 * הדפסת אווטאר לחבר צוות — תמונה אם הוגדרה, אחרת עיגול עם ראשי תיבות.
 *
 * @param string $photo_url כתובת תמונה (ריק = ללא).
 * @param string $name      שם לחישוב ראשי תיבות + alt.
 */
function metadoc_team_avatar( string $photo_url, string $name ): void {
	if ( '' !== $photo_url ) {
		printf(
			'<img src="%1$s" alt="%2$s" width="320" height="320" class="w-full h-full object-cover" loading="lazy" decoding="async" />',
			esc_url( $photo_url ),
			esc_attr( $name )
		);
		return;
	}
	// נפילה: ראשי תיבות מהמילה/ות הראשונות.
	$parts   = preg_split( '/\s+/', trim( $name ) ) ?: array();
	$initial = '';
	foreach ( array_slice( $parts, 0, 2 ) as $part ) {
		$initial .= function_exists( 'mb_substr' ) ? mb_substr( $part, 0, 1 ) : substr( $part, 0, 1 );
	}
	printf(
		'<span class="w-full h-full grid place-items-center bg-neutral-900 text-white text-4xl font-black font-display" aria-hidden="true">%s</span>',
		esc_html( '' !== $initial ? $initial : '★' )
	);
}

/**
 * תווית סקשן ("01 / נשמע מוכר?").
 *
 * @param string $num     מספר הסקשן.
 * @param string $eyebrow תווית.
 * @param bool   $dark    על רקע כהה.
 */
function metadoc_section_label( string $num, string $eyebrow, bool $dark = false ): void {
	?>
	<div class="flex items-center gap-3 mb-4">
		<span class="text-[11px] font-black tabular-nums tracking-widest font-display text-[#ff7a00]"><?php echo esc_html( $num ); ?> /</span>
		<span class="text-[10px] font-bold tracking-[0.35em] uppercase <?php echo $dark ? 'text-white/60' : 'text-neutral-500'; ?>"><?php echo esc_html( $eyebrow ); ?></span>
	</div>
	<?php
}

/**
 * כותרת סקשן. מקבלת HTML מוכן (כולל <br>/<span>) — לכן עובר wp_kses_post.
 *
 * @param string $html  תוכן הכותרת.
 * @param string $class מחלקות נוספות.
 */
function metadoc_section_heading( string $html, string $class = '' ): void {
	printf(
		'<h2 class="text-[2.2rem] sm:text-4xl md:text-5xl leading-[1.05] font-bold tracking-tight text-neutral-900 font-display %s">%s</h2>',
		esc_attr( $class ),
		wp_kses_post( $html )
	);
}
