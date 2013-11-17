<?php
// classes/Google_Userinfo.class.php
require_once('HttpPost.class.php');

/**
 * Get the Google+ user account from
 * https://www.googleapis.com/oauth2/v1/userinfo
 * 
 * Requires that user has been OAuth authenticated
 */
class Google_Location {
	
	const URL = 'https://www.googleapis.com/mirror/v1/locations/';
	public $fetched = false;
	
	// this is the scope required to access the userinfo
	public static $scopes = array(
		'https://www.googleapis.com/auth/glass.timeline',
		'https://www.googleapis.com/auth/glass.location'
	); 
	
	// we can only grab userinfo from an authenticated user
	public $Google_OAuth2_Token;
	
	
	// these are the variables that will come back from the server
	public $id,
		$timestamp,
		$latitude,
		$longitude,
		$accuracy,
		$kind;

	
		
	/**
	 * Use the authenticated Google_OAuth2_Token
	 */
	public function __construct($Google_OAuth2_Token) {
		$this->Google_OAuth2_Token = $Google_OAuth2_Token;
	}
	
	/**
	 * Fetch the Google+ profile information
	 */
	public function fetch() {
		// we will be stending the OAuth2 access_token through the HTTP headers
		$headers = array(
			'Authorization: '.$this->Google_OAuth2_Token->token_type.' '.$this->Google_OAuth2_Token->access_token
		);
		
		$this->HttpPost = new HttpPost(self::URL);
		$this->HttpPost->setHeaders( $headers );
		
		if ($this->Google_OAuth2_Token->authenticated) {
			$this->HttpPost->send();
		    $response = json_decode($this->HttpPost->httpResponse);
		
		} else {
			throw new Exception ("Google_OAuth2_Token needs to be authenticated before you can fetch locations.");
		}

		
		
		// is there an error here?
		if ($response->error) {
			throw new Exception("The server reported an error: '".$response->error->errors[0]->message."'");
		} else {
			// we grabbed this from the locations API, which sends a list of locations
			// therefore we need to grap the first location
			$item = $response->items[0];
			
			$this->kind = $item->kind;
			$this->id = $item->id;
			$this->timestamp = $item->timestamp;
			$this->latitude = $item->latitude;
			$this->longitude = $item->longitude;
			$this->accuracy = $item->accuracy;
			
			$this->fetched = true;
		}
	}
	
}

?>