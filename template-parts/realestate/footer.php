<?php
/**
 * מחלקת נדל"ן — פוטר העמוד.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();
?>
<footer class="md-re-foot">
	<b><?php esc_html_e( 'מטאדוק · מחלקת נדל"ן והשקעות', 'metadoc' ); ?></b>
	<div class="md-re-foot-links">
		<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>"><?php echo esc_html( $c['phone_display'] ); ?></a>
		<span><?php echo esc_html( $c['address'] ); ?></span>
		<span><?php echo esc_html( $c['hours_week'] ); ?><?php echo '' !== $c['hours_fri'] ? ' · ' . esc_html( $c['hours_fri'] ) : ''; ?></span>
		<a href="<?php echo esc_url( metadoc_privacy_url() ); ?>"><?php esc_html_e( 'מדיניות פרטיות', 'metadoc' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/accessibility-statement/' ) ); ?>"><?php esc_html_e( 'הצהרת נגישות', 'metadoc' ); ?></a>
	</div>
	<span><?php printf( esc_html__( '© %s מטאדוק. כל הזכויות שמורות.', 'metadoc' ), esc_html( wp_date( 'Y' ) ) ); ?></span>
</footer>
