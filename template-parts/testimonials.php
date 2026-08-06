<?php
/**
 * Testimonials — המלצות לקוחות.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = array(
	array( 'name' => 'testi_1_name', 'city' => 'testi_1_city', 'quote' => 'testi_1_quote' ),
	array( 'name' => 'testi_2_name', 'city' => 'testi_2_city', 'quote' => 'testi_2_quote' ),
	array( 'name' => 'testi_3_name', 'city' => 'testi_3_city', 'quote' => 'testi_3_quote' ),
);
?>
<section class="bg-neutral-50 border-y border-neutral-200">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
		<?php
		metadoc_section_label( '05', metadoc_text( 'testi_eyebrow' ) );
		metadoc_section_heading(
			sprintf(
				'%s <span class="text-[#ff7a00]">%s</span>.',
				esc_html( metadoc_text( 'testi_title_1' ) ),
				esc_html( metadoc_text( 'testi_title_2' ) )
			)
		);
		?>

		<div class="grid md:grid-cols-3 gap-5 mt-12">
			<?php foreach ( $items as $item ) : ?>
				<?php $name = metadoc_text( $item['name'] ); ?>
				<figure class="bg-white border border-neutral-200 rounded-2xl p-6 md:p-7 flex flex-col hover:shadow-lg transition-shadow">
					<div class="flex items-center gap-1 mb-4 text-[#ff7a00]" role="img" aria-label="<?php esc_attr_e( 'דירוג 5 מתוך 5 כוכבים', 'metadoc' ); ?>">
						<?php for ( $i = 0; $i < 5; $i++ ) : ?>
							<?php metadoc_icon( 'star', array( 'class' => 'size-4 fill-current' ) ); ?>
						<?php endfor; ?>
					</div>
					<blockquote class="text-[15px] md:text-base text-neutral-800 leading-relaxed mb-6 flex-1 font-body">"<?php metadoc_the_text( $item['quote'] ); ?>"</blockquote>
					<figcaption class="flex items-center gap-3 pt-4 border-t border-neutral-100">
						<div class="size-10 rounded-full grid place-items-center text-sm font-black text-black shrink-0 bg-[#ff7a00]" aria-hidden="true"><?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?></div>
						<div class="leading-tight">
							<div class="text-sm font-bold text-neutral-900"><?php echo esc_html( $name ); ?></div>
							<div class="text-[11px] text-neutral-500 mt-0.5"><?php metadoc_the_text( $item['city'] ); ?></div>
						</div>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
