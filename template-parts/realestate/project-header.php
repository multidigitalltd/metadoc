<?php
/**
 * עמוד פרויקט — כותרת עליונה דביקה.
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
	<a class="md-re-btn md-re-btn--grad" href="#interest"><?php esc_html_e( 'לתיאום פגישה ולפרטים נוספים', 'metadoc' ); ?></a>
</header>
