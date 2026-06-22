<?php
/**
 * תבנית ברירת מחדל (נדרשת ע"י וורדפרס).
 * האתר הוא עמוד נחיתה יחיד — ראה front-page.php.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="max-w-3xl mx-auto px-6 py-24">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article <?php post_class(); ?>>
				<h1 class="text-3xl font-bold mb-6 font-display"><?php the_title(); ?></h1>
				<div class="prose max-w-none leading-relaxed">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		}
	} else {
		echo '<p>' . esc_html__( 'לא נמצא תוכן.', 'metadoc' ) . '</p>';
	}
	?>
</main>
<?php
get_footer();
