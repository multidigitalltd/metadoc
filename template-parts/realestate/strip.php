<?php
/**
 * מחלקת נדל"ן — רצועת מועדון קבועה בתחתית העמוד.
 * הסגירה נשמרת ב-localStorage ומסירה את רווח התחתית של העמוד.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside class="md-re md-re-strip" data-md-strip aria-label="<?php esc_attr_e( 'הצטרפות למועדון המשקיעים', 'metadoc' ); ?>">
	<div class="md-re-strip-in">
		<div class="md-re-strip-text">
			<span class="md-re-strip-badge">MEMBERS ONLY</span>
			<span class="md-re-strip-msg"><?php esc_html_e( 'הצטרפו למועדון המשקיעים וקבלו הזדמנויות לפני כולם', 'metadoc' ); ?></span>
			<span class="md-re-strip-free"><?php esc_html_e( 'הצטרפות חינם', 'metadoc' ); ?></span>
		</div>
		<div class="md-re-strip-side">
			<a class="md-re-btn md-re-btn--grad" href="#club">
				<span><?php esc_html_e( 'להצטרפות', 'metadoc' ); ?></span>
				<span aria-hidden="true" style="font-size:18px">←</span>
			</a>
			<button type="button" class="md-re-strip-x" data-md-strip-close aria-label="<?php esc_attr_e( 'סגירת רצועת המועדון', 'metadoc' ); ?>">×</button>
		</div>
	</div>
</aside>
