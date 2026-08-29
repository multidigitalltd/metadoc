<?php
/**
 * מחלקת נדל"ן — מועדון המשקיעים: מסגרת עם מסגרת גרדיאנט מסתובבת,
 * כרטיס חברות מרחף, רשימת הטבות וטופס הצטרפות.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$perks = array(
	array( 'I', __( 'גישה מוקדמת לעסקאות', 'metadoc' ), __( 'הזדמנויות נשלחות לחברי המועדון לפני שהן יוצאות לשוק הפתוח.', 'metadoc' ) ),
	array( 'II', __( 'עסקאות בלעדיות', 'metadoc' ), __( 'נכסים, קרקעות ופרויקטים שמגיעים אלינו ישירות ואינם מתפרסמים בכלל.', 'metadoc' ) ),
	array( 'III', __( 'ליווי אישי', 'metadoc' ), __( 'איש קשר אחד שמכיר את תיק ההשקעות שלכם ומסנן עבורכם רק את המתאים.', 'metadoc' ) ),
	array( 'IV', __( 'סקירות שוק', 'metadoc' ), __( 'ניתוח תשואות, אזורי ביקוש ומגמות תכנון — בלי רעש שיווקי.', 'metadoc' ) ),
);

$areas = array(
	__( 'דירות להשקעה', 'metadoc' ),
	__( 'קרקעות', 'metadoc' ),
	__( 'נכסים מניבים / מסחר', 'metadoc' ),
	__( 'כינוס נכסים ועיזבונות', 'metadoc' ),
);

$card_img = METADOC_URI . '/assets/img/re/club-hand.webp';
$logo_img = METADOC_URI . '/assets/img/re/metadoc-logo-full.png';
?>
<section id="club" class="md-re-club">
	<div class="md-re-ring" data-md-ring>
		<div class="md-re-club-frame">
			<div class="md-re-glow" data-md-glow aria-hidden="true"></div>
			<div class="md-re-club-hair" aria-hidden="true"></div>

			<div class="md-re-club-head" data-reveal>
				<div class="md-re-members">
					<i aria-hidden="true"></i>
					<span>MEMBERS ONLY</span>
					<i aria-hidden="true"></i>
				</div>
				<h2 class="md-re-club-title">
					<?php esc_html_e( 'מועדון המשקיעים', 'metadoc' ); ?>
					<span class="md-re-acc"><?php esc_html_e( 'של מטאדוק', 'metadoc' ); ?></span>
				</h2>
				<p><?php esc_html_e( 'חוג מצומצם של משקיעים שמקבלים את ההזדמנויות ראשונים — עסקאות, קרקעות ופרויקטים חדשים מגיעים אליכם לפני שהם מתפרסמים לקהל הרחב.', 'metadoc' ); ?></p>
			</div>

			<div class="md-re-club-grid" data-reveal>
				<div class="md-re-card-wrap">
					<div class="md-re-card-halo" aria-hidden="true"></div>
					<div class="md-re-card-float">
						<img src="<?php echo esc_url( $card_img ); ?>" width="800" height="1000" alt="<?php esc_attr_e( 'כרטיס חבר מועדון המשקיעים של מטאדוק', 'metadoc' ); ?>" loading="lazy" decoding="async">
						<div class="md-re-card-logo" aria-hidden="true">
							<img src="<?php echo esc_url( $logo_img ); ?>" width="841" height="323" alt="" loading="lazy" decoding="async">
							<img class="md-re-ghost" src="<?php echo esc_url( $logo_img ); ?>" width="841" height="323" alt="" loading="lazy" decoding="async">
						</div>
						<div class="md-re-card-clip" aria-hidden="true">
							<div class="md-re-card-glare"></div>
						</div>
					</div>
				</div>

				<div class="md-re-perks">
					<?php foreach ( $perks as $perk ) : ?>
						<div class="md-re-perk">
							<span aria-hidden="true"><?php echo esc_html( $perk[0] ); ?></span>
							<div>
								<h3><?php echo esc_html( $perk[1] ); ?></h3>
								<p><?php echo esc_html( $perk[2] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
					<p class="md-re-perks-note"><?php esc_html_e( 'החברות ללא עלות · מוגבלת בהיקף', 'metadoc' ); ?></p>
				</div>

				<div class="md-re-club-form">
					<h3><?php esc_html_e( 'בקשת הצטרפות', 'metadoc' ); ?></h3>
					<p><?php esc_html_e( 'נחזור אליכם לאישור החברות ולהתאמת סוג ההזדמנויות.', 'metadoc' ); ?></p>
					<form class="md-lead-form" novalidate data-md-success="inline" data-md-success-label="<?php esc_attr_e( '✓ נרשמתם — ההזדמנות הראשונה בדרך', 'metadoc' ); ?>">
						<div class="md-re-club-fields">
							<div>
								<label class="md-re-sr" for="club-name"><?php esc_html_e( 'שם מלא', 'metadoc' ); ?></label>
								<input class="md-re-cfield" id="club-name" name="name" type="text" required autocomplete="name" placeholder="<?php esc_attr_e( 'שם מלא', 'metadoc' ); ?>">
							</div>
							<div>
								<label class="md-re-sr" for="club-phone"><?php esc_html_e( 'טלפון או אימייל', 'metadoc' ); ?></label>
								<input class="md-re-cfield" id="club-phone" name="phone" type="text" required autocomplete="tel" data-md-dual placeholder="<?php esc_attr_e( 'טלפון / אימייל', 'metadoc' ); ?>">
							</div>
							<div>
								<label class="md-re-sr" for="club-area"><?php esc_html_e( 'תחום ההשקעה המבוקש', 'metadoc' ); ?></label>
								<select class="md-re-cfield" id="club-area" name="area" data-md-note="<?php esc_attr_e( 'תחום השקעה', 'metadoc' ); ?>">
									<option value=""><?php esc_html_e( 'תחום ההשקעה המבוקש', 'metadoc' ); ?></option>
									<?php foreach ( $areas as $area ) : ?>
										<option value="<?php echo esc_attr( $area ); ?>"><?php echo esc_html( $area ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php get_template_part( 'template-parts/realestate/consent', null, array( 'id' => 'club', 'dark' => true ) ); ?>
							<?php get_template_part( 'template-parts/realestate/turnstile' ); ?>
							<button type="submit" class="md-re-btn md-re-btn--pill">
								<span class="md-btn-label"><?php esc_html_e( 'הצטרפו למועדון ←', 'metadoc' ); ?></span>
							</button>
						</div>
						<?php get_template_part( 'template-parts/form-honeypot' ); ?>
						<p class="md-re-status md-form-status" role="status" aria-live="polite"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
