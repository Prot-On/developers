<?php
 
namespace ProtOn\Demos\Controllers;
 
use ProtOn\Demos\OAuthPHP;
use ProtOn\Demos\ApiProtectPHPDemo;
use ProtOn\Utils\Constants;
 
class ProtectDemoController extends Controller {
	
	/**
	 * Receives inputs from a form
	 */
	public function postApiProtectDemo(){
		
		$demo = new ApiProtectPHPDemo();
		
		$client_id =     $_POST['client_id'];
		$client_secret = $_POST['client_secret'];
		$postFile =      $_POST['document'];
		
		/*
		 * This is an example. You have to get your stored token from session,
		 * database or by calling your own oauth authentication service.
		 * Please check http://developers.prot-on.com/php-examples/oauth
		 * if you want to know how to implement an OAuth authentication system
		 */
		$access_token = $_SESSION['access_token'];
		
		$algorithm = 'AES256';
		
		try{
			if($access_token!=NULL){
				$response = $demo->protectDocument($access_token, $file, $algorithm, true);
			} else {
				throw new \Exception('Invalid authentication');
			}
		} catch (\Exception $e){
			$response['error'] = 400;
			$response['error_description'] = $e->getMessage();
		}
		
		return self::getApiProtectResult($response);
	
	}
	
	public function getApiProtectResult($response){
		
		return "Your result view";
	
	}
	
}
?>
