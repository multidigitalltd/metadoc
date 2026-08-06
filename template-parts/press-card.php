<?php
/**
 * כרטיס "כתבה בתקשורת" — מקשר לכתבה החיצונית בלשונית חדשה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pid    = get_the_ID();
$pc_url = Metadoc_Press::url( $pid );
$pc_src = Metadoc_Press::source( $pid );
if ( '' === $pc_url ) {
	$pc_url = get_permalink( $pid );
}
?>
<article <?php post_class( 'group bg-white border border-neutral-200 rounded-2xl overflow-hidden flex flex-col hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.25)] hover:border-neutral-300 transition-all' ); ?>>
	<a href="<?php echo esc_url( $pc_url ); ?>" target="_blank" rel="noopener noreferrer" class="block overflow-hidden aspect-[16/10] bg-neutral-100 relative" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105', 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="w-full h-full grid place-items-center text-neutral-300">
				<?php metadoc_icon( 'external-link', array( 'class' => 'size-9' ) ); ?>
			</span>
		<?php endif; ?>
		<span class="absolute top-3 left-3 bg-black/80 text-white rounded-full p-2 backdrop-blur">
			<?php metadoc_icon( 'external-link', array( 'class' => 'size-4' ) ); ?>
		</span>
	</a>
	<div class="p-6 flex flex-col flex-1">
		<div class="flex items-center gap-2 text-[11px] font-bold tracking-wide text-neutral-500 mb-3">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php if ( '' !== $pc_src ) : ?>
				<span class="w-1 h-1 rounded-full bg-neutral-300"></span>
				<span class="text-[#d96a10]"><?php echo esc_html( $pc_src ); ?></span>
			<?php endif; ?>
		</div>
		<h2 class="font-bold text-xl leading-tight tracking-tight text-neutral-900 font-display mb-2">
			<a href="<?php echo esc_url( $pc_url ); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#d96a10] transition-colors"><?php the_title(); ?></a>
		</h2>
		<?php if ( has_excerpt() ) : ?>
			<p class="text-[14px] text-neutral-600 leading-relaxed flex-1"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
		<?php endif; ?>
		<a href="<?php echo esc_url( $pc_url ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 mt-4 text-[14px] font-extrabold text-neutral-900 group-hover:text-[#ff7a00] transition-colors">
			<?php esc_html_e( 'לכתבה המלאה', 'metadoc' ); ?>
			<?php metadoc_icon( 'external-link', array( 'class' => 'size-4' ) ); ?>
		</a>
	</div>
</article>
