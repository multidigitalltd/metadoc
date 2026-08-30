<?php
/**
 * עמוד פרויקט בודד — אותה תבנית של "שער המפרץ", מוזנת מרשומת הפרויקט.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'realestate' );

while ( have_posts() ) :
	the_post();
	?>
	<div class="md-re md-pr" data-md-project>
		<?php get_template_part( 'template-parts/realestate/project-header' ); ?>
		<main id="main">
			<?php
			get_template_part( 'template-parts/realestate/project-hero' );
			get_template_part( 'template-parts/realestate/project-deal' );
			get_template_part( 'template-parts/realestate/project-planning' );
			get_template_part( 'template-parts/realestate/project-building' );
			get_template_part( 'template-parts/realestate/project-scenarios' );
			get_template_part( 'template-parts/realestate/project-cta' );
			?>
		</main>
		<?php get_template_part( 'template-parts/realestate/project-footer' ); ?>
	</div>
	<?php
	get_template_part( 'template-parts/realestate/project-fab' );
endwhile;

get_footer( 'realestate' );
