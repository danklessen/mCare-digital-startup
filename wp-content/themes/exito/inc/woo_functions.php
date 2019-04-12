<?php 

if ( ! function_exists( 'woocommerce_support' ) ) {
	function woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
}
add_action( 'after_setup_theme', 'woocommerce_support' );


/**
 * Hooks to WooCommerce actions, filters
 */

add_filter( 'exito_after_single_product_image', 'product_thumbnails' );


//	Products Columns
add_filter('loop_shop_columns', 'exito_shop_columns');
if (!function_exists('exito_shop_columns')) {
	function exito_shop_columns() {
		global $exito_options;
		
		if( class_exists( 'ReduxFrameworkPlugin' ) ) {
			if( $exito_options['shop_columns'] == 'col2' ) {
				return 2;
			} else if( $exito_options['shop_columns'] == 'col3' ){
				return 3;
			} else {
				return 4;
			}
		} else {
			return 3;
		}
	}
}


//	Product image size
if (!function_exists('exito_woocommerce_image_dimensions')) {
	function exito_woocommerce_image_dimensions() {
		$catalog = array(
			'width' 	=> '370',
			'height'	=> '370',
			'crop'		=> 1
		);
		
		$single = array(
			'width' 	=> '570',
			'height'	=> '570',
			'crop'		=> 1
		);

		$thumbnail = array(
			'width' 	=> '70',
			'height'	=> '70',
			'crop'		=> 1
		);

		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog );
		update_option( 'shop_single_image_size', $single );
		update_option( 'shop_thumbnail_image_size', $thumbnail );
	}
}
add_action( 'init', 'exito_woocommerce_image_dimensions' );


//	Products per page
add_filter( 'loop_shop_per_page', function ( $cols ) {    
	global $exito_options;

	$exito_products_per_page = ( strlen( $exito_options['products_per_page'] ) > 0 ) ? intval( $exito_options['products_per_page'] ) : 6;
	
	return $exito_products_per_page;
}, 20 );


//	Page Title
add_filter('woocommerce_show_page_title', 'exito_woo_title_none');
if (!function_exists('exito_woo_title_none')) {
	function exito_woo_title_none(){
		return false;
	}
}

//	WooCommerce Product Item
add_action('woocommerce_before_shop_loop_item', 'exito_before_shop_loop_item',5);
add_action('woocommerce_after_shop_loop_item', 'exito_after_shop_loop_item',5);

