<?php
/**
 * פופאפ אישור עוגיות (Cookies). מנוהל ב-main.js עם שמירה ב-localStorage.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$privacy = metadoc_privacy_url();
?>
<div id="md-cookie" role="dialog" aria-label="<?php esc_attr_e( 'הודעת שימוש בעוגיות', 'metadoc' ); ?>" aria-live="polite" hidden
	class="fixed inset-x-3 bottom-20 md:bottom-4 md:inset-x-auto md:right-4 md:max-w-md z-[70] bg-neutral-900 text-white rounded-2xl shadow-2xl border border-white/10 p-4 md:p-5">
	<p class="text-[13px] leading-relaxed text-white/85">
		<?php metadoc_the_text( 'cookie_text' ); ?>
		<a href="<?php echo esc_url( $privacy ); ?>" class="underline text-[#ff9a3c] hover:text-[#ff7a00]"><?php metadoc_the_text( 'cookie_more' ); ?></a>
	</p>
	<div class="flex items-center gap-2 mt-3">
		<button type="button" id="md-cookie-accept" class="flex-1 text-black font-black py-2.5 rounded-xl text-[13px]" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%)">
			<?php metadoc_the_text( 'cookie_accept' ); ?>
		</button>
		<button type="button" id="md-cookie-decline" class="px-4 py-2.5 rounded-xl text-[13px] font-bold border border-white/20 text-white/80 hover:bg-white/10">
			<?php metadoc_the_text( 'cookie_decline' ); ?>
		</button>
	</div>
</div>
