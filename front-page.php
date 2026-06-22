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
get_footer();
