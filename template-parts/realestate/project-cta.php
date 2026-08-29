<?php
/**
 * עמוד פרויקט — 05 / קריאה לפעולה סוגרת + טופס קביעת פגישה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c     = metadoc_contact();
$slots = array(
	__( 'בוקר (09:00–12:00)', 'metadoc' ),
	__( 'צהריים (12:00–15:00)', 'metadoc' ),
	__( 'אחר הצהריים (15:00–18:00)', 'metadoc' ),
	__( 'שיחת זום', 'metadoc' ),
);
?>
<section id="interest" class="md-pr-cta">
	<div class="md-pr-cta-grid md-pr-split">
		<div>
			<h2 data-rv>
				<?php esc_html_e( 'מבינים את הפוטנציאל?', 'metadoc' ); ?><br>
				<span class="md-re-acc"><?php esc_html_e( 'בואו להיות חלק מההצלחה.', 'metadoc' ); ?></span>
			</h2>
			<p><?php esc_html_e( 'השאירו טלפון ומייל, נקבע פגישה ונעבור יחד על התיק המלא — נסח החלקה, המצב התכנוני ולוחות הזמנים למימוש.', 'metadoc' ); ?></p>
			<div class="md-pr-cta-rows">
				<a class="md-pr-cta-row md-pr-cta-tel" href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>">
					<span class="md-pr-cta-ico md-pr-cta-ico--acc" aria-hidden="true">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M15.5 21A13.5 13.5 0 0 1 3 8.5 3.5 3.5 0 0 1 6.5 5c.6 0 1.1.4 1.3 1l1 3c.2.5 0 1-.4 1.3l-1 .8a10.5 10.5 0 0 0 5.5 5.5l.8-1c.3-.4.8-.6 1.3-.4l3 1c.6.2 1 .7 1 1.3A3.5 3.5 0 0 1 15.5 21z"></path></svg>
					</span>
					<span><?php echo esc_html( $c['phone_display'] ); ?></span>
				</a>
				<div class="md-pr-cta-row">
					<span class="md-pr-cta-ico" aria-hidden="true">
						<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="12" r="8.5"></circle><path d="M12 7.5V12l3 1.8"></path></svg>
					</span>
					<span><?php esc_html_e( 'מענה בתוך יום עסקים', 'metadoc' ); ?></span>
				</div>
			</div>
		</div>

		<div class="md-pr-book" data-rv>
			<h3><?php esc_html_e( 'קביעת פגישה', 'metadoc' ); ?></h3>
			<p><?php esc_html_e( 'נחזור אליכם לתיאום מועד — פגישה במשרד או שיחת זום.', 'metadoc' ); ?></p>
			<form class="md-lead-form" novalidate data-md-success="inline" data-md-success-label="<?php esc_attr_e( 'קיבלנו — נחזור אליכם ✓', 'metadoc' ); ?>">
				<div class="md-pr-book-fields">
					<div>
						<label class="md-re-sr" for="pr-book-name"><?php esc_html_e( 'שם מלא', 'metadoc' ); ?></label>
						<input class="md-pr-input" id="pr-book-name" name="name" type="text" required autocomplete="name" placeholder="<?php esc_attr_e( 'שם מלא', 'metadoc' ); ?>">
					</div>
					<div>
						<label class="md-re-sr" for="pr-book-phone"><?php esc_html_e( 'טלפון', 'metadoc' ); ?></label>
						<input class="md-pr-input" id="pr-book-phone" name="phone" type="tel" inputmode="tel" required autocomplete="tel" placeholder="<?php esc_attr_e( 'טלפון', 'metadoc' ); ?>">
					</div>
					<div>
						<label class="md-re-sr" for="pr-book-email"><?php esc_html_e( 'אימייל', 'metadoc' ); ?></label>
						<input class="md-pr-input" id="pr-book-email" name="email" type="email" autocomplete="email" placeholder="<?php esc_attr_e( 'אימייל', 'metadoc' ); ?>">
					</div>
					<div>
						<label class="md-re-sr" for="pr-book-slot"><?php esc_html_e( 'מועד מועדף לפגישה', 'metadoc' ); ?></label>
						<select class="md-pr-input" id="pr-book-slot" name="slot" data-md-note="<?php esc_attr_e( 'מועד מועדף', 'metadoc' ); ?>">
							<option value=""><?php esc_html_e( 'מועד מועדף לפגישה', 'metadoc' ); ?></option>
							<?php foreach ( $slots as $slot ) : ?>
								<option value="<?php echo esc_attr( $slot ); ?>"><?php echo esc_html( $slot ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<?php get_template_part( 'template-parts/realestate/consent', null, array( 'id' => 'book' ) ); ?>
					<?php get_template_part( 'template-parts/realestate/turnstile', null, array( 'light' => true ) ); ?>
					<button type="submit" class="md-re-btn md-re-btn--grad">
						<span class="md-btn-label"><?php esc_html_e( 'קבעו לי פגישה', 'metadoc' ); ?></span>
					</button>
				</div>
				<?php get_template_part( 'template-parts/form-honeypot' ); ?>
				<p class="md-re-status md-form-status" role="status" aria-live="polite"></p>
			</form>
		</div>
	</div>
</section>
