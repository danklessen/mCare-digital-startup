<?php
/**
 * Blog Theme functions and definitions
 */


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

/**
 * 	Exito Theme Setup
 */

if ( ! function_exists( 'exito_setup' ) ) :
function exito_setup() {

	//	Make theme available for translation.
	load_theme_textdomain( 'exito', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	//	Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	//	Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'exito' )
	) );

	//	Switch default core markup for search form, comment form, and comments
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	//	Enable support for Post Formats.
	function exito_post_type( $current_screen ) {
		if ( 'post' == $current_screen->post_type && 'post' == $current_screen->base ) {
			add_theme_support( 'post-formats', array('image', 'gallery', 'link', 'quote', 'audio', 'video'));
		}
	}
	add_action( 'current_screen', 'exito_post_type' );

	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'video') );
	add_post_type_support( 'portfolio', 'post-formats' );
	
	//This theme support custom header
    add_theme_support( 'custom-header' );

    //This theme support custom backgrounds
    add_theme_support( 'custom-backgrounds' );

}
endif; // exito_setup
add_action( 'after_setup_theme', 'exito_setup' );


/**
 * Include files
 */

//	Theme Functions
require_once ( get_template_directory() . '/inc/theme_functions.php' );

//	Theme style, jQuery
require_once ( get_template_directory() . '/inc/css-js.php' );

//	Plugin Recommendations
require_once ( get_template_directory() . '/inc/plugins/install-plugin.php' );

//	Load theme meta boxes
if(is_admin()) {
    require_once ( get_template_directory() . '/inc/metabox/metabox.php' );
}

//	Aqua Resizer
require_once( get_template_directory() . '/inc/aq_resizer.php' );

//	Widgets
require_once ( get_template_directory() . '/inc/widgets/widgets.php' );

//	Breadcrumbs
require_once( get_template_directory() . '/inc/breadcrumbs.php' );

//	WooCommerce
if(class_exists('Woocommerce')) {
	require_once( get_template_directory() .'/inc/woo_functions.php' );
}
