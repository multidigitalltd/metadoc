<?php
/**
 * תוכן עמוד הנחיתה — משותף ל-front-page.php ולתבנית העמוד (template-landing.php).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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
