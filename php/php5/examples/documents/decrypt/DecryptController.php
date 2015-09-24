<?php
 
namespace ProtOn\Demos\Controllers;
 
use ProtOn\Demos\ApiDecryptDemo;
 
class DecryptController extends Controller {
	
	/**
	 * Represents a GET request to /demos/api-decrypt-demo
	 * Your view could consist in a form that posts it fields to itself.
	 * Post action would be controlled by "postApiDecryptDemo()" method.
	 */
	public function getApiDecryptDemo(){
		
		return "Your app view";
	
	}
	
	/**
	 * Represents a POST request to /demos/api-decrypt-demo
	 * This method capture the values sended in a form,
	 * make the call to the API and return the result to the
	 * "getApiDecryptResult($response)" method.
	 */
	public function postApiDecryptDemo(){
	
		$demo = new ApiDecryptDemo();
	
		$client_id =     $_POST['client_id'];
		$client_secret = $_POST['client_secret'];
		$postFile =      $_FILES['document'];
		$file = $postFile->move_uploaded_file($postFile['name'], sys_get_temp_dir()); // It is important to use the original filename and extension in the call
	
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
				$response = $demo->decryptDocument($access_token, $file, $algorithm, true);
			} else {
				throw new \Exception('Invalid authentication');
			}
		} catch (\Exception $e){
			$response['error'] = 400;
			$response['error_description'] = $e->getMessage();
		}
		
		return self::getApiDecryptResult($response);
	
	}
	
	/**
	 * Represents a GET request to /demos/api-decrypt-result
	 * Receives the result of the call and show the view.
	 */
	public function getApiDecryptResult($response){
		
		return "Your app result view";
	
	}
	
}
?>
