<?php
/**
 * Partners Shortcode
 */

if ( ! function_exists( 'cstheme_vc_partners_shortcode' ) ) {
	function cstheme_vc_partners_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( 'cstheme_vc_partners', $atts );
		extract( $atts );
		
		if( $style == 'carousel' ){
			wp_enqueue_script('exito_owlcarousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), false, true);
			wp_enqueue_style('exito_owl_carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css');
		}
		
		if ( isset( $border_color ) && ( '' !== $border_color ) ) {
			$border_color = ' style="border-color: ' . esc_attr( $border_color ) . ';"';
		}
		
		$carousel_class = '';
		if( $style == 'carousel' ) {
			$carousel_class = 'owl-carousel';
			if( isset( $columns ) && ( '' !== $columns ) ) {
				if( $columns == '3' ) {
					$carousel_columns = '4';
				} elseif( $columns == '2' ) {
					$carousel_columns = '6';
				} elseif( $columns == '1-5' ) {
					$carousel_columns = '8';
				} else {
					$carousel_columns = '3';
				}
			}
		}
		
		$compile = '<div id="partners_list" class="row ' . $carousel_class . ' ' . $classes . '">';
		
			$values = (array) vc_param_group_parse_atts( $values );
			$partners_data = array();
			foreach ( $values as $data ) {
				$new_partner = $data;
				$new_partner['partner_img'] = wp_get_attachment_image_src( $data['partner_img'], 'full' );
				$new_partner['partner_img_src'] = $new_partner['partner_img'][0];
				$new_partner['url'] = isset( $data['url'] ) ? $data['url'] : '';
				$new_partner['name_color'] = isset( $data['name_color'] ) ? 'style="color:' . $data['name_color'] . '"' : '';
				$new_partner['name'] = isset( $data['name'] ) ? '<h6 ' . $new_partner['name_color'] . '><b>' . $data['name'] . '</b></h6>' : '';
				$new_partner['img_title'] = isset( $data['name'] ) ? $data['name'] : '';
				$new_partner['description'] = isset( $data['description'] ) ? '<p>' . $data['description'] . '</p>' : '';
				if ( isset( $data['description'] ) && ( '' !== $data['description'] ) ) {
					$new_partner['with_descr'] = 'with_descr';
				} else {
					$new_partner['with_descr'] = 'no_descr';
				}
				$partners_data[] = $new_partner;
			}
			foreach ( $partners_data as $partner ) {
				$compile .= '<div class="col-sm-' . $columns . '">';
					$compile .= '<div class="partner_wrap text-center border_' . $border . ' hover_' . $hover . ' ' . $partner['with_descr'] . '" ' . $border_color . '>';
						if ( '' !== $partner['url'] ) {
							$compile .= '<a href="' . $partner['url'] . '" target="_blank">';
						}
							$compile .= '<img src="' . esc_url( $partner['partner_img_src'] ) . '" title="' . $new_partner['img_title'] . '" />';
							if ( '' !== $partner['name'] || '' !== $partner['description'] ) {
								$compile .= '<div class="partner_descr">';
									$compile .= $partner['name'];
									$compile .= $partner['description'];
								$compile .= '</div>';
							}
						if ( '' !== $partner['url'] ) {
							$compile .= '</a>';
						}
					$compile .= '</div>';
				$compile .= '</div>';
			}
		
		$compile .= '</div>';
		
		if( $style == 'carousel' ) {
			$compile .= '
				<script type="text/javascript">
					jQuery(window).load(function() {
						jQuery("#partners_list.owl-carousel").owlCarousel({
							items: ' . $carousel_columns . ',
							margin: 10,
							dots: false,
							nav: true,
							navText: [],
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
									items: 4,
								},
								1280:{
									items: ' . $carousel_columns . ',
								}
							}
						});
					});
				</script>
			';
		}
        
		return $compile;

	}
}
add_shortcode( 'cstheme_vc_partners', 'cstheme_vc_partners_shortcode' );

