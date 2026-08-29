<?php
/**
 * עמוד פרויקט — פוטר והבהרה משפטית.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();
?>
<footer class="md-pr-foot">
	<div class="md-pr-foot-in is-open" data-md-foot>
		<p class="md-pr-foot-k"><?php esc_html_e( 'הבהרה משפטית', 'metadoc' ); ?></p>
		<p><?php esc_html_e( 'המידע מבוסס על נתוני תמ"א 75, מנהל התכנון ומסמכי אדריכלים. המסמך מהווה חומר שיווקי/פנימי ואינו שומת מקרקעין, ייעוץ השקעות או הבטחה לתשואה.', 'metadoc' ); ?></p>
		<div class="md-pr-foot-line">
			<?php
			printf(
				/* translators: %s: כתובת המשרד. */
				esc_html__( 'מטאדוק · מחלקת נדל"ן · %s', 'metadoc' ),
				esc_html( $c['address'] )
			);
			?>
		</div>
	</div>
</footer>
