<?php
/**
 * SuccessBlock — סיפור הצלחה ו-CTA.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="bg-white">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
		<figure class="rounded-3xl overflow-hidden border border-neutral-200 shadow-[0_40px_80px_-30px_rgba(0,0,0,0.25)] grid md:grid-cols-2 bg-white">
			<div class="relative">
				<?php metadoc_image( 'family-home.jpg', __( 'משפחה מאושרת מקבלת מפתחות לבית חדש', 'metadoc' ), 1200, 896, 'w-full h-[280px] md:h-full object-cover' ); ?>
				<div class="absolute top-5 right-5 bg-black/85 backdrop-blur text-white text-[10px] font-bold tracking-[0.3em] uppercase px-3 py-1.5 rounded-full"><?php esc_html_e( 'סיפור הצלחה', 'metadoc' ); ?></div>
			</div>
			<div class="p-8 md:p-12 flex flex-col justify-center">
				<?php metadoc_section_label( '06', __( 'זה אפשרי', 'metadoc' ) ); ?>
				<h3 class="text-[2rem] md:text-[2.6rem] leading-[1.05] font-bold mb-5 text-neutral-900 tracking-tight font-display">
					<?php esc_html_e( 'הם כבר קיבלו את', 'metadoc' ); ?> <span class="text-[#ff7a00]"><?php esc_html_e( 'המפתחות', 'metadoc' ); ?></span>.<br>
					<?php esc_html_e( 'תורכם.', 'metadoc' ); ?>
				</h3>
				<p class="text-neutral-600 text-[15px] md:text-base leading-relaxed mb-6">
					<?php esc_html_e( 'מאות משפחות שכבר התייאשו מצאו אצלנו פתרון מימון אמיתי — וקיבלו את הבית, את ההלוואה ואת השקט הנפשי שמגיע להם.', 'metadoc' ); ?>
				</p>
				<a href="#form" class="md-btn self-start text-black px-6 py-3.5 rounded-xl text-base font-black flex items-center gap-2" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%);box-shadow:0 16px 36px -10px #ff7a00b3">
					<?php esc_html_e( 'בדקו את התיק שלכם', 'metadoc' ); ?>
					<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-4' ) ); ?>
				</a>
			</div>
		</figure>
	</div>
</section>
