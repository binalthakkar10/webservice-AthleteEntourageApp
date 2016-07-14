<?php

Yii::import('application.models.User._base.BaseUsers');

class Users extends BaseUsers
{

	public $city;
	public $display_name;
	public $password_repeat;
	public $repeat_email;
	public $checkbox;
	public $allow_deduction;
	public $renew_date;



	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function getUserData($userid)
	{
		$resultset=Users::model()->find("id='$userid'");
		if(isset($resultset->attributes))
		{
			return $resultset->username;
		}else
		return ''; //$code;
	}
	public function makeMD5Password($passowrd)
	{
		if(!empty($passowrd)){
			$MD5pwd = md5($passowrd);

			return $MD5pwd;
		}
		return false;
	}

	public function rules() {
		return array(
		array('user_type, firstname, lastname, email, username, password', 'required'),
		array('firstname', 'ext.alpha.alpha'),
		array('lastname', 'ext.alpha.alpha'),
		array(
            'username',
            'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
            'message' => 'Invalid characters in username.',
        ),
		array('email','email'),
		array('email', 'unique', 'className' => 'Users', 'attributeName' => 'email', 'message'=>'This Email is already exist!'),
		array('firstname, lastname, email', 'length', 'max'=>30),
		array('user_type, categories_id, city_id', 'length', 'max'=>10),
		array('password', 'length', 'min' => 6,'message' =>'The password must be grether then 6 characters'),
		array('username', 'length', 'max'=>250),
		array('lognum', 'length', 'max'=>5),
		array('is_active', 'length', 'max'=>1),
		array('user_roles', 'length', 'max'=>255),
		array('updated_at, logdate, code', 'safe'),
		array('user_type, updated_at, logdate, lognum, is_active, categories_id, code', 'default', 'setOnEmpty' => true, 'value' => null),
		array('id, firstname, lastname, user_type, email, username, password, created_at, updated_at, logdate, lognum, is_active, categories_id, city_id, user_roles, code', 'safe', 'on'=>'search'),
		);
	}
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('firstname', $this->firstname, true);
		$criteria->compare('lastname', $this->lastname, true);
		$criteria->compare('user_type', $this->user_type, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('password', $this->password, true);
		//$criteria->compare('city_id', $this->city_id, true);
		if(isset($this->city_id) && !empty($this->city_id)){
			$criteria = new CDbCriteria;
			$criteria->select = 't.*, tu.* ';
			$criteria->join = ' LEFT JOIN `city` AS `tu` ON t.city_id = tu.id';
			$criteria->addCondition("city_name='".$this->city_id."'");
		}
		if(isset($this->categories_id) && !empty($this->categories_id)){
			$criteria = new CDbCriteria;
			$criteria->select = 't.*, tu.* ';
			$criteria->join = ' LEFT JOIN `categories` AS `tu` ON t.categories_id= tu.id';
			$criteria->addCondition("category_name='".$this->categories_id."'");
		}

		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('logdate', $this->logdate, true);
		$criteria->compare('lognum', $this->lognum, true);
		$criteria->compare('is_active', $this->is_active, true);
		$criteria->compare('user_roles', $this->user_roles, true);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('username', $this->username, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'firstname' => Yii::t('app', 'Firstname'),
			'lastname' => Yii::t('app', 'Lastname'),
			'user_type' => Yii::t('app', 'User Type'),
			'email' => Yii::t('app', 'Email'),
			'username' => Yii::t('app', 'Username'),
			'password' => Yii::t('app', 'Password'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'logdate' => Yii::t('app', 'Logdate'),
			'lognum' => Yii::t('app', 'Lognum'),
			'is_active' => Yii::t('app', 'Is Active'),
			'categories_id' => Yii::t('app', 'Categories'),
			'city_id' => Yii::t('app', 'City'),
			'user_roles' => Yii::t('app', 'User Roles'),
			'code' => Yii::t('app', 'Code'),
		);
	}

	public static function getDefinedUserType()
	{
		return array('admin'=>'Admin','users'=>'Users','retailer'=>'Retailer','advertiser'=>'Advertiser');
	}

	public static function getUserType($key)
	{
		$data = self::getDefinedUserType();
		if(isset($data[$key])) return $data[$key];
	}

	public function Showusernamedd()
	{
		$user_details = Users::model()->findAll();
		$dd_data = array();
		if(isset($user_details) && !empty($user_details))
		{
			foreach($user_details AS $user)
			{
				$dd_data[$user->id] = $user->firstname.' '.$user->lastname.' ('.$user->username.') - '.$user->user_type;
			}
		}
		return $dd_data;
	}
	public function randomNumberGenerate(){
		$numchars = rand(4,15); 
		$chars = explode(',','a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9'); 
		$random=''; 
		for($i=0; $i<$numchars;$i++)  { 
		  $random.=$chars[rand(0,count($chars)-1)]; 
		} 
		return $random; 
	}
}




