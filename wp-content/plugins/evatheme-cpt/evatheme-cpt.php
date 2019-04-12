<?php
/*
Plugin Name: 	Evatheme Custom Post Types
Plugin URI: 	http://www.evatheme.com
Description: 	Register Custom Post Types for Evathemes.
Version: 		1.0
Author: 		Evatheme
Author URI: 	http://www.evatheme.com
*/

if ( ! class_exists( 'evatheme_cpt' ) ) :

class evatheme_cpt {

	var $version = 1;
	
	//	Portfolio
	function __construct() {
		register_activation_hook( __FILE__, array( &$this, 'plugin_activation' ) );
		add_action( 'init', array( &$this, 'portfolio_init' ) );
		add_theme_support( 'post-thumbnails', array( 'portfolio' ) );
		add_filter( 'manage_edit-portfolio_columns', array( &$this, 'add_thumbnail_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( &$this, 'display_thumbnail' ), 10, 1 );
		add_action( 'restrict_manage_posts', array( &$this, 'add_taxonomy_filters' ) );
		add_action( 'right_now_content_table_end', array( &$this, 'add_portfolio_counts' ) );
	}

	function plugin_activation() {
		$this->portfolio_init();
		flush_rewrite_rules();
	}
	
	function portfolio_init() {
	
		$labels = array(
			'name' => esc_attr__( 'Portfolio', 'evatheme-cpt' ),
			'singular_name' => esc_attr_x( 'Portfolio Item', 'post type singular name', 'evatheme-cpt' ),
			'add_new' => esc_attr__( 'Add New Item', 'evatheme-cpt' ),
			'add_new_item' => esc_attr__( 'Add New Portfolio Item', 'evatheme-cpt' ),
			'edit_item' => esc_attr__( 'Edit Portfolio Item', 'evatheme-cpt' ),
			'new_item' => esc_attr__( 'Add New Portfolio Item', 'evatheme-cpt' ),
			'view_item' => esc_attr__( 'View Item', 'evatheme-cpt' ),
			'search_items' => esc_attr__( 'Search Portfolio', 'evatheme-cpt' ),
			'not_found' => esc_attr__( 'No portfolio items found', 'evatheme-cpt' ),
			'not_found_in_trash' => esc_attr__( 'No portfolio items found in trash', 'evatheme-cpt' )
		);
		
		$args = array(
	    	'labels' => $labels,
	    	'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'author' ),
			'capability_type' => 'post',
			'rewrite' => array("slug" => "portfolio"), 
			'menu_position' => 5,
			'menu_icon' => 'dashicons-portfolio',
			'has_archive' => true
		);
		
		$args = apply_filters('portfolioposttype_args', $args);
	
		register_post_type( 'portfolio', $args );
		
		$taxonomy_portfolio_tag_labels = array(
			'name' => esc_attr_x( 'Portfolio Tags', 'evatheme-cpt' ),
			'singular_name' => esc_attr_x( 'Portfolio Tag', 'evatheme-cpt' ),
			'search_items' => esc_attr_x( 'Search Portfolio Tags', 'evatheme-cpt' ),
			'popular_items' => esc_attr_x( 'Popular Portfolio Tags', 'evatheme-cpt' ),
			'all_items' => esc_attr_x( 'All Portfolio Tags', 'evatheme-cpt' ),
			'parent_item' => esc_attr_x( 'Parent Portfolio Tag', 'evatheme-cpt' ),
			'parent_item_colon' => esc_attr_x( 'Parent Portfolio Tag:', 'evatheme-cpt' ),
			'edit_item' => esc_attr_x( 'Edit Portfolio Tag', 'evatheme-cpt' ),
			'update_item' => esc_attr_x( 'Update Portfolio Tag', 'evatheme-cpt' ),
			'add_new_item' => esc_attr_x( 'Add New Portfolio Tag', 'evatheme-cpt' ),
			'new_item_name' => esc_attr_x( 'New Portfolio Tag Name', 'evatheme-cpt' ),
			'separate_items_with_commas' => esc_attr_x( 'Separate portfolio tags with commas', 'evatheme-cpt' ),
			'add_or_remove_items' => esc_attr_x( 'Add or remove portfolio tags', 'evatheme-cpt' ),
			'choose_from_most_used' => esc_attr_x( 'Choose from the most used portfolio tags', 'evatheme-cpt' ),
			'menu_name' => esc_attr_x( 'Portfolio Tags', 'evatheme-cpt' )
		);
		
		$taxonomy_portfolio_tag_args = array(
			'labels' => $taxonomy_portfolio_tag_labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => false,
			'rewrite' => array( 'slug' => 'portfolio_tag' ),
			'show_admin_column' => true,
			'query_var' => true
		);
		
		register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $taxonomy_portfolio_tag_args );
	
	    $taxonomy_portfolio_category_labels = array(
			'name' => esc_attr_x( 'Portfolio Categories', 'evatheme-cpt' ),
			'singular_name' => esc_attr_x( 'Portfolio Category', 'evatheme-cpt' ),
			'search_items' => esc_attr_x( 'Search Portfolio Categories', 'evatheme-cpt' ),
			'popular_items' => esc_attr_x( 'Popular Portfolio Categories', 'evatheme-cpt' ),
			'all_items' => esc_attr_x( 'All Portfolio Categories', 'evatheme-cpt' ),
			'parent_item' => esc_attr_x( 'Parent Portfolio Category', 'evatheme-cpt' ),
			'parent_item_colon' => esc_attr_x( 'Parent Portfolio Category:', 'evatheme-cpt' ),
			'edit_item' => esc_attr_x( 'Edit Portfolio Category', 'evatheme-cpt' ),
			'update_item' => esc_attr_x( 'Update Portfolio Category', 'evatheme-cpt' ),
			'add_new_item' => esc_attr_x( 'Add New Portfolio Category', 'evatheme-cpt' ),
			'new_item_name' => esc_attr_x( 'New Portfolio Category Name', 'evatheme-cpt' ),
			'separate_items_with_commas' => esc_attr_x( 'Separate portfolio categories with commas', 'evatheme-cpt' ),
			'add_or_remove_items' => esc_attr_x( 'Add or remove portfolio categories', 'evatheme-cpt' ),
			'choose_from_most_used' => esc_attr_x( 'Choose from the most used portfolio categories', 'evatheme-cpt' ),
			'menu_name' => esc_attr_x( 'Portfolio Categories', 'evatheme-cpt' ),
	    );
		
	    $taxonomy_portfolio_category_args = array(
			'labels' => $taxonomy_portfolio_category_labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'portfolio_category' ),
			'query_var' => true
	    );
		
	    register_taxonomy( 'portfolio_category', array( 'portfolio' ), $taxonomy_portfolio_category_args );
		
	}

