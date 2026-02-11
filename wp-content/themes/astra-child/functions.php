<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.'.time() );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'swiper-css', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'media-query', get_stylesheet_directory_uri() . '/assets/css/media-query.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	
	if( !is_admin() ) {
   		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery-3.7.1.min.js', array(), '3.7.1', true );
	}
	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
	wp_enqueue_script( 'swiper-js', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );

}
add_action( 'wp_enqueue_script', 'child_enqueue_styles', 15 );

function allow_custom_mime_types( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['csv']  = 'text/csv';
    $mimes['json'] = 'application/json';

    return $mimes;
}
add_filter( 'upload_mimes', 'allow_custom_mime_types' );
