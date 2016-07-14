<?php

class CreditCardController extends FrontCoreController
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


	public function actionIndex(){
		
		//$this->layout='main';
		$id=Yii::app()->customer->id;
		$model = Creditcard::model()->find('user_id="'.$id.'" ');
		//p($_POST);
		if(isset($_POST['Creditcard']) && !empty($_POST['Creditcard']))
		{
			$model->setAttributes($_POST['Creditcard']);
			if(isset($_POST['Creditcard']['allow_deduction'])  && !empty($_POST['Creditcard']['allow_deduction'])){
				$model->allow_deduction=$_POST['Creditcard']['allow_deduction'];
			}
			if($model->save(false)){
				Yii::app()->user->setFlash('error',Yii::t("messages",'Successfully Updated...'));
				$this->redirect(CController::createUrl('CreditCard/index'));
				Yii::app()->end();
			}

		}
		
		$this->render('/creditcard/index',array('model' => $model));
		//Yii::app()->end();
	}




}