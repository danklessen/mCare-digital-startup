<?php
/**
 * Custom functions and definitions
 */


//	Add specific CSS class by filter
add_filter( 'body_class', 'exito_body_class' );
function exito_body_class( $classes ) {
	
	global $post, $exito_options;
	
	$exito_postId = ( isset( $post->ID ) ? get_the_ID() : NULL );
	
	//	If Site Boxed
	if ( isset( $exito_postId ) && get_post_meta( $exito_postId, 'exito_page_layout', true ) ) {
		$exito_options_theme_layout = isset( $exito_options['theme_layout'] ) ? $exito_options['theme_layout'] : 'full-width';
		$exito_theme_layout = ( get_post_meta( $exito_postId, 'exito_page_layout', true ) ? get_post_meta( $exito_postId, 'exito_page_layout', true ) : $exito_options_theme_layout );
	} else {
		$exito_theme_layout = isset( $exito_options['theme_layout'] ) ? $exito_options['theme_layout'] : 'full-width';
	}
	if ($exito_theme_layout == 'boxed') {
		$classes[] = 'boxed';
	} else {
		$classes[] = 'full-width';
	}
	
	//	Header Layout
	$exito_header_style = 'header-top';
	$classes[] = $exito_header_style;
	
	//	Header has BG
	$exito_header_bg_style = isset( $exito_options['header_bg_style'] ) ? $exito_options['header_bg_style'] : 'bgcolor';
	$exito_header_page_bg_style = get_post_meta( $exito_postId, 'exito_header_page_bg_style', true );
	$exito_header_bg_style = !empty( $exito_header_page_bg_style ) ? $exito_header_page_bg_style : $exito_header_bg_style;
	if ( is_search() ) {
		$exito_header_bg_style = 'bgcolor';
	}
	$classes[] = 'header_' . $exito_header_bg_style;
	
	//	Header has BG with Opacity
	$exito_header_bgcolor_opacity = isset( $exito_options['header_bgcolor_opacity'] ) ? $exito_options['header_bgcolor_opacity'] : '90';
	if ( isset( $exito_header_bg_style ) && $exito_header_bgcolor_opacity != '99' ) {
		$classes[] = 'header_opacity';
	}
	
	//	Page Title show/hide
	$exito_options_pagetitle = isset( $exito_options['pagetitle'] ) ? $exito_options['pagetitle'] : 'show';
	$exito_pagetitle = ( get_post_meta( $exito_postId, 'exito_pagetitle', true ) ? get_post_meta( $exito_postId, 'exito_pagetitle', true ) : $exito_options_pagetitle );
	if ( is_home() || is_singular('post') || is_category() || is_tag() || is_search() || is_day() || is_month() || is_year() ) {
		$exito_pagetitle = isset( $exito_options['blog_pagetitle'] ) ? $exito_options['blog_pagetitle'] : 'hide';
	} else if ( is_singular('portfolio') ) {
		$exito_pagetitle = isset( $exito_options['portfolio_single_pagetitle'] ) ? $exito_options['portfolio_single_pagetitle'] : 'show';
	} else if( class_exists('WooCommerce') && ( is_shop() || is_product_category() || is_product_tag() || is_cart() || is_checkout() || is_account_page() ) ) {
		$exito_shop_pagetitle = isset( $exito_options['shop_pagetitle'] ) ? $exito_options['shop_pagetitle'] : 'show';
		$exito_pagetitle = $exito_shop_pagetitle;
	} else if( class_exists('WooCommerce') && is_singular('product') ) {
		$exito_pagetitle = 'hide';
	}
	
	$classes[] = 'pagetitle_' . $exito_pagetitle;
	
	//	Page Title show/hide
	$exito_options_breadcrumbs = isset( $exito_options['breadcrumbs'] ) ? $exito_options['breadcrumbs'] : 'show';
	$exito_breadcrumbs = ( get_post_meta( $exito_postId, 'exito_breadcrumbs', true ) ? get_post_meta( $exito_postId, 'exito_breadcrumbs', true ) : $exito_options_breadcrumbs );
	$classes[] = 'breadcrumbs_' . $exito_breadcrumbs;
	
	//	Footer Fixed
	if( isset( $exito_options['footer_fixed'] ) && $exito_options['footer_fixed'] != '0' ) {
		$classes[] = 'footer_fixed';
	}
	
	if ( class_exists( 'woocommerce' ) ) {
		if( isset( $newlife_options['products_no_padding'] ) && $newlife_options['products_no_padding'] != 0 ) {
			$classes[] = 'woo_no_paddings';
		}
	}
	
	return $classes;
}


