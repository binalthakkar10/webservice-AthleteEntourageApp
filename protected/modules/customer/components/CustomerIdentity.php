<?php
/**
 * CustomerIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CustomerIdentity extends UserIdentity
{
	private $_id;
	const ERROR_NONE=0;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
	const ERROR_PASSWORD_INVALID=6;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the email and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public $email;

	public function __construct($username,$password)
	{
		$this->username=$username;
		$this->email=$username;
		$this->password=$password;
	}

	public function authenticate()
	{
		$email = $this->username;
		$password=md5($this->password);
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*";
		$criteria->addCondition(' (t.`email` = \''.$email.'\' AND t.`password`=\''.$password.'\')');
		$customer = Users::model()->find($criteria);
		
		 
		//$customer=Users::model()->findByAttributes(array('email'=>$email),$criteria);
		
		
		if($customer===null) {
			$this->errorCode=self::ERROR_EMAIL_INVALID;
		} else if(Yii::app()->getModule('customer')->encrypting($this->password)!==$customer->password) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		} else if($customer->is_active>1&&Yii::app()->getModule('customer')->activation!='') {
			$this->errorCode=self::ERROR_STATUS_NOTACTIV;
		} else if($customer->is_active==2) {
			$this->errorCode=self::ERROR_STATUS_BAN;
		} else {
			$this->_id		= $customer->id;
			$this->email	= $customer->email;
			$this->username	= $customer->email;
			$this->errorCode= self::ERROR_NONE;
			
			Yii::app()->customer->setId($this->_id);
			//Yii::app()->customer->email = $customer->email;
			Yii::app()->customer->guestName = $customer->email;
			Yii::app()->customer->fullname = $customer->firstname.' '.$customer->lastname;
			
			Yii::app()->customer->name = strtolower($customer->user_type);
			/*Yii::app()->getModule('customer')->setId($this->_id);
			Yii::app()->customer->name = strtolower($customer->user_type);*/	
			$customerData = $customer->attributes;
			$customerData['display_name'] = $customer->display_name;
			//Yii::app()->user->setState('email','asdfgh'); 
			Yii::app()->customer->setState('customer',$customerData);
		 
			
		}
		return !$this->errorCode;
	}

	public function authenticatesignup()
	{
		$email = $this->username;
		$criteria = new CDbCriteria();
		$criteria->select = "t.*";
		$criteria->addCondition(' (t.`email` = \''.$email.'\')');
		$customer = Users::model()->find($criteria);
		 
		//$customer=customer::model()->findByAttributes(array('email'=>$email),$criteria);
		
			$this->_id		= $customer->id;
			$this->email	= $customer->email;
			$this->username	= $customer->email;
			$this->errorCode= self::ERROR_NONE;
			
			Yii::app()->customer->setId($this->_id);
			//Yii::app()->customer->email = $customer->email;
			Yii::app()->customer->guestName = $customer->email;
			Yii::app()->customer->fullname = $customer->firstname.' '.$customer->lastname;
			Yii::app()->customer->name = strtolower($customer->user_type);	
			/*Yii::app()->getModule('customer')->setId($this->_id);
			Yii::app()->customer->name = strtolower($customer->user_type);*/	
			$customerData = $customer->attributes;
			$customerData['display_name'] = $customer->display_name;
			//Yii::app()->user->setState('email','asdfgh'); 
			Yii::app()->customer->setState('customer',$customerData);
		
		return !$this->errorCode;
	}
	
	
	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}