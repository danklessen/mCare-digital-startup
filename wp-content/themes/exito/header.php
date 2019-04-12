<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <?php exito_favicon(); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
	<?php global $post, $exito_options; ?>
	
	<?php exito_preloader(); ?>
	
	<?php if( isset( $exito_options['header_search'] ) && $exito_options['header_search'] != 0) {
		get_template_part( 'templates/header/search_block' );
	} ?>
	
	<?php
		$exito_header_style = 'header-top';
		$exito_header_type = 'type1';
		if ( $exito_header_type == 'type5' && $exito_header_style != 'header-left' ) {
			echo '<div class="menu_creative_block"><div class="menu_creative_btn"></div><div class="menu-primary-menu-container-wrap">';
				wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary' ) );
			echo '</div></div>';
		}
	?>
	
	<div id="page-wrap">
		
		<?php 
			
			if ( is_404() || is_search() ) {
				get_template_part( 'templates/header/header_layout' );
				get_template_part( 'templates/header/header-mobile' );
			}
			
			if( !is_object($post) ) 
				return;
			
			if ( get_post_meta( $post->ID, 'exito_disable_header', true ) !== 'disable' ) {
				get_template_part( 'templates/header/header_layout' );
				get_template_part( 'templates/header/header-mobile' );
			}
		?>
		
		<?php get_template_part( 'templates/page_title' ); ?>
		
		<div id="page-content">