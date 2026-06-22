<?php
/**
 * עמוד הבית — הרכבת עמוד הנחיתה של מטאדוק.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/site-header' );
?>
<main id="main">
	<?php
	$sections = array(
		'hero',
		'trust-bar',
		'identify',
		'solution',
		'who-is-it-for',
		'contact-strip',
		'why-us',
		'process',
		'testimonials',
		'success',
		'lead-form',
		'bottom-cta',
	);
	foreach ( $sections as $section ) {
		get_template_part( 'template-parts/' . $section );
	}
	?>
</main>
<?php
get_template_part( 'template-parts/site-footer' );
get_template_part( 'template-parts/floating' );
get_template_part( 'template-parts/accessibility-widget' );
get_footer();
