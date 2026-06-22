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
