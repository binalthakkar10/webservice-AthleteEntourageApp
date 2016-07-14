<?php

Yii::import('application.models._base.BaseTrasaction');

class Trasaction extends BaseTrasaction
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}