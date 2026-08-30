<?php
/**
 * מחלקת נדל"ן — Hero: כותרת, שתי קריאות לפעולה, מסגרת מדיה עם נתונים
 * וכרטיס הזדמנויות מתחלף.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c = metadoc_contact();

$stats = array(
	array( '15+', __( 'שנות ניסיון בנדל"ן ומימון', 'metadoc' ) ),
	array( '800+', __( 'לקוחות מרוצים', 'metadoc' ) ),
	array( __( 'עשרות', 'metadoc' ), __( 'שותפי תיווך, כינוס ועיזבונות', 'metadoc' ) ),
	array( '360°', __( 'ליווי מלא — מאיתור ועד סגירה', 'metadoc' ) ),
);

/**
 * כרטיסי ההזדמנויות המתחלפים (תוכן לדוגמה).
 *
 * @param array $deals רשימת הכרטיסים.
 */
$deals = apply_filters(
	'metadoc_re_hero_deals',
	array(
		array(
			'kicker' => __( 'הזדמנות לדוגמה · דירה להשקעה', 'metadoc' ),
			'rows'   => array(
				array( __( '4 חד׳ · 96 מ"ר', 'metadoc' ), __( 'פתח תקווה', 'metadoc' ), false ),
				array( __( 'תשואה משוערת', 'metadoc' ), '4.1%', true ),
			),
		),
		array(
			'kicker' => __( 'הזדמנות לדוגמה · קרקע', 'metadoc' ),
			'rows'   => array(
				array( __( '480 מ"ר · מופשרת', 'metadoc' ), __( 'חריש', 'metadoc' ), false ),
				array( __( 'פוטנציאל השבחה', 'metadoc' ), __( 'גבוה', 'metadoc' ), true ),
			),
		),
		array(
			'kicker' => __( 'הזדמנות לדוגמה · פריסייל', 'metadoc' ),
			'rows'   => array(
				array( __( '24 יח"ד · לפני שיווק', 'metadoc' ), __( 'חדרה', 'metadoc' ), false ),
				array( __( 'הנחת רוכשים מוקדמים', 'metadoc' ), __( 'עד 8%', 'metadoc' ), true ),
			),
		),
		array(
			'kicker' => __( 'הזדמנות לדוגמה · נכס מניב', 'metadoc' ),
			'rows'   => array(
				array( __( '210 מ"ר · שוכר קיים', 'metadoc' ), __( 'אזור מסחרי', 'metadoc' ), false ),
				array( __( 'תשואה בפועל', 'metadoc' ), '6.3%', true ),
			),
		),
	)
);
?>
<section class="md-re-hero">
	<div class="md-re-hero-in">
		<div>
			<div class="md-re-kicker md-re-hin">
				<i aria-hidden="true"></i>
				<span><?php esc_html_e( 'מחלקת נדל"ן והשקעות · מעל 15 שנות ניסיון', 'metadoc' ); ?></span>
			</div>
			<h1 class="md-re-h1 md-re-hin md-re-hin-2">
				<?php esc_html_e( 'משקיעים בנדל"ן?', 'metadoc' ); ?><br>
				<span class="md-re-acc"><?php esc_html_e( 'אל תעשו את זה לבד.', 'metadoc' ); ?></span>
			</h1>
			<p class="md-re-hin md-re-hin-3"><?php esc_html_e( 'ליווי אישי וצמוד של משקיעים — מאיתור ההזדמנות, דרך הבדיקות והמשא ומתן, ועד סגירת העסקה והשבחת הנכס.', 'metadoc' ); ?></p>
			<div class="md-re-hero-cta md-re-hin md-re-hin-4">
				<a class="md-re-btn md-re-btn--grad" href="#projects">
					<span><?php esc_html_e( 'לכל הפרויקטים', 'metadoc' ); ?></span>
					<span aria-hidden="true" style="font-size:20px">←</span>
				</a>
				<a class="md-re-btn md-re-btn--ghost" href="tel:<?php echo esc_attr( $c['phone_tel'] ); ?>">
					<span><?php echo esc_html( $c['phone_display'] ); ?></span>
					<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M15.5 21A13.5 13.5 0 0 1 3 8.5 3.5 3.5 0 0 1 6.5 5c.6 0 1.1.4 1.3 1l1 3c.2.5 0 1-.4 1.3l-1 .8a10.5 10.5 0 0 0 5.5 5.5l.8-1c.3-.4.8-.6 1.3-.4l3 1c.6.2 1 .7 1 1.3A3.5 3.5 0 0 1 15.5 21z"></path></svg>
				</a>
			</div>
			<p class="md-re-hero-notes md-re-hin md-re-hin-5">
				<b aria-hidden="true">●</b><span><?php esc_html_e( 'ללא התחייבות', 'metadoc' ); ?></span>
				<b aria-hidden="true">●</b><span><?php esc_html_e( 'דיסקרטיות מלאה', 'metadoc' ); ?></span>
				<b aria-hidden="true">●</b><span><?php esc_html_e( 'מענה תוך 24ש׳', 'metadoc' ); ?></span>
			</p>
		</div>

		<div class="md-re-hero-media md-re-hin md-re-hin-6">
			<div class="md-re-frame">
				<?php
				metadoc_re_image(
					'hero',
					__( 'פרויקט נדל"ן בליווי מטאדוק', 'metadoc' ),
					__( 'תמונה פנורמית של פרויקט', 'metadoc' ),
					array(
						'dark'  => true,
						'eager' => true,
						'sizes' => '(max-width: 1220px) 100vw, 1220px',
					)
				);
				?>
				<div class="md-re-frame-veil" aria-hidden="true"></div>
				<div class="md-re-hstats">
					<?php foreach ( $stats as $stat ) : ?>
						<div class="md-re-hstat">
							<b><?php echo esc_html( $stat[0] ); ?></b>
							<span><?php echo esc_html( $stat[1] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="md-re-deal" data-md-deals role="group" aria-label="<?php esc_attr_e( 'הזדמנויות לדוגמה', 'metadoc' ); ?>">
				<?php foreach ( $deals as $i => $deal ) : ?>
					<div class="md-re-deal-card<?php echo 0 === $i ? ' is-on' : ''; ?>" data-md-deal<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>>
						<p class="md-re-deal-k"><?php echo esc_html( $deal['kicker'] ); ?></p>
						<?php foreach ( $deal['rows'] as $row ) : ?>
							<div class="md-re-deal-row">
								<span><?php echo esc_html( $row[0] ); ?></span>
								<b class="<?php echo $row[2] ? 'md-re-acc' : ''; ?>"><?php echo esc_html( $row[1] ); ?></b>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
