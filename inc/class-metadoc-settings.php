<?php
/**
 * הגדרות התבנית — תחת "התאמה אישית" (Customizer).
 * מאוחסן באופציה אחת (metadoc_settings) ונקרא דרך Metadoc_Settings::get().
 * כולל: יעד מייל לידים, פרטי שולח, Webhook, ומפתחות Cloudflare Turnstile.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Settings
 */
final class Metadoc_Settings {

	private const OPTION = 'metadoc_settings';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'customize_register', array( __CLASS__, 'customize' ) );
	}

	/**
	 * מחזיר ערך הגדרה מהאופציה.
	 *
	 * @param string $key           מפתח.
	 * @param string $default_value ברירת מחדל.
	 * @return string
	 */
	public static function get( string $key, string $default_value = '' ): string {
		$opts = get_option( self::OPTION, array() );
		return ( is_array( $opts ) && isset( $opts[ $key ] ) ) ? (string) $opts[ $key ] : $default_value;
	}

	/**
	 * האם Turnstile מופעל (קיים site key).
	 *
	 * @return bool
	 */
	public static function turnstile_enabled(): bool {
		return '' !== self::get( 'turnstile_site_key' );
	}

	/**
	 * סניטציה לכתובת Webhook (http/https בלבד).
	 *
	 * @param string $value קלט.
	 * @return string
	 */
	public static function sanitize_webhook( $value ): string {
		return esc_url_raw( trim( (string) $value ), array( 'http', 'https' ) );
	}

	/**
	 * רישום פאנל, סקשנים ובקרות ב-Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize מנהל ה-Customizer.
	 */
	public static function customize( $wp_customize ): void {
		$wp_customize->add_panel(
			'metadoc_panel',
			array(
				'title'    => __( 'מטאדוק — הגדרות', 'metadoc' ),
				'priority' => 30,
			)
		);

		// --- סקשן לידים ---
		$wp_customize->add_section(
			'metadoc_leads',
			array(
				'title'       => __( 'טופס לידים', 'metadoc' ),
				'panel'       => 'metadoc_panel',
				'description' => __( 'יעד הפניות, פרטי השולח, ו-Webhook אופציונלי.', 'metadoc' ),
			)
		);

		$fields = array(
			'lead_email' => array(
				'label'    => __( 'כתובת לקבלת הלידים', 'metadoc' ),
				'section'  => 'metadoc_leads',
				'sanitize' => 'sanitize_email',
				'type'     => 'email',
			),
			'from_name'  => array(
				'label'    => __( 'שם השולח (From)', 'metadoc' ),
				'section'  => 'metadoc_leads',
				'sanitize' => 'sanitize_text_field',
				'type'     => 'text',
			),
			'from_email' => array(
				'label'    => __( 'כתובת השולח (From)', 'metadoc' ),
				'section'  => 'metadoc_leads',
				'sanitize' => 'sanitize_email',
				'type'     => 'email',
			),
			'webhook_url' => array(
				'label'    => __( 'כתובת Webhook (אופציונלי)', 'metadoc' ),
				'section'  => 'metadoc_leads',
				'sanitize' => array( __CLASS__, 'sanitize_webhook' ),
				'type'     => 'url',
			),
			'turnstile_site_key' => array(
				'label'    => __( 'Turnstile Site Key', 'metadoc' ),
				'section'  => 'metadoc_turnstile',
				'sanitize' => 'sanitize_text_field',
				'type'     => 'text',
			),
			'turnstile_secret_key' => array(
				'label'    => __( 'Turnstile Secret Key', 'metadoc' ),
				'section'  => 'metadoc_turnstile',
				'sanitize' => 'sanitize_text_field',
				'type'     => 'text',
			),
		);

		// --- סקשן Turnstile ---
		$wp_customize->add_section(
			'metadoc_turnstile',
			array(
				'title'       => __( 'Cloudflare Turnstile (CAPTCHA)', 'metadoc' ),
				'panel'       => 'metadoc_panel',
				'description' => __( 'הזינו מפתחות מחשבון Cloudflare כדי להפעיל CAPTCHA על הטפסים. ריק = מושבת.', 'metadoc' ),
			)
		);

		foreach ( $fields as $key => $field ) {
			$id = self::OPTION . '[' . $key . ']';
			$wp_customize->add_setting(
				$id,
				array(
					'type'              => 'option',
					'capability'        => 'manage_options',
					'default'           => '',
					'sanitize_callback' => $field['sanitize'],
					'transport'         => 'refresh',
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'label'   => $field['label'],
					'section' => $field['section'],
					'type'    => $field['type'],
				)
			);
		}
	}
}

Metadoc_Settings::init();
