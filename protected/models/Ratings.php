<?php

Yii::import('application.models._base.BaseRatings');

class Ratings extends BaseRatings
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}