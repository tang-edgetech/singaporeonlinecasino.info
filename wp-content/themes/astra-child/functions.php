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
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'media-query', get_stylesheet_directory_uri() . '/assets/css/media-query.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	
    $providers = get_the_provider_list();
    wp_add_inline_script( 'provider-list', 'const ProviderList = ' . wp_json_encode( $providers ) . ';', 'before' );

	if( !is_admin() ) {
   		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/assets/js/jquery-3.7.1.min.js', array(), '3.7.1', true );
	}
	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
	wp_enqueue_script( 'swiper-js', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
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
                    <div class="navbar-col col-left d-flex">
                        <a href="<?= home_url();?>" class="navbar-brand p-0 m-0">
                        <?php if( $logo ) {
                            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '" alt="" class="me-2 pb-2">';
                        } else {
                            echo '<h1 class="site-title">' . esc_html( get_bloginfo('name') ) . '</h1>';
                        } ?>
                        </a>
						<?php
						if( !empty($providers) ) {
							$layer = 1;
							?>
							<div class="navbar-collapse ms-1 d-none d-xl-block">
								<ul class="navbar-nav nav-list m-0 p-0 d-flex flex-row primary-navigation-menu-lvl1 ms-1 h-100">
								<?php
								$max_lvl = count($providers);
								$index = 1;
								$default_class = "menu-item text-0-8 text-weight-400 text-uppercase position-relative";

								foreach ($providers as $row) {
        							$spacing = ($max_lvl === $index) ? 'ms-n1 ps-3' : 'pe-2 me-3';
									$label     = esc_html($row['name'] ?? '');
									$slug      = esc_attr($row['slug'] ?? '');
									$url       = !empty($row['url']) ? esc_url($row['url']) : 'javascript:void(0)';
									$thumbnail = esc_url($row['thumbnail'] ?? '');
									$tagging   = $row['tagging'] ?? [];
									$has_child = !empty($row['has_children']) ? 'menu-item-has-children' : '';

									$first_tag  = $tagging[0] ?? '';
									$other_tags = '';
									if (!empty($tagging) && count($tagging) > 1) {
										foreach (array_slice($tagging, 1) as $tag) {
											$other_tags .= '<div class="position-absolute w-auto h-auto text-uppercase vpn-tag ' . esc_attr($tag) . '">' . esc_html($tag) . '</div>';
										}
									}

									$classes = implode(' ', array_filter([
										$default_class,
										$spacing,
										$has_child,
										$slug,
										$first_tag ? 'tag tag-' . $first_tag : '',
									]));

									$data_tag  = $first_tag ? 'data-tag="' . esc_attr($first_tag) . '"' : '';
									$data_menu_type = 'data-menu-tag="'.esc_attr($slug).'"';
									?>
									<li class="<?= $classes; ?>" <?= $data_tag; ?> <?= $data_menu_type;?>>
										<a class="menu-link" href="<?= $url; ?>"><?= $label; ?></a>
										<?= $other_tags; ?>
									</li>
									<?php
									$index++;
								}
								?>
								</ul>
								<ul class="nav-list sub-menu m-0 p-0 d-flex align-items-center primary-navigation-menu-lvl2 p-3 position-fixed w-100 h-auto active">
								<?php foreach( $providers[0]['sub_menu'] as $sub_item ) { 
									$sub_slug = $sub_item['slug'];
									$sub_name = $sub_item['name'];
								?>
									<li class="menu-item sub-menu-item text-0-9 text-weight-400 text-uppercase pe-2 me-4 position-relative live-dealer tag tag-hot" data-game-type="live-casino" data-tag="hot"><a href="https://eupphuat.com/live-casino" role="button"><?= $sub_slug;?></a></li>
								<?php } ?>
								</ul>
								<ul class="nav-list sub-menu m-0 p-0 d-grid align-items-center primary-navigation-menu-lvl3 p-3 position-fixed w-100 h-auto active">
								<?php foreach( $providers[0]['sub_menu'][0]['sub_menu'] as $sub_sub_item ) { 
									$sub_sub_slug = $sub_sub_item['slug'];
									$sub_sub_name = $sub_sub_item['name'];
									$sub_sub_thumbnail = $sub_sub_item['thumbnail'];
								?>
									<li class="menu-item sub-menu-item text-0-9 text-weight-400 text-uppercase text-center position-relative w-100 text-center tag tag-hot" data-tag="hot"><a href=""><img src="<?= PROVIDER_ASSET_URL."/live-casino/".$sub_sub_thumbnail;?>"/></a></li>
								<?php } ?>
								</ul>
							</div>
							<?php
						}
						?>
                    </div>
                    <div class="navbar-col col-right">

                    </div>
                </div>
            </div>
        </nav>
	<?php
	return ob_get_clean();
}
add_shortcode( 'hajimi_custom_header_navigation', 'hajimi_custom_header_navigation' );