	function add_thumbnail_column( $columns ) {
	
		$column_thumbnail = array( 'thumbnail' => esc_attr__( 'Thumbnail', 'evatheme-cpt' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
		return $columns;
	}
	
	function display_thumbnail( $column ) {
		global $post;
		switch ( $column ) {
			case 'thumbnail':
				echo get_the_post_thumbnail( $post->ID, array(60, 60) );
				break;
		}
	}
	 
	function add_taxonomy_filters() {
		global $typenow;
		$taxonomies = array( 'portfolio_category', 'portfolio_tag' );
		
		if ( $typenow == 'portfolio' ) {
			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}
	
	function add_portfolio_counts() {
		
	        if ( ! post_type_exists( 'portfolio' ) ) {
	             return;
	        }
	
	        $num_posts = wp_count_posts( 'portfolio' );
	        $num = number_format_i18n( $num_posts->publish );
	        $text = esc_attr_n( 'Portfolio Item', 'Portfolio Items', intval($num_posts->publish) );
	        if ( current_user_can( 'edit_posts' ) ) {
	            $num = "<a href='edit.php?post_type=portfolio'>$num</a>";
	            $text = "<a href='edit.php?post_type=portfolio'>$text</a>";
	        }
	        echo '<td class="first b b-portfolio">' . $num . '</td>';
	        echo '<td class="t portfolio">' . $text . '</td>';
	        echo '</tr>';
	
	        if ($num_posts->pending > 0) {
	            $num = number_format_i18n( $num_posts->pending );
	            $text = esc_attr_n( 'Portfolio Item Pending', 'Portfolio Items Pending', intval($num_posts->pending) );
	            if ( current_user_can( 'edit_posts' ) ) {
	                $num = "<a href='edit.php?post_status=pending&post_type=portfolio'>$num</a>";
	                $text = "<a href='edit.php?post_status=pending&post_type=portfolio'>$text</a>";
	            }
	            echo '<td class="first b b-portfolio">' . $num . '</td>';
	            echo '<td class="t portfolio">' . $text . '</td>';
	
	            echo '</tr>';
	        }
	}
	
}

new evatheme_cpt;

endif;

?>