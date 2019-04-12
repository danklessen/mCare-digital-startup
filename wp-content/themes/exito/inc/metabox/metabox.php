<?php
/**
 * Adds custom metaboxes to the WordPress categories
 * Developed & Designed exclusively for the Total WordPress theme
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('admin_print_scripts', 'exito_metabox_postsettings_admin_scripts');
if ( !function_exists('exito_metabox_postsettings_admin_scripts')) {
    function exito_metabox_postsettings_admin_scripts(){
        global $post, $pagenow;

        if (current_user_can('edit_posts') && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
            if( isset($post) ) {
                wp_localize_script( 'jquery', 'script_data', array(
                    'post_id' => $post->ID,
                    'nonce' => wp_create_nonce( 'exito-ajax' ),
                    'image_ids' => get_post_meta( $post->ID, 'gallery_image_ids', true ),
                    'label_create' => esc_html__("Create Featured Gallery", "exito"),
                    'label_edit' => esc_html__("Edit Featured Gallery", "exito"),
                    'label_save' => esc_html__("Save Featured Gallery", "exito"),
                    'label_saving' => esc_html__("Saving...", "exito")
                ));
            }
        }
    }
}

// The Metabox class
class exito_Post_Metaboxes {
	private $post_types;
	
	/**
	 * Register this class with the WordPress API
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Post types to add the metabox to
		$this->post_types = apply_filters( 'exito_main_metaboxes_post_types', array(
			'post' 			=> 'post',
			'page' 			=> 'page',
			'portfolio' 	=> 'portfolio',
			'product' 		=> 'product',
		) );

		// Add metabox to corresponding post types
		foreach( $this->post_types as $key => $val ) {
			add_action( 'add_meta_boxes_'. $val, array( $this, 'post_meta' ), 11 );
		}

		// Save meta
		add_action( 'save_post', array( $this, 'save_meta_data' ) );

		// Load scripts for the metabox
		add_action( 'admin_enqueue_scripts', array( $this, 'exito_metabox_admin_enqueue_scripts' ) );

		// Load custom css for metabox
		add_action( 'admin_print_styles-post.php', array( $this, 'exito_metaboxes_css' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'exito_metaboxes_css' ) );

		// Load custom js for metabox
		add_action( 'admin_footer-post.php', array( $this, 'exito_metaboxes_js' ) );
		add_action( 'admin_footer-post-new.php', array( $this, 'exito_metaboxes_js' ) );

	}

	/**
	 * The function responsible for creating the actual meta box.
	 *
	 * @since 1.0.0
	 */
	public function post_meta( $post ) {
		$obj = get_post_type_object( $post->post_type );
		add_meta_box(
			'exito-metabox',
			$obj->labels->singular_name . ' '. esc_html__( 'Settings', 'exito' ),
			array( $this, 'display_meta_box' ),
			$post->post_type,
			'normal',
			'high'
		);
	}

	/**
	 * Enqueue scripts and styles needed for the metaboxes
	 *
	 * @since 1.0.0
	 */
	public static function exito_metabox_admin_enqueue_scripts() {
		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	/**
	 * Renders the content of the meta box.
	 *
	 * @since 1.0.0
	 */
	public function display_meta_box( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'exito_metabox', 'exito_metabox_nonce' );

		// Get current post data
		$post_id   = $post->ID;
		$post_type = get_post_type();

		// Get tabs
		$tabs = $this->tabs_array();

		// Make sure tabs aren't empty
		if ( empty( $tabs ) ) {
			echo '<p>' . esc_html__('Hey your settings are empty, something is going on please contact your webmaster', 'exito') . '</p>';
			return;
		}

		// Store tabs that should display on this specific page in an array for use later
		$active_tabs = array();
		foreach ( $tabs as $tab ) {
			$tab_post_type = isset( $tab['post_type'] ) ? $tab['post_type'] : '';
			if ( ! $tab_post_type ) {
				$display_tab = true;
			} elseif ( in_array( $post_type, $tab_post_type ) ) {
				$display_tab = true;
			} else {
				$display_tab = false;
			}
			if ( $display_tab ) {
				$active_tabs[] = $tab;
			}
		} ?>

		<ul class="wp-tab-bar">
			<?php
			// Output tab links
			$exito_count = '';
			foreach ( $active_tabs as $tab ) {
				$exito_count++;
				$li_class = ( '1' == $exito_count ) ? ' class="wp-tab-active"' : '';
				// Define tab title
				$tab_title = $tab['title'] ? $tab['title'] : esc_html__( 'Other', 'exito' ); ?>
				<li<?php echo $li_class; ?>>
					<a href="javascript:;" data-tab="#exito-mb-tab-<?php echo $exito_count; ?>"><?php echo $tab_title; ?></a>
				</li>
			<?php } ?>
		</ul>

		<?php
		// Output tab sections
		$exito_count = '';
		foreach ( $active_tabs as $tab ) {
			$exito_count++; ?>
			<div id="exito-mb-tab-<?php echo $exito_count; ?>" class="wp-tab-panel clr">
				<table class="form-table">
					<?php
					// Loop through sections and store meta output
					foreach ( $tab['settings'] as $setting ) {

						// Vars
						$meta_id     = $setting['id'];
						$title       = $setting['title'];
						$hidden      = isset ( $setting['hidden'] ) ? $setting['hidden'] : false;
						$type        = isset ( $setting['type'] ) ? $setting['type'] : 'text';
						$default     = isset ( $setting['default'] ) ? $setting['default'] : '';
						$description = isset ( $setting['description'] ) ? $setting['description'] : '';
						$meta_value  = get_post_meta( $post_id, $meta_id, true );
						$meta_value  = $meta_value ? $meta_value : $default; ?>

						<tr<?php if ( $hidden ) echo ' style="display:none;"'; ?> id="<?php echo $meta_id; ?>_tr">
							<th>
								<label for="exito_main_layout"><strong><?php echo $title; ?></strong></label>
								<?php
								// Display field description
								if ( $description ) { ?>
									<p class="exito-mb-description"><?php echo $description; ?></p>
								<?php } ?>
							</th>

							<?php
							// Text Field
							if ( 'text' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo $meta_value; ?>"></td>

							<?php }

							// Number Field
							if ( 'number' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="number" value="<?php echo $meta_value; ?>"></td>

							<?php }

							// HTML Text
							if ( 'text_html' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo esc_html( $meta_value ); ?>"></td>

							<?php }

							// Link field
							elseif ( 'link' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo esc_url( $meta_value ); ?>"></td>

							<?php }

							// Textarea Field
							elseif ( 'textarea' == $type ) {
								$rows = isset ( $setting['rows'] ) ? $setting['rows'] : '4';?>

								<td>
									<textarea rows="<?php echo $rows; ?>" cols="1" name="<?php echo $meta_id; ?>" type="text" class="exito-mb-textarea"><?php echo $meta_value; ?></textarea>
								</td>

							<?php }

							// Code Field
							elseif ( 'code' == $type ) { ?>

								<td>
									<textarea rows="1" cols="1" name="<?php echo $meta_id; ?>" type="text" class="exito-mb-textarea-code"><?php echo $meta_value; ?></textarea>
								</td>

							<?php }

							// Checkbox
							elseif ( 'checkbox' == $type ) {

								$meta_value = ( 'on' == $meta_value ) ? false : true; ?>
								<td><input name="<?php echo $meta_id; ?>" type="checkbox" <?php checked( $meta_value, true, true ); ?>></td>

							<?php }

							// Select
							elseif ( 'select' == $type ) {

								$options = isset ( $setting['options'] ) ? $setting['options'] : '';
								if ( ! empty( $options ) ) { ?>
									<td><select id="<?php echo $meta_id; ?>" name="<?php echo $meta_id; ?>">
									<?php foreach ( $options as $option_value => $option_name ) { ?>
										<option value="<?php echo $option_value; ?>" <?php selected( $meta_value, $option_value, true ); ?>><?php echo $option_name; ?></option>
									<?php } ?>
									</select></td>
								<?php }

							}

							// Select
							elseif ( 'color' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo $meta_value; ?>" class="exito-mb-color-field"></td>

							<?php }

							// Media
							elseif ( 'media' == $type ) {

								// Validate data if array - old Redux cleanup
								if ( is_array( $meta_value ) ) {
									if ( ! empty( $meta_value['url'] ) ) {
										$meta_value = $meta_value['url'];
									} else {
										$meta_value = '';
									}
								} ?>
								<td>
									<div class="uploader">
									<input type="text" name="<?php echo $meta_id; ?>" value="<?php echo $meta_value; ?>">
									<input class="exito-mb-uploader button-secondary" name="<?php echo $meta_id; ?>" type="button" value="<?php esc_html_e( 'Upload', 'exito' ); ?>" />
									<?php if ( $meta_value ) {
											if ( is_numeric( $meta_value ) ) {
												$meta_value = wp_get_attachment_image_src( $meta_value, 'full' );
												$meta_value = $meta_value[0];
											} ?>
										<div class="exito-mb-thumb" style="padding-top:10px;"><img src="<?php echo $meta_value; ?>" height="40" width="" style="height:40px;width:auto;max-width:100%;" /></div>
									<?php } ?>
									</div>
								</td>

							<?php }
							
							//	Gallery
							elseif ( 'gallery' == $type ) {

								$gallery_thumbs = '';
								$button_text = ($meta_value) ? esc_html__('Edit Gallery', 'exito') : esc_html__('Upload Images', 'exito');
								
								// Validate data if array - old Redux cleanup
								if ( is_array( $meta_value ) ) {
									if ( ! empty( $meta_value['url'] ) ) {
										$meta_value = $meta_value['url'];
									} else {
										$meta_value = '';
									}
								}
								
								if( $meta_value ) {
									$thumbs = explode(',', $meta_value);
									foreach( $thumbs as $thumb ) {
										$gallery_thumbs .= '<li style="display:inline-block; vertica-align:top; margin-right:6px;">' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
									}
								} ?>
								
								<td>
									<input type="button" class="button" id="gallery_images_upload" value="<?php echo $button_text; ?>" />
									<input type="hidden" name="<?php echo $meta_id; ?>" id="gallery_image_ids" value="<?php echo $meta_value; ?>" />
									<ul class="gallery-thumbs" style="font-size:0;margin-top:6px;"><?php echo $gallery_thumbs;?></ul>
								</td>

							<?php }

							// Editor
							elseif ( 'editor' == $type ) {
								$teeny= isset( $setting['teeny'] ) ? $setting['teeny'] : false;
								$rows = isset( $setting['rows'] ) ? $setting['rows'] : '10';
								$media_buttons= isset( $setting['media_buttons'] ) ? $setting['media_buttons'] : true; ?>
								<td><?php wp_editor( $meta_value, $meta_id, array(
									'textarea_name' => $meta_id,
									'teeny' => $teeny,
									'textarea_rows' => $rows,
									'media_buttons' => $media_buttons,
								) ); ?></td>
							<?php } ?>
						</tr>

					<?php } ?>
				</table>
			</div>
		<?php } ?>

		<div class="exito-mb-reset">
			<a class="button button-secondary exito-reset-btn"><?php esc_html_e( 'Reset Settings', 'exito' ); ?></a>
			<div class="exito-reset-checkbox"><input type="checkbox" name="exito_metabox_reset"> <?php esc_html_e( 'Are you sure? Check this box, then update your post to reset all settings.', 'exito' ); ?></div>
		</div>

		<div class="clear"></div>

	<?php }

	/**
	 * Save metabox data
	 *
	 * @since 1.0.0
	 */
	public function save_meta_data( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['exito_metabox_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['exito_metabox_nonce'], 'exito_metabox' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. Now we can loop through fields */

		// Check reset field
		$reset = isset( $_POST['exito_metabox_reset'] ) ? $_POST['exito_metabox_reset'] : '';

		// Set settings array
		$tabs = $this->tabs_array();
		$settings = array();
		foreach( $tabs as $tab ) {
			foreach ( $tab['settings'] as $setting ) {
				$settings[] = $setting;
			}
		}

		// Loop through settings and validate
		foreach ( $settings as $setting ) {

			// Vars
			$value = '';
			$id    = $setting['id'];
			$type  = isset ( $setting['type'] ) ? $setting['type'] : 'text';

			// Make sure field exists and if so validate the data
			if ( isset( $_POST[$id] ) ) {

				// Validate text
				if ( 'text' == $type ) {
					$value = sanitize_text_field( $_POST[$id] );
				}

				// Validate textarea
				if ( 'textarea' == $type ) {
					$value = esc_html( $_POST[$id] );
				}

				// Links
				elseif ( 'link' == $type ) {
					$value = esc_url( $_POST[$id] );
				}

				// Validate select
				elseif ( 'select' == $type ) {
					if ( 'default' == $_POST[$id] ) {
						$value = '';
					} else {
						$value = $_POST[$id];
					}
				}

				// Validate media
				if ( 'media' == $type ) {

					// Sanitize
					$value = $_POST[$id];

					// Move old exito_post_self_hosted_shortcode_redux to exito_post_self_hosted_media
					if ( 'exito_post_self_hosted_media' == $id && empty( $_POST[$id] ) && $old = get_post_meta( $post_id, 'exito_post_self_hosted_shortcode_redux', true ) ) {
						$value = $old;
						delete_post_meta( $post_id, 'exito_post_self_hosted_shortcode_redux' );
					}

				}

				// All else
				else {
					$value = $_POST[$id];
				}

				// Update meta if value exists
				if ( $value && 'on' != $reset ) {
					update_post_meta( $post_id, $id, $value );
				}

				// Otherwise cleanup stuff
				else {
					delete_post_meta( $post_id, $id );
				}
			}

		}

	}

	/**
	 * Helpers
	 *
	 * @since 1.0.0
	 */
	public static function helpers( $return = NULl ) {


		// Return array of WP menus
		if ( 'menus' == $return ) {
			$menus = array( esc_html__( 'Default', 'exito' ) );
			$get_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
			foreach ( $get_menus as $menu) {
				$menus[$menu->term_id] = $menu->name;
			}
			return $menus;
		}

		// Widgets
		elseif ( 'widget_areas' == $return ) {
			global $wp_registered_sidebars;
			$get_widget_areas = $wp_registered_sidebars;
			if ( ! empty( $get_widget_areas ) ) {
				foreach ( $get_widget_areas as $widget_area ) {
					$name = isset ( $widget_area['name'] ) ? $widget_area['name'] : '';
					$id = isset ( $widget_area['id'] ) ? $widget_area['id'] : '';
					if ( $name && $id ) {
						$widgets_areas[$id] = $name;
					}
				}
			}
			return $widgets_areas;
		}

	}

	/**
	 * Settings Array
	 *
	 * @since 1.0.0
	 */
	public function tabs_array() {

		// Prefix
		$prefix = 'exito_';

		// Define variable
		$array = array();

		// Main Tab
		$array['main'] = array(
			'title' => esc_html__( 'Main', 'exito' ),
			'post_type' => array( 'page' ),
			'settings' => array(
				'page_layout' =>array(
					'title' => esc_html__( 'Page Layout', 'exito' ),
					'type' => 'select',
					'id' => $prefix . 'page_layout',
					'description' => esc_html__( 'Select the layout for this page.', 'exito' ),
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'full-width' => esc_html__( 'Full-Width', 'exito' ),
						'boxed' => esc_html__( 'Boxed', 'exito' ),
					),
				),
				'page_bg_color' => array(
					'title' 		=> esc_html__( 'Page Background Color', 'exito' ),
					'description' 	=> esc_html__( 'Select a color for page background.', 'exito' ),
					'id' 			=> $prefix .'page_bg_color',
					'type' 			=> 'color',
					'default' 		=> '',
				),
				'page_bg_image' => array(
					'title' => esc_html__( 'Page Background Image', 'exito'),
					'description' => esc_html__( 'Select a custom background image for your page.', 'exito' ),
					'id' => $prefix . 'page_bg_image',
					'type' => 'media',
				),
				'page_bg_repeat' => array(
					'title' 		=> esc_html__( 'Page Background Repeat', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'page_bg_repeat',
					'options' 		=> array(	
										''				=> esc_html__( 'Default', 'exito' ),
										'repeat'		=> esc_html__( 'Repeat', 'exito' ),
										'repeat-x'		=> esc_html__( 'Repeat-x', 'exito' ),
										'repeat-y'		=> esc_html__( 'Repeat-y', 'exito' ),
										'no-repeat' 	=> esc_html__( 'No Repeat',  'exito' )
									),
					'default' 		=> '',
				),
				'page_bg_attachment' => array(
					'title' 		=> esc_html__( 'Page Background Attachment', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'page_bg_attachment',
					'options' 		=> array(	
										''			=> esc_html__( 'Default', 'exito' ),
										'scroll'	=> esc_html__( 'Scroll', 'exito' ),
										'fixed'		=> esc_html__( 'Fixed', 'exito' )
									),
					'default' 		=> '',
				),
				'page_bg_position' => array(
					'title' 		=> esc_html__( 'Page Background Position', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'page_bg_position',
					'options' 		=> array(	
										'' 				=> esc_html__( 'Default', 'exito' ),
										'left top' 		=> esc_html__( 'Left Top', 'exito' ),
										'left center' 	=> esc_html__( 'Left Center', 'exito' ),
										'left bottom' 	=> esc_html__( 'Left Bottom', 'exito' ),
										'center top' 	=> esc_html__( 'Center Top', 'exito' ),
										'center center' => esc_html__( 'Center Center', 'exito' ),
										'center bottom' => esc_html__( 'Center Bottom', 'exito' ),
										'right top' 	=> esc_html__( 'Right Top', 'exito' ),
										'right center' 	=> esc_html__( 'Right Center', 'exito' ),
										'right bottom' 	=> esc_html__( 'Right Bottom', 'exito' )
									),
					'default' 		=> '',
				),
				'page_bg_full' => array(
					'title' 		=> esc_html__( 'Page Background Size', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'page_bg_full',
					'options' 		=> array(	
										'' 				=> esc_html__( 'Default', 'exito' ),
										'inherit' 		=> esc_html__( 'Inherit', 'exito' ),
										'cover' 		=> esc_html__( 'Cover', 'exito' )
									),
					'default' 		=> '',
				),
			),
		);

		// Header Tab
		$array['header'] = array(
			'title' => esc_html__( 'Header', 'exito' ),
			'post_type' => array( 'page' ),
			'settings' => array(
				'disable_header' => array(
					'title' => esc_html__( 'Header', 'exito' ),
					'id' => $prefix . 'disable_header',
					'type' => 'select',
					'description' => esc_html__( 'Enable or disable this element on this page or post.', 'exito' ),
					'options' => array(
						'enable' => esc_html__( 'Enable', 'exito' ),
						'disable' => esc_html__( 'Disable', 'exito' ),
					),
				),
				'header_layout' => array(
					'title' => esc_html__( 'Header Layout', 'exito' ),
					'id' => $prefix . 'header_layout',
					'type' => 'select',
					'description' => esc_html__( 'You can choose between a header full width style menu or a boxed style menu.', 'exito' ),
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'full_width' => esc_html__( 'Full Width', 'exito' ),
						'boxed' => esc_html__( 'Boxed', 'exito' )
					),
					'default' => '',
				),
				'header_page_bg_style' => array(
					'title' => esc_html__( 'Header Background Style', 'exito' ),
					'id' => $prefix . 'header_page_bg_style',
					'type' => 'select',
					'description' => esc_html__( 'Select a background style for this header. settings of background color, transparency or settings of gradient will be taken from the Theme Options.', 'exito' ),
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'gradient' => esc_html__( 'Gradient', 'exito' ),
						'bgcolor' => esc_html__( 'Background Color', 'exito' ),
					),
					'default' => '',
				),
			),
		);

		// Title Tab
		$array['title'] = array(
			'title' => esc_html__( 'Title', 'exito' ),
			'post_type' => array( 'page' ),
			'settings' => array(
				'pagetitle' => array(
					'title' => esc_html__( 'Title', 'exito' ),
					'description' => esc_html__( 'Enable or disable title on this page or post.', 'exito' ),
					'id' => $prefix . 'pagetitle',
					'type' => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'show' => esc_html__( 'Show', 'exito' ),
						'hide' => esc_html__( 'Hide', 'exito' ),
					),
					'default' => '',
				),
				'pagetitle_text' => array(
					'title' => esc_html__( 'Page Title', 'exito' ),
					'description' => esc_html__( 'Please enter the page title.', 'exito' ),
					'type' => 'text',
					'id' => $prefix . 'pagetitle_text',
				),
				'pagetitle_subtext' => array(
					'title' => esc_html__( 'Subheading', 'exito' ),
					'description' => esc_html__( 'Enter your page subheading.', 'exito' ),
					'type' => 'text',
					'id' => $prefix . 'pagetitle_subtext',
				),
				'pagetitle_style' => array(
					'title' => esc_html__( 'Title Style', 'exito' ),
					'description' => esc_html__( 'Select a custom title style for this page or post.', 'exito' ),
					'type' => 'select',
					'id' => $prefix . 'pagetitle_style',
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'background-image' => esc_html__( 'Background Image', 'exito' ),
					),
				),
				'pagetitle_bg_color' => array(
					'title' 		=> esc_html__( 'Page Title Background Color', 'exito' ),
					'description' 	=> esc_html__( 'Select a color.', 'exito' ),
					'id' 			=> $prefix .'pagetitle_bg_color',
					'type' 			=> 'color',
					'default' 		=> '#696969',
				),
				'pagetitle_bg_image' => array(
					'title' => esc_html__( 'Page Title Background Image', 'exito'),
					'description' => esc_html__( 'Select a custom header image for your main title.', 'exito' ),
					'id' => $prefix . 'pagetitle_bg_image',
					'type' => 'media',
				),
				'pagetitle_bg_repeat' => array(
					'title' 		=> esc_html__( 'Page Title Background Repeat', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'pagetitle_bg_repeat',
					'options' 		=> array(	
										'repeat'		=> esc_html__( 'Repeat', 'exito' ),
										'repeat-x'		=> esc_html__( 'Repeat-x', 'exito' ),
										'repeat-y'		=> esc_html__( 'Repeat-y', 'exito' ),
										'no-repeat' 	=> esc_html__( 'No Repeat',  'exito' )
									),
					'default' 		=> 'no-repeat',
				),
				'pagetitle_bg_attachment' => array(
					'title' 		=> esc_html__( 'Page Title Background Attachment', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'pagetitle_bg_attachment',
					'options' 		=> array(	
										'scroll'	=> esc_html__( 'Scroll', 'exito' ),
										'fixed'		=> esc_html__( 'Fixed', 'exito' )
									),
					'default' 		=> 'scroll',
				),
				'pagetitle_bg_position' => array(
					'title' 		=> esc_html__( 'Page Title Background Position', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'pagetitle_bg_position',
					'options' 		=> array(	
										'left top' 		=> esc_html__( 'Left Top', 'exito' ),
										'left center' 	=> esc_html__( 'Left Center', 'exito' ),
										'left bottom' 	=> esc_html__( 'Left Bottom', 'exito' ),
										'center top' 	=> esc_html__( 'Center Top', 'exito' ),
										'center center' => esc_html__( 'Center Center', 'exito' ),
										'center bottom' => esc_html__( 'Center Bottom', 'exito' ),
										'right top' 	=> esc_html__( 'Right Top', 'exito' ),
										'right center' 	=> esc_html__( 'Right Center', 'exito' ),
										'right bottom' 	=> esc_html__( 'Right Bottom', 'exito' )
									),
					'default' 		=> 'center center',
				),
				'pagetitle_bg_full' => array(
					'title' 		=> esc_html__( 'Page Title Background Size', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'pagetitle_bg_full',
					'options' 		=> array(	
										'inherit' 		=> esc_html__( 'Inherit', 'exito' ),
										'cover' 		=> esc_html__( 'Cover', 'exito' )
									),
					'default' 		=> 'cover',
				),
				'pagetitle_bg_image_parallax' => array(
					'title' 		=> esc_html__( 'Parallax Effect', 'exito' ),
					'description' 	=> esc_html__( 'Enable this to the parallax effect for background image.', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'pagetitle_bg_image_parallax',
					'options' 		=> array(	
										''		 		=> esc_html__( 'Default', 'exito' ),
										'disable' 		=> esc_html__( 'Disable', 'exito' ),
										'enable' 		=> esc_html__( 'Enable', 'exito' )
									),
					'default' 		=> '',
				),
				'pagetitle_text_color' => array(
					'title' 		=> esc_html__( 'Page Title Text Color', 'exito' ),
					'description' 	=> esc_html__( 'Select a text color.', 'exito' ),
					'id' 			=> $prefix .'pagetitle_text_color',
					'type' 			=> 'color',
					'default' 		=> '#ffffff',
				),
				
				'breadcrumbs' => array(
					'title' => esc_html__( 'Breadcrumbs', 'exito' ),
					'description' => esc_html__( 'Enable or disable breadcrumbs on this page or post.', 'exito' ),
					'id' => $prefix . 'breadcrumbs',
					'type' => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'show' => esc_html__( 'Show', 'exito' ),
						'hide' => esc_html__( 'Hide', 'exito' ),
					),
					'default' => '',
				),
			),
		);
		

		// Footer tab
		$array['footer'] = array(
			'title' => esc_html__( 'Footer', 'exito' ),
			'post_type' => array( 'page' ),
			'settings' => array(
				'enable_prefooter' => array(
					'title' => esc_html__( 'Prefooter Area', 'exito' ),
					'description' => esc_html__( 'Show or hide prefooter area.', 'exito' ),
					'id' => $prefix . 'enable_prefooter',
					'type' => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'show' => esc_html__( 'Show', 'exito' ),
						'hide' => esc_html__( 'Hide', 'exito' ),
					),
					'default' => '',
				),
				'footer' => array(
					'title' => esc_html__( 'Footer Area', 'exito' ),
					'description' => esc_html__( 'Show or hide Footer Area.', 'exito' ),
					'id' => $prefix . 'footer',
					'type' => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'show' => esc_html__( 'Show', 'exito' ),
						'hide' => esc_html__( 'Hide', 'exito' ),
					),
					'default' => '',
				),
				'footer_layout' => array(
					'title' => esc_html__( 'Footer Layout', 'exito' ),
					'id' => $prefix . 'footer_layout',
					'type' => 'select',
					'description' => esc_html__( 'You can choose between a full width style or a boxed style footer.', 'exito' ),
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'full_width' => esc_html__( 'Full Width', 'exito' ),
						'boxed' => esc_html__( 'Boxed', 'exito' )
					),
					'default' => '',
				),
			),
		);

		// Post tab
		$array['media'] = array(
			'title' => esc_html__( 'Post', 'exito' ),
			'post_type' => array( 'post' ),
			'settings' => array(
				'metro' => array(
					'title' => esc_html__( 'Masonry Item Sizing', 'exito' ),
					'description' => esc_html__( 'This will only be used if you choose to display your Blog Posts in the "Metro Style" in element settings', 'exito' ),
					'id' => $prefix . 'metro',
					'type' => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'width2' => esc_html__( 'Double Width', 'exito' ),
						'height2' => esc_html__( 'Double Height', 'exito' ),
						'wh2' => esc_html__( 'Double Width and Height', 'exito' ),
					),
					'default' => '',
				),
				'post_single_style' => array(
					'title' => esc_html__( 'Featured Image Style', 'exito' ),
					'description' => esc_html__( 'Select the style of a single post page. featured image in full screen or standard', 'exito' ),
					'id' => $prefix . 'post_single_style',
					'type' => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'exito' ),
						'fullscreen' => esc_html__( 'Full screen', 'exito' ),
					),
				),
				'post_quote_text' => array(
					'title' => esc_html__( 'Quote', 'exito' ),
					'description' => esc_html__( 'Write your quote in this field. Will show only for Quote Post Format.', 'exito' ),
					'id' => $prefix . 'post_quote_text',
					'type' => 'textarea',
					'rows' => '2',
				),
				'post_quote_author' => array(
					'title' => esc_html__( 'Quote Author', 'exito' ),
					'description' => esc_html__( 'Write your quote author in this field. Will show only for Quote Post Format.', 'exito' ),
					'id' => $prefix . 'post_quote_author',
					'type' => 'text',
				),
				'post_quote_author_position' => array(
					'title' => esc_html__( 'Quote Author Position', 'exito' ),
					'description' => esc_html__( 'Write your quote author position in this field. Will show only for Quote Post Format.', 'exito' ),
					'id' => $prefix . 'post_quote_author_position',
					'type' => 'text',
				),
				'post_link' => array(
					'title' => esc_html__( 'Link', 'exito' ),
					'description' => esc_html__( 'Write your link in this field. Will show only for Link Post Format.', 'exito' ),
					'id' => $prefix . 'post_link',
					'type' => 'text',
				),
				'post_gallery' => array(
					'title' => esc_html__( 'Gallery', 'exito' ),
					'description' => esc_html__( 'Select the images that should be upload to this gallery. Will show only for Gallery Post Format.', 'exito' ),
					'id' => 'gallery_image_ids',
					'type' => 'gallery',
				),
				'post_video_embed' => array(
					'title' => esc_html__( 'Video Embed Code', 'exito' ),
					'description' => esc_html__( 'Insert Youtube or Vimeo embed code. Videos will show only for Video Post Format.', 'exito' ),
					'id' => $prefix . 'post_video_embed',
					'type' => 'textarea',
					'rows' => '2',
				),
				'post_audio_embed' => array(
					'title' => esc_html__( 'Audio Embed Code', 'exito' ),
					'description' => esc_html__( 'Insert audio embed code. Audios will show only for Audio Post Format.', 'exito' ),
					'id' => $prefix . 'post_audio_embed',
					'type' => 'textarea',
					'rows' => '2',
				),
			),
		);


		// Portfolio Tab
		if ( class_exists( 'evatheme_cpt' ) ) {
			$obj= get_post_type_object( 'portfolio' );
			$tab_title = $obj->labels->singular_name;
			$array['portfolio'] = array(
				'title' => $tab_title,
				'post_type' => array( 'portfolio' ),
				'settings' => array(
					'portfolio_single_layout' => array(
						'title' => esc_html__( 'Layout', 'exito' ),
						'description' => esc_html__( 'Select page layout for single portfolio', 'exito' ),
						'id' => $prefix . 'portfolio_single_layout',
						'type' => 'select',
						'options' => array(
							'full_width' => esc_html__( 'Full width (Description on top, images bottom)', 'exito' ),
							'half_width' => esc_html__( 'Half width (Description right, images left)', 'exito' ),
						),
					),
					'portfolio_single_client' => array(
						'title' => esc_html__( 'Client', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_client',
						'type' => 'text',
					),
					'portfolio_single_add_field_title' => array(
						'title' => esc_html__( 'Additional Field Title', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_add_field_title',
						'type' => 'text',
					),
					'portfolio_single_add_field' => array(
						'title' => esc_html__( 'Additional Field', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_add_field',
						'type' => 'text',
					),
					'portfolio_single_add_field_title2' => array(
						'title' => esc_html__( 'Additional Field Title 2', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_add_field_title2',
						'type' => 'text',
					),
					'portfolio_single_add_field2' => array(
						'title' => esc_html__( 'Additional Field 2', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_add_field2',
						'type' => 'text',
					),
					'portfolio_single_add_field_title3' => array(
						'title' => esc_html__( 'Additional Field Title 3', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_add_field_title3',
						'type' => 'text',
					),
					'portfolio_single_add_field3' => array(
						'title' => esc_html__( 'Additional Field 3', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_add_field3',
						'type' => 'text',
					),
					'portfolio_single_link' => array(
						'title' => esc_html__( 'Link', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_link',
						'type' => 'text',
					),
					'portfolio_single_link_name' => array(
						'title' => esc_html__( 'Link Name', 'exito' ),
						'description' => '',
						'id' => $prefix . 'portfolio_single_link_name',
						'type' => 'text',
					),
					'posrtfolio_single_iframe' => array(
						'title' => esc_html__( 'Embed Code', 'exito' ),
						'description' => esc_html__( 'Insert your embed/iframe code.', 'exito' ),
						'id' => $prefix . 'posrtfolio_single_iframe',
						'type' => 'textarea',
						'rows' => '2',
					),
					'portfolio_single_gallery' => array(
						'title' => esc_html__( 'Gallery', 'exito' ),
						'description' => esc_html__( 'Select the images that should be upload to this gallery. Will show only for Gallery Post Format.', 'exito' ),
						'id' => 'gallery_image_ids',
						'type' => 'gallery',
					),
					'portfolio_single_carousel_enable' => array(
						'title' => esc_html__( 'Gallery Carousel', 'exito' ),
						'description' => esc_html__( 'Enable this to show images in carousel.', 'exito' ),
						'id' => $prefix . 'portfolio_single_carousel_enable',
						'type' => 'select',
						'options' => array(
							'enable' => esc_html__( 'Enable', 'exito' ),
							'disable' => esc_html__( 'Disable', 'exito' ),
						),
					),
					'portfolio_single_carousel_layout' => array(
						'title' => esc_html__( 'Gallery Layout', 'exito' ),
						'description' => esc_html__( 'Enable this to show full width carousel. Only for "Full Width Layout"', 'exito' ),
						'id' => $prefix . 'portfolio_single_carousel_layout',
						'type' => 'select',
						'options' => array(
							'boxed' => esc_html__( 'Boxed', 'exito' ),
							'full_width' => esc_html__( 'Full_width', 'exito' ),
						),
					),
					'portfolio_single_grid_pullleft' => array(
						'title' => esc_html__( 'Images Position', 'exito' ),
						'description' => esc_html__( 'Enable the option to press all of the images to the left side of the monitor. Only for "Gallery Carousel -> Disable"', 'exito' ),
						'id' => $prefix . 'portfolio_single_grid_pullleft',
						'type' => 'select',
						'options' => array(
							'disable' => esc_html__( 'Disable', 'exito' ),
							'enable' => esc_html__( 'Enable', 'exito' ),
						),
					),
				),
			);
		}
		
		
		//	Coming Soon Tab
		$exito_comings_soon_years = array('2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020');
		$exito_comings_soon_months = array(
			'01'=>esc_html__('January','exito'),'02'=>esc_html__('February','exito'),'03'=>esc_html__('March','exito'),
			'04'=>esc_html__('April','exito'),'05'=>esc_html__('May','exito'),'06'=>esc_html__('June','exito'),
			'07'=>esc_html__('July','exito'),'08'=>esc_html__('August','exito'),'09'=>esc_html__('Septempber','exito'),
			'10'=>esc_html__('October','exito'),'11'=>esc_html__('November','exito'),'12'=>esc_html__('December','exito'));
		$exito_comings_soon_days = array(
			'01' => '1','02' => '2','03' => '3','04' => '4','05' => '5',
			'06' => '6','07' => '7','08' => '8','09' => '9','10' => '10',
			'11' => '11','12' => '12','13' => '13','14' => '14','15' => '15',
			'16' => '16','17' => '17','18' => '18','19' => '19','20' => '20',
			'21' => '21','22' => '22','23' => '23','24' => '24','25' => '25',
			'26' => '26','27' => '27','28' => '28','29' => '29','30' => '30','31' => '31',
		);
		
		$array['coming_soon'] = array(
			'title' => esc_html__( 'Coming Soon', 'exito' ),
			'post_type' => array( 'page' ),
			'settings' => array(
				'coming_soon_years' => array(
					'title' => esc_html__( 'Years', 'exito' ),
					'description' => '',
					'id' => $prefix . 'comings_soon_years',
					'type' => 'select',
					'options' => $exito_comings_soon_years,
					'default' => '2020',
				),
				'coming_soon_months' => array(
					'title' => esc_html__( 'Months', 'exito' ),
					'description' => '',
					'id' => $prefix . 'comings_soon_months',
					'type' => 'select',
					'options' => $exito_comings_soon_months,
					'default' => '01',
				),
				'coming_soon_days' => array(
					'title' => esc_html__( 'Days', 'exito' ),
					'description' => '',
					'id' => $prefix . 'comings_soon_days',
					'type' => 'select',
					'options' => $exito_comings_soon_days,
					'default' => '01',
				),
				'coming_soon_subtitle' => array(
					'title' => esc_html__( 'Subtitle', 'exito' ),
					'description' => '',
					'id' => $prefix . 'coming_soon_subtitle',
					'type' => 'text',
					'default' => 'The site is under construction',
				),
				'coming_soon_title' => array(
					'title' => esc_html__( 'Title', 'exito' ),
					'description' => '',
					'id' => $prefix . 'coming_soon_title',
					'type' => 'text',
					'default' => 'Coming Soon',
				),
				'coming_soon_descr' => array(
					'title' => esc_html__( 'Description', 'exito' ),
					'description' => '',
					'id' => $prefix . 'coming_soon_descr',
					'type' => 'text',
					'default' => 'If you have any questions please contact us by e-mail:',
				),
				'coming_soon_email' => array(
					'title' => esc_html__( 'E-mail', 'exito' ),
					'description' => '',
					'id' => $prefix . 'coming_soon_email',
					'type' => 'text',
					'default' => 'info@evatheme.com',
				),
				'coming_soon_bg_color' => array(
					'title' 		=> esc_html__( 'Background Color', 'exito' ),
					'description' 	=> '',
					'id' 			=> $prefix .'coming_soon_bg_color',
					'type' 			=> 'color',
					'default' 		=> '#4c4e50',
				),
				'coming_soon_bg_image' => array(
					'title' => esc_html__( 'Background Image', 'exito'),
					'description' => '',
					'id' => $prefix . 'coming_soon_bg_image',
					'type' => 'media',
				),
				'coming_soon_bg_repeat' => array(
					'title' 		=> esc_html__( 'Background Repeat', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'coming_soon_bg_repeat',
					'options' 		=> array(	
										'repeat'		=> esc_html__( 'Repeat', 'exito' ),
										'repeat-x'		=> esc_html__( 'Repeat-x', 'exito' ),
										'repeat-y'		=> esc_html__( 'Repeat-y', 'exito' ),
										'no-repeat' 	=> esc_html__( 'No Repeat',  'exito' )
									),
					'default' 		=> 'no-repeat',
				),
				'coming_soon_bg_attachment' => array(
					'title' 		=> esc_html__( 'Background Attachment', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'coming_soon_bg_attachment',
					'options' 		=> array(	
										'scroll'	=> esc_html__( 'Scroll', 'exito' ),
										'fixed'		=> esc_html__( 'Fixed', 'exito' )
									),
					'default' 		=> 'scroll',
				),
				'coming_soon_bg_position' => array(
					'title' 		=> esc_html__( 'Background Position', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'coming_soon_bg_position',
					'options' 		=> array(	
										'left top' 		=> esc_html__( 'Left Top', 'exito' ),
										'left center' 	=> esc_html__( 'Left Center', 'exito' ),
										'left bottom' 	=> esc_html__( 'Left Bottom', 'exito' ),
										'center top' 	=> esc_html__( 'Center Top', 'exito' ),
										'center center' => esc_html__( 'Center Center', 'exito' ),
										'center bottom' => esc_html__( 'Center Bottom', 'exito' ),
										'right top' 	=> esc_html__( 'Right Top', 'exito' ),
										'right center' 	=> esc_html__( 'Right Center', 'exito' ),
										'right bottom' 	=> esc_html__( 'Right Bottom', 'exito' )
									),
					'default' 		=> 'center center',
				),
				'coming_soon_bg_full' => array(
					'title' 		=> esc_html__( 'Background Size', 'exito' ),
					'type' 			=> 'select',
					'id' 			=> $prefix . 'coming_soon_bg_full',
					'options' 		=> array(	
										'inherit' 		=> esc_html__( 'Inherit', 'exito' ),
										'cover' 		=> esc_html__( 'Cover', 'exito' )
									),
					'default' 		=> 'cover',
				),
			),
		);
		
		
		//	WooCommerce
		$array['product'] = array(
			'title'    	=> esc_html__( 'Product Video', 'exito' ),
			'post_type' => array( 'product' ),
			'settings' 	=> array(
				'product_video_url' => array(
					'title' => esc_html__( 'Video URL', 'exito' ),
					'description' => esc_html__( 'Enter URL of Youtube or Vimeo or specific filetypes such as mp4, m4v, webm, ogv, wmv, flv.', 'exito' ),
					'id' => $prefix . 'product_video_url',
					'type' => 'text',
					'default' => false,
				),
				'product_video_thumbnail' => array(
					'title' => esc_html__( 'Video Thumbnail', 'exito' ),
					'description' => esc_html__( 'Add video thumbnail', 'exito' ),
					'id' => $prefix . 'product_video_thumbnail',
					'type' => 'media',
					'default' => false,
				),
			),
		);


		// Apply filter & return settings array
		return apply_filters( 'exito_metabox_array', $array );
	}

	/**
	 * Adds custom CSS for the metaboxes inline instead of loading another stylesheet
	 *
	 * @see assets/metabox.css
	 * @since 1.0.0
	 */
	public static function exito_metaboxes_css() { ?>

		<style type="text/css">
			#exito-metabox .wp-tab-panel{display:none;}#exito-metabox .wp-tab-panel#exito-mb-tab-1{display:block;}#exito-metabox .wp-tab-panel{max-height:none !important;}#exito-metabox ul.wp-tab-bar{-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}#exito-metabox ul.wp-tab-bar{padding-top:5px;}#exito-metabox ul.wp-tab-bar:after{content:"";display:block;height:0;clear:both;visibility:hidden;zoom:1;}#exito-metabox ul.wp-tab-bar li{padding:5px 12px;font-size:14px;}#exito-metabox ul.wp-tab-bar li a:focus{box-shadow:none;}#exito-metabox .inside .form-table tr{border-top:1px solid #dfdfdf;}#exito-metabox .inside .form-table tr:first-child{border:none;}#exito-metabox .inside .form-table th{width:240px;padding:10px 30px 10px 0;}#exito-metabox .inside .form-table td{padding:10px 0;}#exito-metabox .inside .form-table label{display:block;}#exito-metabox .inside .form-table th label span{margin-right:7px;}#exito-metabox .exito-mb-uploader{margin-left:5px;}#exito-metabox .inside .form-table th p.exito-mb-description{font-size:12px;font-weight:normal;margin:0;padding:0;padding-top:4px;}#exito-metabox .inside .form-table input[type="text"],#exito-metabox .inside .form-table input[type="number"],#exito-metabox .inside .form-table .exito-mb-textarea-code{width:40%;}#exito-metabox .inside .form-table textarea{width:100%}#exito-metabox .inside .form-table select{min-width:40%;}#exito-metabox .exito-mb-reset{margin-top:7px;}#exito-metabox .exito-mb-reset .exito-reset-btn{display:block;float:left;}#exito-metabox .exito-mb-reset .exito-reset-checkbox{float:left;display:none;margin-left:10px;padding-top:5px;}
		</style>

	<?php

	}

	/**
	 * Adds custom js for the metaboxes inline instead of loading another js file
	 *
	 * @see assets/metabox.js
	 * @since 1.0.0
	 */
	public static function exito_metaboxes_js() { ?>

		<script type="text/javascript">
			!function(e){"use strict";e(document).on("ready",function(){e("div#exito-metabox ul.wp-tab-bar a").click(function(){var t=e("#exito-metabox ul.wp-tab-bar li"),a=e(this).data("tab"),o=e("#exito-metabox div.wp-tab-panel");return e(t).removeClass("wp-tab-active"),e(o).hide(),e(a).show(),e(this).parent("li").addClass("wp-tab-active"),!1}),e("div#exito-metabox .exito-mb-color-field").wpColorPicker();var t=!0,a=wp.media.editor.send.attachment;e("div#exito-metabox .exito-mb-uploader").click(function(){var o=(wp.media.editor.send.attachment,e(this)),i=o.prev();return wp.media.editor.send.attachment=function(o,r){return t?void e(i).val(r.id):a.apply(this,[o,r])},wp.media.editor.open(o),!1}),e("div#exito-metabox .add_media").on("click",function(){t=!1}),e("div#exito-metabox div.exito-mb-reset a.exito-reset-btn").click(function(){var t=e("div.exito-mb-reset div.exito-reset-checkbox"),a=t.is(":visible")?"<?php echo esc_html__( 'Reset Settings', 'exito' ); ?>":"<?php echo esc_html__(  'Cancel Reset', 'exito' ); ?>";e(this).text(a),e("div.exito-mb-reset div.exito-reset-checkbox input").attr("checked",!1),t.toggle()});})}(jQuery);
			
			/* Gallery */
			jQuery(function(){
				var frame;
				var images = script_data.image_ids;
				var selection = loadImages(images);

				jQuery('#gallery_images_upload').on('click', function(e) {
					e.preventDefault();

					// Set options for 1st frame render
					var options = {
						title: script_data.label_create,
						state: 'gallery-edit',
						frame: 'post',
						selection: selection
					};

					// Check if frame or gallery already exist
					if( frame || selection ) {
						options['title'] = script_data.label_edit;
					}

					frame = wp.media(options).open();

					// Tweak views
					frame.menu.get('view').unset('cancel');
					frame.menu.get('view').unset('separateCancel');
					frame.menu.get('view').get('gallery-edit').el.innerHTML = script_data.label_edit;
					frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

					// When we are editing a gallery
					overrideGalleryInsert();
					frame.on( 'toolbar:render:gallery-edit', function() {
						overrideGalleryInsert();
					});

					frame.on( 'content:render:browse', function( browser ) {
						if ( !browser ) return;
						// Hide Gallery Setting in sidebar
						browser.sidebar.on('ready', function(){
							browser.sidebar.unset('gallery');
						});
						// Hide filter/search as they don't work 
						browser.toolbar.on('ready', function(){ 
							if(browser.toolbar.controller._state == 'gallery-library'){ 
								browser.toolbar.$el.hide(); 
							} 
						}); 
					});

					// All images removed
					frame.state().get('library').on( 'remove', function() {
						var models = frame.state().get('library');
						if(models.length == 0){
							selection = false;
							jQuery.post(ajaxurl, { 
								ids: '',
								action: 'exito_save_images',
								post_id: script_data.post_id,
								nonce: script_data.nonce 
							});
						}
					});

					// Override insert button
					function overrideGalleryInsert() {
						frame.toolbar.get('view').set({
							insert: {
								style: 'primary',
								text: script_data.label_save,

								click: function() {                                            
									var models = frame.state().get('library'),
										ids = '';

									models.each( function( attachment ) {
										ids += attachment.id + ','
									});

									this.el.innerHTML = script_data.label_saving;
									
									jQuery.ajax({
										type: 'POST',
										url: ajaxurl,
										data: { 
											ids: ids, 
											action: 'exito_save_images', 
											post_id: script_data.post_id, 
											nonce: script_data.nonce 
										},
										success: function(){
											selection = loadImages(ids);
											jQuery('#gallery_image_ids').val( ids );
											frame.close();
										},
										dataType: 'html'
									}).done( function( data ) {
										jQuery('.gallery-thumbs').html( data );
									}); 
								}
							}
						});
					}
				});

				// Load images
				function loadImages(images) {
					if( images ){
						var shortcode = new wp.shortcode({
							tag:    'gallery',
							attrs:   { ids: images },
							type:   'single'
						});

						var attachments = wp.media.gallery.attachments( shortcode );

						var selection = new wp.media.model.Selection( attachments.models, {
							props:    attachments.props.toJSON(),
							multiple: true
						});

						selection.gallery = attachments.gallery;

						// Fetch the query's attachments, and then break ties from the
						// query to allow for sorting.
						selection.more().done( function() {
							// Break ties with the query.
							selection.props.set({ query: false });
							selection.unmirror();
							selection.props.unset('orderby');
						});

						return selection;
					}
					return false;
				}
			});
			
		</script>

	<?php }

}
$exito_post_metaboxes = new exito_Post_Metaboxes();