<?php
/**
 * מחלקת נדל"ן — רצועת תמונה מקובעת + קריאה לעמוד הפרויקט.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="md-re-band-wrap">
	<div class="md-re-band" data-md-band>
		<div class="md-re-band-img">
			<?php
			metadoc_re_image(
				'band',
				'',
				__( 'תמונת רקע רחבה', 'metadoc' ),
				array(
					'dark'  => true,
					'sizes' => '100vw',
				)
			);
			?>
		</div>
		<div class="md-re-band-veil" aria-hidden="true"></div>
		<div class="md-re-band-in">
			<h2><?php esc_html_e( 'ההזדמנות הבאה שלכם', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'מחכה.', 'metadoc' ); ?></span></h2>
			<a class="md-re-btn md-re-btn--grad" href="<?php echo esc_url( metadoc_re_project_url() ); ?>">
				<span><?php esc_html_e( 'לעמוד הפרויקט', 'metadoc' ); ?></span>
				<span aria-hidden="true" style="font-size:20px">←</span>
			</a>
		</div>
	</div>
</div>
