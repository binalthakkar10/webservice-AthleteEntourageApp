<?php
class ApiController extends GxController
{
	public $format = 'json';


	public function init()
	{
		parent::init();
		
		
	}
	public function getAPIDataStruct()
	{
		if (Yii::app()->request->getRequestType()=='GET') {
			$params = $_GET;
		}else if (Yii::app()->request->getRequestType()=='POST') {
			$params = $_POST;
		}else if (Yii::app()->request->getRequestType()=='REQUEST') {
			$params = $_REQUEST;
		}
		//$params = Yii::app()->request->getRequestType()=='GET';
		$params = '$_'.Yii::app()->request->getRequestType();
		$data = array(
		/*
			'request' => array(
			'method'=>  Yii::app()->request->getPathInfo(),
			//	'request_type'=>  '',
			'params' => $params
			),
			*/
			'response' => array('success'=>'', 'error'=>array())
		);
		return $data;
	}

	protected function _sendResponse($status = 200, $body = '', $content_type = 'text/xml')
	{
		$this->_checkAuth();
		// set the status
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);
		// and the content type

		header('Content-type: ' . $content_type);



		// pages with body are easy
		if($body != '')
		{
			// send the body
			echo $body;
			exit;
		}
		// we need to create the body if none is passed
		else
		{
			// create some body messages
			$message = '';

			// this is purely optional, but makes the pages a little nicer to read
			// for your users.  Since you won't likely send a lot of different status codes,
			// this also shouldn't be too ponderous to maintain
			switch($status)
			{
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = 'The requested method is not implemented.';
					break;
			}

			// servers don't always have a signature turned on
			// (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

			// this should be templated in a real-world solution
			$body = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
</head>
<body>
    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
    <p>' . $message . '</p>
    <hr />
    <address>' . $signature . '</address>
</body>
</html>';

			echo $body;
			exit;
		}
	}

	protected function _getStatusCodeMessage($status)
	{

		$this->_checkAuth();
		// these could be stored in a .ini file and loaded
		// via parse_ini_file()... however, this will suffice
		// for an example
		$codes = Array(
		200 => 'OK',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		);

		return (isset($codes[$status])) ? $codes[$status] : '';
	}

	protected function _checkAuth()
	{
		return;
		// Check if we have the USERNAME and PASSWORD HTTP headers set?
		if(!(isset($_SERVER['HTTP_X_USERNAME']) and isset($_SERVER['HTTP_X_PASSWORD']))) {
			// Error: Unauthorized
			$this->_sendResponse(401);
		}
		$username = $_SERVER['HTTP_X_USERNAME'];
		$password = $_SERVER['HTTP_X_PASSWORD'];
		// Find the user
		$user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
		if($user===null) {
			// Error: Unauthorized
			$this->_sendResponse(401, 'Error: User Name is invalid');
		} else if(!$user->validatePassword($password)) {
			// Error: Unauthorized
			$this->_sendResponse(401, 'Error: User Password is invalid');
		}
	}

	/**
	 * Converts an array to Xml
	 *
	 * @param mixed $arData The array to convert
	 * @param mixed $sRootNodeName The name of the root node in the returned Xml
	 * @param string $sXml The converted Xml
	 */
	public function arrayToXml( $arData, $sRootNodeName = 'data', $sXml = null , $nodeString = null)
	{
		//p($arData['response']['repairers_details'][0]['rep_address2']);
		// turn off compatibility mode as simple xml doesn't like it
		if ( 1 == ini_get( 'zend.ze1_compatibility_mode' ) )
		ini_set( 'zend.ze1_compatibility_mode', 0 );

		if ( null == $sXml )
		$sXml = simplexml_load_string( "<?xml version='1.0' encoding='utf-8'?><{$sRootNodeName} />" );

		// loop through the data passed in.
		foreach ( $arData as $_sKey => $_oValue )
		{
			//echo $_sKey ."<br/>";
			// no numeric keys in our xml please!
			if ( is_numeric($_sKey ) ) {
				//$_sKey = "node_". ( string )$_sKey;
				$_sKey = $nodeString. ( string )$_sKey;
			}
			//p($_sKey);

			// replace anything not alpha numeric
			if($_sKey != 'rep_address1' &&  $_sKey != 'rep_address2' )
			{
				$_sKey = preg_replace( '/[^a-z]/i', '', $_sKey );
			}
			// if there is another array found recrusively call this function

			if ( is_array( $_oValue ) )
			{

				$_oNode = $sXml->addChild( $_sKey );

				self::arrayToXml( $_oValue, $sRootNodeName, $_oNode,  $nodeString);
			}
			else
			{
				// add single node.
				$_oValue = htmlentities( $_oValue );
				$sXml->addChild( $_sKey, $_oValue );
			}
		}

		return( $sXml->asXML() );
	}

	/**
	 * Returns an Xml string representation of an array of CActiveRecords
	 *
	 * @param array $oRS
	 * @param array $arOptions
	 */

	public function xml2array($contents, $get_attributes=1, $priority = 'tag') {

		if(!$contents) return array();

		if(!function_exists('xml_parser_create')) {
			//print "'xml_parser_create()' function not found!";
			return array();
		}

		//Get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create('');

		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($contents), $xml_values);
		xml_parser_free($parser);

		if(!$xml_values) return;//Hmm...

		//Initializations
		$xml_array = array();
		$parents = array();
		$opened_tags = array();
		$arr = array();
		//print_r($arr);
		//exit;
		$current = &$xml_array; //Refference

		//Go through the tags.
		$repeated_tag_index = array();//Multiple tags with same name will be turned into an array
		foreach($xml_values as $data) {
			unset($attributes,$value);//Remove existing values, or there will be trouble

			//This command will extract these variables into the foreach scope
			// tag(string), type(string), level(int), attributes(array).
			extract($data);//We could use the array by itself, but this cooler.

			$result = array();
			$attributes_data = array();

			if(isset($value)) {
				if($priority == 'tag') $result = $value;
				else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
			}

			//Set the attributes too.
			if(isset($attributes) and $get_attributes) {
				foreach($attributes as $attr => $val) {
					if($priority == 'tag') $attributes_data[$attr] = $val;
					else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
				}
			}

			//See tag status and do the needed.
			if($type == "open") {//The starting of the tag '<tag>'
				$parent[$level-1] = &$current;
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
					$current[$tag] = $result;
					if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
					$repeated_tag_index[$tag.'_'.$level] = 1;

					$current = &$current[$tag];

				} else { //There was another element with the same tag name

					if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
						$repeated_tag_index[$tag.'_'.$level]++;
					} else {//This section will make the value an array if multiple tags with the same name appear together
						$current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag.'_'.$level] = 2;

						if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
							$current[$tag]['0_attr'] = $current[$tag.'_attr'];
							unset($current[$tag.'_attr']);
						}

					}
					$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
					$current = &$current[$tag][$last_item_index];
				}

			} elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
				//See if the key is already taken.
				if(!isset($current[$tag])) { //New Key
					$current[$tag] = $result;
					$repeated_tag_index[$tag.'_'.$level] = 1;
					if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

				} else { //If taken, put all things inside a list(array)
					if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

						// ...push the new element into that array.
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

						if($priority == 'tag' and $get_attributes and $attributes_data) {
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
						}
						$repeated_tag_index[$tag.'_'.$level]++;

					} else { //If it is not an array...
						$current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag.'_'.$level] = 1;
						if($priority == 'tag' and $get_attributes) {
							if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well

								$current[$tag]['0_attr'] = $current[$tag.'_attr'];
								unset($current[$tag.'_attr']);
							}

							if($attributes_data) {
								$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
							}
						}
						$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
					}
				}

			} elseif($type == 'close') { //End of tag '</tag>'
				$current = &$parent[$level-1];
			}
		}

		return($xml_array);
	}
}