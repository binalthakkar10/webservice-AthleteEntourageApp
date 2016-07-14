<?php
class StaticController extends FrontCoreController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
		// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
		),
		// page action renders "static" pages stored under 'protected/views/site/pages'
		// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
		),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			echo $error['message'];
			else
			$this->render('error', $error);
		}
	}

	public function actionHowitWorks()
	{
		$model=new StaticPage();
		$id=3;
		$status=1;
		$data=$model->findAll('id= "'.$id.'" AND status="'.$status.'"');
		$this->render('//static/howitswork',array('data'=>$data));
	}

	public function actionPrices()
	{
		$model=new StaticPage();
		$id=4;
		$status=1;
		$data=$model->findAll('id= "'.$id.'" AND status="'.$status.'"');
		$this->render('//static/price',array('data'=>$data));

	}

	public function actionfaq()
	{
		$model=new StaticPage();
		$id=5;
		$status=1;
		$data=$model->findAll('id= "'.$id.'" AND status="'.$status.'"');
		$this->render('//static/faq',array('data'=>$data));

	}

	public function actionterms()
	{
		$model=new StaticPage();
		$id=2;
		$status=1;
		$data=$model->findAll('id= "'.$id.'" AND status="'.$status.'"');
		$this->render('//static/terms',array('data'=>$data));

	}

	public function actionprivacy()
	{
		$model=new StaticPage();
		$id=1;
		$status=1;
		$data=$model->findAll('id= "'.$id.'" AND status="'.$status.'"');
		$this->render('//static/privacy',array('data'=>$data));

	}




	public function actioncontact()
	{
		$model=new Contactus();
		if(isset($_POST['Contactus']) && !empty($_POST['Contactus'])){
			$model->setAttributes($_POST['Contactus']);
			//$errors=$model->getErrors();
			if($model->save()){
				/*$mail = new JPhpMailer;
				 $mail->IsSMTP();
				 $mail->Host = 'mail.inhertix.com';
				 $mail->SMTPAuth = true;
				 $mail->Username = 'client1@inheritx.com';
				 $mail->Password = 'client@123';
				 $mail->SetFrom('ankit@inheritx.com', 'Ankit Modi');
				 $mail->Subject = 'Contact Us';
				 $mail->MsgHTML('<h1>JUST A TEST!</h1>');
				 $mail->AddAddress('ankit@inheritx.com', 'John Doe');
				 $mail->Send();*/

				Yii::app()->user->setFlash('success',Yii::t("messages","Thanks for submission we will get be soon Reply..."));
				$this->render('//static/contact',array('model'=>$model));
				Yii::app()->end();
			}
		}
		$this->render('//static/contact',array('model'=>$model));


	}

	public function actionCron(){
		$model=Users::model()->findAll();
		foreach($model as $data){
			//p($data->created_at,0);
			$current_date=date('Y-m-d H:i:s');
			$next_month_date = date("Y-m-d H:i:s", mktime(date('H',strtotime($customer->created_at)), date('i',strtotime($customer->created_at)), date('s',strtotime($customer->created_at)), date('m',strtotime($customer->created_at))+1, date('d',strtotime($customer->created_at)), date('Y',strtotime($customer->created_at))));
			$flag = 0;
			if(strtotime($current_date) < strtotime($next_month_date)){
				$flag = 0;
			}else{
				$credit=Creditcard::model()->find('user_id="'.$customer->id.'"');
				if($credit->allow_deduction == 'Y'){
					$next_month_date = date("Y-m-d H:i:s", mktime(date('H',strtotime($credit->renew_date)), date('i',strtotime($credit->renew_date)), date('s',strtotime($credit->renew_date)), date('m',strtotime($credit->renew_date))+1, date('d',strtotime($credit->renew_date)), date('Y',strtotime($credit->renew_date))));
					if(strtotime($current_date)< strtotime($next_month_date)){
						$flag = 0;
					}else{
						//payment deduction.
						$retailer_cost = SystemConfig::getValue('retailer_cost');
						$flag = 1;
					}
				}else{
					$flag = 0;
				}
		 	}

		}
	}


}