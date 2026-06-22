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
<?php
get_template_part( 'template-parts/site-footer' );
get_template_part( 'template-parts/floating' );
get_template_part( 'template-parts/accessibility-widget' );
get_template_part( 'template-parts/cookie-consent' );
get_template_part( 'template-parts/success-modal' );
?>
</div><!-- #top -->
<?php wp_footer(); ?>
</body>
</html>
