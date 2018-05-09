<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://au.linkedin.com/in/shaarobtaylor
 * @since      0.1.0
 *
 * @package    Friendly_Signup
 * @subpackage Friendly_Signup/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
	
	$this->active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

?>
<div class="wrap">

 	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 	<form action="options.php" method="post">

        <!-- wordpress provides the styling for tabs. -->
        <h2 class="nav-tab-wrapper">
            <!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
            <a href="?page=friendly-signup&tab=mailchimp" class="nav-tab <?php if($this->active_tab == 'mailchimp'){echo 'nav-tab-active';} ?> "><?php _e('Mailchimp', $this->plugin_name); ?></a>
            <a href="?page=friendly-signup&tab=cookie" class="nav-tab <?php if($this->active_tab == 'cookie'){echo 'nav-tab-active';} ?> "><?php _e('Cookie', $this->plugin_name); ?></a>
            <a href="?page=friendly-signup&tab=slidein" class="nav-tab <?php if($this->active_tab == 'slidein'){echo 'nav-tab-active';} ?> "><?php _e('Slide In', $this->plugin_name); ?></a>
            <a href="?page=friendly-signup&tab=popup" class="nav-tab <?php if($this->active_tab == 'popup'){echo 'nav-tab-active';} ?> "><?php _e('Popup', $this->plugin_name); ?></a>
        </h2>

        <div class="fsup-tab-content">

			<?php

				switch ($this->active_tab) {

					case 'mailchimp' :
					case '' :
					default :

				        settings_fields ($this->plugin_name . '-mailchimp');
				       	do_settings_sections ($this->plugin_name . '-mailchimp');
				       	break;

				    case 'cookie' :

				        settings_fields ($this->plugin_name . '-cookie');
				       	do_settings_sections ($this->plugin_name . '-cookie');
				       	break;

				    case 'slidein' :

				        settings_fields ($this->plugin_name . '-slidein');
				       	do_settings_sections ($this->plugin_name . '-slidein');
				       	break;

				    case 'popup' :

				        settings_fields ($this->plugin_name . '-popup');
				       	do_settings_sections ($this->plugin_name . '-popup');
				       	break;

		       	}

			?>

		</div>

		<?php

			submit_button ('Save Changes', 'primary', 'submit', TRUE);	  

		?>

	</form>

</div>