//	if WooCommerce Plugin Active
function exito_woo_enabled() {
    if ( class_exists( 'woocommerce' ) )
        return true;
    return false;
}


/**
 * Insert social metadata into the header
 */
if ( ! function_exists( 'exito_social_meta' ) ) {
	function exito_social_meta() {

		global $post, $exito_options;

		if ( is_singular() ) {

	        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
	        echo '<meta property="og:type" content="article"/>';
	        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
	        echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '"/>';

			if ( has_post_thumbnail( $post->ID ) ) {
				$exito_thumb = get_post_thumbnail_id();
				$exito_img_url = wp_get_attachment_image_src( $exito_thumb, 'large' );
				$exito_img_url = $exito_img_url[0];
			} else {
				$exito_img_url = isset( $exito_options['header-logo']['url'] ) ? $exito_options['header-logo']['url'] : get_template_directory_uri() . '/assets/images/logo.png';
			}

			echo '<meta itemprop="image" content="' . $exito_img_url . '"> ';
			echo '<meta name="twitter:image:src" content="' . $exito_img_url . '">';
			echo '<meta property="og:image" content="' . $exito_img_url . '" />';

		}
	}
}


//	Theme Logo
if ( ! function_exists( 'exito_logo' ) ) { 
	function exito_logo() {
		
		global $exito_options;
		
		if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
			$exito_logo_src 		= get_template_directory_uri() . '/assets/images/logo.png';
			$exito_logo_retina_src 	= '';
		} else {
			$exito_logo_src 		= isset( $exito_options['header-logo']['url'] ) ? $exito_options['header-logo']['url'] : '';
			$exito_logo_retina_src 	= isset( $exito_options['header-logo-retina']['url'] ) ? $exito_options['header-logo-retina']['url'] : '';
			$exito_logo_width 		= isset( $exito_options['header-logo-width'] ) ? $exito_options['header-logo-width'] : '';
		}
		
		echo '<div class="cstheme-logo">';
			if ( $exito_logo_src != '' || $exito_logo_retina_src != '' ) {
				echo '<a class="logo" href="' . esc_url( home_url( '/' ) ) . '">';
					if( $exito_logo_retina_src != '' ) {
						echo '<img class="logo-img retina" src="' . esc_url( $exito_logo_retina_src ) . '" style="width:' . esc_attr( $exito_logo_width ) . 'px" alt="' . get_bloginfo( 'name' ) . '" />';
					} else {
						echo '<img class="logo-img" src="' . esc_url( $exito_logo_src ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
					}
				echo '</a>';
			} else {
				echo '<h1 class="site-name">';
					echo '<a class="logo" href="'. esc_url( home_url( '/' ) ) .'">';
						bloginfo('name');
					echo '</a>';
				echo '</h1>';
			}
		echo '</div>';
	}
}


//	Theme Favicon
function exito_favicon() {
	
	global $exito_options;
	
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		if(isset($exito_options['favicon']['url']) && $exito_options['favicon']['url']) {
			echo '<link rel="shortcut icon" href="' . esc_url( $exito_options['favicon']['url'] ) . '"/>';
		} else {
			echo '<link rel="shortcut icon" href="'. get_template_directory_uri() . '/assets/images/favicon.png" />';
		}
		
		if( isset( $exito_options['favicon-retina']['url'] ) && $exito_options['favicon-retina']['url'] ) {
			echo '<link rel="apple-touch-icon" href="' . esc_url( $exito_options['favicon-retina']['url'] ) . '">';
		}
		if( isset( $exito_options['apple_icons_57x57']['url'] ) && $exito_options['apple_icons_57x57']['url'] ) {
			echo '<link rel="apple-touch-icon" sizes="57x57" href="' . esc_url( $exito_options['apple_icons_57x57']['url'] ) . '">';
		}
		if( isset( $exito_options['apple_icons_72x72']['url'] ) && $exito_options['apple_icons_72x72']['url'] ) {
			echo '<link rel="apple-touch-icon" sizes="72x72" href="' . esc_url( $exito_options['apple_icons_72x72']['url'] ) . '">';
		}
		if( isset( $exito_options['apple_icons_114x114']['url'] ) && $exito_options['apple_icons_114x114']['url'] ) {
			echo '<link rel="apple-touch-icon" sizes="114x114" href="' . esc_url( $exito_options['apple_icons_114x114']['url'] ) . '">';
		}
		
	}
	
}


