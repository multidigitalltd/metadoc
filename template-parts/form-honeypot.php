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
<div class="md-hp" aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden">
	<label><?php esc_html_e( 'אל תמלאו שדה זה', 'metadoc' ); ?>
		<input type="text" name="website" tabindex="-1" autocomplete="off" value="">
	</label>
</div>
