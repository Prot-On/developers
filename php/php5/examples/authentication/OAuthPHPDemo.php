<?php
 
namespace ProtOn\Demos;
 
use ProtOn\Utils\OAuth2\Client;
use ProtOn\Utils\OAuth2\GrantType\IGrantType;
use ProtOn\Utils\OAuth2\GrantType\AuthorizationCode;
use ProtOn\Utils\OAuth2\GrantType\RefreshToken;
 
class OAuthPHPDemo {
 
	/* Constants */
	
	const AUTHORIZATION_ENDPOINT	= '/external/oauth/authorize';
	const TOKEN_ENDPOINT		= '/external/oauth/token';
	const PROTON_URL		= 'https://proton.prot-on.com';
	const REDIRECT_URL		= 'http://developers.prot-on.com/demos/oauth-demo-result';
 
	/* Attributes */
 
	private $client;
	private $id;
	private $secret;
	
	/**
	 * Constructor
	 */
	public function __construct($id, $secret){
		$this->id = $id;
		$this->secret = $secret;
		$this->buildClient();
	}
	
	/**
	 * Builds a client for this instance
	 */
	public function buildClient(){
		$this->client = new Client($this->id, $this->secret, Client::AUTH_TYPE_AUTHORIZATION_BASIC);
	}
	
	/**
	 * Gets authorization code
	 */
	public function getCode(){
		$auth_url = $this->client->getAuthenticationUrl(self::PROTON_URL.self::AUTHORIZATION_ENDPOINT, self::REDIRECT_URL);
		header('Location: ' . $auth_url);
		die('Redirect');
	}
	
	/**
	 * Gets access token
	 * @param  $code the authorization code
	 */
	public function getAccessToken($code){
		$params = array('code' => $code, 'redirect_uri' => self::REDIRECT_URL);
		$response = $this->client->getAccessToken(self::PROTON_URL.self::TOKEN_ENDPOINT, Client::GRANT_TYPE_AUTH_CODE, $params);
		$token = self::parseOAuthTokenResponse($response); // Array. I.e.: $access_token = $token['access_token'];
		
		return $token;
    }
	
	/**
	 * Parses the response received from the getAccessToken method
	 * @param  $response the response from the getAccessToken method 
	 */
	public static function parseOAuthTokenResponse($response) {
    	$token = array();
		switch ($response['code']){
    		case 200:
    			$token = $response['result'];
    			$date = new \DateTime("now");
    			$token['expiration'] = $date->add(new \DateInterval('PT'.$token['expires_in'].'S'));
    			break;
    		case 401:
    			$token = $response['result'];
    			break;
    	}
    	return $token;
    }
}
?>
