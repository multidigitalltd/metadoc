<?php
/**
 * מחלקת נדל"ן — תחומי התמחות (ארבעה סוגי נכסים).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$svg = 'width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';

$types = array(
	array(
		'icon'  => '<path d="M4 20h16"></path><path d="M6 20V6.5L13 4v16"></path><path d="M13 10h5v10"></path><path d="M8.5 8.5h2"></path><path d="M8.5 12h2"></path><path d="M8.5 15.5h2"></path><path d="M15.5 13.5h1"></path>',
		'title' => __( 'דירות להשקעה', 'metadoc' ),
		'sub'   => __( 'מגורים, יד ראשונה ושנייה', 'metadoc' ),
		'foot'  => __( 'ליווי מלא עד המסירה', 'metadoc' ),
	),
	array(
		'icon'  => '<path d="M3 17.5 12 21l9-3.5"></path><path d="M4.5 8.5h15v6h-15z"></path><path d="M4.5 11.5h15"></path><path d="M12 8.5v6"></path><path d="M12 5.5V3"></path>',
		'title' => __( 'קרקעות', 'metadoc' ),
		'sub'   => __( 'חקלאית, מופשרת ובתכנון', 'metadoc' ),
		'foot'  => __( 'בדיקת סטטוס תכנוני', 'metadoc' ),
	),
	array(
		'icon'  => '<path d="M4 20h16"></path><path d="M5 20v-9h14v9"></path><path d="M3.5 11 5 6.5h14L20.5 11z"></path><path d="M9 20v-5h6v5"></path>',
		'title' => __( 'נכסים מניבים', 'metadoc' ),
		'sub'   => __( 'מסחר, משרדים ולוגיסטיקה', 'metadoc' ),
		'foot'  => __( 'ניתוח תשואה ושוכרים', 'metadoc' ),
	),
	array(
		'icon'  => '<path d="M5.5 3.5h9l4 4v13h-13z"></path><path d="M14 3.5v4h4"></path><path d="M8 10.5h4"></path><circle cx="14.5" cy="15.5" r="2.8"></circle><path d="M13.4 18l-.6 2.6 1.7-.9 1.7.9-.6-2.6"></path>',
		'title' => __( 'כינוס ועיזבונות', 'metadoc' ),
		'sub'   => __( 'הזדמנויות מתחת למחיר השוק', 'metadoc' ),
		'foot'  => __( 'גישה מוקדמת דרך שותפינו', 'metadoc' ),
	),
);
?>
<section class="md-re-assets">
	<div class="md-re-in">
		<div class="md-re-assets-head">
			<div>
				<p class="md-re-eyebrow"><?php esc_html_e( 'תחומי התמחות', 'metadoc' ); ?></p>
				<h2><?php esc_html_e( 'באילו נכסים אנחנו מתמחים', 'metadoc' ); ?></h2>
			</div>
			<a class="md-re-ghost-pill" href="#projects"><?php esc_html_e( 'לפרויקטים הפעילים ←', 'metadoc' ); ?></a>
		</div>
		<div class="md-re-asset-panel" data-reveal>
			<?php foreach ( $types as $type ) : ?>
				<div class="md-re-asset">
					<span class="md-re-asset-ico"><svg <?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- מחרוזת מאפיינים קבועה. ?>><?php echo $type['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG קבוע בקוד. ?></svg></span>
					<div>
						<h3><?php echo esc_html( $type['title'] ); ?></h3>
						<p><?php echo esc_html( $type['sub'] ); ?></p>
					</div>
					<div class="md-re-asset-foot"><?php echo esc_html( $type['foot'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
