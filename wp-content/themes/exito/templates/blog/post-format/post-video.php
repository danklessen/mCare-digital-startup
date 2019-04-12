<?php

global $post;

$exito_width = 1170;
$exito_height = 650;
if( isset($style) && ( $style == 'grid_top_img' || $style == 'masonry_top_img' ) ) {
	if( $columns != 'col1' ) {
		$exito_width = 550;
		$exito_height = 400;
	} else {
		$exito_width = 1170;
		$exito_height = 700;
	}
}
if( isset($style) && ( $style == 'grid_card' || $style == 'masonry_card' ) ) {
	if( $columns != 'col1' ) {
		$exito_width = 670;
		$exito_height = 450;
	} else {
		$exito_width = 1170;
		$exito_height = 610;
	}
}
if( isset($style) && ( $style == 'masonry_top_img' || $style == 'masonry_card' ) ) {
	$exito_height = '';
}

$exito_featured_image_url = wp_get_attachment_url(get_post_thumbnail_id());
$exito_featured_image = '<img src="' . exito_aq_resize( $exito_featured_image_url, $exito_width, $exito_height, true, true, true ) . '" alt="' . get_the_title() . '" />';
?>
	
	<?php if (!empty( $exito_featured_image_url )) { ?>
		<?php if ( !is_single() ) { ?>
			<div class="post-image">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
					<?php echo $exito_featured_image; ?>
					<div class="play_btn"><span></span><i class="fa fa-play"></i></div>
				</a>
			</div>
		<?php } else { ?>
			<div class="post-video">
				<?php echo do_shortcode( get_post_meta( $post->ID, 'exito_post_video_embed', true ) ); ?>
			</div>
		<?php } ?>
	<?php } ?>