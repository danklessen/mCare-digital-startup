<?php
/**
 * The template for displaying all single posts and attachments
 */

get_header();

global $post, $exito_options;

$exito_pf = get_post_format();

$exito_custom_divider = $exito_options['custom_divider']['url'];
$exito_custom_divider_width = isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '0';

$exito_blogsingle_layout = isset( $exito_options['blogsingle_layout'] ) ? $exito_options['blogsingle_layout'] : 'right-sidebar';

if( $exito_blogsingle_layout == 'left-sidebar' ) {
	$exito_sidebar_class = 'pull-left ';
	$exito_blogsingle_wrap_class = 'left_sidebar ';
	$exito_blogsingle_class = 'col-md-8 pull-right';
} elseif( $exito_blogsingle_layout == 'right-sidebar' ) {
	$exito_sidebar_class = 'pull-right';
	$exito_blogsingle_wrap_class = 'right_sidebar ';
	$exito_blogsingle_class = 'col-md-8 pull-left ';
} else {
	$exito_sidebar_class = $exito_blogsingle_class = '';
	$exito_blogsingle_wrap_class = 'no_sidebar ';
}

$exito_post_single_style = get_post_meta( $post->ID, 'exito_post_single_style', true );

if( class_exists( 'ReduxFrameworkPlugin' ) && ( isset( $exito_options['single_post_sharebox'] ) && $exito_options['single_post_sharebox'] != 0 ) ) {
	$exito_single_post_sharebox = 'show';
} else if( ! class_exists( 'ReduxFrameworkPlugin' ) ){
	$exito_single_post_sharebox = 'show';
}

if( class_exists( 'ReduxFrameworkPlugin' ) && ( isset( $exito_options['single_post_author'] ) && $exito_options['single_post_author'] != 0 ) ) {
	$exito_single_post_author = 'show';
} else if( ! class_exists( 'ReduxFrameworkPlugin' ) ){
	$exito_single_post_author = 'show';
}

if( class_exists( 'ReduxFrameworkPlugin' ) && ( isset( $exito_options['single_post_navigation'] ) && $exito_options['single_post_navigation'] != 0 ) ) {
	$exito_single_post_navigation = 'show';
} else if( ! class_exists( 'ReduxFrameworkPlugin' ) ){
	$exito_single_post_navigation = 'show';
}

