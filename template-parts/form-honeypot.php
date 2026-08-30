<?php
/**
 * Honeypot — שדה מלכודת לבוטים (חייב להישאר ריק).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="md-hp" aria-hidden="true" style="position:absolute;width:1px;height:1px;margin:-1px;padding:0;border:0;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap">
	<label><?php esc_html_e( 'אל תמלאו שדה זה', 'metadoc' ); ?>
		<input type="text" name="website" tabindex="-1" autocomplete="off" value="">
	</label>
</div>
