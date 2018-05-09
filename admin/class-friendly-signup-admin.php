<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://au.linkedin.com/in/shaarobtaylor
 * @since      0.1.0
 *
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/admin
 * @author     Shaa Taylor <shaa@techknowsystems.com.au>
 */
class Friendly_Signup_Admin {

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
	 * The settings (options) for the plugin, defined on the settings page.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $settings   Hold the settings for the Admin page.
	 */
	private $mailchimp_settings;
	private $cookie_settings;
	private $slidein_settings;
	private $popup_settings;

	/**
	 * The settings (options) for the plugin, defined on the settings page.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $settings   Holds the settings prefix for the Admin page.
	 */
	private $settings_prefix;

	/**
	 * The active tab on the settings page.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $active_tab   Hold the acyive tab index for the Admin page.
	 */
	private $active_tab;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->mailchimp_settings = get_option($this->plugin_name . '-mailchimp');
		$this->cookie_settings = get_option($this->plugin_name . '-cookie');
		$this->slidein_settings = get_option($this->plugin_name . '-slidein');
		$this->popup_settings = get_option($this->plugin_name . '-popup');
		$this->settings_prefix = 'fsup_';
		$this->active_tba = 'general';

	}

	/**
	 * Register the stylesheets for the admin area.
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

		// Freindly Signup Plugin specific styles
		wp_register_style ($this->plugin_name, plugin_dir_url (__FILE__) . 'css/friendly-signup-admin.css', array(), $this->version, 'all');

		// Codemirror
		wp_register_style ($this->plugin_name . '-codemirror', plugin_dir_url (__FILE__) . 'lib/codemirror/src/codemirror.css', array(), '5.37.0', 'all');
		wp_register_style ($this->plugin_name . '-codemirror-theme', plugin_dir_url (__FILE__) . 'lib/codemirror/theme/neo.css', array(), '5.37.0', 'all');
		wp_register_style ($this->plugin_name . '-codemirror-lint', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/lint/lint.css', array(), '5.37.0', 'all');
		wp_register_style ($this->plugin_name . '-codemirror-fold', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/fold/foldgutter.css', array(), '5.37.0', 'all');

		// Enqueue all styles
		wp_enqueue_style ('wp-color-picker'); // Wordpress colour icker API
		wp_enqueue_style ($this->plugin_name);
		wp_enqueue_style ($this->plugin_name . '-codemirror');
		wp_enqueue_style ($this->plugin_name . '-codemirror-theme');
		wp_enqueue_style ($this->plugin_name . '-codemirror-lint');
		wp_enqueue_style ($this->plugin_name . '-codemirror-fold');

	}

	/**
	 * Register the JavaScript for the admin area.
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

		// Friendly Signup Plugin specific scripts
		wp_register_script ($this->plugin_name, plugin_dir_url (__FILE__) . 'js/friendly-signup-admin.js', array('jquery', 'wp-color-picker'), $this->version, true);

		// Codemirror
		wp_register_script ($this->plugin_name . '-codemirror-js', plugin_dir_url (__FILE__) . 'lib/codemirror/src/codemirror.js', array(), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-mode', plugin_dir_url (__FILE__) . 'lib/codemirror/mode/css.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-addon-active-line', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/active-line.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-addon-close-brackets', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/closebrackets.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-addon-match-brackets', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/matchbrackets.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);
		// Linting
		wp_register_script ($this->plugin_name . '-csslint', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/lint/csslint.js', array(), '1.0.5', true);
		wp_register_script ($this->plugin_name . '-codemirror-lint', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/lint/lint.js', array(), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-css-lint', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/lint/css-lint.js', array(), '5.37.0', true);
		// Code Folding
		wp_register_script ($this->plugin_name . '-codemirror-addon-fold-gutter', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/fold/foldgutter.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-addon-fold-code', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/fold/foldcode.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-addon-fold-comments', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/fold/comment-fold.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);
		wp_register_script ($this->plugin_name . '-codemirror-addon-fold-brace', plugin_dir_url (__FILE__) . 'lib/codemirror/addons/fold/brace-fold.js', array($this->plugin_name . '-codemirror-js'), '5.37.0', true);

		// Enqueue all scripts
		wp_enqueue_script ($this->plugin_name);
		wp_enqueue_script ($this->plugin_name . '-codemirror-js');
		wp_enqueue_script ($this->plugin_name . '-codemirror-mode');
		wp_enqueue_script ($this->plugin_name . '-codemirror-addon-active-line');
		wp_enqueue_script ($this->plugin_name . '-codemirror-addon-close-brackets');
		wp_enqueue_script ($this->plugin_name . '-codemirror-addon-match-brackets');
		wp_enqueue_script ($this->plugin_name . '-csslint');
		wp_enqueue_script ($this->plugin_name . '-codemirror-lint');
		wp_enqueue_script ($this->plugin_name . '-codemirror-css-lint');
		wp_enqueue_script ($this->plugin_name . '-codemirror-addon-fold-gutter');
		wp_enqueue_script ($this->plugin_name . '-codemirror-addon-fold-code');
		wp_enqueue_script ($this->plugin_name . '-codemirror-addon-fold-comments');
		wp_enqueue_script ($this->plugin_name . '-codemirror-addon-fold-brace');

	}

	/**
	 * Adds a 'Settings' link to the plugin on the 'Installed Plugins' page.
	 *
	 * @since    1.0.0
	 */
	public function add_settings_link($links) {

		$settings_link = sprintf ('<a href="%s">%s</a>', esc_url (admin_url ('options-general.php?page=' . $this->plugin_name)), esc_html__( 'Settings', $this->plugin_name));
		array_unshift ($links, $settings_link);
		return $links;

	}

	/**
	 * Adds a settings page under the 'Settings' menu
	 *
	 * @since    1.0.0
	 */
	public function add_settings_page() {

		$hookSuffix = add_options_page (
			__('Friendly Signup Settings', $this->plugin_name), 
			__('Friendly Signup', $this->plugin_name), 
			'manage_options',
			$this->plugin_name,
			array ($this, 'display_settings_page')
		);

	}  // add_options_page

	/**
	 * Adds a settings page under the 'Settings' menu
	 *
	 * @since    1.0.0
	 */
	public function add_settings() {

		// Register the option 'friendly-signup-mailchimp' in the options table
		register_setting (
			$this->plugin_name . '-mailchimp',  // Option Grouo
			$this->plugin_name . '-mailchimp',  // Option Name
			array (
				'type'				=> 'string',
				'description'		=> 'Mailchimp settings for the friendly-signup plugin.',
				'sanitize_callback'	=> array($this, $this->settings_prefix . 'mailchimp_validate'),
			) // Arguements including callback
		);

		// Mailchimp Settings Section'
		add_settings_section (
			$this->settings_prefix . 'mailchimp',  // ID
			__('Mailchimp Settings', $this->plugin_name),  // Title
			array ($this, $this->settings_prefix . 'mailchimp_section_text'),  // Callback
			$this->plugin_name .'-mailchimp'  // Page
		);

		// Add the settings field 'fsup_mc_api_key' field
		add_settings_field (
			$this->plugin_name . '_mc_api_key',  // ID
			__('Mailchimp API Key', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'mc_api_key_input'),  // Callback
			$this->plugin_name .'-mailchimp' ,  // Page
			$this->settings_prefix . 'mailchimp',  // Section
			array ('label for' => $this->plugin_name . '_mc_api_key')  // Arguements for callback
		);

		// Add the settings field 'fsup_mc_list_id' field
		add_settings_field (
			$this->plugin_name . '_mc_list_id',  // ID
			__('Mailchimp List ID', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'mc_list_id_input'),  // Callback
			$this->plugin_name .'-mailchimp' ,  // Page
			$this->settings_prefix . 'mailchimp',  // Section
			array ('label for' => $this->plugin_name . '_mc_list_id')  // Arguements for callback
		);

		// Add the settings field 'fsup_success_msg' field
		add_settings_field (
			$this->plugin_name . '_success_msg',  // ID
			__('Mailchimp Success Message', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'success_msg_input'),  // Callback
			$this->plugin_name .'-mailchimp' ,  // Page
			$this->settings_prefix . 'mailchimp',  // Section
			array ('label for' => $this->plugin_name . '_success_msg')  // Arguements for callback
		);

		// Add the settings field 'fsup_success_on_list_msg' field
		add_settings_field (
			$this->plugin_name . '_success_on_list_msg',  // ID
			__('Mailchimp Success Message (On List Already)', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'success_on_list_msg_input'),  // Callback
			$this->plugin_name .'-mailchimp' ,  // Page
			$this->settings_prefix . 'mailchimp',  // Section
			array ('label for' => $this->plugin_name . '_success_on_list_msg')  // Arguements for callback
		);

		// Add the settings field 'fsup_failure_invalid_msg' field
		add_settings_field (
			$this->plugin_name . '_failure_invalid_msg',  // ID
			__('Mailchimp Failure Message (Invalid Email Address)', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'failure_invalid_msg_input'),  // Callback
			$this->plugin_name .'-mailchimp' ,  // Page
			$this->settings_prefix . 'mailchimp',  // Section
			array ('label for' => $this->plugin_name . '_failure_invalid_msg')  // Arguements for callback
		);

		// Add the settings field 'fsup_failure_unknown_msg' field
		add_settings_field (
			$this->plugin_name . '_failure_unknown_msg',  // ID
			__('Mailchimp Failure Message (Unknown)', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'failure_unknown_msg_input'),  // Callback
			$this->plugin_name .'-mailchimp' ,  // Page
			$this->settings_prefix . 'mailchimp',  // Section
			array ('label for' => $this->plugin_name . '_failure_unknown_msg')  // Arguements for callback
		);

		// Register the option 'friendly-signup-slidein' in the options table
		register_setting (
			$this->plugin_name . '-slidein',  // Option Grouo
			$this->plugin_name . '-slidein',  // Option Name
			array (
				'type'				=> 'string',
				'description'		=> 'Slide In settings for the friendly-signup plugin.',
				'sanitize_callback'	=> array($this, $this->settings_prefix . 'slidein_validate'),
			) // Arguements including callback
		);

		// Slide In Signup Form Settings Section
		add_settings_section (
			$this->settings_prefix . 'slidein_section',  // ID
			__('Slide In Signup Form Settings', $this->plugin_name),  // Title
			array ($this, $this->settings_prefix . 'slidein_section_text'),  // Callback
			$this->plugin_name . '-slidein' // Page
		);

		// Add the settings field 'fsup_slidein_title'
		add_settings_field (
			$this->plugin_name . '_slidein_title',  // ID
			__('Slide In Title', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'slidein_title_input'),  // Callback
			$this->plugin_name . '-slidein',  // Page
			$this->settings_prefix . 'slidein_section',  // Section
			array ('label for' => $this->plugin_name . '_slidein_title')  // Arguements for callback
		);

		// Add the settings field 'fsup_slidein_form_text'
		add_settings_field (
			$this->plugin_name . '_slidein_form_text',  // ID
			__('Slide In Form Text', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'slidein_form_text_input'),  // Callback
			$this->plugin_name . '-slidein',  // Page
			$this->settings_prefix . 'slidein_section',  // Section
			array ('label for' => $this->plugin_name . '_slidein_form_text')  // Arguements for callback
		);

		// Add the settings field 'fsup_popup_button_text'
		add_settings_field (
			$this->plugin_name . '_slidein_button_text',  // ID
			__('Button Text', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'slidein_button_text_input'),  // Callback
			$this->plugin_name . '-slidein',  // Page
			$this->settings_prefix . 'slidein_section',  // Section
			array ('label for' => $this->plugin_name . '_slidein_button_text')  // Arguements for callback
		);

		// Add the settings field 'fsup_popup_after_form_text'
		add_settings_field (
			$this->plugin_name . '_slidein_button_colour',  // ID
			__('Button Colour', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'slidein_button_colour_input'),  // Callback
			$this->plugin_name . '-slidein',  // Page
			$this->settings_prefix . 'slidein_section',  // Section
			array ('label for' => $this->plugin_name . '_slidein_button_colour')  // Arguements for callback
		);

		// Add the settings field 'fsup_slidein_active_on'
		add_settings_field (
			$this->plugin_name . '_slidein_active_on',  // ID
			__('Active On', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'slidein_active_on_input'),  // Callback
			$this->plugin_name . '-slidein',  // Page
			$this->settings_prefix . 'slidein_section',  // Section
			array ('label for' => $this->plugin_name . '_slidein_active_on')  // Arguements for callback
		);

		// Add the settings field 'fsup_slidein_active_on'
		add_settings_field (
			$this->plugin_name . '_slidein_css',  // ID
			__('CSS Edits', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'slidein_css_input'),  // Callback
			$this->plugin_name . '-slidein',  // Page
			$this->settings_prefix . 'slidein_section',  // Section
			array ('label for' => $this->plugin_name . '_slidein_css')  // Arguements for callback
		);

		// Register the option 'friendly-signup-popup' in the options table
		register_setting (
			$this->plugin_name . '-popup',  // Option Grouo
			$this->plugin_name . '-popup',  // Option Name
			array (
				'type'				=> 'string',
				'description'		=> 'Popup settings for the friendly-signup plugin.',
				'sanitize_callback'	=> array($this, $this->settings_prefix . 'popup_validate'),
			) // Arguements including callback
		);

		// Popup Settings Section'
		add_settings_section (
			$this->settings_prefix . 'popup_section',  // ID
			__('Popup Settings', $this->plugin_name),  // Title
			array ($this, $this->settings_prefix . 'popup_section_text'),  // Callback
			$this->plugin_name .'-popup'  // Page
		);

		// Add the settings field 'fsup_popup_title' field
		add_settings_field (
			$this->plugin_name . '_popup_title',  // ID
			__('Popup Title', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'popup_title_input'),  // Callback
			$this->plugin_name .'-popup' ,  // Page
			$this->settings_prefix . 'popup_section',  // Section
			array ('label for' => $this->plugin_name . '_popup_title')  // Arguements for callback
		);

		// Add the settings field 'fsup_popup_before_form_text'
		add_settings_field (
			$this->plugin_name . '_popup_before_form_text',  // ID
			__('Popup (Before) Form Text', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'popup_before_form_text_input'),  // Callback
			$this->plugin_name . '-popup',  // Page
			$this->settings_prefix . 'popup_section',  // Section
			array ('label for' => $this->plugin_name . '_popup_before_form_text')  // Arguements for callback
		);

		// Add the settings field 'fsup_popup_after_form_text'
		add_settings_field (
			$this->plugin_name . '_popup_after_form_text',  // ID
			__('Popup (After) Form Text', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'popup_after_form_text_input'),  // Callback
			$this->plugin_name . '-popup',  // Page
			$this->settings_prefix . 'popup_section',  // Section
			array ('label for' => $this->plugin_name . '_popup_after_form_text')  // Arguements for callback
		);

		// Add the settings field 'fsup_popup_button_text'
		add_settings_field (
			$this->plugin_name . '_popup_button_text',  // ID
			__('Button Text', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'popup_button_text_input'),  // Callback
			$this->plugin_name . '-popup',  // Page
			$this->settings_prefix . 'popup_section',  // Section
			array ('label for' => $this->plugin_name . '_popup_button_text')  // Arguements for callback
		);

		// Add the settings field 'fsup_popup_after_form_text'
		add_settings_field (
			$this->plugin_name . '_popup_button_colour',  // ID
			__('Button Colour', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'popup_button_colour_input'),  // Callback
			$this->plugin_name . '-popup',  // Page
			$this->settings_prefix . 'popup_section',  // Section
			array ('label for' => $this->plugin_name . '_popup_button_colour')  // Arguements for callback
		);

		// Add the settings field 'fsup_popup_active_on'
		add_settings_field (
			$this->plugin_name . '_popup_active_on',  // ID
			__('Active On', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'popup_active_on_input'),  // Callback
			$this->plugin_name . '-popup',  // Page
			$this->settings_prefix . 'popup_section',  // Section
			array ('label for' => $this->plugin_name . '_popup_active_on')  // Arguements for callback
		);

		// Add the settings field 'fsup_slidein_active_on'
		add_settings_field (
			$this->plugin_name . '_popup_css',  // ID
			__('CSS Edits', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'popup_css_input'),  // Callback
			$this->plugin_name . '-popup',  // Page
			$this->settings_prefix . 'popup_section',  // Section
			array ('label for' => $this->plugin_name . '_popup_css')  // Arguements for callback
		);

		// Register the option 'friendly-signup-cookie' in the options table
		register_setting (
			$this->plugin_name . '-cookie',  // Option Grouo
			$this->plugin_name . '-cookie',  // Option Name
			array (
				'type'				=> 'string',
				'description'		=> 'Cookie settings for the friendly-signup plugin.',
				'sanitize_callback'	=> array($this, $this->settings_prefix . 'cookie_validate'),
			) // Arguements including callback
		);

		// Cookie Settings Section'
		add_settings_section (
			$this->settings_prefix . 'cookie_section',  // ID
			__('Popup Settings', $this->plugin_name),  // Title
			array ($this, $this->settings_prefix . 'cookie_section_text'),  // Callback
			$this->plugin_name .'-cookie'  // Page
		);

		// Add the settings field 'fsup_cookie_name' field
		add_settings_field (
			$this->plugin_name . '_cookie_name',  // ID
			__('Cookie Name', $this->plugin_name),  // Label
			array ($this, $this->settings_prefix . 'cookie_name_input'),  // Callback
			$this->plugin_name .'-cookie' ,  // Page
			$this->settings_prefix . 'cookie_section',  // Section
			array ('label for' => $this->plugin_name . '_cookie_name')  // Arguements for callback
		);

	}

	/**
	 * The content for the settings page
	 *
	 * The HTML + PHP is stored in a separate file to segment and easy editing
	 *
	 * @since    1.0.0
	 */
	public function display_settings_page () {

		include_once 'partials/friendly-signup-admin-display.php';

	} // create_settings_page

	/**
	 * Renders the text for the 'Mailchimp' section
	 *
	 * @since    0.1.0
	 */
	public function fsup_mailchimp_section_text() {

		echo '<p>' . __('Set all Mailchimp related settings here so that your people sign up to the correct list.', $this->plugin_name) . '</p>';

	}

	/**
	 * Renders the Mailchimp API Key field for the Mailchimp section
	 *
	 * @since    0.1.0
	 */
	public function fsup_mc_api_key_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->mailchimp_settings["mc_api_key"] = (isset ($this->mailchimp_settings["mc_api_key"])) ? $this->mailchimp_settings["mc_api_key"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_mc_api_key" name="' . $this->plugin_name . '-mailchimp[mc_api_key]" value="' . $this->mailchimp_settings["mc_api_key"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">You can find your Mailchimp API key <a href="https://kb.mailchimp.com/integrations/api-integrations/about-api-keys" target="_blank">here</a>.</p>';
     	$this->mailchimp_settings['mc_api_key'] = esc_attr ($this->mailchimp_settings['mc_api_key']);

	}

	/**
	 * Renders the Mailchimp List ID field for the Mailchimp section
	 *
	 * @since    0.1.0
	 */
	public function fsup_mc_list_id_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->mailchimp_settings["mc_list_id"] = (isset ($this->mailchimp_settings["mc_list_id"])) ? $this->mailchimp_settings["mc_list_id"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_mc_list_id" name="' . $this->plugin_name . '-mailchimp[mc_list_id]" value="' . $this->mailchimp_settings["mc_list_id"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">Follow <a href="https://kb.mailchimp.com/lists/manage-contacts/find-your-list-id" target="_blank">these instrcutions</a> for locating your Mailchimp List ID.</p>';
     	$this->mailchimp_settings['mc_list_id'] = esc_attr ($this->mailchimp_settings['mc_list_id']);

	}

	/**
	 * Renders the Mailchimp Success Message field for the Mailchimp section
	 *
	 * @since    0.1.0
	 */
	public function fsup_success_msg_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->mailchimp_settings["success_msg"] = (isset ($this->mailchimp_settings["success_msg"])) ? $this->mailchimp_settings["success_msg"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_success_msg" name="' . $this->plugin_name . '-mailchimp[success_msg]" value="' . $this->mailchimp_settings["success_msg"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The message displayed when user successfully signs up to your list for the first time.</p>';
     	$this->mailchimp_settings['success_msg'] = esc_attr ($this->mailchimp_settings['success_msg']);

	}

	/**
	 * Renders the Mailchimp Success Message (already on the list) field for the Mailchimp section
	 *
	 * @since    0.1.0
	 */
	public function fsup_success_on_list_msg_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->mailchimp_settings["success_on_list_msg"] = (isset ($this->mailchimp_settings["success_on_list_msg"])) ? $this->mailchimp_settings["success_on_list_msg"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_success_on_list_msg" name="' . $this->plugin_name . '-mailchimp[success_on_list_msg]" value="' . $this->mailchimp_settings["success_on_list_msg"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The message displayed when user is already on your list.</p>';
     	$this->mailchimp_settings['success_on_list_msg'] = esc_attr ($this->mailchimp_settings['success_on_list_msg']);

	}

	/**
	 * Renders the Mailchimp Failure Message field  due to entering an invalid email address for the Mailchimp section
	 *
	 * @since    0.1.0
	 */
	public function fsup_failure_invalid_msg_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->mailchimp_settings["failure_invalid_msg"] = (isset ($this->mailchimp_settings["failure_invalid_msg"])) ? $this->mailchimp_settings["failure_invalid_msg"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_failure_invalid_msg" name="' . $this->plugin_name . '-mailchimp[failure_invalid_msg]" value="' . $this->mailchimp_settings["failure_invalid_msg"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The message displayed when user fails to sign up to this list due to entering an invalid email address.</p>';
     	$this->mailchimp_settings['failure_invalid_msg'] = esc_attr ($this->mailchimp_settings['failure_invalid_msg']);

	}

	/**
	 * Renders the Mailchimp Success Message field for the Mailchimp section
	 *
	 * @since    0.1.0
	 */
	public function fsup_failure_unknown_msg_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->mailchimp_settings["faliure_unknown_msg"] = (isset ($this->mailchimp_settings["faliure_unknown_msg"])) ? $this->mailchimp_settings["faliure_unknown_msg"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_faliure_unknown_msg" name="' . $this->plugin_name . '-mailchimp[faliure_unknown_msg]" value="' . $this->mailchimp_settings["faliure_unknown_msg"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The message displayed when user fails to sign up to the list for an unknown reason. Leave blank for a message to be thrown from Mailchimp API.</p>';
     	$this->mailchimp_settings['faliure_unknown_msg'] = esc_attr ($this->mailchimp_settings['faliure_unknown_msg']);

	}

	/**
	 * Renders the text for the 'Slidein' section
	 *
	 * @since    0.1.0
	 */
	public function fsup_slidein_section_text() {

		echo '<p>' . __('Set all Slide In related settings here so that your slide in box shows the corrct information on it.', $this->plugin_name) . '</p>';

	}

	/**
	 * Renders the Slidein Title field for the Slidein section
	 *
	 * @since    0.1.0
	 */
	public function fsup_slidein_title_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->slidein_settings["slidein_title"] = (isset ($this->slidein_settings["slidein_title"])) ? $this->slidein_settings["slidein_title"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_slidein_title" name="' . $this->plugin_name . '-slidein[slidein_title]" value="' . $this->slidein_settings["slidein_title"] . '" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">Thtle shown within &lt;h2&gt; tags on the Slidein form</p>';
     	$this->slidein_settings['slidein_title'] = esc_attr ($this->slidein_settings['slidein_title']);

	}

	/**
	 * Renders the Slidein Form text field for the Slidein section
	 *
	 * @since    0.1.0
	 */
	public function fsup_slidein_form_text_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->slidein_settings["slidein_form_text"] = (isset ($this->slidein_settings["slidein_form_text"])) ? $this->slidein_settings["slidein_form_text"] : '';

		// Render the field
     	echo '<textarea id="' . $this->plugin_name .'_slidein_form_text" name="' . $this->plugin_name . '-slidein[slidein_form_text]" rows="2" style="width: 50%;">' . $this->slidein_settings["slidein_form_text"] . '</textarea>';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The text shown below the email address field on the Slidein Form. Limit to 150 characters.</p>';
     	$this->slidein_settings['slidein_form_text'] = esc_attr ($this->slidein_settings['slidein_form_text']);

	}

	/**
	 * Renders the Slide In Button Text field for the Popup section
	 *
	 * @since    0.1.4
	 */
	public function fsup_slidein_button_text_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->slidein_settings["slidein_button_text"] = (isset ($this->slidein_settings["slidein_button_text"])) ? $this->slidein_settings["slidein_button_text"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_slidein_button_text" name="' . $this->plugin_name . '-slidein[slidein_button_text]" value="' . $this->slidein_settings["slidein_button_text"] . '" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">Text to appear on the Slide In form Submit button.</p>';
     	$this->slidein_settings['slidein_button_text'] = esc_attr ($this->slidein_settings['slidein_button_text']);

	}

	/**
	 * Renders the Slide In Button Colour picker field for the slidein section
	 *
	 * @since    0.1.2
	 */
	public function fsup_slidein_button_colour_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->slidein_settings["slidein_button_colour"] = (isset ($this->slidein_settings["slidein_button_colour"])) ? $this->slidein_settings["slidein_button_colour"] : '';
		$this->slidein_settings["slidein_button_hover_colour"] = (isset ($this->slidein_settings["slidein_button_hover_colour"])) ? $this->slidein_settings["slidein_button_hover_colour"] : '';

		// Render the field
		echo '<div class="fsup-adm-colour-picker-container">';
     	echo '<input type="text" id="' . $this->plugin_name .'_slidein_button_colour" name="' . $this->plugin_name . '-slidein[slidein_button_colour]" value="' . $this->slidein_settings["slidein_button_colour"] . '" class="fsup-wp-colour-picker" />';
     	echo '&nbsp;&nbsp;&nbsp;';
     	echo '<input type="text" id="' . $this->plugin_name .'_slidein_button_hover_colour" name="' . $this->plugin_name . '-slidein[slidein_button_hover_colour]" value="' . $this->slidein_settings["slidein_button_hover_colour"] . '" class="fsup-wp-colour-picker" />';
     	echo '</div>';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The background colour and the hover colour of the Slide In Form Submit button.</p>';
     	$this->slidein_settings['slidein_button_colour'] = esc_attr ($this->slidein_settings['slidein_button_colour']);
     	$this->slidein_settings['slidein_button_hover_colour'] = esc_attr ($this->slidein_settings['slidein_button_hover_colour']);

	}

	/**
	 * Renders the Active On field for the Slidein section
	 *
	 * @since    0.1.0
	 */
	public function fsup_slidein_active_on_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->slidein_settings["slidein_active_on"] = (isset ($this->slidein_settings["slidein_active_on"])) ? $this->slidein_settings["slidein_active_on"] : '';

		// Render the field
     	echo '<select id="' . $this->plugin_name .'_slidein_active_on" name="' . $this->plugin_name . '-slidein[slidein_active_on]">';
     		echo '<option selected="selected" disabled="disabled">' . esc_attr ( __('Select Location'), $this->plugin_name) . '</option>';
     		echo '<option value="N"' . (('N' === $this->slidein_settings["slidein_active_on"]) ? 'selected="selected"' : '') . '>Nowhere on Site</option>'; 
     		echo '<option value="PG"' . (('PG' === $this->slidein_settings["slidein_active_on"]) ? 'selected="selected"' : '') . '>Pages Only</option>'; 
     		echo '<option value="PST"' . (('PST' === $this->slidein_settings["slidein_active_on"]) ? 'selected="selected"' : '') . '>Posts Only</option>'; 
     		echo '<option value="PGPST"' . (('PGPST' === $this->slidein_settings["slidein_active_on"]) ? 'selected="selected"' : '') . '>Pages and Posts</option>'; 
     		echo '<option value="Y"' . (('Y' === $this->slidein_settings["slidein_active_on"]) ? 'selected="selected"' : '') . '>Everywhere</option>'; 
     	echo '</select>';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">Where the slide in sign up box appears on your site</p>';
     	$this->slidein_settings['slidein_active_on'] = esc_attr ($this->slidein_settings['slidein_active_on']);

	}

	/**
	 * Renders the Slidein CSS Edits field for the Slidein section
	 *
	 * @since    0.1.4
	 */
	public function fsup_slidein_css_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->slidein_settings["slidein_css"] = (isset ($this->slidein_settings["slidein_css"])) ? $this->slidein_settings["slidein_css"] : '';

		// Render the field
     	echo '<textarea id="' . $this->plugin_name .'_slidein_css" name="' . $this->plugin_name . '-slidein[slidein_css]" rows="10" style="width: 40%;">' . $this->slidein_settings["slidein_css"] . '</textarea>';
     	$this->slidein_settings['slidein_css'] = esc_attr ($this->slidein_settings['slidein_css']);

	}

	/**
	 * Renders the text for the 'Popup' section
	 *
	 * @since    0.1.0
	 */
	public function fsup_popup_section_text() {

		echo '<p>' . __('Set all Popup related settings here so that your Popup has the correct information on it.', $this->plugin_name) . '</p>';

	}

	/**
	 * Renders the Popup Title field for the Popup section
	 *
	 * @since    0.1.0
	 */
	public function fsup_popup_title_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->popup_settings["popup_title"] = (isset ($this->popup_settings["popup_title"])) ? $this->popup_settings["popup_title"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_popup_title" name="' . $this->plugin_name . '-popup[popup_title]" value="' . $this->popup_settings["popup_title"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">You can find your Mailchimp API key <a href="https://kb.mailchimp.com/integrations/api-integrations/about-api-keys" target="_blank">here</a>.</p>';
     	$this->popup_settings['popup_title'] = esc_attr ($this->popup_settings['popup_title']);

	}

	/**
	 * Renders the Popup Before Form Text field for the Popup section
	 *
	 * @since    0.1.0
	 */
	public function fsup_popup_before_form_text_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->popup_settings["popup_before_form_text"] = (isset ($this->popup_settings["popup_before_form_text"])) ? $this->popup_settings["popup_before_form_text"] : '';

		// Render the field
     	echo '<textarea id="' . $this->plugin_name .'_popup_before_form_text" name="' . $this->plugin_name . '-popup[popup_before_form_text]" rows="2" style="width: 50%;">' . $this->popup_settings["popup_before_form_text"] . '</textarea>';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The text shown above the email address field on the Popup Form. Limit to 150 characters.</p>';
     	$this->popup_settings['popup_before_form_text'] = esc_attr ($this->popup_settings['popup_before_form_text']);

	}

	/**
	 * Renders the Popup After Form Text field for the Popup section
	 *
	 * @since    0.1.0
	 */
	public function fsup_popup_after_form_text_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->popup_settings["popup_after_form_text"] = (isset ($this->popup_settings["popup_after_form_text"])) ? $this->popup_settings["popup_after_form_text"] : '';

		// Render the field
     	echo '<textarea id="' . $this->plugin_name .'_popup_after_form_text" name="' . $this->plugin_name . '-popup[popup_after_form_text]" rows="2" style="width: 50%;">' . $this->popup_settings["popup_after_form_text"] . '</textarea>';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The text shown below the email address field on the Popup Form. Limit to 150 characters.</p>';
     	$this->popup_settings['popup_after_form_text'] = esc_attr ($this->popup_settings['popup_after_form_text']);

	}

	/**
	 * Renders the Popup Button Text field for the Popup section
	 *
	 * @since    0.1.2
	 */
	public function fsup_popup_button_text_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->popup_settings["popup_button_text"] = (isset ($this->popup_settings["popup_button_text"])) ? $this->popup_settings["popup_button_text"] : '';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_popup_button_text" name="' . $this->plugin_name . '-popup[popup_button_text]" value="' . $this->popup_settings["popup_button_text"] . '" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">Text to appear on the Popup form Submit button.</p>';
     	$this->popup_settings['popup_button_text'] = esc_attr ($this->popup_settings['popup_button_text']);

	}

	/**
	 * Renders the Popup Button Colour picker field for the Popup section
	 *
	 * @since    0.1.2
	 */
	public function fsup_popup_button_colour_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->popup_settings["popup_button_colour"] = (isset ($this->popup_settings["popup_button_colour"])) ? $this->popup_settings["popup_button_colour"] : '';
		$this->popup_settings["popup_button_hover_colour"] = (isset ($this->popup_settings["popup_button_hover_colour"])) ? $this->popup_settings["popup_button_hover_colour"] : '';

		// Render the field
 		echo '<div class="fsup-adm-colour-picker-container">';
    	echo '<input type="text" id="' . $this->plugin_name .'_popup_button_colour" name="' . $this->plugin_name . '-popup[popup_button_colour]" value="' . $this->popup_settings["popup_button_colour"] . '" class="fsup-wp-colour-picker" />';
    	echo '&nbsp;&nbsp;&nbsp;';
    	echo '<input type="text" id="' . $this->plugin_name .'_popup_button_hover_colour" name="' . $this->plugin_name . '-popup[popup_button_hover_colour]" value="' . $this->popup_settings["popup_button_hover_colour"] . '" class="fsup-wp-colour-picker" />';
    	echo '</div>';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The background colour and the hover colour of the Popup Form Submit button.</p>';
     	$this->popup_settings['popup_button_colour'] = esc_attr ($this->popup_settings['popup_button_colour']);
     	$this->popup_settings['popup_button_hover_colour'] = esc_attr ($this->popup_settings['popup_button_hover_colour']);

	}

	/**
	 * Renders the Active On field for the Popup section
	 *
	 * @since    0.1.0
	 */
	public function fsup_popup_active_on_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->slidein_settings["popup_active_on"] = (isset ($this->slidein_settings["popup_active_on"])) ? $this->slidein_settings["popup_active_on"] : '';

		// Render the field
     	echo '<select id="' . $this->plugin_name .'_popup_active_on" name="' . $this->plugin_name . '-popup[popup_active_on]">';
     		echo '<option selected="selected" disabled="disabled">' . esc_attr ( __('Select Location'), $this->plugin_name) . '</option>';
     		echo '<option value="N"' . (('N' === $this->popup_settings["popup_active_on"]) ? 'selected="selected"' : '') . '>Nowhere on Site</option>'; 
     		echo '<option value="PG"' . (('PG' === $this->popup_settings["popup_active_on"]) ? 'selected="selected"' : '') . '>Pages Only</option>'; 
     		echo '<option value="PST"' . (('PST' === $this->popup_settings["popup_active_on"]) ? 'selected="selected"' : '') . '>Posts Only</option>'; 
     		echo '<option value="PGPST"' . (('PGPST' === $this->popup_settings["popup_active_on"]) ? 'selected="selected"' : '') . '>Pages and Posts</option>'; 
     		echo '<option value="Y"' . (('Y' === $this->popup_settings["popup_active_on"]) ? 'selected="selected"' : '') . '>Everywhere</option>'; 
     	echo '</select>';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">Where the popup sign up appears on your site</p>';
     	$this->popup_settings['popup_active_on'] = esc_attr ($this->popup_settings['popup_active_on']);

	}

	/**
	 * Renders the Popup CSS Edits field for the Slidein section
	 *
	 * @since    0.1.4
	 */
	public function fsup_popup_css_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->popup_settings["popup_css"] = (isset ($this->popup_settings["popup_css"])) ? $this->popup_settings["popup_css"] : '';

		// Render the field
     	echo '<textarea id="' . $this->plugin_name .'_popup_css" name="' . $this->plugin_name . '-popup[popup_css]" rows="10" style="width: 40%;">' . $this->popup_settings["popup_css"] . '</textarea>';
     	$this->popup_settings['popup_css'] = esc_attr ($this->popup_settings['popup_css']);

	}

	/**
	 * Renders the text for the 'Cookie' section
	 *
	 * @since    0.1.0
	 */
	public function fsup_cookie_section_text() {

		echo '<p>' . __('Set all the Cookie related settings here so that your cookie has all the information you need from the user signup process.', $this->plugin_name) . '</p>';

	}

	/**
	 * Renders the Cookie Name field for the Cookie section
	 *
	 * @since    0.1.0
	 */
	public function fsup_cookie_name_input () {

		// If this is the first time we have saved the settings, make sure the settings array is properly set
		$this->cookie_settings["cookie_name"] = (isset ($this->cookie_settings["cookie_name"])) ? $this->cookie_settings["cookie_name"] : 'friendly-signup';

		// Render the field
     	echo '<input type="text" id="' . $this->plugin_name .'_cookie_name" name="' . $this->plugin_name . '-cookie[cookie_name]" value="' . $this->cookie_settings["cookie_name"] . '" style="width: 50%;" />';
     	echo '<p class="' . $this->settings_prefix . 'settings_field_subtext">The name of the cookie you want to use with this plugin. This will be the cookie that needs to be checked to see if the user has indeed signed up.</p>';
     	$this->cookie_settings['cookie_name'] = esc_attr ($this->cookie_settings['cookie_name']);

	}

	/**
	 * Sanitises / Validates the user input for the General / Mailchimp options tab
	 *
	 * @since    0.1.0
	 */
	public function fsup_mailchimp_validate ($input) {

		// Initialse a new array for the validated & sanitised output
		$ouput = array();

		// Loop through the Mailchimp field values to sanitize and validate
		foreach ($input as $key => $value) {

			if (isset ($input[$key])) {

				$output[$key] = strip_tags (stripslashes ($input[$key]));
				if ($key === 'mc_list_id') {

					if (!preg_match ('/[a-zA-Z0-9]{10}$/i', $value)) {

						$ouput[$key] = '';

					} // END MC List ID Validation

				} // END Check for MC List ID

			} // END If key isset

		} // END Foreach

		return apply_filters ('fsup_mailchimp_validate', $output, $input); 

	}

	/**
	 * Sanitises / Validates the user input for the Slidein options tab
	 *
	 * @since    0.1.0
	 */
	public function fsup_slidein_validate ($input) {

		// Initialse a new array for the validated & sanitised output
		$ouput = array();

		// Loop through the Slide In field values to sanitize and validate
		foreach ($input as $key => $value) {

			if (isset ($input[$key])) {

				$output[$key] = strip_tags (stripslashes ($input[$key]));

			} // END If key isset

		} // END Foreach

		return apply_filters ('fsup_slidein_validate', $output, $input); 

	}

	/**
	 * Sanitises / Validates the user input for the Popup options tab
	 *
	 * @since    0.1.0
	 */
	public function fsup_popup_validate ($input) {

		// Initialse a new array for the validated & sanitised output
		$ouput = array();

		// Loop through the Popup field values to sanitize and validate
		foreach ($input as $key => $value) {

			if (isset ($input[$key])) {

				$output[$key] = strip_tags (stripslashes ($input[$key]));
				if ($key === 'popup_button_colour') {

					if (!preg_match ('/^#[a-f0-9]{6}$/i', $value)) {

						$ouput[$key] = '#fff';

					} // END Colour Validation

				} // END Check for button colour

			} // END If key isset

		} // END Foreach

		return apply_filters ('fsup_popup_validate', $output, $input); 

	}

	/**
	 * Sanitises / Validates the user input for the Cookie options tab
	 *
	 * @since    0.1.0
	 */
	public function fsup_cookie_validate ($input) {

		// Initialse a new array for the validated & sanitised output
		$ouput = array();

		// Loop through the Cookie field values to sanitize and validate
		foreach ($input as $key => $value) {

			if (isset ($input[$key])) {

				$output[$key] = strip_tags (stripslashes ($input[$key]));

			} // END If key isset

		} // END Foreach

		return apply_filters ('fsup_popup_validate', $output, $input); 

	}

	/**
	 * Minify CSS code on the fly, allowing smaller CSS files to be written to the server.
	 *
	 * @since    0.1.3
	 */
	private function minify_css ($css) {

		// make it into one long line
		$code = str_replace(array("\n","\r"),'',$css);
		// replace all multiple spaces by one space
		$code = preg_replace('!\s+!',' ',$code);
		// replace some unneeded spaces, modify as needed
		$code = str_replace(array(' {',' }','{ ','; '),array('{','}','{',';'),$code);

		return $code;

	}

	/**
	 * Saves some of the mailchimp options to a file
	 *
	 * Saves the Mailchimp API Keuy and the List ID to a file, enabling the 'mc3-signup' library to read them easily
	 * and securely without having to pass these options back and forth via AJAX calls.
	 *
	 * @since    0.1.0
	 */
	public function save_mailchimp_options_to_file ($old_value, $new_value) {

		// Write the settings file
		$file_name = FRIENDLY_SIGNUP_BASE_FILE . 'public/lib/mc3-signup/php/mcSettingsFS.php';
		$file_contents = '<?php' . PHP_EOL . PHP_EOL;
		$file_contents .= "\t" . 'define("MC_API_KEY", "' . $new_value['mc_api_key'] . '");' . PHP_EOL;
		$file_contents .= "\t" . 'define("MC_LIST_ID", "' . $new_value['mc_list_id'] . '");' . PHP_EOL . PHP_EOL;
		$file_contents .= '?>';
		file_put_contents ($file_name, $file_contents);

		// Write the messages file
		$file_name = FRIENDLY_SIGNUP_BASE_FILE . 'public/lib/mc3-signup/php/mcMessagesFS.php';
		$file_contents = '<?php' . PHP_EOL . PHP_EOL;
		$file_contents .= "\t" . 'define("MC_STATUS_SUCCESS", "' . $new_value['success_msg'] . '");' . PHP_EOL;
		$file_contents .= "\t" . 'define("MC_STATUS_EXISTS_UPDATED", "' . $new_value['success_on_list_msg'] . '");' . PHP_EOL;
		$file_contents .= "\t" . 'define("MC_STATUS_EXISTS_NO_UPDATE", "' . $new_value['success_on_list_msg'] . '");' . PHP_EOL;
		$file_contents .= "\t" . 'define("MC_STATUS_ERROR_INVALID", "' . $new_value['failure_invalid_msg'] . '");' . PHP_EOL;
		$file_contents .= "\t" . 'define("MC_STATUS_ERROR_UNKNOWN", "' . $new_value['failure_unknown_msg'] . '");' . PHP_EOL . PHP_EOL;
		$file_contents .= '?>';
		file_put_contents ($file_name, $file_contents);

	}	

	/**
	 * Saves the Slide In CSS edits to a file
	 *
	 * @since    0.1.4
	 */
	public function save_slidein_options_to_file ($old_value, $new_value) {

		// Write the settings file
		$file_name = FRIENDLY_SIGNUP_BASE_FILE . 'public/css/' . $this->plugin_name . '-public-slidein-edits.css';
		$file_contents = '/** -----' . PHP_EOL . ' * Slide In Sign Up CSS edits from the Slide In tab on the Plugin Settings Page' . PHP_EOL . ' */' . PHP_EOL . PHP_EOL;
		$button_css = '#fsup-slidein-mc-subscribe input[type="submit"] { background-color: ' . $new_value['slidein_button_colour'] .'; transition: background-color 1s ease; } #fsup-slidein-mc-subscribe input[type="submit"]:hover { background-color: ' . $new_value['slidein_button_hover_colour'] . '; }';
		$file_contents .= $this->minify_css ($new_value['slidein_css'] . $button_css);
		file_put_contents ($file_name, $file_contents);

	}	

	/**
	 * Saves the Popup CSS edits to a file
	 *
	 * @since    0.1.4
	 */
	public function save_popup_options_to_file ($old_value, $new_value) {

		// Write the settings file
		$file_name = FRIENDLY_SIGNUP_BASE_FILE . 'public/css/' . $this->plugin_name . '-public-popup-edits.css';
		$file_contents = '/** -----' . PHP_EOL . ' * Popup Sign Up CSS edits from the Popup tab on the Plugin Settings Page' . PHP_EOL . ' */' . PHP_EOL . PHP_EOL;
		$button_css = '#fsup-popup-body input[type="submit"] { background-color: ' . $new_value['popup_button_colour'] .'; transition: background-color 1s ease; } #fsup-slidein-mc-subscribe input[type="submit"]:hover { background-color: ' . $new_value['popup_button_hover_colour'] . '; }';
		$file_contents .= $this->minify_css ($new_value['popup_css'] . $button_css);
		file_put_contents ($file_name, $file_contents);

	}	

	/**
	 * Saves the Squeeze From CSS edits to a file
	 *
	 * @since    0.1.4
	 */
	public function save_squeeze_form_options_to_file ($old_value, $new_value) {

		// Write the settings file
		$file_name = FRIENDLY_SIGNUP_BASE_FILE . 'public/css/' . $this->plugin_name . '-public-squeeze-form-edits.css';
		$file_contents = '/** -----' . PHP_EOL . ' * Squeeze Form Sign Up CSS edits from the Squeeze Form tab on the Plugin Settings Page' . PHP_EOL . ' */' . PHP_EOL . PHP_EOL;
		$file_contents .= $this->minify_css ($new_value['squeeze_form_css']);
		file_put_contents ($file_name, $file_contents);

	}

}

