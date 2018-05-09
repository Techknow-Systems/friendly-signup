jQuery (function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

	/* ---
	 * The Codemirror CSS Editor
	 */

	// Object to hold multiple instances of the CodeMirror textareas
	var editor = {};

	/*
	 * Calss the CSSLint external package 
	 * 
	 * Adds a helper to the CodeMirror instances to provide error chekcing and validation for the CSS Edit fields
	 *
	 * @since: 0.1.4
	 */ 
	CodeMirror.registerHelper("lint", "css", function(text) {

		var found = [];
  		if (!window.CSSLint) return found;
  
  			var results = CSSLint.verify(text), messages = results.messages, message = null;
  			for ( var i = 0; i < messages.length; i++) {
    
    			message = messages[i];
    			var startLine = message.line -1, endLine = message.line -1, startCol = message.col -1, endCol = message.col;
    			found.push({
 
      				from: CodeMirror.Pos(startLine, startCol),
      				to: CodeMirror.Pos(endLine, endCol),
      				message: message.message,
      				severity : message.type
    			
    			});
  
  			}
  
  		return found;

	});

	/*
	 * Initialises the Codemirror CSS editor and places them into the editor object. 
	 * 
	 * @since: 0.1.4
	 */ 
    function create_CM_instance (textarea_id) {

    	if (document.getElementById(textarea_id) !== null) {

			editor[textarea_id] = CodeMirror.fromTextArea(document.getElementById(textarea_id), {
		        theme: 'neo',
		        lineNumbers: true,
		        matchBrackets: true,
		        mode: 'css',
		        indentUnit: 4,
		        indentWithTabs: true,
		        styleActiveLine: true,
		        autoCloseBrackets: true,
		        lint: true,
			    foldGutter: true,
		        gutters: ["CodeMirror-linenumbers", "CodeMirror-lint-markers", "CodeMirror-foldgutter"],
			}); 	

		}

    }

    /* 
     * CodeMirror Executuon
     * 
     * Creates CodeMirror instances for CSS Edits textareas on the SlideIn and Popup tabs
     */
    create_CM_instance ('friendly-signup_popup_css');
    create_CM_instance ('friendly-signup_slidein_css');


    /* -----
     * Wordpress Colour Picker
     *
     * Execution - Add a Wordpress Colour Picker for the Popup Button Colour Field
     */
    $('.fsup-wp-colour-picker').wpColorPicker();

 });
