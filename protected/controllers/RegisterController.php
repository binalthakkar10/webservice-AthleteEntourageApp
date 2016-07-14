<?php
session_start();
class RegisterController extends FrontCoreController
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

	public function actionIndex()
	{
		$model= new FrontRegisterValidationForm();
		$this->render('index',array('model'=>$model));
	}
	public function actionCreate()
	{
		//$model = new Users();
		$model = new FrontRegisterValidationForm();
		//p($_POST);
		if (isset($_POST['FrontRegisterValidationForm']) && !empty($_POST['FrontRegisterValidationForm'])) {

			//$model1 = new Users();
			$model->username=$_POST['FrontRegisterValidationForm']['username'];
			$model->firstname=$_POST['FrontRegisterValidationForm']['firstname'];
			$model->lastname=$_POST['FrontRegisterValidationForm']['lastname'];
			$model->email=$_POST['FrontRegisterValidationForm']['email'];
			if($_POST['FrontRegisterValidationForm']['email']!='')
			{
				$Obj = Users::model()->find('email="'.$_POST['FrontRegisterValidationForm']['email'].'"');
				if(isset($Obj->attributes))
				{
					$model->attributes=$_POST['FrontRegisterValidationForm'];
					Yii::app()->user->setFlash('error', Yii::t("messages","There is already an account with this email address, please try again.!"));
					$this->render('index',array('model'=>$model,));
					Yii::app()->end();
				}
			}

			if($_POST['FrontRegisterValidationForm']['checkbox'] =="N"){
				Yii::app()->user->setFlash('error', Yii::t("messages","Please Check the Terms and Privacy Condition.!"));
				$this->render('index',array('model'=>$model));
				Yii::app()->end();
			}
			$usermodel = new User();
			$usermodel->setAttributes($_POST['FrontRegisterValidationForm']);
			$usermodel->password=md5($_POST['FrontRegisterValidationForm']['password']);
			//p($usermodel->attributes);
			if($usermodel->save(false)){
				$_SESSION['sess_bogo']['uid'] = $usermodel->id;
				$model_credit= new Creditcard();
				$model_credit->user_id=$usermodel->id;
				$model_credit->allow_deduction='Y';
				$model_credit->save(false);
				Yii::app()->user->setFlash('error',Yii::t("messages",'Successfully Inserted Please Login to continue'));
				$this->redirect(CController::createUrl('tab/index'));
				Yii::app()->end();
			}else{
				$this->render('index',array('model'=>$model));
				Yii::app()->end();
			}



		}


	}




	public function actionLogin(){

		//echo "DFdfsdfdfsdfsdfdsf"; die;


		$model=new LoginForm();
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		//p($_POST);
		// collect user input data
		
		if(isset($_POST['LoginForm']))
		{
			$_SESSION['free_user'] = '0';
			$customer=Users::model()->find('email="'.$_POST['LoginForm']['email'].'"');
			if(isset($customer) && !empty($customer)){
			$current_date=date('Y-m-d H:i:s');
			$next_month_date = date("Y-m-d H:i:s", mktime(date('H',strtotime($customer->created_at)), date('i',strtotime($customer->created_at)), date('s',strtotime($customer->created_at)), date('m',strtotime($customer->created_at))+1, date('d',strtotime($customer->created_at)), date('Y',strtotime($customer->created_at))));
			if(strtotime($current_date) < strtotime($next_month_date)){
				$_SESSION['allow_retailer']='1';
				$_SESSION['free_user'] = '1';
			}else{
				$credit=Creditcard::model()->find('user_id="'.$customer->id.'"');
				if($credit->allow_deduction == 'Y'){
					$next_month_date = date("Y-m-d H:i:s", mktime(date('H',strtotime($credit->renew_date)), date('i',strtotime($credit->renew_date)), date('s',strtotime($credit->renew_date)), date('m',strtotime($credit->renew_date))+1, date('d',strtotime($credit->renew_date)), date('Y',strtotime($credit->renew_date))));
					if(strtotime($current_date)< strtotime($next_month_date)){
						$_SESSION['allow_retailer']='1';
					}else{
						$_SESSION['allow_retailer']='0';
					}

				}else{
					$_SESSION['allow_retailer']='0';
				}

		 }
			$model->attributes=$_POST['LoginForm'];

			// validate user input and redirect to the previous page if valid
			if($model->login()){
				//$this->redirect(CController::createUrl('customer/index'));
				$this->redirect(CController::createUrl('customer/index'));
				return;
			}else{
				Yii::app()->user->setFlash('error',Yii::t("messages",'Invalid email address or password'));
				$this->redirect('login');
				Yii::app()->end();

			}
			}else{
					Yii::app()->user->setFlash('error',Yii::t("messages","Oops! You've entered the wrong email address or password."));
					$this->redirect('login');
					Yii::app()->end();
			}
		}

		// display the login form
		$this->render('login',array('model'=>$model));


	}

	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect(CController::createUrl('register/login'));

	}

	public function loadModel($id)
	{
		$model=Users::model()->findByPk((int)$id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function actionForgor_Password(){
		$this->renderPartial('forgot_password');	
	}
	public function actionGetPasswordInfo(){
		
		$model = new Users();
		$model = Users::model()->find('email = "'.$_POST['email'].'"');
		if(isset($model) AND !empty($model)){
			$password = rand(100000,300000);
			$model = $this->loadModel($model->id, 'Users');
			$model->password = md5($password);
			$model->save(false);
			$omMessage = new YiiMailMessage;
      		$ssSubject = 'Forgot Password Bogo';
      		 ;
      		$html = '<p>Hello '.ucfirst($model->firstname).'</p>
      				 <br><br>
      				 <p>please find below new password.</p>
      				 <table border="2">
      						<tr>
      							<td>Email:</td>
      							<td>'.$_POST['email'].'</td>
      						</tr>
      						<tr>
      							<td>Password:</td>
      							<td>'.$password.'</td>
      						</tr>
      				 </table>';
      		$omMessage->setTo($_POST['email']);
      		$omMessage->setFrom(array('info@bogo.com'));
      		$omMessage->setSubject($ssSubject);     
      		$omMessage->setBody($html,'text/html','utf-8');     
      		Yii::app()->mail->send($omMessage);
		}else{
			echo "1";
			die;
		}
	}
}