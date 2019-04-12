<?php
/**
 * The template for displaying all single portfolio posts and attachments
 */

get_header();
the_post();

global $post, $exito_options;

$exito_pf = get_post_format();
if (empty($exito_pf)) $exito_pf = "standard";

$exito_portfolio_single_layout 				= get_post_meta( $post->ID, 'exito_portfolio_single_layout', true );
$exito_portfolio_single_client 				= get_post_meta( $post->ID, 'exito_portfolio_single_client', true );
$exito_portfolio_single_add_field_title 	= get_post_meta( $post->ID, 'exito_portfolio_single_add_field_title', true );
$exito_portfolio_single_add_field 			= get_post_meta( $post->ID, 'exito_portfolio_single_add_field', true );
$exito_portfolio_single_add_field_title2 	= get_post_meta( $post->ID, 'exito_portfolio_single_add_field_title2', true );
$exito_portfolio_single_add_field2 			= get_post_meta( $post->ID, 'exito_portfolio_single_add_field2', true );
$exito_portfolio_single_add_field_title3 	= get_post_meta( $post->ID, 'exito_portfolio_single_add_field_title3', true );
$exito_portfolio_single_add_field3 			= get_post_meta( $post->ID, 'exito_portfolio_single_add_field3', true );
$exito_portfolio_single_link 				= get_post_meta( $post->ID, 'exito_portfolio_single_link', true );
$exito_portfolio_single_link_name 			= get_post_meta( $post->ID, 'exito_portfolio_single_link_name', true );

// Categories
$exito_portfolio_category = get_the_term_list($post->ID, 'portfolio_category', '', ', ', '');

/* ADD 1 view for this post */
$exito_post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
update_post_meta(get_the_ID(), "post_views", (int)$exito_post_views + 1);

$exito_portfolio_single_sharebox = isset( $exito_options['portfolio_single_sharebox'] ) ? $exito_options['portfolio_single_sharebox'] : '1';
$exito_portfolio_single_navigation = isset( $exito_options['portfolio_single_navigation'] ) ? $exito_options['portfolio_single_navigation'] : '1';

