<?php
/**
 * The blog post content
 */

global $post;

$exito_sidebar_layout = isset( $exito_options['blog_layout'] ) ? $exito_options['blog_layout'] : 'right-sidebar';

if( is_home() || is_category() || is_tag() || is_day() || is_month() || is_year() ) { 
	if( $exito_sidebar_layout == 'left-sidebar' || $exito_sidebar_layout == 'right-sidebar' ) {
		$excerpt_count = 300;
	} else {
		$excerpt_count = 550;
	}
}
$exito_pf = get_post_format();
if (empty( $exito_pf )) $exito_pf = 'image';
$exito_post_excerpt = (exito_smarty_modifier_truncate(get_the_excerpt(), $excerpt_count));
?>
		
		<div class="post-content-wrapper clearfix">
			<div class="post_format_content">
				<div class="post_likes"><?php echo exito_likes(); ?></div>
				<?php get_template_part( 'templates/blog/post-format/post', $exito_pf ); ?>
			</div>
			
			<?php if( $exito_pf != 'quote' && $exito_pf != 'link' ) { ?>
				<div class="post-descr-wrap clearfix">
					<div class="post-meta">
						<span class="post-meta-author"><?php echo esc_attr__('by','exito'); ?><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name'); ?></a></span>
						<span class="post_meta_category"><?php echo esc_attr__('in','exito'); ?><?php the_category(', '); ?></span>
						<span class="post-meta-date"><?php echo esc_attr__('posted','exito'); ?><i><?php the_time('j F, Y'); ?></i></span>
					</div>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<div class="post-content clearfix">
						<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
					</div>
					<div class="clearfix">
						<a class="post_content_readmore pull-left" href="<?php echo get_permalink(); ?>"><?php echo esc_html__('Read More','exito'); ?></a>
						<div class="pull-right"><?php echo exito_comment_count(); ?></div>
					</div>
				</div>
			<?php } ?>

		</div>