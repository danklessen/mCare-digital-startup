<?php
/**
 * Page Title
 */

	global $post, $wp_query, $exito_options;
	
	$exito_custom_divider = isset( $exito_options['custom_divider']['url'] ) ? $exito_options['custom_divider']['url'] : '';
	$exito_custom_divider_width = isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48';
	
	$exito_options_pagetitle = isset( $exito_options['pagetitle'] ) ? $exito_options['pagetitle'] : 'show';
	$exito_pagetitle = ( get_post_meta( $post->ID, 'exito_pagetitle', true ) ? get_post_meta( $post->ID, 'exito_pagetitle', true ) : $exito_options_pagetitle );
	if ( is_home() || is_singular('post') || is_category() || is_tag() || is_search() || is_day() || is_month() || is_year() ) {
		$exito_pagetitle = isset( $exito_options['blog_pagetitle'] ) ? $exito_options['blog_pagetitle'] : 'hide';
	} else if ( is_singular('portfolio') ) {
		$exito_pagetitle = isset( $exito_options['portfolio_single_pagetitle'] ) ? $exito_options['portfolio_single_pagetitle'] : 'show';
	} else if( class_exists('WooCommerce') && ( is_shop() || is_product_category() || is_product_tag() || is_cart() || is_checkout() || is_account_page() ) ) {
		$exito_pagetitle = isset( $exito_options['shop_pagetitle'] ) ? $exito_options['shop_pagetitle'] : 'show';
	} else if( class_exists('WooCommerce') && is_singular('product') ) {
		$exito_pagetitle = 'hide';
	}
	
	
	$exito_pagetitle_text				= get_post_meta( $post->ID, 'exito_pagetitle_text', true );
	$exito_blog_pagetitle_text			= isset( $exito_options['blog_pagetitle_text'] ) ? $exito_options['blog_pagetitle_text'] : esc_html__('Recent Posts', 'exito');
	$exito_pagetitle_subtext			= get_post_meta( $post->ID, 'exito_pagetitle_subtext', true );
	$exito_blog_pagetitle_subtext		= isset( $exito_options['blog_pagetitle_subtext'] ) ? $exito_options['blog_pagetitle_subtext'] : '';


	if ( $exito_pagetitle_subtext != '' ) {
		$exito_pagetitle_subtext = '<p>' . esc_attr( $exito_pagetitle_subtext ) . '</p>';
	} else if ( ( isset( $exito_options['blog_pagetitle_subtext'] ) && $exito_options['blog_pagetitle_subtext'] != '' ) && ( is_home() ) ) {
		$exito_pagetitle_subtext = '<p>' . esc_attr( $exito_blog_pagetitle_subtext ) . '</p>';
	} elseif ( is_search() ) {
		$exito_pagetitle_subtext = 'This is your custom search page';
	}
	
	if ( $exito_pagetitle_text != '' ) {
		$exito_pagetitle_text = '<h2>' . esc_attr( $exito_pagetitle_text ) . '</h2>';
	} else if (is_home()) {
		$exito_pagetitle_text = '<h2>' . esc_attr( $exito_blog_pagetitle_text ) . '</h2>';
	} else if ( is_singular('post') ) {
		if( isset( $exito_options['blogsingle_pagetitle_text'] ) && $exito_options['blogsingle_pagetitle_text'] != '' ){
			$exito_blogsingle_pagetitle_text = $exito_options['blogsingle_pagetitle_text'];
			$exito_pagetitle_text  = '<h2>' . esc_attr( $exito_blogsingle_pagetitle_text ) . '</h2>';
		} else {
			$exito_pagetitle_text  = '<h2>' . esc_html__( 'Single Post', 'exito' ) . '</h2>';
		}
		if( isset( $exito_options['blogsingle_pagetitle_subtext'] ) && $exito_options['blogsingle_pagetitle_subtext'] != '' ){
			$exito_blogsingle_pagetitle_subtext 	= $exito_options['blogsingle_pagetitle_subtext'];
			$exito_pagetitle_subtext  = '<p>' . esc_attr( $exito_blogsingle_pagetitle_subtext ) . '</p>';
		}
	} else if ( is_singular('portfolio') ) {
		if( isset( $exito_options['portfolio_single_pagetitle_subtext'] ) && $exito_options['portfolio_single_pagetitle_subtext'] != '' ) {
			$exito_pagetitle_subtext  = '<p>' . esc_attr( $exito_options['portfolio_single_pagetitle_subtext'] ) . '</p>';
		}
		if( isset( $exito_options['portfolio_single_pagetitle_text'] ) && $exito_options['portfolio_single_pagetitle_text'] != '' ) {
			$exito_pagetitle_text  = '<h2>' . esc_attr( $exito_options['portfolio_single_pagetitle_text'] ) . '</h2>';
		}
	} else if( class_exists('WooCommerce') && is_shop() ) {
		if( isset( $exito_options['shop_pagetitle_subtext'] ) && $exito_options['shop_pagetitle_subtext'] != '' ){
			$exito_pagetitle_subtext  = '<p>' . esc_attr( $exito_options['shop_pagetitle_subtext'] ) . '</p>';
		}
		if( isset( $exito_options['shop_pagetitle_text'] ) && $exito_options['shop_pagetitle_text'] != '' ){
			$exito_pagetitle_text  = '<h2>' . esc_attr( $exito_options['shop_pagetitle_text'] ) . '</h2>';
		}
	} else if (is_category()) {
		$exito_pagetitle_text = '<h2>' . esc_attr__( 'Category Archive for :', 'exito' ) . ' &#8216;' . single_cat_title( '', false ) . '&#8217 </h2>';
	} else if( is_tag() ) {
		$exito_pagetitle_text = '<h2>' . esc_attr__( 'Posts Tagged', 'exito' ) . ' &#8216;' . single_tag_title() . '&#8217;</h2>';
	} else if( is_search() ) {
		$exito_pagetitle_text = '<h2>' . $wp_query->found_posts . ' ' . esc_attr__( 'search results for', 'exito' ) . ': \'' . esc_attr( get_search_query() ) . '\'</span></h2>';
	} else if ( is_day() || is_month() || is_year() ) {
		$exito_pagetitle_text = '<h2>' . esc_attr__( 'Archive for', 'exito' ) . ' ' . get_the_time( get_option( 'date_format' ) ) . '</span></h2>';
	} else if (is_author()) {
		$exito_pagetitle_text = '<h2>' . esc_attr__( 'Author Archive', 'exito' ) . '</h2>';
	} else if (is_404()) {
		$exito_pagetitle_text = '<h2>' . esc_attr__( 'Error 404', 'exito' ) . '</h2>';
	} else if (isset($_GET['paged']) && !empty($_GET['paged'])) {
		$exito_pagetitle_text = '<h2>' . esc_attr__( 'Blog Archives', 'exito' ) . '</h2>';
	} else {
		$exito_pagetitle_text = '<h2>' . get_the_title() . '</h2>';
	}
	
	/* Parallax Effect */
	$exito_pagetitle_bg_image_parallax = $exito_pagetitle_bg_image_parallax_theme = $exito_pagetitle_bg_image_parallax_page = $exito_pagetitle_class = '';
	$exito_pagetitle_bg_image_parallax_theme = get_post_meta( $post->ID, 'exito_pagetitle_bg_image_parallax', true );
	if( isset( $exito_options['pagetitle_bg_image_parallax'] ) ){
		$exito_pagetitle_bg_image_parallax_page 	= $exito_options['pagetitle_bg_image_parallax'];
	}
	$exito_pagetitle_bg_image_parallax = ! empty( $exito_pagetitle_bg_image_parallax_theme ) ? $exito_pagetitle_bg_image_parallax_theme : $exito_pagetitle_bg_image_parallax_page;
	if ( $exito_pagetitle_bg_image_parallax == 'enable' ) {
		wp_enqueue_script('exito-parallax', get_template_directory_uri() . '/assets/js/custom-parallax.js', array(), '', true);
		$exito_pagetitle_class .= ' exito_parallax';
	}
	
	/* If Single Post Fullscreen */
	$exito_post_single_style = '';
	$exito_post_single_style = get_post_meta( $post->ID, 'exito_post_single_style', true );
	if ( is_singular('post') && $exito_post_single_style == 'fullscreen' ) {
		$exito_pagetitle_class .= ' pagetitle_fullscreen';
	}
	
