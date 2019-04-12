<?php
/*
 * Plugin Name: 	Evatheme Visual Composer Extension
 * Description: 	This plugin extends Visual Composer.
 * Author: 			Evatheme Team
 * Author URI: 		http://evatheme.com
 * Version: 		1.0
 * Text Domain: 	evatheme-vc-extension
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if( class_exists('Ultimate_VC_Addons')) {
	
	//	Visual Composer custom shortcodes
	require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/cstheme_blog.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/cstheme_partners.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/cstheme_portfolio.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/cstheme_testimonials.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/cstheme_before-after.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/custom_params.php';
	
}

?>