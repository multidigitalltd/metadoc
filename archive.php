<?php
/**
 * ארכיון (קטגוריה/תגית/תאריך/מחבר) — רשת כרטיסים מעוצבת.
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
			'eyebrow'  => get_bloginfo( 'name' ),
			'title'    => wp_strip_all_tags( get_the_archive_title() ),
			'subtitle' => wp_strip_all_tags( get_the_archive_description() ),
		)
	);
	get_template_part( 'template-parts/posts-loop' );
	?>
</main>
<?php
get_footer();
