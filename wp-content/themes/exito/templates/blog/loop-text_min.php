<?php
/**
 * The blog post content
 */

global $post;

$exito_post_excerpt = (exito_smarty_modifier_truncate(get_the_excerpt(), $excerpt_count));
$exito_comment_count = get_comments_number('0', '1', '%');
?>
 
			<div class="post-content-wrapper">
				<div class="post-descr-wrap clearfix text-center">
					<div class="post-meta">
						<span class="post_meta_category"><?php the_category(', '); ?></span>
						<span class="post-meta-date"><?php echo esc_attr__('posted','exito'); ?><i><?php the_time('j F, Y'); ?></i></span>
					</div>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<div class="post-content clearfix">
						<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
					</div>
					<div class="clearfix">
						<a class="post_content_readmore" href="<?php echo get_permalink(); ?>"><?php echo esc_html__('Read More','exito'); ?></a>
						<a class="cstheme_comment_count" href="<?php comments_link(); ?>"><i class="icon Evatheme-Icon-Fonts-thin-0274_chat_message_comment_bubble"></i><?php echo esc_html( $exito_comment_count ); ?></a>
					</div>
				</div>
			</div>