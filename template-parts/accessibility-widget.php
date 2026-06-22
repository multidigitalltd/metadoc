<?php
/**
 * ווידג'ט נגישות (ת"י 5568 / WCAG 2.2).
 * המצבים מנוהלים ב-main.js ונשמרים ב-localStorage.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * כפתורי ההגדרות: [data-a11y => תווית].
 *
 * @var array<string,string> $toggles
 */
$toggles = array(
	'text-bigger'        => __( 'הגדלת טקסט', 'metadoc' ),
	'text-smaller'       => __( 'הקטנת טקסט', 'metadoc' ),
	'contrast'           => __( 'ניגודיות גבוהה', 'metadoc' ),
	'invert'             => __( 'היפוך צבעים', 'metadoc' ),
	'grayscale'          => __( 'גווני אפור', 'metadoc' ),
	'links'              => __( 'הדגשת קישורים', 'metadoc' ),
	'highlight-headings' => __( 'הדגשת כותרות', 'metadoc' ),
	'readable'           => __( 'גופן קריא', 'metadoc' ),
	'stop-anim'          => __( 'עצירת אנימציות', 'metadoc' ),
	'reading-guide'      => __( 'סרגל קריאה', 'metadoc' ),
);
?>
<div class="md-reading-guide" aria-hidden="true"></div>

<div id="md-a11y" class="fixed bottom-24 md:bottom-6 right-4 md:right-6 z-[55]">
	<button type="button" id="md-a11y-toggle" aria-expanded="false" aria-controls="md-a11y-panel" aria-label="<?php esc_attr_e( 'פתיחת תפריט נגישות', 'metadoc' ); ?>" class="size-14 rounded-full bg-[#1a4fd6] text-white grid place-items-center shadow-[0_8px_24px_rgba(26,79,214,0.4)] hover:scale-105 active:scale-95 transition">
		<?php metadoc_icon( 'accessibility', array( 'class' => 'size-7' ) ); ?>
	</button>

	<div id="md-a11y-panel" role="dialog" aria-modal="false" aria-label="<?php esc_attr_e( 'הגדרות נגישות', 'metadoc' ); ?>" hidden class="absolute bottom-16 right-0 w-72 max-w-[85vw] bg-white text-neutral-900 rounded-2xl shadow-2xl border border-neutral-200 p-4">
		<div class="flex items-center justify-between mb-3">
			<h2 class="text-sm font-black font-display"><?php esc_html_e( 'הגדרות נגישות', 'metadoc' ); ?></h2>
			<button type="button" id="md-a11y-close" aria-label="<?php esc_attr_e( 'סגירה', 'metadoc' ); ?>" class="size-8 grid place-items-center rounded-lg hover:bg-neutral-100">
				<?php metadoc_icon( 'x', array( 'class' => 'size-5' ) ); ?>
			</button>
		</div>
		<div class="grid grid-cols-2 gap-2">
			<?php foreach ( $toggles as $key => $labeltext ) : ?>
				<button type="button" data-a11y="<?php echo esc_attr( $key ); ?>" aria-pressed="false" class="md-a11y-btn text-[12px] font-bold border border-neutral-200 rounded-xl px-2 py-2.5 hover:border-[#1a4fd6] hover:bg-blue-50 transition text-center">
					<?php echo esc_html( $labeltext ); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<button type="button" id="md-a11y-reset" class="mt-3 w-full text-[12px] font-black text-white bg-neutral-900 rounded-xl py-2.5 hover:bg-neutral-700 transition">
			<?php esc_html_e( 'איפוס הגדרות', 'metadoc' ); ?>
		</button>
		<a href="<?php echo esc_url( home_url( '/accessibility-statement/' ) ); ?>" class="mt-2 block text-center text-[11px] text-neutral-500 underline hover:text-neutral-800">
			<?php esc_html_e( 'הצהרת נגישות', 'metadoc' ); ?>
		</a>
	</div>
</div>
