<?php
/**
 * עמוד פרויקט — 04 / תרחישי רווח (טאבים נגישים + עקומת צמיחה).
 * המספרים נערכים ברשומת הפרויקט; ברירת המחדל היא נתוני "שער המפרץ" המאושרים.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// עקומות הצמיחה קבועות בעיצוב — עולות מימין לשמאל.
$pr_curves = array(
	1 => array(
		'line' => 'M300 174 C 258 170, 232 128, 170 108 C 118 92, 92 58, 20 26',
		'area' => 'M300 174 C 258 170, 232 128, 170 108 C 118 92, 92 58, 20 26 L20 196 L300 196 Z',
		'dots' => array( array( 300, 174 ), array( 170, 108 ), array( 20, 26 ) ),
	),
	2 => array(
		'line' => 'M300 180 C 256 176, 230 146, 170 126 C 116 108, 88 52, 20 22',
		'area' => 'M300 180 C 256 176, 230 146, 170 126 C 116 108, 88 52, 20 22 L20 196 L300 196 Z',
		'dots' => array( array( 300, 180 ), array( 170, 126 ), array( 20, 22 ) ),
	),
);
$pr_hues = array( 1 => '#8a7f70', 2 => '#fb7a00' );
?>
<section class="md-pr-scen-sec">
	<div class="md-re-in">
		<p class="md-re-eyebrow"><?php metadoc_project_the( 's4_eyebrow' ); ?></p>
		<h2 data-rv><?php metadoc_project_the( 's4_title' ); ?> <span class="md-re-acc"><?php metadoc_project_the( 's4_title_acc' ); ?></span></h2>
		<p class="md-pr-scen-sub"><?php metadoc_project_the( 's4_sub' ); ?></p>

		<div class="md-pr-tabs" role="tablist" aria-label="<?php esc_attr_e( 'דרכי מימוש', 'metadoc' ); ?>" data-md-tabs>
			<?php for ( $t = 1; $t <= 2; $t++ ) : ?>
				<button type="button" class="md-pr-tab" role="tab"
					id="md-pr-tab-<?php echo (int) $t; ?>"
					aria-controls="md-pr-panel-<?php echo (int) $t; ?>"
					aria-selected="<?php echo 1 === $t ? 'true' : 'false'; ?>"
					tabindex="<?php echo 1 === $t ? '0' : '-1'; ?>"><?php metadoc_project_the( 's4_tab' . $t . '_label' ); ?></button>
			<?php endfor; ?>
		</div>

		<?php for ( $t = 1; $t <= 2; $t++ ) : ?>
			<div class="md-pr-panel" role="tabpanel" id="md-pr-panel-<?php echo (int) $t; ?>"
				aria-labelledby="md-pr-tab-<?php echo (int) $t; ?>" tabindex="0" <?php echo 1 === $t ? '' : 'hidden'; ?>>
				<p class="md-pr-tab-note"><?php metadoc_project_the( 's4_tab' . $t . '_note' ); ?></p>
				<div class="md-pr-scen-wrap">
					<div class="md-pr-scen" data-rv>
						<?php for ( $c = 1; $c <= 2; $c++ ) : ?>
							<?php
							$base = 's4_tab' . $t . '_card' . $c . '_';
							$name = metadoc_project_field( $base . 'name' );
							if ( '' === $name ) {
								continue;
							}
							$hue = $pr_hues[ $c ];
							$w   = (float) preg_replace( '/[^0-9.]/', '', metadoc_project_field( $base . 'w' ) );
							?>
							<article class="md-pr-card">
								<span class="md-pr-card-bar" style="background:<?php echo esc_attr( $hue ); ?>" aria-hidden="true"></span>
								<div class="md-pr-card-head">
									<h3><?php echo esc_html( $name ); ?></h3>
									<span><?php echo esc_html( metadoc_project_field( $base . 'spec' ) ); ?></span>
								</div>
								<p class="md-pr-card-k"><?php echo esc_html( metadoc_project_field( $base . 'klbl' ) ); ?></p>
								<div class="md-pr-card-profit">
									<b><?php echo esc_html( metadoc_project_field( $base . 'profit' ) ); ?></b>
									<span class="md-pr-card-mult"><?php echo esc_html( metadoc_project_field( $base . 'mult' ) ); ?></span>
								</div>
								<div class="md-pr-card-track" aria-hidden="true">
									<i style="width:<?php echo esc_attr( min( 100, max( 0, $w ) ) . '%' ); ?>;background:<?php echo esc_attr( $hue ); ?>"></i>
								</div>
								<div class="md-pr-card-rows">
									<?php for ( $r = 1; $r <= 3; $r++ ) : ?>
										<?php $k = metadoc_project_field( $base . 'k' . $r ); ?>
										<?php if ( '' === $k ) : continue; endif; ?>
										<div class="md-pr-card-row">
											<span><?php echo esc_html( $k ); ?></span>
											<b><?php echo esc_html( metadoc_project_field( $base . 'v' . $r ) ); ?></b>
										</div>
									<?php endfor; ?>
								</div>
							</article>
						<?php endfor; ?>
					</div>

					<div class="md-pr-chart" data-chart data-rv>
						<p class="md-pr-chart-k"><?php esc_html_e( 'מסלול הצמיחה', 'metadoc' ); ?></p>
						<svg viewBox="0 0 320 210" role="img" aria-label="<?php esc_attr_e( 'תרשים מגמה: הערך עולה מימין לשמאל לאורך שלוש נקודות ציון.', 'metadoc' ); ?>">
							<defs>
								<linearGradient id="md-ch-<?php echo (int) $t; ?>" x1="0" y1="0" x2="0" y2="1">
									<stop offset="0%" stop-color="#fb7a00" stop-opacity="0.34"></stop>
									<stop offset="100%" stop-color="#fb7a00" stop-opacity="0"></stop>
								</linearGradient>
							</defs>
							<g stroke="#ffffff" stroke-opacity="0.09" stroke-width="1">
								<line x1="0" y1="40" x2="320" y2="40"></line>
								<line x1="0" y1="90" x2="320" y2="90"></line>
								<line x1="0" y1="140" x2="320" y2="140"></line>
								<line x1="0" y1="190" x2="320" y2="190"></line>
							</g>
							<path data-ch-area d="<?php echo esc_attr( $pr_curves[ $t ]['area'] ); ?>" fill="url(#md-ch-<?php echo (int) $t; ?>)"></path>
							<path data-ch-line d="<?php echo esc_attr( $pr_curves[ $t ]['line'] ); ?>" fill="none" stroke="#fb7a00" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
							<g data-ch-dots>
								<?php foreach ( $pr_curves[ $t ]['dots'] as $dot ) : ?>
									<circle data-ch-dot cx="<?php echo (int) $dot[0]; ?>" cy="<?php echo (int) $dot[1]; ?>" r="4.6" fill="#14110e" stroke="#fb7a00" stroke-width="2.4"></circle>
								<?php endforeach; ?>
							</g>
						</svg>
						<p class="md-pr-chart-foot"><?php metadoc_project_the( 's4_tab' . $t . '_foot' ); ?></p>
					</div>
				</div>
			</div>
		<?php endfor; ?>
	</div>
</section>
