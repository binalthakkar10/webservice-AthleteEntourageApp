<?php

Yii::import('application.models._base.BaseTransaction');

class Transaction extends BaseTransaction
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
		public function attributeLabels() {
		return array(
			'transaction_id' => Yii::t('app', 'Transaction'),
			'user_id' => Yii::t('app', 'User'),
			'email' => Yii::t('app', 'Email'),
			'twitter_screen_name' => Yii::t('app', 'Twitter Screen Name'),
			'payment_gateway_id' => Yii::t('app', 'Transaction ID'),
			'amount' => Yii::t('app', 'Amount'),
			'campaign_id' => Yii::t('app', 'Campaign'),
			'created_date' => Yii::t('app', 'Created Date'),
			'payment_status' => Yii::t('app', 'Payment Status'),
			'user' => null,
			'campaign' => null,
		);
	}
		
	public static function label($n = 1) {
		return Yii::t('app', 'Payment|Payment', $n);
	}	
}