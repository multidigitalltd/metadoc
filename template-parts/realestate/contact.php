<?php
/**
 * מחלקת נדל"ן — יצירת קשר: פרטי המשרד + טופס פנייה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();

$promises = array(
	__( 'בדיקה ראשונית מקצועית', 'metadoc' ),
	__( 'ליווי אישי וצמוד לאורך כל הדרך', 'metadoc' ),
	__( 'ניסיון של מעל 15 שנים', 'metadoc' ),
	__( 'דיסקרטיות מוחלטת', 'metadoc' ),
	__( 'ללא התחייבות · מענה תוך 24 שעות', 'metadoc' ),
);

$areas = array(
	__( 'דירות להשקעה', 'metadoc' ),
	__( 'קרקעות', 'metadoc' ),
	__( 'נכסים מניבים / מסחר', 'metadoc' ),
	__( 'כינוס נכסים ועיזבונות', 'metadoc' ),
	__( 'עוד לא בטוח — נדבר', 'metadoc' ),
);
?>
<section id="contact" class="md-re-contact">
	<div class="md-re-contact-in" data-reveal>
		<div class="md-re-contact-head">
			<div>
				<p class="md-re-eyebrow"><?php esc_html_e( '06 / דברו איתנו', 'metadoc' ); ?></p>
				<h2><?php esc_html_e( 'נאפיין יחד את ההשקעה', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'המתאימה לכם.', 'metadoc' ); ?></span></h2>
			</div>
			<p><?php esc_html_e( 'השאירו פרטים ומומחה נדל"ן מהצוות שלנו יחזור אליכם תוך 24 שעות לשיחת ייעוץ ראשונית — חינם וללא התחייבות.', 'metadoc' ); ?></p>
		</div>

		<div class="md-re-contact-grid">
			<div>
				<div class="md-re-contact-rows">
					<a class="md-re-crow" href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>">
						<span class="md-re-crow-ico md-re-crow-ico--acc" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M15.5 21A13.5 13.5 0 0 1 3 8.5 3.5 3.5 0 0 1 6.5 5c.6 0 1.1.4 1.3 1l1 3c.2.5 0 1-.4 1.3l-1 .8a10.5 10.5 0 0 0 5.5 5.5l.8-1c.3-.4.8-.6 1.3-.4l3 1c.6.2 1 .7 1 1.3A3.5 3.5 0 0 1 15.5 21z"></path></svg>
						</span>
						<span>
							<span class="md-re-crow-k"><?php esc_html_e( 'טלפון', 'metadoc' ); ?></span>
							<span class="md-re-crow-v md-re-crow-v--big"><?php echo esc_html( $c['phone_display'] ); ?></span>
						</span>
					</a>
					<div class="md-re-crow">
						<span class="md-re-crow-ico" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11z"></path><circle cx="12" cy="10" r="2.6"></circle></svg>
						</span>
						<span>
							<span class="md-re-crow-k"><?php esc_html_e( 'משרד', 'metadoc' ); ?></span>
							<span class="md-re-crow-v"><?php echo esc_html( $c['address'] ); ?></span>
						</span>
					</div>
					<div class="md-re-crow">
						<span class="md-re-crow-ico" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="12" r="8.5"></circle><path d="M12 7.5V12l3 1.8"></path></svg>
						</span>
						<span>
							<span class="md-re-crow-k"><?php esc_html_e( 'שעות מענה', 'metadoc' ); ?></span>
							<span class="md-re-crow-v"><?php echo esc_html( $c['hours_week'] ); ?></span>
						</span>
					</div>
				</div>
				<ul class="md-re-promises">
					<?php foreach ( $promises as $promise ) : ?>
						<li><b aria-hidden="true">✓</b><?php echo esc_html( $promise ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="md-re-contact-card">
				<form class="md-lead-form" novalidate data-md-success="inline" data-md-success-label="<?php esc_attr_e( 'הפרטים נשלחו — נחזור אליכם בהקדם', 'metadoc' ); ?>">
					<div class="md-re-contact-fields">
						<div>
							<label class="md-re-label" for="re-contact-name"><?php esc_html_e( 'שם מלא', 'metadoc' ); ?></label>
							<input class="md-re-field" id="re-contact-name" name="name" type="text" required autocomplete="name" placeholder="<?php esc_attr_e( 'הקלידו את שמכם', 'metadoc' ); ?>">
						</div>
						<div>
							<label class="md-re-label" for="re-contact-phone"><?php esc_html_e( 'טלפון', 'metadoc' ); ?></label>
							<input class="md-re-field" id="re-contact-phone" name="phone" type="tel" inputmode="tel" required autocomplete="tel" placeholder="050-0000000">
						</div>
						<div class="md-re-wide">
							<label class="md-re-label" for="re-contact-area"><?php esc_html_e( 'תחום ההשקעה', 'metadoc' ); ?></label>
							<select class="md-re-field" id="re-contact-area" name="area" data-md-note="<?php esc_attr_e( 'תחום השקעה', 'metadoc' ); ?>">
								<?php foreach ( $areas as $area ) : ?>
									<option value="<?php echo esc_attr( $area ); ?>"><?php echo esc_html( $area ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="md-re-wide">
							<label class="md-re-label" for="re-contact-note">
								<?php esc_html_e( 'במה תרצו להשקיע?', 'metadoc' ); ?> <i><?php esc_html_e( '(לא חובה)', 'metadoc' ); ?></i>
							</label>
							<textarea class="md-re-field" id="re-contact-note" name="note" rows="3" placeholder="<?php esc_attr_e( 'תקציב, אזור מועדף, או כל דבר שחשוב שנדע', 'metadoc' ); ?>"></textarea>
						</div>
						<div class="md-re-wide">
							<?php get_template_part( 'template-parts/realestate/consent', null, array( 'id' => 'contact', 'dark' => true ) ); ?>
							<?php get_template_part( 'template-parts/realestate/turnstile' ); ?>
						</div>
					</div>
					<div class="md-re-contact-foot">
						<span class="md-re-note"><?php esc_html_e( 'הפרטים נשמרים אצלנו בלבד.', 'metadoc' ); ?></span>
						<button type="submit" class="md-re-btn md-re-btn--pill">
							<span class="md-btn-label"><?php esc_html_e( 'שלחו לתיאום שיחה', 'metadoc' ); ?></span>
						</button>
					</div>
					<?php get_template_part( 'template-parts/form-honeypot' ); ?>
					<p class="md-re-status md-form-status" role="status" aria-live="polite"></p>
				</form>
			</div>
		</div>
	</div>
</section>
