<?php
/**
 * עמוד הבית — הרכבת עמוד הנחיתה של מטאדוק.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/landing-content' );
get_footer();
