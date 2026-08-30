<?php
/**
 * עמוד פרויקט — כותרת עליונה.
 * דביקה בדסקטופ בלבד; במובייל נגללת עם העמוד (חוסכת גובה מסך).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<header class="md-pr-hdr">
	<a class="md-pr-back" href="<?php echo esc_url( metadoc_re_dept_url() ); ?>">
		<span aria-hidden="true">→</span>
		<span><?php esc_html_e( 'חזרה למחלקת הנדל"ן', 'metadoc' ); ?></span>
	</a>
	<a class="md-re-btn md-re-btn--grad md-pr-hdr-cta" href="#interest">
		<span class="md-pr-cta-full"><?php esc_html_e( 'לתיאום פגישה ולפרטים נוספים', 'metadoc' ); ?></span>
		<span class="md-pr-cta-short"><?php esc_html_e( 'לתיאום פגישה', 'metadoc' ); ?></span>
	</a>
</header>
