<?php
/**
 * סוג תוכן "ערכים / יתרונות" — כרטיסי ערך דינמיים (ללא הגבלת כמות) לעמוד האודות.
 * כותרת = שם הערך, תקציר = תיאור, אייקון = שדה מטא (בחירה מרשימת האייקונים).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Value
 */
final class Metadoc_Value {

	public const CPT        = 'md_value';
	private const META_ICON = '_md_value_icon';
	private const NONCE     = 'metadoc_value_meta';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
		add_action( 'save_post_' . self::CPT, array( __CLASS__, 'save' ) );
	}

	/**
	 * רישום סוג התוכן — ניהול בלבד.
	 */
	public static function register(): void {
		register_post_type(
			self::CPT,
			array(
				'labels'              => array(
					'name'          => __( 'ערכים ויתרונות', 'metadoc' ),
					'singular_name' => __( 'ערך', 'metadoc' ),
					'menu_name'     => __( 'ערכים ויתרונות', 'metadoc' ),
					'add_new_item'  => __( 'הוספת ערך', 'metadoc' ),
					'edit_item'     => __( 'עריכת ערך', 'metadoc' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-awards',
				'menu_position'       => 26,
				'supports'            => array( 'title', 'excerpt', 'page-attributes' ),
				'show_in_rest'        => false,
			)
		);
	}

	/**
	 * תיבת מטא: בחירת אייקון.
	 */
	public static function meta_box(): void {
		add_meta_box( 'metadoc_value', __( 'אייקון', 'metadoc' ), array( __CLASS__, 'render' ), self::CPT, 'side', 'high' );
	}

	/**
	 * רינדור התיבה — בורר אייקונים.
	 *
	 * @param WP_Post $post הפוסט.
	 */
	public static function render( WP_Post $post ): void {
		$icon  = (string) get_post_meta( $post->ID, self::META_ICON, true );
		$icons = array_keys( metadoc_icon_paths() );
		wp_nonce_field( self::NONCE, self::NONCE . '_field' );
		echo '<p><label for="md_value_icon"><strong>' . esc_html__( 'בחרו אייקון', 'metadoc' ) . '</strong></label></p>';
		echo '<select id="md_value_icon" name="' . esc_attr( self::META_ICON ) . '" class="widefat">';
		foreach ( $icons as $key ) {
			printf( '<option value="%1$s"%2$s>%1$s</option>', esc_attr( $key ), selected( $icon, $key, false ) );
		}
		echo '</select>';
		echo '<p style="margin-top:10px;color:#666;font-size:12px">' . esc_html__( 'התיאור = "תקציר". הסדר נקבע בשדה "סדר" (מאפיינים).', 'metadoc' ) . '</p>';
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
		$icon  = isset( $_POST[ self::META_ICON ] ) ? sanitize_key( wp_unslash( $_POST[ self::META_ICON ] ) ) : '';
		$valid = array_keys( metadoc_icon_paths() );
		if ( in_array( $icon, $valid, true ) ) {
			update_post_meta( $post_id, self::META_ICON, $icon );
		} else {
			delete_post_meta( $post_id, self::META_ICON );
		}
	}

	/**
	 * מחזיר את שם האייקון (עם נפילה).
	 *
	 * @param int $post_id מזהה.
	 * @return string
	 */
	public static function icon( int $post_id ): string {
		$icon = (string) get_post_meta( $post_id, self::META_ICON, true );
		return '' !== $icon ? $icon : 'shield-check';
	}

	/**
	 * שאילתת הערכים לפי סדר.
	 *
	 * @return WP_Post[]
	 */
	public static function all(): array {
		return get_posts(
			array(
				'post_type'      => self::CPT,
				'posts_per_page' => 30,
				'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
				'no_found_rows'  => true,
			)
		);
	}
}

Metadoc_Value::init();
