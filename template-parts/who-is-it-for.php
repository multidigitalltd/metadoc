<?php
/**
 * WhoIsItFor — קהלי יעד.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$audiences = array(
	array( 'icon' => 'home', 'title' => 'audience_1_title', 'desc' => 'audience_1_desc' ),
	array( 'icon' => 'building-2', 'title' => 'audience_2_title', 'desc' => 'audience_2_desc' ),
	array( 'icon' => 'landmark', 'title' => 'audience_3_title', 'desc' => 'audience_3_desc' ),
	array( 'icon' => 'briefcase', 'title' => 'audience_4_title', 'desc' => 'audience_4_desc' ),
	array( 'icon' => 'trending-down', 'title' => 'audience_5_title', 'desc' => 'audience_5_desc' ),
	array( 'icon' => 'wallet', 'title' => 'audience_6_title', 'desc' => 'audience_6_desc' ),
);
?>
<section class="bg-white relative overflow-hidden">
	<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[36rem] h-[36rem] rounded-full blur-[160px] opacity-[0.06] bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 relative">
		<div class="max-w-3xl mb-12 md:mb-16">
			<?php
			metadoc_section_label( '03', metadoc_text( 'whoisfor_eyebrow' ) );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>',
					esc_html( metadoc_text( 'whoisfor_title_1' ) ),
					esc_html( metadoc_text( 'whoisfor_title_2' ) )
				)
			);
			?>
		</div>

		<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
			<?php foreach ( $audiences as $i => $a ) : ?>
				<div class="md-card-hover md-reveal group bg-neutral-50 border border-neutral-200 rounded-2xl p-6 md:p-7 hover:bg-white hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.2)] hover:border-neutral-300 flex flex-col" style="animation-delay:<?php echo esc_attr( (string) ( $i * 90 ) ); ?>ms">
					<div class="size-12 rounded-xl grid place-items-center mb-4 border" style="background:rgba(255,122,0,0.08);border-color:rgba(255,122,0,0.25)">
						<?php metadoc_icon( $a['icon'], array( 'class' => 'size-6 text-[#ff7a00]', 'stroke' => 1.6 ) ); ?>
					</div>
					<h3 class="font-bold text-xl md:text-2xl leading-[1.1] mb-2 text-neutral-900 tracking-tight font-display"><?php metadoc_the_text( $a['title'] ); ?></h3>
					<p class="text-[14px] md:text-[15px] text-neutral-600 leading-relaxed"><?php metadoc_the_text( $a['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
