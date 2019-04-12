<?php
/**
 * The blog post content
 */

global $post;

$exito_featured_image_url = wp_get_attachment_url(get_post_thumbnail_id());
$metro_sizing = get_post_meta( $post->ID, 'exito_metro', true );
if( $columns != '' ) {
	if( $columns == 'col3' ) {
		if( $metro_sizing == 'width2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 1400, 700, true, true, true );
		} elseif( $metro_sizing == 'height2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 700, 1400, true, true, true );
		} elseif( $metro_sizing == 'wh2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 1400, 1400, true, true, true );
		} else {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 700, 700, true, true, true );
		}
	} elseif( $columns == 'col4' ) {
		if( $metro_sizing == 'width2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 1100, 550, true, true, true );
		} elseif( $metro_sizing == 'height2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 550, 1100, true, true, true );
		} elseif( $metro_sizing == 'wh2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 1100, 1100, true, true, true );
		} else {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 550, 550, true, true, true );
		}
	} elseif( $columns == 'col5' ) {
		if( $metro_sizing == 'width2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 850, 425, true, true, true );
		} elseif( $metro_sizing == 'height2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 425, 1100, true, true, true );
		} elseif( $metro_sizing == 'wh2' ) {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 850, 850, true, true, true );
		} else {
			$exito_featured_image_bg = exito_aq_resize( $exito_featured_image_url, 425, 425, true, true, true );
		}
	} else {
		$exito_featured_image_bg = $exito_featured_image_url;
	}
}
?>
 
	<div class="post-content-wrapper">
		<?php if(has_post_thumbnail()) { ?>
			<div class="featured_img_bg" style="background-image:url(<?php echo esc_url( $exito_featured_image_bg ); ?>);"></div>
		<?php } ?>
		<div class="post-descr-wrap">
			<span class="post-meta-date"><?php the_time('M j, Y') ?></span>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<a class="read_more" href="<?php the_permalink(); ?>"><?php echo esc_html__('Read More','exito') ?></a>
		</div>
	</div>