<?php

Yii::import('application.models._base.BaseActivityList');

class ActivityList extends BaseActivityList
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}