if ( ! function_exists( 'cstheme_vc_partners_shortcode_map' ) ) {
	function cstheme_vc_partners_shortcode_map() {
		
		vc_map(array(
			'base'			=> 'cstheme_vc_partners',
			'name'			=> esc_html__('Partners', 'exito'),
			'description'	=> esc_html__('Display Partners', 'exito'),
			'category'		=> esc_html__('Evatheme Modules', 'exito'),
			'icon'			=> 'cstheme-vc-icon',
			'params' 		=> array(
				array(
					'type'	=> 'dropdown',
					'heading'	=> esc_html__( 'Partners Style', 'exito' ),
					'param_name' => 'style',
					'admin_label' => true,
					'value'	=> array(
						esc_html__( 'Grid', 'exito' )	=> 'grid',
						esc_html__( 'Carousel', 'exito' )	=> 'carousel' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Columns', 'exito' ),
					'param_name'	=> 'columns',
					'admin_label' 	=> true,
					'value'			=> array(
						esc_html__( '3 Columns', 'exito' )	=> '4',
						esc_html__( '4 Columns', 'exito' )	=> '3',
						esc_html__( '6 Columns', 'exito' )	=> '2',
						esc_html__( '8 Columns', 'exito' )	=> '1_5',
					),
				),
				array(
					'type' => 'param_group',
					'heading' => esc_html__( 'Partners Logo', 'exito' ),
					'param_name' => 'values',
					'description' => '',
					'params' => array(
						array(
							'type' => 'attach_image',
							'holder' => 'img',
							'heading' => esc_html__('Choose partner logo', 'exito'),
							'description' => '',
							'param_name' => 'partner_img',
							'value' => ''
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Url', 'exito' ),
							'param_name' => 'url',
							'description' => esc_html__( 'Enter url of partner logo.', 'exito' ),
							'admin_label' => true,
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Name', 'exito' ),
							'param_name' => 'name',
							'description' => esc_html__( 'Enter text used as title of partner logo.', 'exito' ),
							'admin_label' => true,
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Name Color', 'exito' ),
							'param_name' => 'name_color',
							'description' => esc_html__( 'Select custom text color for name.', 'exito' ),
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Description', 'exito' ),
							'param_name' => 'description',
							'description' => esc_html__( 'Enter text used as description of partner logo.', 'exito' ),
							'admin_label' => true,
						),
					),
				),
				array(
					'type'	=> 'dropdown',
					'heading'	=> esc_html__( 'Border Style', 'exito' ),
					'param_name' => 'border',
					'admin_label' => true,
					'value'	=> array(
						esc_html__( 'without border', 'exito' )	=> 'none',
						esc_html__( 'border for each logos of partner', 'exito' )	=> 'solid',
						esc_html__( 'line between the logos of partners', 'exito' )	=> 'line',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Border or Line Color', 'exito' ),
					'param_name' => 'border_color',
					'description' => esc_html__( 'Select custom border or line color.', 'exito' ),
					'dependency' => array(
						'element' => 'border',
						'value' => array( 'solid', 'line' ),
					),
				),
				array(
					'type'	=> 'dropdown',
					'heading'	=> esc_html__( 'Hover Effect', 'exito' ),
					'param_name' => 'hover',
					'admin_label' => true,
					'value'	=> array(
						esc_html__( 'logo transparent on hover', 'exito' ) => 'opacity',
						esc_html__( 'logo not transparent on hover', 'exito' ) => 'transparent',
						esc_html__( 'show description on hover', 'exito' ) => 'descr',
						esc_html__( 'show colored border on hover', 'exito' ) => 'border',
						esc_html__( 'show name in popup on hover', 'exito' ) => 'popup',
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__( 'Extra Class', 'exito' ),
					'param_name'	=> 'classes',
					'value' 		=> ''
				),
			)
		));
	}
}
add_action( 'vc_before_init', 'cstheme_vc_partners_shortcode_map' );