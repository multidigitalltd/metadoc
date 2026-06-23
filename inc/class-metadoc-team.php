<?php
/**
 * סוג תוכן "הצוות שלנו" — חברי צוות דינמיים (ללא הגבלת כמות) לעמוד האודות.
 * שם = כותרת, תמונה = תמונה ראשית, אודות = תקציר, תפקיד = שדה מטא.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Team
 */
final class Metadoc_Team {

	public const CPT        = 'md_team';
	private const META_ROLE = '_md_team_role';
	private const NONCE     = 'metadoc_team_meta';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
		add_action( 'save_post_' . self::CPT, array( __CLASS__, 'save' ) );
		add_filter( 'manage_' . self::CPT . '_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', array( __CLASS__, 'column' ), 10, 2 );
	}

	/**
	 * רישום סוג התוכן — ניהול בלבד, ללא עמודים ציבוריים בודדים.
	 */
	public static function register(): void {
		register_post_type(
			self::CPT,
			array(
				'labels'              => array(
					'name'          => __( 'הצוות שלנו', 'metadoc' ),
					'singular_name' => __( 'חבר/ת צוות', 'metadoc' ),
					'menu_name'     => __( 'הצוות שלנו', 'metadoc' ),
					'add_new_item'  => __( 'הוספת חבר/ת צוות', 'metadoc' ),
					'edit_item'     => __( 'עריכת חבר/ת צוות', 'metadoc' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-groups',
				'menu_position'       => 25,
				'supports'            => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
				'show_in_rest'        => false,
			)
		);
	}

	/**
	 * תיבת מטא: תפקיד.
	 */
	public static function meta_box(): void {
		add_meta_box( 'metadoc_team', __( 'פרטי חבר/ת צוות', 'metadoc' ), array( __CLASS__, 'render' ), self::CPT, 'side', 'high' );
	}

	/**
	 * רינדור התיבה.
	 *
	 * @param WP_Post $post הפוסט.
	 */
	public static function render( WP_Post $post ): void {
		$role = (string) get_post_meta( $post->ID, self::META_ROLE, true );
		wp_nonce_field( self::NONCE, self::NONCE . '_field' );
		echo '<p><label for="md_team_role"><strong>' . esc_html__( 'תפקיד', 'metadoc' ) . '</strong></label></p>';
		printf( '<input type="text" id="md_team_role" name="%1$s" value="%2$s" class="widefat" placeholder="%3$s" />', esc_attr( self::META_ROLE ), esc_attr( $role ), esc_attr__( 'למשל: יועץ/ת משכנתאות בכיר/ה', 'metadoc' ) );
		echo '<p style="margin-top:10px;color:#666;font-size:12px">' . esc_html__( 'התמונה = "תמונה ראשית". טקסט האודות = "תקציר". הסדר נקבע בשדה "סדר" (מאפיינים).', 'metadoc' ) . '</p>';
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
		$role = isset( $_POST[ self::META_ROLE ] ) ? sanitize_text_field( wp_unslash( $_POST[ self::META_ROLE ] ) ) : '';
		'' !== $role ? update_post_meta( $post_id, self::META_ROLE, $role ) : delete_post_meta( $post_id, self::META_ROLE );
	}

	/**
	 * מחזיר את התפקיד.
	 *
	 * @param int $post_id מזהה.
	 * @return string
	 */
	public static function role( int $post_id ): string {
		return (string) get_post_meta( $post_id, self::META_ROLE, true );
	}

	/**
	 * שאילתת חברי הצוות לפי סדר.
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
				$new['md_role'] = __( 'תפקיד', 'metadoc' );
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
		if ( 'md_role' === $col ) {
			echo esc_html( self::role( $post_id ) );
		}
	}
}

Metadoc_Team::init();
