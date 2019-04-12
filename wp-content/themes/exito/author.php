<?php
/**
 * The template for displaying Author Archive pages
 */
 
get_header();

$exito_user_post_count 			= count_user_posts( get_the_author_meta( 'ID' ), $post_type = 'post' );
$exito_author_google_profile 	= get_the_author_meta( 'exito_author_google_profile' );
$exito_author_twitter_profile 	= get_the_author_meta( 'exito_author_twitter_profile' );
$exito_author_facebook_profile 	= get_the_author_meta( 'exito_author_facebook_profile' );
$exito_author_linkedin_profile 	= get_the_author_meta( 'exito_author_linkedin_profile' );
$exito_author_instagram_profile = get_the_author_meta( 'exito_author_instagram_profile' );
$exito_author_tumblr_profile 	= get_the_author_meta( 'exito_author_tumblr_profile' );

$excerpt_count = 100;
?>

		<div id="author_posts_page" class="mt-80">
			
			<?php if ( have_posts() ) : the_post(); ?>
			
				<div id="author_posts_info" class="clearfix">
					<div class="container text-center">
						<div class="author_posts_avatar"><?php echo get_avatar( get_the_author_meta('user_email'), '120', '' ); ?></div>
						<div class="author_posts_descr">
							<div class="author_posts_count"><?php echo esc_html( $exito_user_post_count ) . esc_html__( ' articles', 'exito' ) ?></div>
							<h5 class="author_posts_name"><?php the_author(); ?></h5>
							<?php if ( $exito_author_google_profile != '' || $exito_author_twitter_profile != '' || $exito_author_facebook_profile != '' || $exito_author_linkedin_profile != '' || $exito_author_instagram_profile != '' || $exito_author_tumblr_profile != '' ) { ?>
								<div class="author_icons">
									<?php
										if ( $exito_author_google_profile && $exito_author_google_profile != '' ) {
												echo '<a class="social_link google-plus" href="' . esc_url($exito_author_google_profile) . '" target="_blank"><i class="fa fa-google-plus"></i><i class="fa fa-google-plus"></i></a>';
										}

										if ( $exito_author_twitter_profile && $exito_author_twitter_profile != '' ) {
												echo '<a class="social_link twitter" href="' . esc_url($exito_author_twitter_profile) . '" target="_blank"><i class="fa fa-twitter"></i><i class="fa fa-twitter"></i></a>';
										}

										if ( $exito_author_facebook_profile && $exito_author_facebook_profile != '' ) {
												echo '<a class="social_link facebook" href="' . esc_url($exito_author_facebook_profile) . '" target="_blank"><i class="fa fa-facebook"></i><i class="fa fa-facebook"></i></a>';
										}

										if ( $exito_author_linkedin_profile && $exito_author_linkedin_profile != '' ) {
											   echo '<a class="social_link linkedin" href="' . esc_url($exito_author_linkedin_profile) . '" target="_blank"><i class="fa fa-linkedin"></i><i class="fa fa-linkedin"></i></a>';
										}
										
										if ( $exito_author_instagram_profile && $exito_author_instagram_profile != '' ) {
											   echo '<a class="social_link instagram" href="' . esc_url($exito_author_instagram_profile) . '" target="_blank"><i class="fa fa-instagram"></i><i class="fa fa-instagram"></i></a>';
										}
										
										if ( $exito_author_tumblr_profile && $exito_author_tumblr_profile != '' ) {
											   echo '<a class="social_link tumblr" href="' . esc_url($exito_author_tumblr_profile) . '" target="_blank"><i class="fa fa-tumblr"></i><i class="fa fa-tumblr"></i></a>';
										}
									?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				
				<?php rewind_posts(); ?>
				
				<div id="blog_list" class="container grid_top_img col3">
					<div class="row">
						
						<?php while ( have_posts() ) : the_post(); ?>

							<article id="post-<?php the_ID() ?>" <?php post_class() ?>>
							
								<?php get_template_part('templates/blog/loop-top_img'); ?>
								
							</article>

						<?php endwhile; ?>
						
						<?php wp_reset_postdata(); ?>
						
					</div>
					<?php echo exito_pagination( $pages = '' ); ?>
				</div>
				
			<?php endif; ?>

		</div>

<?php get_footer(); ?>