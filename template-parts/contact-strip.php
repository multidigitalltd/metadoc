<?php
/**
 * ContactStrip — רצועת יצירת קשר מהירה (רקע כהה).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$input_cls = 'w-full bg-white border border-white/20 rounded-xl px-4 py-3 focus:outline-none focus:border-[#ff7a00] placeholder:text-neutral-400 text-neutral-900 text-[15px] transition-colors shadow-sm';
?>
<section class="bg-black text-white border-y border-white/10 relative overflow-hidden">
	<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[34rem] h-[34rem] rounded-full blur-[160px] opacity-20 bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-6 md:py-8 relative">
		<h2 class="text-center text-2xl md:text-3xl font-bold mb-5 tracking-tight font-display">
			<?php metadoc_the_text( 'contactstrip_title_1' ); ?> <span class="text-[#ff7a00]"><?php metadoc_the_text( 'contactstrip_title_2' ); ?></span>
		</h2>
		<form class="md-lead-form grid md:grid-cols-12 gap-3 items-end" novalidate>
			<div class="md:col-span-3">
				<label class="sr-only" for="strip-name"><?php esc_html_e( 'שם מלא', 'metadoc' ); ?></label>
				<input id="strip-name" name="name" type="text" required class="<?php echo esc_attr( $input_cls ); ?>" placeholder="<?php esc_attr_e( 'שם מלא', 'metadoc' ); ?>" autocomplete="name">
			</div>
			<div class="md:col-span-3">
				<label class="sr-only" for="strip-phone"><?php esc_html_e( 'טלפון', 'metadoc' ); ?></label>
				<input id="strip-phone" name="phone" type="tel" inputmode="tel" required class="<?php echo esc_attr( $input_cls ); ?>" placeholder="<?php esc_attr_e( 'טלפון', 'metadoc' ); ?>" autocomplete="tel">
			</div>
			<div class="md:col-span-4">
				<label class="sr-only" for="strip-note"><?php esc_html_e( 'פרטים נוספים', 'metadoc' ); ?></label>
				<input id="strip-note" name="note" type="text" class="<?php echo esc_attr( $input_cls ); ?>" placeholder="<?php esc_attr_e( 'פרטים נוספים (לא חובה)', 'metadoc' ); ?>">
			</div>
			<div class="md:col-span-2">
				<button type="submit" class="md-btn w-full text-black font-extrabold py-3 rounded-xl text-[15px] disabled:opacity-60 flex items-center justify-center gap-2" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%)">
					<span class="md-btn-label"><?php esc_html_e( 'שלחו', 'metadoc' ); ?></span>
					<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-4' ) ); ?>
				</button>
			</div>
			<div class="md:col-span-12 flex flex-col items-center gap-2">
				<?php get_template_part( 'template-parts/form-extras', null, array( 'prefix' => 'strip' ) ); ?>
			</div>
			<?php get_template_part( 'template-parts/form-honeypot' ); ?>
			<p class="md-form-status md:col-span-12 text-center text-[13px] font-bold" role="status" aria-live="polite"></p>
		</form>
		<p class="text-[11px] text-white/50 mt-3 text-center flex items-center justify-center gap-1.5">
			<?php metadoc_icon( 'shield-check', array( 'class' => 'size-3' ) ); ?>
			<?php esc_html_e( 'ללא התחייבות · דיסקרטיות מלאה · מענה תוך 24 שעות', 'metadoc' ); ?>
		</p>
	</div>
</section>
