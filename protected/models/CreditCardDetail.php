<?php

Yii::import('application.models._base.BaseCreditCardDetail');

class CreditCardDetail extends BaseCreditCardDetail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function getCreditCardInformation($userId){
		$res = array();
		$response = array();
		$getData = array();
		$creditCardData = CreditCardDetail::model()->findAll("user_id = '".$userId."'");
		foreach ($creditCardData as $creditList){
			$response['user_id'] = $creditList['user_id'];
			$response['card_holder_name'] = $creditList['card_holder_name'];
			$response['card_number'] = $creditList['card_number'];
			$response['expire_date'] = $creditList['expire_date'];
			$response['security_code'] = $creditList['security_code'];
			$res[] = $response;
		}
		if($res){
			$getData["status"] = "1";
			$getData["data"] = $res;
			return $getData;
		}else{
			$getData["status"] = "0";
			$getData["data"] = "No Data Available";
			return $getData;
		}
	}
}