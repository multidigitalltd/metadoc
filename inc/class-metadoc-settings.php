<?php
/**
 * עמוד הגדרות התבנית — מפתחות Cloudflare Turnstile (CAPTCHA לטופס).
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
	private const GROUP  = 'metadoc_settings_group';
	private const PAGE   = 'metadoc-settings';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
	}

	/**
	 * מחזיר ערך הגדרה.
	 *
	 * @param string $key   מפתח.
	 * @param string $default_value ברירת מחדל.
	 * @return string
	 */
	public static function get( string $key, string $default_value = '' ): string {
		$opts = get_option( self::OPTION, array() );
		return isset( $opts[ $key ] ) ? (string) $opts[ $key ] : $default_value;
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
	 * רישום תפריט עליון "מטאדוק" בלוח הבקרה.
	 */
	public static function menu(): void {
		add_menu_page(
			__( 'הגדרות מטאדוק', 'metadoc' ),
			__( 'מטאדוק', 'metadoc' ),
			'manage_options',
			self::PAGE,
			array( __CLASS__, 'render' ),
			'dashicons-admin-settings',
			26
		);
	}

	/**
	 * רישום ההגדרות (Settings API).
	 */
	public static function register(): void {
		register_setting(
			self::GROUP,
			self::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize' ),
				'default'           => array(),
			)
		);

		// סקשן לידים — יעד מייל, שולח, Webhook.
		add_settings_section( 'metadoc_leads', __( 'טופס לידים', 'metadoc' ), array( __CLASS__, 'section_leads' ), self::PAGE );
		add_settings_field( 'lead_email', __( 'כתובת לקבלת הלידים', 'metadoc' ), array( __CLASS__, 'field_text' ), self::PAGE, 'metadoc_leads', array( 'key' => 'lead_email', 'type' => 'email', 'placeholder' => 'office@metadoc.co.il' ) );
		add_settings_field( 'from_name', __( 'שם השולח (From)', 'metadoc' ), array( __CLASS__, 'field_text' ), self::PAGE, 'metadoc_leads', array( 'key' => 'from_name', 'placeholder' => get_bloginfo( 'name' ) ) );
		add_settings_field( 'from_email', __( 'כתובת השולח (From)', 'metadoc' ), array( __CLASS__, 'field_text' ), self::PAGE, 'metadoc_leads', array( 'key' => 'from_email', 'type' => 'email', 'placeholder' => 'no-reply@' . wp_parse_url( home_url(), PHP_URL_HOST ) ) );
		add_settings_field( 'webhook_url', __( 'כתובת Webhook (אופציונלי)', 'metadoc' ), array( __CLASS__, 'field_text' ), self::PAGE, 'metadoc_leads', array( 'key' => 'webhook_url', 'type' => 'url', 'placeholder' => 'https://...' ) );

		// סקשן Turnstile.
		add_settings_section( 'metadoc_turnstile', __( 'Cloudflare Turnstile (CAPTCHA)', 'metadoc' ), array( __CLASS__, 'section_intro' ), self::PAGE );
		add_settings_field( 'turnstile_site_key', __( 'Site Key', 'metadoc' ), array( __CLASS__, 'field_text' ), self::PAGE, 'metadoc_turnstile', array( 'key' => 'turnstile_site_key' ) );
		add_settings_field( 'turnstile_secret_key', __( 'Secret Key', 'metadoc' ), array( __CLASS__, 'field_text' ), self::PAGE, 'metadoc_turnstile', array( 'key' => 'turnstile_secret_key', 'secret' => true ) );
	}

	/**
	 * סניטציה של ההגדרות.
	 *
	 * @param mixed $input קלט גולמי.
	 * @return array
	 */
	public static function sanitize( $input ): array {
		$input = is_array( $input ) ? $input : array();
		return array(
			'lead_email'           => isset( $input['lead_email'] ) ? sanitize_email( $input['lead_email'] ) : '',
			'from_name'            => isset( $input['from_name'] ) ? sanitize_text_field( $input['from_name'] ) : '',
			'from_email'           => isset( $input['from_email'] ) ? sanitize_email( $input['from_email'] ) : '',
			'webhook_url'          => isset( $input['webhook_url'] ) ? esc_url_raw( trim( (string) $input['webhook_url'] ), array( 'http', 'https' ) ) : '',
			'turnstile_site_key'   => isset( $input['turnstile_site_key'] ) ? sanitize_text_field( $input['turnstile_site_key'] ) : '',
			'turnstile_secret_key' => isset( $input['turnstile_secret_key'] ) ? sanitize_text_field( $input['turnstile_secret_key'] ) : '',
		);
	}

	/**
	 * תיאור סקשן הלידים.
	 */
	public static function section_leads(): void {
		echo '<p>' . esc_html__( 'קביעת כתובת לקבלת פניות מהטופס, פרטי השולח, ושליחת Webhook אופציונלי לכל ליד.', 'metadoc' ) . '</p>';
	}

	/**
	 * תיאור הסקשן.
	 */
	public static function section_intro(): void {
		echo '<p>' . esc_html__( 'הזינו את מפתחות Turnstile מחשבון Cloudflare כדי להפעיל הגנת CAPTCHA על טפסי האתר. השאירו ריק כדי להשבית.', 'metadoc' ) . '</p>';
	}

	/**
	 * שדה טקסט.
	 *
	 * @param array $args ארגומנטים.
	 */
	public static function field_text( array $args ): void {
		$key         = (string) ( $args['key'] ?? '' );
		$secret      = ! empty( $args['secret'] );
		$type        = $secret ? 'password' : (string) ( $args['type'] ?? 'text' );
		$placeholder = (string) ( $args['placeholder'] ?? '' );
		$value       = self::get( $key );
		printf(
			'<input type="%1$s" name="%2$s[%3$s]" value="%4$s" placeholder="%5$s" class="regular-text" autocomplete="off" />',
			esc_attr( $type ),
			esc_attr( self::OPTION ),
			esc_attr( $key ),
			esc_attr( $value ),
			esc_attr( $placeholder )
		);
	}

	/**
	 * רינדור עמוד ההגדרות.
	 */
	public static function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( self::GROUP );
				do_settings_sections( self::PAGE );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}

Metadoc_Settings::init();