if( class_exists( 'ReduxFrameworkPlugin' ) && ( isset( $exito_options['single_post_related_posts'] ) && $exito_options['single_post_related_posts'] != 0 ) ) {
	$exito_single_post_related_posts = 'show';
} else if( ! class_exists( 'ReduxFrameworkPlugin' ) ){
	$exito_single_post_related_posts = 'show';
}
?>
		
	<div class="container">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="blog-single-wrap" class="<?php echo 'format-' . esc_html( $exito_pf ) . ' ' . esc_html( $exito_blogsingle_wrap_class ) . ' ' . esc_html( $exito_post_single_style ); ?> clearfix">
				
				<?php if( $exito_post_single_style == 'fullscreen' ) { ?>
					
					<?php if( $exito_blogsingle_layout != 'no-sidebar' ) { ?>
						<div class="row">
							<div class="<?php echo esc_html( $exito_blogsingle_class ); ?>">
						<?php } ?>
								
								<?php if( $exito_pf != 'image' && $exito_pf != 'standard' ) { ?>
									<div class="post_format_content text-center">
										<?php get_template_part( 'templates/blog/post-format/post', $exito_pf ); ?>
									</div>
								<?php } ?>

								<div class="single-post-content clearfix">
									
									<?php
										the_content(esc_html__('Read more!', 'exito'));
										wp_link_pages(array('before' => '<div class="page-link mb20">' . esc_html__('Pages', 'exito') . ': ', 'after' => '</div>'));
									?>
									
								</div>
								
								<div class="posts_nav_link"><?php posts_nav_link(); ?></div>
								
								<div class="single_post_meta_tags">
									<?php if( has_tag() ) {
										the_tags('','', '');
									} ?>
								</div>
							
						<?php if( $exito_blogsingle_layout != 'no-sidebar' ) { ?>
							</div>
							
							<div class="col-md-4 <?php echo esc_html( $exito_sidebar_class ); ?>">
								<?php get_sidebar(); ?>
							</div>
						</div>
					<?php } ?>
			
					<?php if( $exito_single_post_sharebox == 'show' ) {
						get_template_part( 'templates/blog/sharebox' );
					} ?>
					
					<?php if( $exito_single_post_author == 'show' ) {
						get_template_part( 'templates/blog/authorinfo' );
					} ?>
					
					<?php if( $exito_single_post_navigation == 'show' ) { ?>
						<div class="single_post_nav clearfix">
							<?php
								$exito_prev_post = get_adjacent_post(false, '', false);
								$exito_next_post = get_adjacent_post(false, '', true);

								if($exito_prev_post){
									$exito_post_url = get_permalink($exito_prev_post->ID);            
									echo '<div class="pull-left"><a href="' . esc_url( $exito_post_url ) . '" title="' . $exito_prev_post->post_title . '"><p class="heading_font"><i class="fa fa-chevron-left"></i>' . esc_html__('Previous','exito') . '</p><b>' . $exito_prev_post->post_title . '</b></a></div>';
								}

								if($exito_next_post) {
									$exito_post_url = get_permalink($exito_next_post->ID);            
									echo '<div class="pull-right text-right"><a href="' . esc_url( $exito_post_url ) . '" title="' . $exito_next_post->post_title . '"><p class="heading_font">' . esc_html__('Next','exito') . '<i class="fa fa-chevron-right"></i></p><b>' . $exito_next_post->post_title . '</b></a></div>';
								} 
							?>
						</div>
					<?php } ?>
				
					<?php if( $exito_single_post_related_posts == 'show' ) {
						get_template_part('templates/blog/related-posts');
					} ?>
					
					<?php 
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
					
				<?php } else { ?>
				
					<?php if( $exito_blogsingle_layout != 'no-sidebar' ) { ?>
						<div class="row">
							<div class="<?php echo esc_html( $exito_blogsingle_class ); ?>">
						<?php } ?>
							
								<div class="single_post_header">
									<h2 class="single-post-title"><?php the_title(); ?></h2>
									<div class="clearfix">
										<div class="post-meta pull-left">
											<?php if( $exito_custom_divider_width != '0' ){?>
												<div class="divider_active">
													<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
														<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
													<?php } else { ?>
														<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
													<?php } ?>
												</div>
											<?php } ?>
											<span class="post-meta-author"><?php echo esc_attr__('by','exito'); ?><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name'); ?></a></span>
											<span class="post_meta_category"><?php echo esc_attr__('in','exito'); ?><?php the_category(', '); ?></span>
											<span class="post-meta-date"><?php echo esc_attr__('posted','exito'); ?><i><?php the_time('j F, Y'); ?></i></span>
										</div>
										<div class="pull-right">
											<span class="post-meta-comments"><i class="icon Evatheme-Icon-Fonts-thin-0274_chat_message_comment_bubble"></i><?php echo get_comments_number('0', '1', '%'); ?></span>
											<div class="post_likes"><?php echo exito_likes(); ?></div>
										</div>
									</div>
								</div>
								
								<div class="post_format_content text-center">
									<?php get_template_part( 'templates/blog/post-format/post', get_post_format() ); ?>
								</div>

								<div class="single-post-content clearfix">
									
									<?php
										the_content(esc_html__('Read more!', 'exito'));
										wp_link_pages(array('before' => '<div class="page-link mb20">' . esc_html__('Pages', 'exito') . ': ', 'after' => '</div>'));
									?>
									
								</div>
								
								<div class="posts_nav_link"><?php posts_nav_link(); ?></div>
								
								<div class="single_post_meta_tags">
									<?php if( has_tag() ) {
										the_tags('','', '');
									} ?>
								</div>
									
								<?php if( $exito_single_post_sharebox == 'show' ) {
									get_template_part( 'templates/blog/sharebox' );
								} ?>
								
								<?php if( $exito_single_post_author == 'show' ) {
									get_template_part( 'templates/blog/authorinfo' );
								} ?>
								
								<?php if( $exito_single_post_navigation == 'show' ) { ?>
									<div class="single_post_nav clearfix">
										<?php
											$exito_prev_post = get_adjacent_post(false, '', true);
											$exito_next_post = get_adjacent_post(false, '', false);

											if($exito_prev_post){
												$exito_post_url = get_permalink($exito_prev_post->ID);            
												echo '<div class="pull-left"><a href="' . esc_url( $exito_post_url ) . '" title="' . $exito_prev_post->post_title . '"><p><i class="fa fa-chevron-left"></i>' . esc_html__('Previous','exito') . '</p><b>' . $exito_prev_post->post_title . '</b></a></div>';
											}

											if($exito_next_post) {
												$exito_post_url = get_permalink($exito_next_post->ID);            
												echo '<div class="pull-right text-right"><a href="' . esc_url( $exito_post_url ) . '" title="' . $exito_next_post->post_title . '"><p>' . esc_html__('Next','exito') . '<i class="fa fa-chevron-right"></i></p><b>' . $exito_next_post->post_title . '</b></a></div>';
											} 
										?>
									</div>
								<?php } ?>
							
								<?php if( $exito_single_post_related_posts == 'show' ) {
									get_template_part('templates/blog/related-posts');
								} ?>
								
								<?php 
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;
								?>
						
						<?php if( $exito_blogsingle_layout != 'no-sidebar' ) { ?>
							</div>
							
							<div class="col-md-4 <?php echo esc_html( $exito_sidebar_class ); ?>">
								<?php get_sidebar(); ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		<?php endwhile; endif; ?>
		
	</div>

<?php get_footer(); ?>
