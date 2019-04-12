<?php

global $post, $exito_options;

$exito_header_style = 'header-top';
$exito_header_layout = isset( $exito_options['header-layout'] ) ? $exito_options['header-layout'] : 'boxed';
if ( !is_404() && !is_search() ) {
	$exito_header_layout = (get_post_meta( $post->ID, 'exito_header_layout', true ) ? get_post_meta( $post->ID, 'exito_header_layout', true ) : $exito_header_layout);
}
$exito_header_type = 'type1';
$exito_header_left_align = isset( $exito_options['header_left_align'] ) ? $exito_options['header_left_align'] : 'left';
$exito_tagline_area = isset( $exito_options['tagline_area'] ) ? $exito_options['tagline_area'] : '0';

?>
		
		<header class="<?php echo esc_html( $exito_header_style ); ?> <?php if ( $exito_header_style != 'header-left' ) { echo esc_html( $exito_header_layout ) . ' ' . esc_html( $exito_header_type ); } ?> clearfix">
		
			<?php if ( $exito_header_style == 'header-left' ) { ?>
				
				<div class="scroll-wrap <?php echo 'text-' . esc_html( $exito_header_left_align ); ?>">
					<div class="header_left_top">
						<?php exito_logo(); ?>
						<div class="menu-primary-menu-container-wrap">
							<?php wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary' ) ); ?>
						</div>
					</div>
					<div class="header_left_bottom">
						<?php if ($exito_options['header_social_links'] == 1) { ?>
							<div class="social_links_wrap">
								<?php echo exito_social_links(); ?>
							</div>
						<?php } ?>
						
						<?php $exito_footer_copyright = $exito_options['footer_copyright']; ?>
						<?php if(!empty( $exito_footer_copyright ) ) { echo '<div class="copyright">' . esc_attr( $exito_footer_copyright ) . '</div>'; } ?>
					</div>

					<div class="header_bg"></div>
				</div>
			
			<?php } else { ?>
				
				<?php if ( $exito_header_type == 'type2' ) { ?>
					
					<?php if ($exito_tagline_area == 1) { ?>
						<div class="header_tagline">
							<div class="container">
								<div class="pull-left tagline_text_wrap">
									<?php if( !empty( $exito_options['tagline_area_phone'] ) ) { ?>
										<a href="tel:<?php echo esc_html( $exito_options['tagline_area_phone'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0294_phone_call_ringing"></i><?php echo esc_html( $exito_options['tagline_area_phone'] ) ?></a>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_phone'] ) && ( $exito_options['tagline_area_email'] ) ) { ?>
										<span class="theme_color">/</span>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_email'] ) ) { ?>
										<a href="mailto:<?php echo esc_html( $exito_options['tagline_area_email'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0319_email_mail_post_card"></i><?php echo esc_html( $exito_options['tagline_area_email'] ) ?></a>
									<?php } ?>
								</div>
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap text-right pull-right">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<div class="header_wrap">
						<div class="container">
							<div class="right_part_menu clearfix">
								<div class="menu-primary-menu-container-wrap pull-left">
									<?php wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary', 'fallback_cb' => false ) ); ?>
								</div>
								<?php if ( exito_woo_enabled() ) {
									exito_woo_nav_cart();
								} ?>
								<?php if ($exito_options['header_search'] == 1) { ?>
									<a class="header_search_icon pull-left" href="javascript:void(0)">
										<i class="icon Evatheme-Icon-Fonts-thin-0033_search_find_zoom"></i>
									</a>
								<?php } ?>
							</div>
							<?php exito_logo(); ?>
						</div>
					</div>
					<div class="header_bg"></div>
					
				<?php } else if ( $exito_header_type == 'type3' ) { ?>
					
					<?php if ($exito_tagline_area == 1) { ?>
						<div class="header_tagline">
							<div class="container">
								<div class="pull-left tagline_text_wrap">
									<?php if( !empty( $exito_options['tagline_area_phone'] ) ) { ?>
										<a href="tel:<?php echo esc_html( $exito_options['tagline_area_phone'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0294_phone_call_ringing"></i><?php echo esc_html( $exito_options['tagline_area_phone'] ) ?></a>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_phone'] ) && ( $exito_options['tagline_area_email'] ) ) { ?>
										<span class="theme_color">/</span>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_email'] ) ) { ?>
										<a href="mailto:<?php echo esc_html( $exito_options['tagline_area_email'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0319_email_mail_post_card"></i><?php echo esc_html( $exito_options['tagline_area_email'] ) ?></a>
									<?php } ?>
								</div>
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap text-right pull-right">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<div class="header_wrap">
						<div class="container text-center">
							<?php exito_logo(); ?>
							<div class="menu-primary-menu-container-wrap">
								<?php wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary', 'fallback_cb' => false ) ); ?>
							</div>
							<?php if ($exito_options['header_search'] == 1) { ?>
								<a class="header_search_icon" href="javascript:void(0)">
									<i class="icon Evatheme-Icon-Fonts-thin-0033_search_find_zoom"></i>
								</a>
							<?php } ?>
							<?php if ( exito_woo_enabled() ) {
								exito_woo_nav_cart();
							} ?>
						</div>
					</div>
					<div class="header_bg"></div>
					
				<?php } else if ( $exito_header_type == 'type4' ) { ?>
					
					<div class="header_wrap">
						<div class="container text-center">
							<div class="clearfix">
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
								<?php exito_logo(); ?>
								<?php if ($exito_options['header_search'] == 1) { ?>
									<a class="header_search_icon" href="javascript:void(0)">
										<i class="icon Evatheme-Icon-Fonts-thin-0033_search_find_zoom"></i>
									</a>
								<?php } ?>
								<?php if ( exito_woo_enabled() ) {
									exito_woo_nav_cart();
								} ?>
							</div>
							<div class="menu-primary-menu-container-wrap">
								<?php wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary', 'fallback_cb' => false ) ); ?>
							</div>
						</div>
					</div>
					<div class="header_bg"></div>
					
				<?php } else if ( $exito_header_type == 'type5' ) { ?>
					
					<?php if ($exito_tagline_area == 1) { ?>
						<div class="header_tagline">
							<div class="container">
								<div class="pull-left tagline_text_wrap">
									<?php if( !empty( $exito_options['tagline_area_phone'] ) ) { ?>
										<a href="tel:<?php echo esc_html( $exito_options['tagline_area_phone'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0294_phone_call_ringing"></i><?php echo esc_html( $exito_options['tagline_area_phone'] ) ?></a>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_phone'] ) && ( $exito_options['tagline_area_email'] ) ) { ?>
										<span class="theme_color">/</span>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_email'] ) ) { ?>
										<a href="mailto:<?php echo esc_html( $exito_options['tagline_area_email'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0319_email_mail_post_card"></i><?php echo esc_html( $exito_options['tagline_area_email'] ) ?></a>
									<?php } ?>
								</div>
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap text-right pull-right">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<div class="header_wrap">
						<div class="container">
							<?php exito_logo(); ?>
							<div class="right_part_menu clearfix">
								<div class="menu_creative_btn pull-right">
									<span></span><span></span><span></span>
								</div>
								<?php if ($exito_options['header_search'] == 1) { ?>
									<a class="header_search_icon pull-right" href="javascript:void(0)">
										<i class="icon Evatheme-Icon-Fonts-thin-0033_search_find_zoom"></i>
									</a>
								<?php } ?>
								<?php if ( exito_woo_enabled() ) {
									exito_woo_nav_cart();
								} ?>
							</div>
						</div>
					</div>
					<div class="header_bg"></div>
				
				<?php } else if ( $exito_header_type == 'type6' ) { ?>
					
					<?php if ($exito_tagline_area == 1) { ?>
						<div class="header_tagline">
							<div class="container">
								<div class="pull-left tagline_text_wrap">
									<?php if( !empty( $exito_options['tagline_area_phone'] ) ) { ?>
										<a href="tel:<?php echo esc_html( $exito_options['tagline_area_phone'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0294_phone_call_ringing"></i><?php echo esc_html( $exito_options['tagline_area_phone'] ) ?></a>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_phone'] ) && ( $exito_options['tagline_area_email'] ) ) { ?>
										<span class="theme_color">/</span>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_email'] ) ) { ?>
										<a href="mailto:<?php echo esc_html( $exito_options['tagline_area_email'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0319_email_mail_post_card"></i><?php echo esc_html( $exito_options['tagline_area_email'] ) ?></a>
									<?php } ?>
								</div>
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap text-right pull-right">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					
					<div class="header_wrap">
						<div class="container">
							<?php exito_logo(); ?>
							<div class="center_part_menu clearfix text-center">
								<div class="menu-primary-menu-container-wrap">
									<?php wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary', 'fallback_cb' => false ) ); ?>
								</div>
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
							<div class="right_part_menu text-right">
								<?php if ($exito_options['header_search'] == 1) { ?>
									<a class="header_search_icon pull-right" href="javascript:void(0)">
										<i class="icon Evatheme-Icon-Fonts-thin-0033_search_find_zoom"></i>
									</a>
								<?php } ?>
								<?php if ( exito_woo_enabled() ) {
									exito_woo_nav_cart();
								} ?>
							</div>
						</div>
					</div>
					<div class="header_bg"></div>
					
				<?php } else if ( $exito_header_type == 'type7' ) { ?>
					
					<?php if ($exito_tagline_area == 1) { ?>
						<div class="header_tagline">
							<div class="container">
								<div class="pull-left tagline_text_wrap">
									<?php if( !empty( $exito_options['tagline_area_phone'] ) ) { ?>
										<a href="tel:<?php echo esc_html( $exito_options['tagline_area_phone'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0294_phone_call_ringing"></i><?php echo esc_html( $exito_options['tagline_area_phone'] ) ?></a>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_phone'] ) && ( $exito_options['tagline_area_email'] ) ) { ?>
										<span class="theme_color">/</span>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_email'] ) ) { ?>
										<a href="mailto:<?php echo esc_html( $exito_options['tagline_area_email'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0319_email_mail_post_card"></i><?php echo esc_html( $exito_options['tagline_area_email'] ) ?></a>
									<?php } ?>
								</div>
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap text-right pull-right">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					
					<div class="header_wrap">
						<div class="container">
							<div class="clearfix pull-left">
								<div class="menu-primary-menu-container-wrap">
									<?php wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary', 'fallback_cb' => false ) ); ?>
								</div>
								<?php if ($exito_options['header_social_links'] == 1) { ?>
									<div class="social_links_wrap">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
							<div class="pull-right text-right">
								<?php if ($exito_options['header_search'] == 1) { ?>
									<a class="header_search_icon pull-right" href="javascript:void(0)">
										<i class="icon Evatheme-Icon-Fonts-thin-0033_search_find_zoom"></i>
									</a>
								<?php } ?>
								<?php if ( exito_woo_enabled() ) {
									exito_woo_nav_cart();
								} ?>
							</div>
						</div>
						<div class="text-center"><?php exito_logo(); ?></div>
					</div>
					<div class="header_bg"></div>
				
				<?php } else { ?>

					<?php if ($exito_tagline_area == 1) { ?>
						<div class="header_tagline">
							<div class="container">
								<div class="pull-left tagline_text_wrap">
									<?php if( !empty( $exito_options['tagline_area_phone'] ) ) { ?>
										<a href="tel:<?php echo esc_html( $exito_options['tagline_area_phone'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0294_phone_call_ringing"></i><?php echo esc_html( $exito_options['tagline_area_phone'] ) ?></a>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_phone'] ) && ( $exito_options['tagline_area_email'] ) ) { ?>
										<span class="theme_color">/</span>
									<?php } ?>
									<?php if( !empty( $exito_options['tagline_area_email'] ) ) { ?>
										<a href="mailto:<?php echo esc_html( $exito_options['tagline_area_email'] ) ?>"><i class="icon Evatheme-Icon-Fonts-thin-0319_email_mail_post_card"></i><?php echo esc_html( $exito_options['tagline_area_email'] ) ?></a>
									<?php } ?>
								</div>
								<?php if ( isset( $exito_options['header_social_links'] ) && $exito_options['header_social_links'] == 1 ) { ?>
									<div class="social_links_wrap text-right pull-right">
										<?php echo exito_social_links(); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<div class="header_wrap">
						<div class="container">
							<?php exito_logo(); ?>
							<div class="right_part_menu clearfix">
								<?php if ( isset( $exito_options['header_search'] ) && $exito_options['header_search'] == 1 ) { ?>
									<a class="header_search_icon pull-right" href="javascript:void(0)">
										<i class="icon Evatheme-Icon-Fonts-thin-0033_search_find_zoom"></i>
									</a>
								<?php } ?>
								<?php if ( exito_woo_enabled() ) {
									exito_woo_nav_cart();
								} ?>
								<div class="menu-primary-menu-container-wrap pull-right">
									<?php wp_nav_menu( array( 'menu_class' => 'nav-menu', 'theme_location' => 'primary', 'fallback_cb' => false ) ); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="header_bg"></div>
				
				<?php } ?>
				
			<?php } ?>
			
		</header>