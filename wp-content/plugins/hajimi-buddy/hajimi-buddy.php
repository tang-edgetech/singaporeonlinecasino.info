<?php
/**
 * Plugin Name: Hajimi Elementor Widgets
 * Description: Custom Elementor widgets by Hajimi
 * Version: 1.0.0
 * Author: Hajimi
 * Text Domain: hajimi
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'HAJIMI_VERSION', '1.0.'.time() );

add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'hajimi',
        [
            'title' => __( 'Hajimi', 'hajimi' ),
            'icon'  => 'fa fa-plug',
        ]
    );
} );

add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/hajimi_copyright_label.php' );
    require_once( __DIR__ . '/widgets/hajimi_header_navigation.php' );

    $widgets_manager->register( new \Hajimi_Copyright_Label_Widget() );
    $widgets_manager->register( new \Hajimi_Header_Navigation_Widget() );
} );

function hajimi_enqueue_styles() {
    wp_enqueue_style( 'hajimi-css', plugin_dir_url( __FILE__ ) . '/assets/css/hajimi.css', [], HAJIMI_VERSION, 'all' );
    wp_enqueue_script( 'hajimi-js', plugin_dir_url( __FILE__ ) . '/assets/js/hajimi.js', ['jquery'], HAJIMI_VERSION, true );
}
add_action( 'wp_enqueue_script', 'hajimi_enqueue_styles' );