<?php
/**
 * The blog post content
 */

$exito_comment_count = get_comments_number('0', '1', '%');
$exito_post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
update_post_meta(get_the_ID(), "post_views", (int)$exito_post_views + 1);
?>
			
		<div class="post-content-wrapper clearfix">
			<div class="post-descr-wrap clearfix text-center">
				<span class="post-meta-date theme_color"><?php the_time('j F, Y'); ?></span>
				<div class="post_title_wrap">
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<span class="post_meta_category"><?php echo esc_attr__('in','exito'); ?> <?php the_category(', '); ?></span>
				</div>
				<div class="post_bottom_inf clearfix">
					<div class="post_views text-left">
						<i class="icon Evatheme-Icon-Fonts-thin-0043_eye_visibility_show_visible"></i><?php echo esc_html( $exito_post_views ); ?>
					</div>
					<div class="post-meta-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php echo get_avatar( get_the_author_meta('user_email'), '60', '' ) ?></a></div>
					<div class="post_comments text-right">
						<a class="cstheme_comment_count" href="<?php comments_link(); ?>"><i class="icon Evatheme-Icon-Fonts-thin-0274_chat_message_comment_bubble"></i><?php echo esc_html( $exito_comment_count ); ?></a>
					</div>
				</div>
			</div>
		</div>