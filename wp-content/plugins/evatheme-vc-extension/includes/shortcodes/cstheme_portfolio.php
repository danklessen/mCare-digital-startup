<?php
/**
 * Portfolio shortcode
 */

if ( ! function_exists( 'cstheme_vc_portfolio_shortcode' ) ) {
	function cstheme_vc_portfolio_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( 'cstheme_vc_portfolio', $atts );
		extract( $atts );
		
		$compile = '';

?>

        <?php
        list($query_args, $build_query) = vc_build_loop_query($build_query);

        global $paged, $portfolio_class;
        
		if (empty($paged)) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        }

        $query_args['paged'] = $paged;
		
		$portfolio_class = '';
		
		if( $style == 'masonry_top_img' || $style == 'grid_top_img' || $style == 'masonry_card' || $style == 'grid_card' || $style == 'grid_bg_img' || $style == 'masonry_bg_img' || $style == 'rounded' ) {
			if( $columns != '' ) {
				if( $columns == 'col2' ) {
					$portfolio_class = 'col-sm-6';
				} elseif( $columns == 'col3' ) {
					$portfolio_class = 'col-sm-4';
				} elseif( $columns == 'col4' ) {
					$portfolio_class = 'col-sm-3';
				} elseif( $columns == 'col5' ) {
					$portfolio_class = 'col-sm-25';
				} else {
					$portfolio_class = 'col-sm-12';
				}
			}
		}
		
		if( $style == 'carousel' ) {
			$columns = 'owl-carousel';
		} 
		
        global $exito_wp_query_in_shortcodes;
        $exito_wp_query_in_shortcodes = new WP_Query($query_args);
			
			$compile .= '<div id="portfolio_list" class="' . $style . ' ' . $columns . ' ' . $classes . '">';
				
				if( $style == 'masonry_top_img' || $style == 'grid_top_img' || $style == 'masonry_card' || $style == 'grid_card' || $style == 'grid_bg_img' || $style == 'masonry_bg_img' || $style == 'chess' || $style == 'rounded' ) {
					
					$post_type_terms = array();
					if ( $filter == 'show' && $style != 'chess' ) {
						$compile .= exito_portfolio_filter( $post_type_terms );
					}
					
					$compile .= '
						<div class="row">
							<div class="isotope_container_wrap">
								<div class="isotope-container">
						';
				}
						
						if ($exito_wp_query_in_shortcodes->have_posts()) {
							while ($exito_wp_query_in_shortcodes->have_posts()) {
								$exito_wp_query_in_shortcodes->the_post();
									
									// Categories
									$portfolio_category = '';
									$terms = get_the_terms( get_the_ID(), 'portfolio_category' );
									if ( $terms && ! is_wp_error( $terms ) ) {
										foreach ( $terms as $term ) {
											$tempname = strtr($term->name, array(
												" " => "-",
												"'" => "-",
											));
											$portfolio_category .= ' ' . strtolower($tempname) . ' ';
										}
									} else {
										$categories_list = 'Uncategorized';
									}
									
									if ( $border_radius == true ) {
										$border_radius = 'border_radius';
									}
									if ( $no_padding == true ) {
										$no_padding = 'no_padding';
									}
		
									
									$compile .= '<article id="portfolio-' . get_the_ID() . '" ';
										ob_start();
										post_class( $portfolio_class . ' ' . $portfolio_category . ' ' . $border_radius . ' ' . $no_padding );
										$compile .= ob_get_clean() .'>';
										
										ob_start();
										
											if ( $style == 'grid_top_img' || $style == 'masonry_top_img' ) {
												include( locate_template( 'templates/portfolio/loop-top_img.php' ) );
											} elseif ( $style == 'grid_bg_img' || $style == 'masonry_bg_img' ) {
												include( locate_template( 'templates/portfolio/loop-bg_img.php' ) );
											} elseif ( $style == 'grid_card' || $style == 'masonry_card' ) {
												include( locate_template( 'templates/portfolio/loop-card.php' ) );
											} elseif ( $style == 'left_img' ) {
												include( locate_template( 'templates/portfolio/loop-left_img.php' ) );
											} elseif ( $style == 'chess' ) {
												include( locate_template( 'templates/portfolio/loop-chess.php' ) );
											} elseif ( $style == 'carousel' ) {
												include( locate_template( 'templates/portfolio/loop-carousel.php' ) );
											} elseif ( $style == 'rounded' ) {
												include( locate_template( 'templates/portfolio/loop-rounded.php' ) );
											}
										
										$compile .= ob_get_clean();
										
									
									$compile .= '</article>';
									
							}

						}
						
				if( $style == 'masonry_top_img' || $style == 'grid_top_img' || $style == 'masonry_card' || $style == 'grid_card' || $style == 'grid_bg_img' || $style == 'masonry_bg_img' || $style == 'chess' || $style == 'rounded' ) {
					$compile .= '
								</div>
							</div>
						</div>
					';
				}
				
					if( $pagination != 'hide' ) {
						if( $pagination == 'infinite' ) {
							$compile .= exito_infinite_scroll( $exito_wp_query_in_shortcodes->max_num_pages );
						} else if( $pagination == 'pagination' ) {
							$compile .= exito_pagination( $exito_wp_query_in_shortcodes->max_num_pages );
						}
					} elseif( $style == 'left_img' ) {
						$compile .= exito_pagination( $exito_wp_query_in_shortcodes->max_num_pages );
					}
				
			$compile .= '</div>';
			
			wp_reset_postdata();
			
			if( $style == 'carousel' ) {
				$compile .= '
					<script type="text/javascript">
						jQuery(window).load(function() {
							jQuery("#portfolio_list.carousel.owl-carousel").owlCarousel({
								items: ' . $carousel_columns . ',
								margin: 0,
								dots: false,
								nav: true,
								loop: true,
								autoplay: true,
								autoplaySpeed: 1000,
								autoplayTimeout: 5000,
								navSpeed: 1000,
								autoplayHoverPause: true,
								thumbs: false,
								responsive:{
									0:{
										items:1,
									},
									480:{
										items:2,
									},
									768:{
										items:3,
									},
									1280:{
										items:' . $carousel_columns . ',
									}
								}
							});
						});
					</script>
				';
			}

        return $compile;
        ?>
    
