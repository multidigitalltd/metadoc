<?php
/**
 * תבנית ברירת מחדל (fallback). עמוד הבית הוא front-page.php;
 * רשימות פוסטים מטופלות ב-home.php/archive.php.
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
			'eyebrow' => get_bloginfo( 'name' ),
			'title'   => __( 'כתבות', 'metadoc' ),
		)
	);
	get_template_part( 'template-parts/posts-loop' );
	?>
</main>
<?php
get_footer();
