<?php

/**
 * CustomerIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends UserIdentity
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
		$email = $this->email;
		$criteria = new CDbCriteria();
		//$email="gaurav@inheritx.com";
		$criteria->select = "t.*, CONCAT_WS(' ', t.`firstname`, t.`lastname`) AS `fullname`";
		//$criteria->condition  = ' t.user_type = IN(\'admin\',\'user\') AND(t.username = \''.$this->username.'\' OR  t.`email` = \''.$email.'\')';
		$criteria->condition  = ' t.user_type IN(\'admin\',\'superadmin\') AND(t.username= \''.$this->username.'\' OR  t.`email` = \''.$email.'\')';
		$admin = User::model()->find($criteria);
	
		
		if($admin===null) {
			$this->errorCode=self::ERROR_EMAIL_INVALID;
			Yii::app()->admin->setFlash('error','Invalid username and password please try again !');
		} else if(Yii::app()->getModule('admin')->encrypting($this->password)!==$admin->password) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			Yii::app()->admin->setFlash('error','Invalid username and password please try again !');
		//} else if($admin->status==0&&Yii::app()->getModule('admin')->loginNotActive==false) {
			//$this->errorCode=self::ERROR_STATUS_NOTACTIV;
	/*	} else if($admin->status==-1) {
			$this->errorCode=self::ERROR_STATUS_BAN;*/
		} else {
			$this->_id		= $admin->id;
			$this->email	= $admin->email;
			$this->username	= $admin->email;
			$this->errorCode= self::ERROR_NONE;
			Yii::app()->admin->setId($this->_id);
			Yii::app()->admin->guestName = $admin->email;
			Yii::app()->admin->name = strtolower($admin->user_type);
			
			//Yii::app()->admin->fullname = $admin->username;
			
			$adminData = $admin->attributes;
			$adminData['fullname'] = $admin->username;
			Yii::app()->admin->setState('admin',$adminData);
		}
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