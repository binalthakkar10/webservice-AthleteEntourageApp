<?php

Yii::import('application.models._base.BaseCampaign');

class Campaign extends BaseCampaign
{
	public $twitter_screen_name;
	public $tcampaign;	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function beforeSave() {
		if ($this->isNewRecord)
		$this->created_date = new CDbExpression('NOW()');

		//$this->updated_at = new CDbExpression('NOW()');

		return parent::beforeSave();
	}
	public function search() {
		$criteria = new CDbCriteria;
		
		$criteria->select = 't.campaign_id as tcampaign,t.compaign_message,t.post_to_exchange,t.created_date,t.total_cost,p.campaign_id,p.twitter_screen_name,t.is_delete';
		$criteria->join = 'LEFT JOIN campaign_partner p ON t.campaign_id = p.campaign_id';
		$criteria->compare('t.campaign_id', $this->campaign_id);
		$criteria->compare('t.compaign_message', $this->compaign_message, true);
		$criteria->compare('t.post_to_exchange', $this->post_to_exchange);
		$criteria->compare('t.created_date', $this->created_date, true);
		$criteria->compare('t.total_cost', $this->total_cost);
		$criteria->addCondition("is_close = '0'");
		$criteria->addCondition("t.is_delete = '1'");
		
        $criteria->group  = 'tcampaign';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
		
	public function getListofCampaign($u_id){
		$res = array();
		$response = array();
		$getData = array();
		$getMediaData = array();
		$getMediaData1 = array();
		$mediaData =array();
		$command = 	"SELECT campaign . * , user_detail.profile_image,user_detail.user_type,user_detail.is_delete
					FROM `campaign` LEFT JOIN user_detail ON campaign.`user_id` = user_detail.`user_id` WHERE campaign.`user_id` ='".$u_id."' AND campaign.is_delete=1 AND user_detail.is_delete = 1";
		$cmd1 = Yii::app()->db->createCommand($command);
		$userModelData = $cmd1->queryAll();
		//$userModelData = Campaign::model()->findAll("user_id= '".$u_id."'");
		
		foreach($userModelData as $userList){
			
			
			$res['campaign_id'] = $userList['campaign_id'];
			$res['compaign_message'] = $userList['compaign_message'];
			$res['post_to_exchange'] = $userList['post_to_exchange'];
			$res['created_date'] = $userList['created_date'];
			$res['total_cost'] = $userList['total_cost'];
			$res['is_campaign'] = $userList['is_campaign'];	
			$res['profile_image'] = $userList['profile_image'];	
			$res['user_type'] = $userList['user_type'];		
			$response[]['record'] = $res;
			
		}
				$count = count($response);
			
			for ($i=0; $i < $count; $i++) { 
				$appmediaDetails = Media::model()->find("campaign_id = '".$response[$i]['record']['campaign_id']."'");
				if($appmediaDetails){
							$mediaData['file_name'] = $appmediaDetails['file_name'];
							$mediaData['media_type']= $appmediaDetails['media_type'];
							$getMediaData[$i]['media'] = $mediaData;
							
				}
				if(empty($getMediaData[$i]) && !empty($response[$i])){
					$getMediaData1[] = $response[$i];
				}else{
					$getMediaData1[] = array_merge($response[$i],$getMediaData[$i]);	
				}	
			}
		if($getMediaData1){
			$getData['status'] = "1";
			$getData['data'] = $getMediaData1; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Available"; 
			return $getData;
		}
	}
			public function getCampaignPartnerData($type){
			
		$res = array();
		$resCustom = array();
		$getarray = array();
		$getarrayCustom = array();
		$getData =  array();
		$getMedia = array();
		$getMediaData = array();
		$getMediaData1 = array();
		$mediaData =array();
		$finalArray=array();
			$partnerData = CampaignPartner::model()->find("twitter_screen_name='".$type."' AND is_delete = 1");
				//$partnerData = CampaignPartner::model()->find();
			if($partnerData!="")
			{
				$userData = UserDetail::model()->find("twitter_screen_name='".$type."' AND is_delete = 1");
				$profileImage=$userData['profile_image'];
				$user_type=$userData['user_type'];
				$user_id=$userData['user_id'];
				if($user_type==2)
				{
					//------------- FOR Other packages other than Custom-----
						$command="SELECT c.*,c.user_id as userid,cp.impact_score, cp.is_member, cp.is_verified, cp.price, cp.reach, cp.twitter_screen_name,user_detail.user_type,user_detail.profile_image,user_detail.is_delete
						FROM campaign_partner AS cp, campaign AS c JOIN user_detail ON c.user_id = user_detail.user_id WHERE cp.twitter_screen_name='".$type."' AND c.package_name!='Custom' AND c.campaign_id NOT
						IN (SELECT campaign_id FROM social_posts WHERE twitter_screen_name = '".$type."') AND c.is_close =0 AND c.is_paid=1 AND user_detail.is_delete = 1 GROUP BY c.campaign_id ORDER BY c.campaign_id DESC";		 
						$cmd1 = Yii::app()->db->createCommand($command);
						$userModelData = $cmd1->queryAll();
						foreach($userModelData as $userList){	
						$res['campaign_id'] = $userList['campaign_id'];
						$userImage = UserDetail::model()->find("user_id = '".$userList['userid']."'");
						$res['profile_image'] = $userImage['profile_image'];
						$res['compaign_message'] = $userList['compaign_message'];
						$res['post_to_exchange'] = $userList['post_to_exchange'];
						$res['created_date'] = $userList['created_date'];
						$res['twitter_screen_name'] = $userList['twitter_screen_name'];
						$res['is_member'] = $userList['is_member'];
						$res['user_type'] = $userList['user_type'];
						$res['is_verified'] = $userList['is_verified'];
						$res['impact_score'] = $userList['impact_score'];
						$res['price'] = $userList['price'];
						$res['reach'] = $userList['reach'];
						$res['is_paid'] = $userList['is_paid'];
						$getarray[] ['record']= $res;
							}
						
					//------- For custom packages---------
					
					
					$commandCustom="SELECT c.*,c.user_id as userid,cp.impact_score, cp.is_member, cp.is_verified, cp.price, cp.reach, cp.twitter_screen_name,user_detail.user_type,user_detail.is_delete
									 FROM `campaign` as c JOIN `campaign_partner` as cp 
									ON c.campaign_id= cp.campaign_id
									JOIN user_detail ON c.user_id = user_detail.user_id
									WHERE `package_name`='Custom' AND cp.twitter_screen_name = '".$type."' AND c.campaign_id 
									NOT IN (SELECT campaign_id FROM social_posts WHERE twitter_screen_name = '".$type."') AND c.is_close =0 AND c.is_paid=1 AND user_detail.is_delete = 1 GROUP BY c.campaign_id ORDER BY c.campaign_id DESC";		 
						$cmdCustom = Yii::app()->db->createCommand($commandCustom);
						$userModelDataCustom = $cmdCustom->queryAll();
						if($userModelDataCustom){
								foreach($userModelDataCustom as $userListCustom){	
								$resCustom['campaign_id'] = $userListCustom['campaign_id'];
								$userImageCustom = UserDetail::model()->find("user_id = '".$userListCustom['userid']."'");
								$resCustom['profile_image'] = $userImageCustom['profile_image'];
								$resCustom['compaign_message'] = $userListCustom['compaign_message'];
								$resCustom['post_to_exchange'] = $userListCustom['post_to_exchange'];
								$resCustom['created_date'] = $userListCustom['created_date'];
								$resCustom['twitter_screen_name'] = $userListCustom['twitter_screen_name'];
								$resCustom['is_member'] = $userListCustom['is_member'];
								$resCustom['user_type'] = $userListCustom['user_type'];
								$resCustom['is_verified'] = $userListCustom['is_verified'];
								$resCustom['impact_score'] = $userListCustom['impact_score'];
								$resCustom['price'] = $userListCustom['price'];
								$resCustom['reach'] = $userListCustom['reach'];
								$resCustom['is_paid'] = $userListCustom['is_paid'];
								$getarrayCustom[] ['record']= $resCustom;
									}
						}
							
						if($getarrayCustom){
					$finalArray=(array_merge($getarray,$getarrayCustom));
					}
						
						
							
				}elseif($user_type==1){
							
						$command="SELECT c. *,c.user_id as userid,cp.impact_score, cp.is_member, cp.is_verified, cp.price, cp.reach, cp.twitter_screen_name,user_detail.user_type,user_detail.is_delete
						FROM campaign_partner AS cp, campaign AS c JOIN user_detail ON c.user_id = user_detail.user_id WHERE cp.twitter_screen_name='".$type."'AND c.package_name!='Custom' AND user_detail.user_id NOT IN(SELECT user_id FROM `campaign` WHERE `user_id`='".$user_id."') 
						AND c.campaign_id NOT IN (SELECT campaign_id FROM social_posts WHERE twitter_screen_name = '".$type."') AND c.is_close =0 AND c.is_paid=1 AND user_detail.is_delete = 1 GROUP BY c.campaign_id ORDER BY c.campaign_id DESC";		 
						$cmd1 = Yii::app()->db->createCommand($command);
						$userModelData = $cmd1->queryAll();
						foreach($userModelData as $userList){	
						$res['campaign_id'] = $userList['campaign_id'];
						$userImage = UserDetail::model()->find("user_id = '".$userList['userid']."'");
						$res['profile_image'] = $userImage['profile_image'];
						$res['compaign_message'] = $userList['compaign_message'];
						$res['post_to_exchange'] = $userList['post_to_exchange'];
						$res['created_date'] = $userList['created_date'];
						$res['twitter_screen_name'] = $userList['twitter_screen_name'];
						$res['is_member'] = $userList['is_member'];
						$res['user_type'] = $userList['user_type'];
						$res['is_verified'] = $userList['is_verified'];
						$res['impact_score'] = $userList['impact_score'];
						$res['price'] = $userList['price'];
						$res['reach'] = $userList['reach'];
						$res['is_paid'] = $userList['is_paid'];
						$getarray[] ['record']= $res;
							}
						
					
						
							$commandCustom="SELECT c.*,c.user_id as userid,cp.impact_score, cp.is_member, cp.is_verified, cp.price, cp.reach, cp.twitter_screen_name,user_detail.user_type,user_detail.is_delete
									 FROM `campaign` as c JOIN `campaign_partner` as cp 
									ON c.campaign_id= cp.campaign_id
									JOIN user_detail ON c.user_id = user_detail.user_id
									WHERE `package_name`='Custom' AND cp.twitter_screen_name = '".$type."' AND c.campaign_id 
									NOT IN (SELECT campaign_id FROM social_posts WHERE twitter_screen_name = '".$type."') AND c.is_close =0 AND c.is_paid=1 AND user_detail.is_delete = 1 GROUP BY c.campaign_id ORDER BY c.campaign_id DESC";		 
						$cmdCustom = Yii::app()->db->createCommand($commandCustom);
						$userModelDataCustom = $cmdCustom->queryAll();
						if($userModelDataCustom){
								foreach($userModelDataCustom as $userListCustom){	
								$resCustom['campaign_id'] = $userListCustom['campaign_id'];
								$userImageCustom = UserDetail::model()->find("user_id = '".$userListCustom['userid']."'");
								$resCustom['profile_image'] = $userImageCustom['profile_image'];
								$resCustom['compaign_message'] = $userListCustom['compaign_message'];
								$resCustom['post_to_exchange'] = $userListCustom['post_to_exchange'];
								$resCustom['created_date'] = $userListCustom['created_date'];
								$resCustom['twitter_screen_name'] = $userListCustom['twitter_screen_name'];
								$resCustom['is_member'] = $userListCustom['is_member'];
								$resCustom['user_type'] = $userListCustom['user_type'];
								$resCustom['is_verified'] = $userListCustom['is_verified'];
								$resCustom['impact_score'] = $userListCustom['impact_score'];
								$resCustom['price'] = $userListCustom['price'];
								$resCustom['reach'] = $userListCustom['reach'];
								$resCustom['is_paid'] = $userListCustom['is_paid'];
								$getarrayCustom[] ['record']= $resCustom;
									}
						
						
						}
					if($getarrayCustom){
					$finalArray=(array_merge($getarray,$getarrayCustom));
						
					}
						
						
						
				}
	}else{
		

					$command="SELECT c. * , user_detail.profile_image,user_detail.twitter_screen_name,user_detail.is_verified,user_detail.impact_score,user_detail.user_type,user_detail.is_delete
						FROM  campaign AS c JOIN user_detail ON c.user_id = user_detail.user_id WHERE c.campaign_id NOT
						IN (SELECT campaign_id FROM social_posts WHERE twitter_screen_name = '".$type."') AND c.is_close =0 AND c.is_paid=1 AND user_detail.is_delete = 1 GROUP BY c.campaign_id ORDER BY c.campaign_id DESC";		 
			$cmd1 = Yii::app()->db->createCommand($command);
			$userModelData = $cmd1->queryAll();
		foreach($userModelData as $userList){	
			$res['campaign_id'] = $userList['campaign_id'];
			$res['profile_image'] = $userList['profile_image'];
			$res['compaign_message'] = $userList['compaign_message'];
			$res['post_to_exchange'] = $userList['post_to_exchange'];
			$res['created_date'] = $userList['created_date'];
			$res['twitter_screen_name'] = $userList['twitter_screen_name'];
			$res['is_member'] = "1";
			$res['is_verified'] = $userList['is_verified'];
			$res['impact_score'] = $userList['impact_score'];
			$res['user_type'] = $userList['user_type'];
			$res['price'] = "0";
			$res['reach'] = "0";
			$res['is_paid'] = $userList['is_paid'];
			$getarray[] ['record']= $res;
		
	}	
	}
		
		
		if($finalArray){
					$count = count($finalArray);
			
			for ($i=0; $i < $count; $i++) { 
				$appmediaDetails = Media::model()->find("campaign_id = '".$finalArray[$i]['record']['campaign_id']."' AND is_delete = 1");
				if($appmediaDetails){
							$mediaData['file_name'] = $appmediaDetails['file_name'];
							$mediaData['media_type']= $appmediaDetails['media_type'];
							$getMediaData[$i]['media'] = $mediaData;
							
				}
				if(empty($getMediaData[$i]) && !empty($finalArray[$i])){
					$getMediaData1[] = $finalArray[$i];
				}else{
					$getMediaData1[] = array_merge($finalArray[$i],$getMediaData[$i]);	
				}	
			}
			
		}else{
						
					
				$count = count($getarray);
			
			for ($i=0; $i < $count; $i++) { 
				$appmediaDetails = Media::model()->find("campaign_id = '".$getarray[$i]['record']['campaign_id']."' AND is_delete = 1");
				if($appmediaDetails){
							$mediaData['file_name'] = $appmediaDetails['file_name'];
							$mediaData['media_type']= $appmediaDetails['media_type'];
							$getMediaData[$i]['media'] = $mediaData;
							
				}
				if(empty($getMediaData[$i]) && !empty($getarray[$i])){
					$getMediaData1[] = $getarray[$i];
				}else{
					$getMediaData1[] = array_merge($getarray[$i],$getMediaData[$i]);	
				}	
			}
			
		}
		
		
		if($getMediaData1){
			$getData['status'] = "1";
			$getData['data'] = $getMediaData1; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Available"; 
			return $getData;
		}
	}
	public function getCampaignmessage($campaign_id)
	{
		$modelData = Campaign::model()->find('campaign_id = "'.$campaign_id.'"');
		
		return $modelData->compaign_message;
	}
	public function getCampaignData()
	{
		$response=array();
	    $UserScreenName="SELECT campaign.*,user_detail.twitter_screen_name FROM `campaign` JOIN user_detail ON campaign.`user_id`= user_detail.`user_id` GROUP BY campaign.`user_id`";
		$userData = Yii::app()->db->createCommand($UserScreenName);
		$usersocial = $userData->queryAll();
		foreach($usersocial as $userList)
		{
			$response[$userList['user_id']]=$userList['twitter_screen_name'];
		}
		if($response){
			return $response;	
		}else{
			return false;
		}
		
			
	}	
		
		
}