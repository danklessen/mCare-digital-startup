<?php

/**
 * Register sidebars
 */
function exito_widgets_init() {
	
	global $exito_options;
	
	//	Blog Sidebar
	register_sidebar( array(
		'name'          	=> esc_html__( 'Blog Sidebar', 'exito' ),
		'id'            	=> 'blog-sidebar',
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h4 class="widget-title">',
		'after_title'   	=> '</h4>',
	) );
	
	//	Prefooter Area
	$exito_widgets_grid = isset( $exito_options['prefooter_col'] ) ? $exito_options['prefooter_col'] : '4-4-4';
	$i = 1;
	foreach (explode('-', $exito_widgets_grid) as $exito_widgets_g) {
		register_sidebar(array(
			'name' 				=> esc_html__('Prefooter Area ', 'exito') . $i,
			'id' 				=> "footer-area-$i",
			'description' 		=> esc_html__('The prefooter area widgets', 'exito'),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
			'after_widget' 		=> '</aside>',
			'before_title' 		=> '<h4 class="widget-title">',
			'after_title'   	=> '</h4>',
		));
		$i++;
	}
	
	//	Shop Sidebar
	if( exito_woo_enabled() ) {
		register_sidebar( array(
			'name'          	=> esc_html__( 'Shop Sidebar', 'exito' ),
			'id'            	=> 'shop-sidebar',
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  	=> '</aside>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   	=> '</h4>',
		) );
	}
	
	if (!empty($exito_options['unlimited_sidebar'])) {	
		if(isset($exito_options['unlimited_sidebar']) && sizeof($exito_options['unlimited_sidebar']) > 0) {
			foreach($exito_options['unlimited_sidebar'] as $exito_sidebar) {
				if (isset($exito_sidebar) && !empty($exito_sidebar)) {
					register_sidebar( array(
						'name' 				=> $exito_sidebar,
						'id' 				=> exito_generateSlug($exito_sidebar, 45),
						'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
						'after_widget' 		=> '</aside>',
						'before_title' 		=> '<h4 class="widget-title">',
						'after_title'   	=> '</h4>',
					));
				}
			}
		}
	}
	
}
add_action( 'widgets_init', 'exito_widgets_init' );


/**
 * Unlimited Sidebars
 */

function exito_generateSlug($phrase, $maxLength) {
    $result = strtolower($phrase);
    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    $result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", "-", $result);
    return $result;
}


/**
 * Include widgets
 */

require_once( get_template_directory() . '/inc/widgets/widget-flickr.php' );
require_once( get_template_directory() . '/inc/widgets/widget-posts.php' );
require_once( get_template_directory() . '/inc/widgets/widget-social.php' );