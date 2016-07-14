<?php

Yii::import('application.models._base.BaseBalance');

class Balance extends BaseBalance
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
?>