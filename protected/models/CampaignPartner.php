<?php

Yii::import('application.models._base.BaseCampaignPartner');

class CampaignPartner extends BaseCampaignPartner
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function search() {
		$criteria = new CDbCriteria;
		$cam=$_REQUEST['campaign_id'];
		$criteria->compare('id', $this->id);
		$criteria->compare('campaign_id', $this->campaign_id);
		$criteria->compare('twitter_screen_name', $this->twitter_screen_name, true);
		$criteria->compare('is_member', $this->is_member);
		$criteria->compare('is_verified', $this->is_verified);
		$criteria->compare('impact_score', $this->impact_score);
		$criteria->compare('price', $this->price);
		$criteria->compare('reach', $this->reach);
		if(isset($cam) && !empty($cam))
		{
			$criteria->addCondition('campaign_id = "'.$cam.'"');
		}
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function getCampaignData($campaignData = false){
		$responseData = array();
		$modelData = CampaignPartner::model()->findAll('campaign_id = "'.$campaignData.'"');
		foreach ($modelData as $campaignData){
			$responseData[] = $campaignData['twitter_screen_name'];
		}
		$recordData = implode(', ', $responseData);
		if($recordData){
			return $recordData;
		}else{
			return false;	
		}
	}
	
		public static function label($n = 1) {
		return Yii::t('app', 'Hire|Hire', $n);
	}

}