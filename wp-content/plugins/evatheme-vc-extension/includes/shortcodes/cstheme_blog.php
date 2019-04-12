<?php
/**
 * Blog shortcode
 */

if ( ! function_exists( 'cstheme_vc_blog_shortcode' ) ) {
	function cstheme_vc_blog_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( 'cstheme_vc_blog', $atts );
		extract( $atts );
		
		$compile = '';

		
        list($query_args, $build_query) = vc_build_loop_query($build_query);

        global $post, $paged;
        
		if (empty($paged)) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        }

        $query_args['paged'] = $paged;
		
		$post_class = '';
		
		if( $style == 'masonry_top_img' || $style == 'grid_top_img' || $style == 'grid_bg_img' || $style == 'masonry_bg_img' || $style == 'bg_img_card' || $style == 'grid_card' || $style == 'masonry_card' || $style == 'grid_card_min' || $style == 'masonry_card_min' || $style == 'frame_min' || $style == 'metro' ) {
			if( $columns != '' ) {
				if( $columns == 'col2' ) {
					$post_class .= ' col-md-6';
				} elseif( $columns == 'col3' ) {
					$post_class .= ' col-md-4';
				} elseif( $columns == 'col4' ) {
					$post_class .= ' col-md-3';
				} elseif( $columns == 'col5' ) {
					$post_class .= ' col-md-25';
				} else {
					$post_class .= ' col-md-12';
				}
			}
		}
		if ( $no_padding == true ) {
			$post_class .= ' pl0 pr0 pb0 pt0';
		}
		
		if ( $border_radius == true ) {
			$post_class .= ' border_radius';
		}
		
		
        global $exito_wp_query_in_shortcodes;
        $exito_wp_query_in_shortcodes = new WP_Query($query_args);
			
			$compile .= '<div id="blog_list" class="' . $style . ' ' . $columns . ' ' . $classes . '">';
				
				if( ( $style == 'masonry_top_img' || $style == 'grid_top_img' || $style == 'grid_bg_img' || $style == 'masonry_bg_img' || $style == 'bg_img_card' || $style == 'grid_card' || $style == 'masonry_card' || $style == 'grid_card_min' || $style == 'masonry_card_min' || $style == 'frame_min' || $style == 'metro' ) && ( $columns != 'col1' ) ) {
					$compile .= '
						<div class="row">
							<div class="isotope_container_wrap">
								<div class="isotope-container">
						';
				}
				
						if ($exito_wp_query_in_shortcodes->have_posts()) {
							while ($exito_wp_query_in_shortcodes->have_posts()) {
								$exito_wp_query_in_shortcodes->the_post();
									
									$metro = get_post_meta( $post->ID, 'exito_metro', true );
									if( ( $style == 'metro' ) && ( isset( $metro ) && $metro != '' ) ) {
										$sizing_class = ' sizing_' . $metro;
									} else {
										$sizing_class = '';
									}
									
									$compile .= '<article id="post-' . get_the_ID() . '" ';
										ob_start();
										post_class($post_class . $sizing_class);
										$compile .= ob_get_clean() .'>';
										
										ob_start();
										if ( $style == 'grid_top_img' || $style == 'masonry_top_img' ) {
											include( locate_template( 'templates/blog/loop-top_img.php' ) );
										} elseif ( $style == 'text_min' ) {
											include( locate_template( 'templates/blog/loop-text_min.php' ) );
										} elseif ( $style == 'grid_bg_img' || $style == 'masonry_bg_img' ) {
											include( locate_template( 'templates/blog/loop-bg_img.php' ) );
										} elseif ( $style == 'bg_img_card' ) {
											include( locate_template( 'templates/blog/loop-bg_img_card.php' ) );
										} elseif ( $style == 'grid_card' || $style == 'masonry_card' ) {
											include( locate_template( 'templates/blog/loop-card.php' ) );
										} elseif ( $style == 'grid_card_min' || $style == 'masonry_card_min' ) {
											include( locate_template( 'templates/blog/loop-card_min.php' ) );
										} elseif ( $style == 'frame_min' ) {
											include( locate_template( 'templates/blog/loop-frame_min.php' ) );
										} elseif ( $style == 'metro' ) {
											include( locate_template( 'templates/blog/loop-metro.php' ) );
										} else {
											include( locate_template( 'templates/blog/loop.php' ) );
										}
										$compile .= ob_get_clean();
										
									
									$compile .= '</article>';
							}

						}
						
				if( ( $style == 'masonry_top_img' || $style == 'grid_top_img' || $style == 'grid_bg_img' || $style == 'masonry_bg_img' || $style == 'bg_img_card' || $style == 'grid_card' || $style == 'masonry_card' || $style == 'grid_card_min' || $style == 'masonry_card_min' || $style == 'frame_min' || $style == 'metro' ) && ( $columns != 'col1' ) ) {
					$compile .= '
								</div>
							</div>
						</div>
					';
				}
				
					if( $pagination != 'hide' && $style != 'text_min' && $columns != 'col1' ) {
						if( $pagination == 'infinite' ) {
							$compile .= exito_infinite_scroll( $exito_wp_query_in_shortcodes->max_num_pages );
						} else if( $pagination == 'pagination' ) {
							$compile .= exito_pagination( $exito_wp_query_in_shortcodes->max_num_pages );
						}
					}
					if ( $style == 'text_min' || $columns == 'col1' ) {
						$compile .= exito_pagination( $exito_wp_query_in_shortcodes->max_num_pages );
					}
				
			$compile .= '</div>';
			
			wp_reset_postdata();

        return $compile;
        ?>
    
