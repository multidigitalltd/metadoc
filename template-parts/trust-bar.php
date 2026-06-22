<?php
/**
 * סרגל אמון — נתוני ניסיון והצלחה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = array(
	array( 'icon' => 'clock', 'n' => '+15', 't' => __( 'מעל 15 שנות ניסיון', 'metadoc' ) ),
	array( 'icon' => 'users', 'n' => '+800', 't' => __( 'לקוחות מרוצים', 'metadoc' ) ),
	array( 'icon' => 'award', 'n' => '94%', 't' => __( 'אחוזי הצלחה', 'metadoc' ) ),
	array( 'icon' => 'shield-check', 'n' => '100%', 't' => __( 'דיסקרטיות', 'metadoc' ) ),
);
?>
<section class="bg-white border-b border-neutral-200">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-6 md:py-8 grid grid-cols-2 md:grid-cols-4 gap-6">
		<?php foreach ( $stats as $s ) : ?>
			<div class="flex items-center gap-3">
				<div class="size-11 rounded-xl grid place-items-center shrink-0 border border-neutral-200" style="background:#fff7ee">
					<?php metadoc_icon( $s['icon'], array( 'class' => 'size-5 text-[#ff7a00]' ) ); ?>
				</div>
				<div class="min-w-0">
					<div class="text-xl md:text-2xl font-black leading-none text-neutral-900 font-display"><?php echo esc_html( $s['n'] ); ?></div>
					<div class="text-[11px] md:text-xs font-semibold text-neutral-500 tracking-wide mt-1"><?php echo esc_html( $s['t'] ); ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
