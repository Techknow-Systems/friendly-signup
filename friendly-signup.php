<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://au.linkedin.com/in/shaarobtaylor
 * @since             0.1.1
 * @package           Friendly_Signup
 *
 * @wordpress-plugin
 * Plugin Name:       Friendly Signup
 * Plugin URI:        https://techknowsystems.com.au/plugins/friendly-signup
 * Description:       Entice ans inspire your website users to signup to your email lists without being too in their face. Give them value first, so they know what they are getting from you and why they are signing up. It makes a refreshing change!
 * Version:           0.1.4
 * Author:            Shaa Taylor
 * Author URI:        https://au.linkedin.com/in/shaarobtaylor
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       friendly-signup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Used for referring to the plugin file or basename
if ( ! defined( 'FRIENDLY_SIGNUP_BASE' ) ) {
	define( 'FRIENDLY_SIGNUP_BASE', plugin_basename (__FILE__));
}

if ( ! defined( 'FRIENDLY_SIGNUP_BASE_FILE' ) ) {
	define( 'FRIENDLY_SIGNUP_BASE_FILE', plugin_dir_path (__FILE__));
}

// Used for referring to the plugin file or basename
if ( ! defined( 'FRIENDLY_SIGNUP_URL' ) ) {
	define( 'FRIENDLY_SIGNUP_URL', plugin_dir_url (__FILE__));
}

/**
 * Currently plugin version.
 * Start at version 0.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if ( defined( 'FRIENDLY_SIGNUP_VERSION' ) ) {
	define( 'FRIENDLY_SIGNUP_VERSION', '0.1.4' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-friendly-signup-activator.php
 */
function activate_Friendly_Signup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-friendly-signup-activator.php';
	Friendly_Signup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-friendly-signup-deactivator.php
 */
function deactivate_Friendly_Signup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-friendly-signup-deactivator.php';
	Friendly_Signup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Friendly_Signup' );
register_deactivation_hook( __FILE__, 'deactivate_Friendly_Signup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-friendly-signup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_Friendly_Signup() {

	$plugin = new Friendly_Signup();
	$plugin->run();

}
run_Friendly_Signup();
