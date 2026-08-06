<?php
/**
 * לולאת פוסטים משותפת (רשת כרטיסים + פאגינציה) לארכיון/בלוג/חיפוש.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="max-w-7xl mx-auto px-6 md:px-10 py-12 md:py-20">
	<?php if ( have_posts() ) : ?>
		<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/post-card' );
			endwhile;
			?>
		</div>
		<?php
		the_posts_pagination(
			array(
				'mid_size'  => 1,
				'prev_text' => __( 'הקודם', 'metadoc' ),
				'next_text' => __( 'הבא', 'metadoc' ),
				'class'     => 'md-pagination',
			)
		);
		?>
	<?php else : ?>
		<p class="text-center text-neutral-500 text-lg py-16"><?php esc_html_e( 'לא נמצאו תכנים להצגה.', 'metadoc' ); ?></p>
	<?php endif; ?>
</div>
