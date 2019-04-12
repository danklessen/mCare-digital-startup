<?php
/**
 * The template for displaying products
 */

get_header();

global $exito_options;

$exito_shop_class = '';

$exito_shop_layout = isset( $exito_options['shop_layout'] ) ? $exito_options['shop_layout'] : 'right-sidebar';
if( $exito_shop_layout == 'left-sidebar' ) {
	$exito_sidebar_class = 'pull-left ';
	$exito_shop_class .= 'left_sidebar ';
	$exito_shop_list_class = 'col-md-9 pull-right';
} elseif( $exito_shop_layout == 'right-sidebar' ) {
	$exito_sidebar_class = 'pull-right';
	$exito_shop_class .= 'right_sidebar ';
	$exito_shop_list_class = 'col-md-9 pull-left ';
} else {
	$exito_sidebar_class = $exito_shop_list_class = '';
	$exito_shop_class .= 'no_sidebar ';
}

$exito_shop_columns = isset( $exito_options['shop_columns'] ) ? $exito_options['shop_columns'] : 'col3';
$exito_shop_class .= $exito_shop_columns . ' ';
?>

		<div id="products_list" class="container <?php echo esc_html( $exito_shop_class ); ?>">
			
			<?php
			if( $exito_shop_layout != 'no-sidebar' && !is_product() ) {
			echo '
				<div class="row">
					<div class="' . esc_html( $exito_shop_list_class ) . '">';
			}
			?>

						<div class="shop_wrap clearfix">
				
							<?php woocommerce_content(); ?>
						
						</div>
					
			<?php
			if( $exito_shop_layout != 'no-sidebar' && !is_product() ) {
			echo '</div>';
			}
			?>
				
			<?php if( $exito_shop_layout != 'no-sidebar' && !is_product() ) { ?>
					<div class="col-md-3 <?php echo esc_html( $exito_sidebar_class ); ?>">
						<?php get_sidebar(); ?>
					</div>
				</div>
			<?php } ?>
			
		</div>

<?php get_footer(); ?>