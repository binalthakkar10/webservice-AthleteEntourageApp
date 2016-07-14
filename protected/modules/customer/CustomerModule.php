<?php

class CustomerModule extends CWebModule
{
	public $returnUrl 	= "/customer/index";
	//public $returnUrl 	= "/customer/cpanel";
	//public $homeUrl 	= "/customer/index";
	public $homeUrl 	= "";
	public $loginUrl 	= "/index/signup";
	public $logoutUrl 	= "/customer/logout";
	public $settingsUrl	= "/customer/index/settings";
	public $accountsUrl	= "/customer/index/accountsettings";
	/**
	 * @var string
	 * @desc hash method (md5,sha1 or algo hash function http://www.php.net/manual/en/function.hash.php)
	 */
	public $hash='md5';

	/**
	 * @var boolean
	 * @desc use email for activation customer account
	 */
	public $sendActivationMail=true;


	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'application.models.*',
			'application.models.User.*',
			'customer.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			$loginAction = TRUE;
			if($controller->id=='index' && $action->id=='login') {
				$loginAction=FALSE;
			}
			if(!Yii::app()->customer->id && $loginAction) {
				Yii::app()->controller->redirect(CustomerModule::getUrl('login'));
			}
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
		return false;
	}

	public static function getUrl($type='home')
	{
		switch($type) {
			case 'home':
				return CustomerCoreController::createUrl(Yii::app()->getModule('customer')->homeUrl);
				break;
			case 'return':
				return CustomerCoreController::createUrl(Yii::app()->getModule('customer')->returnUrl);
				break;
			case 'login':
				return CustomerCoreController::createUrl(Yii::app()->getModule('customer')->loginUrl);
				break;
			case 'logout':
				return CustomerCoreController::createUrl(Yii::app()->getModule('customer')->logoutUrl);
				break;
			case 'settings':
				return CustomerCoreController::createUrl(Yii::app()->getModule('customer')->settingsUrl);
				break;
			case 'accounts':
				return CustomerCoreController::createUrl(Yii::app()->getModule('customer')->accountsUrl);
				break;
		}
	}
	public static function getUserData()
	{
		return self::getCustomer()->attributes; // Yii::app()->customer->getState('customer');
	}

	public static function getUserRoles()
	{
		// return self::getUserDataByKey('user_roles');
		$role = UserRole::model()->find('role_type = \''.CustomerModule::getUserDataByKey('user_type').'\'');
		if($role) {
			if($role->parent_id!=0) return implode(',', array($role->id,$role->parent_id));
			else return $role->id;
		}
		else return -1;
	}
	public static function getUserDataByKey()
	{
		$array = func_get_args(); //explode('.', $path);
		$customerData = self::getCustomer()->attributes; //Yii::app()->customer->getState('customer');
		$str ='';
		$val = $customerData;
		foreach($array as $data) {
			$str .= '[\''.$data.'\']';
			if(!isset($val[$data])) return false;
			$val = $val[$data];
		}
		return $val;
	}

	public static function encrypting($string="") {

		$hash = Yii::app()->getModule('customer')->hash;
		if ($hash=="md5") 	return md5($string);
		if ($hash=="sha1") 	return sha1($string);
		else 				return hash($hash,$string);
	}


	public static function getLoginUrl()
	{
		if(!Yii::app()->customer->id) {
			return Controller::createUrl('/customer/login');
		}else {
			return Controller::createUrl('/customer/logout');
		}
	}
	public static function getLoginText()
	{
		if(!Yii::app()->customer->id) {
			return 'Login';
		}else {
			return 'Logout';
		}
	}

	public static function getFullname()
	{
		if(Yii::app()->customer->id) {
			$customer = self::getCustomer();
			return ucwords($customer->fullname);
		}else {
			return false;
		}
	}

	public static function getWelcomeText()
	{
		if(Yii::app()->customer->id) {
			$customer = self::getCustomer();
			switch ($customer->user_type) {
				case 'venue':
					return ucwords($customer->fullname);
					break;
				default:
					return 'Hello, '.ucwords($customer->fullname);
					break;
			}
		}else {
			return false;
		}
	}
	public static function getCustomer()
	{
		if(Yii::app()->customer->id) {
			$criteria = new CDbCriteria();
			$criteria->select = 't.*, TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) AS age';
			$criteria->addCondition("id=".Yii::app()->customer->id);
			return $customer = Customer::model()->find($criteria);
		}else {
			return false;
		}
	}
	
	
	
	public static function getPhoto($type='icon')
	{
		switch ($type) {
			case 'icon':
				return CHtml::image(Yii::app()->request->baseUrl."/uploads/customer/welcome_user.jpg", self::getFullname());
				break;
			default:
				return CHtml::image(Yii::app()->request->baseUrl."/images/welcome_user.jpg", self::getFullname());
				break;
		}
	}
	public static function getAge()
	{
		if(Yii::app()->customer->id) {
			$customer = self::getCustomer();
			return $customer->age;

		}else {
			return false;
		}
	}

	public function getProfilePhoto()
	{
		if(Yii::app()->customer->id){
			$customer = self::getCustomer();
			if(isset($customer->photo)){
				return $customer->photo;
			}else{
				return false;
			}
		}
	}
	 
	public function getLocation()
	{
		if(Yii::app()->customer->id){
			$customer = self::getCustomer();
			$locationStr	=	"";
			if(isset($customer->attributes)){
				if(isset($customer->country)){
					$locationStr	=	$customer->country;	
				}
				if(isset($customer->state)){
					$locationStr.=",".$customer->state;
				}
				if(isset($customer->city)){
					$locationStr.=",".$customer->city;
				}
				return $locationStr;
			}else{
				return false;
			}
		}
	}
	
}
