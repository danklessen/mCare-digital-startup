<?php
/**
 * The blog post content
 */

global $post;

$exito_pf = get_post_format();
if (empty( $exito_pf )) $exito_pf = 'image';
if( is_author() ) {
	$excerpt_count = 210;
}
$exito_post_excerpt = (exito_smarty_modifier_truncate(get_the_excerpt(), $excerpt_count));
$exito_comment_count = get_comments_number('0', '1', '%');
?>
 
			<div class="post-content-wrapper clearfix">
				<div class="post_format_content">
					<div class="post_likes"><?php echo exito_likes(); ?></div>
					<?php get_template_part( 'templates/blog/post-format/post', $exito_pf ); ?>
				</div>
				<?php if( $exito_pf != 'quote' && $exito_pf != 'link' ) { ?>
					<div class="post-descr-wrap clearfix">
						<div class="post-meta">
							<span class="post-meta-date"><?php the_time('j F, Y'); ?></span>
						</div>
						<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="post-content clearfix">
							<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
						</div>
						<div class="clearfix">
							<a class="post_content_readmore pull-left" href="<?php echo get_permalink(); ?>"><?php echo esc_html__('Read More','exito'); ?></a>
							<a class="cstheme_comment_count pull-right" href="<?php comments_link(); ?>"><i class="icon Evatheme-Icon-Fonts-thin-0274_chat_message_comment_bubble"></i><?php echo esc_html( $exito_comment_count ); ?></a>
						</div>
					</div>
				<?php } ?>
			</div>