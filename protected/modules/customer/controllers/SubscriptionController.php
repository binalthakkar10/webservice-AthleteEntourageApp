<?php

class SubscriptionController extends FrontCoreController
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

	public function actionIndex(){
		//p($_POST);
			$id=Yii::app()->customer->id;
			$model = Creditcard::model()->find('user_id="'.$id.'" ');	
			if(isset($_POST['Creditcard']) && !empty($_POST['Creditcard']))
			{
				$model->setAttributes($_POST['Creditcard']);
				if(isset($_POST['Creditcard']['allow_deduction'])  && !empty($_POST['Creditcard']['allow_deduction'])){
					$model->allow_deduction=$_POST['Creditcard']['allow_deduction'];
				}
				if($model->save(false)){
					Yii::app()->user->setFlash('error',Yii::t("messages",'Successfully Updated...'));
					$this->render('index');
					Yii::app()->end();
				}
			}
			$this->render('index');
			
		}
}
?>