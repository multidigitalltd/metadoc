<?php
/**
 * מחלקת נדל"ן — כותרת עליונה דביקה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c    = metadoc_contact();
$nav  = array(
	'#about'    => __( 'אודות', 'metadoc' ),
	'#services' => __( 'שירותים', 'metadoc' ),
	'#projects' => __( 'פרויקטים', 'metadoc' ),
	'#club'     => __( 'מועדון המשקיעים', 'metadoc' ),
	'#faq'      => __( 'שאלות נפוצות', 'metadoc' ),
);
$logo = METADOC_URI . '/assets/img/re/metadoc-logo-full.png';
if ( is_readable( METADOC_DIR . '/assets/img/re/metadoc-logo-full.webp' ) ) {
	$logo = METADOC_URI . '/assets/img/re/metadoc-logo-full.webp';
}
?>
<header class="md-re-hdr">
	<a class="md-re-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<img src="<?php echo esc_url( $logo ); ?>" width="841" height="323" alt="<?php esc_attr_e( 'מטאדוק · נדל"ן / מימון / פיננסים', 'metadoc' ); ?>" fetchpriority="high" decoding="async">
		<span class="md-re-brand-sep" aria-hidden="true"></span>
		<span class="md-re-brand-sub"><?php esc_html_e( 'מחלקת נדל"ן והשקעות', 'metadoc' ); ?></span>
	</a>
	<nav class="md-re-nav" aria-label="<?php esc_attr_e( 'ניווט מחלקת הנדל"ן', 'metadoc' ); ?>">
		<?php foreach ( $nav as $href => $label ) : ?>
			<a href="<?php echo esc_attr( $href ); ?>"><?php echo esc_html( $label ); ?></a>
		<?php endforeach; ?>
		<a class="md-re-nav-tel" href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>"><?php echo esc_html( $c['phone_display'] ); ?></a>
		<a class="md-re-nav-cta" href="#contact"><?php esc_html_e( 'שיחת ייעוץ חינם ←', 'metadoc' ); ?></a>
	</nav>
</header>
