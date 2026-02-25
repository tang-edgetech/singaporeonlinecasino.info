<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

        <?php
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
        ?> 
            <div class="col-11 col-md-10 mx-auto mt-3 mt-md-4"><div class="alert alert-warning" role="alert">Frontend content is hide on this preview editor!</div></div>
        <?php
        }
        else {
            $homepage = get_field('homepage', 'option');
            $introduction_banner = $homepage['introduction_banner'];
            echo '<div class="col-12 col-md-11 col-xl-10 mx-auto px-0">';
                echo '<div class="swiper swiper-introduction-banner mt-0 mt-md-4">';
                if( !empty($introduction_banner) ) {
                        echo '<div class="swiper-wrapper">';
                        foreach($introduction_banner as $banner) {
                            $banner_image = $banner['banner_image'];
                            $banner_image_mobile = $banner['banner_image_mobile'];
                            $banner_link = $banner['banner_link'];
                        ?>
                            <div class="swiper-slide">
                                <?php if( !empty($banner_link['url']) ) : ?><a href="<?= $banner_link['url'];?>"><?php endif;?>
                                    <source srcset="<?= $banner_image['url'];?>" media="(min-width: 1200px)"/>
                                    <img src="<?= $banner_image_mobile['url'];?>" class="img-fluid w-100" alt="<?= $banner_image['alt'];?>"/>
                                <?php if( !empty($banner_link['url']) ) : ?></a><?php endif;?>
                            </div>
                        <?php
                        }
                        echo '</div>';
                        echo '<div class="intro-banner-pagination"></div>';
                    echo '</div>';
                }
                echo '<div class="d-none d-xl-block"><hr class="mt-5"></div>';
                
            echo '</div>';
            ?>
                <div class="col-12 col-md-11 col-xl-10 mx-auto px-0 d-md-none">
                    <div class="mobile-cta">
                        <?php 
                        $side_menu = get_field('side_menu', 'option');
                        $call_to_action = $side_menu['call_to_action'];
                        foreach($call_to_action as $btn) {
                            $button = $btn['button_link'];
                            $button_link = $button['url'];
                            $button_color = $btn['button_color'];
                            if( empty($button_link) ) { 
                                $button_link = 'javascript:void(0);';
                            }
                        ?>
                            <a href="<?= $button_link;?>" class="btn btn-<?= $button_color['value'];?>" target="<?= $button['target'];?>"><span><?= $button['title'];?></span></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="homepage-pre-content">
                    <?= do_shortcode('[game_provider_slider game_type="slots"]');?>
                    <?= do_shortcode('[game_provider_slider game_type="live-casino"]');?>
                    <?= do_shortcode('[game_provider_slider game_type="recommended"]');?>
                    
                    <div class="col-12 col-md-11 col-xl-10 px-4 px-md-0">
                        <div class="game-result-listing pt-4 pt-md-0">
                            <?= do_shortcode('[game_result_board result_board="deposit"]');?>
                            <?= do_shortcode('[game_result_board result_board="withdrawal"]');?>
                            <?= do_shortcode('[game_result_board result_board="top_winners"]');?>
                        </div>
                    </div>
                </div>

                <div class="section py-4">
                    <div class="section-inner py-md-4">
                        <div class="col-12 col-md-11 col-xl-10 px-4 px-md-0 mx-auto">
                            <picture>
                                <source media="(min-width: 1200px)" srcset="<?= home_url();?>/wp-content/uploads/2026/02/desktop-bottom-sg-en.webp">
                                <img src="<?= home_url();?>/wp-content/uploads/2026/02/mobile-bottom-sg-en.webp"/>
                            </picture>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
            <div class="elementor-page-content"><?php the_content(); ?></div>

		<?php astra_primary_content_bottom(); ?>

	</div>

<?php get_footer(); ?>
