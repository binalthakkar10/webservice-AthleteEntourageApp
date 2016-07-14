<?php

Yii::import('application.models._base.BasePostToExchange');

class PostToExchange extends BasePostToExchange
{
	public $compaign_message;
	public $display_name;	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function label($n = 1) {
		return Yii::t('app', 'Exchange Posts|Exchange Posts', $n);
	}
	public function beforeSave() {
		if ($this->isNewRecord)
		$this->created_date = new CDbExpression('NOW()');
		//$this->start_date = new CDbExpression('NOW()');
		//$this->end_date = new CDbExpression('NOW() + INTERVAL 7 DAY');
		//$this->updated_at = new CDbExpression('NOW()');

		return parent::beforeSave();
	}	
	public function search() {
		$criteria = new CDbCriteria;
		
		$criteria->select = 't.campaign_id as tcampaignid,t.postexchange_id,t.user_id as tuserid,t.user_type,t.message,t.created_date,cm.campaign_id,cm.compaign_message,ud.user_id as uduserid,ud.display_name,t.is_delete';
		$criteria->join = 'LEFT JOIN campaign AS cm ON cm.campaign_id = t.campaign_id LEFT JOIN user_detail AS ud ON ud.`user_id`= t.user_id';
		$criteria->compare('postexchange_id', $this->postexchange_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('campaign_id', $this->campaign_id);
		$criteria->compare('user_type', $this->user_type);
		$criteria->compare('message', $this->message, true);
		//$criteria->compare('file_name', $this->file_name, true);
		//$criteria->compare('media_type', $this->media_type, true);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->addCondition("t.is_delete = '1'");
		//$criteria->group  = 'ppostexchange';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function getListOfExchangePostData($typeName,$user_id){
		$response = array();
		$getarray = array();
		$getData =  array();
		$getMedia = array();
		$getMediaData = array();
		$getMediaData1 = array();
		if($typeName==1 || $typeName==2){
			$command = "SELECT post_to_exchange . * , user_detail.profile_image, user_detail.twitter_screen_name,user_detail.is_delete
						FROM `post_to_exchange`
						JOIN user_detail ON post_to_exchange.`user_id` = user_detail.`user_id` WHERE post_to_exchange.is_delete=1 AND user_detail.is_delete = 1 AND post_to_exchange.`user_type`=$typeName AND end_date >= curdate() 
						AND post_to_exchange.`user_id`='".$user_id."' 
						ORDER BY post_to_exchange.`postexchange_id` DESC";
			$cmd1 = Yii::app()->db->createCommand($command);
			$exchangeData = $cmd1->queryAll();
		}elseif($typeName==3){
			$command = "SELECT post_to_exchange . * , user_detail.profile_image, user_detail.twitter_screen_name,user_detail.is_delete
						FROM `post_to_exchange`
						JOIN user_detail ON post_to_exchange.`user_id` = user_detail.`user_id` WHERE post_to_exchange.is_delete=1 AND user_detail.is_delete = 1 AND post_to_exchange.is_paid= 1 AND end_date >= curdate() ORDER BY post_to_exchange.`postexchange_id` DESC";
			$cmd1 = Yii::app()->db->createCommand($command);
			$exchangeData = $cmd1->queryAll();
		}
			if($exchangeData)
			{
			foreach ($exchangeData as $exchangeList) {
						$response['postexchange_id'] = $exchangeList['postexchange_id'];
						$response['user_id'] = $exchangeList['user_id'];
						$response['campaign_id'] = $exchangeList['campaign_id'];
						$response['user_type'] = $exchangeList['user_type'];
						$response['message'] = $exchangeList['message'];
						$response['cost'] = $exchangeList['cost'];
						$response['created_date'] = $exchangeList['created_date'];
						$response['profile_image'] = $exchangeList['profile_image'];
						$response['twitter_screen_name'] = $exchangeList['twitter_screen_name'];
						$response['is_paid'] = $exchangeList['is_paid'];
						$postId=$exchangeList['postexchange_id'];
						$getarray[]['record'] = $response;			
			}
			
			$count = count($getarray);
			
			for ($i=0; $i < $count; $i++) {
				$appmediaDetails = Media::model()->find("postexchange_id = '".$getarray[$i]['record']['postexchange_id']."' AND is_delete = '1'");
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
					$getData["status"] = "1";
					$getData["data"] = $getMediaData1;
					return $getData;
			}else{
					$getData["status"] = "0";
					$getData["data"] = "No Data Avaiable";
					return $getData;
			}
			
			
		
		
	}	
	/*	public function getListOfExchangePostData($typeName){
		$res = array();
		$res1 = array();
		$response = array();
		$response1 = array();
		$getData = array();
		$getdetail=array();
		$u_id=array();
		
				if(!empty($typeName))
			{	
					
			$command = ("SELECT post_to_exchange . * , user_detail.profile_image
FROM `post_to_exchange`
JOIN user_detail ON post_to_exchange.`user_id` = user_detail.`user_id` WHERE post_to_exchange.`user_type`=$typeName");
			$cmd1 = Yii::app()->db->createCommand($command);
			$result = $cmd1->queryAll();
			foreach ($result as $postListData) {
						$response['postexchange_id'] = $postListData['postexchange_id'];
						$response['user_id'] = $postListData['user_id'];
						$response['campaign_id'] = $postListData['campaign_id'];
						$response['user_type'] = $postListData['user_type'];
						$response['message'] = $postListData['message'];
						$response['created_date'] = $postListData['created_date'];
						$response['profile_image'] = $postListData['profile_image'];
						$postId=$postListData['postexchange_id'];
						$res['record']=$response;
												$i=0;
												$appmediaDetails = Media::model()->findAll("postexchange_id = '".$postId."'");
												if(!empty($appmediaDetails)){
															foreach ($appmediaDetails as $appmediaList) {
																$response1['file_name'] = $appmediaList['file_name'];
																$response1['media_type']= $appmediaList['media_type'];
																$res1['media'][$i]=$response1;
																
																$i++;
															}	
													}
							
						$getdetail[]=(array_merge($res,$res1));
					
							
					
						
						
						
				
			}
			if($getdetail){
						$getData["status"] = "1";
						$getData["data"] = $getdetail;
						return $getData;
					}else{
						$getData["status"] = "0";
						$getData["data"] = "No Data Avaiable";
						return $getData;
					}
			
				}
					else{	$getData["status"] = "0";
						$getData["data"] = "please insert type";
						return $getData;	
						}
				}

		/*public function getCampaignData($campaignData = false){
		$responseData = array();
		$modelData = CampaignPartner::model()->findAll('campaign_id = "'.$campaignData.'"');
		foreach ($modelData as $campaignData){
			$responseData[] = $campaignData['twitter_screen_name'];
		}
		$recordData = implode(',', $responseData);
		if($recordData){
			return $recordData;
		}else{
			return false;	
		}
	}*/
		
		
		
		
		
}
?>