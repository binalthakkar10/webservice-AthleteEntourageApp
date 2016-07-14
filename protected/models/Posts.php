<?php

Yii::import('application.models._base.BasePosts');

class Posts extends BasePosts
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function rules() {
		return array(
			array('post_text, user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('post_text', 'length', 'max'=>5000),
			array('post_id, post_text, user_id', 'safe', 'on'=>'search'),
		);
	}
	
		public function getListOfExchangePostData($typeName){
		$res = array();
		$response = array();
		$getData = array();
		$u_id=array();
		
				if(!empty($typeName))
			{	
					
			$command = ("SELECT * FROM `posts` WHERE `user_id`IN(SELECT `user_id` FROM `user_detail` WHERE `user_type`=$typeName)");
			$cmd1 = Yii::app()->db->createCommand($command);
			$result = $cmd1->queryAll();
			foreach ($result as $postListData) {
			$response['post_id'] = $postListData['post_id'];
						$response['post_text'] = $postListData['post_text'];
						$response['user_id'] = $postListData['user_id'];
						$response['created_date'] = $postListData['created_date'];
						$response['created_date'] = $postListData['created_date'];
						
						
						$res[] = $response;	
				
			}
			if($res){
						$getData["status"] = "1";
						$getData["data"] = $res;
						return $getData;
					}else{
						$getData["status"] = "0";
						$getData["data"] = "No Data Avaiable";
						return $getData;
					}
			
				}
					else{	$getData["status"] = "0";
						$getData["data"] = "please insert type";
						return $getData;	
						}
				}


		



}