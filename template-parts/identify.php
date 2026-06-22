<?php
/**
 * Identify — זיהוי כאב הלקוח ("נשמע מוכר?").
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = array( 'identify_item_1', 'identify_item_2', 'identify_item_3', 'identify_item_4', 'identify_item_5', 'identify_item_6' );
?>
<section class="bg-neutral-50 relative">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid md:grid-cols-12 gap-10 items-start">
		<div class="md:col-span-5 md:sticky md:top-24">
			<?php
			metadoc_section_label( '01', metadoc_text( 'identify_eyebrow' ) );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>.',
					esc_html( metadoc_text( 'identify_title_1' ) ),
					esc_html( metadoc_text( 'identify_title_2' ) )
				)
			);
			?>
			<p class="text-neutral-600 leading-relaxed text-[15px] md:text-base max-w-[42ch] mt-5"><?php metadoc_the_text( 'identify_p1' ); ?></p>
			<p class="text-neutral-600 leading-relaxed text-[15px] md:text-base max-w-[42ch] mt-3 font-semibold"><?php metadoc_the_text( 'identify_p2' ); ?></p>
		</div>

		<ul class="md:col-span-7 grid sm:grid-cols-2 gap-3">
			<?php foreach ( $items as $i => $key ) : ?>
				<li class="group flex gap-4 items-start bg-white hover:border-neutral-900 border border-neutral-200 rounded-2xl px-5 py-4 transition-all hover:shadow-md">
					<span class="text-sm font-black tabular-nums text-neutral-300 group-hover:text-[#ff7a00] transition w-6 mt-0.5 font-display"><?php echo esc_html( '0' . ( $i + 1 ) ); ?></span>
					<span class="text-[15px] text-neutral-800 leading-snug font-medium flex-1"><?php metadoc_the_text( $key ); ?></span>
					<?php metadoc_icon( 'check', array( 'class' => 'size-5 mt-0.5 shrink-0 text-[#ff7a00]' ) ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
