<?php

Yii::import('application.models._base.BasePostToExchangePrice');

class PostToExchangePrice extends BasePostToExchangePrice
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}