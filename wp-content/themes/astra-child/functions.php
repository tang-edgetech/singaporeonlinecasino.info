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
define( 'PROVIDER_ASSET_URL', get_stylesheet_directory_uri() . '/assets/images/providers' );

function get_the_provider_list() {
    static $providers = null;

    if ( $providers === null ) {
        $json_file = get_stylesheet_directory() . '/assets/providers/provider_list.json';
        if ( file_exists( $json_file ) ) {
            $providers = json_decode( file_get_contents( $json_file ), true );
        } else {
            $providers = [];
        }
    }

    return $providers;
}

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'swiper-css', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'hamburgers', get_stylesheet_directory_uri() . '/assets/css/hamburgers.min.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'media-query', get_stylesheet_directory_uri() . '/assets/css/media-query.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	

	if( !is_admin() ) {
   		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/assets/js/jquery-3.7.1.min.js', array(), '3.7.1', true );
	}
	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
	wp_enqueue_script( 'swiper-js', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
    $providers = get_the_provider_list();
    wp_add_inline_script( 'scripts', 'const ProviderList = ' . wp_json_encode( $providers ) . ';', 'before' );
	wp_localize_script( 'scripts', 'global', array(
		'admin_ajax' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('global_ajax_nonce'),
		'provider_asset_url' => PROVIDER_ASSET_URL,
	));
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

add_filter( 'document_title_separator', function( $sep ) {
    return '|';
});

function allow_custom_mime_types( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['csv']  = 'text/csv';
    $mimes['json'] = 'application/json';
	$mimes['ico'] = 'image/vnd.microsoft.icon';

    return $mimes;
}
add_filter( 'upload_mimes', 'allow_custom_mime_types' );

function hajimi_custom_header_navigation($atts) {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $providers = get_the_provider_list();
	ob_start();
	?>
	
        <nav class="navbar px-3 px-xl-0 pt-2 pb-0">
            <div class="navbar-row d-flex justify-content-center">
                <div class="col-11 d-flex justify-content-between align-items-center">
                    <div class="navbar-col col-left d-flex justify-content-between w-100">
                        <a href="<?= home_url();?>" class="navbar-brand p-0 m-0">
                        <?php if( $logo ) {
                            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '" alt="" class="me-2 pb-2">';
                        } else {
                            echo '<h1 class="site-title">' . esc_html( get_bloginfo('name') ) . '</h1>';
                        } ?>
                        </a>
                        <button type="button" class="menu-toggler p-0 bg-transparent">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                            <span class="d-none hidden">Menu Toggle</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <aside class="position-fixed fixed-top side-menu-wrapper w-100">
            <div class="side-menu ms-auto">

            </div>
            <button type="button" class="close-side-menu bg-transparent">
                <i class="fa fa-times" aria-hidden="true"></i>
                <span class="d-none hidden">Close Menu</span>
            </button>
        </aside>
	<?php
	return ob_get_clean();
}
add_shortcode( 'hajimi_custom_header_navigation', 'hajimi_custom_header_navigation' );

// function wpdocs_my_function() {
    
//     $providers = get_the_provider_list();
//     echo "<p class=\"value\">".json_encode($providers)."</p>";
// }
// add_action( 'wp_body_open', 'wpdocs_my_function' );