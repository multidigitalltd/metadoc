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

$rows = array(
	array( __( 'מיקום', 'metadoc' ), __( 'קריית אתא, מזרח שכונת קריית בנימין, צמוד לרקמה הבנויה', 'metadoc' ) ),
	array( __( 'מחיר כניסה', 'metadoc' ), __( '199,000 ₪ בלבד', 'metadoc' ) ),
	array( __( 'עיתוי', 'metadoc' ), __( 'לפני נעילת הזכויות', 'metadoc' ) ),
);
?>
<section class="md-pr-sec">
	<div class="md-pr-split md-re-in">
		<div data-rv>
			<p class="md-re-eyebrow"><?php esc_html_e( '01 / תמצית העסקה', 'metadoc' ); ?></p>
			<h2 class="md-pr-h2"><?php esc_html_e( 'כניסה מוקדמת,', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'לפני נעילת הזכויות.', 'metadoc' ); ?></span></h2>
			<p class="md-pr-lead"><?php esc_html_e( 'קרקע במזרח שכונת קריית בנימין, צמודת דופן לרקמה הבנויה — בתוך מתחם 2.4 של תמ"א 75, המיועד למרקם עירוני חדש.', 'metadoc' ); ?></p>
			<dl class="md-pr-rows">
				<?php foreach ( $rows as $row ) : ?>
					<div class="md-pr-row">
						<dt><?php echo esc_html( $row[0] ); ?></dt>
						<dd><?php echo esc_html( $row[1] ); ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>
		</div>
		<figure class="md-pr-fig" data-rv>
			<div class="md-pr-fig-in">
				<?php
				metadoc_re_image(
					'pr_mass',
					__( 'הדמיית הבינוי המתוכנן — מיקום החלקה מסומן', 'metadoc' ),
					__( 'הדמיית בינוי', 'metadoc' ),
					array( 'sizes' => '(max-width: 1060px) 100vw, 560px' )
				);
				?>
			</div>
			<figcaption><?php esc_html_e( 'הדמיית הבינוי המתוכנן — מיקום החלקה מסומן בחץ.', 'metadoc' ); ?></figcaption>
		</figure>
	</div>
</section>
