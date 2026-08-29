<?php
/**
 * עמוד פרויקט — סרגל לידים קבוע בתחתית (פתוח כברירת מחדל) + וואטסאפ.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wa    = metadoc_re_whatsapp( __( 'היי, מעניין אותי פרויקט שער המפרץ', 'metadoc' ) );
$wa_ic = '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12.04 2C6.6 2 2.2 6.4 2.2 11.84c0 1.74.46 3.42 1.32 4.9L2 22l5.4-1.42a9.8 9.8 0 0 0 4.64 1.18h.01c5.43 0 9.84-4.4 9.84-9.84C21.89 6.4 17.48 2 12.04 2zm0 17.94h-.01a8.2 8.2 0 0 1-4.16-1.14l-.3-.18-3.2.84.86-3.12-.2-.32a8.13 8.13 0 0 1-1.25-4.34c0-4.52 3.68-8.2 8.21-8.2 2.19 0 4.25.86 5.8 2.4a8.14 8.14 0 0 1 2.4 5.8c0 4.53-3.68 8.26-8.15 8.26zm4.5-6.17c-.25-.13-1.46-.72-1.68-.8-.23-.08-.39-.13-.56.12-.16.25-.64.8-.79.97-.14.16-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.71-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.44-.06-.12-.56-1.34-.76-1.84-.2-.48-.4-.41-.56-.42h-.48c-.16 0-.43.06-.65.31-.23.25-.86.84-.86 2.05s.88 2.38 1 2.54c.13.17 1.73 2.64 4.2 3.7.59.26 1.04.4 1.4.52.59.19 1.12.16 1.55.1.47-.07 1.46-.6 1.66-1.17.21-.58.21-1.07.15-1.17-.06-.11-.23-.17-.48-.29z"></path></svg>';
?>
<aside class="md-re md-pr md-pr-fab" data-md-fab aria-label="<?php esc_attr_e( 'השארת פרטים ליצירת קשר', 'metadoc' ); ?>">
	<form class="md-lead-form" novalidate data-md-fab-form
		data-md-success="inline"
		data-md-success-label="<?php esc_attr_e( 'קיבלנו — נחזור אליכם ✓', 'metadoc' ); ?>">
		<div class="md-pr-fab-bar">
			<div class="md-pr-fab-lead">
				<b><?php esc_html_e( 'מעניין אתכם?', 'metadoc' ); ?></b>
				<span><?php esc_html_e( 'השאירו פרטים ונחזור אליכם', 'metadoc' ); ?></span>
			</div>
			<label class="md-re-sr" for="pr-fab-name"><?php esc_html_e( 'שם מלא', 'metadoc' ); ?></label>
			<input class="md-pr-fab-in md-pr-fab-name" id="pr-fab-name" name="name" type="text" required autocomplete="name" placeholder="<?php esc_attr_e( 'שם מלא', 'metadoc' ); ?>">
			<label class="md-re-sr" for="pr-fab-phone"><?php esc_html_e( 'טלפון', 'metadoc' ); ?></label>
			<input class="md-pr-fab-in md-pr-fab-phone" id="pr-fab-phone" name="phone" type="tel" inputmode="tel" required autocomplete="tel" placeholder="<?php esc_attr_e( 'טלפון', 'metadoc' ); ?>">
			<label class="md-re-sr" for="pr-fab-email"><?php esc_html_e( 'אימייל', 'metadoc' ); ?></label>
			<input class="md-pr-fab-in md-pr-fab-email" id="pr-fab-email" name="email" type="email" autocomplete="email" placeholder="<?php esc_attr_e( 'אימייל', 'metadoc' ); ?>">
			<?php get_template_part( 'template-parts/realestate/consent', null, array( 'id' => 'fab', 'compact' => true ) ); ?>
			<button type="submit" class="md-pr-fab-send">
				<span class="md-btn-label"><?php esc_html_e( 'שלחו', 'metadoc' ); ?></span>
			</button>
			<a class="md-pr-wa" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'שליחת הודעת וואטסאפ', 'metadoc' ); ?>">
				<?php echo $wa_ic; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG קבוע בקוד. ?>
			</a>
			<button type="button" class="md-pr-fab-x" data-md-fab-toggle aria-label="<?php esc_attr_e( 'סגירת הטופס', 'metadoc' ); ?>">×</button>
		</div>
		<?php get_template_part( 'template-parts/realestate/turnstile', null, array( 'light' => true ) ); ?>
		<?php get_template_part( 'template-parts/form-honeypot' ); ?>
		<p class="md-re-status md-form-status" role="status" aria-live="polite"></p>
	</form>

	<div class="md-pr-fab-mini" data-md-fab-mini hidden>
		<span><?php esc_html_e( 'מעניין אתכם הפרויקט? השאירו פרטים ונחזור אליכם', 'metadoc' ); ?></span>
		<div class="md-pr-fab-mini-side">
			<button type="button" class="md-pr-fab-open" data-md-fab-toggle><?php esc_html_e( 'השאירו פרטים', 'metadoc' ); ?></button>
			<a class="md-pr-wa md-pr-wa--round" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'שליחת הודעת וואטסאפ', 'metadoc' ); ?>">
				<?php echo $wa_ic; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG קבוע בקוד. ?>
			</a>
		</div>
	</div>
</aside>
