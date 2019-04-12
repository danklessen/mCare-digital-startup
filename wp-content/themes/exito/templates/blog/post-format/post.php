<?php 

global $post;

$width = 1170;
$height = 650;
if( isset($style) && ( $style == 'grid_top_img' || $style == 'masonry_top_img' ) ) {
	if( $columns != 'col1' ) {
		$width = 550;
		$height = 400;
	} else {
		$width = 1170;
		$height = 700;
	}
}
if( isset($style) && ( $style == 'grid_card' || $style == 'masonry_card' ) ) {
	if( $columns != 'col1' ) {
		$width = 670;
		$height = 450;
	} else {
		$width = 1170;
		$height = 610;
	}
}
if( isset($style) && ( $style == 'masonry_top_img' || $style == 'masonry_card' ) ) {
	$height = '';
}

$featured_image_url = wp_get_attachment_url(get_post_thumbnail_id());
if( !is_single() ){
	$featured_image = '<img src="' . exito_aq_resize( $featured_image_url, $width, $height, true, true, true ) . '" alt="' . get_the_title() . '" />';
} else {
	$featured_image = '<img src="' . esc_url( $featured_image_url ) . '" alt="' . get_the_title() . '" />';
}
?>
	
	<?php if (!empty( $featured_image_url )) { ?>
		<div class="post-image">
			<?php if ( !is_single() ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
			<?php } ?>
				<?php echo $featured_image; ?>
			<?php if ( !is_single() ) { ?>
				</a>
			<?php } ?>
		</div>
	<?php }?>