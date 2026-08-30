<?php
/**
 * עמוד פרויקט — 02 / המצב התכנוני (כרטיסי נתונים + בלוק היתרון).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pr_svg   = 'width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';
$pr_icons = Metadoc_Projects::fact_icons();
?>
<section class="md-pr-sec md-pr-sec--warm">
	<div class="md-re-in">
		<div class="md-pr-sec-head" data-rv>
			<div>
				<p class="md-re-eyebrow"><?php metadoc_project_the( 's2_eyebrow' ); ?></p>
				<h2 class="md-pr-h2"><?php metadoc_project_the( 's2_title' ); ?></h2>
			</div>
			<p><?php metadoc_project_the( 's2_sub' ); ?></p>
		</div>
		<div class="md-pr-facts" data-rv>
			<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
				<?php
				$num = metadoc_project_field( 's2_fact' . $i . '_num' );
				if ( '' === $num ) {
					continue;
				}
				$icon = metadoc_project_field( 's2_fact' . $i . '_icon' );
				$path = $pr_icons[ $icon ]['path'] ?? reset( $pr_icons )['path'];
				?>
				<div class="md-pr-fact">
					<span class="md-pr-fact-ico"><svg <?php echo $pr_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- מחרוזת מאפיינים קבועה. ?>><?php echo $path; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG קבוע בקוד. ?></svg></span>
					<b><?php echo esc_html( $num ); ?></b>
					<span><?php metadoc_project_the( 's2_fact' . $i . '_label' ); ?></span>
				</div>
			<?php endfor; ?>
		</div>
		<?php if ( '' !== metadoc_project_field( 's2_edge_title' ) ) : ?>
			<div class="md-pr-edge" data-rv>
				<p class="md-pr-edge-k"><?php metadoc_project_the( 's2_edge_label' ); ?></p>
				<h3><?php metadoc_project_the( 's2_edge_title' ); ?></h3>
				<p><?php metadoc_project_the( 's2_edge_body' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
