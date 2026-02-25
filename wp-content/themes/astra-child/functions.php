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

add_action('template_redirect', function() {

    if ( is_front_page() || is_page() ) {

        remove_action( 'wp_head', '_wp_render_title_tag', 1 );
        remove_theme_support( 'title-tag' );

    }

});

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
	
        <nav class="navbar px-3 px-md-0 px-xl-0 pt-2 pb-0">
            <div class="navbar-row d-flex justify-content-center">  
                <div class="col-12 col-md-11 d-flex justify-content-between align-items-center">
                    <div class="navbar-col col-left d-flex justify-content-between w-100">
                        <a href="<?= home_url();?>" class="navbar-brand p-0 m-0">
                        <?php if( $logo ) {
                            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '" alt="" class="me-2 pb-2">';
                        } else {
                            echo '<h1 class="site-title">' . esc_html( get_bloginfo('name') ) . '</h1>';
                        } ?>
                        </a>
                    </div>
                    <div class="navbar-col col-right d-flex justify-content-end align-items-center w-100">
                        <button type="button" class="menu-toggler p-0 bg-transparent">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                            <span class="d-none hidden">Menu Toggle</span>
                        </button>
                        <?php
                        $side_menu = get_field('side_menu', 'option');
                        $call_to_action = $side_menu['call_to_action'];
                        ?>
                        <div class="call-to-action d-none d-md-flex align-items-center gap-md-2 ps-2">
                            <?php foreach($call_to_action as $btn) {
                                $button = $btn['button_link'];
                                $button_link = $button['url'];
                                $button_color = $btn['button_color'];
                                if( empty($button_link) ) { 
                                    $button_link = 'javascript:void(0);';
                                }
                            ?>
                                <a href="<?= $button_link;?>" class="btn btn-<?= $button_color['value'];?>" target="<?= $button['target'];?>"><span><?= $button['title'];?></span></a>
                            <?php } ?>
                            <button type="button" class="btn-pll language-switcher p-0"><span class="d-none hidden">Language</span><?= '<img src="'.get_stylesheet_directory_uri() . '/assets/images/flags/sg.svg"/>';?></button>
                        </div>
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