if ( ! function_exists( 'exito_before_shop_loop_item' ) ) {
	function exito_before_shop_loop_item() {
		global $woocommerce, $product, $post, $exito_options;
		
		$exito_products_list_type = isset( $exito_options['products_list_type'] ) ? $exito_options['products_list_type'] : 'type1';
		?>
		<div class="product_wrap <?php if ( $product->is_on_sale() ) { echo 'product_sale'; } ?> <?php echo 'products_list_' . $exito_products_list_type; ?>">

			<?php if( $exito_products_list_type == 'type2' ) { ?>
				
				<div class="shop_list_product_image">
					<a href="<?php the_permalink(); ?>">
						<?php 
							echo woocommerce_get_product_thumbnail();
							
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								$secondary_image_id = $attachment_ids['0'];
								echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) );
							}
						?>
					</a>
					<?php if ( $product->is_on_sale() ) {

						$exito_sale_text = esc_attr__( 'Sale', 'exito' );
				
						echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $exito_sale_text . '</span>', $post, $product );
						
					} ?>
				</div>
				<div class="shop_list_product_descr">
					<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="product_categories">', '</span>' ); ?>
					<h6 class="product-title"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h6>
					<div class="price_wrap"><?php woocommerce_template_loop_price(); ?></div>
				</div>
			
			<?php } elseif( $exito_products_list_type == 'type3' ) { ?>
				
				<div class="shop_list_product_image">
					<a href="<?php the_permalink(); ?>">
						<?php 
							echo woocommerce_get_product_thumbnail();
							
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								$secondary_image_id = $attachment_ids['0'];
								echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) );
							}
						?>
					</a>
					<?php if ( $product->is_on_sale() ) {

						$exito_sale_text = esc_attr__( 'Sale', 'exito' );
				
						echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $exito_sale_text . '</span>', $post, $product );
						
					} ?>
					<?php woocommerce_template_loop_add_to_cart(); ?>
				</div>
				<div class="shop_list_product_descr">
					<div class="clearfix">
						<h6 class="product-title"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h6>
						<?php woocommerce_template_loop_price(); ?>
					</div>
					<?php woocommerce_template_loop_rating(); ?>
				</div>
			
			<?php } elseif( $exito_products_list_type == 'type4' ) { ?>
				
				<div class="shop_list_product_image">
					<a href="<?php the_permalink(); ?>">
						<?php 
							echo woocommerce_get_product_thumbnail();
							
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								$secondary_image_id = $attachment_ids['0'];
								echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) );
							}
						?>
					</a>
					<?php if ( $product->is_on_sale() ) {

						$exito_sale_text = esc_attr__( 'Sale', 'exito' );
				
						echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $exito_sale_text . '</span>', $post, $product );
						
					} ?>
					<?php woocommerce_template_loop_add_to_cart(); ?>
				</div>
				<div class="shop_list_product_descr text-center">
					<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="product_categories">', '</span>' ); ?>
					<h6 class="product-title"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h6>
					<?php woocommerce_template_loop_price(); ?>
				</div>
				
			<?php } elseif( $exito_products_list_type == 'type5' ) { ?>
				
				<div class="shop_list_product_image">
					<a href="<?php the_permalink(); ?>">
						<?php 
							echo woocommerce_get_product_thumbnail();
							
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								$secondary_image_id = $attachment_ids['0'];
								echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) );
							}
						?>
					</a>
					<?php if ( $product->is_on_sale() ) {

						$exito_sale_text = esc_attr__( 'Sale', 'exito' );
				
						echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $exito_sale_text . '</span>', $post, $product );
						
					} ?>
				</div>
				<div class="shop_list_product_descr">
					<h6 class="product-title"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h6>
					<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="product_categories">', '</span>' ); ?>
					<?php woocommerce_template_loop_price(); ?>
				</div>
				
			<?php } else { ?>
				
				<div class="shop_list_product_image">
					<a href="<?php the_permalink(); ?>">
						<?php 
							echo woocommerce_get_product_thumbnail();
							
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								$secondary_image_id = $attachment_ids['0'];
								echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) );
							}
						?>
					</a>
					<?php if ( $product->is_on_sale() ) {

						$exito_sale_text = esc_attr__( 'Sale', 'exito' );
				
						echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $exito_sale_text . '</span>', $post, $product );
						
					} ?>
				</div>
				<div class="shop_list_product_descr">
					<h6 class="product-title"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h6>
					
					<?php woocommerce_template_loop_rating(); ?>
					
					<div class="clearfix">
						<span class="price"><?php woocommerce_template_loop_price(); ?></span>
						
						<?php woocommerce_template_loop_add_to_cart(); ?>
					</div>
				</div>
				
			<?php } ?>

			<div class="hide">
			<?php
	}
}

if ( ! function_exists( 'exito_after_shop_loop_item' ) ) {
	function exito_after_shop_loop_item() {
		?>
			</div>
		</div>
		<?php
	}
}


// Custom Shop Pagination
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action('woocommerce_after_shop_loop', 'exito_get_shop_pagination', 10);
if (!function_exists('exito_get_shop_pagination')) {	
	function exito_get_shop_pagination() {
		echo exito_pagination();
	}
}


/* Change Positions */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title',5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt',20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta',40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing',50);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40);	
add_action('woocommerce_single_product_summary', 'exito_woocommerce_template_single_meta', 50);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 60);


/* Product Single Share Buttons */
add_action('woocommerce_share','exito_wooshare');
function exito_wooshare(){
	
	global $post, $exito_options;

	$exito_featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );
