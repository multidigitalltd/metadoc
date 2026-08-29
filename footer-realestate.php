<?php
/**
 * סגירת המסמך לעמודי מחלקת הנדל"ן.
 * הווידג'טים הצפים הגלובליים אינם נטענים כאן — לשני העמודים יש סרגל תחתון קבוע
 * משלהם, ושני סרגלים באותו מקום היו מתנגשים.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'template-parts/accessibility-widget' );
get_template_part( 'template-parts/cookie-consent' );
wp_footer();
?>
</body>
</html>
