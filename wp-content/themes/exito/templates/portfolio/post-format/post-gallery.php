<?php

global $post;

$exito_postid = get_the_ID();

$exito_portfolio_single_layout = get_post_meta( $post->ID, 'exito_portfolio_single_layout', true );
$exito_portfolio_single_carousel_enable = get_post_meta( $post->ID, 'exito_portfolio_single_carousel_enable', true );
$exito_portfolio_single_grid_pullleft = get_post_meta( $post->ID, 'exito_portfolio_single_grid_pullleft', true );

if( $exito_portfolio_single_carousel_enable == 'enable' ) {
	$exito_width = 1170;
	$exito_height = 600;
}

$exito_portfolio_single_carousel_layout = get_post_meta( $post->ID, 'exito_portfolio_single_carousel_layout', true );

$unique_id = uniqid('post_gallery');
$gallery_image_ids = get_post_meta( $post->ID, 'gallery_image_ids', true );

if (!empty($gallery_image_ids)) {
	$exito_posts_image_gallery = get_post_meta( $exito_postid, 'gallery_image_ids', true );
} else {
	// Backwards compat
	$attachment_ids = get_posts('post_parent=' . $exito_postid . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
	$attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
	$exito_posts_image_gallery = implode(',', $attachment_ids);
}

$attachments = array_filter(explode(',', $exito_posts_image_gallery));

    if ($attachments) {
		if( $exito_portfolio_single_carousel_enable == 'enable' ) {
			echo '<div id="'. esc_html( $unique_id ) .'" class="post-slider owl-carousel clearfix">';
		} else {
			echo '<div class="post_images_grid">';
		}
			foreach ($attachments as $attachment) {
				$exito_featured_image_url = wp_get_attachment_url($attachment);
				if( $exito_portfolio_single_carousel_enable == 'enable' ) {
					$exito_featured_image = '<img src="' . exito_aq_resize( $exito_featured_image_url, $exito_width, $exito_height, true, true, true ) . '" alt="' . get_the_title() . '" />';
				} else {
					$exito_featured_image = '<img class="mb50" src="' . esc_url( $exito_featured_image_url ) . '" alt="' . get_the_title() . '" />';
				}
				?>
				<div class="item">
					<?php echo $exito_featured_image; ?>
				</div>
			<?php  }
		echo '</div>';
    }

if( $exito_portfolio_single_carousel_enable == 'enable' ) {
?>
	<script type="text/javascript">
		<?php if ( $exito_portfolio_single_carousel_layout == 'full_width' && $exito_portfolio_single_layout != 'half_width' ) { ?>
			function portfolio_single_carousel_layout() {
				var FullwidthContainer = jQuery(window).width(),
					container = jQuery('#page-content > .container').width(),
					marginLeft = ( jQuery(window).width() - container ) / 2;
				
				jQuery('.portfolio_format_content').css({'margin-left': -marginLeft + 'px', 'width': FullwidthContainer + 'px', 'padding': '0 50px'});
			}
			
			jQuery(window).resize(function(){
				portfolio_single_carousel_layout();
			});
		<?php } ?>
		
		jQuery(window).load(function() {
			<?php if ( $exito_portfolio_single_carousel_layout == 'full_width' && $exito_portfolio_single_layout != 'half_width' ) { ?>
				portfolio_single_carousel_layout();
			<?php } ?>
			
			jQuery('#<?php echo esc_html( $unique_id ); ?>.owl-carousel').owlCarousel({
				items: 1,
				margin: 0,
				dots: true,
				nav: true,
				navText: [
					"<i class='fa fa-angle-left'></i>",
					"<i class='fa fa-angle-right'></i>"
				],
				loop: true,
				autoplay: true,
				autoplaySpeed: 1000,
				autoplayTimeout: 5000,
				navSpeed: 1000,
				autoplayHoverPause: true,
				thumbs: false
			});
		});
	</script>
<?php
}

if ( $exito_portfolio_single_grid_pullleft == 'enable' ) { ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			"use strict";
			var FullwidthContainer = jQuery(window).width(),
				container = jQuery('#page-content > .container').width(),
				marginLeft = ( jQuery(window).width() - container ) / 2;
			
			jQuery('.portfolio_format_content').css({'margin-left': -marginLeft + 'px', 'margin-top': '-100px', 'margin-bottom': '-100px'});
			jQuery('.portfolio_format_content').find('img').removeClass('mb50');
		});
	</script>
<?php }