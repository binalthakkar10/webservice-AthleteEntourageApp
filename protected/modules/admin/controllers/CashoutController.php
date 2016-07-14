<?php

class CashoutController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Cashout'),
		));
	}

	public function actionCreate() {
		$model = new Cashout;


		if (isset($_POST['Cashout'])) {
			$model->setAttributes($_POST['Cashout']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->cashout_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Cashout');


		if (isset($_POST['Cashout'])) {
			$model->setAttributes($_POST['Cashout']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->cashout_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Cashout')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Cashout');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Cashout('search');
		$model->unsetAttributes();

		if (isset($_GET['Cashout']))
			$model->setAttributes($_GET['Cashout']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	
public function actionDeleteAll()
{
		$var=	$_REQUEST['id'];
		$cashout_message = $_REQUEST['cashout_message'];
		
        if (isset($var))
        {
        			$explode=(explode(",",$var));
            			 for($i = 0; $i < count($explode); $i++)
           				 {	
  						  $appUserDetails = Cashout::model()->find("cashout_id = '".$explode[$i]."'");
						  if($appUserDetails)
						  {
						  		$cashId=$appUserDetails['cashout_id'];
								
							    $userdata=$this->loadModel($cashId, 'Cashout');
								if($userdata['is_verified']==0)
								{
									$amount=$userdata['amount_to_cashout'];
									$uid=$userdata['user_id'];
									
									$appBalDetails = Balance::model()->find("user_id = '".$uid."'");
									
									if($appBalDetails){
										$id = $appBalDetails['balance_id'];
										$bal = $appBalDetails['balance'];
										$balmodel = $this->loadModel($id, 'Balance');
										
										if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
											$balmodel->user_id =  $data['data']['user_id'];
										}
										
										if($bal >= $amount){
											$balmodel->balance =  $bal - $amount;
											$balmodel->updated_date = date('Y/m/d H:i:s');
											$userdata->is_verified=1;
											$userdata->cashout_message=$cashout_message;
											($balmodel->save(false));
											($userdata->save(false));
											
											$userDetails = UserDetail::model()->find("user_id = '".$uid."'");
											//p($userDetails);
											if($userDetails){
												$to = $userDetails->email.',ankit@letsnurture.com';
												$subject = "The Roster Network-Cashout";
												$txt = "Dear ".$userDetails->display_name.",\r\n\n";
												$txt .= "Message from admin.\r\n\n";
												$txt .= $cashout_message;
												$headers = "db@therosternetwork.com";
													
												$mail=	mail($to,$subject,$txt,"From: $headers");	
											}
											
									
								
									
								}else{
										Yii::app()->admin->setFlash('error', 'Not enough balance to verify.');
										$this->redirect(array('admin'));	
								}

							}

							}
							
						}  
						 }
						Yii::app()->admin->setFlash('Success', 'selected user hes been  verified.');
									$this->redirect(array('admin'));		
              
        }
        else
        {
                Yii::app()->user->setFlash('error', 'Please select at least one record to verify.');
                $this->redirect(array('admin'));
        }               
}

}