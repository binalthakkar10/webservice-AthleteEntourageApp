<?php

Yii::import('application.models._base.BaseUser_Detail');

class User_Detail extends BaseUser_Detail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}