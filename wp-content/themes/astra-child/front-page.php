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
        $homepage = get_field('homepage', 'option');
        $introduction_banner = $homepage['introduction_banner'];
        if( !empty($introduction_banner) ) {
            echo '<div class="swiper swiper-introduction-banner">';
                echo '<div class="swiper-wrapper">';
                foreach($introduction_banner as $banner) {
                    $banner_image = $banner['banner_image'];
                    $banner_link = $banner['banner_link'];
                ?>
                    <div class="swiper-slide">
                        <?php if( !empty($banner_link['url']) ) : ?><a href="<?= $banner_link['url'];?>"><?php endif;?>
                            <img src="<?= $banner_image['url'];?>" class="img-fluid w-100" alt="<?= $banner_image['alt'];?>"/>
                        <?php if( !empty($banner_link['url']) ) : ?></a><?php endif;?>
                    </div>
                <?php
                }
                echo '</div>';
                echo '<div class="intro-banner-pagination"></div>';
            echo '</div>';
        }
        echo '<div class="d-none d-lg-block"><hr class="mt-5"></div>';
        ?>

		<div class="elementor-page-content"><?php the_content(); ?></div>

		<?php astra_primary_content_bottom(); ?>

	</div>

<?php get_footer(); ?>
