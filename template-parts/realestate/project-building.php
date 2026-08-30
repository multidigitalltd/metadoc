<?php
/**
 * עמוד פרויקט — 03 / מאפייני הבינוי.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="md-pr-sec">
	<div class="md-re-in">
		<p class="md-re-eyebrow"><?php metadoc_project_the( 's3_eyebrow' ); ?></p>
		<h2 class="md-pr-h2" style="margin-bottom:44px" data-rv><?php metadoc_project_the( 's3_title' ); ?> <span class="md-re-acc"><?php metadoc_project_the( 's3_title_acc' ); ?></span></h2>
		<div class="md-pr-split md-pr-split--top">
			<figure class="md-pr-fig" data-rv>
				<div class="md-pr-fig-in">
					<?php
					metadoc_project_image(
						's3_image',
						'pr_heigh',
						__( 'מפת גבהי בנייה באזור — מיקום החלקה מסומן', 'metadoc' ),
						__( 'מפת גבהי בנייה', 'metadoc' ),
						array( 'sizes' => '(max-width: 1060px) 100vw, 560px' )
					);
					?>
				</div>
				<?php $pr_cap = metadoc_project_field( 's3_caption' ); ?>
				<?php if ( '' !== $pr_cap ) : ?>
					<figcaption><?php echo esc_html( $pr_cap ); ?></figcaption>
				<?php endif; ?>
			</figure>
			<div class="md-pr-bullets" data-rv>
				<?php for ( $i = 1; $i <= 2; $i++ ) : ?>
					<?php $title = metadoc_project_field( 's3_b' . $i . '_title' ); ?>
					<?php if ( '' === $title ) : continue; endif; ?>
					<div class="md-pr-bullet<?php echo 1 === $i ? ' md-pr-bullet--first' : ''; ?>">
						<h3><?php echo esc_html( $title ); ?></h3>
						<p><?php metadoc_project_the( 's3_b' . $i . '_body' ); ?></p>
					</div>
				<?php endfor; ?>
				<div class="md-pr-bullet">
					<h3 style="margin-bottom:14px"><?php metadoc_project_the( 's3_mix_title' ); ?></h3>
					<div class="md-pr-mix">
						<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
							<?php
							$label = metadoc_project_field( 's3_mix' . $i . '_label' );
							if ( '' === $label ) {
								continue;
							}
							$pct = metadoc_project_field( 's3_mix' . $i . '_pct' );
							$w   = (float) preg_replace( '/[^0-9.]/', '', $pct );
							?>
							<div>
								<div class="md-pr-mix-row">
									<span><?php echo esc_html( $label ); ?></span>
									<b><?php echo esc_html( $pct ); ?></b>
								</div>
								<div class="md-pr-bar"><i style="width:<?php echo esc_attr( min( 100, max( 0, $w ) ) . '%' ); ?>"></i></div>
							</div>
						<?php endfor; ?>
						<?php $pr_note = metadoc_project_field( 's3_mix_note' ); ?>
						<?php if ( '' !== $pr_note ) : ?>
							<p class="md-pr-mix-note"><?php echo esc_html( $pr_note ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
