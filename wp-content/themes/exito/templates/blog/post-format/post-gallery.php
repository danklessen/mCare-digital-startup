<?php

global $post;

$exito_postid = get_the_ID();

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

$gallery_image_ids = get_post_meta($post->ID, 'gallery_image_ids', true);

if (!empty($gallery_image_ids)) {
	$exito_posts_image_gallery = get_post_meta($exito_postid, 'gallery_image_ids', true);
} else {
	// Backwards compat
	$attachment_ids = get_posts('post_parent=' . $exito_postid . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
	$attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
	$exito_posts_image_gallery = implode(',', $attachment_ids);
}

$attachments = array_filter(explode(',', $exito_posts_image_gallery));

    if ($attachments) {
        echo '<div class="post-slider owl-carousel clearfix">';
			foreach ($attachments as $attachment) {
				$exito_featured_image_url = wp_get_attachment_url($attachment);
				$exito_featured_image = '<img src="' . exito_aq_resize( $exito_featured_image_url, $exito_width, $exito_height, true, true, true ) . '" alt="' . get_the_title() . '" />';
				?>
				<div class="item">
					<?php echo $exito_featured_image; ?>
				</div>
			<?php  }
        echo '</div>';
    }
?>