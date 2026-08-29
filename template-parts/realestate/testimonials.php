<?php
/**
 * מחלקת נדל"ן — המלצות משקיעים.
 * תוכן ממלא-מקום עד לקבלת המלצות אמיתיות (פילטר: metadoc_re_testimonials).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * המלצות המשקיעים.
 *
 * @param array $items רשימת המלצות (initial, name, city, quote).
 */
$items = apply_filters(
	'metadoc_re_testimonials',
	array(
		array( 'א', __( 'אבי ר.', 'metadoc' ), __( 'פתח תקווה', 'metadoc' ), __( '"חיפשתי דירה להשקעה חצי שנה לבד. תוך חודשיים הם איתרו נכס, ניהלו את המו"מ וסגרנו במחיר שלא האמנתי שאפשרי."', 'metadoc' ) ),
		array( 'ש', __( 'שרה ק.', 'metadoc' ), __( 'ירושלים', 'metadoc' ), __( '"הליווי הצמוד נתן לי ביטחון בכל שלב. כל הבדיקות נעשו בשבילי, וגם המימון סודר דרכם בתנאים מצוינים."', 'metadoc' ) ),
		array( 'ד', __( 'דניאל מ.', 'metadoc' ), __( 'רמת גן', 'metadoc' ), __( '"השקעה ראשונה שלי בנדל"ן. אפיינו איתי בדיוק מה מתאים לי, והיום הנכס כבר מניב תשואה יפה."', 'metadoc' ) ),
	)
);
?>
<section class="md-re-tst">
	<div class="md-re-in">
		<p class="md-re-eyebrow"><?php esc_html_e( '04 / מה אומרים עלינו', 'metadoc' ); ?></p>
		<h2><?php esc_html_e( 'משקיעים שכבר', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'עשו את זה.', 'metadoc' ); ?></span></h2>
		<div class="md-re-tst-grid" data-reveal>
			<?php foreach ( $items as $item ) : ?>
				<figure class="md-re-tst-card" style="margin:0">
					<div class="md-re-tst-mark" aria-hidden="true">”</div>
					<blockquote><?php echo esc_html( $item[3] ); ?></blockquote>
					<figcaption class="md-re-tst-who">
						<span class="md-re-tst-ini" aria-hidden="true"><?php echo esc_html( $item[0] ); ?></span>
						<span>
							<span class="md-re-tst-name"><?php echo esc_html( $item[1] ); ?></span>
							<span class="md-re-tst-city" style="display:block"><?php echo esc_html( $item[2] ); ?></span>
						</span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
