<?php

Yii::import('application.models._base.BaseUserDetail');

class UserDetail extends BaseUserDetail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function rules() {
		return array(
			array('user_type, profile_image, display_name,description, facebook_screen_name, twitter_screen_name', 'required'),
			array('profile_image', 'file', 'types'=>'jpg, gif, png'),
		);
	}
	
	/*public function rules() {
		return array(
			array('user_type, device_type, push_score_change, push_get_contacted, push_new_exchanges, push_new_athletes', 'numerical', 'integerOnly'=>true),
			array('impact_score', 'numerical'),
			array('first_name, last_name', 'length', 'max'=>100),
			array('email, oauth_provider, oauth_uid', 'length', 'max'=>250),
			array('phone_number', 'length', 'max'=>50),
			array('device_id', 'length', 'max'=>500),
			array('status', 'length', 'max'=>1),
			array('updated_at', 'safe'),
			array('push_score_change, push_get_contacted, push_new_exchanges, push_new_athletes, updated_at, status', 'default', 'setOnEmpty' => true, 'value' => null),
			array('user_id, user_role, first_name, last_name, email, phone_number, oauth_provider, oauth_uid, device_id, device_type, push_score_change, push_get_contacted, push_new_exchanges, push_new_athletes, impact_score, created_at, updated_at, status', 'safe', 'on'=>'search'),
		);
	}*/
		public function search() {
		$criteria = new CDbCriteria;
		 //$criteria->addCondition("is_delete = 1");
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('user_type', $this->user_type);
		$criteria->compare('profile_image', $this->profile_image, true);
		$criteria->compare('cover_image', $this->cover_image, true);
		$criteria->compare('display_name', $this->display_name, true);
		$criteria->compare('first_name', $this->first_name, true);
		$criteria->compare('last_name', $this->last_name, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('phone_number', $this->phone_number, true);
		$criteria->compare('oauth_provider', $this->oauth_provider, true);
		$criteria->compare('oauth_uid', $this->oauth_uid, true);
		$criteria->compare('device_id', $this->device_id, true);
		$criteria->compare('device_type', $this->device_type);
		$criteria->compare('push_score_change', $this->push_score_change);
		$criteria->compare('push_get_contacted', $this->push_get_contacted);
		$criteria->compare('push_new_exchanges', $this->push_new_exchanges);
		$criteria->compare('push_new_athletes', $this->push_new_athletes);
		$criteria->compare('impact_score', $this->impact_score);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('is_verified', $this->is_verified);
		$criteria->compare('is_featured', $this->is_featured);
		$criteria->compare('facebook_screen_name', $this->facebook_screen_name, true);
		$criteria->compare('twitter_screen_name', $this->twitter_screen_name, true);
		$criteria->compare('ratings', $this->ratings);
		$criteria->compare('fb_followers', $this->fb_followers);
		$criteria->compare('twitter_followers', $this->twitter_followers);
		$criteria->compare('fb_friends', $this->fb_friends);
		$criteria->compare('fb_likes', $this->fb_likes);
		$criteria->compare('twitter_tweets', $this->twitter_tweets);
		$criteria->compare('retweets', $this->retweets);
		$criteria->compare('is_page', $this->is_page);
		$criteria->compare('is_delete', $this->is_delete);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function attributeLabels() {
		return array(
			'user_id' => Yii::t('app', 'User'),
			'user_type' => Yii::t('app', 'User Type'),
			'profile_image' => Yii::t('app', 'Profile Image'),
			'display_name' => Yii::t('app', 'Display Name'),
			'first_name' => Yii::t('app', 'First Name'),
			'last_name' => Yii::t('app', 'Last Name'),
			'description' => Yii::t('app', 'Description'),
			'email' => Yii::t('app', 'Email'),
			'phone_number' => Yii::t('app', 'Phone Number'),
			'oauth_provider' => Yii::t('app', 'Oauth Provider'),
			'oauth_uid' => Yii::t('app', 'Oauth Uid'),
			'device_id' => Yii::t('app', 'Device Token'),
			'device_type' => Yii::t('app', 'Device Type'),
			'push_score_change' => Yii::t('app', 'Push Score Change'),
			'push_get_contacted' => Yii::t('app', 'Push Get Contacted'),
			'push_new_exchanges' => Yii::t('app', 'Push New Exchanges'),
			'push_new_athletes' => Yii::t('app', 'Push New Athletes'),
			'impact_score' => Yii::t('app', 'Impact Score'),
			'created_date' => Yii::t('app', 'Created Date'),
			'is_verified' => Yii::t('app', 'Is Verified'),
			'is_featured' => Yii::t('app', 'Is Featured'),
			'facebook_screen_name' => Yii::t('app', 'Facebook Screen Name'),
			'twitter_screen_name' => Yii::t('app', 'Twitter Handle'),
			'posts' => null,
			'ratings' => null,
		);
	}
	
	public function getListofUser($userData){
		$res = array();
		$response = array();
		$getData = array();
		$userModelData = UserDetail::model()->findAll("user_type = '".$userData."' AND is_delete = 1");
	
		foreach($userModelData as $userList){
			$res['user_id'] = $userList['user_id'];
			$res['user_type'] = $userList['user_type'];
			$res['profile_image'] = $userList['profile_image'];
			$res['cover_image'] = $userList['cover_image'];
			$res['display_name'] = $userList['display_name'];
			$res['first_name'] = $userList['first_name'];
			$res['last_name'] = $userList['last_name'];
			$res['description'] = $userList['description'];
			$res['email'] = $userList['email'];
			$res['phone_number'] = $userList['phone_number'];
			$res['oauth_provider'] = $userList['oauth_provider'];
			$res['oauth_uid'] = $userList['oauth_uid'];
			$res['device_id'] = $userList['device_id'];
			$res['device_type'] = $userList['device_type'];
			$res['push_score_change'] = $userList['push_score_change'];
			$res['push_get_contacted'] = $userList['push_get_contacted'];
			$res['push_new_exchanges'] = $userList['push_new_exchanges'];
			$res['push_new_athletes'] = $userList['push_new_athletes'];
			$res['impact_score'] = $userList['impact_score'];
			$res['created_at'] = $userList['created_date'];
			$res['is_verified'] = $userList['is_verified'];
			$res['is_featured'] = $userList['is_featured'];
			$res['facebook_screen_name'] = $userList['facebook_screen_name'];
			$res['twitter_screen_name'] = $userList['twitter_screen_name'];
			$res['fb_friends'] = $userList['fb_friends'];
			$res['fb_likes'] = $userList['fb_likes'];
			$res['twitter_tweets'] = $userList['twitter_tweets'];
			$res['retweets'] = $userList['retweets'];
			
			//$res['updated_at'] = $userList['updated_at'];
			//$res['status'] = $userList['status'];
			$response[] = $res;
		}
		if($response){
			$getData['status'] = "1";
			$getData['data'] = $response; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Available"; 
			return $getData;
		}
	}

public function getUserDetail($u_id){
		$res = array();
		$response = array();
		$getData = array();
		$userModelData = UserDetail::model()->findAll("user_id = '".$u_id."' AND is_delete=1");
		foreach($userModelData as $userList){
			$res['user_id'] = $userList['user_id'];
			$res['first_name'] = $userList['first_name'];
			$res['last_name'] = $userList['last_name'];
			$res['email'] = $userList['email'];
			$res['phone_number'] = $userList['phone_number'];
			$response[] = $res;
		}
		if($response){
			$getData['status'] = "1";
			$getData['data'] = $response; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Available"; 
			return $getData;
		}
	}
	
	
	public function ListOfFeaturedUser($type,$user_id){
		$res = array();
		$response = array();
		$getData = array();
		if($type==1)
		{
		$userModelData = UserDetail::model()->findAll("user_type = 1 AND is_delete=1 AND (is_verified = 1 OR is_featured = 1 ) AND user_id NOT IN($user_id)");
		foreach($userModelData as $userList){
			$res['user_id'] = $userList['user_id'];
			$res['user_type'] = $userList['user_type'];
			$res['profile_image'] =$userList['profile_image'];
			$res['cover_image'] =$userList['cover_image'];
			$res['display_name'] = $userList['display_name'];
			$res['description'] = $userList['description'];
			$res['device_id'] = $userList['device_id'];
			$res['device_type'] = $userList['device_type'];
			$res['push_score_change'] = $userList['push_score_change'];
			$res['push_get_contacted'] = $userList['push_get_contacted'];
			$res['push_new_exchanges'] = $userList['push_new_exchanges'];
			$res['push_new_athletes'] = $userList['push_new_athletes'];
			$res['created_at'] = $userList['created_date'];
			$res['is_verified'] = $userList['is_verified'];
			$res['is_featured'] = $userList['is_featured'];
			$res['impact_score'] = $userList['impact_score'];
			$res['facebook_screen_name'] = $userList['facebook_screen_name'];
			$res['twitter_screen_name'] = $userList['twitter_screen_name'];
			$res['fb_followers'] = $userList['fb_followers'];
			$res['twitter_followers'] = $userList['twitter_followers'];
			$res['fb_friends'] = $userList['fb_friends'];
			$res['fb_likes'] = $userList['fb_likes'];
			$res['twitter_tweets'] = $userList['twitter_tweets'];
			$res['retweets'] = $userList['retweets'];
			$response[] = $res;
		}
		
		}elseif($type==2){
			$userModelData = UserDetail::model()->findAll("user_type = 1 AND is_delete = 1 AND (is_verified = 1 OR is_featured = 1)");
		foreach($userModelData as $userList){
			$res['user_id'] = $userList['user_id'];
			$res['user_type'] = $userList['user_type'];   
			$res['profile_image'] =$userList['profile_image'];
			$res['cover_image'] =$userList['cover_image'];
			$res['display_name'] = $userList['display_name'];
			$res['description'] = $userList['description'];
			$res['device_id'] = $userList['device_id'];
			$res['device_type'] = $userList['device_type'];
			$res['push_score_change'] = $userList['push_score_change'];
			$res['push_get_contacted'] = $userList['push_get_contacted'];
			$res['push_new_exchanges'] = $userList['push_new_exchanges'];
			$res['push_new_athletes'] = $userList['push_new_athletes'];
			$res['created_at'] = $userList['created_date'];
			$res['is_verified'] = $userList['is_verified'];
			$res['is_featured'] = $userList['is_featured'];
			$res['impact_score'] = $userList['impact_score'];
			$res['facebook_screen_name'] = $userList['facebook_screen_name'];
			$res['twitter_screen_name'] = $userList['twitter_screen_name'];
			$res['twitter_followers'] = $userList['twitter_followers'];
			$res['fb_friends'] = $userList['fb_friends'];
			$res['fb_likes'] = $userList['fb_likes'];
			$res['twitter_tweets'] = $userList['twitter_tweets'];
			$res['retweets'] = $userList['retweets'];
			$response[] = $res;
		}	
			
		}
		
		if($response){
			$getData['status'] = "1";
			$getData['data'] = $response; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Available"; 
			return $getData;
		}
	}
	
	
	
	public function getListOfSearchData($searchData){
		$res = array();
		$response = array();
		$getData = array();
		$firstname = $data['data']['first_name'];
		$lastname = $data['data']['last_name'];
		$userModelData = UserDetail::model()->find("first_name LIKE '%".$firstname."%' OR last_name LIKE '%".$lastname."%'");
		if($userModelData){
			$res['user_id'] = $userList['user_id'];
			$res['user_role'] = $userList['user_role'];
			$res['first_name'] = $userList['first_name'];
			$res['last_name'] = $userList['last_name'];
			$res['email'] = $userList['email'];
			$res['phone_number'] = $userList['phone_number'];
			$res['oauth_provider'] = $userList['oauth_provider'];
			$res['oauth_uid'] = $userList['oauth_uid'];
			$res['device_id'] = $userList['device_id'];
			$res['device_type'] = $userList['device_type'];
			$res['push_score_change'] = $userList['push_score_change'];
			$res['push_get_contacted'] = $userList['push_get_contacted'];
			$res['push_new_exchanges'] = $userList['push_new_exchanges'];
			$res['push_new_athletes'] = $userList['push_new_athletes'];
			$res['impact_score'] = $userList['impact_score'];
			$res['created_at'] = $userList['created_at'];
			$res['updated_at'] = $userList['updated_at'];
			$res['status'] = $userList['status'];
			$response[] = $res;
			$getData['status'] = "1";
			$getData['data'] = $response; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Found"; 
			return $getData;
		}
		}

		public function getDisplayName($user_id)
		{
		$modelData = UserDetail::model()->find('user_id = "'.$user_id.'"');
		return $modelData->display_name;
		}
		public function getUserNames()
			{
			$response=array();	
			$modelData = UserDetail::model()->findAll(array('select'=>'user_id,display_name'));
			foreach($modelData as $userList)
			{
				$response[$userList['user_id']]=$userList['display_name'];
			}
					if($response){
				return $response;	
				}else{
				return false;
					}
			}
		public function getUsertype($user_type)
		{
			if($user_type==1)
			{
				$uname='Athlete';
				return $uname;
			}
			elseif($user_type==2)
			{
				$uname='Entourage';
				return $uname;
			}
		}



}