<?php

/**
 * The shortcode definitions for UPLIFT Check User.
 *
 * @link 		http://www.techknowsystems.com.au
 * @since 		0.1.0
 *
 * @package 	Friendly_Signup
 * @subpackage 	Friendly_Signup/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/public
 * @author     Shaa Taylor <shaa@uplift.global>
 */
class Friendly_Signup_Public_Shortcodes {

	/**
	 * The ID of this plugin.
	 *
	 * @since 		0.1.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 		0.1.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;

	/**
	 * The settings for the plugin set by the admin page.
	 *
	 * @since 		0.1.0
	 * @access 		private
	 * @var 		string 			$options 			Contains all plugin settings
	 */
	private $options;

	/**
	 * The current POST ID that we are viewing.
	 *
	 * @since 		0.1.0
	 * @access 		private
	 * @var 		string 			$postID 			The ID of the current post.
	 */
	private $postID;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		0.1.0
	 * @param 		string 			$plugin_name 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	    $currentURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    $this->postID = url_to_postid ($currentURL);
	    $this->options = get_option ($this->plugin_name);

	}

	// Below are all the shortcode functions

	/**
	 * Creates a Squeeze Page style sign-up form 
	 *
	 * @since 		0.1.0
	 * @return 		none
	 */
	public function create_squeeze_form () {

		// At the moment, do nothing!

	}

}