//	Theme Preloader
function exito_preloader() {
	
	global $exito_options;
	
	$exito_preloader = isset( $exito_options['preloader'] ) ? $exito_options['preloader'] : 1;
	
	if( $exito_preloader != 0 ) {
		echo '<div id="loader"><div class="loader_wrap"><span>' . esc_attr__( 'Loading', 'exito' ) . '</span><div class="bar_wrap"><div class="bar"></div></div></div></div>';
	}
}


//	Social Links
if ( ! function_exists( 'exito_social_links' ) ) { 

	function exito_social_links() {	
	
		global $exito_options;
		
		$output = '';
		$exito_social_links = array();
		
		if( isset( $exito_options['facebook_link'] ) && $exito_options['facebook_link'] ) {
			$exito_social_links['facebook'] = $exito_options['facebook_link'];
		}
		
		if( isset( $exito_options['twitter_link'] ) && $exito_options['twitter_link'] ) {
			$exito_social_links['twitter'] = $exito_options['twitter_link'];
		}
		
		if( isset( $exito_options['linkedin_link'] ) && $exito_options['linkedin_link'] ) {
			$exito_social_links['linkedin'] = $exito_options['linkedin_link'];
		}
		
		if( isset( $exito_options['pinterest_link'] ) && $exito_options['pinterest_link'] ) {
			$exito_social_links['pinterest'] = $exito_options['pinterest_link'];
		}
		
		if( isset( $exito_options['googleplus_link'] ) && $exito_options['googleplus_link'] ) {
			$exito_social_links['google-plus'] = $exito_options['googleplus_link'];
		}
		
		if( isset( $exito_options['youtube_link'] ) && $exito_options['youtube_link'] ) {
			$exito_social_links['youtube'] = $exito_options['youtube_link'];
		}
		
		if( isset( $exito_options['rss_link'] ) && $exito_options['rss_link'] ) {
			$exito_social_links['rss'] = $exito_options['rss_link'];
		}
		
		if( isset( $exito_options['tumblr_link'] ) && $exito_options['tumblr_link'] ) {
			$exito_social_links['tumblr'] = $exito_options['tumblr_link'];
		}
		
		if( isset( $exito_options['reddit_link'] ) && $exito_options['reddit_link'] ) {
			$exito_social_links['reddit'] = $exito_options['reddit_link'];
		}
		
		if( isset( $exito_options['dribbble_link'] ) && $exito_options['dribbble_link'] ) {
			$exito_social_links['dribbble'] = $exito_options['dribbble_link'];
		}
		
		if( isset( $exito_options['digg_link'] ) && $exito_options['digg_link'] ) {
			$exito_social_links['digg'] = $exito_options['digg_link'];
		}
		
		if( isset( $exito_options['flickr_link'] ) && $exito_options['flickr_link'] ) {
			$exito_social_links['flickr'] = $exito_options['flickr_link'];
		}
		
		if( isset( $exito_options['instagram_link'] ) && $exito_options['instagram_link'] ) {
			$exito_social_links['instagram'] = $exito_options['instagram_link'];
		}
		
		if( isset( $exito_options['vimeo_link'] ) && $exito_options['vimeo_link'] ) {
			$exito_social_links['vimeo'] = $exito_options['vimeo_link'];
		}
		
		if( isset( $exito_options['skype_link'] ) && $exito_options['skype_link'] ) {
			$exito_social_links['skype'] = $exito_options['skype_link'];
		}
		
		if( isset( $exito_options['yahoo_link'] ) && $exito_options['yahoo_link'] ) {
			$exito_social_links['yahoo'] = $exito_options['yahoo_link'];
		}
		
		$exito_icon_class = '';
		$exito_social_link = '';
		
		if( isset( $exito_social_links ) && is_array( $exito_social_links ) ) {
			foreach( $exito_social_links as $exito_icon => $exito_link ) {
				$exito_icon_class = $exito_icon;
				
				$exito_icon = 'fa fa-' . $exito_icon;
				
				$exito_social_link .= '<a class="social_link" href="' . esc_url( $exito_link ) . '" target="_blank"><i class="' . esc_attr( $exito_icon ) . '"></i><i class="' . esc_attr( $exito_icon ) . '"></i></a>';
			}
		}
		
		if( isset( $exito_social_link ) && $exito_social_link != '' ) {
			$output .= $exito_social_link;
		}

		return $output;
	}
}


