<?php
/**
 * מחלקת נדל"ן — השירותים (פסיפס 3x2 בקווי שיער).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$svg = 'width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';

$services = array(
	array(
		'icon'  => '<path d="M3 20h8V9.5L7 6.5 3 9.5V20z"></path><path d="M6 20v-4h2v4"></path><circle cx="16" cy="10" r="4.2"></circle><path d="M19.2 13.2 22 16"></path>',
		'title' => __( 'איתור עסקאות והזדמנויות', 'metadoc' ),
		'text'  => __( 'איתור נכסים והזדמנויות נדל"ן בהתאם לאפיון ההשקעה שלכם, בסיוע עשרות משרדי תיווך, כונסי נכסים ומנהלי עיזבונות.', 'metadoc' ),
	),
	array(
		'icon'  => '<path d="M3 20h18"></path><path d="M6 20v-6"></path><path d="M11 20V9"></path><path d="M16 20v-9"></path><path d="M21 20V5"></path><path d="M5 10.5 10 6l4 2.5 6-5"></path>',
		'title' => __( 'בדיקת כדאיות כלכלית', 'metadoc' ),
		'text'  => __( 'בדיקה מקיפה ומקצועית של כל עסקה ובחינת הכדאיות הכלכלית שלה — לפני שאתם מתחייבים.', 'metadoc' ),
	),
	array(
		'icon'  => '<path d="M12 4v16"></path><path d="M5 7h14"></path><path d="M8.5 5.5 12 4l3.5 1.5"></path><path d="M5 7l-2 5h4l-2-5z"></path><path d="M19 7l-2 5h4l-2-5z"></path><path d="M8 20h8"></path>',
		'title' => __( 'בדיקות משפטיות ושמאות', 'metadoc' ),
		'text'  => __( 'ביצוע כל הבדיקות המשפטיות הנחוצות, לרבות בדיקות שמאות, כדי שתיכנסו לעסקה בעיניים פקוחות.', 'metadoc' ),
	),
	array(
		'icon'  => '<rect x="4" y="3.5" width="16" height="17" rx="2"></rect><path d="M7 8.5h6"></path><path d="M7 15.5h6"></path><path d="M14.5 8.5H17"></path><path d="M15 6.5l2 2-2 2"></path><path d="M9.5 13.5l-2 2 2 2"></path>',
		'title' => __( 'ניהול משא ומתן', 'metadoc' ),
		'text'  => __( 'ניהול המשא ומתן בשמכם ובהתאם לדרישותיכם, להשגת תנאי העסקה האופטימליים — עד הסגירה.', 'metadoc' ),
	),
	array(
		'icon'  => '<path d="M2.5 9 9 5l6.5 4"></path><path d="M3.5 19.5h11"></path><path d="M5 19.5v-7"></path><path d="M9 19.5v-7"></path><path d="M13 19.5v-7"></path><circle cx="18" cy="16" r="4"></circle><path d="M16.6 17.4l2.8-2.8"></path>',
		'title' => __( 'מימון ואשראי', 'metadoc' ),
		'text'  => __( 'בחינת אפשרויות מימון בנקאי וחוץ־בנקאי, ייעוץ משכנתאות וליווי מול הגופים המובילים בארץ.', 'metadoc' ),
	),
	array(
		'icon'  => '<path d="M3.5 11.5 10 6.5l6.5 5"></path><path d="M5.5 13v7h9v-7"></path><path d="M8.5 20v-4h3v4"></path><path d="M19 4.5v7"></path><path d="M16.5 7l2.5-2.5L21.5 7"></path>',
		'title' => __( 'השבחה וניהול שוטף', 'metadoc' ),
		'text'  => __( 'שיפוץ והשבחת הנכס על פי הצורך, וטיפול שוטף בנכס גם לאחר ביצוע העסקה.', 'metadoc' ),
	),
);
?>
<section id="services" class="md-re-services">
	<div class="md-re-in">
		<p class="md-re-eyebrow"><?php esc_html_e( '02 / השירותים שלנו', 'metadoc' ); ?></p>
		<h2 class="md-re-h2"><?php esc_html_e( 'מעטפת מלאה למשקיע —', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'במקום אחד.', 'metadoc' ); ?></span></h2>
		<p class="md-re-lead"><?php esc_html_e( 'כל מה שנדרש כדי להפוך הזדמנות לעסקה סגורה, ולנכס שמייצר ערך לאורך זמן.', 'metadoc' ); ?></p>
		<div class="md-re-svc-grid" data-reveal>
			<?php foreach ( $services as $service ) : ?>
				<article class="md-re-svc">
					<div class="md-re-svc-top">
						<span class="md-re-svc-ico"><svg <?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- מחרוזת מאפיינים קבועה. ?>><?php echo $service['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG קבוע בקוד. ?></svg></span>
						<span class="md-re-svc-rule" aria-hidden="true"></span>
					</div>
					<h3><?php echo esc_html( $service['title'] ); ?></h3>
					<p><?php echo esc_html( $service['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
