<?php
 
namespace ProtOn\Demos;
 
use ProtOn\Utils\BearerPest;
 
class ApiUsersDemo {
	
	const PROTON_REST_API = 'https://dnd.prot-on.com/rest-api/api';
	const SERVICE_URL = '/users/';
	
	public function getUsers($token, $filter){
		
		$response = NULL;
		
		$httpHeaders = array('Content-Type' => 'text/html; charset=utf-8');
		$data = array('filter' => $filter);
		
		$pest = new BearerPest(self::PROTON_REST_API);
		$pest->setupAuth($token, '', 'bearer');
		try {
			$body = $pest->get(self::SERVICE_URL, $data, $httpHeaders);
			$response = $body;
		} catch (Pest_Exception $e) {
			$response = $e->getMessage();
		}
		
		return $response;
		
	}
	
}
?>