/**
 * Post excerpt
 */
if (!function_exists('exito_smarty_modifier_truncate')) {
    function exito_smarty_modifier_truncate($string, $length = 80, $etc = '... ',
		$break_words = false)
    {
        if ($length == 0)
            return '';

        if (mb_strlen($string, 'utf8') > $length) {
            $length -= mb_strlen($etc, 'utf8');
            if (!$break_words) {
                $string = preg_replace('/\s+\S+\s*$/su', '', mb_substr($string, 0, $length + 1, 'utf8'));
            }
            return mb_substr($string, 0, $length, 'utf8') . $etc;
        } else {
            return $string;
        }
    }
}

//	Comments Count
if (!function_exists('exito_comment_count')) {
	function exito_comment_count() {
		$exito_comment_count = get_comments_number('0', '1', '%');
		if ($exito_comment_count == 0) {
			$exito_comment_trans = esc_attr__('No Comments', 'exito');
		} elseif ($exito_comment_count == 1) {
			$exito_comment_trans = esc_attr__('1 Comment', 'exito');
		} else {
			$exito_comment_trans = $exito_comment_count . ' ' . esc_attr__('Comments', 'exito');
		}
		return '<a class="cstheme_comment_count" href="' . get_comments_link() . '" title="' . $exito_comment_trans . '"><i class="icon Evatheme-Icon-Fonts-thin-0274_chat_message_comment_bubble"></i>' . $exito_comment_trans . '</a>';
	}
}

/**
 * Single Post Comments List
 */

if (!function_exists('exito_comment')) {
    function exito_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; ?>
	
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
				<div class="comment-avatar">
					<?php echo get_avatar($comment, $size = '70'); ?>
				</div>
				<div class="comment-content">
					<div class="comment-meta clearfix">
						<span><?php echo esc_html__('author','exito'); ?></span>
						<span class="comment_author"><?php comment_author(); ?></span>
						<span><?php echo esc_html__('posted','exito'); ?></span>
						<span class="comment-date"><?php comment_date('F jS Y. g:i a'); ?></span>
						<?php comment_reply_link(array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="fa fa-reply"></i>' . esc_attr__('Reply', 'exito') ))); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'exito'),' ','' ); ?>
					</div>
					<div class="comment-text clearfix">
						<?php comment_text(); ?>
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'exito'); ?></em>
							<br>
						<?php endif; ?>
					</div>
				</div>
			</div>
	<?php
	}
}


//	Display navigation to next/previous set of posts when applicable.
if ( ! function_exists( 'exito_pagination' ) ) { 

	function exito_pagination( $pages = '' ) {
		
		global $wp_query, $wp_rewrite;
		
		$compile = '';
		
		$pages = ($pages) ? $pages : $wp_query->max_num_pages;

		// Don't print empty markup if there's only one page.
		if ( $pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );
	
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}
	
		$pagenum_link = esc_url ( remove_query_arg( array_keys( $query_args ), $pagenum_link ) );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	
		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
		
		$prev_arrow = 'fa fa-angle-left';
		$next_arrow = 'fa fa-angle-right';
		
		// Set up paginated links.
		$links = paginate_links( array(
			'base'     				=> $pagenum_link,
			'format'   				=> $format,
			'total'    				=> $pages,
			'current'  				=> $paged,
			'show_all' 				=> false,
			'mid_size' 				=> 2,
			'type' 					=> 'array',
			'add_args' 				=> array_map( 'urlencode', $query_args ),
			'prev_text' 			=> '<i class="'. $prev_arrow .'"></i>',
			'next_text' 			=> '<i class="'. $next_arrow .'"></i>',
		) );

		if ( !empty($links) ) {
			$compile .= '<div class="eva-pagination">';
			foreach( $links as $link ) {
				$compile .= $link;
			}
			$compile .= '</div>';
		}

		return $compile;
	}
}


/**
 *	Load More button
 */

