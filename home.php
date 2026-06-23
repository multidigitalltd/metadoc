<?php
/**
 * עמוד הפוסטים (בלוג/כתבות) — מוצג כשמגדירים "עמוד פוסטים" בהגדרות → קריאה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$posts_page_id = (int) get_option( 'page_for_posts' );
$mh_title      = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'כתבות', 'metadoc' );
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'eyebrow' => get_bloginfo( 'name' ),
			'title'   => $mh_title,
		)
	);
	get_template_part( 'template-parts/posts-loop' );
	?>
</main>
<?php
get_footer();
