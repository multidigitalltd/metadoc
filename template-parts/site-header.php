<?php
/**
 * כותרת האתר (ניווט עליון) + תפריט ראשי + תפריט מובייל.
 *
 * הקישור למחלקת הנדל"ן הוא פריט קבוע בתפריט — הוא מוצג גם כשלא שויך
 * תפריט וורדפרס, ובכל רוחב מסך יש אליו נתיב אחד לפחות:
 * lg ומעלה בתוך הניווט, sm–lg ככפתור בשורת הפעולות, ומתחת ל-sm בתפריט
 * המובייל.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c        = metadoc_contact();
$has_menu = has_nav_menu( 'primary' );
$re_url   = metadoc_re_dept_url();
$re_label = __( 'מחלקת נדל"ן', 'metadoc' );

// בלי תפריט וורדפרס אין מה לפתוח מעל sm — שם הכפתור ממילא גלוי בשורת הפעולות.
$mobile_vis = $has_menu ? 'lg:hidden' : 'sm:hidden';
?>
<header class="relative z-50 bg-white/95 backdrop-blur-md border-b border-neutral-200 px-5 md:px-10 py-2 flex justify-between items-center gap-4" role="banner">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 group shrink-0" aria-label="<?php esc_attr_e( 'מטאדוק — דף הבית', 'metadoc' ); ?>">
		<img src="<?php echo esc_url( metadoc_logo_url() ); ?>" alt="<?php esc_attr_e( 'מטאדוק - נדל״ן, מימון, פיננסים', 'metadoc' ); ?>" width="260" height="100" class="h-14 md:h-16 w-auto object-contain transition-transform group-hover:scale-[1.04]" decoding="async" fetchpriority="high">
	</a>

	<nav class="md-nav hidden lg:flex flex-1 items-center justify-center gap-6" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'metadoc' ); ?>">
		<?php if ( $has_menu ) : ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex items-center gap-6',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		<?php endif; ?>
		<a href="<?php echo esc_url( $re_url ); ?>" class="md-nav-re">
			<?php echo esc_html( $re_label ); ?>
			<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-3.5' ) ); ?>
		</a>
	</nav>

	<div class="flex items-center gap-2 shrink-0">
		<a href="<?php echo esc_url( $re_url ); ?>" class="hidden sm:inline-flex lg:hidden items-center gap-1.5 text-sm font-bold text-neutral-800 border border-neutral-200 rounded-full px-4 py-2 hover:border-[#ff7a00] hover:text-[#ff7a00] transition">
			<?php echo esc_html( $re_label ); ?>
			<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-3.5' ) ); ?>
		</a>
		<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>" class="hidden md:inline-flex items-center gap-2 text-sm font-bold text-neutral-700 hover:text-neutral-900 transition">
			<?php metadoc_icon( 'phone', array( 'class' => 'size-4 text-[#ff7a00]' ) ); ?>
			<?php echo esc_html( $c['phone_display'] ); ?>
		</a>
		<a href="<?php echo esc_url( metadoc_form_url() ); ?>" class="md-btn text-white px-4 py-2 rounded-full text-sm font-extrabold flex items-center gap-1.5 shadow-sm bg-[#0a0a0a]">
			<?php metadoc_the_text( 'header_cta' ); ?>
			<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-3.5' ) ); ?>
		</a>
		<button type="button" id="md-nav-toggle" class="<?php echo esc_attr( $mobile_vis ); ?> size-10 grid place-items-center rounded-lg hover:bg-neutral-100 text-neutral-900" aria-expanded="false" aria-controls="md-mobile-nav" aria-label="<?php esc_attr_e( 'פתיחת תפריט', 'metadoc' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" class="size-6"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
		</button>
	</div>
</header>
<nav id="md-mobile-nav" hidden class="md-nav md-nav-mobile <?php echo esc_attr( $mobile_vis ); ?> relative z-40 bg-white border-b border-neutral-200 px-5 py-3 shadow-lg" aria-label="<?php esc_attr_e( 'תפריט מובייל', 'metadoc' ); ?>">
	<?php if ( $has_menu ) : ?>
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
	<?php endif; ?>
	<a href="<?php echo esc_url( $re_url ); ?>" class="md-nav-re">
		<?php esc_html_e( 'מחלקת נדל"ן והשקעות', 'metadoc' ); ?>
		<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-3.5' ) ); ?>
	</a>
</nav>
