<?php
/**
 * The blog post content
 */

global $post;

$exito_featured_image_url 	= wp_get_attachment_url(get_post_thumbnail_id());
$exito_featured_image 		= '<img src="' . esc_url( $exito_featured_image_url ) . '" alt="' . get_the_title() . '" />';
?>
 
			<div class="post-content-wrapper">
				<div class="post_format_content">
					<?php if ( $style == 'masonry_bg_img' ) { ?>
						<div class="featured_image_img"><?php echo $exito_featured_image; ?></div>
					<?php } else { ?>
						<div class="featured_image_bg" style="background-image:url(<?php echo esc_url( $exito_featured_image_url ); ?>);"></div>
					<?php } ?>
				</div>
				<div class="post-descr-wrap text-center">
					<div class="post-meta">
						<span class="post-meta-date"><i><?php the_time('j F, Y'); ?></i></span>
					</div>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<div class="post_likes"><?php echo exito_likes(); ?></div>
					<a class="post_content_readmore" href="<?php echo get_permalink(); ?>"><?php echo esc_html__('Read More','exito'); ?></a>
				</div>
			</div>