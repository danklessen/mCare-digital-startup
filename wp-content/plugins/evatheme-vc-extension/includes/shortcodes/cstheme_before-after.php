<?php
/**
 * Before / After Shortcode
 */

if ( ! function_exists( 'cstheme_vc_before_after_shortcode' ) ) {
	function cstheme_vc_before_after_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( 'cstheme_vc_before_after', $atts );
		extract( $atts );
		
		wp_enqueue_script('exito_before_after', get_template_directory_uri() . '/assets/js/before-after.min.js', array('jquery'), false, true);
		wp_enqueue_style('exito_before_after', get_template_directory_uri() . '/assets/css/before_after.css');
		
		$compile = '';
		
		$image_1 = wp_get_attachment_image_src( $image_1, 'full' );
        $image_1Src = $image_1[0];
		$image_2 = wp_get_attachment_image_src( $image_2, 'full' );
        $image_2Src = $image_2[0];
		
        $compile = '<div class="evatheme-before-after-container">';
			$compile .= '<div class="evatheme-before-after">';
				$compile .= '<img src="' . esc_url( $image_1Src ) . '" title="' . esc_attr__( 'Before', 'exito' ) . '" />';
				$compile .= '<img src="' . esc_url( $image_2Src ) . '" title="' . esc_attr__( 'After', 'exito' ) . '" />';
			$compile .= '</div>';
		$compile .= '</div>';
        
		return $compile;

	}
}
add_shortcode( 'cstheme_vc_before_after', 'cstheme_vc_before_after_shortcode' );

if ( ! function_exists( 'cstheme_vc_before_after_shortcode_map' ) ) {
	function cstheme_vc_before_after_shortcode_map() {
		
		vc_map(array(
			'base'			=> 'cstheme_vc_before_after',
			'name'			=> esc_html__('Before / After', 'exito'),
			'description'	=> esc_html__('Display Before / After Images', 'exito'),
			'category'		=> esc_html__('Evatheme Modules', 'exito'),
			'icon'			=> 'cstheme-vc-icon',
			'params' 		=> array(
				array(
					'type' 			=> 'attach_image',
					'holder' 		=> 'img',
					'heading' 		=> esc_html__('Choose first image', 'exito'),
					'description' 	=> '',
					'param_name' 	=> 'image_1',
					'value' 		=> ''
				),
				array(
					'type' 			=> 'attach_image',
					'holder' 		=> 'img',
					'heading' 		=> esc_html__('Choose second image', 'exito'),
					'description' 	=> '',
					'param_name' 	=> 'image_2',
					'value' 		=> ''
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
add_action( 'vc_before_init', 'cstheme_vc_before_after_shortcode_map' );