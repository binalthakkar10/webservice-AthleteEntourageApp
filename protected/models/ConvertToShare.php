<?php

Yii::import('application.models._base.BaseConvertToShare');

class ConvertToShare extends BaseConvertToShare
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
				public function beforeSave() {
		if ($this->isNewRecord)
		$this->created_date = new CDbExpression('NOW()');
		return parent::beforeSave();
	}
}