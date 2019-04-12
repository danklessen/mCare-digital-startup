<?php
/**
 * The template for displaying search results pages.
 */

get_header();

global $post;
?>

		<div id="search_result_list">
			<div class="container">
				<div class="row">

					<?php if (have_posts ()) { while (have_posts ()) : the_post(); ?>
						
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="post-content-wrapper clearfix">
								<div class="post-descr-wrap clearfix">
									<span class="post_type"><?php echo ucfirst( get_post_type( $post->ID ) ); ?></span>
									<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									<div class="post-meta">
										<span class="post-meta-date theme_color"><?php the_time('j F, Y'); ?></span>
									</div>
								</div>
							</div>
						</article>

					<?php endwhile; ?>
						
					<?php wp_reset_postdata(); ?>
						
					<?php } else { ?>
						
						<div id="error404-container" class="container">
							<h4 class="error404"><?php esc_html_e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'exito');?></h4>
						</div>
						
					<?php } ?>

				</div>
			</div>
			
			<?php exito_pagination(); ?>
			
		</div>

<?php get_footer(); ?>