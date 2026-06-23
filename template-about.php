<?php
/**
 * Template Name: עמוד אודות
 *
 * עמוד "אודות" מעוצב: סיפור החברה (תוכן העמוד), ערכים והצוות שלנו.
 * הערכים והצוות נערכים ב"התאמה אישית" → תוכן האתר → עמוד אודות.
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

$team = array(
	array( 'about_team_1_name', 'about_team_1_role', 'about_team_1_bio', 'about_team_1_photo' ),
	array( 'about_team_2_name', 'about_team_2_role', 'about_team_2_bio', 'about_team_2_photo' ),
	array( 'about_team_3_name', 'about_team_3_role', 'about_team_3_bio', 'about_team_3_photo' ),
	array( 'about_team_4_name', 'about_team_4_role', 'about_team_4_bio', 'about_team_4_photo' ),
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

	<!-- סיפור החברה -->
	<section class="bg-white">
		<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid lg:grid-cols-12 gap-10 lg:gap-16 items-center">
			<div class="lg:col-span-6 order-2 lg:order-1">
				<p class="text-xl md:text-2xl font-bold text-neutral-900 leading-snug mb-6 text-balance font-display"><?php metadoc_the_text( 'about_lead' ); ?></p>
				<?php if ( '' !== $content ) : ?>
					<div class="md-prose"><?php the_content(); ?></div>
				<?php endif; ?>
			</div>
			<div class="lg:col-span-6 order-1 lg:order-2">
				<figure class="relative rounded-3xl overflow-hidden border border-neutral-200 shadow-[0_40px_80px_-30px_rgba(0,0,0,0.4)]">
					<img src="<?php echo esc_url( $about_img ); ?>" alt="<?php esc_attr_e( 'צוות מטאדוק', 'metadoc' ); ?>" width="1024" height="768" class="w-full h-[320px] md:h-[460px] object-cover" loading="lazy" decoding="async">
					<div class="absolute bottom-5 right-5 bg-white/95 backdrop-blur rounded-2xl px-5 py-4 shadow-xl">
						<div class="text-3xl font-black leading-none font-display text-[#ff7a00]"><?php metadoc_the_text( 'trust_1_num' ); ?></div>
						<div class="text-[11px] font-bold text-neutral-500 tracking-wider mt-1"><?php metadoc_the_text( 'trust_1_text' ); ?></div>
					</div>
				</figure>
			</div>
		</div>
	</section>

	<!-- ציטוט מודגש -->
	<section class="bg-black text-white relative overflow-hidden">
		<div class="absolute -left-32 top-1/2 -translate-y-1/2 w-[26rem] h-[26rem] rounded-full blur-[140px] opacity-20 bg-[#ff7a00]" aria-hidden="true"></div>
		<div class="relative z-10 max-w-4xl mx-auto px-6 md:px-10 py-16 md:py-24 text-center">
			<?php metadoc_icon( 'star', array( 'class' => 'size-8 text-[#ff7a00] mx-auto mb-6' ) ); ?>
			<p class="text-2xl md:text-4xl font-bold leading-tight tracking-tight text-balance font-display"><?php metadoc_the_text( 'about_quote' ); ?></p>
		</div>
	</section>

	<!-- ערכים -->
	<section class="bg-neutral-50">
		<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
			<?php metadoc_section_heading( esc_html( metadoc_text( 'about_values_title' ) ), 'text-center mb-12 md:mb-16' ); ?>
			<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php foreach ( $values as $v ) : ?>
					<div class="bg-white border border-neutral-200 rounded-2xl p-8 text-center hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.25)] hover:border-neutral-300 transition-all">
						<span class="inline-grid place-items-center size-14 rounded-2xl bg-[#ff7a00]/10 text-[#ff7a00] mb-5">
							<?php metadoc_icon( $v[0], array( 'class' => 'size-7' ) ); ?>
						</span>
						<h3 class="text-xl font-bold text-neutral-900 mb-2 font-display"><?php metadoc_the_text( $v[1] ); ?></h3>
						<p class="text-[15px] text-neutral-600 leading-relaxed"><?php metadoc_the_text( $v[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- הצוות שלנו -->
	<?php
	$team_visible = array();
	foreach ( $team as $member ) {
		if ( '' !== trim( metadoc_text( $member[0] ) ) ) {
			$team_visible[] = $member;
		}
	}
	if ( ! empty( $team_visible ) ) :
		?>
	<section class="bg-white">
		<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
			<div class="text-center max-w-2xl mx-auto mb-12 md:mb-16">
				<?php metadoc_section_heading( esc_html( metadoc_text( 'about_team_title' ) ), 'mb-4' ); ?>
				<p class="text-lg text-neutral-600 leading-relaxed"><?php metadoc_the_text( 'about_team_subtitle' ); ?></p>
			</div>
			<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
				<?php foreach ( $team_visible as $member ) : ?>
					<article class="group text-center">
						<div class="relative mx-auto w-40 h-40 rounded-full overflow-hidden border-4 border-neutral-100 shadow-lg mb-5 ring-1 ring-neutral-200">
							<?php metadoc_team_avatar( metadoc_text( $member[3] ), metadoc_text( $member[0] ) ); ?>
						</div>
						<h3 class="text-xl font-bold text-neutral-900 font-display"><?php metadoc_the_text( $member[0] ); ?></h3>
						<div class="text-[13px] font-extrabold tracking-wide text-[#ff7a00] mt-1 mb-3"><?php metadoc_the_text( $member[1] ); ?></div>
						<p class="text-[14px] text-neutral-600 leading-relaxed max-w-xs mx-auto"><?php metadoc_the_text( $member[2] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/lead-form' ); ?>
</main>
<?php
get_footer();
