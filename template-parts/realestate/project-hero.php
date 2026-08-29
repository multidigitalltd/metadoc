<?php
/**
 * עמוד פרויקט — Hero מפוצל: עמודת טקסט כהה + תמונה עם פרלקסה וזום איטי.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hstats = array(
	array( '199,000 ₪', __( 'מחיר כניסה', 'metadoc' ) ),
	array( __( 'עד 28', 'metadoc' ), __( 'קומות · מתחם מגדלים', 'metadoc' ) ),
	array( __( 'מתחם 2.4', 'metadoc' ), __( 'מרקם עירוני חדש', 'metadoc' ) ),
);
?>
<section class="md-pr-hero">
	<div class="md-pr-hero-grid">
		<div class="md-pr-hero-shell" data-md-hero-shell>
			<div class="md-pr-hero-glow" data-md-hero-glow aria-hidden="true"></div>
			<div class="md-pr-kicker">
				<i aria-hidden="true"></i>
				<span><?php esc_html_e( 'הזדמנות קרקע · תמ"א 75', 'metadoc' ); ?></span>
			</div>
			<h1 class="md-pr-h1"><?php esc_html_e( 'שער המפרץ', 'metadoc' ); ?></h1>
			<p class="md-pr-hero-sub"><?php esc_html_e( 'קריית בנימין, קריית אתא', 'metadoc' ); ?></p>
			<div class="md-pr-hstats">
				<?php foreach ( $hstats as $stat ) : ?>
					<div class="md-pr-hstat">
						<b><?php echo esc_html( $stat[0] ); ?></b>
						<span><?php echo esc_html( $stat[1] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="md-pr-hero-media">
			<div class="md-pr-hero-px" data-md-hero-px>
				<?php
				metadoc_re_image(
					'pr_hero',
					__( 'הדמיית המרקם העירוני והפארק המטרופוליני המתוכננים', 'metadoc' ),
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
