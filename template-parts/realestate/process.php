<?php
/**
 * מחלקת נדל"ן — התהליך (5 שלבים לצד תמונה דביקה).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$steps = array(
	array( '01', __( 'אפיון ההשקעה', 'metadoc' ), __( 'פגישת היכרות בה נאפיין יחד את סוג ההשקעה המתאים לכם.', 'metadoc' ) ),
	array( '02', __( 'איתור הנכס', 'metadoc' ), __( 'חיפוש ממוקד בעזרת רשת השותפים שלנו ברחבי הארץ.', 'metadoc' ) ),
	array( '03', __( 'בדיקות מקיפות', 'metadoc' ), __( 'בדיקות משפטיות, שמאות וכדאיות כלכלית לעסקה.', 'metadoc' ) ),
	array( '04', __( 'מו"מ וסגירה', 'metadoc' ), __( 'ניהול משא ומתן בשמכם והובלת העסקה לסגירה בתנאים אופטימליים.', 'metadoc' ) ),
	array( '05', __( 'השבחה וליווי', 'metadoc' ), __( 'שיפוץ, השבחה וטיפול שוטף בנכס — גם אחרי החתימה.', 'metadoc' ) ),
);
$last  = count( $steps ) - 1;
?>
<section class="md-re-process">
	<div class="md-re-in">
		<p class="md-re-chip"><b aria-hidden="true">●</b> <?php esc_html_e( 'התהליך · 5 שלבים פשוטים', 'metadoc' ); ?></p>
		<h2><?php esc_html_e( 'איך זה', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'עובד?', 'metadoc' ); ?></span></h2>
		<div class="md-re-process-grid" data-reveal>
			<div class="md-re-process-shot">
				<?php
				metadoc_re_image(
					'process',
					__( 'ליווי אישי של משקיעים', 'metadoc' ),
					__( 'תמונת ליווי משקיעים', 'metadoc' ),
					array(
						'dark'  => true,
						'sizes' => '(max-width: 980px) 100vw, 420px',
					)
				);
				?>
			</div>
			<ol style="list-style:none;margin:0;padding:0">
				<?php foreach ( $steps as $i => $step ) : ?>
					<li class="md-re-step">
						<div class="md-re-step-rail">
							<div class="md-re-step-num" aria-hidden="true"><?php echo esc_html( $step[0] ); ?></div>
							<?php if ( $i < $last ) : ?>
								<div class="md-re-step-line" aria-hidden="true"></div>
							<?php endif; ?>
						</div>
						<div class="md-re-step-body">
							<h3><?php echo esc_html( $step[1] ); ?></h3>
							<p><?php echo esc_html( $step[2] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
