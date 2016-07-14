<?php

Yii::import('application.models._base.BaseBankingInfo');

class BankingInfo extends BaseBankingInfo
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function getBankingInformation($userData){
		$res = array();
		$response = array();
		$getData = array();
		$bankingData = BankingInfo::model()->findAll("user_id = '".$userData."'");
		foreach ($bankingData as $bankingList){
			$response['user_id'] = $bankingList['user_id'];
			$response['name_on_account'] = $bankingList['name_on_account'];
			$response['account_no'] = $bankingList['account_no'];
			$response['bank_swift_id'] = $bankingList['bank_swift_id'];
			$response['bank_name'] = $bankingList['bank_name'];
			$response['bank_address'] = $bankingList['bank_address'];
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