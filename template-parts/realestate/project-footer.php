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
		<p class="md-pr-foot-k"><?php metadoc_project_the( 'foot_label' ); ?></p>
		<p><?php metadoc_project_the( 'foot_text' ); ?></p>
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
