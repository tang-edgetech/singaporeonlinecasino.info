<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
if ( apply_filters( 'astra_header_profile_gmpg_link', true ) ) {
	?>
	<link rel="profile" href="https://gmpg.org/xfn/11"> 
	<?php
}
?>
<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
?>  
	<style type="text/css" id="hajimi">
		.elementor-widget-text-editor > * {
			font-family: inherit;
			font-size: inherit;
			line-height: inherit;
			font-weight: inherit;
			letter-spacing: inherit;
			text-decoration: inherit;
			text-transform: inherit;
			color: inherit;
		}
		.elementor-widget-text-editor > a, .elementor-widget-text-editor p > a, .elementor-widget-text-editor li > a, .elementor-text-editor > a, .elementor-text-editor p > a, .elementor-text-editor li > a {
			color: #ff0031;
		}
		.elementor-widget-text-editor > a:hover, .elementor-widget-text-editor p > a:hover, .elementor-widget-text-editor li > a:hover, .elementor-text-editor > a:hover, .elementor-text-editor p > a:hover, .elementor-text-editor li > a:hover {
			color: #666;
		}
		.elementor-widget-text-editor p, .elementor-text-editor p {
			margin: 0;
		}
		.elementor-widget-text-editor p+ul, .elementor-widget-text-editor p+ol, .elementor-text-editor > p+ul, .elementor-text-editor > p+ol {
			margin-top: 0.625rem;
			margin-bottom: 1.5rem;
		}
		.elementor-widget-text-editor > ul, .elementor-widget-text-editor > ol, .elementor-text-editor > ul, .elementor-text-editor > ol {
			margin-left: 0;
		}
		.elementor-widget-text-editor > ul:last-child, .elementor-widget-text-editor > ol:last-child, .elementor-text-editor > ul:last-child, .elementor-text-editor > ol:last-child {
			margin-bottom: 0;
		}
	</style>
<?php
}
?>
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>
<?php astra_body_top(); ?>
<?php wp_body_open(); ?>


<a
	class="skip-link screen-reader-text"
	href="#content">
		<?php echo esc_html( astra_default_strings( 'string-header-skip-link', false ) ); ?>
</a>

<div
<?php
	echo wp_kses_post(
		astra_attr(
			'site',
			array(
				'id'    => 'page',
				'class' => 'hfeed site',
			)
		)
	);
	?>
>
	<?php
	astra_header_before();

	astra_header();

	astra_header_after();

	astra_content_before();
	?>
	<div id="content" class="site-content">
		<div class="ast-container">
		<?php astra_content_top(); ?>
