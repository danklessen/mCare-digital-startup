<?php
/**
 * The template for displaying the footer
 */

global $post, $exito_options;

$exito_postId = ( isset( $post->ID ) ? get_the_ID() : NULL );

$exito_options_enable_prefooter = isset( $exito_options['enable_prefooter'] ) ? $exito_options['enable_prefooter'] : 'hide';
$exito_enable_prefooter = ( get_post_meta( $exito_postId, 'exito_enable_prefooter', true ) ? get_post_meta( $exito_postId, 'exito_enable_prefooter', true ) : $exito_options_enable_prefooter );
$exito_options_footer = isset( $exito_options['footer'] ) ? $exito_options['footer'] : 'show';
$exito_enable_footer = ( get_post_meta( $exito_postId, 'exito_footer', true ) ? get_post_meta( $exito_postId, 'exito_footer', true ) : $exito_options_footer );

if ( !is_404() && !is_search() ) {
	$exito_options_footer_layout = isset( $exito_options['footer_layout'] ) ? $exito_options['footer_layout'] : 'boxed';
	$exito_footer_layout = ( get_post_meta( $post->ID, 'exito_footer_layout', true ) ? get_post_meta( $post->ID, 'exito_footer_layout', true ) : $exito_options_footer_layout );
} else {
	$exito_footer_layout = isset( $exito_options['footer_layout'] ) ? $exito_options['footer_layout'] : 'boxed';
}

$exito_footer_class = $exito_footer_layout;
?>
		
		</div><!-- //page-content -->
		
		<footer class="<?php echo esc_html( $exito_footer_class ); ?>">
		
			<!-- Prefooter Area -->
			<?php if( $exito_enable_prefooter == 'show' ) { ?>
				<div id="prefooter_area">
					<div class="container">
						<div class="row">
							<?php
								$exito_widgets_grid = isset( $exito_options['prefooter_col'] ) ? $exito_options['prefooter_col'] : '4-4-4';
								$i = 1;
								foreach (explode('-', $exito_widgets_grid) as $exito_widgets_g) {
									echo '<div class="col-md-' . esc_html( $exito_widgets_g ) . ' col-' . esc_html( $i ) . '">';
										dynamic_sidebar("footer-area-$i");
									echo '</div>';
									$i++;
								}
							?>
						</div>
					</div>
				</div>
			<?php } ?>
			
			<!-- Footer Area -->
			<?php if( $exito_enable_footer == 'show' ) { ?>
				<div id="footer_bottom">
					<div class="container">
						<div class="row">
							<div class="col-sm-6 copyright_wrap">
								<?php $exito_footer_copyright = isset( $exito_options['footer_copyright'] ) ? $exito_options['footer_copyright'] : 'Copyright © 2017 Exito. All Rights Reserved.'; ?>
								<?php if(!empty( $exito_footer_copyright ) ) { echo '<div class="copyright">' . esc_attr( $exito_footer_copyright ) . '</div>'; } ?>
							</div>
							<div class="col-sm-6 social_links_wrap text-right">
								<?php echo exito_social_links(); ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
		</footer>
		
	</div><!-- //Page Wrap -->
	
<?php wp_footer(); ?>

</body>
</html>