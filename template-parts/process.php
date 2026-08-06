<?php
/**
 * Process — איך זה עובד (4 שלבים, רקע כהה).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$steps = array(
	array( 'icon' => 'pen-line', 'title' => 'step_1_title', 'desc' => 'step_1_desc' ),
	array( 'icon' => 'search', 'title' => 'step_2_title', 'desc' => 'step_2_desc' ),
	array( 'icon' => 'lightbulb', 'title' => 'step_3_title', 'desc' => 'step_3_desc' ),
	array( 'icon' => 'heart-handshake', 'title' => 'step_4_title', 'desc' => 'step_4_desc' ),
);
$count = count( $steps );
?>
<section class="relative overflow-hidden text-white" style="background:radial-gradient(1200px 600px at 85% -10%, rgba(255,122,0,0.25), transparent 60%), radial-gradient(900px 500px at 0% 100%, rgba(255,122,0,0.18), transparent 55%), linear-gradient(180deg, #0f0f10 0%, #161618 100%)">
	<div class="absolute inset-0 opacity-[0.07]" aria-hidden="true" style="background-image:linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px);background-size:44px 44px"></div>
	<div class="absolute -top-24 -right-24 w-[28rem] h-[28rem] rounded-full blur-[140px] opacity-30 bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 relative">
		<div class="inline-flex items-center gap-2 mb-5 px-4 py-2 rounded-full border border-white/15 bg-white/5 backdrop-blur">
			<span class="size-1.5 rounded-full bg-[#ff7a00]"></span>
			<span class="text-[11px] md:text-[12px] font-bold tracking-[0.3em] uppercase text-white/80"><?php metadoc_the_text( 'process_eyebrow' ); ?></span>
		</div>
		<h2 class="text-[2.6rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] leading-[0.95] font-bold tracking-tight text-white mb-12 md:mb-16 font-display">
			<?php metadoc_the_text( 'process_title_pre' ); ?>
			<span class="relative inline-block">
				<span class="relative z-10 text-[#ff7a00]"><?php metadoc_the_text( 'process_title_em' ); ?></span>
				<span class="absolute inset-x-0 bottom-1 h-3 md:h-4 bg-white/10 -z-0"></span>
			</span>?
		</h2>

		<div class="grid md:grid-cols-4 gap-5">
			<?php foreach ( $steps as $idx => $s ) : ?>
				<div class="md-card-hover md-reveal-pop relative bg-white/[0.04] backdrop-blur border border-white/10 text-white rounded-2xl p-6 md:p-8 hover:bg-white/[0.07] hover:border-white/20 hover:shadow-[0_30px_60px_-20px_rgba(255,122,0,0.35)]" style="animation-delay:<?php echo esc_attr( (string) ( $idx * 120 ) ); ?>ms">
					<div class="size-14 rounded-2xl grid place-items-center mb-5 border transition-transform duration-500 group-hover:rotate-6" style="background:rgba(255,122,0,0.10);border-color:rgba(255,122,0,0.35);box-shadow:inset 0 0 0 1px rgba(255,255,255,0.04)">
						<?php metadoc_icon( $s['icon'], array( 'class' => 'size-7 text-[#ff7a00]', 'stroke' => 1.6 ) ); ?>
					</div>
					<h3 class="font-bold text-2xl md:text-[1.75rem] leading-[1.1] mb-3 tracking-tight font-display"><?php metadoc_the_text( $s['title'] ); ?></h3>
					<p class="text-white/70 text-[14px] md:text-[15px] leading-relaxed"><?php metadoc_the_text( $s['desc'] ); ?></p>
					<?php if ( $idx < $count - 1 ) : ?>
						<?php metadoc_icon( 'arrow-left', array( 'class' => 'hidden md:block absolute -left-4 top-1/2 -translate-y-1/2 size-5 text-white/30' ) ); ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
