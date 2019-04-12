<?php 

global $post, $exito_options;

$exito_custom_divider 			= $exito_options['custom_divider']['url'];
$exito_custom_divider_width 	= isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48';
$exito_featured_image_url 		= wp_get_attachment_url(get_post_thumbnail_id());
$exito_post_link 				= get_post_meta($post->ID, 'exito_post_link', true);
?>

	<div class="post-link">
		<div class="featured_img_bg" 
			<?php if(!empty($exito_featured_image_url)) { ?>
				style="background-image:url(<?php echo esc_url( $exito_featured_image_url ); ?>);"
			<?php } ?>
		></div>
		<div class="post_link_wrap text-center">
			<i class="fa fa-link"></i>
			<h4><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php echo the_title(); ?></a></h4>
			<div class="divider_active">
				<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
					<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
				<?php } else { ?>
					<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
				<?php } ?>
			</div>
			<?php if(!empty($exito_post_link)) { echo '<a class="post_link" href="' . esc_url( $exito_post_link ) . '">' . esc_attr( $exito_post_link ) . '</a>'; } ?>
		</div>
	</div>