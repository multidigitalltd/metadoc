<?php
/**
 * Solution — הצגת הפתרון (רקע כהה).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="bg-black text-white relative overflow-hidden">
	<div class="absolute top-0 right-0 w-80 h-80 rounded-full blur-[120px] opacity-20 bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="absolute -bottom-20 -left-20 w-[24rem] h-[24rem] rounded-full blur-[140px] opacity-15 bg-[#ff7a00]" aria-hidden="true"></div>

	<div class="absolute -left-6 top-1/2 -translate-y-1/2 opacity-[0.06] pointer-events-none select-none" aria-hidden="true">
		<img src="<?php echo esc_url( metadoc_logo_url() ); ?>" alt="" width="600" height="220" class="w-[24rem] md:w-[30rem] lg:w-[36rem] h-auto object-contain" style="filter:drop-shadow(0 0 30px #ff7a00cc) drop-shadow(0 0 60px #ff7a0099)" loading="lazy" decoding="async">
	</div>

	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid md:grid-cols-12 gap-10 items-center relative">
		<figure class="md:col-span-6 rounded-3xl overflow-hidden border border-white/10 relative group order-2 md:order-1 shadow-[0_40px_80px_-20px_rgba(0,0,0,0.6)]">
			<?php metadoc_image( 'handshake.jpg', __( 'יועץ משכנתאות לוחץ ידיים עם לקוח', 'metadoc' ), 1024, 1024, 'w-full h-[300px] md:h-[460px] object-cover transition-transform duration-700 group-hover:scale-105' ); ?>
			<div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none">
				<img src="<?php echo esc_url( metadoc_logo_url() ); ?>" alt="" width="600" height="220" class="w-[70%] h-auto object-contain opacity-[0.08]" style="filter:drop-shadow(0 0 20px #ff7a0099)" loading="lazy" decoding="async">
			</div>
			<div class="absolute inset-x-0 bottom-0 p-5 bg-gradient-to-t from-black via-black/50 to-transparent">
				<div class="text-[10px] uppercase tracking-[0.3em] font-bold text-[#ff9a3c]"><?php esc_html_e( 'שותפים · לא ספקים', 'metadoc' ); ?></div>
			</div>
		</figure>

		<div class="md:col-span-6 order-1 md:order-2">
			<?php
			metadoc_section_label( '02', __( 'הפתרון', 'metadoc' ), true );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>.',
					esc_html__( 'פתרונות המימון שלנו מתאימים במיוחד', 'metadoc' ),
					esc_html__( 'למצבים כאלו', 'metadoc' )
				),
				'text-white'
			);
			?>
			<div class="space-y-5 text-[15px] md:text-[16px] text-white/75 leading-relaxed mt-6">
				<p><?php esc_html_e( 'במשך יותר מ-15 שנים אנו מלווים לקוחות במצבים מורכבים מול גופי המימון והבנקים — כאלה שכבר שמעו "לא" יותר מפעם אחת.', 'metadoc' ); ?></p>
				<p><?php esc_html_e( 'אנחנו בוחנים כל תיק לעומק, מזהים את החסמים האמיתיים, בונים אסטרטגיית מימון יצירתית ומלווים אתכם לאורך כל הדרך עד החתימה.', 'metadoc' ); ?></p>
				<p class="text-white font-bold border-r-2 pr-5 text-[19px] md:text-[24px] leading-relaxed font-display" style="border-color:#ff7a00">
					<?php esc_html_e( 'המטרה שלנו פשוטה: למצות עבורכם את כל האפשרויות הקיימות', 'metadoc' ); ?>
					<br>
					<?php esc_html_e( 'ולהביא לפתרון המימון המתאים ביותר.', 'metadoc' ); ?>
				</p>
			</div>
		</div>
	</div>
</section>
