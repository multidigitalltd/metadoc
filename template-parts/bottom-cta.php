<?php
/**
 * BottomCTA — קריאה לפעולה אחרונה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();
?>
<section class="bg-black text-white relative overflow-hidden">
	<div class="absolute inset-0 opacity-[0.05]" aria-hidden="true" style="background-image:linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px);background-size:44px 44px"></div>
	<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] rounded-full blur-[160px] opacity-20 bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="max-w-4xl mx-auto px-6 md:px-10 py-16 md:py-24 text-center relative">
		<div class="inline-flex items-center gap-2 mb-6">
			<span class="h-px w-8 bg-white/30"></span>
			<span class="text-[10px] font-bold tracking-[0.35em] uppercase text-[#ff9a3c]"><?php metadoc_the_text( 'bottomcta_eyebrow' ); ?></span>
			<span class="h-px w-8 bg-white/30"></span>
		</div>
		<h2 class="text-[2.2rem] sm:text-4xl md:text-5xl leading-[1.05] font-bold mb-5 tracking-tight font-display">
			<?php metadoc_the_text( 'bottomcta_title_1' ); ?><br>
			<span class="text-[#ff7a00]"><?php metadoc_the_text( 'bottomcta_title_2' ); ?></span>
		</h2>
		<p class="text-white/70 mb-9 text-[15px] md:text-base max-w-xl mx-auto"><?php metadoc_the_text( 'bottomcta_p' ); ?></p>
		<div class="flex flex-col sm:flex-row gap-3 justify-center">
			<a href="#form" class="md-btn text-black px-8 py-4 rounded-xl text-lg font-black flex items-center justify-center gap-2" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%);box-shadow:0 18px 40px -12px #ff7a00cc">
				<?php metadoc_the_text( 'bottomcta_btn' ); ?>
				<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-5' ) ); ?>
			</a>
			<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>" class="md-btn-ghost text-white px-8 py-4 rounded-xl text-lg font-bold border border-white/20 hover:bg-white/10 hover:border-white/50 flex items-center justify-center gap-2">
				<?php metadoc_icon( 'phone', array( 'class' => 'size-4' ) ); ?>
				<?php echo esc_html( $c['phone_display'] ); ?>
			</a>
		</div>
	</div>
</section>
