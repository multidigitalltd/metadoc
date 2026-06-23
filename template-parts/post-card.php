<?php
/**
 * כרטיס פוסט לרשת הארכיון/בלוג. נקרא בתוך הלולאה.
 * תומך בקישור חיצוני (כתבה שפורסמה באתר אחר).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cats   = get_the_category();
$link   = metadoc_post_link();
$target = $link['external'] ? ' target="_blank" rel="noopener noreferrer"' : '';
?>
<article <?php post_class( 'group bg-white border border-neutral-200 rounded-2xl overflow-hidden flex flex-col hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.25)] hover:border-neutral-300 transition-all' ); ?>>
	<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- מחרוזת קבועה. ?> class="block overflow-hidden aspect-[16/10] bg-neutral-100" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105', 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="w-full h-full grid place-items-center text-neutral-300">
				<?php metadoc_icon( 'home', array( 'class' => 'size-10' ) ); ?>
			</span>
		<?php endif; ?>
	</a>
	<div class="p-6 flex flex-col flex-1">
		<div class="flex items-center gap-2 text-[11px] font-bold tracking-wide text-neutral-500 mb-3">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php if ( ! empty( $cats ) ) : ?>
				<span class="w-1 h-1 rounded-full bg-neutral-300"></span>
				<span class="text-[#d96a10]"><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
		</div>
		<h2 class="font-bold text-xl leading-tight tracking-tight text-neutral-900 font-display mb-2">
			<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- מחרוזת קבועה. ?> class="hover:text-[#d96a10] transition-colors"><?php the_title(); ?></a>
		</h2>
		<p class="text-[14px] text-neutral-600 leading-relaxed flex-1"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
		<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- מחרוזת קבועה. ?> class="inline-flex items-center gap-1.5 mt-4 text-[14px] font-extrabold text-neutral-900 group-hover:text-[#ff7a00] transition-colors">
			<?php echo $link['external'] ? esc_html__( 'לכתבה המלאה', 'metadoc' ) : esc_html__( 'קראו עוד', 'metadoc' ); ?>
			<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-4' ) ); ?>
		</a>
	</div>
</article>
