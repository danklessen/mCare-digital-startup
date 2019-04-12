<?php

global $post, $exito_options;

$exito_custom_divider 					= $exito_options['custom_divider']['url'];
$exito_custom_divider_width 			= isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48';
$exito_single_post_related_posts_title 	= isset( $exito_options['single_post_related_posts_title'] ) ? $exito_options['single_post_related_posts_title'] : esc_html__('Related Posts', 'exito');
$exito_blogsingle_layout 				= isset( $exito_options['blogsingle_layout'] ) ? $exito_options['blogsingle_layout'] : 'left-sidebar';
$exito_post_excerpt_count 				= 155;
if ( $exito_blogsingle_layout != 'no-sidebar') {
	$exito_post_excerpt_count = 100;
}
$exito_post_excerpt = (exito_smarty_modifier_truncate(get_the_excerpt(), $exito_post_excerpt_count));
?>
	
	<?php
		
		$categories = get_the_category($post->ID);

		if ($categories) {

			$category_ids = array();

			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
			
			$args = array(
				'category__in'     => $category_ids,
				'post__not_in'     => array($post->ID),
				'ignore_sticky_posts' => 1,
				'orderby' => 'rand'
			);
		
	?>
	
				<div id="related_posts_list">
					
					<?php if ( !empty( $exito_single_post_related_posts_title ) ) { ?>
						<h4><?php echo esc_attr( $exito_single_post_related_posts_title ); ?></h4>
						<?php if( $exito_custom_divider_width != '0' ){ ?>
							<div class="divider_active">
								<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
									<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
								<?php } else { ?>
									<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
								<?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
					
					<div class="owl-carousel">

						<?php

							$my_query = new WP_Query($args);
							
							if( $my_query->have_posts() ) {
								while ($my_query->have_posts()) : $my_query->the_post();
									
									$exito_featured_image_url = wp_get_attachment_url(get_post_thumbnail_id());
									$exito_featured_image = '<img src="' . exito_aq_resize($exito_featured_image_url, 370, 250, true, true, true) . '" alt="' . get_the_title() . '" />';
									
									echo '
										<div class="item">
											<div class="posts_carousel_wrap clearfix">
												<div class="post_format_content">
													<div class="post_likes">';
														exito_likes();
													echo '</div>
										';
													if( !empty( $exito_featured_image_url ) ) {
														echo '<a href="' . get_permalink() . '">' . $exito_featured_image . '</a>';
													}
											echo '
												</div>
												<div class="posts_carousel_content">
													<span class="post-meta-date">' . get_the_time('j F, Y') . '</span>
													<h5 class="post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h5>
													<p>' . esc_html( $exito_post_excerpt ) . '</p>
													' . exito_comment_count() . '
												</div>
											</div>
										</div>
									';
									
								endwhile;
								
								wp_reset_postdata();
							}
				
						?>

					</div>
				</div>
				
		<?php } ?>