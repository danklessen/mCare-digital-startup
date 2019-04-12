<?php
/**
 * The sidebar containing the main widget area
 */
 
global $post;

$exito_sidebar = get_post_meta( $post->ID, 'exito_sidebar', true );

if(is_home() || is_singular('post') || is_archive() || is_category() || is_tag() || is_search() || is_day() || is_month() || is_year()) {
	$exito_sidebar = 'blog-sidebar';
}

if( exito_woo_enabled() && get_post_type() == 'product' ) {
    $exito_sidebar = 'shop-sidebar';
}
?>
	<div id="blog_sidebar" class="<?php echo esc_html( $exito_sidebar ); ?>">
		
		<?php
			if ( is_active_sidebar( $exito_sidebar ) ) {
				dynamic_sidebar( $exito_sidebar );
			}
		?>
		
	</div>