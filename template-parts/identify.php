<?php
/**
 * Identify — זיהוי כאב הלקוח ("נשמע מוכר?").
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = array(
	__( 'הבקשה למשכנתא נדחתה', 'metadoc' ),
	__( 'סירוב מהבנק בגלל התנהלות חשבון', 'metadoc' ),
	__( "חזרו צ'קים או הוראות קבע בעבר", 'metadoc' ),
	__( 'דירוג האשראי פוגע בסיכויי האישור', 'metadoc' ),
	__( 'ריבוי הלוואות והחזרים חודשיים גבוהים', 'metadoc' ),
	__( 'אין מי שמוכן להילחם עבורכם', 'metadoc' ),
);
?>
<section class="bg-neutral-50 relative">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid md:grid-cols-12 gap-10 items-start">
		<div class="md:col-span-5 md:sticky md:top-24">
			<?php
			metadoc_section_label( '01', __( 'נשמע מוכר?', 'metadoc' ) );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>.',
					esc_html__( 'אם הגעתם לכאן —', 'metadoc' ),
					esc_html__( 'אתם לא לבד', 'metadoc' )
				)
			);
			?>
			<p class="text-neutral-600 leading-relaxed text-[15px] md:text-base max-w-[42ch] mt-5">
				<?php esc_html_e( 'אנחנו פוגשים מדי חודש אנשים טובים, עובדים ומתפרנסים, שנדחים פעם אחר פעם — למרות שיש להם נכס, הכנסה ויכולת החזר.', 'metadoc' ); ?>
			</p>
			<p class="text-neutral-600 leading-relaxed text-[15px] md:text-base max-w-[42ch] mt-3 font-semibold">
				<?php esc_html_e( 'אנחנו כאן כדי לפתוח דלתות גם כשנראה שאין סיכוי.', 'metadoc' ); ?>
			</p>
		</div>

		<ul class="md:col-span-7 grid sm:grid-cols-2 gap-3">
			<?php foreach ( $items as $i => $t ) : ?>
				<li class="group flex gap-4 items-start bg-white hover:border-neutral-900 border border-neutral-200 rounded-2xl px-5 py-4 transition-all hover:shadow-md">
					<span class="text-sm font-black tabular-nums text-neutral-300 group-hover:text-[#ff7a00] transition w-6 mt-0.5 font-display"><?php echo esc_html( '0' . ( $i + 1 ) ); ?></span>
					<span class="text-[15px] text-neutral-800 leading-snug font-medium flex-1"><?php echo esc_html( $t ); ?></span>
					<?php metadoc_icon( 'check', array( 'class' => 'size-5 mt-0.5 shrink-0 text-[#ff7a00]' ) ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
