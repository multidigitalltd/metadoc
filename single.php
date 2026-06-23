<?php
/**
 * פוסט בודד (כתבה) — עיצוב מותג מלא.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$cats    = get_the_category();
	$eyebrow = get_the_date();
	if ( ! empty( $cats ) ) {
		$eyebrow = $cats[0]->name . ' · ' . $eyebrow;
	}
	?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'eyebrow' => $eyebrow,
			'title'   => get_the_title(),
		)
	);
	?>
	<article <?php post_class( 'bg-white' ); ?>>
		<div class="max-w-3xl mx-auto px-6 md:px-10 py-12 md:py-20">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="mb-10 rounded-2xl overflow-hidden -mt-24 md:-mt-32 relative z-10 shadow-[0_30px_70px_-30px_rgba(0,0,0,0.4)]">
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto', 'loading' => 'eager' ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="md-prose">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages(
				array(
					'before' => '<div class="md-pagination">',
					'after'  => '</div>',
				)
			);

			$tags = get_the_tag_list( '', '' );
			if ( $tags ) :
				?>
				<div class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-neutral-200">
					<?php
					foreach ( get_the_tags() as $tag ) :
						printf(
							'<a href="%s" class="text-[12px] font-bold bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-full px-3 py-1.5 transition-colors">#%s</a>',
							esc_url( get_tag_link( $tag->term_id ) ),
							esc_html( $tag->name )
						);
					endforeach;
					?>
				</div>
			<?php endif; ?>

			<nav class="flex flex-wrap justify-between gap-4 mt-10" aria-label="<?php esc_attr_e( 'ניווט בין כתבות', 'metadoc' ); ?>">
				<?php
				$prev = get_previous_post();
				$next = get_next_post();
				if ( $prev ) :
					?>
					<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="inline-flex items-center gap-2 text-[14px] font-extrabold text-neutral-700 hover:text-[#ff7a00] transition-colors">
						<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-4 rotate-180' ) ); ?>
						<?php esc_html_e( 'הכתבה הקודמת', 'metadoc' ); ?>
					</a>
				<?php else : ?>
					<span></span>
				<?php endif; ?>
				<?php if ( $next ) : ?>
					<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="inline-flex items-center gap-2 text-[14px] font-extrabold text-neutral-700 hover:text-[#ff7a00] transition-colors">
						<?php esc_html_e( 'הכתבה הבאה', 'metadoc' ); ?>
						<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-4' ) ); ?>
					</a>
				<?php endif; ?>
			</nav>
		</div>
	</article>
	<?php get_template_part( 'template-parts/lead-form' ); ?>
</main>
	<?php
endwhile;

get_footer();
