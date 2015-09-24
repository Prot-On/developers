<?php
 
namespace ProtOn\Demos\Controllers;
 
use ProtOn\Demos\OAuthPHP;
use ProtOn\Demos\ApiUsersPHPDemo;
use ProtOn\Utils\Constants;
 
class UserSearchController extends Controller {
	
	public function getApiUsersDemo(){
	
		return "Your app view";
	
	}
	
	public function postApiUsersDemo(){
	
		$demo = new ApiUsersPHPDemo();
	
		$client_id =     $_POST['client_id'];
		$client_secret = $_POST['client_secret'];
		$filter =        $_POST['filter'];
	
		/*
		 * This is an example. You have to get your stored token from session,
		 * database or by calling your own oauth authentication service.
		 * Please check http://developers.prot-on.com/php-examples/oauth
		 * if you want to know how to implement an OAuth authentication system
		 */
		$access_token = $_SESSION['access_token'];
	
		try{
			if($access_token!=NULL){
				$response = $demo->getUsers($access_token, $filter);
			} else {
				throw new \Exception('Invalid authentication');
			}
		} catch (\Exception $e){
			$response['error'] = 400;
			$response['error_description'] = $e->getMessage();
		}
	
		return self::getApiUsersResult($response);
	
	}
	
	public function getApiUsersResult($response){
	
		return "Your view result";
	
	}
	
}
?>
