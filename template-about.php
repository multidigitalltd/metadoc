<?php
/**
 * Template Name: עמוד אודות
 *
 * עמוד "אודות" מעוצב: סיפור החברה (תוכן העמוד), ציטוט, ערכים והצוות שלנו.
 * כל הטקסטים נערכים ב"התאמה אישית" → תוכן האתר → עמוד אודות.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
the_post();

$about_img = metadoc_text( 'about_image' );
$about_img = '' !== $about_img ? $about_img : metadoc_img_url( 'advisor.jpg' );
$content   = trim( get_the_content() );

$values = array(
	array( 'shield-check', 'about_value_1_title', 'about_value_1_desc' ),
	array( 'heart-handshake', 'about_value_2_title', 'about_value_2_desc' ),
	array( 'award', 'about_value_3_title', 'about_value_3_desc' ),
);

// נתונים צפים על התמונה הראשית (מתוך סרגל האמון — מקור אמת יחיד).
$stats = array(
	array( 'trust_1_num', 'trust_1_text' ),
	array( 'trust_2_num', 'trust_2_text' ),
);
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'eyebrow'  => metadoc_text( 'about_eyebrow' ),
			'title'    => get_the_title(),
			'subtitle' => metadoc_text( 'about_subtitle' ),
		)
	);
	?>

	<!-- 01 · סיפור החברה -->
	<section class="bg-white">
		<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid lg:grid-cols-12 gap-10 lg:gap-16 items-center">
			<div class="lg:col-span-6 order-2 lg:order-1 md-reveal">
				<?php
				metadoc_section_label( '01', metadoc_text( 'about_story_eyebrow' ) );
				metadoc_section_heading( esc_html( metadoc_text( 'about_story_title' ) ), 'mb-6' );
				?>
				<p class="text-lg md:text-xl font-bold text-neutral-900 leading-snug text-balance font-display border-s-2 border-[#ff7a00] ps-5"><?php metadoc_the_text( 'about_lead' ); ?></p>
				<?php if ( '' !== $content ) : ?>
					<div class="md-prose mt-6"><?php the_content(); ?></div>
				<?php endif; ?>
			</div>

			<div class="lg:col-span-6 order-1 lg:order-2 md-reveal-right">
				<figure class="md-img-hover relative rounded-3xl overflow-hidden border border-neutral-200 shadow-[0_40px_80px_-30px_rgba(0,0,0,0.4)]">
					<img src="<?php echo esc_url( $about_img ); ?>" alt="<?php esc_attr_e( 'צוות מטאדוק', 'metadoc' ); ?>" width="1024" height="768" class="w-full h-[320px] md:h-[460px] object-cover" loading="lazy" decoding="async">
					<span class="absolute inset-x-0 bottom-0 h-2/5 bg-gradient-to-t from-black/55 to-transparent" aria-hidden="true"></span>
					<figcaption class="absolute inset-x-4 bottom-4 md:inset-x-5 md:bottom-5 grid grid-cols-2 gap-3">
						<?php foreach ( $stats as $stat ) : ?>
							<div class="bg-white/95 backdrop-blur rounded-2xl px-4 py-3 shadow-xl">
								<div class="text-2xl md:text-3xl font-black leading-none font-display text-[#ff7a00]"><?php metadoc_the_text( $stat[0] ); ?></div>
								<div class="text-[11px] font-bold text-neutral-500 tracking-wider mt-1"><?php metadoc_the_text( $stat[1] ); ?></div>
							</div>
						<?php endforeach; ?>
					</figcaption>
				</figure>
			</div>
		</div>
	</section>

	<!-- ציטוט מודגש -->
	<section class="bg-black text-white relative overflow-hidden">
		<div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image:linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px);background-size:44px 44px" aria-hidden="true"></div>
		<div class="absolute -left-32 top-1/2 -translate-y-1/2 w-[26rem] h-[26rem] rounded-full blur-[140px] opacity-20 bg-[#ff7a00]" aria-hidden="true"></div>
		<div class="relative z-10 max-w-4xl mx-auto px-6 md:px-10 py-16 md:py-24 text-center">
			<?php metadoc_icon( 'quote', array( 'class' => 'size-9 md:size-11 text-[#ff7a00] mx-auto mb-6', 'stroke' => 1.5 ) ); ?>
			<blockquote class="text-2xl md:text-4xl font-bold leading-tight tracking-tight text-balance font-display"><?php metadoc_the_text( 'about_quote' ); ?></blockquote>
			<?php if ( '' !== trim( metadoc_text( 'about_quote_author' ) ) ) : ?>
				<div class="flex items-center justify-center gap-3 mt-8">
					<span class="h-px w-10 bg-white/25"></span>
					<span class="text-[11px] font-bold tracking-[0.3em] uppercase text-white/60"><?php metadoc_the_text( 'about_quote_author' ); ?></span>
					<span class="h-px w-10 bg-white/25"></span>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- 02 · ערכים -->
	<section class="bg-neutral-50">
		<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
			<div class="max-w-3xl mb-12 md:mb-16">
				<?php
				metadoc_section_label( '02', metadoc_text( 'about_values_eyebrow' ) );
				metadoc_section_heading( esc_html( metadoc_text( 'about_values_title' ) ) );
				?>
			</div>
			<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php foreach ( $values as $i => $v ) : ?>
					<div class="md-card-hover md-reveal group flex flex-col bg-white border border-neutral-200 rounded-3xl p-7 md:p-9 hover:border-neutral-300 hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.3)]" style="animation-delay:<?php echo esc_attr( (string) ( $i * 90 ) ); ?>ms">
						<span class="inline-grid place-items-center size-14 rounded-2xl bg-[#ff7a00]/10 text-[#b45309] transition-transform duration-500 group-hover:-rotate-6">
							<?php metadoc_icon( $v[0], array( 'class' => 'size-7', 'stroke' => 1.7 ) ); ?>
						</span>
						<h3 class="text-xl md:text-[1.4rem] font-bold text-neutral-900 leading-tight font-display mt-6"><?php metadoc_the_text( $v[1] ); ?></h3>
						<span class="block h-0.5 w-10 rounded-full bg-[#ff7a00] mt-4 mb-4 transition-all duration-500 group-hover:w-16" aria-hidden="true"></span>
						<p class="text-[15px] text-neutral-600 leading-relaxed"><?php metadoc_the_text( $v[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- 03 · הצוות שלנו -->
	<?php get_template_part( 'template-parts/about-team' ); ?>

	<?php get_template_part( 'template-parts/lead-form' ); ?>
</main>
<?php
get_footer();
