<?php
/**
 * סוג תוכן "כתבות בתקשורת" — קישורים לכתבות חיצוניות על העסק (סיקור).
 * נפרד מהפוסטים הרגילים (תוכן פנימי).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Press
 */
final class Metadoc_Press {

	public const CPT       = 'md_press';
	private const META_URL = '_md_press_url';
	private const META_SRC = '_md_press_source';
	private const NONCE    = 'metadoc_press_meta';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_action( 'init', array( __CLASS__, 'maybe_flush' ), 99 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
		add_action( 'save_post_' . self::CPT, array( __CLASS__, 'save' ) );
		add_action( 'template_redirect', array( __CLASS__, 'redirect_single' ) );
		add_filter( 'manage_' . self::CPT . '_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', array( __CLASS__, 'column' ), 10, 2 );
	}

	/**
	 * רישום סוג התוכן עם ארכיון ציבורי.
	 */
	public static function register(): void {
		register_post_type(
			self::CPT,
			array(
				'labels'       => array(
					'name'          => __( 'כתבות בתקשורת', 'metadoc' ),
					'singular_name' => __( 'כתבה בתקשורת', 'metadoc' ),
					'menu_name'     => __( 'כתבות בתקשורת', 'metadoc' ),
					'add_new_item'  => __( 'הוספת כתבה בתקשורת', 'metadoc' ),
					'edit_item'     => __( 'עריכת כתבה', 'metadoc' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'menu_icon'    => 'dashicons-megaphone',
				'menu_position' => 24,
				'rewrite'      => array( 'slug' => 'press' ),
				'supports'     => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * ריענון חד-פעמי של חוקי ה-rewrite כדי ש-/press/ יעבוד.
	 */
	public static function maybe_flush(): void {
		if ( '1' !== get_option( 'metadoc_press_rewrite_v1' ) ) {
			flush_rewrite_rules( false );
			update_option( 'metadoc_press_rewrite_v1', '1' );
		}
	}

	/**
	 * תיבת מטא: קישור חיצוני + שם מקור.
	 */
	public static function meta_box(): void {
		add_meta_box( 'metadoc_press', __( 'פרטי הכתבה', 'metadoc' ), array( __CLASS__, 'render' ), self::CPT, 'normal', 'high' );
	}

	/**
	 * רינדור התיבה.
	 *
	 * @param WP_Post $post הפוסט.
	 */
	public static function render( WP_Post $post ): void {
		$url = (string) get_post_meta( $post->ID, self::META_URL, true );
		$src = (string) get_post_meta( $post->ID, self::META_SRC, true );
		wp_nonce_field( self::NONCE, self::NONCE . '_field' );
		echo '<p><label for="md_press_url"><strong>' . esc_html__( 'קישור לכתבה החיצונית (חובה)', 'metadoc' ) . '</strong></label></p>';
		printf( '<input type="url" id="md_press_url" name="%1$s" value="%2$s" class="widefat" placeholder="https://..." required />', esc_attr( self::META_URL ), esc_attr( $url ) );
		echo '<p style="margin-top:12px"><label for="md_press_source"><strong>' . esc_html__( 'שם המקור (למשל: ynet, מאקו)', 'metadoc' ) . '</strong></label></p>';
		printf( '<input type="text" id="md_press_source" name="%1$s" value="%2$s" class="widefat" placeholder="%3$s" />', esc_attr( self::META_SRC ), esc_attr( $src ), esc_attr__( 'שם אתר/עיתון', 'metadoc' ) );
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
		$url = isset( $_POST[ self::META_URL ] ) ? esc_url_raw( trim( (string) wp_unslash( $_POST[ self::META_URL ] ) ), array( 'http', 'https' ) ) : '';
		$src = isset( $_POST[ self::META_SRC ] ) ? sanitize_text_field( wp_unslash( $_POST[ self::META_SRC ] ) ) : '';
		'' !== $url ? update_post_meta( $post_id, self::META_URL, $url ) : delete_post_meta( $post_id, self::META_URL );
		'' !== $src ? update_post_meta( $post_id, self::META_SRC, $src ) : delete_post_meta( $post_id, self::META_SRC );
	}

	/**
	 * הפניית עמוד בודד של כתבה ישירות לקישור החיצוני.
	 */
	public static function redirect_single(): void {
		if ( ! is_singular( self::CPT ) ) {
			return;
		}
		$url = (string) get_post_meta( get_queried_object_id(), self::META_URL, true );
		if ( '' !== $url ) {
			wp_redirect( $url, 302 ); // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect -- יעד חיצוני מכוון.
			exit;
		}
	}

	/**
	 * מחזיר את הקישור החיצוני.
	 *
	 * @param int $post_id מזהה.
	 * @return string
	 */
	public static function url( int $post_id ): string {
		return (string) get_post_meta( $post_id, self::META_URL, true );
	}

	/**
	 * מחזיר את שם המקור.
	 *
	 * @param int $post_id מזהה.
	 * @return string
	 */
	public static function source( int $post_id ): string {
		return (string) get_post_meta( $post_id, self::META_SRC, true );
	}

	/**
	 * עמודות ניהול.
	 *
	 * @param array $cols עמודות.
	 * @return array
	 */
	public static function columns( array $cols ): array {
		$new = array();
		foreach ( $cols as $k => $v ) {
			$new[ $k ] = $v;
			if ( 'title' === $k ) {
				$new['md_source'] = __( 'מקור', 'metadoc' );
				$new['md_url']    = __( 'קישור', 'metadoc' );
			}
		}
		return $new;
	}

	/**
	 * תוכן עמודה.
	 *
	 * @param string $col     מזהה.
	 * @param int    $post_id מזהה.
	 */
	public static function column( string $col, int $post_id ): void {
		if ( 'md_source' === $col ) {
			echo esc_html( self::source( $post_id ) );
		} elseif ( 'md_url' === $col ) {
			$url = self::url( $post_id );
			if ( '' !== $url ) {
				printf( '<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s ↗</a>', esc_url( $url ), esc_html__( 'צפייה', 'metadoc' ) );
			}
		}
	}
}

Metadoc_Press::init();
