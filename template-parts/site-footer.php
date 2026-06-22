<?php
/**
 * Footer — פרטי התקשרות, שעות וזכויות + Schema.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c       = metadoc_contact();
$privacy = metadoc_privacy_url();

$schema = array(
	'@context'    => 'https://schema.org',
	'@type'       => 'FinancialService',
	'name'        => 'מטאדוק',
	'description' => 'פתרונות מימון ומשכנתאות לבעלי נכסים מסורבי בנקים.',
	'url'         => home_url( '/' ),
	'telephone'   => '+972-' . ltrim( $c['phone_tel'], '0' ),
	'email'       => $c['email'],
	'address'     => array(
		'@type'           => 'PostalAddress',
		'streetAddress'   => 'הדובדבן 9',
		'addressLocality' => 'קריית אונו',
		'addressCountry'  => 'IL',
	),
	'openingHours' => array( 'Su-Th 09:00-18:00', 'Fr 09:00-13:00' ),
);
?>
<footer class="bg-black border-t border-white/10 text-white" role="contentinfo">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-12 md:py-14 grid md:grid-cols-4 gap-8">
		<div class="md:col-span-1">
			<img src="<?php echo esc_url( metadoc_logo_url() ); ?>" alt="<?php esc_attr_e( 'מטאדוק', 'metadoc' ); ?>" width="180" height="64" class="h-14 w-auto object-contain bg-white/95 rounded-xl p-2 mb-4 inline-block" loading="lazy" decoding="async">
			<p class="text-white/60 text-sm leading-relaxed max-w-[34ch]"><?php esc_html_e( 'פתרונות מימון יצירתיים לבעלי נכסים שהבנקים אמרו להם "לא".', 'metadoc' ); ?></p>
		</div>
		<div>
			<h2 class="text-[10px] font-bold tracking-[0.3em] uppercase text-white/40 mb-4"><?php esc_html_e( 'צרו קשר', 'metadoc' ); ?></h2>
			<div class="space-y-3 text-[14px]">
				<a href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>" class="flex items-center gap-2 text-white/80 hover:text-white transition-colors">
					<?php metadoc_icon( 'phone', array( 'class' => 'size-4 text-[#ff7a00]' ) ); ?> <?php echo esc_html( $c['phone_display'] ); ?>
				</a>
				<a href="mailto:<?php echo esc_attr( $c['email'] ); ?>" class="flex items-center gap-2 text-white/80 hover:text-white transition-colors break-all">
					<?php metadoc_icon( 'mail', array( 'class' => 'size-4 shrink-0 text-[#ff7a00]' ) ); ?> <?php echo esc_html( $c['email'] ); ?>
				</a>
				<a href="<?php echo esc_url( $c['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-white/80 hover:text-white transition-colors">
					<?php metadoc_icon( 'message-circle', array( 'class' => 'size-4 text-[#ff7a00]' ) ); ?> <?php esc_html_e( 'WhatsApp', 'metadoc' ); ?>
				</a>
			</div>
		</div>
		<div>
			<h2 class="text-[10px] font-bold tracking-[0.3em] uppercase text-white/40 mb-4"><?php esc_html_e( 'כתובת', 'metadoc' ); ?></h2>
			<div class="flex items-start gap-2 text-[14px] text-white/70">
				<?php metadoc_icon( 'map-pin', array( 'class' => 'size-4 mt-0.5 shrink-0 text-[#ff7a00]' ) ); ?>
				<span><?php echo esc_html( $c['address'] ); ?></span>
			</div>
		</div>
		<div>
			<h2 class="text-[10px] font-bold tracking-[0.3em] uppercase text-white/40 mb-4"><?php esc_html_e( 'שעות פעילות', 'metadoc' ); ?></h2>
			<div class="text-[14px] text-white/70 space-y-1">
				<div><?php echo esc_html( $c['hours_week'] ); ?></div>
				<div><?php echo esc_html( $c['hours_fri'] ); ?></div>
			</div>
		</div>
	</div>
	<div class="border-t border-white/10">
		<div class="max-w-7xl mx-auto px-6 md:px-10 py-5 text-[11px] text-white/40 flex flex-wrap gap-3 justify-between items-center">
			<p>&copy; <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> <?php esc_html_e( 'מטאדוק. כל הזכויות שמורות.', 'metadoc' ); ?></p>
			<nav class="flex flex-wrap gap-3 items-center" aria-label="<?php esc_attr_e( 'קישורי תחתית', 'metadoc' ); ?>">
				<a href="<?php echo esc_url( home_url( '/accessibility-statement/' ) ); ?>" class="hover:text-white transition-colors"><?php esc_html_e( 'הצהרת נגישות', 'metadoc' ); ?></a>
				<?php if ( $privacy ) : ?>
					<a href="<?php echo esc_url( $privacy ); ?>" class="hover:text-white transition-colors"><?php esc_html_e( 'מדיניות פרטיות', 'metadoc' ); ?></a>
				<?php endif; ?>
				<span><?php esc_html_e( 'מתן ההלוואה בכפוף לאישור הגוף המממן.', 'metadoc' ); ?></span>
			</nav>
		</div>
	</div>
	<div class="border-t border-white/10">
		<div class="max-w-7xl mx-auto px-6 md:px-10 py-4 text-center text-[11px] text-white/40">
			UX/UI &amp; Dev by
			<a href="https://m-d.co.il/" target="_blank" rel="noopener noreferrer" class="font-bold text-white/70 hover:text-[#ff7a00] transition-colors">Multi Digital</a>
		</div>
	</div>
</footer>
<script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
