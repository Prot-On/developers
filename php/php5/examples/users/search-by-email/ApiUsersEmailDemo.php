<?php
 
namespace ProtOn\Demos;
 
use ProtOn\Utils\BearerPest;
 
class ApiUsersEmailDemo {
	
	const PROTON_REST_API = 'https://dnd.prot-on.com/rest-api/api';
	
	public function getUsersByEmail($token, $email){
		
		$response = NULL;
		
		$service_url = '/users/email/{email}?email='.urlencode($email);
		
		$httpHeaders = array('Content-Type' => 'text/html; charset=utf-8');
		$data = array();
		
		$pest = new BearerPest(self::PROTON_REST_API);
		$pest->setupAuth($token, '', 'bearer');
		try {
			$body = $pest->get($service_url, $data, $httpHeaders);
			$response = $body;
		} catch (Pest_Exception $e) {
			$response = $e->getMessage();
		}
		
		return $response;
		
	}
	
}
?>
