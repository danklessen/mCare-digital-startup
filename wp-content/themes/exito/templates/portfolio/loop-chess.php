<?php
/**
 * The portfolio post content
 */

global $post;

$exito_height = 520;
if( !empty( $chess_img_height ) ) {
	$exito_height = $chess_img_height;
}

$exito_featured_image_url = wp_get_attachment_url(get_post_thumbnail_id());
$exito_featured_image = '<img src="' . exito_aq_resize( $exito_featured_image_url, 1000, $exito_height, true, true, true ) . '" alt="' . get_the_title() . '" />';
$exito_portfolio_category = get_the_term_list($post->ID, 'portfolio_category', '', ', ', '');
$exito_post_excerpt = (exito_smarty_modifier_truncate(get_the_excerpt(), 150));
?>
 
		<div class="portfolio_content_wrapper clearfix">
			<div class="col-md-6 portfolio_format_content">
				<div class="post_likes"><?php echo exito_likes(); ?></div>
				<?php if( !empty( $exito_featured_image_url ) ) { ?>
					<?php echo '<a href="' . get_permalink() . '">' . $exito_featured_image . '<i class="icon Evatheme-Icon-Fonts-thin-0043_eye_visibility_show_visible"></i></a>'; ?>
				<?php } ?>
			</div>
			<div class="col-md-6 portfolio_descr_wrap text-center">
				<span class="portfolio_meta_category"><?php echo strip_tags( $exito_portfolio_category ); ?></span>
				<h2 class="portfolio_title"><a href="<?php the_permalink( $post->ID ); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="portfolio_content clearfix">
					<p><?php echo esc_html( $exito_post_excerpt ); ?></p>
				</div>
				<?php if (!empty ( $read_more_btn )) { ?>
					<a class="btn btn-primary" href="<?php the_permalink( $post->ID ); ?>"><?php echo esc_attr( $read_more_btn ); ?></a>
				<?php } ?>
			</div>
		</div>