<?php

	}
}
add_shortcode( 'cstheme_vc_portfolio', 'cstheme_vc_portfolio_shortcode' );

if ( ! function_exists( 'cstheme_vc_portfolio_shortcode_map' ) ) {
	function cstheme_vc_portfolio_shortcode_map() {
		
		vc_map(array(
			'base' 			=> 'cstheme_vc_portfolio',
			'name' 			=> esc_html__('Portfolio Posts', 'exito'),
			'description' 	=> esc_html__('Display portfolio posts', 'exito'),
			'category' 		=> esc_html__('Evatheme Modules', 'exito'),
			'icon' 			=> 'cstheme-vc-icon',
			'params' 		=> array(
				array(
					'type' 			=> 'loop',
					'heading' 		=> esc_html__( 'Portfolio Items', 'exito' ),
					'param_name' 	=> 'build_query',
					'settings' 		=> array(
						'size' 			=> array('hidden' => false, 'value' => 4 * 3),
						'order_by' 		=> array('value' => 'date'),
						'post_type' 	=> array('value' => 'portfolio', 'hidden' => false),
						'categories' 	=> array('hidden' => true),
						'tags' 			=> array('hidden' => true)
					),
					'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'exito' )
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__('Portfolio Style', 'exito'),
					'param_name' 	=> 'style',
					'admin_label' 	=> true,
					'value' 		=> array(
						esc_html__('Background Image Grid', 'exito') 		=> 'grid_bg_img',
						esc_html__('Background Image Masonry', 'exito') 	=> 'masonry_bg_img',
						esc_html__('Top Image Grid', 'exito') 				=> 'grid_top_img',
						esc_html__('Top Image Masonry', 'exito') 			=> 'masonry_top_img',
						esc_html__('Card Grid', 'exito') 					=> 'grid_card',
						esc_html__('Card Masonry', 'exito') 				=> 'masonry_card',
						esc_html__('Left Image', 'exito') 					=> 'left_img',
						esc_html__('Chess Style', 'exito') 				=> 'chess',
						esc_html__('Carousel', 'exito') 					=> 'carousel',
						esc_html__('Rounded', 'exito') 					=> 'rounded',
					),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__('Filter', 'exito'),
					'param_name' 	=> 'filter',
					'admin_label' 	=> true,
					'value' 		=> array(
						esc_html__('Show', 'exito') 			=> 'show',
						esc_html__('Hide', 'exito') 			=> 'hide',
					),
					'dependency'	=> array(
						'element'		=> 'style',
						'value'			=> array( 'grid_bg_img', 'masonry_bg_img', 'grid_top_img', 'masonry_top_img', 'grid_card', 'masonry_card', 'rounded' ),
					),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Columns', 'exito' ),
					'param_name'	=> 'columns',
					'admin_label' 	=> true,
					'value'			=> array(
						esc_html__( '2 Columns', 'exito' )	=> 'col2',
						esc_html__( '3 Columns', 'exito' )	=> 'col3',
						esc_html__( '4 Columns', 'exito' )	=> 'col4',
						esc_html__( '5 Columns', 'exito' )	=> 'col5'
					),
					'dependency'	=> array(
						'element'		=> 'style',
						'value'			=> array( 'grid_bg_img', 'masonry_bg_img', 'grid_top_img', 'masonry_top_img', 'grid_card', 'masonry_card', 'rounded' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'No padding', 'exito' ),
					'param_name' => 'no_padding',
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid_bg_img', 'masonry_bg_img' ),
					),
				),
				// if Carousel
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Columns', 'exito' ),
					'param_name'	=> 'carousel_columns',
					'admin_label' 	=> true,
					'value'			=> array(
						esc_html__( '2 Columns', 'exito' )	=> '2',
						esc_html__( '3 Columns', 'exito' )	=> '3',
						esc_html__( '4 Columns', 'exito' )	=> '4',
						esc_html__( '5 Columns', 'exito' )	=> '5'
					),
					'dependency'	=> array(
						'element'		=> 'style',
						'value'			=> array( 'carousel' ),
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__( 'Image Height', 'exito' ),
					'param_name'	=> 'carousel_img_height',
					'value' 		=> '795',
					'dependency'	=> array(
						'element'		=> 'style',
						'value'			=> array( 'carousel' ),
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__( 'Image Height', 'exito' ),
					'param_name'	=> 'chess_img_height',
					'value' 		=> '520',
					'dependency'	=> array(
						'element'		=> 'style',
						'value'			=> array( 'chess' ),
					),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Pagination', 'exito' ),
					'param_name'	=> 'pagination',
					'value'			=> array(
						esc_html__( 'Hide', 'exito' )				=> 'hide',
						esc_html__( 'Pagination', 'exito' )		=> 'pagination',
						esc_html__( 'Infinite Scroll', 'exito' )	=> 'infinite'
					),
					'dependency'	=> array(
						'element'		=> 'style',
						'value'			=> array( 'grid_bg_img', 'masonry_bg_img', 'grid_top_img', 'masonry_top_img', 'grid_card', 'masonry_card', 'chess', 'rounded' ),
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__( 'Button Text (Show Case)', 'exito' ),
					'param_name'	=> 'read_more_btn',
					'value' 		=> 'Show Case',
					'dependency'	=> array(
						'element'		=> 'style',
						'value'			=> array( 'left_img', 'chess', 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Set rounded featured image corners?', 'exito' ),
					'param_name' => 'border_radius',
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid_bg_img', 'masonry_bg_img', 'grid_top_img', 'masonry_top_img', 'left_img' ),
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__( 'Extra Class', 'exito' ),
					'param_name'	=> 'classes',
					'value' 		=> '',
				)
			)
		));
		
	}
}
add_action( 'vc_before_init', 'cstheme_vc_portfolio_shortcode_map' );