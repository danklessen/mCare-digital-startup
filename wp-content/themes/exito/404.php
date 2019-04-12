<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();

	global $exito_options;
	
	$exito_custom_divider = $exito_options['custom_divider']['url'];
	$exito_custom_divider_width = isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48';
?>
	
	<div id="error404_container">
		<div class="container text-center">
			<h1><?php echo esc_html__('404', 'exito'); ?></h1>
			<div class="text-center">
				<div class="divider_active">
					<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
						<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
					<?php } else { ?>
						<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
					<?php } ?>
				</div>
				<h2><?php echo esc_html__('Page not found', 'exito'); ?></h2>
				<div class="divider_active">
					<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
						<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
					<?php } else { ?>
						<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
					<?php } ?>
				</div>
			</div>
			<?php if( isset( $exito_options['page404_descr'] ) && $exito_options['page404_descr'] != '' ) { ?>
				<p><?php echo esc_html( $exito_options['page404_descr'] ); ?></p>
			<?php } ?>
			<div class="clearfix"></div>
			<a class="btnback" href="<?php echo esc_url( home_url( '/' ) ); ?>/"><i class="fa fa-chevron-left"></i><?php echo esc_html__('Back Homepage', 'exito'); ?></a>
		</div>
	</div>

<?php get_footer(); ?>