if (!function_exists('exito_infinite_scroll')) {
	function exito_infinite_scroll( $pages = "" ) {
		
		global $paged, $exito_wp_query_in_shortcodes;
		
		$compile = '';

        if (empty($paged)) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        }
		$pages = intval($exito_wp_query_in_shortcodes->max_num_pages);
		if (empty($pages)) {
			$pages = 1;
		}
		if (1 != $pages) {
			$compile .= '<div class="text-center">';
				$compile .= '<div class="eva-infinite-scroll" data-has-next="' . ( $paged === $pages ? 'false' : 'true' ) . '">';
					$compile .= '<a class="btn btn-infinite-scroll no-more hide" href="#">' . esc_html__('No more posts', 'exito') . '</a>';
					$compile .= '<a class="btn btn-infinite-scroll loading" href="#"><i class="fa fa-refresh"></i></a>';
					$compile .= '<a class="btn btn-infinite-scroll next" href="' . get_pagenum_link( $paged + 1 ) . '">' . esc_html__('Load more posts', 'exito') . '</a>';
				$compile .= '</div>';
			$compile .= '</div>';
		}
		
		return $compile; 
	}
}



//	Post Likes
function exito_enqueue_script() {
	wp_enqueue_script('exito_ajaxurl', get_template_directory_uri() . '/assets/js/jquery.cookie.js', array('jquery'), false, true);
	wp_add_inline_script( 'exito_ajaxurl', 'var exito_ajaxurl = "' . admin_url("admin-ajax.php") . '";' );
}
add_action( 'wp_enqueue_scripts', 'exito_enqueue_script' );

function exito_likes() {
	
	wp_enqueue_script('exito_cookie', get_template_directory_uri() . '/assets/js/jquery.cookie.js', array('jquery'), false, true);
    $exito_all_likes = get_post_meta(get_the_ID(), 'exito_likes', true);
    if (!isset($exito_all_likes) || absint($exito_all_likes) < 1) {
        $exito_all_likes = 0;
    }
    echo '
    <span class="cstheme_likes ' . (isset($_COOKIE['like' . get_the_ID()]) ? "already_liked" : "exito_add_like") . '" data-postid="' . get_the_ID() . '">
        <i class="fa fa-heart-o"></i>
        <span class="likes_count">' . esc_html( $exito_all_likes ) . '</span>
    </span>
    ';
}

add_action('wp_ajax_add_like_post', 'exito_add_like_post');
add_action('wp_ajax_nopriv_add_like_post', 'exito_add_like_post');
function exito_add_like_post()
{
    $exito_post_id = absint($_POST['post_id']);
    $exito_all_likes = get_post_meta($exito_post_id, 'exito_likes', true);
    $exito_all_likes = (isset($exito_all_likes) ? $exito_all_likes : 0) + 1;
    update_post_meta($exito_post_id, 'exito_likes', $exito_all_likes);
    echo $exito_all_likes;
    die();
}



//	Posts per author posts page
add_filter( 'pre_option_posts_per_page', 'exito_author_posts_per_page' );
function exito_author_posts_per_page( $posts_per_page ) {
	global $wp_query;
	if ( is_author() ) {
		return 9;
	}
	
	if ( is_search() ) {
		return 500;
	} 

	return $posts_per_page;
}


