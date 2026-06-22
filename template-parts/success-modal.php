<?php
/**
 * מודאל אישור שליחת טופס — מוצג ב-JS לאחר שליחה מוצלחת.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="md-success" hidden role="dialog" aria-modal="true" aria-labelledby="md-success-title" class="fixed inset-0 z-[80] grid place-items-center p-4">
	<div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-md-close></div>
	<div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 text-center md-reveal-pop">
		<div class="size-16 rounded-full grid place-items-center mx-auto mb-4" style="background:rgba(34,197,94,0.12)">
			<?php metadoc_icon( 'check', array( 'class' => 'size-9 text-[#16a34a]', 'stroke' => 2.5 ) ); ?>
		</div>
		<h2 id="md-success-title" class="text-2xl md:text-3xl font-black font-display mb-2 text-neutral-900"><?php esc_html_e( 'הפרטים נשלחו בהצלחה!', 'metadoc' ); ?></h2>
		<p class="text-neutral-600 text-[15px] leading-relaxed mb-6"><?php esc_html_e( 'מומחה מהצוות שלנו יחזור אליכם בהקדם, בדרך כלל תוך 24 שעות.', 'metadoc' ); ?></p>
		<button type="button" data-md-close class="md-btn w-full text-black font-black py-3.5 rounded-xl text-base" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%)">
			<?php esc_html_e( 'מצוין, תודה', 'metadoc' ); ?>
		</button>
	</div>
</div>
