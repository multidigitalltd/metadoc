<?php
/**
 * Template Name: מחלקת נדל"ן — עמוד מחלקה
 *
 * עמוד מחלקת הנדל"ן וההשקעות של מטאדוק, כולל מועדון המשקיעים.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'realestate' );
?>
<div class="md-re md-re-dept is-strip" data-md-dept>
	<?php get_template_part( 'template-parts/realestate/header' ); ?>
	<main id="main">
		<?php
		get_template_part( 'template-parts/realestate/hero' );
		get_template_part( 'template-parts/realestate/club' );
		get_template_part( 'template-parts/realestate/asset-types' );
		get_template_part( 'template-parts/realestate/about' );
		get_template_part( 'template-parts/realestate/services' );
		get_template_part( 'template-parts/realestate/process' );
		get_template_part( 'template-parts/realestate/projects' );
		get_template_part( 'template-parts/realestate/testimonials' );
		get_template_part( 'template-parts/realestate/band' );
		get_template_part( 'template-parts/realestate/faq' );
		get_template_part( 'template-parts/realestate/contact' );
		?>
	</main>
	<?php get_template_part( 'template-parts/realestate/footer' ); ?>
</div>
<?php
get_template_part( 'template-parts/realestate/strip' );
get_footer( 'realestate' );
