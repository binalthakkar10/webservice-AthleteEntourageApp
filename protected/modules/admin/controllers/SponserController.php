<?php

class SponserController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Sponser'),
		));
	}

	public function actionCreate() {
		$model = new Sponser;

		if (isset($_POST['Sponser'])) {
			$model->setAttributes($_POST['Sponser']);
			if($model->validate()){
				// iPhone Image
		    if($_POST['Sponser']['iphone_image']==''){
					if(($_FILES['Sponser']['name']['iphone_image']==''))
					{
							Yii::app()->admin->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
							$this->render('create', array( 'model' => $model));
							Yii::app()->end();
					}else{
						$path	= 	YiiBase::getPathOfAlias('webroot');
						$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
						
						$model->iphone_image=$_FILES['Sponser']['name']['iphone_image'];
						$model->iphone_image = CUploadedFile::getInstance($model, 'iphone_image',false);
						$model->iphone_image->saveAs($path.'/upload/Sponser/iPhone/'.$model->iphone_image);
						Yii::import('application.extensions.EWideImage.EWideImage');
						EWideImage::load($path.'/upload/Sponser/iPhone/'.$model->iphone_image)->saveToFile($path.'/upload/Sponser/iPhone/'.$model->iphone_image);
						Yii::import('application.extensions.yii-easyimage.EasyImage');
						$image = new EasyImage($path.'/upload/Sponser/iPhone/'.$model->iphone_image);
						$image->resize(640,524,EasyImage::RESIZE_NONE);
						$image->save($path.'/upload/Sponser/iPhone/'.$model->iphone_image);
						$model->iphone_image = $model->iphone_image;
						
					}

			}else{
					$iphone_image->iphone_image = $_POST['Sponser']['iphone_image'];

			}
			
			// iPad Image
			if($_POST['Sponser']['ipad_image']==''){
					if(($_FILES['Sponser']['name']['ipad_image']==''))
					{
							Yii::app()->admin->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
							$this->render('create', array( 'model' => $model));
							Yii::app()->end();
					}else{
							$path	= 	YiiBase::getPathOfAlias('webroot');
							$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
						
							$model->ipad_image=$_FILES['Sponser']['name']['ipad_image'];
							$model->ipad_image = CUploadedFile::getInstance($model, 'ipad_image');
							$model->ipad_image->saveAs($path.'/upload/Sponser/iPad/'.$model->ipad_image);
							Yii::import('application.extensions.EWideImage.EWideImage');
							EWideImage::load($path.'/upload/Sponser/iPad/'.$model->ipad_image)->saveToFile($path.'/upload/Sponser/iPad/'.$model->ipad_image);
							Yii::import('application.extensions.yii-easyimage.EasyImage');
							$image = new EasyImage($path.'/upload/Sponser/iPad/'.$model->ipad_image);
							$image->resize(1536,944,EasyImage::RESIZE_NONE);
							$image->save($path.'/upload/Sponser/iPad/'.$model->ipad_image);
							$model->ipad_image = $model->ipad_image;
						
						
						
					}

			}else{
					$iphone_image->image = $_POST['Sponser']['image'];

			}
			
			
		}
				$twitterFollower=$model->twitter_followers;
				$fbFollower=$model->facebook_followers;
				$model->impact_score=(0.75*(2.8437*(pow($twitterFollower, 0.2728)))+(0.25*(1.3497*(pow($fbFollower,0.3866)))));
					$model->flag='1';
			$sponserData = Sponser::model()->findAll("flag='1'");
			foreach($sponserData as $sponserFlag)
			{
				$sponserId = $sponserFlag['sponser_id'];
				$sponData = $this->loadModel($sponserId, 'Sponser');
				$sponData['flag']='0';
				$sponData->save();
				
			}
			
			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin', 'id' => $model->sponser_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Sponser');


		if (isset($_POST['Sponser'])) {
			$model->setAttributes($_POST['Sponser']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->sponser_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Sponser')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Sponser');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->pageTitle = "Sponsor || Roster Network";
		$model = new Sponser('search');
		$model->unsetAttributes();

		if (isset($_GET['Sponser']))
			$model->setAttributes($_GET['Sponser']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	public function loadModel($id, $type, $errorMessage = 'This page does not exist', $errorNum = 404) {
		eval('$model = ' . $type . '::model()->findByPk($id);');
		if ($model === null)
			throw new CHttpException($errorNum, $errorMessage);
		return $model;
	}
		public function actionActiveUser()
	{
		$var=	$_REQUEST['id'];
		
        if (isset($var))
        {
        					$appSponserFlag = Sponser::model()->find('flag=1');
							if($appSponserFlag)
						 	 {
						  		$sid1=$appSponserFlag['sponser_id'];
							    $sponserdata1=$this->loadModel($sid1, 'Sponser');
								if($sponserdata1['flag']==1)
								{
								$sponserdata1->flag=0;
								if($sponserdata1->save(false)){
									  
								}
							}
							 }	
        					$explode=(explode(",",$var));
  						  $appSponserDetails = Sponser::model()->find("sponser_id = '".$explode[0]."'");
						  
						  if($appSponserDetails)
						  {
						  		$sid=$appSponserDetails['sponser_id'];
							    $sponserdata=$this->loadModel($sid, 'Sponser');
								if($sponserdata['flag']==0)
								{
								$sponserdata->flag=1;
								if($sponserdata->save(false)){
									  
								}
							}
							
						}  
						 
					Yii::app()->admin->setFlash('success', 'selected user has been  activated.');
				$this->redirect(array('admin'));		
              
        }
        else
        {
                Yii::app()->user->setFlash('error', 'Please select at least one record to verify.');
                $this->redirect(array('admin'));
        }               
}

}