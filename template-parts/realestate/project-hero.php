<?php
/**
 * עמוד פרויקט — Hero מפוצל: עמודת טקסט כהה + תמונה עם פרלקסה וזום איטי.
 * התוכן נקרא מרשומת הפרויקט (עם נפילה לברירות המחדל של "שער המפרץ").
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pr_title = is_singular( Metadoc_Projects::CPT ) ? get_the_title() : __( 'שער המפרץ', 'metadoc' );
?>
<section class="md-pr-hero">
	<div class="md-pr-hero-grid">
		<div class="md-pr-hero-shell" data-md-hero-shell>
			<div class="md-pr-hero-glow" data-md-hero-glow aria-hidden="true"></div>
			<div class="md-pr-kicker">
				<i aria-hidden="true"></i>
				<span><?php metadoc_project_the( 'hero_eyebrow' ); ?></span>
			</div>
			<h1 class="md-pr-h1"><?php echo esc_html( $pr_title ); ?></h1>
			<p class="md-pr-hero-sub"><?php metadoc_project_the( 'hero_sub' ); ?></p>
			<div class="md-pr-hstats">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<?php $num = metadoc_project_field( 'hero_stat' . $i . '_num' ); ?>
					<?php if ( '' === $num ) : continue; endif; ?>
					<div class="md-pr-hstat">
						<b><?php echo esc_html( $num ); ?></b>
						<span><?php metadoc_project_the( 'hero_stat' . $i . '_label' ); ?></span>
					</div>
				<?php endfor; ?>
			</div>
		</div>
		<div class="md-pr-hero-media">
			<div class="md-pr-hero-px" data-md-hero-px>
				<?php
				metadoc_project_image(
					'hero_image',
					'pr_hero',
					/* translators: %s: שם הפרויקט. */
					sprintf( __( 'הדמיית הפרויקט %s', 'metadoc' ), $pr_title ),
					__( 'הדמיית הפרויקט', 'metadoc' ),
					array(
						'dark'  => true,
						'eager' => true,
						'sizes' => '(max-width: 980px) 100vw, 55vw',
					)
				);
				?>
			</div>
			<div class="md-pr-hero-tint" aria-hidden="true"></div>
		</div>
	</div>
</section>
