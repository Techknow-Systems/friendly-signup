<?php

require ('mcSettingsFS.php');
require ('mcMessagesFS.php');

class MailChimp
{
	
	private $apiKey;
	private $listID;
	private $email;
	private $optIn;
	private $apiUrl = 'https://<dc>.api.mailchimp.com/3.0/';
	
	/** 
	* Create a new instance
	* @param string $mcListName - Optional
	*/
	public function __construct($optIn)
	{
		// Use the API Key defined in the settings file.
		$this->setApiKey(MC_API_KEY);
		$this->setListID(MC_LIST_ID);
		$this->setOptInStyle($optIn);
	}
	
	/** 
	* Method to Set Api Key
	* @param string $apiKey
	*/
	private function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
		list(, $datacentre) = explode('-', $this->apiKey);
		$this->apiUrl = str_replace('<dc>', $datacentre, $this->apiUrl);
	}

	/** 
	* Method to Set List ID to work with
	* @param string $mcListID
	*/
	public function setListID($mcListID)
	{
		$this->listID = $mcListID;
	}

	/** 
	* Method to Set the Opt In Style (single or double)
	* @param string $optIn
	*/
	public function setOptInStyle($optIn)
	{
		$this->optIn = $optIn;
	}

	/** 
	* Method to get the curent list ID, for use with functions that require it
	* @params none
	*/
	public function getListID() {
		return $this->listID;
	}

	/** 
	* Magic Method to request http verb
	* @return array
	*/
	public function __call($method, $arguments)
	{
		$httpVerb = strtoupper($method);
		$allowedHttpVerbs = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE');
		
		//Validate http verb
		if(in_array($httpVerb, $allowedHttpVerbs)){
			$endPoint = $arguments[0];
			//throw new \Exception('"Arguments[1] DATA: ' . print_r($arguments[1]) . '"');
			$data = isset($arguments[1]) ? $arguments[1] : array();
			return $this->request($httpVerb, $endPoint, $data);
		}
		
		throw new \Exception('Invalid http verb!');
	}
	
	/** 
	* Call MailChimp API
	* @param string $httpVerb
	* @param string $endPoint - (http://kb.mailchimp.com/api/resources)
	* @param array $data - Optional
	* @return array
	*/
	private function request($httpVerb = 'GET', $endPoint, $data = array())
	{
		//validate API
		if(! $this->apiKey){
			throw new \Exception('MailChimp API Key must be set before making request!');
		}
		
		$endPoint = ltrim($endPoint, '/');
		$httpVerb = strtoupper($httpVerb);
		$requestUrl = $this->apiUrl.$endPoint;
		
		return $this->curlRequest($requestUrl, $httpVerb, $data);
	}
	
	/** 
	* Request using curl extension
	* @param string $url
	* @param string $httpVerb
	* @param array $data - Optional
	* @return array
	*/
	private function curlRequest($url, $httpVerb, array $data = array(), $curlTimeout = 15)
	{
		if(function_exists('curl_init') && function_exists('curl_setopt')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_USERAGENT, 'VPS/MC-API:3.0');
			curl_setopt($ch, CURLOPT_TIMEOUT, $curlTimeout);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_USERPWD, "user:".$this->apiKey);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpVerb);
			
			//Submit data
			if(!empty($data)){
				$jsonData = json_encode($data);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			}
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			
			return $result ? json_decode($result, true) : false;
		}

		throw new \Exception('curl extension is missing!');
	}

	/**
	* Check the Return Status
	* @param string $MCReturn - the MC result
	* @param bool $doPatch - update the member if they already exist
	* @return array
	*/
	private function checkMCStatus($MCResult, $isPatch = false)
	{
		$returnVal['success'] = 'false';
		$returnVal['update'] = ($isPatch) ? 'true' : 'false';
		$returnVal['exists'] = 'false';
		$returnVal['email'] = $this->email;
		$returnVal['message'] = '';
		$returnVal['needs_update'] = 'false';
		$returnVal['from_mc'] = $MCResult;

		// If status is pending all is well, otherwise...
		switch ($MCResult['status']) {

			// Not on the list, now added
			case 'pending':
				$returnVal['success'] = 'true';
				$returnVal['message'] = MC_STATUS_SUCCESS;
				break;

			// Was alreasdy on the list, now updated
			case 'subscribed':
				$returnVal['exists'] = ($this->optIn == 'single') ? 'false' : 'true';
				$returnVal['success'] = 'true';
				$returnVal['message'] = ($this->optIn == 'single') ? MC_STATUS_SUCCESS : MC_STATUS_EXISTS_UPDATED;
				break;

			// Has unsubscribed, needs to be resubscribed
			case 'unsubscribed':
			case 'cleaned':
				$returnVal['success'] = 'true';
				$returnVal['needs_update'] = 'true';
				break;

			// There is a problem, needs further investigatuion
			case '400':
				$returnVal['success'] = 'false';
				
				// Check to see what the problem actually is
				if ($MCResult['title']  === 'Invalid Resource') {

					$returnVal['error'] = 'invalid';			
					if (($MCResult['detail'] === 'Blank email address') || ($MCResult['detail'] === 'Please provide a valid email address.')) {

						// Invalid email address
						$returnVal['message'] = MC_STATUS_ERROR_INVALID;

					} else {

						$returnVal['message'] = $MCResult['detail'];

					}

				} else {

					// Something else weird
					$returnVal['error'] = 'unknown';
					$returnVal['message'] = $MCResult['detail'];
				}
				break;

			// Not sure what is going on, just return the MC error message
			default:
				$returnVal['success'] = 'false';
				$returnVal['message'] = $MCResult['detail'];

		}

		$returnVal['listinfo'] = $this->listID;
		return $returnVal;
		//return $return_val ? json_encode($return_val) : false;
	}

	/**
	* Function wrapper to do the sign up process. Paramaeter to check is subscrober is already on the list, then update their details
	* @param string $email
	* @param string $fname
	* @param string $digest - get the weeklyu digest
	* @param bool $doUpdate
	* @return array
	*/
	public function doSignup($email, $fName, $digest, $doUpdate = false)
	{
		$this->email = $email;
		$status_if_new = ($this->optIn == 'single') ? 'subscribed' : 'pending';
		
		// Subscribe the user to the list
		$result = $this->put('/Lists/' . $this->listID . '/members/' . md5($email), array(
		    'email_address' => $email,
		    'email_type' => 'html',
		    'status_if_new' => $status_if_new,
		    'status' => 'subscribed'
		));

		// Check out the status returned from MailChimp and see if we need to update the MailChimp email
		$status = $this->checkMCStatus($result);

		// Check to see if we need to update the subscriber (i.e. they have unsubscribed)
		if ($status['needs_update'] === 'true') {

			$patchResult = $this->patch('/Lists/' . $this->listID . '/members/' . md5($email), array(
		    	'email_address' => $email,
		    	'email_type' => 'html',
		    	'status' => $status_if_new
			));

			// Check out the status returned from MailChimp and see if we need to update the MailChimp email
			$patchStatus = $this->checkMCStatus($patchResult, true);
			return $patchStatus;

		} else { 

			return $status; 

		}
		
	}

	/**
	* Function to check the signup status of the supplied email address.
    * If onWeekly = true, this function returns true if they are subscribed and on the weekly, otherwise false. If onWeekly = false, function just returns the signup status.
	* @param string $email
	* @param bool $onWeekly
	* @return array
	*/
	public function checkSignupStatus($email, $onWeekly = false)
	{
		$this->email = $email;
		$result = $this->get('/Lists/' . $this->listID . '/members/' . md5($email));

		if ($onWeekly) {

			if (($result['status'] === 'subscribed') && ($result['merge_fields']['DIGEST'] === 'Yes')) {

				return true;

			} else {

				return false;

			}
		
		} else {

			return $result['status'];

		}

	}

}

?>