$exito_custom_divider = $exito_options['custom_divider']['url'];
$exito_custom_divider_width = isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48';
?>
		
		<div class="container">
			<div id="portfolio_single_wrap" class="<?php echo 'format-' . esc_html( $exito_pf ) . ' ' . esc_html( $exito_portfolio_single_layout ); ?> clearfix mb50">
				<div class="row">
					
					<?php if( $exito_portfolio_single_layout == 'full_width' ) { ?>
						
						<div class="col-md-12">
							<div class="row">
								<div class="col-lg-8 col-md-7">
									<div class="portfolio_single_content clearfix">
										<div class="portfolio_single_title_wrap">
											<h3 class="portfolio_single_title"><?php the_title(); ?></h3>
											<div class="divider_active">
												<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
													<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
												<?php } else { ?>
													<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
												<?php } ?>
											</div>
											<div class="post_likes"><?php echo exito_likes(); ?></div>
										</div>
										<?php
											the_content(esc_html__('Read more!', 'exito'));
											wp_link_pages(array('before' => '<div class="page-link mb20">' . esc_html__('Pages', 'exito') . ': ', 'after' => '</div>'));
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-5">
									<div class="portfolio_single_details_wrap">
										<?php if( isset( $exito_portfolio_single_client ) && $exito_portfolio_single_client != '' ) { ?>
											<div class="portfolio_single_det">
												<p><i><strong><?php esc_html_e('Client', 'exito') ?></strong></i>
												<span class="portfolio-client">
													<?php echo esc_attr( $exito_portfolio_single_client ); ?>
												</span></p>
											</div>
										<?php } ?>
										<?php if( !empty( $exito_portfolio_category ) ) { ?>
											<div class="portfolio_single_det">
												<p><i><strong><?php esc_html_e('Category', 'exito') ?></strong></i>
												<span class="portfolio-category">
													<?php echo strip_tags($exito_portfolio_category) ?>
												</span></p>
											</div>
										<?php } ?>
										<?php if(get_the_term_list($post->ID, 'portfolio_tag', '', ',', '')) { ?>
											<div class="portfolio_single_det">
												<p><i><strong><?php esc_html_e('Tags', 'exito') ?></strong></i>
												<span class="portfolio-tag">
													<?php echo get_the_term_list($post->ID, 'portfolio_tag', '', ', ', ''); ?>
												</span></p>
											</div>
										<?php } ?>
										<div class="portfolio_single_det">
											<p><i><strong><?php esc_html_e('Date', 'exito') ?></strong></i>
											<span class="portfolio-date">
												<?php the_date('j F Y'); ?>
											</span></p>
										</div>
										<?php if( isset( $exito_portfolio_single_add_field_title ) && $exito_portfolio_single_add_field_title != '' ) { ?>
											<div class="portfolio_single_det">
												<p><i><strong><?php echo esc_attr( $exito_portfolio_single_add_field_title ); ?></strong></i>
												<span class="portfolio-add_field">
													<?php echo esc_attr( $exito_portfolio_single_add_field ); ?>
												</span></p>
											</div>
										<?php } ?>
										<?php if( isset( $exito_portfolio_single_add_field_title2 ) && $exito_portfolio_single_add_field_title2 != '' ) { ?>
											<div class="portfolio_single_det">
												<p><i><strong><?php echo esc_attr( $exito_portfolio_single_add_field_title2 ); ?></strong></i>
												<span class="portfolio-add_field">
													<?php echo esc_attr( $exito_portfolio_single_add_field2 ); ?>
												</span></p>
											</div>
										<?php } ?>
										<?php if( isset( $exito_portfolio_single_add_field_title3 ) && $exito_portfolio_single_add_field_title3 != '' ) { ?>
											<div class="portfolio_single_det">
												<p><i><strong><?php echo esc_attr( $exito_portfolio_single_add_field_title3 ); ?></strong></i>
												<span class="portfolio-add_field">
													<?php echo esc_attr( $exito_portfolio_single_add_field3 ); ?>
												</span></p>
											</div>
										<?php } ?>
										<?php if( isset( $exito_portfolio_single_link ) && $exito_portfolio_single_link != '' ) { ?>
											<div class="portfolio_single_det">
												<p><i><strong><?php esc_html_e('Link', 'exito') ?></strong></i>
												<span class="portfolio-custom-link">
													<a class="theme_color" href="<?php echo esc_url( $exito_portfolio_single_link ); ?>" target="_blank">
														<?php echo esc_attr( ( $exito_portfolio_single_link_name != '' ) ? $exito_portfolio_single_link_name : $exito_portfolio_single_link ); ?>
													</a>
												</span></p>
											</div>
										<?php } ?>
										<?php if( $exito_portfolio_single_sharebox != 0 ) { ?>
											<div class="portfolio_single_sharebox">
												<?php get_template_part( 'templates/portfolio/sharebox' ); ?>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="portfolio_format_content">
								<?php get_template_part( 'templates/portfolio/post-format/post', $exito_pf ); ?>
							</div>
						</div>
					
					<?php } elseif ( $exito_portfolio_single_layout == 'half_width' ) { ?>
						
						<div class="col-lg-8 col-md-7 mb50">
							<div class="portfolio_format_content">
								<?php get_template_part( 'templates/portfolio/post-format/post', $exito_pf ); ?>
							</div>
						</div>
						<div class="col-lg-4 col-md-5 mb50">
							<div class="portfolio_single_content clearfix">
								<div class="portfolio_single_title_wrap">
									<h3 class="portfolio_single_title"><?php the_title(); ?></h3>
									<div class="divider_active"><img width="<?php echo esc_attr( $exito_custom_divider_width ); ?>px" src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" /></div>
									<div class="post_likes"><?php echo exito_likes(); ?></div>
								</div>
								<?php
									the_content(esc_html__('Read more!', 'exito'));
									wp_link_pages(array('before' => '<div class="page-link mb20">' . esc_html__('Pages', 'exito') . ': ', 'after' => '</div>'));
								?>
							</div>
							<div class="portfolio_single_details_wrap">
								<?php if( isset( $exito_portfolio_single_client ) && $exito_portfolio_single_client != '' ) { ?>
									<div class="portfolio_single_det">
										<p><i><strong><?php esc_html_e('Client', 'exito') ?></strong></i>
										<span class="portfolio-client">
											<?php echo esc_attr( $exito_portfolio_single_client ); ?>
										</span></p>
									</div>
								<?php } ?>
								<?php if( !empty( $exito_portfolio_category ) ) { ?>
									<div class="portfolio_single_det">
										<p><i><strong><?php esc_html_e('Category', 'exito') ?></strong></i>
										<span class="portfolio-category">
											<?php echo strip_tags($exito_portfolio_category) ?>
										</span></p>
									</div>
								<?php } ?>
								<?php if(get_the_term_list($post->ID, 'portfolio_tag', '', ',', '')) { ?>
									<div class="portfolio_single_det">
										<p><i><strong><?php esc_html_e('Tags', 'exito') ?></strong></i>
										<span class="portfolio-tag">
											<?php echo get_the_term_list($post->ID, 'portfolio_tag', '', ', ', ''); ?>
										</span></p>
									</div>
								<?php } ?>
								<div class="portfolio_single_det">
									<p><i><strong><?php esc_html_e('Date', 'exito') ?></strong></i>
									<span class="portfolio-date">
										<?php the_date('j F Y'); ?>
									</span></p>
								</div>
								<?php if( isset( $exito_portfolio_single_add_field_title ) && $exito_portfolio_single_add_field_title != '' ) { ?>
									<div class="portfolio_single_det">
										<p><i><strong><?php echo esc_attr( $exito_portfolio_single_add_field_title ); ?></strong></i>
										<span class="portfolio-add_field">
											<?php echo esc_attr( $exito_portfolio_single_add_field ); ?>
										</span></p>
									</div>
								<?php } ?>
								<?php if( isset( $exito_portfolio_single_add_field_title2 ) && $exito_portfolio_single_add_field_title2 != '' ) { ?>
									<div class="portfolio_single_det">
										<p><i><strong><?php echo esc_attr( $exito_portfolio_single_add_field_title2 ); ?></strong></i>
										<span class="portfolio-add_field">
											<?php echo esc_attr( $exito_portfolio_single_add_field2 ); ?>
										</span></p>
									</div>
								<?php } ?>
								<?php if( isset( $exito_portfolio_single_add_field_title3 ) && $exito_portfolio_single_add_field_title3 != '' ) { ?>
									<div class="portfolio_single_det">
										<p><i><strong><?php echo esc_attr( $exito_portfolio_single_add_field_title3 ); ?></strong></i>
										<span class="portfolio-add_field">
											<?php echo esc_attr( $exito_portfolio_single_add_field3 ); ?>
										</span></p>
									</div>
								<?php } ?>
								<?php if( isset( $exito_portfolio_single_link ) && $exito_portfolio_single_link != '' ) { ?>
									<div class="portfolio_single_det">
										<p><i><strong><?php esc_html_e('Link', 'exito') ?></strong></i>
										<span class="portfolio-custom-link">
											<a class="theme_color" href="<?php echo esc_url( $exito_portfolio_single_link ); ?>" target="_blank">
												<?php echo esc_attr( ( $exito_portfolio_single_link_name != '' ) ? $exito_portfolio_single_link_name : $exito_portfolio_single_link ); ?>
											</a>
										</span></p>
									</div>
								<?php } ?>
								<?php if( $exito_portfolio_single_sharebox != 0 ) { ?>
									<div class="portfolio_single_sharebox">
										<?php get_template_part( 'templates/portfolio/sharebox' ); ?>
									</div>
								<?php } ?>
							</div>
						</div>
						
					<?php } ?>
					
				</div>
			</div>
		</div>
		
		<?php if( $exito_portfolio_single_navigation != 0) { ?>
			<div class="portfolio_single_nav">
					
				<?php $exito_options_header_layout = isset( $exito_options['header-layout'] ) ? $exito_options['header-layout'] : 'full_width'; ?>
				<?php $exito_header_layout = get_post_meta( $post->ID, 'exito_header_layout', true ) ? get_post_meta( $post->ID, 'exito_header_layout', true ) : $exito_options_header_layout; ?>
				<div class="<?php if( $exito_header_layout != 'full_width' ) { echo 'container'; } ?> clearfix">
					
					<?php
						
						$exito_prev_post = get_adjacent_post(false, '', false);
						$exito_next_post = get_adjacent_post(false, '', true);
						if( isset( $exito_options['portfolio_single_navigation_backbtn'] ) && $exito_options['portfolio_single_navigation_backbtn'] != '' ){
							$exito_portfolio_single_navigation_backbtn = $exito_options['portfolio_single_navigation_backbtn'];
						}
						
						if($exito_prev_post){
							$exito_post_url = get_permalink( $exito_prev_post->ID );            
							echo '<div class="pull-left"><a href="' . esc_url( $exito_post_url ) . '" title="' . $exito_prev_post->post_title . '"><i class="first fa fa-angle-left"></i><i class="last fa fa-angle-left"></i><span>' . $exito_prev_post->post_title . '</span></a></div>';
						}
						
						if( isset( $exito_options['portfolio_single_navigation_backbtn'] ) && $exito_options['portfolio_single_navigation_backbtn'] != '' ){
							echo '<a class="back-to-portfolio" href="' . esc_url( $exito_portfolio_single_navigation_backbtn ) . '"><i class="icon Evatheme-Icon-Fonts-thin-0208_grid_view"></i></a>';
						}
						
						if( $exito_next_post ) {
							$exito_post_url = get_permalink( $exito_next_post->ID );            
							echo '<div class="pull-right text-right"><a href="' . esc_url( $exito_post_url ) . '" title="' . $exito_next_post->post_title . '"><i class="first fa fa-angle-right"></i><i class="last fa fa-angle-right"></i><span>' . $exito_next_post->post_title . '</span></a></div>';
						} 
					?>
					
				</div>
			</div>
		<?php } ?>

<?php get_footer(); ?>
