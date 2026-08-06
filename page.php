<?php
/**
 * תבנית עמוד רגיל (אודות, הצהרת נגישות, מדיניות פרטיות וכו').
 * כל עמוד מקבל אוטומטית את עיצוב המותג: כותרת + תוכן מעוצב.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'eyebrow' => get_bloginfo( 'name' ),
				'title'   => get_the_title(),
			)
		);
		?>
		<article <?php post_class( 'bg-white' ); ?>>
			<div class="max-w-3xl mx-auto px-6 md:px-10 py-12 md:py-20">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="mb-8 rounded-2xl overflow-hidden">
						<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto', 'loading' => 'lazy' ) ); ?>
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
				?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
