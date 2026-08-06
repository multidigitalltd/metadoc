<?php
/**
 * אודות — "הצוות שלנו".
 *
 * מוצגים רק חברי צוות ששמם מולא, ומספר העמודות מתאים את עצמו לכמות בפועל
 * כך שהרשת תמיד מרוכזת ואחידה (ללא "חור" בסוף השורה).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$members = array();
for ( $i = 1; $i <= METADOC_TEAM_MAX; $i++ ) {
	$name = trim( metadoc_text( 'about_team_' . $i . '_name' ) );
	if ( '' === $name ) {
		continue;
	}
	$members[] = array(
		'name'  => $name,
		'role'  => metadoc_text( 'about_team_' . $i . '_role' ),
		'bio'   => metadoc_text( 'about_team_' . $i . '_bio' ),
		'photo' => metadoc_text( 'about_team_' . $i . '_photo' ),
	);
}

if ( empty( $members ) ) {
	return;
}

// פריסה לפי מספר חברי הצוות בפועל — הרשת נשארת מרוכזת גם ב-1/2/3.
$layouts    = array(
	1 => 'max-w-sm',
	2 => 'sm:grid-cols-2 max-w-3xl',
	3 => 'sm:grid-cols-2 lg:grid-cols-3 max-w-5xl',
);
$team_grid  = $layouts[ count( $members ) ] ?? 'sm:grid-cols-2 lg:grid-cols-4';
$avatar_arg = array(
	'width'          => 480,
	'height'         => 600,
	'initials_class' => 'text-5xl md:text-6xl',
);
?>
<section class="bg-white border-t border-neutral-200">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
		<div class="max-w-3xl mb-12 md:mb-16">
			<?php
			metadoc_section_label( '03', metadoc_text( 'about_team_eyebrow' ) );
			metadoc_section_heading( esc_html( metadoc_text( 'about_team_title' ) ), 'mb-4' );
			?>
			<p class="text-[15px] md:text-lg text-neutral-600 leading-relaxed"><?php metadoc_the_text( 'about_team_subtitle' ); ?></p>
		</div>

		<div class="grid gap-6 md:gap-8 mx-auto <?php echo esc_attr( $team_grid ); ?>">
			<?php foreach ( $members as $idx => $member ) : ?>
				<article
					class="md-card-hover md-reveal group flex flex-col h-full bg-white border border-neutral-200 rounded-3xl overflow-hidden hover:border-neutral-300 hover:shadow-[0_30px_70px_-35px_rgba(0,0,0,0.45)]"
					style="animation-delay:<?php echo esc_attr( (string) ( $idx * 90 ) ); ?>ms"
					itemscope itemtype="https://schema.org/Person"
				>
					<div class="md-img-hover relative aspect-[4/3] sm:aspect-[4/5] overflow-hidden bg-neutral-100">
						<?php metadoc_team_avatar( $member['photo'], $member['name'], $avatar_arg ); ?>
						<span class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/40 to-transparent" aria-hidden="true"></span>
					</div>

					<div class="flex flex-col p-6 md:p-7">
						<h3 class="text-xl md:text-[1.375rem] font-bold text-neutral-900 leading-tight font-display" itemprop="name"><?php echo esc_html( $member['name'] ); ?></h3>

						<?php if ( '' !== $member['role'] ) : ?>
							<div class="text-[12px] font-extrabold tracking-[0.12em] text-[#b45309] mt-2" itemprop="jobTitle"><?php echo esc_html( $member['role'] ); ?></div>
						<?php endif; ?>

						<span class="block h-0.5 w-10 rounded-full bg-[#ff7a00] mt-4 mb-4 transition-all duration-500 group-hover:w-16" aria-hidden="true"></span>

						<?php if ( '' !== $member['bio'] ) : ?>
							<p class="text-[14px] text-neutral-600 leading-relaxed" itemprop="description"><?php echo esc_html( $member['bio'] ); ?></p>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
