<?php

//	Admin Styles
function exito_admin_google_fonts_url(){
	
	$admin_google_font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
    return $admin_google_font_url;
}

function exito_admin_style() {
	
	#CSS
	wp_enqueue_style('exito-admin', get_template_directory_uri() . '/inc/assets/css/cstheme-admin.css');
	wp_enqueue_style('exito-redux', get_template_directory_uri() . '/inc/assets/css/evatheme-redux-options.css');
	wp_enqueue_style('exito-admin-google-fonts', exito_admin_google_fonts_url(), array(), '1.0.0' );
	
	#JS
	wp_enqueue_script('exito-admin', get_template_directory_uri() . '/inc/assets/js/cstheme-admin.js', array( 'jquery' ), '', true);
	
}
add_action('admin_enqueue_scripts', 'exito_admin_style');

/* Register Google Fonts */
function exito_google_fonts_url() {
	
	$google_font_url = add_query_arg( 'family', urlencode( 'Ubuntu:300,400,500|Lato:300&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
	
    return $google_font_url;
}

#Frontend
if ( !function_exists('exito_css_js_register')) {
	function exito_css_js_register(){
		
		global $post, $exito_options;
		
		$exito_postId = ( isset( $post->ID ) ? get_the_ID() : NULL );
		
		$exito_post_single_style = '';
		$exito_post_single_style = get_post_meta( $exito_postId, 'exito_post_single_style', true );
		
		$exito_header_style = 'header-top';
		
		#CSS
		wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
		wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');
		wp_enqueue_style('exito-evathemeicons', get_template_directory_uri() . '/assets/css/Evatheme-Icon-Fonts.css');
		wp_enqueue_style('swipebox', get_template_directory_uri() . '/assets/css/plugins/swipebox.min.css', array(), '1.4.4');
		wp_enqueue_style('exito-owlcarousel', get_template_directory_uri() . '/assets/css/custom-owlcarousel.css');
		if (exito_woo_enabled()) {
			wp_enqueue_style('exito-woo', get_template_directory_uri() . '/assets/css/custom-woo.css');
		}
		wp_enqueue_style('exito-theme', get_template_directory_uri() . '/assets/css/theme-style.css');
		wp_enqueue_style('exito-responsive', get_template_directory_uri() . '/assets/css/responsive.css');
		wp_enqueue_style('exito-default', get_stylesheet_uri());
		
		if( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
			wp_enqueue_style('exito-google-fonts', exito_google_fonts_url(), array(), '1.0.0' );
		}

		#JS
		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '3.3.4', true);
		wp_enqueue_script('swipebox', get_template_directory_uri() . '/assets/js/plugins/jquery.swipebox.min.js', 'jquery', '1.4.4', true);
		wp_enqueue_script('mousewheel', get_template_directory_uri() . '/assets/js/jquery.mousewheel.js', array( 'jquery' ), '3.1.9', true);
		wp_enqueue_script('exito-fluidbox', get_template_directory_uri() . '/assets/js/custom-fluidbox.js', array(), '', true);
		wp_enqueue_script('owlcarousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), false, true);
		wp_enqueue_script('exito-isotope', get_template_directory_uri() . '/assets/js/custom-isotope.js', array('jquery'), false, true);
		
		$exito_func_fixed_sidebar = isset( $exito_options['func_fixed_sidebar'] ) ? $exito_options['func_fixed_sidebar'] : '0';
		if( $exito_func_fixed_sidebar != '0' && $exito_post_single_style != 'fullscreen' ) {
			wp_enqueue_script('exito-stickysidebar', get_template_directory_uri() . '/assets/js/custom-stickysidebar.js', array(), false, true);
		}
		if (exito_woo_enabled()) {
			if( is_singular('product') ){
				wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/plugins/slick.min.js', array( 'jquery' ), '1.6.0', true);
			}
			wp_enqueue_script('exito-woo', get_template_directory_uri() . '/assets/js/custom-woo.js', array( 'jquery' ), '', true);
		}
		wp_enqueue_script('exito-script', get_template_directory_uri() . '/assets/js/theme-script.js', array( 'jquery' ), '', true);
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		//	Coming Soon Page
		if( get_page_template_slug() == "page-comingsoon.php" ) {
			
			$exito_comings_soon_years 	= get_post_meta( $post->ID, 'exito_comings_soon_years', true );
			$exito_comings_soon_months 	= get_post_meta( $post->ID, 'exito_comings_soon_months', true );
			$exito_comings_soon_days 	= get_post_meta( $post->ID, 'exito_comings_soon_days', true );
			
			wp_add_inline_script( 'exito-script', '
				
				jQuery(document).ready(function() {
					jQuery(".countdown").downCount({
						date: "'. esc_html( $exito_comings_soon_months ) .'/'. esc_html( $exito_comings_soon_days ) .'/'. esc_html( $exito_comings_soon_years ) .' 12:00:00"
					});
				});
			
			' );
			
		}

	}
}
add_action('wp_enqueue_scripts', 'exito_css_js_register');


/* Custom styles */
function exito_custom_styles() {
	
	global $post, $exito_options;
	
	wp_enqueue_style( 'exito_inline_custom_style', get_template_directory_uri() . '/assets/css/cstheme_custom_styles.css' );
	
	$exito_postId = ( isset( $post->ID ) ? get_the_ID() : NULL );
	
	$exito_theme_color 					= isset( $exito_options['theme_color'] ) ? $exito_options['theme_color'] : '#ffb500';
	$exito_header_bg_style 				= isset( $exito_options['header_bg_style'] ) ? $exito_options['header_bg_style'] : 'bgcolor';
	$exito_header_page_bg_style 		= get_post_meta( $exito_postId, 'exito_header_page_bg_style', true );
	$exito_header_bgcolor 				= isset( $exito_options['header_bgcolor'] ) ? $exito_options['header_bgcolor'] : '#222222';
	$exito_header_color 				= isset( $exito_options['header_color'] ) ? $exito_options['header_color'] : '#ffffff';
	$exito_headersubmenu_font_family 	= isset( $exito_options['headersubmenu_font']['font-family'] ) ? $exito_options['headersubmenu_font']['font-family'] : 'Ubuntu';
	$exito_headersubmenu_font_transform = isset( $exito_options['headersubmenu_font']['text-transform'] ) ? $exito_options['headersubmenu_font']['text-transform'] : 'none';
	$exito_headersubmenu_font_weight 	= isset( $exito_options['headersubmenu_font']['font-weight'] ) ? $exito_options['headersubmenu_font']['font-weight'] : '300';
	$exito_headersubmenu_font_height 	= isset( $exito_options['headersubmenu_font']['line-height'] ) ? $exito_options['headersubmenu_font']['line-height'] : '20px';
	$exito_headersubmenu_font_size 		= isset( $exito_options['headersubmenu_font']['font-size'] ) ? $exito_options['headersubmenu_font']['font-size'] : '14px';
	$exito_headersubmenu_font_color 	= isset( $exito_options['headersubmenu_font']['color'] ) ? $exito_options['headersubmenu_font']['color'] : '#ffffff';
	$exito_headersubmenu_font_spacing 	= isset( $exito_options['headersubmenu_font']['letter-spacing'] ) ? $exito_options['headersubmenu_font']['letter-spacing'] : '0px';
	$exito_headermenu_hover_color 		= isset( $exito_options['headermenu_hover_color'] ) ? $exito_options['headermenu_hover_color'] : '#ffb500';
	$exito_headersubmenu_bgcolor 		= isset( $exito_options['headersubmenu_bgcolor'] ) ? $exito_options['headersubmenu_bgcolor'] : '#222222';
	$exito_headersubmenu_hover_bgcolor 	= isset( $exito_options['headersubmenu_hover_bgcolor'] ) ? $exito_options['headersubmenu_hover_bgcolor'] : '#191919';
	$exito_header_style 				= 'header-top';
	$exito_header_left_bgcolor 			= isset( $exito_options['header_left_bgcolor'] ) ? $exito_options['header_left_bgcolor'] : '#2d2f31';
	$exito_header_left_color 			= isset( $exito_options['header_left_color'] ) ? $exito_options['header_left_color'] : '#ffffff';
	$exito_prefooter_bgcolor 			= isset( $exito_options['prefooter_bgcolor'] ) ? $exito_options['prefooter_bgcolor'] : '#2d2f31';
	$exito_prefooter_color 				= isset( $exito_options['prefooter_color'] ) ? $exito_options['prefooter_color'] : '#999999';
	$exito_footer_bgcolor 				= isset( $exito_options['footer_bgcolor'] ) ? $exito_options['footer_bgcolor'] : '#1e1e1e';
	$exito_footer_color 				= isset( $exito_options['footer_color'] ) ? $exito_options['footer_color'] : '#b7b7b7';
	$exito_portfolio_overlay 			= isset( $exito_options['portfolio_overlay'] ) ? $exito_options['portfolio_overlay'] : '#333333';
	$exito_portfolio_overlay_opacity 	= isset( $exito_options['portfolio_overlay_opacity'] ) ? $exito_options['portfolio_overlay_opacity'] : '85';
	$exito_portfolio_filter_color 		= isset( $exito_options['portfolio_filter_color'] ) ? $exito_options['portfolio_filter_color'] : '#333333';
	$exito_prefooter_headings_family 	= isset( $exito_options['prefooter_headings']['font-family'] ) ? $exito_options['prefooter_headings']['font-family'] : 'Ubuntu';
	$exito_prefooter_headings_transform = isset( $exito_options['prefooter_headings']['text-transform'] ) ? $exito_options['prefooter_headings']['text-transform'] : 'none';
	$exito_prefooter_headings_weight 	= isset( $exito_options['prefooter_headings']['font-weight'] ) ? $exito_options['prefooter_headings']['font-weight'] : '500';
	$exito_prefooter_headings_height 	= isset( $exito_options['prefooter_headings']['line-height'] ) ? $exito_options['prefooter_headings']['line-height'] : '28px';
	$exito_prefooter_headings_size 		= isset( $exito_options['prefooter_headings']['font-size'] ) ? $exito_options['prefooter_headings']['font-size'] : '18px';
	$exito_prefooter_headings_color 	= isset( $exito_options['prefooter_headings']['color'] ) ? $exito_options['prefooter_headings']['color'] : '#ffffff';
	$exito_prefooter_headings_spacing 	= isset( $exito_options['prefooter_headings']['letter-spacing'] ) ? $exito_options['prefooter_headings']['letter-spacing'] : '0px';
	$exito_headermenu_font_family 		= isset( $exito_options['headermenu_font']['font-family'] ) ? $exito_options['headermenu_font']['font-family'] : 'Ubuntu';
	$exito_headermenu_font_transform 	= isset( $exito_options['headermenu_font']['text-transform'] ) ? $exito_options['headermenu_font']['text-transform'] : 'none';
	$exito_headermenu_font_weight 		= isset( $exito_options['headermenu_font']['font-weight'] ) ? $exito_options['headermenu_font']['font-weight'] : '500';
	$exito_headermenu_font_height 		= isset( $exito_options['headermenu_font']['line-height'] ) ? $exito_options['headermenu_font']['line-height'] : '20px';
	$exito_headermenu_font_size 		= isset( $exito_options['headermenu_font']['font-size'] ) ? $exito_options['headermenu_font']['font-size'] : '16px';
	$exito_headermenu_font_color 		= isset( $exito_options['headermenu_font']['color'] ) ? $exito_options['headermenu_font']['color'] : '#ffffff';
	$exito_headermenu_font_spacing 		= isset( $exito_options['headermenu_font']['letter-spacing'] ) ? $exito_options['headermenu_font']['letter-spacing'] : '0px';
	$exito_heading_font_family 			= isset( $exito_options['h1-font']['font-family'] ) ? $exito_options['h1-font']['font-family'] : 'Ubuntu';
	$exito_body_font_family 			= isset( $exito_options['body-font']['font-family'] ) ? $exito_options['body-font']['font-family'] : 'Ubuntu';
	$exito_body_font_transform 			= isset( $exito_options['body-font']['text-transform'] ) ? $exito_options['body-font']['text-transform'] : 'none';
	$exito_body_font_weight 			= isset( $exito_options['body-font']['font-weight'] ) ? $exito_options['body-font']['font-weight'] : '300';
	$exito_body_font_height 			= isset( $exito_options['body-font']['line-height'] ) ? $exito_options['body-font']['line-height'] : '28px';
	$exito_body_font_size 				= isset( $exito_options['body-font']['font-size'] ) ? $exito_options['body-font']['font-size'] : '16px';
	$exito_body_font_color 				= isset( $exito_options['body-font']['color'] ) ? $exito_options['body-font']['color'] : '#222';
	$exito_body_font_spacing 			= isset( $exito_options['body-font']['letter-spacing'] ) ? $exito_options['body-font']['letter-spacing'] : '0px';

	// Theme / Page Background Stylings
	$exito_page_bg_styles = $exito_page_bg_image = $exito_page_bg_image_repeat = $exito_page_bg_color = $exito_page_bg_attachment = $exito_page_bg_position = $exito_page_bg_cover = $exito_page_text_color = $exito_theme_boxed_margin = '';
	$exito_page_bg_image = get_post_meta( $exito_postId, 'exito_page_bg_image', true );

	if ( $exito_page_bg_image ) {
		if ( is_numeric( $exito_page_bg_image ) ) {
			$exito_page_bg_image = wp_get_attachment_image_src( $exito_page_bg_image, 'full' );
			$exito_page_bg_image = $exito_page_bg_image[0];
		}
	}

	$exito_page_bg_image_repeat 	= get_post_meta( $exito_postId, 'exito_page_bg_repeat', true );
	$exito_page_bg_color 			= get_post_meta( $exito_postId, 'exito_page_bg_color', true );
	$exito_page_bg_attachment 		= get_post_meta( $exito_postId, 'exito_page_bg_attachment', true );
	$exito_page_bg_position 		= get_post_meta( $exito_postId, 'exito_page_bg_position', true );
	$exito_page_bg_cover 			= get_post_meta( $exito_postId, 'exito_page_bg_full', true );
	$exito_page_text_color 			= get_post_meta( $exito_postId, 'exito_page_text_color', true );

	$exito_theme_bg_image = $exito_theme_bg_image_repeat = $exito_theme_bg_color = $exito_theme_bg_attachment = $exito_theme_bg_position = $exito_theme_bg_cover = '';
	if( isset( $exito_options['theme_bg_image'] ) ) {
		if( isset( $exito_options['theme_bg_image']['background-image'] ) && $exito_options['theme_bg_image']['background-image'] != '' ) {
			$exito_theme_bg_image = $exito_options['theme_bg_image']['background-image'];
		}
		if( isset( $exito_options['theme_bg_image']['background-repeat'] ) && $exito_options['theme_bg_image']['background-repeat'] != '' ) {
			$exito_theme_bg_image_repeat = $exito_options['theme_bg_image']['background-repeat'];
		}
		if( isset( $exito_options['theme_bg_image']['background-attachment'] ) && $exito_options['theme_bg_image']['background-attachment'] != '' ) {
			$exito_theme_bg_attachment = $exito_options['theme_bg_image']['background-attachment'];
		}
		if( isset( $exito_options['theme_bg_image']['background-position'] ) && $exito_options['theme_bg_image']['background-position'] != '' ) {
			$exito_theme_bg_position = $exito_options['theme_bg_image']['background-position'];
		}
		if( isset( $exito_options['theme_bg_image']['background-size'] ) && $exito_options['theme_bg_image']['background-size'] != '' ) {
			$exito_theme_bg_cover = $exito_options['theme_bg_image']['background-size'];
		}
	}
	if( isset( $exito_options['theme_bg_image']['background-color'] ) && $exito_options['theme_bg_image']['background-color'] != '' ) {
		$exito_theme_bg_color = $exito_options['theme_bg_image']['background-color'];
	}

	$exito_page_bg_image 		= ! empty( $exito_page_bg_image ) ? $exito_page_bg_image : $exito_theme_bg_image;
	$exito_page_bg_color 		= ! empty( $exito_page_bg_color ) ? $exito_page_bg_color : $exito_theme_bg_color;
	$exito_page_bg_image_repeat = ! empty( $exito_page_bg_image_repeat ) ? $exito_page_bg_image_repeat : $exito_theme_bg_image_repeat;
	$exito_page_bg_attachment 	= ! empty( $exito_page_bg_attachment ) ? $exito_page_bg_attachment : $exito_theme_bg_attachment;
	$exito_page_bg_position 	= ! empty( $exito_page_bg_position ) ? $exito_page_bg_position : $exito_theme_bg_position;
	$exito_page_bg_cover 		= ! empty( $exito_page_bg_cover ) ? $exito_page_bg_cover : $exito_theme_bg_cover;

	if( isset( $exito_page_bg_image ) && $exito_page_bg_image != '' ) {
		$exito_page_bg_styles .= 'background-image: url('. $exito_page_bg_image .');';
		if( isset( $exito_page_bg_image_repeat ) && $exito_page_bg_image_repeat != '' ) {
			$exito_page_bg_styles .= 'background-repeat: '. $exito_page_bg_image_repeat .';';
		}
		if( isset( $exito_page_bg_attachment ) && $exito_page_bg_attachment != '' ) {
			$exito_page_bg_styles .= 'background-attachment: '. $exito_page_bg_attachment .';';
		}
		if( isset( $exito_page_bg_position ) && $exito_page_bg_position != '' ) {
			$exito_page_bg_styles .= 'background-position: '. $exito_page_bg_position .';';
		}
		if( isset( $exito_page_bg_cover ) && $exito_page_bg_cover != '' ) {
			$exito_page_bg_styles .= 'background-size: '. $exito_page_bg_cover .';';
			$exito_page_bg_styles .= '-moz-background-size: '. $exito_page_bg_cover .';';
			$exito_page_bg_styles .= '-webkit-background-size: '. $exito_page_bg_cover .';';
			$exito_page_bg_styles .= '-o-background-size: '. $exito_page_bg_cover .';';
			$exito_page_bg_styles .= '-ms-background-size: '. $exito_page_bg_cover .';';
		}
	}

	if( isset( $exito_page_bg_color ) && $exito_page_bg_color != '' ) {
		$exito_page_bg_styles .= 'background-color: '. $exito_page_bg_color .';';
	}

	
	$exito_theme_boxed_margin = isset( $exito_options['theme_boxed_margin'] ) ? $exito_options['theme_boxed_margin'] : '0';
	
	$exito_header_bg_style = !empty( $exito_header_page_bg_style ) ? $exito_header_page_bg_style : $exito_header_bg_style;
	
	if ( isset( $exito_header_bg_style ) ) {
		$exito_header_bgcolor_opacity = $exito_options['header_bgcolor_opacity'];
	} else {
		$exito_header_bgcolor_opacity = '99';
	}
	
	$exito_header_gradient_from = isset( $exito_options['header_gradient']['from'] ) ? $exito_options['header_gradient']['from'] : '#000000';
	$exito_header_gradient_to = isset( $exito_options['header_gradient']['to'] ) ? $exito_options['header_gradient']['to'] : 'transparent';
	
	if ( ( $exito_header_bg_style != 'gradient' ) || ( is_singular('portfolio') && $exito_options['portfolio_single_pagetitle'] != 'show' ) || is_search() ) {
		$exito_headertop_bg = '
			body.header-top header.header-top .header_bg{
				opacity: 0.' . $exito_header_bgcolor_opacity . ' ;
				background-color: ' . $exito_header_bgcolor . ';
			}
		';
	} else {
		$exito_headertop_bg = '
			body.header-top header.header-top .header_bg{
				height:200%;
				opacity:1;
				background: -moz-linear-gradient(top, ' . $exito_header_gradient_from . ' 0%, ' . $exito_header_gradient_to . ' 100%);
				background: -webkit-linear-gradient(top, ' . $exito_header_gradient_from . ' 0%,' . $exito_header_gradient_to . ' 100%);
				background: linear-gradient(to bottom, ' . $exito_header_gradient_from . ' 0%,' . $exito_header_gradient_to . ' 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="' . $exito_header_gradient_from . '", endColorstr="' . $exito_header_gradient_to . '",GradientType=0 );
			}
			body.header-top.pagetitle_hide.header-fixed .header_bg {height:100%; background-color: ' . $exito_header_bgcolor . ';}
			body.single-product.header-top.pagetitle_hide .header_bg {height:auto; background-color: ' . $exito_header_bgcolor . ';}
			header.header-top .menu-primary-menu-container-wrap ul.nav-menu > li:hover > a,
			header.header-top .menu-primary-menu-container-wrap ul.nav-menu > li.current_page_item > a,
			header.header-top .menu-primary-menu-container-wrap ul.nav-menu > li.current-menu-item > a{
				color: ' . $exito_headermenu_hover_color . ' !important;
			}
		';
	}
	
	// Breadcrumbs
	$exito_breadcrumbs_bgcolor = isset( $exito_options['breadcrumbs_bgcolor'] ) ? $exito_options['breadcrumbs_bgcolor'] : '#f2f2f2';
	$exito_breadcrumbs_color = isset( $exito_options['breadcrumbs_color'] ) ? $exito_options['breadcrumbs_color'] : '#999999';
	
	
	// Page Title Background Stylings
	$exito_pagetitle_bg_styles = $exito_pagetitle_bg_image = $exito_pagetitle_bg_image_repeat = $exito_pagetitle_bg_color = $exito_pagetitle_bg_attachment = $exito_pagetitle_bg_position = $exito_pagetitle_bg_cover = $exito_pagetitle_text_color = $exito_post_single_style = '';
	$exito_pagetitle_bg_image = get_post_meta( $exito_postId, 'exito_pagetitle_bg_image', true );
	$exito_post_single_style = get_post_meta( $exito_postId, 'exito_post_single_style', true );

	if ( $exito_pagetitle_bg_image ) {
		if ( is_numeric( $exito_pagetitle_bg_image ) ) {
			$exito_pagetitle_bg_image = wp_get_attachment_image_src( $exito_pagetitle_bg_image, 'full' );
			$exito_pagetitle_bg_image = $exito_pagetitle_bg_image[0];
		}
	}

	$exito_pagetitle_bg_image_repeat 	= get_post_meta( $exito_postId, 'exito_pagetitle_bg_repeat', true );
	$exito_pagetitle_bg_color 			= get_post_meta( $exito_postId, 'exito_pagetitle_bg_color', true );
	$exito_pagetitle_bg_attachment 		= get_post_meta( $exito_postId, 'exito_pagetitle_bg_attachment', true );
	$exito_pagetitle_bg_position 		= get_post_meta( $exito_postId, 'exito_pagetitle_bg_position', true );
	$exito_pagetitle_bg_cover 			= get_post_meta( $exito_postId, 'exito_pagetitle_bg_full', true );
	$exito_pagetitle_text_color 		= get_post_meta( $exito_postId, 'exito_pagetitle_text_color', true );

	$exito_theme_pagetitle_bg_image = $exito_theme_pagetitle_bg_image_repeat = $exito_theme_pagetitle_bg_color = $exito_theme_pagetitle_bg_attachment = $exito_theme_pagetitle_bg_position = $exito_theme_pagetitle_bg_cover = $exito_theme_pagetitle_text_color = '';
	if( isset( $exito_options['pagetitle_bg_image'] ) ) {
		if( isset( $exito_options['pagetitle_bg_image']['background-image'] ) && $exito_options['pagetitle_bg_image']['background-image'] != '' ) {
			$exito_theme_pagetitle_bg_image = $exito_options['pagetitle_bg_image']['background-image'];
		}
		if( isset( $exito_options['pagetitle_bg_image']['background-repeat'] ) && $exito_options['pagetitle_bg_image']['background-repeat'] != '' ) {
			$exito_theme_pagetitle_bg_image_repeat = $exito_options['pagetitle_bg_image']['background-repeat'];
		}
		if( isset( $exito_options['pagetitle_bg_image']['background-attachment'] ) && $exito_options['pagetitle_bg_image']['background-attachment'] != '' ) {
			$exito_theme_pagetitle_bg_attachment = $exito_options['pagetitle_bg_image']['background-attachment'];
		}
		if( isset( $exito_options['pagetitle_bg_image']['background-position'] ) && $exito_options['pagetitle_bg_image']['background-position'] != '' ) {
			$exito_theme_pagetitle_bg_position = $exito_options['pagetitle_bg_image']['background-position'];
		}
		if( isset( $exito_options['pagetitle_bg_image']['background-size'] ) && $exito_options['pagetitle_bg_image']['background-size'] != '' ) {
			$exito_theme_pagetitle_bg_cover = $exito_options['pagetitle_bg_image']['background-size'];
		}
		if( isset( $exito_options['pagetitle_text_color'] ) && $exito_options['pagetitle_text_color'] != '' ) {
			$exito_theme_pagetitle_text_color = $exito_options['pagetitle_text_color'];
		}
	}
	if( isset( $exito_options['pagetitle_bg_image']['background-color'] ) && $exito_options['pagetitle_bg_image']['background-color'] != '' ) {
		$exito_theme_pagetitle_bg_color = $exito_options['pagetitle_bg_image']['background-color'];
	}

	//	If Blog
	if ( ( is_home() || is_singular('post') || is_category() || is_tag() || is_search() || is_day() || is_month() || is_year() ) && isset( $exito_options['blog_pagetitle_bg_image'] ) ) {
		if( isset( $exito_options['blog_pagetitle_bg_image']['background-image'] ) && $exito_options['blog_pagetitle_bg_image']['background-image'] != '' ) {
			$exito_theme_pagetitle_bg_image = $exito_options['blog_pagetitle_bg_image']['background-image'];
		}
		if( isset( $exito_options['blog_pagetitle_bg_image']['background-repeat'] ) && $exito_options['blog_pagetitle_bg_image']['background-repeat'] != '' ) {
			$exito_theme_pagetitle_bg_image_repeat = $exito_options['blog_pagetitle_bg_image']['background-repeat'];
		}
		if( isset( $exito_options['blog_pagetitle_bg_image']['background-attachment'] ) && $exito_options['blog_pagetitle_bg_image']['background-attachment'] != '' ) {
			$exito_theme_pagetitle_bg_attachment = $exito_options['blog_pagetitle_bg_image']['background-attachment'];
		}
		if( isset( $exito_options['blog_pagetitle_bg_image']['background-position'] ) && $exito_options['blog_pagetitle_bg_image']['background-position'] != '' ) {
			$exito_theme_pagetitle_bg_position = $exito_options['blog_pagetitle_bg_image']['background-position'];
		}
		if( isset( $exito_options['blog_pagetitle_bg_image']['background-size'] ) && $exito_options['blog_pagetitle_bg_image']['background-size'] != '' ) {
			$exito_theme_pagetitle_bg_cover = $exito_options['blog_pagetitle_bg_image']['background-size'];
		}
		if( isset( $exito_options['pagetitle_text_color'] ) && $exito_options['pagetitle_text_color'] != '' ) {
			$exito_theme_pagetitle_text_color = $exito_options['pagetitle_text_color'];
		}
	} else if ( is_singular('portfolio') && isset( $exito_options['portfolio_single_pagetitle_bg_image'] ) ) {
		if( isset( $exito_options['portfolio_single_pagetitle_bg_image']['background-image'] ) && $exito_options['portfolio_single_pagetitle_bg_image']['background-image'] != '' ) {
			$exito_theme_pagetitle_bg_image = $exito_options['portfolio_single_pagetitle_bg_image']['background-image'];
		}
		if( isset( $exito_options['portfolio_single_pagetitle_bg_image']['background-repeat'] ) && $exito_options['portfolio_single_pagetitle_bg_image']['background-repeat'] != '' ) {
			$exito_theme_pagetitle_bg_image_repeat = $exito_options['portfolio_single_pagetitle_bg_image']['background-repeat'];
		}
		if( isset( $exito_options['portfolio_single_pagetitle_bg_image']['background-attachment'] ) && $exito_options['portfolio_single_pagetitle_bg_image']['background-attachment'] != '' ) {
			$exito_theme_pagetitle_bg_attachment = $exito_options['portfolio_single_pagetitle_bg_image']['background-attachment'];
		}
		if( isset( $exito_options['portfolio_single_pagetitle_bg_image']['background-position'] ) && $exito_options['portfolio_single_pagetitle_bg_image']['background-position'] != '' ) {
			$exito_theme_pagetitle_bg_position = $exito_options['portfolio_single_pagetitle_bg_image']['background-position'];
		}
		if( isset( $exito_options['portfolio_single_pagetitle_bg_image']['background-size'] ) && $exito_options['portfolio_single_pagetitle_bg_image']['background-size'] != '' ) {
			$exito_theme_pagetitle_bg_cover = $exito_options['portfolio_single_pagetitle_bg_image']['background-size'];
		}
		if( isset( $exito_options['portfolio_single_pagetitle_text_color'] ) && $exito_options['portfolio_single_pagetitle_text_color'] != '' ) {
			$exito_theme_pagetitle_text_color = $exito_options['portfolio_single_pagetitle_text_color'];
		}
	}
	if( ( is_home() || is_singular('post') || is_category() || is_tag() || is_search() || is_day() || is_month() || is_year() ) && isset( $exito_options['blog_pagetitle_bg_image']['background-color'] ) && $exito_options['blog_pagetitle_bg_image']['background-color'] != '' ) {
		$exito_theme_pagetitle_bg_color = $exito_options['blog_pagetitle_bg_image']['background-color'];
	}

	$exito_pagetitle_bg_image 			= ! empty( $exito_pagetitle_bg_image ) ? $exito_pagetitle_bg_image : $exito_theme_pagetitle_bg_image;
	$exito_pagetitle_bg_color 			= ! empty( $exito_pagetitle_bg_color ) ? $exito_pagetitle_bg_color : $exito_theme_pagetitle_bg_color;
	$exito_pagetitle_bg_image_repeat 	= ! empty( $exito_pagetitle_bg_image_repeat ) ? $exito_pagetitle_bg_image_repeat : $exito_theme_pagetitle_bg_image_repeat;
	$exito_pagetitle_bg_attachment 		= ! empty( $exito_pagetitle_bg_attachment ) ? $exito_pagetitle_bg_attachment : $exito_theme_pagetitle_bg_attachment;
	$exito_pagetitle_bg_position 		= ! empty( $exito_pagetitle_bg_position ) ? $exito_pagetitle_bg_position : $exito_theme_pagetitle_bg_position;
	$exito_pagetitle_bg_cover 			= ! empty( $exito_pagetitle_bg_cover ) ? $exito_pagetitle_bg_cover : $exito_theme_pagetitle_bg_cover;
	$exito_pagetitle_text_color 		= ! empty( $exito_pagetitle_text_color ) ? $exito_pagetitle_text_color : $exito_theme_pagetitle_text_color;

	if( isset( $exito_pagetitle_bg_image ) && $exito_pagetitle_bg_image != '' ) {
		$exito_pagetitle_bg_styles .= 'background-image: url('. $exito_pagetitle_bg_image .');';
		if( isset( $exito_pagetitle_bg_image_repeat ) && $exito_pagetitle_bg_image_repeat != '' ) {
			$exito_pagetitle_bg_styles .= 'background-repeat: '. $exito_pagetitle_bg_image_repeat .';';
		}
		if( isset( $exito_pagetitle_bg_attachment ) && $exito_pagetitle_bg_attachment != '' ) {
			$exito_pagetitle_bg_styles .= 'background-attachment: '. $exito_pagetitle_bg_attachment .';';
		}
		if( isset( $exito_pagetitle_bg_position ) && $exito_pagetitle_bg_position != '' ) {
			$exito_pagetitle_bg_styles .= 'background-position: '. $exito_pagetitle_bg_position .';';
		}
		if( isset( $exito_pagetitle_bg_cover ) && $exito_pagetitle_bg_cover != '' ) {
			$exito_pagetitle_bg_styles .= 'background-size: '. $exito_pagetitle_bg_cover .';';
			$exito_pagetitle_bg_styles .= '-moz-background-size: '. $exito_pagetitle_bg_cover .';';
			$exito_pagetitle_bg_styles .= '-webkit-background-size: '. $exito_pagetitle_bg_cover .';';
			$exito_pagetitle_bg_styles .= '-o-background-size: '. $exito_pagetitle_bg_cover .';';
			$exito_pagetitle_bg_styles .= '-ms-background-size: '. $exito_pagetitle_bg_cover .';';
		}
	}

	if( isset( $exito_pagetitle_bg_color ) && $exito_pagetitle_bg_color != '' ) {
		$exito_pagetitle_bg_styles .= 'background-color: '. $exito_pagetitle_bg_color .';';
	}

	if( isset( $exito_pagetitle_text_color ) && $exito_pagetitle_text_color != '' ) {
		$exito_pagetitle_bg_styles .= 'color: '. $exito_pagetitle_text_color .';';
	}
	
	if ( is_singular('post') && $exito_post_single_style == 'fullscreen' ) {
		$exito_featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		$exito_pagetitle_bg_styles .= 'background-image: url('. $exito_featured_image_url .');';
	}
	
	
	//	Page 404
	$exito_page404_bg_styles = '';
	if ( is_404() ) {

		$exito_page404_bg_image = $exito_page404_bg_image_repeat = $exito_page404_bg_color = $exito_page404_bg_attachment = $exito_page404_bg_position = $exito_page404_bg_cover = '';
		if( isset( $exito_options['page404_bg_image'] ) ) {
			if( isset( $exito_options['page404_bg_image']['background-image'] ) && $exito_options['page404_bg_image']['background-image'] != '' ) {
				$exito_page404_bg_image = $exito_options['page404_bg_image']['background-image'];
			}
			if( isset( $exito_options['page404_bg_image']['background-repeat'] ) && $exito_options['page404_bg_image']['background-repeat'] != '' ) {
				$exito_page404_bg_image_repeat = $exito_options['page404_bg_image']['background-repeat'];
			}
			if( isset( $exito_options['page404_bg_image']['background-attachment'] ) && $exito_options['page404_bg_image']['background-attachment'] != '' ) {
				$exito_page404_bg_attachment = $exito_options['page404_bg_image']['background-attachment'];
			}
			if( isset( $exito_options['page404_bg_image']['background-position'] ) && $exito_options['page404_bg_image']['background-position'] != '' ) {
				$exito_page404_bg_position = $exito_options['page404_bg_image']['background-position'];
			}
			if( isset( $exito_options['page404_bg_image']['background-size'] ) && $exito_options['page404_bg_image']['background-size'] != '' ) {
				$exito_page404_bg_cover = $exito_options['page404_bg_image']['background-size'];
			}
		}
		if( isset( $exito_options['page404_bg_image']['background-color'] ) && $exito_options['page404_bg_image']['background-color'] != '' ) {
			$exito_page404_bg_color = $exito_options['page404_bg_image']['background-color'];
		}

		if( isset( $exito_page404_bg_image ) && $exito_page404_bg_image != '' ) {
			$exito_page404_bg_styles .= 'background-image: url('. $exito_page404_bg_image .');';
			if( isset( $exito_page404_bg_image_repeat ) && $exito_page404_bg_image_repeat != '' ) {
				$exito_page404_bg_styles .= 'background-repeat: '. $exito_page404_bg_image_repeat .';';
			}
			if( isset( $exito_page404_bg_attachment ) && $exito_page404_bg_attachment != '' ) {
				$exito_page404_bg_styles .= 'background-attachment: '. $exito_page404_bg_attachment .';';
			}
			if( isset( $exito_page404_bg_position ) && $exito_page404_bg_position != '' ) {
				$exito_page404_bg_styles .= 'background-position: '. $exito_page404_bg_position .';';
			}
			if( isset( $exito_page404_bg_cover ) && $exito_page404_bg_cover != '' ) {
				$exito_page404_bg_styles .= 'background-size: '. $exito_page404_bg_cover .';';
				$exito_page404_bg_styles .= '-moz-background-size: '. $exito_page404_bg_cover .';';
				$exito_page404_bg_styles .= '-webkit-background-size: '. $exito_page404_bg_cover .';';
				$exito_page404_bg_styles .= '-o-background-size: '. $exito_page404_bg_cover .';';
				$exito_page404_bg_styles .= '-ms-background-size: '. $exito_page404_bg_cover .';';
			}
		}

		if( isset( $exito_page404_bg_color ) && $exito_page404_bg_color != '' ) {
			$exito_page404_bg_styles .= 'background-color: '. $exito_page404_bg_color .';';
		}
	}
	
	
	//	WooCommerce
	$exito_pageshop_bg_styles = $exito_pageshop_bg_image = $exito_pageshop_bg_image_repeat = $exito_pageshop_bg_color = $exito_pageshop_bg_attachment = $exito_pageshop_bg_position = $exito_pageshop_bg_cover = $exito_shop_pagetitle_text_color = $exito_shop_pagetitle_text_color_set = '';
	if( class_exists('WooCommerce') && ( is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() ) ) {

		if( isset( $exito_options['pageshop_bg_image'] ) ) {
			if( isset( $exito_options['pageshop_bg_image']['background-image'] ) && $exito_options['pageshop_bg_image']['background-image'] != '' ) {
				$exito_pageshop_bg_image = $exito_options['pageshop_bg_image']['background-image'];
			}
			if( isset( $exito_options['pageshop_bg_image']['background-repeat'] ) && $exito_options['pageshop_bg_image']['background-repeat'] != '' ) {
				$exito_pageshop_bg_image_repeat = $exito_options['pageshop_bg_image']['background-repeat'];
			}
			if( isset( $exito_options['pageshop_bg_image']['background-attachment'] ) && $exito_options['pageshop_bg_image']['background-attachment'] != '' ) {
				$exito_pageshop_bg_attachment = $exito_options['pageshop_bg_image']['background-attachment'];
			}
			if( isset( $exito_options['pageshop_bg_image']['background-position'] ) && $exito_options['pageshop_bg_image']['background-position'] != '' ) {
				$exito_pageshop_bg_position = $exito_options['pageshop_bg_image']['background-position'];
			}
			if( isset( $exito_options['pageshop_bg_image']['background-size'] ) && $exito_options['pageshop_bg_image']['background-size'] != '' ) {
				$exito_pageshop_bg_cover = $exito_options['pageshop_bg_image']['background-size'];
			}
			if( isset( $exito_options['shop_pagetitle_text_color'] ) && $exito_options['shop_pagetitle_text_color'] != '' ) {
				$exito_shop_pagetitle_text_color = $exito_options['shop_pagetitle_text_color'];
			}
		}
		if( isset( $exito_options['pageshop_bg_image']['background-color'] ) && $exito_options['pageshop_bg_image']['background-color'] != '' ) {
			$exito_pageshop_bg_color = $exito_options['pageshop_bg_image']['background-color'];
		}

		if( isset( $exito_pageshop_bg_image ) && $exito_pageshop_bg_image != '' ) {
			$exito_pageshop_bg_styles .= 'background-image: url('. $exito_pageshop_bg_image .');';
			if( isset( $exito_pageshop_bg_image_repeat ) && $exito_pageshop_bg_image_repeat != '' ) {
				$exito_pageshop_bg_styles .= 'background-repeat: '. $exito_pageshop_bg_image_repeat .';';
			}
			if( isset( $exito_pageshop_bg_attachment ) && $exito_pageshop_bg_attachment != '' ) {
				$exito_pageshop_bg_styles .= 'background-attachment: '. $exito_pageshop_bg_attachment .';';
			}
			if( isset( $exito_pageshop_bg_position ) && $exito_pageshop_bg_position != '' ) {
				$exito_pageshop_bg_styles .= 'background-position: '. $exito_pageshop_bg_position .';';
			}
			if( isset( $exito_pageshop_bg_cover ) && $exito_pageshop_bg_cover != '' ) {
				$exito_pageshop_bg_styles .= 'background-size: '. $exito_pageshop_bg_cover .';';
				$exito_pageshop_bg_styles .= '-moz-background-size: '. $exito_pageshop_bg_cover .';';
				$exito_pageshop_bg_styles .= '-webkit-background-size: '. $exito_pageshop_bg_cover .';';
				$exito_pageshop_bg_styles .= '-o-background-size: '. $exito_pageshop_bg_cover .';';
				$exito_pageshop_bg_styles .= '-ms-background-size: '. $exito_pageshop_bg_cover .';';
			}
		}

		if( isset( $exito_pageshop_bg_color ) && $exito_pageshop_bg_color != '' ) {
			$exito_pageshop_bg_styles .= 'background-color: '. $exito_pageshop_bg_color .';';
		}
		
		if( isset( $exito_shop_pagetitle_text_color ) && $exito_shop_pagetitle_text_color != '' ) {
			$exito_shop_pagetitle_text_color_set .= 'color: '. $exito_shop_pagetitle_text_color .';';
		}
	}
	
	
	/* Custom CSS from Theme Options */
	$exito_options_custom_css = isset( $exito_options['custom_css'] ) ? $exito_options['custom_css'] : '';
	
	
	$exito_inline_custom_css = "
	
	body{
		font-family: $exito_body_font_family ;
		text-transform: $exito_body_font_transform ;
		font-weight: $exito_body_font_weight ;
		line-height: $exito_body_font_height ;
		font-size: $exito_body_font_size ;
		color: $exito_body_font_color ;
		letter-spacing: $exito_body_font_spacing ;
	}
	body.boxed {  }
	body.boxed{
		padding-top: $exito_theme_boxed_margin px;
		padding-bottom: $exito_theme_boxed_margin px;
		$exito_page_bg_styles
	}
	body.boxed footer.fixed.active{
		bottom: $exito_theme_boxed_margin px;
	}
	
	
	/* header */
	$exito_headertop_bg
	
	.header_wrap .menu_creative_btn span{
		background-color: $exito_headermenu_font_color !important;
	}
	.header_wrap .menu_creative_btn:hover span{ background-color: $exito_headermenu_hover_color !important; }
	.header_search_icon{ color: $exito_headermenu_font_color !important; }
	.header_search_icon:hover{ color: $exito_headermenu_hover_color !important; }
	.menu_creative_btn span{ background-color: $exito_header_color ; }
	.header_tagline:before{ background-color: $exito_header_color ; }
	.tagline_text_wrap a{ color: $exito_header_color !important; }
	.tagline_text_wrap a:hover i{ color: $exito_theme_color ; }
	header.header-top .social_links_wrap .social_link{ color: $exito_header_color !important; }
	.exito-logo h1 a{ color: $exito_header_color !important; }
	body.header-fixed header.header-top .header_wrap{ background-color: $exito_header_bgcolor ; }
	#page-wrap > header#header_mobile_wrap{ background-color: $exito_header_bgcolor ; }

	header.header-top .menu-primary-menu-container-wrap > div > ul > li > a,
	.menu_creative_block .menu-primary-menu-container-wrap > div > ul > li > a{
		font-family: $exito_headermenu_font_family ;
		text-transform: $exito_headermenu_font_transform ;
		font-weight: $exito_headermenu_font_weight ;
		line-height: $exito_headermenu_font_height ;
		font-size: $exito_headermenu_font_size ;
		color: $exito_headermenu_font_color ;
		letter-spacing: $exito_headermenu_font_spacing ;
	}
	header.header-top .menu-primary-menu-container-wrap .sub-menu li.menu-item a,
	.menu_creative_block li li a{
		font-family: $exito_headersubmenu_font_family ;
		text-transform: $exito_headersubmenu_font_transform ;
		font-weight: $exito_headersubmenu_font_weight ;
		line-height: $exito_headersubmenu_font_height;
		font-size: $exito_headersubmenu_font_size ;
		color: $exito_headersubmenu_font_color ;
		letter-spacing: $exito_headersubmenu_font_spacing ;
	}
	
	
	/* Menu */
	header.header-top .menu-primary-menu-container-wrap .sub-menu,
	header.header-top .menu-primary-menu-container-wrap .sub-menu .sub-menu{
		border-color: $exito_theme_color ;
		background-color: $exito_headersubmenu_bgcolor ;
	}
	header.header-top .menu-primary-menu-container-wrap > div > ul > li > a:hover,
	header.header-top .menu-primary-menu-container-wrap ul li.current_page_item > a,
	header.header-top .menu-primary-menu-container-wrap ul li.current-menu-item > a,
	header.header-top .menu-primary-menu-container-wrap li.current-menu-parent > a,
	header.header-top .menu-primary-menu-container-wrap li.current-menu-ancestor > a{
		color: $exito_headermenu_hover_color ;
	}
	#header_mobile_wrap .menu-primary-menu-container-wrap li a:hover,
	#header_mobile_wrap .menu-primary-menu-container-wrap ul li.current_page_item > a,
	#header_mobile_wrap .menu-primary-menu-container-wrap ul li.current-menu-item > a,
	#header_mobile_wrap .menu-primary-menu-container-wrap li.current-menu-parent > a,
	#header_mobile_wrap .menu-primary-menu-container-wrap li.current-menu-ancestor > a{
		color: $exito_theme_color ;
	}
	header.header-top .menu-primary-menu-container-wrap ul.nav-menu > li.current-menu-ancestor.menu-item > a{
		color: $exito_theme_color !important;
	}
	header.header-top .menu-primary-menu-container-wrap .sub-menu li a:after{
		color: $exito_headersubmenu_font_color ;
	}
	header.header-top .menu-primary-menu-container-wrap .sub-menu li.menu-item a:hover,
	header.header-top .menu-primary-menu-container-wrap .sub-menu li.current-menu-parent a,
	header.header-top .menu-primary-menu-container-wrap .sub-menu li.current_page_item a,
	header.header-top .menu-primary-menu-container-wrap .sub-menu .sub-menu li.menu-item a:hover,
	header.header-top .menu-primary-menu-container-wrap .sub-menu .sub-menu li.current-menu-parent a,
	header.header-top .menu-primary-menu-container-wrap .sub-menu .sub-menu li.current_page_item a{
		background-color: $exito_headersubmenu_hover_bgcolor ;
	}

	
	/* Mobile Menu */
	#header_mobile_wrap ul.nav-menu li a{
		color: $exito_headermenu_font_color ;
	}
	
	
	/* Page Title Background Stylings */
	#pagetitle { $exito_pagetitle_bg_styles }
	#pagetitle h2, #pagetitle a, #pagetitle p { color: $exito_pagetitle_text_color ; }
	

	/* Page 404 */
	#error404_container { $exito_page404_bg_styles }
	

	/* Breadcrumbs */
	#breadcrumbs{ background-color: $exito_breadcrumbs_bgcolor ; }
	#breadcrumbs a, #breadcrumbs span{ color: $exito_breadcrumbs_color ; }
	#breadcrumbs a:hover{ color: $exito_theme_color ; }
	
	/* Footer */
	footer #prefooter_area{ color: $exito_prefooter_color ; background-color: $exito_prefooter_bgcolor ; }
	footer #prefooter_area a{ color: $exito_prefooter_color ; }
	footer #prefooter_area a:hover{ color: $exito_theme_color ; }
	footer #prefooter_area .cstheme_widget_sociallinks .social_link{ color: $exito_prefooter_bgcolor ; }
	footer #footer_bottom{ color: $exito_footer_color ; background-color: $exito_footer_bgcolor ; }
	footer #footer_bottom .social_links_wrap .social_link{ color: $exito_footer_color !important; }
	footer #footer_bottom .social_links_wrap .social_link:hover{ color: $exito_theme_color !important; }
	footer .widget-title{
		font-family: $exito_prefooter_headings_family ;
		text-transform: $exito_prefooter_headings_transform ;
		font-weight: $exito_prefooter_headings_weight ;
		line-height: $exito_prefooter_headings_height ;
		font-size: $exito_prefooter_headings_size ;
		color: $exito_prefooter_headings_color ;
		letter-spacing: $exito_prefooter_headings_spacing ;
	}
	
	
	/* WooCommerce */
	.woocommerce #pagetitle, .woocommerce-page #pagetitle { $exito_pageshop_bg_styles }
	.woocommerce #pagetitle h2, .woocommerce #pagetitle p, .woocommerce-page #pagetitle h2, .woocommerce-page #pagetitle p{ $exito_shop_pagetitle_text_color_set }
	
	/* Shortcodes */
	.btn:hover,
	.btn-default:hover,
	.btn:focus,
	.btn-default.active,
	.btn-default.active:hover,
	.btn-default.focus,
	.btn-default:active,
	.btn-default:focus,
	.btn-primary,
	.btn.btn-primary,
	.btn-primary.active,
	.btn-primary.focus,
	.btn-primary:active,
	.btn-primary:focus{
		border-color: $exito_theme_color ;
		background: $exito_theme_color ;
	}
	
	blockquote:before, blockquote cite:before, blockquote small:before{ background-color: $exito_theme_color ; }
	blockquote cite, blockquote small, blockquote:after{ color: $exito_theme_color ; }
	
	/* Custom Colors */
	a:hover, a:focus{ color: $exito_theme_color ; }
	.single-post-content p a, .contentarea p a{ color: $exito_theme_color ; }
	::selection{ background: $exito_theme_color ; color:#fff; }
	::-moz-selection{ background: $exito_theme_color ; color:#fff; }
	.theme_color{ color: $exito_theme_color ; }
	.bg_primary{ background-color: $exito_theme_color ; }
	button:hover, input[type='button'], input[type='reset'], input[type='submit']:hover{ background-color: $exito_theme_color ; }
	input[type='text']:focus, input[type='email']:focus, input[type='url']:focus, input[type='password']:focus, input[type='search']:focus, textarea:focus, .wpcf7-form input:focus, .wpcf7-form textarea:focus{ color:#333; border-color: $exito_theme_color !important; background-color:#fff; }
	#blog-single-wrap.fullscreen .form_field:focus{ color:#333; border-color: $exito_theme_color ; background-color:#fff; }
	#loader .bar{ background-color: $exito_theme_color ; }
	.header_search i.fa-search:hover{ color: $exito_theme_color ; }
	.menu_creative_btn:hover span{ background-color: $exito_theme_color ; }
	.widget_meta li a:hover, .widget_archive li a:hover, .widget_categories li a:hover, .widget_product_categories li a:hover{ color: $exito_theme_color ; }
	.single_post_meta_tags a:hover, .tagcloud a:hover{ border-color: $exito_theme_color ; }
	.cstheme_widget_sociallinks .social_link:hover{ background-color: $exito_theme_color ; }
	#blog-single-wrap .sharebox .social_link:hover{ background-color: $exito_theme_color ; }
	.eva-pagination .page-numbers:hover{ border-color: $exito_theme_color ; }
	.eva-pagination .page-numbers.current{ border-color: $exito_theme_color ; background-color: $exito_theme_color ; }
	.post_content_readmore:before{ background-color: $exito_theme_color ; }
	.owl-controls .owl-dot:hover, .owl-controls .owl-dot.active{ box-shadow: 0 0 0 10px $exito_theme_color inset; }
	.format-link .post_format_content .featured_img_bg:before{ background-color: $exito_theme_color ; }
	#related_posts_list .post-title:before{ background-color: $exito_theme_color ; }
	.commentlist .comment-meta .comment-reply-link i{ color: $exito_theme_color ; }
	.form_search_block input[type='text']{ border-color: $exito_theme_color !important; }
	.form_search_block i.fa.fa-search{ background-color: $exito_theme_color ; }
	.post-image .play_btn i{ background-color: $exito_theme_color ; }
	.portfolio_descr_wrap .portfolio_title:before{ background-color: $exito_theme_color ; }
	#portfolio_list.grid .portfolio_descr_wrap .portfolio_title a:hover{ color: $exito_theme_color ; }
	#portfolio_list.masonry .portfolio_format_content i:hover:before, #portfolio_list.masonry .portfolio_format_content i:hover:after{ background-color: $exito_theme_color ; }
	aside h4.widget-title:before{ background-color: $exito_theme_color ; }
	.cstheme_comment_count:hover i{ color: $exito_theme_color ; }
	.cstheme_widget_instagram li a i:hover:before, .cstheme_widget_instagram li a i:hover:after{ background-color: $exito_theme_color ; }
	#portfolio_list.masonry_card .portfolio_title:before, #portfolio_list.grid_card .portfolio_title:before{ background-color: $exito_theme_color ; }
	#portfolio_list.left_img .portfolio_meta_category:before, #portfolio_list.chess .portfolio_meta_category:before, #portfolio_list.carousel .portfolio_meta_category:before{ background-color: $exito_theme_color ; }
	#portfolio_list.chess .portfolio_content_wrapper .portfolio_descr_wrap:before{ background-color: $exito_theme_color ; }
	#portfolio_list.carousel .portfolio_title a:hover{ color: $exito_theme_color ; }
	.partner_wrap.with_descr .partner_descr h6:before{ background-color: $exito_theme_color ; }
	#blog_list.masonry_bg_img .post_format_content:before{ background-color: $exito_theme_color ; }
	#blog_list.grid_card .post-descr-wrap .post-title:before{ background-color: $exito_theme_color ; }
	#blog_list.grid_card_min .post-descr-wrap .post-meta i, #blog_list.masonry_card_min .post-descr-wrap .post-meta i{ color: $exito_theme_color ; }
	#portfolio_list.rounded .portfolio_descr_wrap:before{ background-color: $exito_theme_color ; }
	#portfolio_list.grid_bg_img .portfolio_content_wrapper .portfolio_format_content:before,
	#portfolio_list.masonry_bg_img .portfolio_content_wrapper .portfolio_format_content:before,
	#portfolio_list.rounded .portfolio_format_content:after,
	#portfolio_list.masonry_top_img .portfolio_format_content:before,
	#portfolio_list.grid_top_img .portfolio_format_content:before,
	#portfolio_list.left_img .portfolio_format_content:before,
	#portfolio_list.masonry_card .portfolio_format_content > a:before,
	#portfolio_list.grid_card .portfolio_format_content > a:before,
	#portfolio_list.chess .portfolio_format_content a:before,
	#portfolio_list.carousel .portfolio_format_content a:before{
		background-color: $exito_portfolio_overlay ;
	}
	#portfolio_list.grid_bg_img .portfolio_content_wrapper:hover .portfolio_format_content:before,
	#portfolio_list.masonry_bg_img .portfolio_content_wrapper:hover .portfolio_format_content:before,
	#portfolio_list.rounded .portfolio_format_content:hover:after,
	#portfolio_list.masonry_top_img .portfolio_content_wrapper:hover .portfolio_format_content:before,
	#portfolio_list.grid_top_img .portfolio_content_wrapper:hover .portfolio_format_content:before,
	#portfolio_list.left_img .portfolio_format_content:hover:before,
	#portfolio_list.masonry_card .portfolio_content_wrapper:hover .portfolio_format_content a:before,
	#portfolio_list.grid_card .portfolio_content_wrapper:hover .portfolio_format_content a:before,
	#portfolio_list.chess .portfolio_format_content:hover a:before,
	#portfolio_list.carousel .portfolio_content_wrapper:hover .portfolio_format_content a:before{
		opacity: 0.$exito_portfolio_overlay_opacity ;
	}
	.vc_tta-style-classic.vc_tta.vc_general .vc_tta-tabs-list .vc_tta-tab.vc_active > a{ border-top: 2px solid $exito_theme_color !important; }
	.vc_tta-style-classic.vc_tta.vc_general.vc_tta-o-no-fill .vc_tta-tabs-list .vc_tta-tab.vc_active > a{ border-bottom: 3px solid $exito_theme_color !important; }
	.vc_tta-style-classic.vc_tta.vc_general .vc_tta-tabs-list .vc_tta-tab.vc_active > a, .vc_tta-style-classic.vc_tta.vc_general .vc_tta-tabs-list .vc_tta-tab > a:hover{ color: $exito_theme_color !important; }
	.vc_tta-style-classic.vc_tta.vc_general.vc_tta-o-no-fill.vc_tta-shape-round .vc_tta-tabs-list .vc_tta-tab > a:hover{ border-color: $exito_theme_color !important; }
	.vc_tta-style-classic.vc_tta.vc_general.vc_tta-tabs-position-left .vc_tta-tabs-list .vc_tta-tab.vc_active > a{ border-left: 2px solid $exito_theme_color !important; }
	.vc_tta-color-white.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover, .vc_tta-color-white.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a{ color: $exito_theme_color !important; }
	.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-heading{ border-left:2px solid $exito_theme_color !important; }
	.vc_tta.vc_tta-accordion .vc_active .vc_tta-controls-icon.vc_tta-controls-icon-plus{ background-color: $exito_theme_color !important; }
	.ult_design_5 .ult_pricing_table .ult_price_link .ult_price_action_button:hover{ background-color: $exito_theme_color !important; }
	.ult-team-member-wrap.ult-style-1 .ult-team-member-name-wrap .member-name-divider{ background-color: $exito_theme_color !important; }
	#blog_list.grid_card .post-descr-wrap .post-title:before, #blog_list.masonry_card .post-descr-wrap .post-title:before{ background-color: $exito_theme_color ; }
	#page-content .wpb_image_grid_uls.hover_style3 li a i{ background-color: $exito_theme_color ; }
	.ult-carousel-wrapper .slick-dots li.slick-active i{ color: $exito_theme_color !important; }
	#error404_container .btnback{ background-color: $exito_theme_color ; }
	.coming_soon_wrapper h6 a{ color: $exito_theme_color ; }
	.coming_soon_wrapper ul.countdown{ border-color: $exito_theme_color ; }
	.coming_soon_wrapper ul.countdown:before, .coming_soon_wrapper ul.countdown:after, .coming_soon_wrapper ul.countdown i:before, .coming_soon_wrapper ul.countdown i:after{ background-color: $exito_theme_color ; }
	#blog_list.frame_min .post-content-wrapper:hover{ box-shadow: 0 0 0 2px $exito_theme_color inset; }
	#blog_list.frame_min .post-content-wrapper:hover .post_bottom_inf .text-left, #blog_list.frame_min .post-content-wrapper:hover .post_bottom_inf .text-right, #blog_list.frame_min .post-content-wrapper:hover .cstheme_comment_count, #blog_list.frame_min .post-content-wrapper:hover .cstheme_comment_count i, #blog_list.frame_min .post-content-wrapper:hover .post_bottom_inf .text-left i{color: $exito_theme_color ;}
	#portfolio_single_wrap .sharebox .social_link:hover{ background-color: $exito_theme_color ; }
	.shop_wrap .sharebox .social_link:hover{ background-color: $exito_theme_color ; }
	.cstheme_contactform_type5 span.focus:before{ background-color: $exito_theme_color ; }
	.cstheme_contactform_type5 span input:focus, .cstheme_contactform_type5 textarea:focus{ color: $exito_theme_color ; }
	.cstheme_contactform_type6 span.focus:before{ background-color: $exito_theme_color ; opacity:0.1; }
	.cstheme_contactform_type6 span input:focus, .cstheme_contactform_type6 textarea:focus, .cstheme_contactform_type6 p.focus i.icon{ color: $exito_theme_color ; }
	.cstheme_contactform_type8 p.focus i.icon{ color: $exito_theme_color ; }
	.cstheme_contactform_type10 span.focus:before{ background-color: $exito_theme_color ; }
	.cstheme_contactform_type10 input:focus, .cstheme_contactform_type10 textarea:focus{border-color:#e4e4e4 !important; background-color:#f9f9f9 !important;}
	.cstheme_contactform_type4 span input:focus, .cstheme_contactform_type4 textarea:focus{ border-color:transparent !important; }
	.button_with_icon .play_btn i{ background-color: $exito_theme_color ; }
	.portfolio_single_nav a i.last{ color: $exito_theme_color ; }
	.portfolio_single_nav a.back-to-portfolio:hover{ color: $exito_theme_color ; }
	.filter_block li a{ color: $exito_portfolio_filter_color ; }
	.filter_block li a:after{ background-color: $exito_portfolio_filter_color ; }
	.filter_block li a:hover{ color: $exito_theme_color ; }
	#blog_list.frame_min .post-title:hover a{ color: $exito_theme_color !important; }
	#blog_list.bg_img_card .post-title:hover a, #blog_list.bg_img_card .format-quote h2.post-title:hover a{ color: $exito_theme_color ; }
	#blog_list.bg_img_card .post-content-quote-wrapper .overlay_border:before, #blog_list.bg_img_card .post-content-quote-wrapper .overlay_border:after{border-color: $exito_theme_color ;}
	#blog_list.bg_img_card .post-content-link-wrapper{background-color: $exito_theme_color ;}
	#blog_list.bg_img_card .post_meta_category{ background-color: $exito_theme_color ; }
	#blog_list.bg_img_card .read_more:before{ background-color: $exito_theme_color ; }
	#blog_list.bg_img_card .read_more:hover{ color: $exito_theme_color ; }
	.widget_categories .current-cat a,
	.widget_pages li a:hover,
	.widget_nav_menu li a:hover,
	.widget_pages li.current_page_item a,
	.widget_nav_menu li.current_page_item a,
	#pagetitle.pagetitle_fullscreen .single_post_header .post-meta a:hover,
	#pagetitle.pagetitle_fullscreen .cstheme_comment_count i,
	.recent_posts_list.carousel .recent_post_title a:hover{
		color: $exito_theme_color ;
	}
	#blog_list.default article.post.sticky:before,
	#blog_list.grid_bg_img .post_content_readmore,
	form.wpcf7-form input[type='submit']:hover{
		background-color: $exito_theme_color ;
	}
	.eva-pagination .page-numbers,
	.btn,
	.portfolio_single_det,
	.portfolio_single_nav div > div > a,
	.post_content_readmore,
	.button,
	input,
	textarea,
	.woocommerce .quantity input.qty,
	.woocommerce-page .quantity input.qty,
	.woocommerce button.button.alt.single_add_to_cart_button,
	.summary .product_meta b,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a,
	.woocommerce-page div.product .woocommerce-tabs ul.tabs li a,
	h1, h2, h3, h4, h5, h6{
		font-family: $exito_heading_font_family ;
	}
	
	.mobile_menu_btn span{
		background-color: $exito_headermenu_font_color ;
	}
	
	/* MailChimp Plugin */
	.mc4wp-form .mc4wp_email_wrap.focus i{ color: $exito_theme_color ; }
	
	/* WooCommerce */
	.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{ background-color: $exito_theme_color ; color:#222; }
	.woocommerce ul.products .product_wrap.products_list_type1 .shop_list_product_image:before, .woocommerce-page ul.products .product_wrap.products_list_type1 .shop_list_product_image:before{ background-color: $exito_theme_color ; }
	.woocommerce .star-rating span:before{ color: $exito_theme_color ; }
	.woocommerce div.product #product-thumbnails .slick-slide:after,
	.woocommerce-page div.product #product-thumbnails .slick-slide:after{
		background-color: $exito_theme_color;
	}
	.woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price{ color: $exito_theme_color ; }
	.summary .product_meta a:hover{ color: $exito_theme_color ; }
	.shop_wrap .cswoo_sharebox .cswoo_social_link:hover{ color: $exito_theme_color ; }
	.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce-page div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a{ color: $exito_theme_color ; }
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a{ border-top: 2px solid $exito_theme_color ; border-bottom-color: #fff; }
	#woo-nav-cart ul.cart_list li,
	#woo-nav-cart ul.cart_list li a,
	#woo-nav-cart ul.product_list_widget li a,
	#woo-nav-cart .widget_shopping_cart .cart_list li.mini_cart_item a.remove{
		color: $exito_headersubmenu_font_color !important;
	}
	#woo-nav-cart .cart_empty ul.product_list_widget li{
		color: $exito_headersubmenu_font_color ;
	}
	#woo-nav-cart ul.cart_list li a:hover, #woo-nav-cart ul.product_list_widget li a:hover{ color: $exito_theme_color !important; }
	#woo-nav-cart .nav-cart-content i,
	#woo-nav-cart .nav-cart-products.cart_empty p{
		color: $exito_headermenu_font_color ;
	}
	#woo-nav-cart .nav-cart-content i:hover{ color: $exito_headermenu_hover_color ; }
	#woo-nav-cart .woo-cart-count{ background-color: $exito_theme_color ; }
	.woocommerce #review_form #respond input#submit{ background-color: $exito_theme_color ; }
	.woocommerce table.cart input, .woocommerce-page table.cart input{ background-color: $exito_theme_color ; }
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range{ background-color: $exito_theme_color ; }
	#woo-nav-cart .widget_shopping_cart_content a.button,
	.woocommerce .widget_shopping_cart_content a.button:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover{
		background-color: $exito_theme_color !important;
	}
	.woocommerce .widget_shopping_cart .total:before, .woocommerce-page.widget_shopping_cart .total:before, .woocommerce-page .widget_shopping_cart .total:before{ background-color: $exito_theme_color ; }
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle{ background-color: $exito_theme_color ; }
	.woocommerce .widget .star-rating span:before, .woocommerce-page .widget .star-rating span:before{ color: $exito_theme_color ; }
	.woocommerce div.product .woocommerce-product-rating .woocommerce-review-link:hover{ color: $exito_theme_color ; }
	.woocommerce-message .button:hover{ background-color: $exito_theme_color !important; }
	#coupon_code:focus{ border-color: $exito_theme_color !important; }
	#customer_login .button{ background-color: $exito_theme_color !important; }
	.woocommerce ul.products li.product-category.product h3 .count, .woocommerce-page ul.products li.product-category.product h3 .count{ background-color: $exito_theme_color ; }
	.woocommerce ul.products li.product .product_wrap.products_list_type2 .shop_list_product_descr .add_to_cart_button:hover,
	.woocommerce-page ul.products li.product .product_wrap.products_list_type2 .shop_list_product_descr .add_to_cart_button:hover,
	.woocommerce ul.products li.product .product_wrap.products_list_type5 .add_to_cart_button:hover,
	.woocommerce-page ul.products li.product .product_wrap.products_list_type5 .add_to_cart_button:hover,
	.woocommerce button.button.alt.single_add_to_cart_button:hover,
	.woocommerce div.product ul > li:before{
		background-color: $exito_theme_color ;
	}
	body.archive.woocommerce.header-top.pagetitle_hide .header_bg,
	body.woocommerce-page.header-top.pagetitle_hide .header_bg{
		height:auto;
		background-color: $exito_header_bgcolor ;
	}
	
	#woo-nav-cart .nav-cart-products{background-color: $exito_headersubmenu_bgcolor ;}
	#woo-nav-cart ul.product_list_widget li:before{
		background-color: $exito_headersubmenu_hover_bgcolor ;
	}
	
	/* Custom CSS from Theme Options */
	$exito_options_custom_css
	
	";
	wp_add_inline_style( 'exito_inline_custom_style', $exito_inline_custom_css );
}
add_action( 'wp_enqueue_scripts', 'exito_custom_styles' );


/* Custom js */
function exito_custom_js() {
	
	global $exito_options;
	
	if( ( isset( $exito_options['custom-js'] ) ) && ( !empty( $exito_options['custom-js'] ) ) ) {
		echo $exito_options['custom-js'];
	}
}
add_action('wp_footer', 'exito_custom_js', 100);