<?php

Yii::import('application.models.User._base.BaseUserRole');

class UserRole extends BaseUserRole
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}