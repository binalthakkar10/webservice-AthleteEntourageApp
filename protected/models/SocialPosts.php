<?php

Yii::import('application.models._base.BaseSocialPosts');

class SocialPosts extends BaseSocialPosts
{
	public $compaign_message;
	public $post_to_exchange;
	public $total_cost;	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
			public function beforeSave() {

		if ($this->isNewRecord)
		$this->created_date = new CDbExpression('NOW()');
		return parent::beforeSave();
	}
			
	public function getListofSocialData($campaign_id){
		$res = array();
		$response = array();
		$getData = array();
	
		$socialModelData = SocialPosts::model()->findAll("campaign_id= '".$campaign_id."' AND is_delete=1");
		foreach($socialModelData as $userList){
			$res['user_id'] = $userList['user_id'];
			$res['twitter_screen_name'] = $userList['twitter_screen_name'];
			$res['campaign_id'] = $userList['campaign_id'];
			$res['fb_post_id'] = $userList['fb_post_id'];
			$res['twitter_post_id'] = $userList['twitter_post_id'];
			$res['twitter_screen_name'] = $userList['twitter_screen_name'];
			$res['fb_screen_name'] = $userList['fb_screen_name'];
			$res['fb_reach'] = $userList['fb_reach'];
			$res['twitter_reach'] = $userList['twitter_reach'];
			$res['price'] = $userList['price'];		
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
	
	public function getListofsocialMessages($u_id){
		$res = array();
		$response = array();
		$getData = array();
	
		$social = "SELECT social_posts.`campaign_id`,campaign.compaign_message,campaign.user_id,
					user_detail.profile_image 
					FROM campaign 
					JOIN social_posts ON campaign.campaign_id = social_posts.campaign_id 
					JOIN user_detail ON campaign.user_id=user_detail.user_id
					WHERE social_posts.`user_id`='".$u_id."' AND social_posts.is_delete=1";	
		$SocialData = Yii::app()->db->createCommand($social);
		$socialAllData = $SocialData->queryAll();
		
		foreach($socialAllData as $socialList){
			$res['campaign_id'] = $socialList['campaign_id'];
			$res['compaign_message'] = $socialList['compaign_message'];
			$res['user_id'] = $socialList['user_id'];
			$res['profile_image'] = $socialList['profile_image'];	
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
	
	public function searchData() {
		$campaignId = $_REQUEST['id'];	
		$criteria = new CDbCriteria;
		
		$criteria->compare('social_id', $this->social_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('twitter_screen_name', $this->twitter_screen_name, true);
		$criteria->compare('fb_screen_name', $this->fb_screen_name, true);
		$criteria->compare('campaign_id', $this->campaign_id);
		$criteria->compare('fb_post_id', $this->fb_post_id, true);
		$criteria->compare('twitter_post_id', $this->twitter_post_id, true);
		$criteria->compare('fb_reach', $this->fb_reach, true);
		$criteria->compare('twitter_reach', $this->twitter_reach, true);
		$criteria->compare('price', $this->price);
		$criteria->compare('is_exchange', $this->is_exchange);
		$criteria->compare('rated', $this->rated);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('is_delete', $this->is_delete);
		$criteria->addCondition("campaign_id = '".$campaignId."'");

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}		
			
			
}