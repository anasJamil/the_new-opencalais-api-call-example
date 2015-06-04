<?php
/**
 * By Anas Jamil 
 * Last updated 2/6/2015
 */

class OCalais {
	private $private_key = '';
	private $api_url = 'https://api.thomsonreuters.com/permid/calais';
	public  $content_type = 'text/raw';
	private $output_format = 'application/json';
	private $doc = '';
	private $extracted_entities = array();

	public function OCalais($key) {
		if (empty($key)) {
			$msg ='API key is required';
			echo $msg;
			throw new Exception($msg);
		}
		$this -> private_key = $key;
	}

	public function textAnalysis($doc) {
		$this -> doc = $doc;  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this -> api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this -> doc);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
											"Content-Type:" . $this -> content_type, 
											"outputFormat:" . $this -> output_format, 
											"X-AG-Access-Token:" . $this -> private_key, 
											));
		$response = curl_exec($ch);
		curl_close($ch);
		$res = get_object_vars(json_decode($response, false));
		$info = array('topic' => '', 'person' => '', 'country' => '', 'city' => '', 'provinceorstate' => '', 'company' => '', 'organization' => '', 'industryterm' => '');
		foreach ($res as $data) {
			$data = get_object_vars($data);
			if (array_key_exists('_typeGroup', $data) && $data['_typeGroup'] == 'topics') {
				$info['topic'][] = $data['name'];
			}
			if (array_key_exists('_type', $data)) {
				if (array_key_exists(strtolower($data['_type']), $info)) {
					$key = strtolower($data['_type']);
					$info[$key][] = $data['name']; 
				}  
			}
		} 
		return $info;
	}
}