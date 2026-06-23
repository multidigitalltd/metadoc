<?php
/**
 * Template Name: כתבות בתקשורת
 *
 * תבנית עמוד שמציגה את כל ה"כתבות בתקשורת" (קישורים חיצוניים) כרשת כרטיסים.
 * שבצו אותה על עמוד (למשל /press/) דרך מאפייני עמוד → תבנית.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

the_post();
$page_content = trim( get_the_content() );

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$press = new WP_Query(
	array(
		'post_type'      => Metadoc_Press::CPT,
		'posts_per_page' => 12,
		'paged'          => $paged,
		'no_found_rows'  => false,
	)
);
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'eyebrow'  => get_bloginfo( 'name' ),
			'title'    => get_the_title(),
			'subtitle' => __( 'מה כותבים עלינו בתקשורת', 'metadoc' ),
		)
	);
	?>
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-12 md:py-20">
		<?php if ( '' !== $page_content ) : ?>
			<div class="md-prose max-w-3xl mx-auto mb-12"><?php the_content(); ?></div>
		<?php endif; ?>

		<?php if ( $press->have_posts() ) : ?>
			<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php
				while ( $press->have_posts() ) :
					$press->the_post();
					get_template_part( 'template-parts/press-card' );
				endwhile;
				?>
			</div>
			<?php
			$links = paginate_links(
				array(
					'base'      => trailingslashit( get_permalink() ) . 'page/%#%/',
					'format'    => '',
					'current'   => $paged,
					'total'     => (int) $press->max_num_pages,
					'mid_size'  => 1,
					'prev_text' => __( 'הקודם', 'metadoc' ),
					'next_text' => __( 'הבא', 'metadoc' ),
				)
			);
			if ( $links ) {
				echo '<div class="md-pagination">' . wp_kses_post( $links ) . '</div>';
			}
			wp_reset_postdata();
			?>
		<?php else : ?>
			<p class="text-center text-neutral-500 text-lg py-16"><?php esc_html_e( 'עדיין אין כתבות להצגה.', 'metadoc' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
