<?php
/**
 * עמוד פרויקט — 04 / תרחישי רווח (טאבים נגישים + עקומת צמיחה).
 * הנתונים אושרו מול הלקוח — אין לשנות מספרים.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tabs = array(
	'pre'  => array(
		'label' => __( 'אקזיט לפני בנייה', 'metadoc' ),
		'note'  => __( 'מכירת הקרקע ברגע שהזכויות מאושרות — בלי לבנות.', 'metadoc' ),
		'foot'  => __( 'הרווח מחושב בניכוי עלות הקרקע והיטל ההשבחה.', 'metadoc' ),
		'line'  => 'M300 174 C 258 170, 232 128, 170 108 C 118 92, 92 58, 20 26',
		'area'  => 'M300 174 C 258 170, 232 128, 170 108 C 118 92, 92 58, 20 26 L20 196 L300 196 Z',
		'dots'  => array( array( 300, 174 ), array( 170, 108 ), array( 20, 26 ) ),
		'cards' => array(
			array(
				'name'  => __( 'שמרני', 'metadoc' ),
				'spec'  => __( '6 קומות · 100 מ"ר', 'metadoc' ),
				'hue'   => '#8a7f70',
				'klbl'  => __( 'רווח פוטנציאלי', 'metadoc' ),
				'profit' => '400,000 ₪',
				'mult'  => __( '×2 על ההשקעה', 'metadoc' ),
				'w'     => '67%',
				'rows'  => array(
					array( __( 'שווי קרקע בהיתר', 'metadoc' ), '900,000 ₪' ),
					array( __( 'היטל השבחה', 'metadoc' ), '300,000 ₪' ),
					array( __( 'השקעה', 'metadoc' ), '199,000 ₪' ),
				),
			),
			array(
				'name'  => __( 'לפי שמאות תקן 22', 'metadoc' ),
				'spec'  => __( '10 קומות · 167 מ"ר', 'metadoc' ),
				'hue'   => '#fb7a00',
				'klbl'  => __( 'רווח פוטנציאלי', 'metadoc' ),
				'profit' => '600,000 ₪',
				'mult'  => __( '×3 על ההשקעה', 'metadoc' ),
				'w'     => '100%',
				'rows'  => array(
					array( __( 'שווי קרקע בהיתר', 'metadoc' ), '1,200,000 ₪' ),
					array( __( 'היטל השבחה', 'metadoc' ), '500,000 ₪' ),
					array( __( 'השקעה', 'metadoc' ), '199,000 ₪' ),
				),
			),
		),
	),
	'post' => array(
		'label' => __( 'אקזיט לאחר בנייה', 'metadoc' ),
		'note'  => __( 'בונים ומוכרים דירה גמורה. הרווח נטו, אחרי כל ההוצאות.', 'metadoc' ),
		'foot'  => __( 'ההוצאות כוללות קרקע, בנייה והיטל השבחה.', 'metadoc' ),
		'line'  => 'M300 180 C 256 176, 230 146, 170 126 C 116 108, 88 52, 20 22',
		'area'  => 'M300 180 C 256 176, 230 146, 170 126 C 116 108, 88 52, 20 22 L20 196 L300 196 Z',
		'dots'  => array( array( 300, 180 ), array( 170, 126 ), array( 20, 22 ) ),
		'cards' => array(
			array(
				'name'  => __( '6 קומות', 'metadoc' ),
				'spec'  => __( 'מימוש דירה בנויה', 'metadoc' ),
				'hue'   => '#8a7f70',
				'klbl'  => __( 'רווח נטו', 'metadoc' ),
				'profit' => '600,000 ₪',
				'mult'  => __( '+43% על ההוצאה הכוללת', 'metadoc' ),
				'w'     => '53%',
				'rows'  => array(
					array( __( 'שווי דירה', 'metadoc' ), '2,000,000 ₪' ),
					array( __( 'הוצאות כוללות', 'metadoc' ), '1,400,000 ₪' ),
					array( __( 'מתוכן קרקע', 'metadoc' ), '199,000 ₪' ),
				),
			),
			array(
				'name'  => __( '10 קומות', 'metadoc' ),
				'spec'  => __( 'מימוש דירה בנויה', 'metadoc' ),
				'hue'   => '#fb7a00',
				'klbl'  => __( 'רווח נטו', 'metadoc' ),
				'profit' => '1,137,000 ₪',
				'mult'  => __( '+52% על ההוצאה הכוללת', 'metadoc' ),
				'w'     => '100%',
				'rows'  => array(
					array( __( 'שווי דירה', 'metadoc' ), '3,340,000 ₪' ),
					array( __( 'הוצאות כוללות', 'metadoc' ), '2,203,000 ₪' ),
					array( __( 'מתוכן קרקע', 'metadoc' ), '199,000 ₪' ),
				),
			),
		),
	),
);
?>
<section class="md-pr-scen-sec">
	<div class="md-re-in">
		<p class="md-re-eyebrow"><?php esc_html_e( '04 / תרחישי רווח', 'metadoc' ); ?></p>
		<h2 data-rv><?php esc_html_e( 'מה קורה ל-199,000 ₪', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'שנכנסים היום.', 'metadoc' ); ?></span></h2>
		<p class="md-pr-scen-sub"><?php esc_html_e( 'שתי דרכי מימוש, לפי היקף הבנייה שיאושר בפועל.', 'metadoc' ); ?></p>

		<div class="md-pr-tabs" role="tablist" aria-label="<?php esc_attr_e( 'דרכי מימוש', 'metadoc' ); ?>" data-md-tabs>
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<?php $is_first = 'pre' === $key; ?>
				<button type="button" class="md-pr-tab" role="tab"
					id="md-pr-tab-<?php echo esc_attr( $key ); ?>"
					aria-controls="md-pr-panel-<?php echo esc_attr( $key ); ?>"
					aria-selected="<?php echo $is_first ? 'true' : 'false'; ?>"
					tabindex="<?php echo $is_first ? '0' : '-1'; ?>"><?php echo esc_html( $tab['label'] ); ?></button>
			<?php endforeach; ?>
		</div>

		<?php foreach ( $tabs as $key => $tab ) : ?>
			<?php $is_first = 'pre' === $key; ?>
			<div class="md-pr-panel" role="tabpanel" id="md-pr-panel-<?php echo esc_attr( $key ); ?>"
				aria-labelledby="md-pr-tab-<?php echo esc_attr( $key ); ?>" tabindex="0" <?php echo $is_first ? '' : 'hidden'; ?>>
				<p class="md-pr-tab-note"><?php echo esc_html( $tab['note'] ); ?></p>
				<div class="md-pr-scen-wrap">
					<div class="md-pr-scen" data-rv>
						<?php foreach ( $tab['cards'] as $card ) : ?>
							<article class="md-pr-card">
								<span class="md-pr-card-bar" style="background:<?php echo esc_attr( $card['hue'] ); ?>" aria-hidden="true"></span>
								<div class="md-pr-card-head">
									<h3><?php echo esc_html( $card['name'] ); ?></h3>
									<span><?php echo esc_html( $card['spec'] ); ?></span>
								</div>
								<p class="md-pr-card-k"><?php echo esc_html( $card['klbl'] ); ?></p>
								<div class="md-pr-card-profit">
									<b><?php echo esc_html( $card['profit'] ); ?></b>
									<span class="md-pr-card-mult"><?php echo esc_html( $card['mult'] ); ?></span>
								</div>
								<div class="md-pr-card-track" aria-hidden="true">
									<i style="width:<?php echo esc_attr( $card['w'] ); ?>;background:<?php echo esc_attr( $card['hue'] ); ?>"></i>
								</div>
								<div class="md-pr-card-rows">
									<?php foreach ( $card['rows'] as $row ) : ?>
										<div class="md-pr-card-row">
											<span><?php echo esc_html( $row[0] ); ?></span>
											<b><?php echo esc_html( $row[1] ); ?></b>
										</div>
									<?php endforeach; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>

					<div class="md-pr-chart" data-chart data-rv>
						<p class="md-pr-chart-k"><?php esc_html_e( 'מסלול הצמיחה', 'metadoc' ); ?></p>
						<svg viewBox="0 0 320 210" role="img" aria-label="<?php esc_attr_e( 'תרשים מגמה: הערך עולה מימין לשמאל לאורך שלוש נקודות ציון.', 'metadoc' ); ?>">
							<defs>
								<linearGradient id="md-ch-<?php echo esc_attr( $key ); ?>" x1="0" y1="0" x2="0" y2="1">
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
							<path data-ch-area d="<?php echo esc_attr( $tab['area'] ); ?>" fill="url(#md-ch-<?php echo esc_attr( $key ); ?>)"></path>
							<path data-ch-line d="<?php echo esc_attr( $tab['line'] ); ?>" fill="none" stroke="#fb7a00" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
							<g data-ch-dots>
								<?php foreach ( $tab['dots'] as $dot ) : ?>
									<circle data-ch-dot cx="<?php echo esc_attr( (string) $dot[0] ); ?>" cy="<?php echo esc_attr( (string) $dot[1] ); ?>" r="4.6" fill="#14110e" stroke="#fb7a00" stroke-width="2.4"></circle>
								<?php endforeach; ?>
							</g>
						</svg>
						<p class="md-pr-chart-foot"><?php echo esc_html( $tab['foot'] ); ?></p>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
