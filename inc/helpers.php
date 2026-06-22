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
	foreach ( array( 'metadoc-logo.svg', 'metadoc-logo.png' ) as $candidate ) {
		if ( is_readable( METADOC_DIR . '/assets/img/' . $candidate ) ) {
			return METADOC_URI . '/assets/img/' . $candidate;
		}
	}
	// נפילה לקובץ הצפוי גם אם טרם הועלה — יוחלף מיד עם העלאת הלוגו.
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
