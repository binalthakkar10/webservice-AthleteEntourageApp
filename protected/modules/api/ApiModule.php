<?php

class ApiModule extends CWebModule
{
	public $hash='md5';
	public function init()
	{
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'api.models.*',
			'application.models.User.*',
			'api.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{

		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
		return false;
	}
	/**
	 * @return hash string.
	 */
	public static function encrypting($string="") {
		$hash = Yii::app()->getModule('api')->hash;
		if ($hash=="md5")
		return md5($string);
		if ($hash=="sha1")
		return sha1($string);
		else
		return hash($hash,$string);
	}
	public static function getFormatedDate($dateStr, $formatTo='Y-m-d', $formatFrom='F d,Y')
	{
		$ra = date($formatFrom,strtotime($dateStr));
		$dateArr=explode(" ",$ra);
		$data = explode(",",$dateArr[1]);
		$y=$data['0'];
		$m=$data['1'];
		$d=$dateArr['0'];
		$cDate=$y." ".$d.",".$m;
		return date($formatTo,strtotime($ra));
	}

	public static function getUserBasePhotoPath()
	{
		return YiiBase::getPathOfAlias('webroot'). '/uploads/user/';
	}
	public static function getUserBasePhotoUrl()
	{
		return Yii::app()->request->hostInfo.Yii::app()->baseUrl. '/uploads/user/';
	}

	public static function getUserPhoto($id)
	{
		$user = User::model()->findByPk($id);
		if($user &&  $user->image!='' && file_exists(self::getUserBasePhotoPath().$user->image)) {
			return self::getUserBasePhotoUrl().$user->image;
		}
		return false;
	}
	public static function getUserData()
	{
		return self::getUserDataById(Yii::app()->user->id);
	}
	public static function getUserDataById($id)
	{
		$userData= Login::model()->findByPk($id);
		if($userData) {
			return array(
				'id' => $userData->id,
			    'username' => $userData->username,
			    'password' =>$userData->password,
			);
		}
		return false;
	}
}
