<?php
/**
 * תבנית ה-Head ופתיחת המסמך.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-white text-neutral-900' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'דילוג לתוכן הראשי', 'metadoc' ); ?></a>
<div id="top" class="bg-white text-neutral-900 min-h-screen pb-28 md:pb-0 antialiased font-body">
<?php get_template_part( 'template-parts/site-header' ); ?>
