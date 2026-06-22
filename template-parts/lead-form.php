<?php
/**
 * LeadForm — טופס בדיקת זכאות ראשי.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c        = metadoc_contact();
$input    = 'w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3.5 focus:outline-none focus:border-[#ff7a00] focus:bg-white/10 placeholder:text-white/35 text-white transition-colors';
$label    = 'block text-[11px] mb-1.5 text-white/60 font-bold mr-1 tracking-wider uppercase';
$benefits = array( 'leadform_benefit_1', 'leadform_benefit_2', 'leadform_benefit_3', 'leadform_benefit_4' );
?>
<section id="form" class="bg-neutral-50 scroll-mt-20">
	<div class="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid md:grid-cols-12 gap-10 items-start">
		<div class="md:col-span-5">
			<?php
			metadoc_section_label( '07', metadoc_text( 'leadform_eyebrow' ) );
			metadoc_section_heading(
				sprintf(
					'%s<br /><span class="text-[#ff7a00]">%s</span>',
					esc_html( metadoc_text( 'leadform_title_1' ) ),
					esc_html( metadoc_text( 'leadform_title_2' ) )
				)
			);
			?>
			<p class="text-neutral-600 leading-relaxed text-[15px] md:text-base mt-5 mb-7 max-w-[42ch]"><?php metadoc_the_text( 'leadform_p' ); ?></p>
			<ul class="space-y-3 text-[14px] text-neutral-700">
				<?php foreach ( $benefits as $key ) : ?>
					<li class="flex items-center gap-2.5">
						<?php metadoc_icon( 'check', array( 'class' => 'size-4 shrink-0 text-[#ff7a00]' ) ); ?>
						<span class="font-medium"><?php metadoc_the_text( $key ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="md:col-span-7 w-full">
			<div class="bg-black text-white rounded-3xl px-6 md:px-10 py-8 md:py-10 shadow-2xl relative overflow-hidden border border-white/10">
				<div class="absolute -top-16 -left-16 w-60 h-60 rounded-full blur-3xl opacity-25 bg-[#ff7a00]" aria-hidden="true"></div>
				<div class="relative">
					<div class="text-[10px] font-bold tracking-[0.35em] uppercase mb-3 text-[#ff9a3c]"><?php metadoc_the_text( 'leadform_box_eyebrow' ); ?></div>
					<h2 class="text-2xl md:text-3xl font-bold mb-6 tracking-tight font-display"><?php metadoc_the_text( 'leadform_box_title' ); ?></h2>

					<form class="md-lead-form space-y-4" novalidate>
						<div class="grid sm:grid-cols-2 gap-4">
							<div>
								<label class="<?php echo esc_attr( $label ); ?>" for="lead-name"><?php esc_html_e( 'שם מלא', 'metadoc' ); ?></label>
								<input id="lead-name" name="name" type="text" required class="<?php echo esc_attr( $input ); ?>" placeholder="<?php esc_attr_e( 'ישראל ישראלי', 'metadoc' ); ?>" autocomplete="name">
							</div>
							<div>
								<label class="<?php echo esc_attr( $label ); ?>" for="lead-phone"><?php esc_html_e( 'טלפון', 'metadoc' ); ?></label>
								<input id="lead-phone" name="phone" type="tel" inputmode="tel" required class="<?php echo esc_attr( $input ); ?>" placeholder="<?php echo esc_attr( $c['phone_display'] ); ?>" autocomplete="tel">
							</div>
						</div>
						<div>
							<label class="<?php echo esc_attr( $label ); ?>" for="lead-note"><?php esc_html_e( 'פרטים נוספים (לא חובה)', 'metadoc' ); ?></label>
							<textarea id="lead-note" name="note" rows="3" class="<?php echo esc_attr( $input . ' resize-none' ); ?>" placeholder="<?php esc_attr_e( 'ספרו לנו בקצרה על המקרה שלכם', 'metadoc' ); ?>"></textarea>
						</div>
						<?php get_template_part( 'template-parts/form-extras', null, array( 'prefix' => 'lead' ) ); ?>
						<button type="submit" class="md-btn w-full text-black font-black py-4 rounded-xl text-lg disabled:opacity-60 flex items-center justify-center gap-2" style="background:linear-gradient(135deg, #ff7a00 0%, #ff9a3c 100%);box-shadow:0 16px 36px -10px #ff7a00b3">
							<span class="md-btn-label"><?php metadoc_the_text( 'leadform_btn' ); ?></span>
							<?php metadoc_icon( 'arrow-left', array( 'class' => 'size-5' ) ); ?>
						</button>
						<?php get_template_part( 'template-parts/form-honeypot' ); ?>
						<p class="md-form-status text-center text-[13px] font-bold" role="status" aria-live="polite"></p>
						<p class="text-[11px] text-center text-white/50 flex items-center justify-center gap-1.5">
							<?php metadoc_icon( 'shield-check', array( 'class' => 'size-3' ) ); ?>
							<?php esc_html_e( 'בלחיצה על השליחה אני מאשר/ת קבלת פנייה חוזרת.', 'metadoc' ); ?>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
