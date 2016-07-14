<?php

Yii::import('application.models._base.BaseCashout');

class Cashout extends BaseCashout
{
	public $display_name;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
				public function beforeSave() {
		if ($this->isNewRecord)
		$this->created_date = new CDbExpression('NOW()');
		return parent::beforeSave();
	}
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->select = 't.cashout_id,t.bank_name,t.bank_swift_id,t.name_on_acc,t.acc_no,t.bank_address,t.user_id as tuserid,t.amount_to_cashout,t.is_verified,t.updated_date,t.created_date,u.display_name,u.user_id';
		$criteria->join = 'LEFT JOIN user_detail u ON t.user_id = u.user_id';
		$criteria->compare('cashout_id', $this->cashout_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('amount_to_cashout', $this->amount_to_cashout);
		$criteria->compare('acc_no', $this->acc_no, true);
		$criteria->compare('name_on_acc', $this->name_on_acc, true);
		$criteria->compare('bank_swift_id', $this->bank_swift_id, true);
		$criteria->compare('bank_name', $this->bank_name, true);
		$criteria->compare('bank_address', $this->bank_address, true);
		$criteria->compare('is_verified', $this->is_verified);
		$criteria->compare('updated_date', $this->updated_date, true);
		$criteria->compare('created_date', $this->created_date, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function getBalanceInfo($userId){
		$balanceInfo = Balance::model()->find("user_id = '".$userId."'");
		if($balanceInfo){
			return $balanceInfo['balance'];
		}else{
			return '0';
		}
	}
	
 				
	public function getCashOutDetails($userId){
		//$res = array();
		//$getData = array();
		//$response = array();
		$command = "SELECT * FROM cashout WHERE `user_id` ='".$userId."' AND is_delete=1 ORDER BY `cashout_id` DESC LIMIT 1";
		$cmd1 = Yii::app()->db->createCommand($command);
		$modelData = $cmd1->queryAll();	
		if($modelData){
			$getData['status'] = "1";
			$getData['data'] = $modelData; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Available"; 
			return $getData;
		}
	}				
					
					
}