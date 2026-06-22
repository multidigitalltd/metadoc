<?php
/**
 * ווידג'טים צפים — וואטסאפ, בדיקת זכאות, וסרגל תחתון במובייל.
 * מבנה זהה לווידג'ט הנגישות: עוטף fixed + כפתור פנימי בזרימה רגילה,
 * כדי שלא תהיה תלות בסדר שכבות CSS ולא תיווצר גלילה אופקית.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();
?>
<div class="fixed bottom-24 md:bottom-6 left-4 md:left-6 z-[55]">
	<a href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'שלחו וואטסאפ', 'metadoc' ); ?>" class="size-14 rounded-full bg-[#25D366] shadow-[0_8px_24px_rgba(37,211,102,0.4)] grid place-items-center active:scale-90 hover:scale-105 transition">
		<?php metadoc_icon( 'message-circle', array( 'class' => 'size-7 text-white' ) ); ?>
	</a>
</div>

<div class="hidden md:block fixed bottom-44 md:bottom-24 left-4 md:left-6 z-[55]">
	<a href="<?php echo esc_url( metadoc_form_url() ); ?>" aria-label="<?php esc_attr_e( 'בדיקת זכאות חינם', 'metadoc' ); ?>" class="md-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-black font-black text-[13px] md:text-[14px] hover:scale-105 transition font-display" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%);box-shadow:0 12px 28px -8px #ff7a00cc, 0 0 0 3px rgba(255,122,0,0.18)">
		<?php esc_html_e( 'בדיקת זכאות', 'metadoc' ); ?>
		<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-3.5' ) ); ?>
	</a>
</div>

<div class="md:hidden fixed bottom-0 inset-x-0 max-w-full overflow-x-hidden box-border bg-black/95 backdrop-blur-lg border-t border-white/10 p-3 flex gap-3 z-50">
	<a href="<?php echo esc_url( metadoc_form_url() ); ?>" class="flex-1 text-black flex items-center justify-center gap-2 py-3 rounded-xl font-black text-sm" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%);box-shadow:0 8px 20px -8px #ff7a00b3">
		<?php esc_html_e( 'בדיקת זכאות חינם', 'metadoc' ); ?>
		<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-4' ) ); ?>
	</a>
	<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>" aria-label="<?php esc_attr_e( 'חייגו', 'metadoc' ); ?>" class="size-12 bg-white text-black rounded-xl grid place-items-center active:scale-95 transition">
		<?php metadoc_icon( 'phone', array( 'class' => 'size-5' ) ); ?>
	</a>
</div>
