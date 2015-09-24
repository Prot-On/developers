<?php
namespace ProtOn\Utils;

use ProtOn\Utils\Pest\Pest;

class BearerPest extends Pest {

	protected $bearerHeader;
	
	public function setupAuth($user, $pass, $auth = 'basic'){
		if ($auth == 'bearer') {
			$this->bearerHeader = 'Authorization: Bearer ' . $user;
		} else {
			parent::setupAuth($user, $pass, $auth);
		}
	}
	
	public function prepData($data) {
		if (is_array ( $data )) {
			$multipart = false;
			
			foreach ( $data as $item ) {
				if (is_string ( $item ) && strncmp ( $item, "@", 1 ) == 0 && is_file ( substr ( $item, 1 ) )) {
					$multipart = true;
					break;
				} elseif ($item instanceof \CURLFile) {
					$multipart = true;
					break;
				}
			}
			
			return ($multipart) ? $data : http_build_query ( $data );
		} else {
			return $data;
		}
	}
	
	protected function prepHeaders($headers) {
		$headers = parent::prepHeaders($headers);
		if (!empty($this->bearerHeader)) {
			$headers[] = $this->bearerHeader;
		}
		return $headers;
	}

}

?>