//	Array of social profiles for team members
function exito_staff_social_array() {
	return apply_filters( 'exito_staff_social_array', array(
		'twitter'        => array (
			'key'        => 'twitter',
			'meta'       => 'exito_staff_twitter',
			'icon_class' => 'fa fa-twitter',
			'label'      => esc_attr__('Twitter', 'exito'),
		),
		'facebook'        => array (
			'key'        => 'facebook',
			'meta'       => 'exito_staff_facebook',
			'icon_class' => 'fa fa-facebook',
			'label'      => esc_attr__('Facebook', 'exito'),
		),
		'instagram'      => array (
			'key'        => 'instagram',
			'meta'       => 'exito_staff_instagram',
			'icon_class' => 'fa fa-instagram',
			'label'      => esc_attr__('Instagram', 'exito'),
		),
		'google-plus'    => array (
			'key'        => 'google-plus',
			'meta'       => 'exito_staff_google-plus',
			'icon_class' => 'fa fa-google-plus',
			'label'      => esc_attr__('Google Plus', 'exito'),
		),
		'linkedin'       => array (
			'key'        => 'linkedin',
			'meta'       => 'exito_staff_linkedin',
			'icon_class' => 'fa fa-linkedin',
			'label'      => esc_attr__('Linkedin', 'exito'),
		),
		'dribbble'       => array (
			'key'        => 'dribbble',
			'meta'       => 'exito_staff_dribbble',
			'icon_class' => 'fa fa-dribbble',
			'label'      => esc_attr__('Dribbble', 'exito'),
		),
		'vk'             => array (
			'key'        => 'vk',
			'meta'       => 'exito_staff_vk',
			'icon_class' => 'fa fa-vk',
			'label'      => esc_attr__('VK', 'exito'),
		),
		'skype'          => array (
			'key'        => 'skype',
			'meta'       => 'exito_staff_skype',
			'icon_class' => 'fa fa-skype',
			'label'      => esc_attr__('Skype', 'exito'),
		),
		'phone_number'   => array (
			'key'        => 'phone_number',
			'meta'       => 'exito_staff_phone_number',
			'icon_class' => 'fa fa-phone',
			'label'      => esc_attr__( 'Phone Number', 'exito' ),
		),
		'email'          => array (
			'key'        => 'email',
			'meta'       => 'exito_staff_email',
			'icon_class' => 'fa fa-envelope',
			'label'      => esc_attr__( 'Email', 'exito' ),
		),
		'website'        => array (
			'key'        => 'website',
			'meta'       => 'exito_staff_website',
			'icon_class' => 'fa fa-external-link-square',
			'label'      => esc_attr__( 'Website', 'exito' ),
		),
	) );
}

//	Creates an array for adding the team social options to the metaboxes
function exito_staff_social_meta_array() {
	$profiles = exito_staff_social_array();
	$array = array();
	foreach ( $profiles as $profile ) {
		$array[] = array(
				'title' => '<span class="'. $profile['icon_class'] .'"></span>' . $profile['label'],
				'id'    => $profile['meta'],
				'type'  => 'text',
				'std'   => '',
		);
	}
	return $array;
}


//	Portfolio Filter
if (!function_exists('exito_portfolio_filter')) {
    function exito_portfolio_filter($post_type_terms = "")
    {
        if (!isset($term_list)) {
            $term_list = '';
        }
        $permalink = get_permalink();
        $args = array('taxonomy' => 'Category', 'include' => $post_type_terms);
        $terms = get_terms('portfolio_category', $args);
        $count = count($terms);
        $i = 0;
        $iterm = 1;
		
		$compile = '';
		
        if ($count > 0) {
            $cape_list = '';
            if ($count > 1) {
                $term_list .= '<li class="' . (!isset($_GET['slug']) ? 'selected' : '') . '">';

                $args_for_count_all_terms = array(
                    'post_type' => 'portfolio',
                    'post_status' => 'publish'
                );
                $query_for_count_all_terms = new WP_Query($args_for_count_all_terms);

                $term_list .= '<a href="#filter" data-option-value="*" data-catname="all" data-title="' . $query_for_count_all_terms->post_count . '">' . esc_html__('All', 'exito') . '</a>
				</li>';
            }
            $termcount = count($terms);
            if (is_array($terms)) {
                foreach ($terms as $term) {

                    $args_for_count_all_terms = array(
                        'post_type' => 'portfolio',
                        'post_status' => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'id',
                                'terms' => $term->term_id
                            )
                        )
                    );
                    $query_for_count_all_terms = new WP_Query($args_for_count_all_terms);

                    $i++;
                    $permalink = esc_url(add_query_arg("slug", $term->term_id, $permalink));
                    $term_list .= '<li ';
                    if (isset($_GET['slug'])) {
                        $getslug = $_GET['slug'];
                    } else {
                        $getslug = '';
                    }

                    if (strnatcasecmp($getslug, $term->term_id) == 0) $term_list .= 'class="selected"';

                    $tempname = strtr($term->name, array(
                        ' ' => '-',
                    ));
                    $tempname = strtolower($tempname);
                    $term_list .= '><a data-option-value=".' . $tempname . '" data-catname="' . $tempname . '" href="#filter"  data-title="' . $query_for_count_all_terms->post_count . '">' . $term->name . '</a>
                </li>';
                    if ($count != $i) $term_list .= ' '; else $term_list .= '';

                    $iterm++;
                }
            }
            
			$compile .= '<div class="filter_block"><ul data-option-key="filter" class="optionset">' . $term_list . '</ul></div>';
			
			return $compile;
			
        }
    }
}