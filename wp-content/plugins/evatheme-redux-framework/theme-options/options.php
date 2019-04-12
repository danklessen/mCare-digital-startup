<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "exito_options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'exito_options/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => $theme->get( 'Name' ) . esc_html__( ' Options', 'redux-framework' ),
        'page_title'           => $theme->get( 'Name' ) . esc_html__( ' Options', 'redux-framework' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => plugin_dir_url( __FILE__ ) . 'img/emblem.png',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );


    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://plus.google.com/share?url=http://www.evatheme.ru',
        'title' => 'Visit us on Google Plus',
        'icon'  => 'el el-googleplus'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/evatheme',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/EVATHEME',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.behance.net/evickagency',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-behance'
    );
	
	// Add content after the form.
	$args['footer_text'] = __( '<p style="margin-top:20px;"><a href="http://www.evatheme.com/themes/" target="_blank" style="font-size:14px; color:#777; text-decoration:none; margin-right:10px;">More Themes</a><a href="http://www.forum.evatheme.com/" target="_blank"  style="font-size:14px; color:#777; text-decoration:none; margin-right:10px;">Support Forum</a><a href="http://exito.evatheme.com/docs/" target="_blank" style="font-size:14px; color:#777; text-decoration:none; margin-right:10px;">Documentation</a>
	</p>', 'redux-framework' );
	
	
    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'redux-framework' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'redux-framework' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

	/* General */
	Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'General', 'redux-framework' ),
		'heading'		=> esc_html__( 'General Settings', 'redux-framework'),
		'id'			=> 'general',
		'customizer_width' => '400px',
        'icon'			=> 'el el-cogs',
		'fields' 		=> array(
			array(
				'id'		=> 'section-favicon-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Favicon', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'favicon',
				'type'		=> 'media',
				'title'		=> esc_html__( 'Favicon', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Please insert your favicon 16x16px or 32x32px icon.', 'redux-framework' ) . '<br>' . esc_html__( 'Please note that if you"ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.', 'redux-framework' ),
				'compiler'	=> 'true',
				'desc'		=> esc_html__( 'Upload your Favicon.', 'redux-framework' ),
				'default'	=> array('url'=>get_template_directory_uri() . '/assets/images/favicon.ico'),
			),
			array(
				'id'		=> 'favicon-retina',
				'type'		=> 'switch',
				'title'		=> esc_html__( 'Retina Favicon', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Check this option if you want to have a Retina Favicon.', 'redux-framework' ),
				'default'	=> '0'
			),
			array(
				'id'		=> 'apple_icons_57x57',
				'type'		=> 'media',
				'required'	=> array( 'favicon-retina', '=', '1' ),
				'title'		=> esc_html__( 'Apple touch icon (57px)', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Icon must be 57x57px. Please note that if you"ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.', 'redux-framework' ),
				'compiler'	=> 'true',
				'desc'		=> esc_html__( 'Upload your Favicon.', 'redux-framework' ),
				'default'	=> '',
			),
			array(
				'id'		=> 'apple_icons_72x72',
				'type'		=> 'media',
				'required'	=> array( 'favicon-retina', '=', '1' ),
				'title'		=> esc_html__( 'Apple touch icon (72px)', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Icon must be 72x72px. Please note that if you"ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.', 'redux-framework' ),
				'compiler'	=> 'true',
				'desc'		=> esc_html__( 'Upload your Favicon.', 'redux-framework' ),
				'default'	=> '',
			),
			array(
				'id'		=> 'apple_icons_114x114',
				'type'		=> 'media',
				'required'	=> array( 'favicon-retina', '=', '1' ),
				'title'		=> esc_html__( 'Apple touch icon (114px)', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Icon must be 114x114px. Please note that if you"ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.', 'redux-framework' ),
				'compiler'	=> 'true',
				'desc'		=> esc_html__( 'Upload your Favicon.', 'redux-framework' ),
				'default'	=> '',
			),
			array(
				'id'		=> 'section-favicon-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			array(
				'id'		=> 'section-preloader-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Preloader Settings', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'preloader',
				'type'		=> 'switch',
				'title'		=> esc_html__( 'Preloader', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Enable a preloader screen on first page load. It displays a running line until the browser fetch the whole web content and will fade out the moment the page has been completely cached.', 'redux-framework' ),
				'default'	=> '0'
			),
			array(
				'id'		=> 'section-preloader-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			
			array(
				'id'		=> 'section-custom-divider-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Custom Divider', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'custom_divider',
				'type'		=> 'media',
				'title'		=> esc_html__( 'Custom Divider', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Custom image of divider. Found inside titles of pages, posts, single posts.', 'redux-framework' ),
				'compiler'	=> 'true',
				'default'	=> array('url' => get_template_directory_uri() . '/assets/images/theme-divider.png'),
			),
			array(
				'id'		=> 'custom_divider_width',
				'type'		=> 'slider',
				'title'		=> esc_html__( 'Half the width of divider', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'In order that the divider looked good on all gadgets, please enter half the width', 'redux-framework' ),
				'default'	=> 8,
				'min'		=> 0,
				'step'		=> 1,
				'max'		=> 100,
				'display_value' => 'text'
			),
			array(
				'id'		=> 'section-custom-divider-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			
			array(
				'id'		=> 'section-codefield-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Custom Code Fields', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'custom_css',
				'type'		=> 'ace_editor',
				'title'		=> esc_html__( 'CSS Code', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Paste your custom CSS code here.', 'redux-framework' ) . '<br>' . esc_html__( 'Very helpful if you add a custom class in a shortcode in order to customize a specific element.', 'redux-framework' ),
				'mode'		=> 'css',
				'theme'		=> 'chrome',
				'desc'		=> '',
				'default'	=> ''
			),
			array(
				'id'		=> 'custom-js',
				'type'		=> 'ace_editor',
				'title'		=> esc_html__( 'JS Code', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Paste your custom JS code here.', 'redux-framework' ),
				'mode'		=> 'javascript',
				'theme'		=> 'monokai',
				'desc'		=> '',
				'default'	=> ''
			),
			array(
				'id'		=> 'section-codefield-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
		)
	) );
	
	// Theme Layout
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Theme Layout', 'redux-framework' ),
		'heading'		=> esc_html__( 'Theme Layout Settings', 'redux-framework' ),
		'id'			=> 'theme_layout_settings',
		'subsection'	=> true,
		'fields'		=> array(
			array(
				'id'		=> 'section-theme_layout-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Theme Layout', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'theme_layout',
				'type'		=> 'select',
				'title'		=> esc_html__( 'Theme Layout', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Select the layout for you site.', 'redux-framework' ),
				'options' 	=> array(
								'full-width' 	=> esc_html__( 'Full-Width', 'redux-framework' ),
								'boxed' 		=> esc_html__( 'Boxed', 'redux-framework' ),
							),
				'default'	=> 'full-width'
			),
			array(
				'id'        => 'theme_bg_image',
				'type'      => 'background',
				'title'     => esc_html__('Theme Background Color / Image', 'redux-framework'),
				'subtitle'  => esc_html__('Select the for theme background color or image.', 'redux-framework'),
				'required' => array('theme_layout', 'equals', array('boxed')),
				'default'   => array(
									'background-color' => '#696969',
								),
				'transparent' => false,
			),
			array(
				'id'		=> 'theme_boxed_margin',
				'type'		=> 'slider',
				'title'		=> esc_html__( 'Indentation Site', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Select margins for the entire site from above and below', 'redux-framework' ),
				'required' => array('theme_layout', 'equals', array('boxed')),
				'default'	=> 0,
				'min'		=> 0,
				'step'		=> 10,
				'max'		=> 200,
				'display_value' => 'text'
			),
			array(
				'id'		=> 'section-theme_layout-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
		)
	) );
	
	// Page 404
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Page 404', 'redux-framework' ),
		'heading'		=> esc_html__( 'Page 404 Settings', 'redux-framework' ),
		'id'			=> 'page404_settings',
		'subsection'	=> true,
		'fields'		=> array(
			array(
				'id'		=> 'section-page404-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Page 404', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'        => 'page404_bg_image',
				'type'      => 'background',
				'title'     => esc_html__('Page 404 Background Color / Image', 'redux-framework'),
				'subtitle'  => esc_html__('Select the for page 404 background color or image.', 'redux-framework'),
				'default'   => array(
									'background-color' => '#4c4e50',
								),
				'transparent' => false,
			),
			array(
				'id'		=> 'page404_descr',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Description', 'redux-framework' ),
				'default'	=> 'The page requested could not be found. This could be a spelling error in the URL or a removed page.'
			),
			array(
				'id'		=> 'section-page404-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
		)
	) );
	
	
	//	Typography
    Redux::setSection( $opt_name, array(
        'title'			=> esc_html__( 'Typography', 'redux-framework' ),
		'heading'		=> esc_html__('Typography Settings', 'redux-framework'),
        'id'			=> 'typography',
        'icon'			=> 'el el-font',
        'fields'		=> array(
            array(
				'id'		=> 'section-main-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Main font', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
                'id'		=> 'body-font',
                'type'		=> 'typography',
                'title'		=> esc_html__( 'Body Font', 'redux-framework' ),
                'subtitle'	=> esc_html__( 'Specify the body font properties.', 'redux-framework' ),
                'google'	=> true,
				'preview'	=> false,
				'output'	=> array( 'body' ),
                'compiler'	=> array( 'body' ),
                'default'	=> array(
                    'font-family'	=> 'Ubuntu',
					'font-style'	=> '300',
					'line-height'	=> '28px',
                    'font-size'		=> '16px',
					'color'			=> '#222',
                ),
            ),
			array(
				'id'		=> 'section-main-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			array(
				'id'		=> 'section-heading-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Heading font', 'redux-framework' ),
				'indent'	=> true,
			),
            array(
                'id'		=> 'h1-font',
                'type'		=> 'typography',
                'title'		=> esc_html__( 'Heading 1', 'redux-framework' ),
                'google'	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview'	=> false, // Disable the previewer
                'all_styles' => true,
                'output'	=> array( 'h1' ),
                'compiler'	=> array( 'h1' ),
                'default'	=> array(
                    'font-family'	=> 'Ubuntu',
					'font-style'	=> '500',
					'line-height'	=> '84px',
					'font-size'		=> '72px',
					'color'			=> '#222',
					'letter-spacing' => '0px'
                ),
            ),
			array(
                'id'		=> 'h2-font',
                'type'		=> 'typography',
                'title'		=> esc_html__( 'Heading 2', 'redux-framework' ),
                'google'	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview'	=> false, // Disable the previewer
                'all_styles' => true,
                'output'	=> array( 'h2' ),
                'compiler'	=> array( 'h2' ),
                'default'	=> array(
                    'font-family' 	=> 'Ubuntu',
					'font-style' 	=> '500',
					'line-height' 	=> '74px',
					'font-size' 	=> '62px',
					'color' 		=> '#222',
					'letter-spacing' => '0px'
                ),
            ),
			array(
                'id' 		=> 'h3-font',
                'type' 		=> 'typography',
                'title' 	=> esc_html__( 'Heading 3', 'redux-framework' ),
                'google' 	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview' 	=> false, // Disable the previewer
                'all_styles' => true,
                'output' 	=> array( 'h3' ),
                'compiler' 	=> array( 'h3' ),
                'default' 	=> array(
                    'font-family' 	=> 'Ubuntu',
					'font-style' 	=> '500',
					'line-height' 	=> '64px',
					'font-size' 	=> '52px',
					'color' 		=> '#222',
					'letter-spacing' => '0px'
                ),
            ),
			array(
                'id' 		=> 'h4-font',
                'type' 		=> 'typography',
                'title' 	=> esc_html__( 'Heading 4', 'redux-framework' ),
                'google' 	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview' 	=> false, // Disable the previewer
                'all_styles' => true,
                'output' 	=> array( 'h4' ),
                'compiler' 	=> array( 'h4' ),
                'default' 	=> array(
                    'font-family' 	=> 'Ubuntu',
					'font-style' 	=> '500',
					'line-height' 	=> '50px',
					'font-size' 	=> '38px',
					'color' 		=> '#222',
					'letter-spacing' => '0px'
                ),
            ),
			array(
                'id' 		=> 'h5-font',
                'type' 		=> 'typography',
                'title' 	=> esc_html__( 'Heading 5', 'redux-framework' ),
                'google' 	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview' 	=> false, // Disable the previewer
                'all_styles' => true,
                'output' 	=> array( 'h5' ),
                'compiler' 	=> array( 'h5' ),
                'default' 	=> array(
                    'font-family' 	=> 'Ubuntu',
					'font-style' 	=> '500',
					'line-height' 	=> '34px',
					'font-size' 	=> '22px',
					'color' 		=> '#222',
					'letter-spacing' => '0px'
                ),
            ),
			array(
                'id' 		=> 'h6-font',
                'type' 		=> 'typography',
                'title' 	=> esc_html__( 'Heading 6', 'redux-framework' ),
                'google' 	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview' 	=> false, // Disable the previewer
                'all_styles' => true,
                'output' 	=> array( 'h6' ),
                'compiler' 	=> array( 'h6' ),
                'default' 	=> array(
                    'font-family' 	=> 'Ubuntu',
					'font-style' 	=> '400',
					'line-height' 	=> '34px',
					'font-size' 	=> '22px',
					'color' 		=> '#222',
					'letter-spacing' => '0px'
                ),
            ),
			array(
				'id'		=> 'section-heading-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			array(
				'id'		=> 'section-blog-content-font-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Blog Content', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
                'id'		=> 'blog_content_font',
                'type'		=> 'typography',
                'title'		=> esc_html__( 'Post Content Font', 'redux-framework' ),
                'subtitle'	=> esc_html__( 'Specify the post font properties.', 'redux-framework' ),
                'google'	=> true,
				'preview'	=> false,
				'output'	=> array( '.single-post-content p' ),
                'compiler'	=> array( '.single-post-content p' ),
                'default'	=> array(
                   'font-family' 	=> 'Lato',
					'font-style' 	=> '400',
					'line-height' 	=> '34px',
					'font-size' 	=> '20px',
					'color' 		=> '#222',
					'letter-spacing' => '0px'
                ),
            ),
			array(
				'id'		=> 'section-blog-content-font-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
        )
    ) );
	
	
	// Color Selection
    Redux::setSection( $opt_name, array(
        'title'			=> esc_html__( 'Colors', 'redux-framework' ),
		'heading'		=> esc_html__('Colors Settings', 'redux-framework'),
        'id'			=> 'color',
		'icon'			=> 'el el-brush',
        'fields'		=> array(
            array(
				'id' 		=> 'section-theme-color-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Theme Color', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
                'id'		=> 'theme_color',
                'type'		=> 'color',
				'transparent' => false,
                'output'	=> array( '.theme_color' ),
                'title'		=> esc_html__( 'Default Theme Color', 'redux-framework' ),
                'subtitle'	=> esc_html__( 'Pick a color for the theme (default: #ffb500).', 'redux-framework' ),
                'default'	=> '#ffb500',
            ),
			array(
				'id'		=> 'section-theme-color-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
        ),
    ) );
	
	
	// Header
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Header', 'redux-framework' ),
		'heading'		=> esc_html__( 'Header Settings', 'redux-framework' ),
		'id'			=> 'header',
		'icon'			=> 'dashicons dashicons-align-center',
		'fields'		=> array(
			array(
				'id'		=> 'section-header-styles-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Header Styles', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'header-layout',
				'type'		=> 'select',
				'title'		=> esc_html__( 'Header Layout', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'You can choose between a header full width style menu or a boxed style menu.', 'redux-framework' ),
				'options'	=> array(
								'full_width'		=> esc_html__( 'Full Width', 'redux-framework' ),
								'boxed'				=> esc_html__( 'Boxed', 'redux-framework' )
							),
				'default'	=> 'boxed'
			),
			array(
				'id'		=> 'header_bg_style',
				'type'		=> 'select',
				'title'		=> esc_html__( 'Header Background Style', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Select a background style for the header.', 'redux-framework' ),
				'options'	=> array(
								'gradient'		=> esc_html__( 'Gradient', 'redux-framework' ),
								'bgcolor'		=> esc_html__( 'Background Color', 'redux-framework' ),
							),
				'default'	=> 'gradient'
			),
			array(
				'id'		=> 'header_bgcolor',
				'type'		=> 'color',
				'title'		=> esc_html__( 'Header Background Color', 'redux-framework' ), 
				'subtitle'	=> esc_html__( 'Pick a color for the header background.', 'redux-framework' ),
				'required'	=> array( 'header_bg_style', 'equals', array('bgcolor') ),
				'default'	=> '#222222',
				'transparent' => false,
				'validate'	=> 'color',
			),
			array(
				'id'		=> 'header_bgcolor_opacity',
				'type'		=> 'slider',
				'title'		=> esc_html__( 'Header Background Color Opacity', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Pick a opacity for the header background color.', 'redux-framework' ),
				'required'	=> array( 'header_bg_style', 'equals', array('bgcolor') ),
				'min'		=> 0,
				'step'		=> 1,
				'max'		=> 99,
				'default'	=> 90,
				'display_value' => 'text'
			),
			array(
				'id'		=> 'header_gradient',
				'type'		=> 'color_gradient',
				'title'		=> esc_html__( 'Header Gradient Color', 'redux-framework' ), 
				'subtitle'	=> esc_html__( 'Pick a gradient colors for the header text color.', 'redux-framework' ),
				'required'	=> array( 'header_bg_style', 'equals', array('gradient') ),
				'default'   => array(
							'from'      => '#000000',
                            'to'        => '',
				),
				'transparent' => true,
				'validate'	=> 'color',
			),
			array(
				'id'		=> 'header_color',
				'type'		=> 'color',
				'title'		=> esc_html__( 'Header Text Color', 'redux-framework' ), 
				'subtitle'	=> esc_html__( 'Pick a color for the header text color. Tagline text, social icons color, Creative Menu button', 'redux-framework' ),
				'default'	=> '#fff',
				'transparent' => false,
				'validate'	=> 'color',
			),
			array(
				'id'		=> 'section-header-styles-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			
			array(
				'id'		=> 'section-tagline-area-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Tagline Area Settings', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'tagline_area',
				'type'		=> 'switch',
				'title'		=> esc_html__( 'Tagline area', 'redux-framework' ),
				'default'	=> '0',
			),
			array(
				'id'		=> 'tagline_area_phone',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Phone Number', 'redux-framework' ),
				'required'	=> array( 'tagline_area', '=', '1' ),
				'default'	=> '1-800-985-357',
			),
			array(
				'id'		=> 'tagline_area_email',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Email Address', 'redux-framework' ),
				'required'	=> array( 'tagline_area', '=', '1' ),
				'default'	=> 'hello@exito.com',
			),
			array(
				'id'		=> 'section-tagline-area-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			
			array(
				'id'		=> 'section-logo-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Theme Logo', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'header-logo',
				'type'		=> 'media',
				'title'		=> esc_html__( 'Upload Standard Logo', 'redux-framework' ),
				'compiler'	=> 'true',
				'desc'		=> esc_html__( 'Upload your header logo.', 'redux-framework' ),
				'default'	=> array('url' => get_template_directory_uri() . '/assets/images/logo.png'),
			),
			array(
				'id'		=> 'header-logo-retina',
				'type'		=> 'media',
				'title'		=> esc_html__( 'Retina Logo', 'redux-framework' ),
				'compiler'	=> 'true',
				'desc'		=> esc_html__( 'Upload your header retina logo.', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Note: You retina logo must be larger than 2x. Example: Main logo 120x200 then Retina must be 240x400.', 'redux-framework' ),
				'default'	=> '',
			),
			array(
				'id'		=> 'header-logo-width',
				'type'		=> 'slider',
				'title'		=> esc_html__( 'Standard Logo Width', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'You need to insert Non retina logo width. Height auto.', 'redux-framework' ),
				'min'		=> 0,
				'step'		=> 1,
				'max'		=> 300,
				'default'	=> 170,
				'display_value' => 'text'
			),
			array(
				'id'		=> 'section-logo-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			array(
				'id'		=> 'section-header-icons-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Header Icons', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'header_social_links',
				'type'		=> 'switch',
				'title'		=> esc_html__( 'Header Social Links', 'redux-framework' ),
				'default'	=> '0'
			),
			array(
				'id'		=> 'header_search',
				'type'		=> 'switch',
				'title'		=> esc_html__( 'Header Search', 'redux-framework' ),
				'default'	=> '1'
			),
			array(
				'id'		=> 'section-header-icons-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
		)
	) );
	
	
	// Header Menu
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Header Menu', 'redux-framework' ),
		'heading'		=> esc_html__( 'Menu Styles', 'redux-framework' ),
		'id'			=> 'header_menu',
		'subsection'	=> true,
		'fields'		=> array(
			array(
				'id'     	=> 'section-headermenu-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Style Menu Items', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
                'id'		=> 'headermenu_font',
                'type'		=> 'typography',
                'title'		=> esc_html__( 'Main Menu Items', 'redux-framework' ),
				'subtitle'  => esc_html__('Styles for the main menu items', 'redux-framework'),
                'google'	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview'	=> false, // Disable the previewer
                'all_styles' => false,
				'text-transform' => true,
				'text-align' => false,
				'subsets' => false,
                'default'	=> array(
                    'font-family'	=> 'Ubuntu',
					'font-style'	=> '500',
					'line-height'	=> '20px',
					'font-size'		=> '16px',
					'color'			=> '#fff',
					'letter-spacing' => '0px'
                ),
            ),
			array(
				'id'        => 'headermenu_hover_color',
				'type'      => 'color',
				'title'     => esc_html__('Hover Color', 'redux-framework'),
				'subtitle'  => esc_html__('The color of the text when you hover on the main menu items', 'redux-framework'),
				'default'   => '#ffb500',
				'transparent' => false,
			),
			array(
                'id'		=> 'headersubmenu_font',
                'type'		=> 'typography',
                'title'		=> esc_html__( 'Sub Menu Items', 'redux-framework' ),
				'subtitle'  => esc_html__('Styles for the main sub menu items', 'redux-framework'),
                'google'	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview'	=> false, // Disable the previewer
                'all_styles' => false,
				'text-transform' => true,
				'text-align' => false,
				'subsets' => false,
                'default'	=> array(
                    'font-family'	=> 'Ubuntu',
					'font-style'	=> '300',
					'line-height'	=> '20px',
					'font-size'		=> '14px',
					'color'			=> '#ffffff',
					'letter-spacing' => '0px'
                ),
            ),
			array(
				'id'        => 'headersubmenu_bgcolor',
				'type'      => 'color',
				'title'     => esc_html__('Background Color', 'redux-framework'),
				'subtitle'  => esc_html__('Background for drop-down menu', 'redux-framework'),
				'default'   => '#222222',
				'transparent' => false,
			),
			array(
				'id'        => 'headersubmenu_hover_bgcolor',
				'type'      => 'color',
				'title'     => esc_html__('Hover Background Color', 'redux-framework'),
				'subtitle'  => esc_html__('Background of the text when you hover or active on the menu items', 'redux-framework'),
				'default'   => '#191919',
				'transparent' => false,
			),
			array(
				'id'     => 'section-headermenu-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );
	
	
	// Page Title
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Page Title', 'redux-framework' ),
		'heading'		=> '',
		'id'			=> 'pagetitle',
		'icon'			=> 'dashicons dashicons-editor-insertmore',
		'fields'		=> array(
			array(
				'id'     	=> 'section-pagetitle-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Page Title Styles', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id'        => 'pagetitle',
				'type'      => 'select',
				'title'     => esc_html__('Show Page Title?', 'redux-framework'),
				'subtitle'  => esc_html__('Turn on to show the page title.', 'redux-framework'),
				'options' => array(
					'show' => esc_html__( 'Show', 'redux-framework' ),
					'hide' => esc_html__( 'Hide', 'redux-framework' ),
				),
				'default' => 'show',
			),
			array(
				'id'        => 'pagetitle_bg_image',
				'type'      => 'background',
				'title'     => esc_html__('Page Title Background Color / Image', 'redux-framework'),
				'subtitle'  => esc_html__('Select the Title background color or image.', 'redux-framework'),
				'required' => array('pagetitle', 'equals', array('show')),
				'default'   => array(
									'background-color' => '#696969',
								),
				'transparent' => false,
			),
			array(
				'id'        => 'pagetitle_bg_image_parallax',
				'type'      => 'select',
				'title'     => esc_html__('Parallax Effect', 'redux-framework'),
				'subtitle'  => esc_html__('Enable this to the parallax effect for background image.', 'redux-framework'),
				'options' => array(
					'disable' => esc_html__( 'Disable', 'redux-framework' ),
					'enable' => esc_html__( 'Enable', 'redux-framework' ),
				),
				'default' => 'disable',
			),
			array(
				'id'        => 'pagetitle_text_color',
				'type'      => 'color',
				'title'     => esc_html__('Title Text Color', 'redux-framework'),
				'subtitle'  => esc_html__('Title text color (default: #ffffff).', 'redux-framework'),
				'required' => array('pagetitle', 'equals', array('show')),
				'default'   => '#ffffff',
				'transparent' => false,
			),
			array(
				'id'     => 'section-pagetitle-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     	=> 'section-breadcrumbs-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Breadcrumbs Styles', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id'        => 'breadcrumbs',
				'type'      => 'select',
				'title'     => esc_html__('Show breadcrumbs?', 'redux-framework'),
				'subtitle'  => esc_html__('Turn on to show the breadcrumbs in the title.', 'redux-framework'),
				'options' => array(
					'show' => esc_html__( 'Show', 'redux-framework' ),
					'hide' => esc_html__( 'Hide', 'redux-framework' ),
				),
				'default' => 'show',
			),
			array(
				'id'        => 'breadcrumbs_bgcolor',
				'type'      => 'color',
				'title'     => esc_html__('Breadcrumbs Background Color', 'redux-framework'),
				'subtitle'  => esc_html__('Breadcrumbs background color (default: #f2f2f2).', 'redux-framework'),
				'required' => array('breadcrumbs', 'equals', array('show')),
				'default'   => '#f2f2f2',
				'transparent' => false,
			),
			array(
				'id'        => 'breadcrumbs_color',
				'type'      => 'color',
				'title'     => esc_html__('Breadcrumbs Text Color', 'redux-framework'),
				'subtitle'  => esc_html__('Breadcrumbs text color (default: #999999).', 'redux-framework'),
				'required' => array('breadcrumbs', 'equals', array('show')),
				'default'   => '#999999',
				'transparent' => false,
			),
			array(
				'id'     => 'section-breadcrumbs-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );
	
	
	// Blog
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Blog', 'redux-framework' ),
		'heading'		=> esc_html__( 'Default Blog Settings', 'redux-framework' ),
		'id'			=> 'blog',
		'icon'			=> 'dashicons dashicons-welcome-write-blog',
		'fields'		=> array(
			array(
				'id'     	=> 'section-blog-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Blog Title Styles', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id'        => 'blog_pagetitle',
				'type'      => 'select',
				'title'     => esc_html__('Show Page Title?', 'redux-framework'),
				'subtitle'  => esc_html__('Turn on to show the page title.', 'redux-framework'),
				'options' => array(
					'show' => esc_html__( 'Show', 'redux-framework' ),
					'hide' => esc_html__( 'Hide', 'redux-framework' ),
				),
				'default' => 'show',
			),
			array(
				'id'        => 'blog_pagetitle_bg_image',
				'type'      => 'background',
				'title'     => esc_html__('Page Title Background Color / Image', 'redux-framework'),
				'subtitle'  => esc_html__('Select the Title background color or image.', 'redux-framework'),
				'required' => array('blog_pagetitle', 'equals', array('show')),
				'default'   => array(
									'background-color' => '#696969',
								),
				'transparent' => false,
			),
			array(
				'id'        => 'blog_pagetitle_text_color',
				'type'      => 'color',
				'title'     => esc_html__('Title Text Color', 'redux-framework'),
				'subtitle'  => esc_html__('Title text color (default: #ffffff).', 'redux-framework'),
				'required' => array('blog_pagetitle', 'equals', array('show')),
				'default'   => '#ffffff',
				'transparent' => false,
			),
			array(
				'id'		=> 'blog_pagetitle_text',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Blog Title', 'redux-framework' ),
				'required' => array('blog_pagetitle', 'equals', array('show')),
				'default'	=> 'Blog Classic'
			),
			array(
				'id'		=> 'blog_pagetitle_subtext',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Blog Subheading', 'redux-framework' ),
				'required' => array('blog_pagetitle', 'equals', array('show')),
				'default'	=> 'Our Best Posts'
			),
			array(
				'id'		=> 'blog_layout',
				'type' 		=> 'image_select',
				'title' 	=> esc_html__( 'Blog Layout', 'redux-framework' ),
				'options' 	=> array(
					'no-sidebar' 		=> array('alt' => esc_html__('No Sidebar', 'redux-framework'), 'img' => plugin_dir_url( __FILE__ ) . 'img/no-sidebar.png'),
					'right-sidebar' 	=> array('alt' => esc_html__('Right Sidebar', 'redux-framework'), 'img' => plugin_dir_url( __FILE__ ) . 'img/right-sidebar.png'),
					'left-sidebar' 		=> array('alt' => esc_html__('Left Sidebar', 'redux-framework'), 'img' => plugin_dir_url( __FILE__ ) . 'img/left-sidebar.png'),
				),
				'default' 	=> 'right-sidebar'
			),
			array(
				'id'     => 'section-blog-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );
	
	
	// Single Post
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Single Post', 'redux-framework' ),
		'heading'		=> esc_html__( 'Single Post Settings', 'redux-framework' ),
		'id'			=> 'single_post',
		'subsection'	=> true,
		'fields'		=> array(
			array(
				'id'     	=> 'section-blogsingle-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Single Post Title Styles', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id'		=> 'blogsingle_pagetitle_text',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Single Post Title', 'redux-framework' ),
				'default'	=> 'Single Post'
			),
			array(
				'id'		=> 'blogsingle_pagetitle_subtext',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Single Post Subheading', 'redux-framework' ),
				'default'	=> 'Our Best Post'
			),
			array(
				'id'		=> 'blogsingle_layout',
				'type' 		=> 'image_select',
				'title' 	=> esc_html__( 'Single Post Layout', 'redux-framework' ),
				'options' 	=> array(
					'no-sidebar' 		=> array('alt' => esc_html__('No Sidebar', 'redux-framework'), 'img' => plugin_dir_url( __FILE__ ) . 'img/no-sidebar.png'),
					'right-sidebar' 	=> array('alt' => esc_html__('Right Sidebar', 'redux-framework'), 'img' => plugin_dir_url( __FILE__ ) . 'img/right-sidebar.png'),
					'left-sidebar' 		=> array('alt' => esc_html__('Left Sidebar', 'redux-framework'), 'img' => plugin_dir_url( __FILE__ ) . 'img/left-sidebar.png'),
				),
				'default' 	=> 'left-sidebar'
			),
			array(
				'id'     => 'section-blogsingle-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     	=> 'section-blogsingle-sharebox-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Social sharing box icons', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id' => 'single_post_sharebox',
				'type' => 'switch',
				'title' => esc_html__( 'Sharebox', 'redux-framework' ),
				'subtitle' => esc_html__( 'Enable social share-box on single post view?', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_facebook',
				'type' => 'switch',
				'title' => esc_html__( 'Facebook', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Facebook in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_twitter',
				'type' => 'switch',
				'title' => esc_html__( 'Twitter', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Twitter in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_linkedin',
				'type' => 'switch',
				'title' => esc_html__( 'LinkedIn', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable LinkedIn in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_reddit',
				'type' => 'switch',
				'title' => esc_html__( 'Reddit', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Reddit in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_digg',
				'type' => 'switch',
				'title' => esc_html__( 'Digg', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Digg in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_delicious',
				'type' => 'switch',
				'title' => esc_html__( 'Delicious', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Delicious in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_google',
				'type' => 'switch',
				'title' => esc_html__( 'Google plus', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Google plus in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_sharebox_pinterest',
				'type' => 'switch',
				'title' => esc_html__( 'Pinterest', 'redux-framework' ),
				'required' => array( 'single_post_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Pinterest in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id'     => 'section-blogsingle-sharebox-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     	=> 'section-blogsingle-elements-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Single Post Elements', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id' => 'single_post_author',
				'type' => 'switch',
				'title' => esc_html__( 'Author Box', 'redux-framework' ),
				'subtitle' => esc_html__( 'Enable Author Box on single post view?', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_navigation',
				'type' => 'switch',
				'title' => esc_html__( 'Post Navigation', 'redux-framework' ),
				'subtitle' => esc_html__( 'Enable Navigation on single post view?', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_related_posts',
				'type' => 'switch',
				'title' => esc_html__( 'Related Posts', 'redux-framework' ),
				'subtitle' => esc_html__( 'Enable Related Posts on single post view?', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'single_post_related_posts_title',
				'type' => 'text',
				'title' => esc_html__( 'Related Posts Title', 'redux-framework' ),
				'required' => array( 'single_post_related_posts', '=', '1' ),
				'default' => 'Related Posts'
			),
			array(
				'id'     => 'section-blogsingle-elements-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );
	
	
	//	Portfolio
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Portfolio', 'redux-framework' ),
		'heading'		=> esc_html__( 'Portfolio Settings', 'redux-framework' ),
		'id'			=> 'portfolio',
		'icon'			=> 'dashicons dashicons-portfolio',
		'fields'		=> array(
			array(
				'id'     	=> 'section-portfolio_list-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'List of portfolio works', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id'        => 'portfolio_filter_color',
				'type'      => 'color',
				'title'     => esc_html__('Portfolio Filter Color', 'redux-framework'),
				'subtitle'  => esc_html__('Select a color for portfolio filter text', 'redux-framework'),
				'default'   => '#333333',
				'transparent' => false,
			),
			array(
				'id'        => 'portfolio_overlay',
				'type'      => 'color',
				'title'     => esc_html__('Portfolio Overlay Color', 'redux-framework'),
				'subtitle'  => esc_html__('Select a color for the overlay in portfolio', 'redux-framework'),
				'default'   => '#333333',
				'transparent' => false,
			),
			array(
				'id'		=> 'portfolio_overlay_opacity',
				'type'		=> 'slider',
				'title'		=> esc_html__( 'Portfolio Overlay Opacity', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'Select opacity for the overlay in portfolio', 'redux-framework' ),
				'default'	=> 85,
				'min'		=> 0,
				'step'		=> 1,
				'max'		=> 99,
				'display_value' => 'text'
			),
			array(
				'id'     => 'section-portfolio_list-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     	=> 'section-portfolio_single_title-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Single Portfolio Title', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id'        => 'portfolio_single_pagetitle',
				'type'      => 'select',
				'title'     => esc_html__('Show Page Title?', 'redux-framework'),
				'subtitle'  => esc_html__('Turn on to show the page title.', 'redux-framework'),
				'options' => array(
					'show' => esc_html__( 'Show', 'redux-framework' ),
					'hide' => esc_html__( 'Hide', 'redux-framework' ),
				),
				'default' => 'show',
			),
			array(
				'id'        => 'portfolio_single_pagetitle_bg_image',
				'type'      => 'background',
				'title'     => esc_html__('Page Title Background Color / Image', 'redux-framework'),
				'subtitle'  => esc_html__('Select the Title background color or image.', 'redux-framework'),
				'required' => array('portfolio_single_pagetitle', 'equals', array('show')),
				'default'   => array(
									'background-color' => '#696969',
								),
				'transparent' => false,
			),
			array(
				'id'        => 'portfolio_single_pagetitle_text_color',
				'type'      => 'color',
				'title'     => esc_html__('Title Text Color', 'redux-framework'),
				'subtitle'  => esc_html__('Title text color (default: #ffffff).', 'redux-framework'),
				'required' => array('portfolio_single_pagetitle', 'equals', array('show')),
				'default'   => '#ffffff',
				'transparent' => false,
			),
			array(
				'id'		=> 'portfolio_single_pagetitle_text',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Single Portfolio Title', 'redux-framework' ),
				'required' => array('portfolio_single_pagetitle', 'equals', array('show')),
				'default'	=> 'Single Portfolio'
			),
			array(
				'id'		=> 'portfolio_single_pagetitle_subtext',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Single Portfolio Subheading', 'redux-framework' ),
				'required' => array('portfolio_single_pagetitle', 'equals', array('show')),
				'default'	=> 'Our Best Work'
			),
			array(
				'id'        => 'portfolio_single_breadcrumbs',
				'type'      => 'select',
				'title'     => esc_html__('Show breadcrumbs?', 'redux-framework'),
				'subtitle'  => esc_html__('Turn on to show the breadcrumbs in the title.', 'redux-framework'),
				'options' => array(
					'show' => esc_html__( 'Show', 'redux-framework' ),
					'hide' => esc_html__( 'Hide', 'redux-framework' ),
				),
				'default' => 'hide',
			),
			array(
				'id'     => 'section-portfolio_single_title-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     	=> 'section-portfolio_single-sharebox-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Social sharing box icons', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id' => 'portfolio_single_sharebox',
				'type' => 'switch',
				'title' => esc_html__( 'Sharebox', 'redux-framework' ),
				'subtitle' => esc_html__( 'Enable social share-box on single post view?', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_facebook',
				'type' => 'switch',
				'title' => esc_html__( 'Facebook', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Facebook in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_twitter',
				'type' => 'switch',
				'title' => esc_html__( 'Twitter', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Twitter in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_linkedin',
				'type' => 'switch',
				'title' => esc_html__( 'LinkedIn', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable LinkedIn in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_reddit',
				'type' => 'switch',
				'title' => esc_html__( 'Reddit', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Reddit in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_digg',
				'type' => 'switch',
				'title' => esc_html__( 'Digg', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Digg in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_delicious',
				'type' => 'switch',
				'title' => esc_html__( 'Delicious', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Delicious in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_google',
				'type' => 'switch',
				'title' => esc_html__( 'Google plus', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Google plus in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id' => 'portfolio_single_sharebox_pinterest',
				'type' => 'switch',
				'title' => esc_html__( 'Pinterest', 'redux-framework' ),
				'required' => array( 'portfolio_single_sharebox', '=', '1' ),
				'subtitle' => esc_html__( 'Check to enable Pinterest in social sharing box', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id'     => 'section-portfolio_single-sharebox-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     	=> 'section-portfolio_single-elements-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Single Post Elements', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id' => 'portfolio_single_navigation',
				'type' => 'switch',
				'title' => esc_html__( 'Post Navigation', 'redux-framework' ),
				'subtitle' => esc_html__( 'Enable Navigation on single post view?', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id'		=> 'portfolio_single_navigation_backbtn',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Portfolio Page Link', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'link to go to the home page portfolio', 'redux-framework' ),
				'default' 	=> ''
			),
			array(
				'id'     => 'section-portfolio_single-elements-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );
	
	
	// Footer
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Footer', 'redux-framework' ),
		'heading'		=> esc_html__( 'Footer Settings', 'redux-framework' ),
		'id'			=> 'footer',
		'icon'			=> 'dashicons dashicons-align-center',
		'fields'		=> array(
			array(
				'id'     	=> 'section-footer_fixed-start',
				'type'   	=> 'section',
				'title' 	=> '',
				'indent' 	=> true,
			),
			array(
				'id' => 'footer_fixed',
				'type' => 'switch',
				'title' => esc_html__( 'Footer Fixed', 'redux-framework' ),
				'subtitle' => esc_html__( 'Make fixed footer', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id'		=> 'footer_layout',
				'type'		=> 'select',
				'title'		=> esc_html__( 'Footer Layout', 'redux-framework' ),
				'subtitle'	=> esc_html__( 'You can choose between a full width style or a boxed style footer.', 'redux-framework' ),
				'options'	=> array(
								'full_width'		=> esc_html__( 'Full Width', 'redux-framework' ),
								'boxed'				=> esc_html__( 'Boxed', 'redux-framework' )
							),
				'default'	=> 'boxed'
			),
			array(
				'id'     => 'section-footer_fixed-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     	=> 'section-prefooter-background-start',
				'type'   	=> 'section',
				'title' 	=> esc_html__( 'Prefooter Styles', 'redux-framework' ),
				'indent' 	=> true,
			),
			array(
				'id' => 'enable_prefooter',
				'type' => 'select',
				'title' => esc_html__( 'Prefooter Area', 'redux-framework' ),
				'subtitle' => esc_html__( 'Check this option if you want show prefooter area', 'redux-framework' ),
				'options' => array(
					'show' => esc_html__( 'Show', 'redux-framework' ),
					'hide' => esc_html__( 'Hide', 'redux-framework' ),
				),
				'default' => 'hide',
			),
			array(
				'id'        => 'prefooter_bgcolor',
				'type'      => 'color',
				'title'     => esc_html__( 'Prefooter Background Color', 'redux-framework' ), 
				'subtitle'  => esc_html__( 'Please select a color.', 'redux-framework' ),
				'required' => array('enable_prefooter', 'equals', array('show')),
				'default'   => '#222222',
				'transparent' => false,
				'validate'  => 'color',
			),
			array(
				'id' => 'prefooter_col',
				'type' => 'image_select',
				'title' => esc_html__( 'Prefooter Columns', 'redux-framework' ),
				'subtitle' => esc_html__( 'Choose the number of desired column in the prefooter widget area.', 'redux-framework' ),
				'required' => array('enable_prefooter', 'equals', array('show')),
				'options' => array(
					'12' => array('alt' => '1 Columns', 'img' => plugin_dir_url( __FILE__ ) . 'img/1col.png'),
					'6-6' => array('alt' => '2 Columns', 'img' => plugin_dir_url( __FILE__ ) . 'img/2col.png'),
					'4-4-4' => array('alt' => '3 Columns', 'img' => plugin_dir_url( __FILE__ ) . 'img/3col.png'),
					'3-3-3-3' => array('alt' => '4 Columns', 'img' => plugin_dir_url( __FILE__ ) . 'img/4col.png')
				),
				'default' => '4-4-4'
			),
			array(
                'id'		=> 'prefooter_headings',
                'type'		=> 'typography',
                'title'		=> esc_html__( 'Widgets Hedings', 'redux-framework' ),
				'subtitle'  => esc_html__('Styles for the headings of widgets', 'redux-framework'),
				'required' => array('enable_prefooter', 'equals', array('show')),
                'google'	=> true,
                'letter-spacing' => true,  // Defaults to false
                'preview'	=> false, // Disable the previewer
                'all_styles' => false,
				'text-transform' => true,
				'text-align' => false,
				'subsets' => false,
                'default'	=> array(
                    'font-family'	=> 'Ubuntu',
					'font-style'	=> '500',
					'line-height'	=> '28px',
					'font-size'		=> '18px',
					'color'			=> '#ffffff',
					'letter-spacing' => '0px'
                ),
            ),
			array(
				'id'        => 'prefooter_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Prefooter Text Color', 'redux-framework' ), 
				'subtitle'  => esc_html__( 'Please select a color.', 'redux-framework' ),
				'required' => array('enable_prefooter', 'equals', array('show')),
				'default'   => '#999999',
				'transparent' => false,
				'validate'  => 'color',
			),
			array(
				'id'     => 'section-prefooter-background-end',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'     => 'section-footer-start',
				'type'   => 'section',
				'title' => esc_html__( 'Footer Styles', 'redux-framework' ),
				'indent' => true,
			),
			array(
				'id' => 'footer',
				'type' => 'select',
				'title' => esc_html__( 'Footer Area', 'redux-framework' ),
				'subtitle' => esc_html__( 'Check this option if you want the footer bottom area.', 'redux-framework' ),
				'options' => array(
					'show' => esc_html__( 'Show', 'redux-framework' ),
					'hide' => esc_html__( 'Hide', 'redux-framework' ),
				),
				'default' => 'show',
			),
			array(
				'id'        => 'footer_bgcolor',
				'type'      => 'color',
				'title'     => esc_html__( 'Footer Background Color', 'redux-framework' ), 
				'subtitle'  => esc_html__( 'Please select a color.', 'redux-framework' ),
				'required' => array('footer', 'equals', array('show')),
				'default'   => '#242628',
				'transparent' => false,
				'validate'  => 'color',
			),
			array(
				'id'        => 'footer_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Footer Text Color', 'redux-framework' ), 
				'subtitle'  => esc_html__( 'Please select a color.', 'redux-framework' ),
				'required' => array('footer', 'equals', array('show')),
				'default'   => '#999999',
				'transparent' => false,
				'validate'  => 'color',
			),
			array(
				'id' => 'footer_copyright',
				'type' => 'text',
				'title' => esc_html__( 'Footer Copyright Text', 'redux-framework' ),
				'subtitle' => esc_html__( 'Please enter the copyright text.', 'redux-framework' ),
				'required' => array('footer', 'equals', array('show')),
				'default' => 'Copyright &#169; 2017 Evatheme. All Rights Reserved.'
			),
			array(
				'id' => 'footer-social',
				'type' => 'switch',
				'title' => esc_html__( 'Footer Social Icon', 'redux-framework' ),
				'subtitle' => esc_html__( 'Check this option if you to add social icons inside the footer.', 'redux-framework' ),
				'required' => array('footer', 'equals', array('show')),
				'default' => '1'
			),
			array(
				'id'     => 'section-footer-bootom-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );
	
	
	// Social Icons
    Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'Social Icons', 'redux-framework' ),
		'heading'		=> esc_html__( 'Social Icons Settings', 'redux-framework' ),
		'id'			=> 'social-icons',
		'icon'			=> 'dashicons dashicons-share',
		'fields'		=> array(
			array(
				'id'		=> 'section-social-icons-start',
				'type'		=> 'section',
				'indent'	=> true,
			),
			array(
				'id'		=> 'facebook_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Facebook', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Facebook icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> "http://www.facebook.com/evatheme"
			),
			array(
				'id'		=> 'twitter_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Twitter', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Twitter icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> "http://twitter.com/EVATHEME"
			),
			array(
				'id'		=> 'linkedin_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'LinkedIn', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for LinkedIn icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'pinterest_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Pinterest', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Pinterest icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'googleplus_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Google Plus+', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Google Plus+ icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> "https://plus.google.com/u/0/share?url=http://www.evatheme.com"
			),
			array(
				'id'		=> 'youtube_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Youtube', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Youtube icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'rss_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'RSS', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for RSS icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'tumblr_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Tumblr', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Tumblr icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'reddit_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Reddit', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Reddit icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'dribbble_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Dribbble', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Dribbble icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'digg_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Digg', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Digg icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'flickr_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Flickr', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Flickr icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'instagram_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Instagram', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Instagram icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> "https://www.instagram.com/evathemefoto/"
			),
			array(
				'id'		=> 'vimeo_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Vimeo', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Vimeo icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'skype_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Skype', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Skype icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'yahoo_link',
				'type'     	=> 'text',
				'title' 	=> esc_html__( 'Yahoo', 'redux-framework' ),
				'subtitle' 	=> esc_html__( 'Enter the link for Yahoo icon to appear. To remove it, just leave it blank.', 'redux-framework' ),
				'default' 	=> ""
			),
			array(
				'id'		=> 'section-social-icons-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
		)
	) );
	
	
	//	Sidebars
	$fields = get_option('exito_options');
	if (is_array($fields) && array_key_exists ('unlimited_sidebar', $fields)) {
		$options = $fields['unlimited_sidebar'];
		$sidebars =  array();
		if ($options != null) {
			foreach($options as $sidebar) {
				$sidebars[$sidebar] = $sidebar;
			}
		} else {
			$sidebars = null;
		}
	} else {
		$sidebars = null;
	}
		
	Redux::setSection( $opt_name, array(
		'title'			=> esc_html__( 'SideBar', 'redux-framework' ),
		'id'			=> 'unlimited-sideBar',
		'customizer_width' => '400px',
        'icon'			=> 'dashicons dashicons-align-left',
		'fields'		=> array(
			array(
				'id'		=> 'sidebars-start',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Sidebar Generator', 'redux-framework' ),
				'indent'	=> true,
			),
			array(
				'id'		=> 'info_sidebars',
				'type'		=> 'info',
				'title'		=> esc_html__( 'In this option panel, you can create and add unlimited number of sidebar.', 'redux-framework' ) . '<br>' . esc_html__( 'Give a name to your sidebar, add it, then save changes.', 'redux-framework' ) . '<br>' . esc_html__( 'Your new created sidebar will appear on the widget page', 'redux-framework' ) . ' (<a href="'. admin_url( "widgets.php", "http" ) . '">' . esc_html__( 'widget pages', 'redux-framework' ) . '</a>) ' . esc_html__( 'Manage it by adding widget as usual.', 'redux-framework' ) . '<br>' . esc_html__( 'To set the sidebar, you will see on post, portfolio and page a custom meta box named Sidebar. Select the name of the desired sidebar that you want to display on the current post/page.', 'redux-framework' ),
				'icon'		=> 'el-icon-info-sign',
			),
			array(
				'id'		=> 'sidebars-end',
				'type'		=> 'section',
				'title'		=> esc_html__( 'Sidebar Generator', 'redux-framework' ),
				'indent'	=> false,
			),
			array(
				'id'		=> 'sidebars2-start',
				'type'		=> 'section',
				'indent'	=> true,
			),
			array(
				'id'		=> 'unlimited_sidebar',
				'type'		=> 'multi_text',
				'title'		=> esc_html__( 'Sidebar generator', 'redux-framework' ),
				'validate'	=> 'no_html',
				'subtitle'	=> esc_html__( 'Enter a name ', 'redux-framework' ) . '<strong>' . esc_html__( '(Without special characters)', 'redux-framework' ) . '</strong>' . esc_html__( ' for the sidebar, then click on ', 'redux-framework' ) . '<i>' . esc_html__( '"add more"', 'redux-framework' ) . '</i>' . esc_html__( ' to add a new sidebar.', 'redux-framework' ),
				'default'	=> '',
			),
			array(
				'id'		=> 'sidebars-end',
				'type'		=> 'section',
				'indent'	=> false,
			),
			array(
				'id'     => 'section-functions-fixed-sidebar-start',
				'type'   => 'section',
				'title' => esc_html__( 'Fixed Sidebar', 'redux-framework' ),
				'indent' => true,
			),
			array(
				'id' => 'func_fixed_sidebar',
				'type' => 'switch',
				'title' => esc_html__( 'Fixed Sidebar (Functions)', 'redux-framework' ),
				'subtitle' => esc_html__( 'enable or disable the fixed sidebar function.', 'redux-framework' ),
				'default' => '1'
			),
			array(
				'id'     => 'section-functions-fixed-sidebar-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );

	
	Redux::setSection( $opt_name, array(
		'title'			=> '',
		'type'			=> 'divide',
	) );
	
	
	function encodeURIComponent($str) {
		$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
		return strtr(rawurlencode($str), $revert);
	}
	$theme_doc = '<iframe src="http://exito.evatheme.com/docs/" style="width:90%;height:800px"></iframe>';
	
	Redux::setSection( $opt_name, array(
		'icon'			=> 'dashicons dashicons-book-alt',
		'title'			=> esc_html__( 'Documentation', 'redux-framework' ),
		'heading'		=> esc_html__( 'Exito Documentation', 'redux-framework' ), 
		'fields'		=> array(
			array(
				'id'		=> '1000',
				'type'		=> 'raw',
				'content'	=> $theme_doc,
			)
		),
	) );
	
    
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'redux-framework' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

