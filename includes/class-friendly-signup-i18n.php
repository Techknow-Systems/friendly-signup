<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://au.linkedin.com/in/shaarobtaylor
 * @since      0.1.0
 *
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.0
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/includes
 * @author     Shaa Taylor <shaa@techknowsystems.com.au>
 */
class Friendly_Signup_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'friendly-signup',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
