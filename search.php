<?php
/**
 * תוצאות חיפוש.
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
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'eyebrow'  => __( 'חיפוש באתר', 'metadoc' ),
			'title'    => __( 'תוצאות חיפוש', 'metadoc' ),
			/* translators: %s: search query. */
			'subtitle' => sprintf( __( 'עבור: %s', 'metadoc' ), get_search_query() ),
		)
	);
	get_template_part( 'template-parts/posts-loop' );
	?>
</main>
<?php
get_footer();
