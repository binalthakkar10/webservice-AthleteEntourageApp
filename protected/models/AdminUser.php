<?php

Yii::import('application.models.._base.BaseAdminUser');

class AdminUser extends BaseAdminUser
{

	public $rpassword;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}



	public function rules() {
		return array(
		array('user_type, firstname, lastname, email, username, password, created_at, city_id, user_roles', 'required'),
		array('firstname, lastname, email', 'length', 'max'=>30),
		array('user_type, categories_id, city_id', 'length', 'max'=>10),
		array('username', 'length', 'max'=>250),
		array('password', 'length', 'max'=>150),
		array('lognum', 'length', 'max'=>5),
		array('is_active', 'length', 'max'=>1),
		array('user_roles', 'length', 'max'=>255),
		array('updated_at, logdate, extra', 'safe'),
		array('user_type, updated_at, logdate, lognum, is_active, categories_id, extra', 'default', 'setOnEmpty' => true, 'value' => null),
		array('id, firstname, lastname, user_type, email, username, password, created_at, updated_at, logdate, lognum, is_active, categories_id, city_id, user_roles, extra', 'safe', 'on'=>'search'),
		);
	}
	/*public function afterFind()
	 {
		$this->created_at = strtotime($this->created_at);
		$this->created_at = date('m-d-Y', $this->created_at);

		//$this->updated_at = strtotime($this->updated_at);
		//$this->updated_at = date('m/d/Y', $this->updated_at);
		parent::afterFind ();
		}*/

	public function beforeSave() {
		if ($this->isNewRecord)
		$this->created_at = new CDbExpression('NOW()');

		$this->updated_at = new CDbExpression('NOW()');

		return parent::beforeSave();
	}


	public function makeMD5Password($passowrd)
	{
		if(!empty($passowrd)){
			$MD5pwd = md5($passowrd);
			return $MD5pwd;
		}
		return false;
	}


	public function getUserData($userid)
	{
		$resultset=AdminUser::model()->find("id='$userid'");;
		if(isset($resultset->attributes))
		{
			return $resultset->username;
		}else
		return ''; //$code;
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'user_type' => Yii::t('app', 'User Type'),
			'firstname' => Yii::t('app', 'Firstname'),
			'lastname' => Yii::t('app', 'Lastname'),
			'email' => Yii::t('app', 'Email'),
			'password' => Yii::t('app', 'Password'),
			'rpassword' => Yii::t('app', 'Retype Password'),	
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'logdate' => Yii::t('app', 'Logdate'),
			'lognum' => Yii::t('app', 'Lognum'),
			'is_active' => Yii::t('app', 'Is Active'),
			'user_roles' => Yii::t('app', 'User Roles'),
			'extra' => Yii::t('app', 'Extra'),
			'username' => Yii::t('app', 'Username'),
		);
	}

	public function getParentName($id)
	{
		$model = $this->findByPk($id);
		if($model!='')
		{
			return $model->fullname;
		}
		else
		{
			return $model;
		}
	}

	public static function getDefinedUserType()
	{
		return array('admin'=>'Admin','user'=>'Users','retailer'=>'Retailer','advertiser'=>'Advertiser');
	}
	public static function getUserType($key)
	{
		$data = self::getDefinedUserType();
		if(isset($data[$key])) return $data[$key];
	}



}