<?php
/**
 * עמוד 404 — לא נמצא.
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
			'eyebrow' => '404',
			'title'   => __( 'הדף לא נמצא', 'metadoc' ),
		)
	);
	?>
	<section class="bg-white">
		<div class="max-w-2xl mx-auto px-6 md:px-10 py-16 md:py-24 text-center">
			<p class="text-neutral-600 text-[15px] md:text-base leading-relaxed mb-8"><?php esc_html_e( 'הדף שחיפשתם אינו קיים או הוסר. אפשר לחזור לדף הבית או ליצור איתנו קשר.', 'metadoc' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="md-btn inline-flex items-center gap-2 text-black px-7 py-3.5 rounded-xl text-base font-black" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%);box-shadow:0 16px 36px -10px #ff7a00b3">
				<?php esc_html_e( 'חזרה לדף הבית', 'metadoc' ); ?>
				<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-4' ) ); ?>
			</a>
		</div>
	</section>
</main>
<?php
get_footer();
