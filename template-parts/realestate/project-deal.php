<?php
/**
 * עמוד פרויקט — 01 / תמצית העסקה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="md-pr-sec">
	<div class="md-pr-split md-re-in">
		<div data-rv>
			<p class="md-re-eyebrow"><?php metadoc_project_the( 's1_eyebrow' ); ?></p>
			<h2 class="md-pr-h2"><?php metadoc_project_the( 's1_title' ); ?> <span class="md-re-acc"><?php metadoc_project_the( 's1_title_acc' ); ?></span></h2>
			<p class="md-pr-lead"><?php metadoc_project_the( 's1_lead' ); ?></p>
			<dl class="md-pr-rows">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<?php $key = metadoc_project_field( 's1_row' . $i . '_k' ); ?>
					<?php if ( '' === $key ) : continue; endif; ?>
					<div class="md-pr-row">
						<dt><?php echo esc_html( $key ); ?></dt>
						<dd><?php metadoc_project_the( 's1_row' . $i . '_v' ); ?></dd>
					</div>
				<?php endfor; ?>
			</dl>
		</div>
		<figure class="md-pr-fig" data-rv>
			<div class="md-pr-fig-in">
				<?php
				metadoc_project_image(
					's1_image',
					'pr_mass',
					__( 'הדמיית הבינוי המתוכנן — מיקום החלקה מסומן', 'metadoc' ),
					__( 'הדמיית בינוי', 'metadoc' ),
					array( 'sizes' => '(max-width: 1060px) 100vw, 560px' )
				);
				?>
			</div>
			<?php $pr_cap = metadoc_project_field( 's1_caption' ); ?>
			<?php if ( '' !== $pr_cap ) : ?>
				<figcaption><?php echo esc_html( $pr_cap ); ?></figcaption>
			<?php endif; ?>
		</figure>
	</div>
</section>
