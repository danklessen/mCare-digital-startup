<?php
/**
 * The template for displaying archive pages
 */

get_header();

global $exito_options;

$exito_sidebar_layout = isset( $exito_options['blog_layout'] ) ? $exito_options['blog_layout'] : 'right-sidebar';
if( $exito_sidebar_layout == 'left-sidebar' ) {
	$exito_sidebar_class = 'pull-left ';
	$exito_blog_list_wrap_class = 'left_sidebar ';
	$exito_blog_list_class = 'col-md-8 pull-right';
} elseif( $exito_sidebar_layout == 'right-sidebar' ) {
	$exito_sidebar_class = 'pull-right';
	$exito_blog_list_wrap_class = 'right_sidebar ';
	$exito_blog_list_class = 'col-md-8 pull-left ';
} else {
	$exito_sidebar_class = $exito_blog_list_class = '';
	$exito_blog_list_wrap_class = 'no_sidebar ';
}
?>
		
		<div id="blog_list" class="container default mt0 <?php echo esc_html( $exito_blog_list_wrap_class ); ?>">
			<div class="row">
			
			<?php
			if( $exito_sidebar_layout != 'no-sidebar' ) {
			echo '
				<div class="' . esc_html( $exito_blog_list_class ) . '">
					<div class="row">
				';
			}
			?>

						<?php
							while (have_posts()) {
								the_post();
						?>
								
								<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-12'); ?>>
									
									<?php get_template_part('templates/blog/loop'); ?>
									
								</article>
								
						<?php 
							}
						?>
					
			<?php
			if( $exito_sidebar_layout != 'no-sidebar' ) {
			echo '
					</div>';
					
					echo exito_pagination( $pages = '' );
					
				echo '
				</div>
				';
			}
			?>
				
				<?php if( $exito_sidebar_layout != 'no-sidebar' ) { ?>
					<div class="col-md-4 <?php echo esc_html( $exito_sidebar_class ); ?>">
						<?php get_sidebar(); ?>
					</div>
				<?php } ?>
				
				<?php if( $exito_sidebar_layout == 'no-sidebar' ) { ?>
					<?php echo exito_pagination( $pages = '' ); ?>
				<?php } ?>
				
			</div>
			
		</div>

<?php get_footer(); ?>