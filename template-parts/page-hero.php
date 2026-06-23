<?php
/**
 * באנר כותרת לעמודים פנימיים (אודות, כתבות, פוסט, ארכיון).
 * $args: title, eyebrow (אופציונלי), subtitle (אופציונלי).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$mh_title    = isset( $args['title'] ) ? (string) $args['title'] : '';
$mh_eyebrow  = isset( $args['eyebrow'] ) ? (string) $args['eyebrow'] : '';
$mh_subtitle = isset( $args['subtitle'] ) ? (string) $args['subtitle'] : '';
?>
<section class="relative overflow-hidden bg-black text-white">
	<div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image:linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px);background-size:44px 44px" aria-hidden="true"></div>
	<div class="absolute -left-32 -top-20 w-[26rem] h-[26rem] rounded-full blur-[140px] opacity-20 bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="max-w-4xl mx-auto px-6 md:px-10 pt-14 md:pt-20 pb-12 md:pb-16 relative text-center">
		<?php if ( '' !== $mh_eyebrow ) : ?>
			<div class="inline-flex items-center gap-2 mb-5">
				<span class="h-px w-8 bg-white/30"></span>
				<span class="text-[11px] font-bold tracking-[0.3em] uppercase text-[#ff9a3c]"><?php echo esc_html( $mh_eyebrow ); ?></span>
				<span class="h-px w-8 bg-white/30"></span>
			</div>
		<?php endif; ?>
		<h1 class="text-[2.4rem] sm:text-5xl md:text-6xl leading-[1.05] font-bold tracking-tight font-display"><?php echo wp_kses_post( $mh_title ); ?></h1>
		<?php if ( '' !== $mh_subtitle ) : ?>
			<p class="text-white/70 text-[15px] md:text-lg mt-5 max-w-2xl mx-auto leading-relaxed"><?php echo esc_html( $mh_subtitle ); ?></p>
		<?php endif; ?>
	</div>
</section>
