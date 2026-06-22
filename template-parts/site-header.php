<?php
/**
 * כותרת האתר (ניווט עליון דביק).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();
?>
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-neutral-200 px-5 md:px-10 py-2 flex justify-between items-center" role="banner">
	<a href="#top" class="flex items-center gap-3 group" aria-label="<?php esc_attr_e( 'מטאדוק — חזרה לראש העמוד', 'metadoc' ); ?>">
		<img src="<?php echo esc_url( metadoc_logo_url() ); ?>" alt="<?php esc_attr_e( 'מטאדוק - נדל״ן, מימון, פיננסים', 'metadoc' ); ?>" width="260" height="100" class="h-14 md:h-16 w-auto object-contain transition-transform group-hover:scale-[1.04]" decoding="async" fetchpriority="high">
	</a>
	<nav class="flex items-center gap-2" aria-label="<?php esc_attr_e( 'פעולות ראשיות', 'metadoc' ); ?>">
		<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>" class="hidden md:inline-flex items-center gap-2 text-sm font-bold text-neutral-700 hover:text-neutral-900 transition">
			<?php metadoc_icon( 'phone', array( 'class' => 'size-4 text-[#ff7a00]' ) ); ?>
			<?php echo esc_html( $c['phone_display'] ); ?>
		</a>
		<a href="<?php echo esc_url( metadoc_form_url() ); ?>" class="md-btn text-white px-4 py-2 rounded-full text-sm font-extrabold flex items-center gap-1.5 shadow-sm bg-[#0a0a0a]">
			<?php esc_html_e( 'בדיקת זכאות', 'metadoc' ); ?>
			<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-3.5' ) ); ?>
		</a>
	</nav>
</header>
