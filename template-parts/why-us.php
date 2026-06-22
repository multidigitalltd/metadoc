<?php
/**
 * WhyUs — למה דווקא מטאדוק.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$points = array(
	array( 'title' => 'whyus_1_title', 'desc' => 'whyus_1_desc' ),
	array( 'title' => 'whyus_2_title', 'desc' => 'whyus_2_desc' ),
	array( 'title' => 'whyus_3_title', 'desc' => 'whyus_3_desc' ),
	array( 'title' => 'whyus_4_title', 'desc' => 'whyus_4_desc' ),
	array( 'title' => 'whyus_5_title', 'desc' => 'whyus_5_desc' ),
	array( 'title' => 'whyus_6_title', 'desc' => 'whyus_6_desc' ),
);
?>
<section class="bg-white">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
		<div class="max-w-3xl mb-12 md:mb-16">
			<?php
			metadoc_section_label( '04', metadoc_text( 'whyus_eyebrow' ) );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>.',
					esc_html( metadoc_text( 'whyus_title_1' ) ),
					esc_html( metadoc_text( 'whyus_title_2' ) )
				)
			);
			?>
		</div>

		<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-neutral-200 border border-neutral-200 rounded-3xl overflow-hidden">
			<?php foreach ( $points as $i => $p ) : ?>
				<div class="md-card-hover md-reveal group bg-white p-7 md:p-9 hover:bg-neutral-50 hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.35)] flex flex-col" style="animation-delay:<?php echo esc_attr( (string) ( $i * 90 ) ); ?>ms">
					<div class="flex items-baseline gap-3 mb-4">
						<div class="text-3xl md:text-4xl font-black tabular-nums leading-none font-display text-[#ff7a00]"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
						<div class="h-px flex-1 bg-neutral-200 group-hover:bg-[#ff7a00] transition-colors"></div>
					</div>
					<h3 class="font-bold text-2xl md:text-[1.75rem] leading-[1.1] mb-3 text-neutral-900 tracking-tight font-display"><?php metadoc_the_text( $p['title'] ); ?></h3>
					<p class="text-[14px] md:text-[15px] text-neutral-600 leading-relaxed"><?php metadoc_the_text( $p['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
