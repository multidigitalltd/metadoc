<?php
/**
 * שדות מקור הפנייה — מאפשרים סינון וייצוא לידים לפי פרויקט וטופס.
 * $args: form (שם הטופס).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ls_project = '';
if ( is_singular( Metadoc_Projects::CPT ) ) {
	$ls_project = (string) get_the_title();
} elseif ( is_page_template( Metadoc_RealEstate::TPL_PROJECT ) ) {
	$ls_project = __( 'שער המפרץ', 'metadoc' );
} elseif ( is_page_template( Metadoc_RealEstate::TPL_DEPT ) ) {
	$ls_project = __( 'מחלקת נדל"ן', 'metadoc' );
}
?>
<input type="hidden" name="project" value="<?php echo esc_attr( $ls_project ); ?>">
<input type="hidden" name="form" value="<?php echo esc_attr( isset( $args['form'] ) ? (string) $args['form'] : '' ); ?>">
