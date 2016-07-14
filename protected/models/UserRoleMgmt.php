<?php

Yii::import('application.models._base.BaseUserRoleMgmt');

class UserRoleMgmt extends BaseUserRoleMgmt
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}