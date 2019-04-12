<?php
/**
 * Template Name: Page - Coming Soon
 */

get_header('comingsoon');

global $post, $exito_options;

$exito_custom_divider 			= $exito_options['custom_divider']['url'];
$exito_custom_divider_width 	= isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48';
$exito_coming_soon_subtitle 	= get_post_meta( $post->ID, 'exito_coming_soon_subtitle', true );
$exito_coming_soon_title 		= get_post_meta( $post->ID, 'exito_coming_soon_title', true );
$exito_coming_soon_descr 		= get_post_meta( $post->ID, 'exito_coming_soon_descr', true );
$exito_coming_soon_email 		= get_post_meta( $post->ID, 'exito_coming_soon_email', true );

$exito_coming_soon_bg_styles = $exito_coming_soon_bg_image = $exito_coming_soon_bg_image_repeat = $exito_coming_soon_bg_color = $exito_coming_soon_bg_attachment = $exito_coming_soon_bg_position = $exito_coming_soon_bg_cover = $exito_coming_soon_text_color = '';
$exito_coming_soon_bg_image 	= get_post_meta( $post->ID, 'exito_coming_soon_bg_image', true );

if ( $exito_coming_soon_bg_image ) {
	if ( is_numeric( $exito_coming_soon_bg_image ) ) {
		$exito_coming_soon_bg_image = wp_get_attachment_image_src( $exito_coming_soon_bg_image, 'full' );
		$exito_coming_soon_bg_image = $exito_coming_soon_bg_image[0];
	}
}

$exito_coming_soon_bg_image_repeat 	= get_post_meta( $post->ID, 'exito_coming_soon_bg_repeat', true );
$exito_coming_soon_bg_color 		= get_post_meta( $post->ID, 'exito_coming_soon_bg_color', true );
$exito_coming_soon_bg_attachment 	= get_post_meta( $post->ID, 'exito_coming_soon_bg_attachment', true );
$exito_coming_soon_bg_position 		= get_post_meta( $post->ID, 'exito_coming_soon_bg_position', true );
$exito_coming_soon_bg_cover 		= get_post_meta( $post->ID, 'exito_coming_soon_bg_full', true );

if( isset( $exito_coming_soon_bg_image ) && $exito_coming_soon_bg_image != '' ) {
	$exito_coming_soon_bg_styles .= 'background-image: url('. $exito_coming_soon_bg_image .');';
	if( isset( $exito_coming_soon_bg_image_repeat ) && $exito_coming_soon_bg_image_repeat != '' ) {
		$exito_coming_soon_bg_styles .= 'background-repeat: '. $exito_coming_soon_bg_image_repeat .';';
	}
	if( isset( $exito_coming_soon_bg_attachment ) && $exito_coming_soon_bg_attachment != '' ) {
		$exito_coming_soon_bg_styles .= 'background-attachment: '. $exito_coming_soon_bg_attachment .';';
	}
	if( isset( $exito_coming_soon_bg_position ) && $exito_coming_soon_bg_position != '' ) {
		$exito_coming_soon_bg_styles .= 'background-position: '. $exito_coming_soon_bg_position .';';
	}
	if( isset( $exito_coming_soon_bg_cover ) && $exito_coming_soon_bg_cover != '' ) {
		$exito_coming_soon_bg_styles .= 'background-size: '. $exito_coming_soon_bg_cover .';';
		$exito_coming_soon_bg_styles .= '-moz-background-size: '. $exito_coming_soon_bg_cover .';';
		$exito_coming_soon_bg_styles .= '-webkit-background-size: '. $exito_coming_soon_bg_cover .';';
		$exito_coming_soon_bg_styles .= '-o-background-size: '. $exito_coming_soon_bg_cover .';';
		$exito_coming_soon_bg_styles .= '-ms-background-size: '. $exito_coming_soon_bg_cover .';';
	}
}

if( isset( $exito_coming_soon_bg_color ) && $exito_coming_soon_bg_color != '' ) {
	$exito_coming_soon_bg_styles .= 'background-color: '. $exito_coming_soon_bg_color .';';
}

if( $exito_coming_soon_bg_styles ) {
	echo '
		<style>
			.coming_soon_wrapper { ' . $exito_coming_soon_bg_styles . ' }
		</style>
	';
}
?>
		
		<div class="coming_soon_wrapper text-center">
			<div class="container">
				<div class="text-center">
					<div class="divider_active">
						<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
							<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
						<?php } else { ?>
							<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
						<?php } ?>
					</div>
					<h4><?php echo esc_html( $exito_coming_soon_subtitle ); ?></h4>
					<div class="divider_active">
						<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
							<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
						<?php } else { ?>
							<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
						<?php } ?>
					</div>
				</div>
				<h1><?php echo esc_html( $exito_coming_soon_title ); ?></h1>
				<h6><?php echo esc_html( $exito_coming_soon_descr ) . ' <a href="mailto:' . esc_html( $exito_coming_soon_email ) . '">' . esc_html( $exito_coming_soon_email ) . '</a>'; ?></h6>
				
				<!-- COUNTDOWN -->
				<ul class="countdown">
					<i></i>
					<li>
						<span class="days">00</span>
						<p class="days_ref"><?php echo esc_attr__('days', 'exito'); ?></p>
					</li>
					<li>
						<span class="hours">00</span>
						<p class="hours_ref"><?php echo esc_attr__('hours', 'exito'); ?></p>
					</li>
					<li>
						<span class="minutes">00</span>
						<p class="minutes_ref"><?php echo esc_attr__('minutes', 'exito'); ?></p>
					</li>
					<li>
						<span class="seconds">00</span>
						<p class="seconds_ref"><?php echo esc_attr__('seconds', 'exito'); ?></p>
					</li>
				</ul><!-- //COUNTDOWN -->
			</div>
		</div>

<?php get_footer('comingsoon'); ?>