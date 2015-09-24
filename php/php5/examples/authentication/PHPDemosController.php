<?php
 
namespace ProtOn\Demos\Controllers;
 
use ProtOn\Demos\OAuthPHPDemo;
use ProtOn\Utils\Constants;
 
class PHPDemosController extends Controller {
	
	/* BEGIN OAUTH AUTHENTICATION EXAMPLE */
	
	/**
	 * Represents a request to http://developers.prot-on.com/demos/oauth-demo
	 */
	public function getOauthDemo() {
		return "Your demo view";
	}
	
	/**
	 * Represents a request to http://developers.prot-on.com/demos/oauth-demo-code
	 */
	public function postOauthDemoCode() {
		session_start();
		$client_id = $_SESSION['oauth_demo']['client_id'] = $_POST['client_id'];
		$client_secret = $_SESSION['oauth_demo']['client_secret'] = $_POST['client_secret'];
		
		$oauth = new OAuthPHPDemo($client_id, $client_secret);
		$oauth->getCode();
	}
	
	/**
	 * Represents a request made to http://developers.prot-on.com/demos/oauth-demo-result
	 */
	public function getOauthDemoResult() {
		
		$code = isset($_GET['code']) ? $_GET['code'] : NULL;
		
		if($code!=NULL){
			session_start();
			$client_id = $_SESSION['oauth_demo']['client_id'];
			$client_secret = $_SESSION['oauth_demo']['client_secret'];
			
			$oauth = new OAuthPHPDemo($client_id, $client_secret);
			$token = $oauth->getAccessToken($_GET['code']);
			
			/*
			 * This is only to unset token from session in this example.
			 * You can remove it from your implementation if you wish.
			 */
			unset($_SESSION['oauth_demo']);
			
			return "Your result view";
		}
	}
	
	/* END OAUTH AUTHENTICATION EXAMPLE */
	
}
?>
