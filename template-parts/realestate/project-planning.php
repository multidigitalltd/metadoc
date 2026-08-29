<?php
/**
 * עמוד פרויקט — 02 / המצב התכנוני (כרטיסי נתונים + יתרון החלקה).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$svg = 'width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';

$facts = array(
	array(
		'icon' => '<path d="M4 6.5 9.5 4l5 2.5L20 4v13.5L14.5 20l-5-2.5L4 20V6.5z"></path><path d="M9.5 4v13.5"></path><path d="M14.5 6.5V20"></path>',
		'num'  => '12,400',
		'lbl'  => __( 'דונם — שטח התכנית', 'metadoc' ),
	),
	array(
		'icon' => '<path d="M3 21h18"></path><path d="M5 21V9l5-3.5V21"></path><path d="M10 21V11l5 3v7"></path><path d="M15 21v-9l4 2.5V21"></path><path d="M7.5 12h1"></path><path d="M7.5 16h1"></path>',
		'num'  => '70,000',
		'lbl'  => __( 'יח"ד מגורים', 'metadoc' ),
	),
	array(
		'icon' => '<path d="M3 20.5h18"></path><path d="M4.5 20.5V9.5h7v11"></path><path d="M11.5 20.5V13H20v7.5"></path><path d="M6.5 12.5h3"></path><path d="M6.5 16.5h3"></path><path d="M14 16h3.5"></path>',
		'num'  => '1,800,000',
		'lbl'  => __( 'מ"ר תעסוקה ומסחר', 'metadoc' ),
	),
	array(
		'icon' => '<path d="M12 20.5v-6"></path><path d="M12 14.5c-3.6 0-6.5-2.7-6.5-6 0-1.5.5-2.9 1.4-4 .6 2.2 2.6 3.4 5.1 3.4s4.5-1.2 5.1-3.4c.9 1.1 1.4 2.5 1.4 4 0 3.3-2.9 6-6.5 6z"></path><path d="M7.5 20.5h9"></path>',
		'num'  => '1,400',
		'lbl'  => __( 'דונם שטחים פתוחים', 'metadoc' ),
	),
	array(
		'icon' => '<path d="M3 20.5h18"></path><path d="M5 20.5V7.5h14v13"></path><path d="M8.5 11h3"></path><path d="M15 11h1.5"></path><path d="M8.5 15h3"></path><path d="M15 15h1.5"></path><path d="M9 7.5V4.5h6v3"></path>',
		'num'  => '1,000',
		'lbl'  => __( 'חדרי מלונאות', 'metadoc' ),
	),
	array(
		'icon' => '<path d="M4 20V8l8-4 8 4v12"></path><path d="M4 20h16"></path><path d="M9.5 20v-5h5v5"></path><circle cx="12" cy="10" r="1.6"></circle>',
		'num'  => '46,000',
		'lbl'  => __( 'יח"ד במתחם 2.4 — שלנו', 'metadoc' ),
	),
);
?>
<section class="md-pr-sec md-pr-sec--warm">
	<div class="md-re-in">
		<div class="md-pr-sec-head" data-rv>
			<div>
				<p class="md-re-eyebrow"><?php esc_html_e( '02 / המצב התכנוני', 'metadoc' ); ?></p>
				<h2 class="md-pr-h2"><?php esc_html_e( 'תמ"א 75 "שער המפרץ"', 'metadoc' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'תכנית מסגרת ארצית שמייצרת מרקם עירוני חדש בין חיפה, נשר וקריית אתא.', 'metadoc' ); ?></p>
		</div>
		<div class="md-pr-facts" data-rv>
			<?php foreach ( $facts as $fact ) : ?>
				<div class="md-pr-fact">
					<span class="md-pr-fact-ico"><svg <?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- מחרוזת מאפיינים קבועה. ?>><?php echo $fact['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG קבוע בקוד. ?></svg></span>
					<b><?php echo esc_html( $fact['num'] ); ?></b>
					<span><?php echo esc_html( $fact['lbl'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="md-pr-edge" data-rv>
			<p class="md-pr-edge-k"><?php esc_html_e( 'היתרון של החלקה שלנו', 'metadoc' ); ?></p>
			<h3><?php esc_html_e( 'צמודת דופן לבנייה הקיימת — ולכן הבנייה במתחם צפויה להתחיל דווקא כאן.', 'metadoc' ); ?></h3>
			<p><?php esc_html_e( 'מתחם 2.4 משתרע על 5,200 דונם וכולל כ-46,000 יח"ד מתוכננות. הפיתוח במתחמים כאלה מתקדם מהרקמה הבנויה החוצה, כשהתשתיות כבר קיימות בקצה — והחלקה שלנו יושבת בדיוק על הקו הזה.', 'metadoc' ); ?></p>
		</div>
	</div>
</section>
