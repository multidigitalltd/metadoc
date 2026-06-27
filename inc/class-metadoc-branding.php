<?php
/**
 * מיתוג לוח הבקרה — לוגו מטאדוק במסך ההתחברות ובסרגל הניהול.
 * משתמש באותו לוגו של האתר (custom-logo / קובץ התבנית).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Branding
 */
final class Metadoc_Branding {

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'login_enqueue_scripts', array( __CLASS__, 'login_logo' ) );
		add_filter( 'login_headerurl', array( __CLASS__, 'login_url' ) );
		add_filter( 'login_headertext', array( __CLASS__, 'login_text' ) );
		add_action( 'admin_bar_menu', array( __CLASS__, 'admin_bar_logo' ), 11 );
		add_action( 'wp_dashboard_setup', array( __CLASS__, 'support_widget' ) );
	}

	/** דוא"ל התמיכה של Multi Digital. */
	private const SUPPORT_EMAIL = 'service@multidigital.co.il';

	/**
	 * רישום ווידג'ט "תמיכה ושירות" בלוח הבקרה.
	 */
	public static function support_widget(): void {
		wp_add_dashboard_widget( 'metadoc_support', __( 'תמיכה ושירות', 'metadoc' ), array( __CLASS__, 'support_widget_content' ) );
	}

	/**
	 * תוכן ווידג'ט התמיכה — מעוצב, עם Escaping מלא.
	 */
	public static function support_widget_content(): void {
		$socials = array(
			'Facebook'  => 'https://www.facebook.com/multidigitalltd',
			'WhatsApp'  => 'https://www.whatsapp.com/channel/0029VaKs05JInlqRWEMgLn0B',
			'Instagram' => 'https://www.instagram.com/multi_digital_ltd/',
			'YouTube'   => 'https://www.youtube.com/channel/UC1HbeK10vkhrfGvoHnNPrfA',
		);
		?>
		<style>
			#metadoc_support .inside{margin:0;padding:0}
			.md-support{background:linear-gradient(135deg,#fcbd12 0%,#ee3472 100%);color:#fff;padding:16px 18px;border-radius:6px;line-height:1.6}
			.md-support a{color:#fff}
			.md-support p{margin:0 0 12px}
			.md-support .md-support-btn{display:inline-block;background:#0a0a0a;color:#fff;padding:8px 16px;border-radius:999px;font-weight:700;text-decoration:none}
			.md-support .md-support-links a{font-weight:600;text-decoration:underline;white-space:nowrap}
		</style>
		<div class="md-support">
			<p>
				<?php
				printf(
					/* translators: %s: Multi Digital link. */
					esc_html__( 'האתר שלך פותח על ידי %s — ויש לו בית!', 'metadoc' ),
					'<a href="https://m-d.co.il" target="_blank" rel="noopener noreferrer"><strong>Multi Digital</strong></a>'
				);
				?>
			</p>
			<p>
				<a class="md-support-btn" href="mailto:<?php echo esc_attr( self::SUPPORT_EMAIL ); ?>"><?php esc_html_e( 'לקבלת שירות לחצו כאן', 'metadoc' ); ?></a>
			</p>
			<p>
				<?php esc_html_e( 'או במייל:', 'metadoc' ); ?>
				<a href="mailto:<?php echo esc_attr( self::SUPPORT_EMAIL ); ?>"><?php echo esc_html( self::SUPPORT_EMAIL ); ?></a>
			</p>
			<p class="md-support-links">
				<?php esc_html_e( 'טיפים לניהול אתרים — עקבו אחרינו:', 'metadoc' ); ?><br>
				<?php
				$items = array();
				foreach ( $socials as $label => $url ) {
					$items[] = '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $label ) . '</a>';
				}
				echo implode( ' · ', $items ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- כל פריט עבר esc_url/esc_html.
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * לוגו במסך ההתחברות.
	 */
	public static function login_logo(): void {
		$logo = metadoc_logo_url();
		printf(
			'<style>.login h1 a{background-image:url(%s)!important;background-size:contain;background-position:center;width:100%%;height:72px}</style>',
			esc_url( $logo )
		);
	}

	/**
	 * קישור הלוגו במסך ההתחברות → דף הבית.
	 *
	 * @return string
	 */
	public static function login_url(): string {
		return home_url( '/' );
	}

	/**
	 * טקסט חלופי ללוגו ההתחברות.
	 *
	 * @return string
	 */
	public static function login_text(): string {
		return get_bloginfo( 'name' );
	}

	/**
	 * החלפת לוגו וורדפרס בסרגל הניהול בלוגו מטאדוק.
	 *
	 * @param WP_Admin_Bar $bar סרגל הניהול.
	 */
	public static function admin_bar_logo( $bar ): void {
		if ( ! is_admin_bar_showing() ) {
			return;
		}
		$bar->remove_node( 'wp-logo' );
		$bar->add_node(
			array(
				'id'    => 'metadoc-logo',
				'title' => '<img src="' . esc_url( metadoc_logo_url() ) . '" alt="" style="height:20px;width:auto;padding:6px 0" />',
				'href'  => admin_url(),
				'meta'  => array( 'title' => get_bloginfo( 'name' ) ),
			)
		);
	}
}

Metadoc_Branding::init();
