<?php
/**
 * WhoIsItFor — קהלי יעד.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$audiences = array(
	array( 'icon' => 'home', 't' => __( 'דירה ראשונה', 'metadoc' ), 'd' => __( 'זוגות צעירים ומשפחות שרוכשים נכס ראשון וצריכים ליווי מקצועי', 'metadoc' ) ),
	array( 'icon' => 'building-2', 't' => __( 'מחזור משכנתא', 'metadoc' ), 'd' => __( 'בעלי נכס קיים שרוצים לשפר תנאים, להוריד ריבית או למשוך הון', 'metadoc' ) ),
	array( 'icon' => 'landmark', 't' => __( 'נדחו על ידי הבנק', 'metadoc' ), 'd' => __( 'מי שסבל מסירוב בנקאי וזקוק למומחה שיודע איך לפתוח דלתות', 'metadoc' ) ),
	array( 'icon' => 'briefcase', 't' => __( 'עצמאיים ובעלי עסקים', 'metadoc' ), 'd' => __( 'לקוחות עם הכנסה משתנה שבנקים רואים בה כאתגר', 'metadoc' ) ),
	array( 'icon' => 'trending-down', 't' => __( 'ריבוי התחייבויות', 'metadoc' ), 'd' => __( 'בעלי הלוואות וחובות מרובים המעונינים לאחד הלוואות ולשפר את ההחזרים', 'metadoc' ) ),
	array( 'icon' => 'wallet', 't' => __( 'נכס להשקעה', 'metadoc' ), 'd' => __( 'מי שמעוניין לרכוש דירה להשקעה וזקוק למסלול מימון מתאים', 'metadoc' ) ),
);
?>
<section class="bg-white relative overflow-hidden">
	<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[36rem] h-[36rem] rounded-full blur-[160px] opacity-[0.06] bg-[#ff7a00]" aria-hidden="true"></div>
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 relative">
		<div class="max-w-3xl mb-12 md:mb-16">
			<?php
			metadoc_section_label( '03', __( 'למי מתאים השירות', 'metadoc' ) );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>',
					esc_html__( 'אם יש לכם נכס או אתם בתהליך רכישה —', 'metadoc' ),
					esc_html__( 'אתם מתאימים!', 'metadoc' )
				)
			);
			?>
		</div>

		<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
			<?php foreach ( $audiences as $i => $a ) : ?>
				<div class="md-card-hover md-reveal group bg-neutral-50 border border-neutral-200 rounded-2xl p-6 md:p-7 hover:bg-white hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.2)] hover:border-neutral-300 flex flex-col" style="animation-delay:<?php echo esc_attr( (string) ( $i * 90 ) ); ?>ms">
					<div class="size-12 rounded-xl grid place-items-center mb-4 border" style="background:rgba(255,122,0,0.08);border-color:rgba(255,122,0,0.25)">
						<?php metadoc_icon( $a['icon'], array( 'class' => 'size-6 text-[#ff7a00]', 'stroke' => 1.6 ) ); ?>
					</div>
					<h3 class="font-bold text-xl md:text-2xl leading-[1.1] mb-2 text-neutral-900 tracking-tight font-display"><?php echo esc_html( $a['t'] ); ?></h3>
					<p class="text-[14px] md:text-[15px] text-neutral-600 leading-relaxed"><?php echo esc_html( $a['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
