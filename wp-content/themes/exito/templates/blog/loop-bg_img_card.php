<?php
/**
 * The blog post content
 */

$exito_pf 					= get_post_format();
$exito_quote_text 			= get_post_meta($post->ID, 'format_quote_text', true);
$exito_quote_author 		= get_post_meta($post->ID, 'format_quote_author', true);
$exito_format_link_url 		= get_post_meta($post->ID, 'format_link_url', true);
$exito_featured_image_url 	= wp_get_attachment_url(get_post_thumbnail_id());
$exito_post_excerpt 		= (exito_smarty_modifier_truncate(get_the_excerpt(), $excerpt_count));
?>
 
	<div class="post-content-wrapper">
		<?php if($exito_pf == 'quote') { ?>
	
			<div class="post-content-quote-wrapper">
				<div class="featured_img_bg" 
					<?php if(has_post_thumbnail()) { ?>
						style="background-image:url(<?php echo esc_url( $exito_featured_image_url ); ?>);"
					<?php } ?>
				></div>
				<div class="quote-format-wrap text-center">
					<i class="icon Evatheme-Icon-Fonts-thin-0285_chat_message_quote_reply"></i>
					<span class="post-meta-date"><?php the_time('M j, Y') ?></span>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
						<?php if (!empty($exito_quote_text)) {
							echo esc_attr( $exito_quote_text );
						} else {
							the_title();
						} ?>
					</a></h2>
					<span class="quote-author"><?php echo esc_attr__( 'Say', 'exito' ); ?></span>
					<p class="quote-author-name">
						<?php
							if ( !empty( $exito_quote_author ) ) {
								echo esc_attr( $exito_quote_author );
							} else {
								echo get_the_author_meta('display_name');
							}
						?>
					</p>
				</div>
				<div class="overlay_border"></div>
			</div>
			
		<?php } elseif ($exito_pf == 'link') { ?>
			
			<div class="post-content-link-wrapper">
				<div class="featured_img_bg" 
					<?php if(has_post_thumbnail()) { ?>
						style="background-image:url(<?php echo esc_url( $exito_featured_image_url ); ?>);"
					<?php } ?>
				></div>
				<div class="link-format-wrap text-center">
					<i class="icon Evatheme-Icon-Fonts-thin-0031_pin_bookmark"></i>
					<span class="post-meta-date"><?php the_time('M j, Y') ?></span>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<a class="post-format-link-url" href="
						<?php
							if ( !empty( $exito_format_link_url ) ) {
								echo esc_url( $exito_format_link_url );
							} else {
								echo the_permalink();
							}
						?>
					"  target="_blank">
						<?php
							if ( !empty( $exito_format_link_url ) ) {
								echo esc_attr( $exito_format_link_url );
							} else {
								echo get_the_author_meta('display_name');
							}
						?>
					</a>
				</div>
				<div class="overlay_border"></div>
			</div>
			
		<?php } else { ?>
		
			<div class="featured_img_bg" 
				<?php if(has_post_thumbnail()) { ?>
					style="background-image:url(<?php echo esc_url( $exito_featured_image_url ); ?>);"
				<?php } ?>
			></div>
			<span class="post_meta_category"><?php the_category(', '); ?></span>
			<div class="post-descr-wrap">
				<span class="post-meta-date"><?php the_time('M j, Y') ?></span>
				<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="post-content">
					<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
				</div>
			</div>
			<a class="read_more" href="<?php the_permalink(); ?>"><?php echo esc_html__('Read More','exito') ?></a>
			<div class="post-meta">
				<span class="post-meta-likes"><?php echo exito_likes(); ?></span>
				<span class="post-meta-comments"><i class="fa fa-comments"></i><?php echo get_comments_number(get_the_ID()); ?></span>
			</div>
			
		<?php } ?>
	</div>