function game_provider_slider_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'game_type' => 'default'
        ),
        $atts,
        'game_provider_slider'
    );
    $game_type = sanitize_text_field( $atts['game_type'] );
    $game_title = '';
    $game_data = '';
    if( $game_type == 'slots' ) {
        $game_title = 'Slots';
        $game_data = '[{"title":"Double Fortune","image":"https://cny.fujicdnx.net/public/storage/game_api/pgslot/en/double_fortune_desktop.png"},{"title":"Zeus of Olympus","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/zeus_of_olympus_desktop.png"},{"title":"Sweet Bonanza Super Scatter","image":"https://cny.fujicdnx.net/public/storage/game_api/pragmaticplay/en/sweet_bonanza_super_scatter_desktop.png"},{"title":"Eternal Abundance","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/eternal_abundance_desktop.png"},{"title":"Chinese New Year Moreways","image":"https://cny.fujicdnx.net/public/storage/game_api/fachai/en/chinese_new_year_moreways_desktop.png"},{"title":"Mahjong Wins Gong Xi Fa Cai","image":"https://cny.fujicdnx.net/public/storage/game_api/pragmaticplay/en/mahjong_wins__gong_xi_fa_cai_desktop.png"},{"title":"Happy Buddha","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/happy_buddha_desktop.png"},{"title":"Mahjong Wins","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/mahjong_wins_desktop.png"},{"title":"Gates of Olympus Super Scatter","image":"https://cny.fujicdnx.net/public/storage/game_api/pragmaticplay/en/gates_of_olympus_super_scatter_desktop.png"},{"title":"Duo Cai Duo Fu","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/duo_cai_duo_fu_desktop.png"},{"title":"Neko Wins","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/neko_wins_desktop.png"}]';
    }
    else if( $game_type == 'live-casino') {
        $game_title = 'Live Casino';
        $game_data = '[{"title":"Monopoly","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/MONOPOLY.png"},{"title":"Lightning Roulette","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/lightning_roullet0.jpg"},{"title":"Mega Ball","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/Mega_Ball.png"},{"title":"Sweet Bonanza Candyland","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/bonanza0.jpg"},{"title":"Mega Wheel","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/mega0.jpg"},{"title":"Cash or Crash","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/Cash_or_Crash.png"},{"title":"Crazy Time","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/crazy_time.png"},{"title":"Mega Sic Bo","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/sic0_(1).jpg"},{"title":"Lightning Baccarat","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/lightningbaccarat.png"},{"title":"Speed Baccarat","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/speed_baccarat.png"},{"title":"Lightning Dice","image":"https://ano20.eucdnex.com/public/storage/product_sorting/live-dealer/lightning_dice0.jpg"},{"title":"Funky Time","image":"https://cny.fujicdnx.net/public/storage/game_api/evo/en/funky_time_desktop.png"}]';
    }
    else if( $game_type == 'recommended') {
        $game_title = 'Recommended';
        $game_data = '[{"title":"Eternal Abundance","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/eternal_abundance_desktop.png"},{"title":"Mahjong Wins 2","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/mahjong_wins_2_desktop.png"},{"title":"Dragon Heiress","image":"https://cny.fujicdnx.net/public/storage/game_api/marbula2/en/dragon_heiress_desktop.png"},{"title":"Prosperity Fortune Tree","image":"https://cny.fujicdnx.net/public/storage/game_api/pgslot/en/prosperity_fortune_tree_desktop.png"},{"title":"Mahjong Wins  Gong Xi Fa Cai","image":"https://cny.fujicdnx.net/public/storage/game_api/pragmaticplay/en/mahjong_wins__gong_xi_fa_cai_desktop.png"},{"title":"Jade Coins","image":"https://cny.fujicdnx.net/public/storage/game_api/endorphina/en/jadecoins_desktop.png"},{"title":"Speed Baccarat","image":"https://ano20.eucdnex.com/public/storage/product_sorting/popular_game/speed_baccarat.png"},{"title":"Lightning Baccarat","image":"https://ano20.eucdnex.com/public/storage/product_sorting/popular_game/evolution_lightning_baccarat.png"},{"title":"Crazy Time","image":"https://ano20.eucdnex.com/public/storage/product_sorting/popular_game/crazy_time.png"},{"title":"Marbula 2-Classic","image":"https://ano20.eucdnex.com/public/storage/product_sorting/popular_game/marbula2.jpg"},{"title":"Aviator","image":"https://cny.fujicdnx.net/public/storage/game_api/spribe/en/aviator_desktop.png"},{"title":"Super Sic Bo","image":"https://ano20.eucdnex.com/public/storage/product_sorting/popular_game/evolution-super-sic-bo-ps.jpg"}]';
    }

    ob_start();
    if( !empty($game_data) ) {

        $games = json_decode( $game_data, true );
    ?>
    <div class="col-12 col-md-11 col-xl-10 px-4 px-md-0 mx-auto">
        <div class="game-provider-slider">
            <div class="slider-header">
                <h2 class="slider-header-title"><?= $game_title;?></h2>
            </div>
            <div class="slider-body">
                <div class="gpSlider swiper">
                    <div class="swiper-wrapper">
                    <?php foreach( $games as $item ) { 
                        $column_title = $item['title'];
                        $column_image = $item['image'];
                    ?> 
                        <div class="swiper-slide gp-item">
                            <div class="swiper-slide-inner gp-item-inner">
                                <div class="gp-thumbnail"><img src="<?= $column_image;?>"/></div>
                                <div class="gp-content mt-2 pt-1 mb-2 px-0">
                                    <p class="game-title p-0 m-0 text-weight-400 text-default text-center"><?= $column_title;?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    else {
    ?>
        <div class="alert alert-warning" role="alert">The game type is required!</div>
    <?php
    }
    return ob_get_clean();
}
add_shortcode('game_provider_slider', 'game_provider_slider_shortcode');

function game_result_board_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'result_board' => 'default'
        ),
        $atts,
        'game_result_board'
    );
    $result_board = sanitize_text_field( $atts['result_board'] );
    $game_title = '';
    $game_slug = '';
    $game_data = '';
    if( $result_board == 'deposit' ) {
        $game_title = 'Recent Deposit';
        $game_slug = 'deposit';
    }
    else if( $result_board == 'withdrawal' ) {
        $game_title = 'Recent Withdrawal';
        $game_slug = 'withdraw';
    }
    else if( $result_board == 'top_winners' ) {
        $game_title = 'Top Winner';
        $game_slug = 'top-winners d-none d-xl-block';
        $game_data = '[{"img":"https://eupphuat.com/assets/provider/evo.png","title":"***439***","price":"$ 10,030.30"},{"img":"https://eupphuat.com/assets/provider/dreamgame.png","title":"***195***","price":"$ 2,000.00"},{"img":"https://eupphuat.com/assets/provider/ssport.png","title":"***inm***","price":"$ 1,803.66"},{"img":"https://eupphuat.com/assets/provider/endorphina.png","title":"***514***","price":"$ 1,186.25"},{"img":"https://eupphuat.com/assets/provider/qtech.png","title":"***077***","price":"$ 707.20"},{"img":"https://eupphuat.com/assets/provider/fachaiv2.png","title":"***lim***","price":"$ 613.20"},{"img":"https://eupphuat.com/assets/provider/marbula2.png","title":"***huk***","price":"$ 613.10"},{"img":"https://eupphuat.com/assets/provider/sagaming.png","title":"***nna***","price":"$ 573.00"},{"img":"https://eupphuat.com/assets/provider/spribe.png","title":"***ill***","price":"$ 329.71"},{"img":"https://eupphuat.com/assets/provider/bngv2.png","title":"***ete***","price":"$ 286.70"}]';
    }
    
    ob_start();
    $data = json_decode($game_data, true);
    ?>
        <div class="game-board type-<?= $game_slug;?>">
            <div class="game-header mb-2 mb-md-2 mb-lg-3 px-0">
                <h3 class="game-header-title text-white"><?= $game_title;?></h3>
            </div>
            <div class="game-body<?= ($result_board !== 'top_winners') ? ' px-0' : '';?>">
            <?php
            if( $result_board == 'top_winners' ) {
            ?>
                <div class="top_winner px-4 px-md-0">
                    <div class="result-board swiper static mb-3">
                        <div class="swiper-wrapper">
                        <?php
                        for($i=0;$i<3;$i++) {
                            $image = $data[$i]['img'];
                            $title = $data[$i]['title'];
                            $price = $data[$i]['price'];
                        ?>
                            <div class=" swiper-slide board-item p-1">
                                <div class="board-item-inner">
                                    <div class="board-thumbnail"><img src="<?= $image;?>"/></div>
                                    <div class="board-body">
                                        <div class="board-title"><?= $title;?></div>
                                        <div class="board-price"><?= $price;?></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <div class="result-board swiper infinite-swiper bg-shade-grey py-2">
                    <div class="swiper-wrapper">
                    <?php
                    for($j=2;$j<count($data);$j++) {
                        $image = $data[$j]['img'];
                        $title = $data[$j]['title'];
                        $price = $data[$j]['price'];
                    ?>
                        <div class="swiper-slide board-item p-1">
                            <div class="board-item-inner">
                                <div class="board-thumbnail"><img src="<?= $image;?>"/></div>
                                <div class="board-body">
                                    <div class="board-title"><?= $title;?></div>
                                    <div class="board-price"><?= $price;?></div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            <?php
            }
            else {
            ?>
                <div class="table-wrapper px-lg-3 px-1 px-md-2 pb-2 pt-lg-1">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>USERNAME</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for( $i=0;$i<5;$i++ ) { 
                            $unhashed_title = generateRandomString();
                            $title = maskString($unhashed_title);
                            $price = randomDeposit();
                            if( $result_board == 'withdrawal' ) {
                                $price = randomWithdraw();
                            }
                        ?>
                            <tr>
                                <td><?= $title;?></td>
                                <td><?= $price;?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    <?php
    return ob_get_clean();
}
add_shortcode('game_result_board', 'game_result_board_shortcode');

function generateRandomString($length = 15) {
    $length = rand(5, min(15, $length));
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function maskString($input) {
    $length = strlen($input);

    if ($length <= 3) {
        return $input;
    }

    $firstTwo = substr($input, 0, 2);
    $last = $input[$length - 1];
    $masked = str_repeat('*', $length - 3);

    return $firstTwo . $masked . $last;
}

function randomDeposit() {
    $amount = rand(50, 10000);
    return number_format($amount, 2, '.', '');
}

function randomWithdraw() {
    $amount = mt_rand(10000, 500000) / 100;
    return number_format($amount, 2, '.', '');
}

function mspuiyi_card() {
?>
    <div class="aside-mspuiyi position-fixed d-none d-xl-flex">
        <img class="w-100 puiyi-img loading" src="<?= get_stylesheet_directory_uri();?>/assets/images/miss-puiyi-left.png" alt="Miss Puiyi" width="100" height="auto" data-was-processed="true">
        <div class="mspuiyi-text-wrapper text-white position-relative pe-3 pt-3 pb-3 ps-2">
            <p class="m-0 p-0 text-0-8">萧佩儿</p>
            <p class="m-0 p-0 text-weight-600 text-1-2">MS PUI YI</p>
            <p class="m-0 p-0 text-0-8">EU9 Brand Ambassador 2021/22</p>

            <img class="w-100 puiyi-sign position-absolute loading" src="<?= get_stylesheet_directory_uri();?>/assets/images/miss-puiyi-sign.png?27092023" alt="Miss Puiyi" width="50" height="auto" data-was-processed="true">
        </div>
    </div>
<?php
}
add_action( 'wp_body_open', 'mspuiyi_card' );