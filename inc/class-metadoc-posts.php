<?php
/**
 * תמיכה בכתבות עם קישור חיצוני (סיקור תקשורתי שפורסם באתר אחר).
 * אם הוגדר קישור — הכרטיס/הכותרת מובילים לכתבה החיצונית.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Posts
 */
final class Metadoc_Posts {

	private const META  = '_md_external_url';
	private const NONCE = 'metadoc_post_meta';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
		add_action( 'save_post_post', array( __CLASS__, 'save' ) );
	}

	/**
	 * רישום תיבת מטא.
	 */
	public static function meta_box(): void {
		add_meta_box(
			'metadoc_external',
			__( 'קישור חיצוני לכתבה', 'metadoc' ),
			array( __CLASS__, 'render' ),
			'post',
			'side',
			'high'
		);
	}

	/**
	 * רינדור התיבה.
	 *
	 * @param WP_Post $post הפוסט.
	 */
	public static function render( WP_Post $post ): void {
		$value = (string) get_post_meta( $post->ID, self::META, true );
		wp_nonce_field( self::NONCE, self::NONCE . '_field' );
		echo '<p>' . esc_html__( 'אם הכתבה פורסמה באתר חיצוני (סיקור תקשורתי), הדביקו כאן את הכתובת. הכרטיס יוביל אליה בלשונית חדשה.', 'metadoc' ) . '</p>';
		printf(
			'<input type="url" name="%1$s" value="%2$s" class="widefat" placeholder="https://..." />',
			esc_attr( self::META ),
			esc_attr( $value )
		);
	}

	/**
	 * שמירה.
	 *
	 * @param int $post_id מזהה הפוסט.
	 */
	public static function save( int $post_id ): void {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$nonce = isset( $_POST[ self::NONCE . '_field' ] ) ? sanitize_text_field( wp_unslash( $_POST[ self::NONCE . '_field' ] ) ) : '';
		if ( ! $nonce || ! wp_verify_nonce( $nonce, self::NONCE ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$url = isset( $_POST[ self::META ] ) ? esc_url_raw( trim( (string) wp_unslash( $_POST[ self::META ] ), " \t\n\r\0\x0B" ), array( 'http', 'https' ) ) : '';
		if ( '' !== $url ) {
			update_post_meta( $post_id, self::META, $url );
		} else {
			delete_post_meta( $post_id, self::META );
		}
	}

	/**
	 * מחזיר את הקישור החיצוני של הפוסט (ריק אם אין).
	 *
	 * @param int $post_id מזהה הפוסט.
	 * @return string
	 */
	public static function external_url( int $post_id ): string {
		return (string) get_post_meta( $post_id, self::META, true );
	}
}

Metadoc_Posts::init();

/**
 * מחזיר את היעד של כתבה: קישור חיצוני אם הוגדר, אחרת הקישור הפנימי.
 *
 * @param int|null $post_id מזהה הפוסט (ברירת מחדל: הנוכחי).
 * @return array{url:string,external:bool}
 */
function metadoc_post_link( ?int $post_id = null ): array {
	$post_id  = $post_id ? $post_id : (int) get_the_ID();
	$external = Metadoc_Posts::external_url( $post_id );
	if ( '' !== $external ) {
		return array( 'url' => $external, 'external' => true );
	}
	return array( 'url' => (string) get_permalink( $post_id ), 'external' => false );
}
