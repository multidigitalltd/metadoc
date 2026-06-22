<?php
/**
 * תוספות טופס: אישור מדיניות פרטיות (חובה) + ווידג'ט Cloudflare Turnstile.
 * מקבל $args: prefix (לייחוד מזהים).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$prefix     = isset( $args['prefix'] ) ? (string) $args['prefix'] : 'form';
$consent_id = $prefix . '-consent';
$privacy    = metadoc_privacy_url();
?>
<div class="flex items-start gap-2">
	<input type="checkbox" id="<?php echo esc_attr( $consent_id ); ?>" name="consent" value="1" required class="md-consent mt-0.5 size-4 shrink-0 accent-[#ff7a00]">
	<label for="<?php echo esc_attr( $consent_id ); ?>" class="text-[12px] text-white/70 leading-snug">
		<?php esc_html_e( 'קראתי ואני מאשר/ת את', 'metadoc' ); ?>
		<a href="<?php echo esc_url( $privacy ); ?>" target="_blank" rel="noopener noreferrer" class="underline text-[#ff9a3c] hover:text-[#ff7a00]"><?php esc_html_e( 'מדיניות הפרטיות', 'metadoc' ); ?></a>
	</label>
</div>
<?php if ( Metadoc_Settings::turnstile_enabled() ) : ?>
	<div class="cf-turnstile" data-sitekey="<?php echo esc_attr( Metadoc_Settings::get( 'turnstile_site_key' ) ); ?>" data-theme="dark" data-language="he"></div>
<?php endif; ?>
