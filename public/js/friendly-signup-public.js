jQuery (function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// File Scope Variables
	var viewportWidth = window.innerWidth;  // Get the Browser Width
	var signupType = '';

    // Check to see if the browser supports btoa() & atob() - Thanks IE for your lack of support
    if (!window.btoa) window.btoa = base64.encode;
    if (!window.atob) window.atob = base64.decode;

	// --- SLIDE IN
	var animated = false;  // Box has completely slid out or not
	var animating = false;  // Box is in the process of sliding out
	var scrollPos = 0; // The number of pixels to scroll down before slide in

	// Wraps the GA event code as it has changed recently!
	function ga_event (action, category, label) {

		gtag ('event', action, {
			  'event_category' : category,
			  'event_label' : label,
		});

	}

	// Slide the box in or out
	function animate_slidein() {

		signupType = 'slidein';
		// Check to see if the box is fully in or fully out & therefore not animated
		if (!animating) {

			// Only fire if we are half way down the article	
			if  ($(window).scrollTop() >= scrollPos) {

				// Box is stationary
				if (!animated) {

					// Set the flag that box is moving, check for a cookie not to show the box
					animating = true;
					if ((Cookies.get('friendly-signup') === undefined)|| (!Cookies.get('friendly-signup'))) {

						// If we are not on a mobile device
						if (viewportWidth > 750) {

							// Slide out & do a call back when animation is complete to set flags back to false
							$('#fsup-slidein-signup').animate({'right':'0'}, {'duration':600, 'complete':animate_complete} );
							animated = true;

						// We are on mobile
						} else {

							// Slide box up from the bottom
							$('#fsup-slidein-signup').animate({'bottom':'0'}, {'duration':600, 'complete':animate_complete} );
							animated = true;

						}

					}

				}

			// If we are not half way down the article, slide the box in
			} else if (animated) {

				// Set theflags and do the animation
				if (viewportWidth > 750) {

					animating = true;
					$('#fsup-slidein-signup').stop(true).animate({'right':'-600px'}, {'duration':100, 'complete':animate_complete} );
					animated = false;

				} else {

					animating = true;
					$('#fsup-slidein-signup').stop(true).animate({'bottom':'-200px'}, {'duration':100, 'complete':animate_complete} );
					animated = false;

				}  // Viewport Width Check

			}  // End Checking article position

		}  // End check to see if box is stationary

	}  // End scroll function

	// Callback to set the say that we are finished sliding the box in / out
	function animate_complete() {

		animating = false;
		animate_slidein();

	}

	// Close the slidin box and set a cookie is necessary
	function close_slidein(action, email) {

		if (action == 'close') {

			$('#fsup-slidein-signup').remove();
			//Cookies.set('upl-signedin', window.btoa(encodeURIComponent('subscribed:false;')), { expires: 1 });

		} else if (action == 'subscribed') {

			$("html, body").animate({ scrollTop: 0 }, "slow");
			setTimeout(function(){
				$('#fsup-slidein-signup').fadeOut('slow');
				Cookies.set('friendly-signup', window.btoa(encodeURIComponent('subscribed:true;email:' + email + ';')), { expires: 731 });
			}, 4500);

		} else if (action === 'close_from_popup') {

			$('#fsup-slidein-signup').remove();

		}

	}

    // Swicth the Sign Up button on and off
	function toggle_button(formName, btnSuffix, enableFlag) {

       	if (!enableFlag) {

       		$('#' + formName + ' img').css('visibility', 'visible');
       		$('#fsup-mc-subscribe-button' + btnSuffix)
       		.attr('disabled', true)
       		.attr('style', 'background-color: #ccc !important');

       	} else {

       		$('#' + formName + ' img').css('visibility', 'hidden');
       		$('#fsup-mc-subscribe-button' + btnSuffix)
       		.attr('disabled', false)
       		.attr('style', 'background-color: #db393e !important');
       		$('#fsup-mc-subscribe-button' + btnSuffix + ":hover").attr('style', 'background-color: #fb5257 !important');

       	}

    }

	// Output the appropriate sign up message depending on the status that is returned from MC
	function output_signup_status(signupType, mcStatus, outputForm, formContainer) {

		var subscribeSuccess = mcStatus['success'];
		var subscribeExists = mcStatus['exists'];
		var subscribeUpdate = mcStatus['update'];
		var subscribeError = mcStatus['error'];
		var subscribeMessage = mcStatus['message'];
		var subscribeEmail = mcStatus['email'];
		var subscribeMsgText;
        var slideinHeight = 'decrease';  // don't do anything with the height

		switch (signupType) {

			case 'slidein' :

		        if (subscribeSuccess == 'true') {

		        	// Register the Google Analytics Event
					if (viewportWidth > 750) { //ga('send', 'event', 'Form', 'Submitted', 'Email sign-up - Desktop (slidein)');
					} else { //ga('send', 'event', 'Form', 'Submitted', 'Email sign-up - Mobile (slidein)');
					}

					// hide the keyboard on mobile devices
		    		//document.activeElement.blur();
		    		//$("#upltv-slidein-mc-subscribe input").blur();
		    		//$('#upl-films-player').focus();

		    		// Output the success message and close the slidein
		        	$('.fsup-slidein-text').remove();
		        	$('.fsup-slidein-error').remove();
	    	    	$(outputForm).hide();
		        	slideinHeight = 'decrease';
		        	subscribeMsgText = "<p class='fsup-slidein-success'>" + subscribeMessage + "</p>";
		        	close_slidein('subscribed', subscribeEmail);

		        } else {

		        	// output the error message
		        	$('.fsup-slidein-text').remove();
		        	$('.fsup-slidein-error').remove();
		  			slideinHeight = 'increase';
		        	subscribeMsgText = "<p class='fsup-slidein-error'>" +  subscribeMessage + "</p>";
		        	$('#fsup-slidein-mc-subscribe input[type="email"]').focus();

				} // Subscribe Success 

		        // Check the height of the slidein box to determine if we are on desktop or mobile
		        // and adjsut the height of the slidein accordingly
		        if (viewportWidth > 750) {

		            // On Desktop
		            if (slideinHeight == 'increase') {
		            	$('#fsup-slidein-signup').css('height', '170px');
		            } else if (slideinHeight == 'decrease') {
		            	$('#fsup-slidein-signup').css('height', '130px');
		            }

		        } else {

		            // We are on mobile
		            $('.fsup-slidein-text').remove();

		            if (slideinHeight == 'increase') {
		            	$('#fsup-slidein-signup').css('height', '130px');
		            } else if (slideinHeight == 'decrease') {
		            	$('#fsup-slidein-signup').css('height', '70px');
		            }

		       	}// Slider Heigh Check

		        $(formContainer).append(subscribeMsgText);
		       	slideinHeight = 'decrease';
		       	break;

	        case 'popup' :

		        if (subscribeSuccess == 'true') {

		        	// Register the Google Analytics Event
					if (viewportWidth > 750) { ga_event ('Signup', 'Form Submitted', 'Desktop (popup)'); } 
					else { ga_event ('Signup', 'Submitted', 'Email sign-up - Mobile (popup)'); }

					// Display the success message in the popup
		        	$('.fsup-popup-text').remove()
		        	$('.fsup-popup-error').remove();
	    	    	$(outputForm).hide();
		        	subscribeMsgText = "<p class='fsup-popup-success'>" + subscribeMessage + "</p>";
					close_popup('subscribed', subscribeEmail);

		        } else {

		        	$('.fsup-popup-error').text(subscribeMessage);

		        }
		        
		        $(formContainer).append(subscribeMsgText);
		        break;

        }

    }


    // --- POPUP
    function animate_popup() {

    	signupType = 'popup';

    	// If a cookie already exists, do not show the popup.
    	if (!Cookies.get('friendly-signup') ||(Cookies.get('friendly-signup') === 'undefined')) {

	    	reset_popup_form();
	    	$('#fsup-popup').fadeIn(350);
	 		$('#fsup-popup-mc-subscribe input[type="email"]').focus();

	 	}
 
    }

    function close_popup(action, email) {

    	var timeToClose = 0;

    	switch (action) {

    		case 'close' :
    		default :

    			// Fade out popup quiclky
    			timeToClose = 0;
				setTimeout (function () {
		    		$('#fsup-popup').fadeOut(350);
		    	}, timeToClose);
    			break;

    		case 'subscribed' :

    			// Fade out popup slowly - give user time to read the messge
    			timeToClose = 5000;
				Cookies.set('friendly-signup', window.btoa(encodeURIComponent('subscribed:true;email:' + email + ';')), { expires: 731 });

				// This needs to be moved out of here!!
				$('.upldpm-tour-logo-text-desktop').css({'top': 'calc((100vh - 150px) * 0.92)'});
				$('.upldpm-tour-logo-text-mobile-bottom div h1').css({'display': 'block'});
				$('.upldpm-tour-logo-text-mobile-bottom').css({'top': 'calc(100vh - 270px)'});
				$('#upldpm-footer').attr('style', 'display: none !important');
				$.fn.fullpage.setAllowScrolling(true);
				$.fn.fullpage.setAutoScrolling(false);
				setTimeout (function () {
		    		$('#fsup-popup').fadeOut(350);
					$('html,body').animate({scrollTop: $('#upldpm-section-dowmload-music').offset().top}, 'slow');
		    	}, timeToClose);
    			break;

    	}

    }

    function reset_popup_form() {

        $('p').remove('.fsup-squeeze-mc-success');    
        $('p').remove('.fsup-squeeze-mc-error');
        $('#fsup-popup-mc-subscribe input')
       		.not('[type=button], [type=submit], [type=reset], [type=hidden], [type=radio], [type=checkbox]')
  			.val('');
        $('#fsup-popup-mc-subscribe').show();

    }



	// ---
	// DOM Ready - Lets Start.
    // When the DOM is readym show the slide in
	$(document).ready(function () {

		animate_slidein ();

	});  // DOM Ready


	// ---
    // SLIDE IN Ececuition - Lets do it!
	// Slide the signup box in when close button is clicked
	$('#fsup-slidein-signup .fsup-slidein-close').on('click',function(e){

		// Slide the signup box back in and set a cookie to not show the box for 14 days
		close_slidein('close');
		e.stopPropagation();

	});

	// Submit the slide inform to the form AJAX handler
	$('#fsup-slidein-mc-subscribe').on('submit', function (e) {

		e.preventDefault();
		toggle_button('fsup-slidein-mc-subscribe', '', false);
		$.post({

            url: url_obj.plugin_url + 'public/lib/mc3-signup/ajax/processMCForm.php',
           	dataTyoe: 'json',
            data: $(this).serialize(), 
            success: function(data) {

            	console.log(JSON.stringify(data));
            	output_signup_status('slidein', $.parseJSON(data), '#fsup-slidein-mc-subscribe', '#fsup-slidein-body');
            	toggle_button('fsup-slidein-mc-subscribe', '', true);

           	} // Function to test returnvalue

        });  // AJAX Call

	}); // Sliein Form Submit


	// --- 
	// POPUP Execution - Lets do it!
	// Show the Popup when the Download button is clicked
	$('.upldpm-button-download').on('click', function (e) {

		e.preventDefault();
		animate_popup();

	});

	$('.fsup-popup-close').on('click', function (e) {

		e.preventDefault();
		close_popup('close');

	});

	// Submit the slide inform to the form AJAX handler
	$('#fsup-popup-mc-subscribe').on('submit', function (e) {

		e.preventDefault();
		var formData = $(this).serialize();
		toggle_button('fsup-popup-mc-subscribe', '', false);
		$.post({

            url: url_obj.plugin_url + 'public/lib/mc3-signup/ajax/processMCForm.php',
            dataTyoe: 'json',
            data: formData, 
            success: function(data) {

           		//console.log(JSON.stringify(data));
            	output_signup_status('popup', $.parseJSON(data), '#fsup-popup-mc-subscribe', '#fsup-popup-body');
            	toggle_button('fsup-slidein-mc-subscribe', '', true);

           	} // Function to test returnvalue

        });  // AJAX Call

	}); // Sliein Form Submit


});