<?php

	}
}
add_shortcode( 'cstheme_vc_blog', 'cstheme_vc_blog_shortcode' );

if ( ! function_exists( 'cstheme_vc_blog_shortcode_map' ) ) {
	function cstheme_vc_blog_shortcode_map() {
		
		vc_map(array(
			'base'			=> 'cstheme_vc_blog',
			'name'			=> esc_html__('Blog Posts', 'exito'),
			'description'	=> esc_html__('Display blog posts', 'exito'),
			'category'		=> esc_html__('Evatheme Modules', 'exito'),
			'icon'			=> 'cstheme-vc-icon',
			'params' 		=> array(
				array(
					'type'			=> 'loop',
					'heading'		=> esc_html__( 'Blog Items', 'exito' ),
					'param_name'	=> 'build_query',
					'settings' 		=> array(
						'size' 			=> array('hidden' => false, 'value' => 4 * 3),
						'order_by' 		=> array('value' => 'date'),
						'post_type' 	=> array('value' => 'post', 'hidden' => false),
						'categories' 	=> array('hidden' => false),
						'tags' 			=> array('hidden' => false)
					),
					'description' 	=> esc_html__( 'Create WordPress loop, to populate content from your site.', 'exito' )
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Blog Style', 'exito' ),
					'param_name'	=> 'style',
					'admin_label' 	=> true,
					'value'			=> array(
						esc_html__('Default', 'exito' ) 				=> 'default',
						esc_html__('Top Image Grid', 'exito') 			=> 'grid_top_img',
						esc_html__('Top Image Masonry', 'exito') 		=> 'masonry_top_img',
						esc_html__('Text Minimal', 'exito') 			=> 'text_min',
						esc_html__('Background Image Grid', 'exito') 	=> 'grid_bg_img',
						esc_html__('Background Image Masonry', 'exito') => 'masonry_bg_img',
						esc_html__('Background Image Card', 'exito') 	=> 'bg_img_card',
						esc_html__('Card Grid', 'exito') 				=> 'grid_card',
						esc_html__('Card Masonry', 'exito') 			=> 'masonry_card',
						esc_html__('Card Minimal Grid', 'exito') 		=> 'grid_card_min',
						esc_html__('Card Minimal Masonry', 'exito') 	=> 'masonry_card_min',
						esc_html__('Frame Minimal', 'exito') 			=> 'frame_min',
						esc_html__('Metro Style', 'exito') 				=> 'metro',
					)
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Blog Grid Columns', 'exito' ),
					'param_name'	=> 'columns',
					'admin_label' 	=> true,
					'value'			=> array(
						esc_html__( '1 Column', 'exito' )	=> 'col1',
						esc_html__( '2 Columns', 'exito' )	=> 'col2',
						esc_html__( '3 Columns', 'exito' )	=> 'col3',
						esc_html__( '4 Columns', 'exito' )	=> 'col4',
						esc_html__( '5 Columns', 'exito' )	=> 'col5'
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid_top_img', 'masonry_top_img', 'grid_bg_img', 'masonry_bg_img', 'bg_img_card', 'grid_card', 'masonry_card', 'grid_card_min', 'masonry_card_min', 'frame_min', 'metro' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'No padding', 'exito' ),
					'param_name' => 'no_padding',
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid_bg_img', 'masonry_bg_img', 'bg_img_card', 'metro' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Set rounded featured image corners?', 'exito' ),
					'param_name' => 'border_radius',
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid_bg_img', 'masonry_bg_img', 'grid_card', 'masonry_card', 'grid_card_min', 'masonry_card_min', 'frame_min' ),
					),
				),
				array(
					'type'			=> 'number',
					'heading'		=> esc_html__( 'Excerpt Count', 'exito' ),
					'description'	=> esc_html__( 'How much blog words displayed in blog Excerpt. Must insert Digits including 0.', 'exito' ),
					'param_name'	=> 'excerpt_count',
					'value' 		=> '200',
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'default', 'grid_top_img', 'masonry_top_img', 'text_min', 'grid_card', 'masonry_card', 'grid_card_min', 'masonry_card_min', 'bg_img_card' ),
					),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Pagination', 'exito' ),
					'param_name'	=> 'pagination',
					'value'			=> array(
						esc_html__( 'Hide', 'exito' )			=> 'hide',
						esc_html__( 'Pagination', 'exito' )		=> 'pagination',
						esc_html__( 'Infinite Scroll', 'exito' )	=> 'infinite'
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid_top_img', 'masonry_top_img', 'grid_bg_img', 'masonry_bg_img', 'grid_card', 'masonry_card', 'grid_card_min', 'masonry_card_min', 'frame_min', 'metro', 'bg_img_card' ),
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__( 'Extra Class', 'exito' ),
					'param_name'	=> 'classes',
					'value' 		=> '',
				),
			)
		));
	}
}
add_action( 'vc_before_init', 'cstheme_vc_blog_shortcode_map' );