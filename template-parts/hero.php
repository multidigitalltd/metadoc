<?php
/**
 * Hero — כותרת ראשית, CTA ותמונת סירוב.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();
?>
<section class="relative overflow-hidden bg-black text-white">
	<div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image:linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px);background-size:44px 44px" aria-hidden="true"></div>
	<div class="absolute -left-32 top-10 w-[26rem] h-[26rem] rounded-full blur-[140px] opacity-25 bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="absolute -right-40 bottom-0 w-[22rem] h-[22rem] rounded-full blur-[120px] opacity-10 bg-[#3b82f6]" aria-hidden="true"></div>

	<div class="absolute -right-10 top-1/2 -translate-y-1/2 opacity-[0.07] pointer-events-none select-none" aria-hidden="true">
		<img src="<?php echo esc_url( metadoc_logo_url() ); ?>" alt="" width="600" height="220" class="w-[28rem] md:w-[36rem] lg:w-[44rem] h-auto object-contain" style="filter:drop-shadow(0 0 40px #ff7a00cc) drop-shadow(0 0 80px #ff7a0099)" loading="lazy" decoding="async">
	</div>

	<div class="relative z-10 max-w-7xl mx-auto px-6 md:px-10 pt-12 md:pt-20 pb-14 md:pb-24 grid md:grid-cols-12 gap-10 items-center">
		<div class="md:col-span-7">
			<div class="flex items-center gap-3 mb-6">
				<span class="h-px w-10 bg-[#ff7a00]"></span>
				<span class="text-[11px] md:text-[13px] font-bold tracking-[0.25em] text-[#ff9a3c]"><?php metadoc_the_text( 'hero_eyebrow' ); ?></span>
			</div>

			<h1 class="md-reveal text-[2.6rem] sm:text-[3.2rem] md:text-[4.2rem] lg:text-[4.8rem] leading-[1] font-bold mb-6 tracking-tight text-balance font-display" style="animation-delay:60ms">
				<?php metadoc_the_text( 'hero_title_1' ); ?>
				<br>
				<span class="text-[#ff7a00]"><?php metadoc_the_text( 'hero_title_2' ); ?></span>
			</h1>

			<div class="md-reveal text-[16px] md:text-[18px] text-white/75 mb-7 leading-relaxed max-w-[54ch] text-balance" style="animation-delay:180ms">
				<p><?php metadoc_the_text( 'hero_subtitle' ); ?></p>
			</div>

			<div class="md-reveal flex flex-col sm:flex-row gap-3 mb-8" style="animation-delay:300ms">
				<a href="#form" class="md-btn group text-black text-center px-7 py-4 rounded-xl text-base md:text-lg font-black flex items-center justify-center gap-2" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%);box-shadow:0 18px 40px -12px #ff7a00cc">
					<?php metadoc_the_text( 'hero_cta' ); ?>
					<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-5 group-hover:-translate-x-1 transition-transform' ) ); ?>
				</a>
				<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>" class="md-btn-ghost text-white text-center px-7 py-4 rounded-xl text-base md:text-lg font-bold border border-white/20 hover:bg-white/10 hover:border-white/50 flex items-center justify-center gap-2">
					<?php metadoc_icon( 'phone', array( 'class' => 'size-4' ) ); ?>
					<?php echo esc_html( $c['phone_display'] ); ?>
				</a>
			</div>

			<div class="md-reveal flex items-center gap-4 text-[12px] text-white/60" style="animation-delay:420ms">
				<span class="flex items-center gap-1.5">
					<?php metadoc_icon( 'shield-check', array( 'class' => 'size-4 text-[#ff9a3c]' ) ); ?>
					<?php metadoc_the_text( 'hero_badge_1' ); ?>
				</span>
				<span class="w-1 h-1 rounded-full bg-white/20"></span>
				<span><?php metadoc_the_text( 'hero_badge_2' ); ?></span>
				<span class="w-1 h-1 rounded-full bg-white/20"></span>
				<span><?php metadoc_the_text( 'hero_badge_3' ); ?></span>
			</div>
		</div>

		<div class="md:col-span-5 md-reveal-right" style="animation-delay:240ms">
			<figure class="relative rounded-3xl overflow-hidden border border-white/10 shadow-[0_40px_80px_-20px_rgba(0,0,0,0.6)] group md-img-hover">
				<?php metadoc_image( 'rejection.jpg', __( 'לקוח שמקבל מכתב סירוב מהבנק', 'metadoc' ), 1024, 1024, 'w-full h-[320px] md:h-[460px] object-cover', true ); ?>
				<div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
				<figcaption class="absolute inset-x-0 bottom-0 p-5 md:p-6">
					<div class="text-[10px] tracking-[0.3em] uppercase font-bold mb-1.5 text-[#ff9a3c]"><?php metadoc_the_text( 'hero_img_eyebrow' ); ?></div>
					<div class="text-lg md:text-xl font-bold leading-tight font-display"><?php metadoc_the_text( 'hero_img_caption' ); ?></div>
				</figcaption>
				<div class="absolute top-4 right-4 bg-white/95 backdrop-blur rounded-2xl px-4 py-3 text-neutral-900 shadow-xl">
					<div class="text-2xl font-black leading-none font-display"><?php metadoc_the_text( 'hero_stat_num' ); ?></div>
					<div class="text-[10px] font-bold text-neutral-500 tracking-wider uppercase mt-1"><?php metadoc_the_text( 'hero_stat_label' ); ?></div>
				</div>
			</figure>
		</div>
	</div>
</section>
