<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{


	const ERROR_NONE=0;
	const ERROR_NOT_EXIST=1;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
	const ERROR_PASSWORD_INVALID=6;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	//public $email;

	public function __construct($username,$password)
	{
		$this->username=$username;
		//$this->email=$username;
		$this->password=$password;
	}
	public function authenticate()
	{
		//$email = $this->email;
		$criteria = new CDbCriteria();

		//$criteria->select = "t.*, CONCAT_WS(' ', t.`firstname`, t.`lastname`) AS `fullname`";
		$criteria->condition="t.username='".$this->username."'" AND "t.password='".$this->password."'" ;
		//$criteria->condition  = 't.username = \''.$this->username.'\' OR  t.`email` = \''.$email.'\'';
		//$criteria->condition  = ' t.user_type IN(\'admin\',\'superadmin\') AND(t.username= \''.$this->username.'\' OR  t.`email` = \''.$email.'\')';
		$users = Users::model()->find($criteria);
		if(!$users) {
			$this->errorCode=self::ERROR_NOT_EXIST;
		}else {

			$result= array(
			'User_id'=>$users->attributes['id'],
			'EmailAddress'=>$users->attributes['email'],
			 'Name'=>$users->attributes['username'],
			 'Address'=>$users->attributes['address'],
			 'Website'=>$users->attributes['url'],
			 'Lang_id'=>$users->attributes['lang_id'],
			);
			// $this->errorCode=$result;

			$systemPass = $users->password;
			$userPass 	= Yii::app()->getModule('api')->encrypting($this->password);
			if($users===null) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else if($systemPass!==$userPass) {
				$this->errorCode=self::ERROR_PASSWORD_INVALID;

			} else {

				//$this->email	= $users->email;
				$this->username	= $users->username;
				$this->password	= $users->password;
				
		 	 	//print Yii::app()->user->id;
		 		//print Yii::app()->user->getId($users->id);
		 		$this->errorCode= self::ERROR_NONE;
		 		//Yii::app()->user->setId($users->id);
			}
		}
		return !$this->errorCode;
	}


	/*if(!isset($users[$this->username]))
	 $this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
		$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
		}*/

}