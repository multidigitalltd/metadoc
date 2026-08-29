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

$mix = array(
	array( __( 'דירות קטנות · 55–80 מ"ר', 'metadoc' ), '20%' ),
	array( __( 'דירות רגילות · 80–110 מ"ר', 'metadoc' ), '60%' ),
	array( __( 'דירות גדולות · מעל 110 מ"ר', 'metadoc' ), '20%' ),
);
?>
<section class="md-pr-sec">
	<div class="md-re-in">
		<p class="md-re-eyebrow"><?php esc_html_e( '03 / מאפייני הבינוי', 'metadoc' ); ?></p>
		<h2 class="md-pr-h2" style="margin-bottom:44px" data-rv><?php esc_html_e( 'איפה עומדת', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'החלקה שלנו.', 'metadoc' ); ?></span></h2>
		<div class="md-pr-split md-pr-split--top">
			<figure class="md-pr-fig" data-rv>
				<div class="md-pr-fig-in">
					<?php
					metadoc_re_image(
						'pr_heigh',
						__( 'מפת גבהי בנייה באזור — מיקום החלקה מסומן', 'metadoc' ),
						__( 'מפת גבהי בנייה', 'metadoc' ),
						array( 'sizes' => '(max-width: 1060px) 100vw, 560px' )
					);
					?>
				</div>
				<figcaption><?php esc_html_e( 'תבנית הבנייה באזור — החלקה על ציר שד\' הקישון, בקטגוריית המגדלים.', 'metadoc' ); ?></figcaption>
			</figure>
			<div class="md-pr-bullets" data-rv>
				<div class="md-pr-bullet md-pr-bullet--first">
					<h3><?php esc_html_e( 'על ציר שד\' הקישון החדש', 'metadoc' ); ?></h3>
					<p><?php esc_html_e( 'הציר המחבר את חיפה, נשר וקריית אתא לפארק המטרופוליני.', 'metadoc' ); ?></p>
				</div>
				<div class="md-pr-bullet">
					<h3><?php esc_html_e( 'מעורב שימושים, עד 28 קומות', 'metadoc' ); ?></h3>
					<p><?php esc_html_e( 'מגורים ומסחר במתחם מגדלים.', 'metadoc' ); ?></p>
				</div>
				<div class="md-pr-bullet">
					<h3 style="margin-bottom:14px"><?php esc_html_e( 'תמהיל דירות מתוכנן', 'metadoc' ); ?></h3>
					<div class="md-pr-mix">
						<?php foreach ( $mix as $row ) : ?>
							<div>
								<div class="md-pr-mix-row">
									<span><?php echo esc_html( $row[0] ); ?></span>
									<b><?php echo esc_html( $row[1] ); ?></b>
								</div>
								<div class="md-pr-bar"><i style="width:<?php echo esc_attr( $row[1] ); ?>"></i></div>
							</div>
						<?php endforeach; ?>
						<p class="md-pr-mix-note"><?php esc_html_e( 'ממוצע יח"ד: 95 מ"ר', 'metadoc' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
