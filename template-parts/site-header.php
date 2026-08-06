<?php
/**
 * כותרת האתר (ניווט עליון דביק) + תפריט ראשי + תפריט מובייל.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c        = metadoc_contact();
$has_menu = has_nav_menu( 'primary' );
?>
<header class="relative z-50 bg-white/95 backdrop-blur-md border-b border-neutral-200 px-5 md:px-10 py-2 flex justify-between items-center gap-4" role="banner">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 group shrink-0" aria-label="<?php esc_attr_e( 'מטאדוק — דף הבית', 'metadoc' ); ?>">
		<img src="<?php echo esc_url( metadoc_logo_url() ); ?>" alt="<?php esc_attr_e( 'מטאדוק - נדל״ן, מימון, פיננסים', 'metadoc' ); ?>" width="260" height="100" class="h-14 md:h-16 w-auto object-contain transition-transform group-hover:scale-[1.04]" decoding="async" fetchpriority="high">
	</a>

	<?php if ( $has_menu ) : ?>
		<nav class="md-nav hidden lg:block flex-1" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'metadoc' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex items-center justify-center gap-6',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>
	<?php endif; ?>

	<div class="flex items-center gap-2 shrink-0">
		<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>" class="hidden md:inline-flex items-center gap-2 text-sm font-bold text-neutral-700 hover:text-neutral-900 transition">
			<?php metadoc_icon( 'phone', array( 'class' => 'size-4 text-[#ff7a00]' ) ); ?>
			<?php echo esc_html( $c['phone_display'] ); ?>
		</a>
		<a href="<?php echo esc_url( metadoc_form_url() ); ?>" class="md-btn text-white px-4 py-2 rounded-full text-sm font-extrabold flex items-center gap-1.5 shadow-sm bg-[#0a0a0a]">
			<?php metadoc_the_text( 'header_cta' ); ?>
			<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-3.5' ) ); ?>
		</a>
		<?php if ( $has_menu ) : ?>
			<button type="button" id="md-nav-toggle" class="lg:hidden size-10 grid place-items-center rounded-lg hover:bg-neutral-100 text-neutral-900" aria-expanded="false" aria-controls="md-mobile-nav" aria-label="<?php esc_attr_e( 'פתיחת תפריט', 'metadoc' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" class="size-6"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
			</button>
		<?php endif; ?>
	</div>
</header>
<?php if ( $has_menu ) : ?>
	<nav id="md-mobile-nav" hidden class="md-nav md-nav-mobile lg:hidden relative z-40 bg-white border-b border-neutral-200 px-5 py-3 shadow-lg" aria-label="<?php esc_attr_e( 'תפריט מובייל', 'metadoc' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'flex flex-col gap-1',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		?>
	</nav>
<?php endif; ?>
