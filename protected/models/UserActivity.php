<?php

Yii::import('application.models._base.BaseUserActivity');

class UserActivity extends BaseUserActivity
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function usersearchactivity() {
		$userId = $_REQUEST['id'];
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('activity_id', $this->activity_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('status', $this->status, true);
		$criteria->addCondition("user_id = '".$userId."'");

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function getActivityName($activityId){
		$activityData = ActivityList::model()->find("activity_id = '".$activityId."'");
		if($activityData){
			return $activityData['activity_name'];
		}else{
			return false;
		}
	}
}