<?php
/**
 * The blog post content
 */

global $post;

$exito_pf = get_post_format();
if (empty( $exito_pf )) $exito_pf = 'image';
$exito_post_excerpt = (exito_smarty_modifier_truncate(get_the_excerpt(), $excerpt_count));
$exito_comment_count = get_comments_number('0', '1', '%');
?>
			
		<?php if ( $columns != 'col1' ) { ?>
			<div class="post-content-wrapper clearfix">
				<div class="post_format_content">
					<div class="post_likes"><?php echo exito_likes(); ?></div>
					<?php get_template_part( 'templates/blog/post-format/post', $exito_pf ); ?>
				</div>
				<?php if( $exito_pf != 'quote' && $exito_pf != 'link' ) { ?>
					<div class="post-descr-wrap clearfix">
						<div class="post-meta">
							<span class="post-meta-date"><i><?php the_time('j F, Y'); ?></i></span>
						</div>
						<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="post-content clearfix">
							<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
						</div>
					</div>
				<?php } ?>
			</div>
		
		<?php } else { ?>
			
			<div class="post-content-wrapper clearfix">
				<div class="post_format_content">
					<div class="post_likes"><?php echo exito_likes(); ?></div>
					<?php get_template_part( 'templates/blog/post-format/post', $exito_pf ); ?>
				</div>
				<?php if( $exito_pf != 'quote' && $exito_pf != 'link' ) { ?>
					<div class="post-descr-wrap clearfix">
						<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="post-meta">
							<span class="post-meta-author"><?php echo esc_attr__('by','exito'); ?><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name'); ?></a></span>
							<span class="post_meta_category"><?php echo esc_attr__('in','exito'); ?><?php the_category(', '); ?></span>
							<span class="post-meta-date"><?php echo esc_attr__('posted','exito'); ?><i><?php the_time('j F, Y'); ?></i></span>
						</div>
						<div class="post-content clearfix">
							<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
						</div>
						<div class="post_bottom_inf clearfix">
							<div class="pull-left">
								<a class="post_content_readmore btn btn-default" href="<?php echo get_permalink(); ?>"><?php echo esc_html__( 'Read More', 'exito' ); ?></a>
								<?php echo exito_comment_count(); ?>
							</div>
							<div class="pull-right">
								<div class="post-meta-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php echo get_avatar( get_the_author_meta('user_email'), '30', '' ) ?><span><i><?php echo esc_attr__('by', 'exito') ?></i> <?php echo get_the_author_meta('display_name') ?></span></a></div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			
		<?php } ?>