?>
	
	<div class="cswoo_sharebox">
		<b><?php echo esc_attr__( 'Share', 'exito' ); ?></b>
		
		<div class="cswoo_sharebox_links">
			<?php if( isset( $exito_options['single_post_sharebox_facebook'] ) && $exito_options['single_post_sharebox_facebook'] != '0') { ?>
				<a class="cswoo_social_link facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="<?php esc_html_e( 'Facebook', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
			<?php } ?>
			
			<?php if( isset( $exito_options['single_post_sharebox_twitter'] ) && $exito_options['single_post_sharebox_twitter'] != '0') { ?>
				<a class="cswoo_social_link twitter" href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" title="<?php esc_html_e( 'Twitter', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
			<?php } ?>
			
			<?php if( isset( $exito_options['single_post_sharebox_google'] ) && $exito_options['single_post_sharebox_google'] != '0') { ?>
				<a class="cswoo_social_link google-plus" href="http://plus.google.com/share?url=<?php the_permalink() ?>&amp;title=<?php echo str_replace(' ', '+', the_title('', '', false)); ?>" title="<?php esc_html_e( 'Google+', 'exito') ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>
			<?php } ?>
			
			<?php if( isset( $exito_options['single_post_sharebox_pinterest'] ) && $exito_options['single_post_sharebox_pinterest'] != '0') { ?>
				<?php $exito_featured_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID())); ?>
				<a class="cswoo_social_link pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&media=<?php echo (strlen($exito_featured_image_url[0]) > 0) ? $exito_featured_image_url[0] : get_option( 'exito_logo' ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-pinterest-p"></i></a>
			<?php } ?>
		</div>
	</div>
	
<?php
}


/* Related Products on Single page */
add_filter( 'woocommerce_output_related_products_args', 'exito_related_products_args' );
function exito_related_products_args( $args ) {
	
	$args['posts_per_page'] = 3;
	
	return $args;
}


//	Single Meta
function exito_woocommerce_template_single_meta(){
	global $post, $product;
	
	?>
	<div class="product_meta">

		<?php do_action( 'woocommerce_product_meta_start' ); ?>

		<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

			<span class="sku_wrapper"><b><?php echo esc_attr__( 'SKU', 'exito' ); ?></b><span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_attr__( 'N/A', 'exito' ); ?></span></span>

		<?php endif; ?>

		<span class="posted_in"><b><?php echo esc_attr__( 'Categories', 'exito' ); ?></b><?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?></span>
		<span class="tagged_as"><b><?php echo esc_attr__( 'Tags', 'exito' ); ?></b><?php echo wc_get_product_tag_list( $product->get_id(), ', ' ); ?></span>

		<?php do_action( 'woocommerce_product_meta_end' ); ?>

	</div>
<?php }


//	Nav Cart Icon
if(!function_exists('exito_woo_nav_cart')) {
	function exito_woo_nav_cart() {
		global $woocommerce;
	
		$inactive = '';
		$cart_count = $woocommerce->cart->get_cart_contents_count();
		?>
	
		<div id="woo-nav-cart">
			<div class="nav-cart-content">
				<i class="icon Evatheme-Icon-Fonts-thin-0443_shopping_cart_basket_store"></i>
				<?php if( $cart_count > 0 ) { ?>
					<span class="woo-cart-count"><?php echo esc_attr( $cart_count ); ?></span>
				<?php } ?>
			</div>
			<div class="nav-cart-products <?php if( $cart_count < 1 ) { echo 'cart_empty';} ?>">
				<div class="widget_shopping_cart"><div class="widget_shopping_cart_content"></div></div>				
			</div>
		</div>
	
	<?php 
	}
}


/**
 * Get product thumnails
 *
 * @since  1.0.0
 * @return string
 */
function product_thumbnails() {
	global $post, $product, $woocommerce;

	$attachment_ids = $product->get_gallery_image_ids();
	$video_thumb = get_post_meta( $product->get_id(), 'exito_product_video_thumbnail', true );
	if ( $video_thumb ) {
		$video_thumb = wp_get_attachment_image( $video_thumb, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
	}

	if ( $attachment_ids || $video_thumb ) {
		
		?>
		<div class="product-thumbnails" id="product-thumbnails">
			<div class="thumbnails"><?php

				$image_thumb = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

				if ( $image_thumb ) {

					printf(
						'<div>%s</div>',
						$image_thumb
					);

				}

				if ( $attachment_ids ) {
					foreach ( $attachment_ids as $attachment_id ) {

						$props = wc_get_product_attachment_props( $attachment_id, $post );

						if ( ! $props['url'] ) {
							continue;
						}

						echo apply_filters(
							'woocommerce_single_product_image_thumbnail_html',
							sprintf(
								'<div>%s</div>',
								wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
							),
							$attachment_id,
							$post->ID
						);
					}
				}

				if ( $video_thumb ) {
					printf(
						'<div class="video-thumb">%s</div>',
						$video_thumb
					);
				}

				?>
			</div>
		</div>
		<?php
	}

}
?>