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
		// סקשן יחיד בשורש ה-Customizer (ללא פאנל) — הופעה אמינה ופשוטה.
		$wp_customize->add_section(
			'metadoc_settings_section',
			array(
				'title'       => __( 'מטאדוק — הגדרות', 'metadoc' ),
				'priority'    => 30,
				'description' => __( 'יעד לידים, פרטי שולח, Webhook, ומפתחות Cloudflare Turnstile. השאירו ריק כדי להשבית.', 'metadoc' ),
			)
		);

		$fields = array(
			'lead_email'           => array( 'label' => __( 'כתובת לקבלת הלידים', 'metadoc' ), 'sanitize' => 'sanitize_email' ),
			'from_name'            => array( 'label' => __( 'שם השולח (From)', 'metadoc' ), 'sanitize' => 'sanitize_text_field' ),
			'from_email'           => array( 'label' => __( 'כתובת השולח (From)', 'metadoc' ), 'sanitize' => 'sanitize_email' ),
			'webhook_url'          => array( 'label' => __( 'כתובת Webhook (אופציונלי)', 'metadoc' ), 'sanitize' => array( __CLASS__, 'sanitize_webhook' ) ),
			'turnstile_site_key'   => array( 'label' => __( 'Cloudflare Turnstile — Site Key', 'metadoc' ), 'sanitize' => 'sanitize_text_field' ),
			'turnstile_secret_key' => array( 'label' => __( 'Cloudflare Turnstile — Secret Key', 'metadoc' ), 'sanitize' => 'sanitize_text_field' ),
		);

		$priority = 10;
		foreach ( $fields as $key => $field ) {
			$id = self::OPTION . '[' . $key . ']';
			$wp_customize->add_setting(
				$id,
				array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => '',
					'sanitize_callback' => $field['sanitize'],
					'transport'         => 'refresh',
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'label'    => $field['label'],
					'section'  => 'metadoc_settings_section',
					'type'     => 'text',
					'priority' => $priority,
				)
			);
			$priority += 10;
		}
	}
}

Metadoc_Settings::init();
