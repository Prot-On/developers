<?php
 
namespace ProtOn\Demos\Controllers;
 
use ProtOn\Demos\ApiUsersEmailDemo;
 
class UserEmailController extends Controller {
	
	public function getApiUsersEmailDemo(){
	
		return "Your app view";
	
	}
	
	public function postApiUsersEmailDemo(){
	
		$demo = new ApiUsersEmailDemo();
	
		$client_id =     $_POST['client_id'];
		$client_secret = $_POST['client_secret'];
		$email =         $_POST['email'];
	
		/*
		 * This is an example. You have to get your stored token from session,
		 * database or by calling your own oauth authentication service.
		 * Please check http://developers.prot-on.com/php-examples/oauth
		 * if you want to know how to implement an OAuth authentication system
		 */
		 $access_token = $_SESSION['access_token'];
	
		try{
			if($access_token!=NULL){
				$response = $demo->getUsersByEmail($access_token, $email);
			} else {
				throw new \Exception('Invalid authentication');
			}
		} catch (\Exception $e){
			$response['error'] = 400;
			$response['error_description'] = $e->getMessage();
		}
	
		return self::getApiUsersEmailResult($response);
	
	}
	
	public function getApiUsersEmailResult($response){
	
		return "Your app result view";
	
	}
	
}
?>
