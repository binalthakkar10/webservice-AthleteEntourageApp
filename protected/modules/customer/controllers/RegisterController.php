<?php
//session_start();
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

	
	public function actionProfile(){
		$model= new Users();
		$id=Yii::app()->customer->id;
		$resultset=Users::model()->find("id='$id'");
		if(isset($_POST['Users']) && !empty($_POST['Users']))
		{
			$resultset->setAttributes($_POST['Users']);
			if($resultset->save()){
				Yii::app()->user->setFlash('error',Yii::t("messages",'Successfully Updated...'));
				$this->redirect('profile',array('resultset'=>$resultset));
				Yii::app()->end();
			}

		}
		$this->render('profile',array('resultset'=>$resultset));
	}

	public function actionChangePassword(){
		$id=Yii::app()->customer->id;
		$model=Users::model()->findByPk((int)$id);
		$modelForm=new ChangePasswordForm();
		if(isset($_POST['ChangePasswordForm']['oldpassword']) && !empty($_POST['ChangePasswordForm']['oldpassword']))
		{
			$modelForm->oldpassword=md5($_POST['ChangePasswordForm']['oldpassword']);
			if($modelForm->oldpassword!=$model->password){
				Yii::app()->user->setFlash('error',Yii::t("messages",'please insert a correct  old password'));
				$this->redirect('changepassword',array('model'=>$modelForm));
				Yii::app()->end();
			}else{
				$modelForm->password_repeat=$_POST['ChangePasswordForm']['password_repeat'];
				$model->password=md5($modelForm->password_repeat);
				$model->save(false);
				if (!$model->hasErrors()) {
					Yii::app()->user->setFlash('error',Yii::t("messages",'Password change a Succesfully..!'));
					$this->redirect('changepassword',array('model'=>$model));
					Yii::app()->end();
				}else{
					Yii::app()->user->setFlash('error',Yii::t("messages",'Password change a Failure..!'));
					$this->redirect('changepassword',array('model'=>$model));
					Yii::app()->end();
				}
			}

		}
		$this->render('changepassword',array('model'=>$modelForm));
	}



	

	public function loadModel($id)
	{
		$model=Users::model()->findByPk((int)$id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}







}