<?php

Yii::import('application.models._base.BaseSocialPostsExchange');

class SocialPostsExchange extends BaseSocialPostsExchange
{
	public $campaign_id;
	public $user_type;	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function beforeSave() {

		if ($this->isNewRecord)
		$this->created_date = new CDbExpression('NOW()');
		return parent::beforeSave();
	}
	public function searchData() {
		$exchangeId = $_REQUEST['id'];	
		$criteria = new CDbCriteria;

		$criteria->compare('social_id', $this->social_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('twitter_screen_name', $this->twitter_screen_name, true);
		$criteria->compare('fb_screen_name', $this->fb_screen_name, true);
		$criteria->compare('postexchange_id', $this->postexchange_id);
		$criteria->compare('fb_post_id', $this->fb_post_id, true);
		$criteria->compare('twitter_post_ids', $this->twitter_post_ids, true);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('is_delete', $this->is_delete);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('video_url', $this->video_url, true);
		$criteria->compare('image_url', $this->image_url, true);
		$criteria->addCondition("postexchange_id = '".$exchangeId."'");
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
}