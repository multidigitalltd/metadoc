<?php
/**
 * הגדרות לכל-עמוד לעמודי נחיתה / קמפיין:
 * טלפון מותאם, והסתרת כפתור וואטסאפ ו/או כתובת המייל — בלי לשכפל קבצים.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Landing
 */
final class Metadoc_Landing {

	private const NONCE         = 'metadoc_landing_meta';
	private const HIDE_WHATSAPP = '_md_hide_whatsapp';
	private const HIDE_EMAIL    = '_md_hide_email';
	private const PHONE_DISPLAY = '_md_phone_display';
	private const PHONE_TEL     = '_md_phone_tel';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
		add_action( 'save_post_page', array( __CLASS__, 'save' ) );
		add_filter( 'metadoc_text', array( __CLASS__, 'filter_phone' ), 10, 2 );
	}

	/**
	 * רישום תיבת המטא בעמודים.
	 */
	public static function meta_box(): void {
		add_meta_box(
			'metadoc_landing',
			__( 'הגדרות עמוד נחיתה / קמפיין', 'metadoc' ),
			array( __CLASS__, 'render' ),
			'page',
			'side',
			'default'
		);
	}

	/**
	 * רינדור התיבה.
	 *
	 * @param WP_Post $post העמוד.
	 */
	public static function render( WP_Post $post ): void {
		$hide_wa  = (string) get_post_meta( $post->ID, self::HIDE_WHATSAPP, true );
		$hide_em  = (string) get_post_meta( $post->ID, self::HIDE_EMAIL, true );
		$ph_disp  = (string) get_post_meta( $post->ID, self::PHONE_DISPLAY, true );
		$ph_tel   = (string) get_post_meta( $post->ID, self::PHONE_TEL, true );
		wp_nonce_field( self::NONCE, self::NONCE . '_field' );
		?>
		<p style="margin:0 0 10px;color:#666;font-size:12px">
			<?php esc_html_e( 'חל על עמוד עם תבנית "עמוד נחיתה מטאדוק". מאפשר טלפון אחר והסתרת וואטסאפ/מייל — ללא שכפול קבצים.', 'metadoc' ); ?>
		</p>
		<p>
			<label><input type="checkbox" name="<?php echo esc_attr( self::HIDE_WHATSAPP ); ?>" value="1" <?php checked( '1', $hide_wa ); ?>>
			<?php esc_html_e( 'הסתר כפתור וואטסאפ צף', 'metadoc' ); ?></label>
		</p>
		<p>
			<label><input type="checkbox" name="<?php echo esc_attr( self::HIDE_EMAIL ); ?>" value="1" <?php checked( '1', $hide_em ); ?>>
			<?php esc_html_e( 'הסתר כתובת מייל (בפוטר)', 'metadoc' ); ?></label>
		</p>
		<p style="margin-top:12px">
			<label for="md_phone_display"><strong><?php esc_html_e( 'טלפון לתצוגה (אופציונלי)', 'metadoc' ); ?></strong></label>
			<input type="text" id="md_phone_display" name="<?php echo esc_attr( self::PHONE_DISPLAY ); ?>" value="<?php echo esc_attr( $ph_disp ); ?>" class="widefat" placeholder="03-000-0000">
		</p>
		<p>
			<label for="md_phone_tel"><strong><?php esc_html_e( 'טלפון לחיוג (ספרות בלבד)', 'metadoc' ); ?></strong></label>
			<input type="text" id="md_phone_tel" name="<?php echo esc_attr( self::PHONE_TEL ); ?>" value="<?php echo esc_attr( $ph_tel ); ?>" class="widefat" placeholder="030000000">
		</p>
		<p style="margin:0;color:#666;font-size:12px">
			<?php esc_html_e( 'השאירו ריק כדי להשתמש בטלפון הראשי של האתר.', 'metadoc' ); ?>
		</p>
		<?php
	}

	/**
	 * שמירה.
	 *
	 * @param int $post_id מזהה.
	 */
	public static function save( int $post_id ): void {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$nonce = isset( $_POST[ self::NONCE . '_field' ] ) ? sanitize_text_field( wp_unslash( $_POST[ self::NONCE . '_field' ] ) ) : '';
		if ( ! $nonce || ! wp_verify_nonce( $nonce, self::NONCE ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		self::save_checkbox( $post_id, self::HIDE_WHATSAPP );
		self::save_checkbox( $post_id, self::HIDE_EMAIL );

		$disp = isset( $_POST[ self::PHONE_DISPLAY ] ) ? sanitize_text_field( wp_unslash( $_POST[ self::PHONE_DISPLAY ] ) ) : '';
		$tel  = isset( $_POST[ self::PHONE_TEL ] ) ? preg_replace( '/[^0-9]/', '', (string) wp_unslash( $_POST[ self::PHONE_TEL ] ) ) : '';
		'' !== $disp ? update_post_meta( $post_id, self::PHONE_DISPLAY, $disp ) : delete_post_meta( $post_id, self::PHONE_DISPLAY );
		'' !== $tel ? update_post_meta( $post_id, self::PHONE_TEL, $tel ) : delete_post_meta( $post_id, self::PHONE_TEL );
	}

	/**
	 * שמירת צ'קבוק בודד.
	 *
	 * @param int    $post_id מזהה.
	 * @param string $key     מפתח מטא.
	 */
	private static function save_checkbox( int $post_id, string $key ): void {
		if ( isset( $_POST[ $key ] ) && '1' === sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) ) {
			update_post_meta( $post_id, $key, '1' );
		} else {
			delete_post_meta( $post_id, $key );
		}
	}

	/**
	 * מחזיר את מזהה העמוד הנוכחי בפרונט (singular page בלבד).
	 *
	 * @return int
	 */
	private static function current_page_id(): int {
		if ( is_admin() || ! is_page() ) {
			return 0;
		}
		return (int) get_queried_object_id();
	}

	/**
	 * האם להסתיר וואטסאפ בעמוד הנוכחי.
	 *
	 * @return bool
	 */
	public static function hide_whatsapp(): bool {
		$id = self::current_page_id();
		return $id > 0 && '1' === (string) get_post_meta( $id, self::HIDE_WHATSAPP, true );
	}

	/**
	 * האם להסתיר מייל בעמוד הנוכחי.
	 *
	 * @return bool
	 */
	public static function hide_email(): bool {
		$id = self::current_page_id();
		return $id > 0 && '1' === (string) get_post_meta( $id, self::HIDE_EMAIL, true );
	}

	/**
	 * עוקף את הטלפון (תצוגה/חיוג) לפי הגדרת העמוד, אם קיימת.
	 *
	 * @param string $value הערך המקורי.
	 * @param string $key   מפתח השדה.
	 * @return string
	 */
	public static function filter_phone( string $value, string $key ): string {
		if ( 'phone_display' !== $key && 'phone_tel' !== $key ) {
			return $value;
		}
		$id = self::current_page_id();
		if ( $id <= 0 ) {
			return $value;
		}
		$meta = 'phone_display' === $key ? self::PHONE_DISPLAY : self::PHONE_TEL;
		$over = (string) get_post_meta( $id, $meta, true );
		return '' !== $over ? $over : $value;
	}
}

Metadoc_Landing::init();
