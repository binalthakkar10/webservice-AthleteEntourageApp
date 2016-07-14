<?php

Yii::import('application.models._base.BaseInbox');

class Inbox extends BaseInbox
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
		public function beforeSave() {
		if ($this->isNewRecord)
		$this->created_date = new CDbExpression('NOW()');

		//$this->updated_at = new CDbExpression('NOW()');

		return parent::beforeSave();
	}
		
public function GetListOfChat($fromUser,$toUser){
		$res = array();
		$res1=array();
		$response = array();
		$getData = array();
		$inboxModelData = Inbox::model()->findAll("from_user_id = '".$fromUser."' AND to_user_id = '".$toUser."'");
		foreach($inboxModelData as $userList){
			$res['from_user_id'] = $userList['from_user_id'];
			$res['message'] = $userList['message'];
			$res['to_user_id'] = $userList['to_user_id'];
			$res['created_date'] = $userList['created_date'];
			$inboxId=$userList['inbox_id'];
			if(!empty($inboxId))
			{
				$mediaModelData = Media::model()->findAll("inbox_id = '".$inboxId."'");
				if($mediaModelData)
				{
					
					foreach($mediaModelData as $inboxList){
						$res['file_name'] = $inboxList['file_name'];
						$res['media_type'] = $inboxList['media_type'];
						$res1[]=$res;	
					}
					
				}
			}
			
			$response[] =(array_merge($res1,$res));
			
		}
		if($response){
			$getData['status'] = "1";
			$getData['data'] = $response; 
			return $getData;
		}else{
			$getData['status'] = "0";
			$getData['data'] = "No Data Available"; 
			return $getData;
		}
	}		
		
		
		
}