<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Exito for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_template_directory_uri() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'exito_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function exito_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
	
		array(
			'name'     				=> esc_attr__('Contact Form 7', 'exito'),
			'slug'     				=> 'contact-form-7',
			'required' 				=> false,
			'version'            	=> '4.8',
            'force_activation'      => false,
            'force_deactivation'    => false,
		),
		
		array(
            'name'          		=> esc_attr__('WPBakery Visual Composer', 'exito'),
            'slug'          		=> 'js_composer',
            'source'            	=> get_template_directory() . '/inc/plugins/js_composer.zip',
            'required'   	        => true,
            'version'       	    => '5.2',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
		
        array(
            'name'         			=> esc_attr__('Ultimate VC Addons', 'exito'),
            'slug'          		=> 'Ultimate_VC_Addons',
            'source'            	=> get_template_directory() . '/inc/plugins/Ultimate_VC_Addons.zip',
            'required'          	=> true,
            'version'           	=> '3.16',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
		
        array(
            'name'          		=> esc_attr__('Evatheme Custom Post Types', 'exito'),
            'slug'          		=> 'evatheme-cpt',
            'source'            	=> get_template_directory() . '/inc/plugins/evatheme-cpt.zip',
            'required'          	=> true,
            'version'           	=> '1.0',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
		
        array(
            'name'          		=> esc_attr__('Revolution Slider', 'exito'),
            'slug'          		=> 'revslider',
            'source'            	=> get_template_directory() . '/inc/plugins/revslider.zip',
            'required'          	=> false,
            'version'           	=> '5.4',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
		
		array(
			'name'     				=> esc_attr__('Evatheme Redux Framework', 'exito'),
			'slug'     				=> 'evatheme-redux-framework',
			'source'            	=> get_template_directory() . '/inc/plugins/evatheme-redux-framework.zip',
			'required' 				=> true,
			'version'            	=> '3.6',
            'force_activation'      => false,
            'force_deactivation'    => false,
		),
		
		array(
			'name'     				=> esc_attr__('Evatheme VC Extension', 'exito'),
			'slug'     				=> 'evatheme-vc-extension',
			'source'            	=> get_template_directory() . '/inc/plugins/evatheme-vc-extension.zip',
			'required' 				=> true,
			'version'            	=> '1.0',
            'force_activation'      => false,
            'force_deactivation'    => false,
		)
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'exito',            // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}