<?php 

global $post, $exito_options;

$exito_custom_divider 				= $exito_options['custom_divider']['url'];
$exito_custom_divider_width 		= isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48';
$exito_featured_image_url 			= wp_get_attachment_url(get_post_thumbnail_id());
$exito_post_quote_text 				= get_post_meta($post->ID, 'exito_post_quote_text', true);
$exito_post_quote_author 			= get_post_meta($post->ID, 'exito_post_quote_author', true);
$exito_post_quote_author_position 	= get_post_meta($post->ID, 'exito_post_quote_author_position', true);
?>

	<div class="post-quote">
		<div class="featured_img_bg" 
			<?php if( !empty( $exito_featured_image_url ) ) { ?>
				style="background-image:url(<?php echo esc_url( $exito_featured_image_url ); ?>);"
			<?php } ?>
		></div>
		<div class="post_quote_wrap text-center">
			<i class="theme_color">”</i>
			<h4><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'exito'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php if(!empty($exito_post_quote_text)) { echo esc_attr( $exito_post_quote_text ); } else { echo the_title(); } ?></a></h4>
			<div class="divider_active">
				<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
					<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
				<?php } else { ?>
					<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
				<?php } ?>
			</div>
			<p><?php if(!empty($exito_post_quote_author)) { echo esc_attr( $exito_post_quote_author ); } else { echo get_the_author_meta('display_name'); } ?></p>
			<?php if(!empty($exito_post_quote_author_position)) { echo '<span>' . esc_attr( $exito_post_quote_author_position ) . '</span>'; } ?>
		</div>
	</div>