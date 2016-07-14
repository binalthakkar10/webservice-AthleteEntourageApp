<?php
class Golocation
{
	protected $errors = array();
	protected $service = 'api.ipinfodb.com';
	protected $version = 'v3';
	protected $apiKey = '8a984f068bd9b4d8342e0abc620d2f46abf129b9c064d6ee530580b78a56eab8';

	public function __construct(){}

	public function __destruct(){}

	public function setKey($key=null){
		if(!empty($key)) $this->apiKey = $key;
	}

	public function getError(){
		return implode("\n", $this->errors);
	}

	public function getCountry($host){
		return $this->getResult($host, 'ip-country');
	}

	public function getCity($host){
		return $this->getResult($host, 'ip-city');
	}

	private function getResult($host, $name){
		$ip = @gethostbyname($host);

		if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)){
			$xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');

			try{
				$response = @new SimpleXMLElement($xml);

				foreach($response as $field=>$value){
					$result[(string)$field] = (string)$value;
				}

				return $result;
			}
			catch(Exception $e){
				$this->errors[] = $e->getMessage();
				return;
			}
		}

		$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
		return;
	}
	public function getLocation()
	{	
		if ($_SERVER['REMOTE_ADDR']=="127.0.0.1")	  
			$locations = $this->getCity("210.211.251.20");
		else{
			$locations = $this->getCity($_SERVER['REMOTE_ADDR']);			
		}
		return $locations;
	}
}
