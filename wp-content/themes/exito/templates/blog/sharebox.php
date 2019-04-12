<?php

global $exito_options;

$exito_single_post_sharebox_facebook 	= isset( $exito_options['single_post_sharebox_facebook'] ) ? $exito_options['single_post_sharebox_facebook'] : '1';
$exito_single_post_sharebox_twitter 	= isset( $exito_options['single_post_sharebox_twitter'] ) ? $exito_options['single_post_sharebox_twitter'] : '1';
$exito_single_post_sharebox_linkedin 	= isset( $exito_options['single_post_sharebox_linkedin'] ) ? $exito_options['single_post_sharebox_linkedin'] : '0';
$exito_single_post_sharebox_reddit 		= isset( $exito_options['single_post_sharebox_reddit'] ) ? $exito_options['single_post_sharebox_reddit'] : '0';
$exito_single_post_sharebox_digg 		= isset( $exito_options['single_post_sharebox_digg'] ) ? $exito_options['single_post_sharebox_digg'] : '0';
$exito_single_post_sharebox_delicious 	= isset( $exito_options['single_post_sharebox_delicious'] ) ? $exito_options['single_post_sharebox_delicious'] : '0';
$exito_single_post_sharebox_google 		= isset( $exito_options['single_post_sharebox_google'] ) ? $exito_options['single_post_sharebox_google'] : '1';
$exito_single_post_sharebox_pinterest 	= isset( $exito_options['single_post_sharebox_pinterest'] ) ? $exito_options['single_post_sharebox_pinterest'] : '1';
?>

<div class="sharebox">
	<span><?php echo esc_html__( 'Share this :', 'exito' ); ?></span>
	
	<div class="sharebox_links">
		<?php if($exito_single_post_sharebox_facebook != '0') { ?>
			<a class="social_link facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="<?php esc_html_e( 'Facebook', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i><i class="fa fa-facebook"></i></a>
		<?php } ?>
		
		<?php if($exito_single_post_sharebox_twitter != '0') { ?>
			<a class="social_link twitter" href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" title="<?php esc_html_e( 'Twitter', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i><i class="fa fa-twitter"></i></a>
		<?php } ?>
		
		<?php if($exito_single_post_sharebox_linkedin != '0') { ?>
			<?php $exito_featured_image_url = wp_get_attachment_url(get_post_thumbnail_id()); ?>
			<a class="social_link linkedin" href="https://www.linkedin.com/cws/share?url=<?php echo get_permalink(); ?>&title=<?php echo get_the_title(); ?>&summary=<?php echo get_the_excerpt(); ?>" title="Linkedin Share" data-image="<?php echo esc_url( $exito_featured_image_url ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-linkedin"></i><i class="fa fa-linkedin"></i></a><script type="in/share" data-url="<?php echo get_permalink() ?>" data-counter="right"></script>
		<?php } ?>
		
		<?php if($exito_single_post_sharebox_reddit != '0') { ?>
			<a class="social_link reddit" href="http://www.reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('', '', false)) ?>" title="<?php esc_html_e( 'Reddit', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-reddit"></i><i class="fa fa-reddit"></i></a>
		<?php } ?>
		
		<?php if($exito_single_post_sharebox_digg != '0') { ?>
			<a class="social_link digg" href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;bodytext=&amp;tags=&amp;title=<?php echo urlencode(the_title('', '', false)) ?>" title="<?php esc_html_e( 'Digg', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-digg"></i><i class="fa fa-digg"></i></a>
		<?php } ?>
		
		<?php if($exito_single_post_sharebox_delicious != '0') { ?>
			<a class="social_link delicious" href="http://www.delicious.com/post?v=2&amp;url=<?php the_permalink() ?>&amp;notes=&amp;tags=&amp;title=<?php echo urlencode(the_title('', '', false)) ?>" title="<?php esc_html_e( 'Delicious', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-delicious"></i><i class="fa fa-delicious"></i></a>
		<?php } ?>
		
		<?php if($exito_single_post_sharebox_google != '0') { ?>
			<a class="social_link google-plus" href="http://plus.google.com/share?url=<?php the_permalink() ?>&amp;title=<?php echo str_replace(' ', '+', the_title('', '', false)); ?>" title="<?php esc_html_e( 'Google+', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i><i class="fa fa-google-plus"></i></a>
		<?php } ?>
		
		<?php if($exito_single_post_sharebox_pinterest != '0') { ?>
			<?php $exito_featured_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID())); ?>
			<a class="social_link pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&media=<?php echo (strlen($exito_featured_image_url[0]) > 0) ? $exito_featured_image_url[0] : get_option( 'exito_logo' ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-pinterest-p"></i><i class="fa fa-pinterest-p"></i></a>
		<?php } ?>
	</div>
</div>