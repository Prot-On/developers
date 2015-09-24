<?php
 
namespace ProtOn\Demos;
 
use ProtOn\Utils\BearerPest;
 
class ApiDecryptDemo {
	
	/* Constants */
	
	const PROTON_REST_API = 'https://dnd.prot-on.com/rest-api/api';
	const SERVICE_URL = '/documents/decrypt';
	
	/**
	 * Decrypts a document
	 * @param  string $token
	 * @param  file $file
	 * @param  string $algorithm
	 * @param  boolean $return_url
	 * @return  Ambigous 
	 */
	public function decryptDocument($token, $file, $algorithm, $return_url){
		
		$response = NULL;
		
		$httpHeaders = array('Content-Type' => 'multipart/form-data; charset=utf-8');
		$data = array('file' => $this->getCurlFile($file->getRealPath()), 'algorithm'=>$algorithm, 'return_url'=>$return_url);
		
		$pest = new BearerPest(self::PROTON_REST_API);
		$pest->setupAuth($token, '', 'bearer');
		try {
			$body = $pest->post(self::SERVICE_URL, $data, $httpHeaders);
			$response = $body;
		} catch (Pest_Exception $e) {
			$response = $e->getMessage();
		}
		
		return $response;
		
	}
	
	/**
	 * Builds the appropiate $curlFile data type depending
	 * on the installed PHP version
	 * @param  string $filePath
	 * @return  Ambigous 
	 */
	function getCurlFile($filePath){
		
		if(version_compare(PHP_VERSION, '5.5.0') >= 0){
			$curlFile = new \CURLFile($filePath, '', '');
		} else {
			$curlFile = "@".$filePath;
		}
		
		return $curlFile;
		
	}
	
}
?>
