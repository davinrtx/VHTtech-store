<?php

/**
* The template for displaying all single posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package WordPress
* @subpackage Machic
* @since 1.0.0
*/

	remove_action( 'machic_main_header', 'machic_main_header_function', 10 );
	remove_action( 'machic_main_footer', 'machic_main_footer_function', 10 );

	remove_action( 'machic_before_main_shop', 'machic_get_elementor_template', 10);
	remove_action( 'machic_after_main_shop', 'machic_get_elementor_template', 10);
	remove_action( 'machic_before_main_footer', 'machic_get_elementor_template', 10);
	remove_action( 'machic_after_main_footer', 'machic_get_elementor_template', 10);
	remove_action( 'machic_before_main_header', 'machic_get_elementor_template', 10);
	remove_action( 'machic_after_main_header', 'machic_get_elementor_template', 10);

    get_header();

    while ( have_posts() ) : the_post();
        the_content();
    endwhile;

    get_footer();
?>
