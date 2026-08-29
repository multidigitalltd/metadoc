<?php
/**
 * מחלקת נדל"ן — מי אנחנו.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section id="about" class="md-re-about">
	<div class="md-re-about-grid" data-reveal>
		<div class="md-re-shot md-re-shot--43">
			<?php
			metadoc_re_image(
				'about',
				__( 'צוות מחלקת הנדל"ן של מטאדוק במשרד', 'metadoc' ),
				__( 'תמונת הצוות / המשרד', 'metadoc' ),
				array( 'sizes' => '(max-width: 980px) 100vw, 520px' )
			);
			?>
		</div>
		<div>
			<p class="md-re-eyebrow"><?php esc_html_e( '01 / מי אנחנו', 'metadoc' ); ?></p>
			<h2><?php esc_html_e( 'המומחים להשקעות', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'נדל"ן.', 'metadoc' ); ?></span></h2>
			<p><?php esc_html_e( 'מטאדוק היא חברה ותיקה עם ניסיון של מעל 15 שנים בתחומי הנדל"ן, המימון והפיננסים. במשך שנים הוצעו שירותינו לקהל משקיעים מצומצם וייחודי — וכעת, עם עליית הביקוש, פתחנו את הדלת לקהל המשקיעים הרחב.', 'metadoc' ); ?></p>
			<p style="margin-bottom:24px"><?php esc_html_e( 'אנו מלווים כל משקיע באופן אישי: משלב איתור ההזדמנות העסקית, לאורך גיבוש העסקה ועד לביצועה בפועל — בסיוע עשרות משרדי תיווך, כונסי נכסים ומנהלי עיזבונות העובדים עמנו בשיתוף פעולה.', 'metadoc' ); ?></p>
			<p class="md-re-quote"><?php esc_html_e( 'המטרה שלנו פשוטה: להפוך את ההשקעה שלכם לעסקה בטוחה, משתלמת ורווחית.', 'metadoc' ); ?></p>
		</div>
	</div>
</section>
