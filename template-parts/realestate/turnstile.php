<?php
/**
 * ווידג'ט Cloudflare Turnstile לטפסי מחלקת הנדל"ן.
 * מודפס רק כשהוגדר site key בהגדרות — אחרת הטפסים היו נחסמים בצד הלקוח
 * ובצד השרת בלי אפשרות להשלים את האימות.
 * $args: light (ווידג'ט בהיר, לטפסים על רקע בהיר).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Metadoc_Settings' ) || ! Metadoc_Settings::turnstile_enabled() ) {
	return;
}
?>
<div class="cf-turnstile md-re-turnstile"
	data-sitekey="<?php echo esc_attr( Metadoc_Settings::get( 'turnstile_site_key' ) ); ?>"
	data-theme="<?php echo empty( $args['light'] ) ? 'dark' : 'light'; ?>"
	data-language="he"></div>
