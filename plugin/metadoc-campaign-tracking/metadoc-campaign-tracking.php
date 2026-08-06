<?php
/**
 * Plugin Name:       Metadoc — מעקב קמפיין (חדרי חרדים)
 * Plugin URI:        https://m-d.co.il/
 * Description:        שולח לידים שנשלחו בהצלחה מטופס האתר ל-CRM של מערכת הפרסום (bhol). הפעלה/כיבוי דרך מסך התוספים — מיועד לשימוש זמני בזמן קמפיין. ללא השפעה על שליחת הליד הרגילה.
 * Version:           1.0.0
 * Author:            Multi Digital
 * Author URI:        https://m-d.co.il/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP:      7.4
 * Text Domain:       metadoc-campaign
 *
 * @package MetadocCampaign
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * כתובת ברירת המחדל של ה-CRM. ניתן לעקוף עם הפילטר 'mdct_endpoint':
 *   add_filter( 'mdct_endpoint', fn() => 'https://example.com/lead.php' );
 */
if ( ! defined( 'MDCT_ENDPOINT_DEFAULT' ) ) {
	define( 'MDCT_ENDPOINT_DEFAULT', 'https://ext.bhol.co.il/lead.php' );
}

define( 'MDCT_VERSION', '1.0.0' );

/**
 * טעינת סקריפט המעקב בצד הלקוח (Footer, ללא חסימה).
 */
function mdct_enqueue_assets() {
	wp_enqueue_script(
		'mdct-campaign',
		plugins_url( 'campaign-tracking.js', __FILE__ ),
		array(),
		MDCT_VERSION,
		true
	);

	$endpoint = esc_url_raw( (string) apply_filters( 'mdct_endpoint', MDCT_ENDPOINT_DEFAULT ) );

	wp_localize_script(
		'mdct-campaign',
		'mdctCampaign',
		array( 'endpoint' => $endpoint )
	);
}
add_action( 'wp_enqueue_scripts', 'mdct_enqueue_assets' );
