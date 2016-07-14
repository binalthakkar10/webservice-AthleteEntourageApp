<?php
class BaseSession extends CHttpSession {
	public static function getSessionContent() {
		
		if(is_string(Yii::app()->user->getState('baseSession'))) {
			return json_decode(Yii::app()->user->getState('baseSession'), true);
		}else {
			return Yii::app()->user->getState('baseSession');
		}
	}

	public static function setSessionContentField($key, $value) {
		$baseSession = self::getSessionContent();
		$baseSession['root'][$key] = $value;
		return Yii::app()->user->setState('baseSession', json_encode($baseSession));
	}
	/**
	 * dynamic arguement last one is the value of the content.
	 */
	public static function setSessionContentFieldPath($array)
	{
		$baseSession = self::getSessionContent();
		if(!is_array($baseSession)) $baseSession = array('root'=>array());
		$baseSession = array_replace_recursive($baseSession,array('root'=>$array));
		return Yii::app()->user->setState('baseSession', json_encode($baseSession));
	}
	public static function getSessionDataByKey()
	{
		$array = func_get_args(); //explode('.', $path);
		array_unshift($array,'root');
		$sessionData = self::getSessionContent();
		$str ='';
		$val = $sessionData;
		foreach($array as $data) {
			$str .= '[\''.$data.'\']';
			if(!isset($val[$data])) return false;
			$val = $val[$data];
		}
		return $val;
	}
	public static function setSessionContent($baseSession) {
		return Yii::app()->user->setState('baseSession', json_encode($baseSession));
	}


}