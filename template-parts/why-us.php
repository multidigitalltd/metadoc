<?php
/**
 * WhyUs — למה דווקא מטאדוק.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$points = array(
	array( 't' => __( 'ניסיון של מעל 15 שנים', 'metadoc' ), 'd' => __( 'ידע מעשי בטיפול בתיקים מורכבים ובמקרים שנדחו בעבר על ידי שני בנקים ויותר.', 'metadoc' ) ),
	array( 't' => __( 'נלחמים על כל לקוח', 'metadoc' ), 'd' => __( 'לא מסתפקים בתשובה הראשונה. ממשיכים לבדוק עד שמוצאים את הפתרון הנכון.', 'metadoc' ) ),
	array( 't' => __( 'מומחיות במקרים מורכבים', 'metadoc' ), 'd' => __( 'לקוחות בעלי אתגרי אשראי, סירובי בנקים, BDI שלילי ותיקים חריגים.', 'metadoc' ) ),
	array( 't' => __( 'ליווי אישי וצמוד', 'metadoc' ), 'd' => __( 'איש קשר אחד שמכיר את התיק שלכם לעומק, מההתחלה ועד לחתימה.', 'metadoc' ) ),
	array( 't' => __( 'מאות לקוחות מרוצים', 'metadoc' ), 'd' => __( 'אנשים שכבר היו בטוחים שאין להם פתרון – וקיבלו הזדמנות נוספת.', 'metadoc' ) ),
	array( 't' => __( 'שקיפות מלאה', 'metadoc' ), 'd' => __( 'אתם תמיד יודעים בדיוק איפה התיק עומד, מה הצעדים הבאים והעלויות הצפויות.', 'metadoc' ) ),
);
?>
<section class="bg-white">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
		<div class="max-w-3xl mb-12 md:mb-16">
			<?php
			metadoc_section_label( '04', __( 'למה דווקא מטאדוק', 'metadoc' ) );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>.',
					esc_html__( 'כי הניסיון', 'metadoc' ),
					esc_html__( 'עושה את ההבדל', 'metadoc' )
				)
			);
			?>
		</div>

		<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-neutral-200 border border-neutral-200 rounded-3xl overflow-hidden">
			<?php foreach ( $points as $i => $p ) : ?>
				<div class="md-card-hover md-reveal group bg-white p-7 md:p-9 hover:bg-neutral-50 hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.35)] flex flex-col" style="animation-delay:<?php echo esc_attr( (string) ( $i * 90 ) ); ?>ms">
					<div class="flex items-baseline gap-3 mb-4">
						<div class="text-3xl md:text-4xl font-black tabular-nums leading-none font-display text-[#ff7a00]"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
						<div class="h-px flex-1 bg-neutral-200 group-hover:bg-[#ff7a00] transition-colors"></div>
					</div>
					<h3 class="font-bold text-2xl md:text-[1.75rem] leading-[1.1] mb-3 text-neutral-900 tracking-tight font-display"><?php echo esc_html( $p['t'] ); ?></h3>
					<p class="text-[14px] md:text-[15px] text-neutral-600 leading-relaxed"><?php echo esc_html( $p['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
