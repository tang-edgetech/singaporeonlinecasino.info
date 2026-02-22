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
            <?php
            $side_menu = get_field('side_menu', 'option');
            $banners = $side_menu['banner'];
            $call_to_action = $side_menu['call_to_action'];
            $sidemenu_banner_class = 'sidemenu-banner';
            $sidemenu_banner_item_class = 'banner-item';
            if( !empty($banners) ) {
                if( count($banners) > 1 ) { 
                    $sidemenu_banner_class .= ' swiper';
                    $sidemenu_banner_item_class .= ' swiper-slide';
                }
            ?>
                <div class="<?= $sidemenu_banner_class;?>">
                <?php if( count($banners) > 1 ) { echo '<div class="swiper-wrapper">'; } ?>
            <?php foreach( $banners as $banner ) {
                    $banner_title = $banner['banner_title'];
                    $banner_image = $banner['banner_image'];
                    $banner_url = $banner['banner_url']; ?>
                <div class="<?= $sidemenu_banner_item_class;?>">
                    <?php
                    if( !empty($banner_url['url']) ) { echo '<a href="'.$banner_url['url'].'" title="'.$banner_title.'">'; }
                    if( $banner_image['url'] ) {
                        echo '<img src="'.$banner_image['url'].'" class="img-fluid w-100" alt="'.$banner_title.'"/>';
                    }
                    if( !empty($banner_url['url']) ) { echo '</a>'; }
                    ?>
                </div>
            <?php } ?>
                <?php if( count($banners) > 1 ) { echo '</div>'; } ?>
                </div>
            <?php
            }
            if( !empty($call_to_action) ) {
            ?>
                <div class="sidemenu-buttons">
                <?php foreach($call_to_action as $btn) {
                    $button = $btn['button_link'];
                    $button_link = $button['url'];
                    $button_color = $btn['button_color'];
                    if( empty($button_link) ) { 
                        $button_link = 'javascript:void(0);';
                    }
                ?>
                    <a href="<?= $button_link;?>" class="btn btn-<?= $button_color['value'];?>" target="<?= $button['target'];?>"><?= $button['title'];?></a>
                <?php } ?>
                </div>
            <?php
            }
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container_id' => 'sidemenu-navigation',
                    'container_class' => 'sidemenu-navigation',
                    'menu_id' => 'primary-menu-list',
                    'menu_class' => 'sidemenu-menu-list navbar nav m-0 p-0',
            ));
            ?>
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

add_filter('nav_menu_link_attributes', 'add_acf_tag_to_a', 10, 4);
function add_acf_tag_to_a($atts, $item, $args, $depth) {

    if ($args->theme_location !== 'primary') {
        return $atts;
    }

    $tags = get_field('tag', $item);

    if (!empty($tags)) {

        if (!is_array($tags)) {
            $tags = array($tags);
        }

        if (!isset($atts['class'])) {
            $atts['class'] = '';
        }
    
        $atts['class'] .= 'tag';
        foreach ($tags as $tag) {
            $atts['class'] .= ' tag-' . sanitize_html_class($tag['value']);
        }

        $first_tag = reset($tags);
        $atts['data-tag'] = esc_attr($first_tag['value']);
    }

    return $atts;
}

function add_icon_before_menu_title($title, $item, $args, $depth) {
    if (!is_string($title)) {
        return '';
    }

    if (isset($args->theme_location) && $args->theme_location === 'primary') {

        $icon = get_field('menu_icon', $item);
        $icon_html = '';

        if (!empty($icon) && is_array($icon) && !empty($icon['url'])) {

            $icon_html = '<img src="' . esc_url($icon['url']) . '" alt="' . esc_attr($icon['alt'] ?? '') . '" class="menu-icon" />';

        }
        $title = $icon_html . '<span class="menu-label">' . $title . '</span>';
    }

    return (string) $title;
}
add_filter('nav_menu_item_title', 'add_icon_before_menu_title', 10, 4);