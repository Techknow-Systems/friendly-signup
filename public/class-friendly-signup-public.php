<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://au.linkedin.com/in/shaarobtaylor
 * @since      0.1.0
 *
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/public
 * @author     Shaa Taylor <shaa@techknowsystems.com.au>
 */
class Friendly_Signup_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The settings / options for the plugib - stored in the options table as an array.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $settings    The settings / options for the plugin.
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->general_settings = get_option ($this->plugin_name . '-general');
		$this->slidein_settings = get_option ($this->plugin_name . '-slidein');
		$this->popup_settings = get_option ($this->plugin_name . '-popup');

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Friendly_Signup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Friendly_Signup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Plugin specific styles
		wp_register_style ($this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/friendly-signup-public.css', array(), $this->version, 'all');

		// User styles added via the options page
		wp_register_style ($this->plugin_name . '-public-slidein-edits', plugin_dir_url( __FILE__ ) . 'css/friendly-signup-public-slidein-edits.css', array(), $this->version, 'all');
		wp_register_style ($this->plugin_name . '-public-popup-edits', plugin_dir_url( __FILE__ ) . 'css/friendly-signup-public-popup-edits.css', array(), $this->version, 'all');
		wp_register_style ($this->plugin_name . '-public-squeeze-form-edits', plugin_dir_url( __FILE__ ) . 'css/friendly-signup-public-squeeze-form-edits.css', array(), $this->version, 'all');

		// Enqueue all styles
		wp_enqueue_style ($this->plugin_name);
		wp_enqueue_style ($this->plugin_name . '-public-slidein-edits');
		wp_enqueue_style ($this->plugin_name . '-public-popup-edits');
		wp_enqueue_style ($this->plugin_name . '-public-squeeze-form-edits');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Friendly_Signup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Friendly_Signup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Pass through the plugin URL to jQuery
		$URL_array = array (
			'plugin_url' => FRIENDLY_SIGNUP_URL,
		);

		// JSCookie (External Library)
  		wp_register_script ($this->plugin_name . '-cookie', plugin_dir_url (__FILE__) . 'lib/js-cookie/js.cookie.js', array('jquery'), '2.2.0', true );

  		// Plugin specific script
		wp_register_script ($this->plugin_name, plugin_dir_url (__FILE__) . 'js/friendly-signup-public.js', array( 'jquery', $this->plugin_name . '-cookie'), $this->version, false);

		// Enqueue all scripts
		wp_localize_script ($this->plugin_name, 'url_obj', $URL_array);
		wp_enqueue_script ($this->plugin_name);

	}

	/**
	 * Registers all the plugin shortcodes 
	 *
	 * @since 		0.1.0
	 * @return 		none
	 */
	public function register_shortcodes () {

		// Class for all shortcode functions
		$shortcodes = new Friendly_Signup_Public_Shortcodes ($this->plugin_name, $this->version);

		// Define all the available shortcodes
		add_shortcode ('squeeze_signup_form', array ($shortcodes, 'create_squeeze_form'));

	}

	/**
	 * Adds a signup form just beforw the </body> so that we can slide it in.
	 *
	 * @since 		0.1.0
	 * @return 		none
	 */
	public function add_slidein_signup_form () {

		$slidein_form_HTML = '';

		if ($this->slidein_settings['slidein_active_on'] == 'Y') {
			$slidein_form_HTML = '<!-- Friendly Signup: SLIDE IN SIGNUP FORM -->';
			$slidein_form_HTML .= '<div id="fsup-slidein-signup">';
				$slidein_form_HTML .= '<a class="fsup-slidein-close"></a>';
				$slidein_form_HTML .= '<h3>' . $this->slidein_settings['slidein_title'] . '</h3>';
	    		$slidein_form_HTML .= '<div id="fsup-slidein-body">';
	        		$slidein_form_HTML .= '<fieldset>';
	            		$slidein_form_HTML .= '<form id="fsup-slidein-mc-subscribe" name="fsup-slidein-mc-subscribe" method="post" action="#" target="_blank">';
	                		$slidein_form_HTML .= '<input type="email" name="email" class="required email" placeholder="email address...">';
	                		$slidein_form_HTML .= '<span style="width: 5%">&nbsp;</span>';
	                		$slidein_form_HTML .= '<input type="submit" value="Sign Up" name="signup" id="fsup-mc-subscribe-button" class="button"><br>';
	                		//$slidein_form_HTML .= '<input type="checkbox" name="digest" value="Yes" checked="true"><span class="fsup-slidein-checkbox-text" style="font-size: 16px; margin-top: 3px;">Include Weekly Digest</span>';
	                		$slidein_form_HTML .= '<input type="hidden" value="UPLIFT" name="list">';
	            		$slidein_form_HTML .= '</form>';
	        		$slidein_form_HTML .= '</fieldset>';
	        		$slidein_form_HTML .= '<p class="fsup-slidein-text">' . $this->slidein_settings['slidein_form_text'] . '</p>';
	    		$slidein_form_HTML .= '</div>';
			$slidein_form_HTML .= '</div>';
			$slidein_form_HTML .= '<!-- END: SLIDE IN SIGNUP FORM -->';
		}

		echo $slidein_form_HTML;

	}

	/**
	 * Adds a signup form just beforw the </body> so that we can pop it up.
	 *
	 * @since 		0.1.0
	 * @return 		none
	 */
	public function add_popup_signup_form () {

		$popup_form_HTML = '';

		if ($this->popup_settings['popup_active_on'] == 'Y') {

			$popup_form_HTML = '<!-- Friendly Signup: POPUP SIGNUP FORM -->';
			$popup_form_HTML .= '<div id="fsup-popup" class="fsup-popup-overlay">';
				$popup_form_HTML .= '<div class="fsup-popup-signup">';
					$popup_form_HTML .= '<div class="fsup-popup-title">';
						$popup_form_HTML .= '<h3>' . $this->popup_settings['popup_title'] . '</h3>';
					$popup_form_HTML .= '</div>';
					$popup_form_HTML .= '<div class="fsup-popup-before-text">';
						$popup_form_HTML .= '<p>' . $this->popup_settings['popup_before_form_text'] . '</p>';
					$popup_form_HTML .= '</div>';
		    		$popup_form_HTML .= '<div id="fsup-popup-body">';
		        		$popup_form_HTML .= '<fieldset>';
		            		$popup_form_HTML .= '<form id="fsup-popup-mc-subscribe" name="fsup-popup-mc-subscribe" class="validate mc-signup-form" method="post" action="#" target="_blank">';
		                		$popup_form_HTML .= '<input type="email" name="email" class="required email" placeholder="email address...">';
		                		$popup_form_HTML .= '<input type="submit" value="' . $this->popup_settings['popup_button_text'] . '" name="signup" id="fsup-mc-subscribe-button" class="button"><br>';
		                		$popup_form_HTML .= '<input type="hidden" value="single" name="optin">';
		            		$popup_form_HTML .= '</form>';
		        		$popup_form_HTML .= '</fieldset>';
		        		$popup_form_HTML .= '<p class="fsup-popup-after-text">' . $this->popup_settings['popup_after_form_text'] . '</p>';
		        		$popup_form_HTML .= '<p class="fsup-popup-error">&nbsp</p>';
		    		$popup_form_HTML .= '</div>';
				$popup_form_HTML .= '</div>';
			$popup_form_HTML .= '<a class="fsup-popup-close"></a>';
			$popup_form_HTML .= '</div>';
			$popup_form_HTML .= '<!-- END: POPUP SIGNUP FORM -->';
		}

		echo $popup_form_HTML;

	}

}
