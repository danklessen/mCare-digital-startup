<?php
/**
 * The portfolio post content
 */

global $post;

$exito_featured_image_url = wp_get_attachment_url(get_post_thumbnail_id());
$exito_featured_image = '<img src="' . exito_aq_resize( $exito_featured_image_url, 370, 220, true, true, true ) . '" alt="' . get_the_title() . '" />';
$exito_portfolio_category = get_the_term_list($post->ID, 'portfolio_category', '', ', ', '');
$exito_post_excerpt = (exito_smarty_modifier_truncate(get_the_excerpt(), 150));
?>
 
		<div class="row portfolio_content_wrapper">
			<div class="col-md-4 portfolio_format_content">
				<div class="post_likes"><?php echo exito_likes(); ?></div>
				<?php if( !empty( $exito_featured_image_url ) ) { ?>
					<?php echo '<a href="' . get_permalink() . '">' . $exito_featured_image . '<i class="plus"></i></a>'; ?>
				<?php } ?>
			</div>
			<div class="col-md-7 portfolio_descr_wrap">
				<span class="portfolio_meta_category"><?php echo strip_tags( $exito_portfolio_category ); ?></span>
				<h2 class="portfolio_title"><a href="<?php the_permalink( $post->ID ); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="portfolio_content clearfix">
					<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
				</div>
				<a class="btn btn-primary" href="<?php the_permalink( $post->ID ); ?>"><?php echo esc_attr( $read_more_btn ); ?></a>
			</div>
		</div>