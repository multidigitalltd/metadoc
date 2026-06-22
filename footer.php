<?php
/**
 * סגירת המסמך.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php get_template_part( 'template-parts/site-footer' ); ?>
</div><!-- #top -->
<?php
// ווידג'טים צפים (fixed) מחוץ ל-#top — מנותקים מכל הקשר פריסה/clip,
// כדי שלא יושפעו וגם לא ידחפו את העמוד.
get_template_part( 'template-parts/floating' );
get_template_part( 'template-parts/accessibility-widget' );
get_template_part( 'template-parts/cookie-consent' );
get_template_part( 'template-parts/success-modal' );
wp_footer();
?>
</body>
</html>
