<?php
/**
 * Template Name: עמוד נחיתה מטאדוק
 *
 * תבנית עמוד שמלבישה את עיצוב הנחיתה המלא על כל עמוד שתבחר.
 * שימושי כשמגדירים "עמוד סטטי" כדף הבית דרך הגדרות → קריאה.
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
