<?php
/**
 * Template Name: מחלקת נדל"ן — עמוד פרויקט (שער המפרץ)
 *
 * עמוד פרויקט קרקע: תמצית עסקה, מצב תכנוני, מאפייני בינוי, תרחישי רווח,
 * תיאום פגישה וסרגל לידים קבוע.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'realestate' );
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
get_footer( 'realestate' );
