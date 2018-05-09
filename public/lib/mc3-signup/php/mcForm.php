<?php

require ('mcApiCall.php');

class mcForm 
{
	private $optIn;
	private $email;
	private $fName;
	private $digest;
	private $updateIfExists;
	private $redirectURI;
	private $redirectPageTitle;
    private $cssClassSuccess;
    private $cssClassError;
	private $mcResult;

	/** 
	* Create a new instance of the form being processed and sets attributes from the HTML form
	* @param object $form
	*/
	public function __construct($form)
	{
		// Get all the values from the form being processed
		$this->fName = (isset($form['fname'])) ? strtolower(strip_tags($form['fname'])) : 'not set';
		$this->email = (isset($form['email'])) ? strtolower(strip_tags($form['email'])) : 'not set';
		$this->optIn = (isset($form['optin'])) ? strtolower(strip_tags($form['optin'])) : 'double';
		$this->digest = (isset($form['digest'])) ? strip_tags($form['digest']) : 'No';
		$this->updateIfExists = (isset($form['updateIfExists'])) ? strip_tags($form['updateIfExists']) : true;

        $this->cssClassSuccess = (isset($form['cssclass_success'])) ? strip_tags($form['cssclass_success']) : 'not set';
        $this->cssClassError = (isset($form['cssclass_error'])) ? strip_tags($form['cssclass_error']) : 'not set';

		// Split out the redirect into the URL & Page Title if it is set
		If (isset($form['redirect'])) {
			list($URI, $PageTitle) = explode(';', strip_tags($form['redirect']));
			$this->redirectURI = $URI;
			$this->redirectPageTitle = $PageTitle;
		} else {
			$this->redirectURI = $this->redirectPageTitle = 'not set';
		}

	}

	/** 
	* Processes the form instance by posting to the Mailchimp API
	* @param bool $updateIfExists
	* @return array
	*/
	public function doPost()
	{
		$mc = new MailChimp($this->optIn);
		$this->mcResult = $mc->doSignup($this->email, $this->fName, $this->digest, $this->updateIfExists);
		$this->mcResult['redirectURI'] = $this->redirectURI;
		$this->mcResult['redirectPageTitle'] = $this->redirectPageTitle;
        $this->mcResult['cssClassSuccess'] = $this->cssClassSuccess;
        $this->mcResult['cssClassError'] = $this->cssClassError;
        $this->mcResult['optin'] = $this->optIn;

		return json_encode($this->mcResult);
	}

}