?>
		
		<?php if ( $exito_pagetitle == 'show' ) { ?>
			<div id="pagetitle" class="<?php echo esc_html( $exito_pagetitle_class ); ?>">
				<div class="container text-center">
					
					<?php if ( is_singular('post') && $exito_post_single_style == 'fullscreen' ) { ?>
						
						<div class="single_post_header">
							<?php echo exito_likes(); ?>
							<h2 class="single-post-title"><?php the_title(); ?></h2>
							<div class="post-meta">
								<span class="post-meta-author"><?php echo esc_attr__('by','exito'); ?><i><?php echo the_author_meta( 'display_name' , $post->post_author ); ?></i></span>
								<span class="post_meta_category"><?php echo esc_attr__('in','exito'); ?><?php the_category(', '); ?></span>
								<span class="post-meta-date"><?php echo esc_attr__('posted','exito'); ?><i><?php the_time('j F, Y'); ?></i></span>
								<span class="post-meta-comments"><?php echo exito_comment_count(); ?></span>
							</div>
						</div>
						
					<?php } else { ?>
					
						<?php echo $exito_pagetitle_subtext; ?>
						<?php echo $exito_pagetitle_text; ?>
						
					<?php } ?>
					<div class="divider_active">
						<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
							<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
						<?php } else { ?>
							<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
		
		<?php $exito_options_breadcrumbs = isset( $exito_options['breadcrumbs'] ) ? $exito_options['breadcrumbs'] : 'show'; ?>
		<?php $exito_breadcrumbs = ( get_post_meta( $post->ID, 'exito_breadcrumbs', true ) ? get_post_meta( $post->ID, 'exito_breadcrumbs', true ) : $exito_options_breadcrumbs ); ?>
		<?php if ( is_singular('portfolio') ) {
			$exito_breadcrumbs = isset( $exito_options['portfolio_single_breadcrumbs'] ) ? $exito_options['portfolio_single_breadcrumbs'] : 'show';
		} ?>
		
		<?php if ( $exito_breadcrumbs == 'show' ) { ?>
			<div id="breadcrumbs">
				<div class="container">
					<div class="row">
						<div class="col-sm-8">
							<?php exito_breadcrumbs(); ?>
						</div>
						<?php if ( ! is_front_page() ) { ?>
							<div class="col-sm-4 text-right">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-chevron-left"></i><?php echo esc_attr__( 'Back Home', 'exito' ); ?></a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>