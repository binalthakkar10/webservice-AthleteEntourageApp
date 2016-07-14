<?php

class CouponController extends FrontCoreController
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

	public function actionAddCoupon()
	{
		$model= new Coupon();
		if(isset($_POST['Coupon'])){

			
			$model->setAttributes($_POST['Coupon']);

			$model->user_id=Yii::app()->customer->id;
			
			
			if($model->save(false)){
				//p($model->user_id);
				
				if($_POST['Coupon']['image_url']==''){
					
					if(($_FILES['Coupon']['name']['image']==''))
					{
						Yii::app()->user->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
						//$this->render('index',array('model'=>$model,));
						//Yii::app()->end();
					}else{
						$path	= 	YiiBase::getPathOfAlias('webroot');
						$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
						
						$model->image=$_FILES['Coupon']['name']['image'];
						$model->image = CUploadedFile::getInstance($model, 'image');
						$model->image->saveAs($path.'/upload/coupon/'.$model->image);
						$image_path=$url.'/upload/coupon/'.$model->image;
						$model->image_url=$image_path;
						$model->save(false);
					}
	
				}else{
					$model->image_url=$_POST['Coupon']['image_url'];
						
				}
				//Yii::app()->user->setFlash('error', Yii::t("messages","Succesfully Inserted..!"));
				$this->redirect('index',array('model'=>$model,));
				Yii::app()->end();
			}
		}


		$this->render('index',array('model'=>$model));
	}

	public function actionIndex(){

		$i=1;
		$id=Yii::app()->customer->id;
		$model=Coupon::model()->findAll('user_id="'.$id.'"');
		$data_arr = array();
		foreach($model as $data){
			$data_arr[]=array(
					'counter'=>$i++,
					'id'=>$data->id,
					'coupon title'=> $data->deal_title,
					'image'=> $data->image,
					'image_url'=>$data->image_url,
					'start_date'=>$data->start_date,
					'expiry_date'=>$data->expiry_date,
					'Action'=>'',
			);
		}
		$arrayDataProvider=new CArrayDataProvider($data_arr, array('id'=>'id',
							'pagination'=>array('pageSize'=>10),
		));
		$params =array(
		'arrayDataProvider'=>$arrayDataProvider,
		);
		$this->render('admin', $params);



	}

	public function actionUpdate($id){
		$model = Coupon::model()->find('id="'.$id.'"');
		$path	= 	YiiBase::getPathOfAlias('webroot');
		$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
		$image = $model->image;
		if(isset($_POST['Coupon']) && !empty($_POST['Coupon'])){
			//p($_POST);
			$model->setAttributes($_POST['Coupon']);
			//$data->user_id=Yii::app()->customer->id;

			if(isset($_POST['Coupon']['image_url']) && empty($_POST['Coupon']['image_url'])){
				if((isset($_FILES['Coupon']['name']['image'])) && empty($_FILES['Coupon']['name']['image'])){
					if($image == ''){
						Yii::app()->user->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
						$this->render('create',array('model'=>$model,));
						Yii::app()->end();
					}
				}else{
					if($_FILES['Coupon']['name']['image'] != ''){
						$model->image = $_FILES['Coupon']['name']['image'];
						$model->image = CUploadedFile::getInstance($model, 'image');
						if(isset($model->image) && !empty($model->image)){
							$model->image->saveAs($path.'/upload/coupon/'.$model->image);
						}
						if($_POST['Coupon']['image_url'] == '')
						{
							$image_path=$url.'/upload/coupon/'.$model->image;
							$model->image_url=$image_path;
						}
					}
				}
			}else{
				if((isset($_FILES['Coupon']['name']['image'])) && !empty($_FILES['Coupon']['name']['image'])){
					$model->image = $_FILES['Coupon']['name']['image'];
					$model->image = CUploadedFile::getInstance($model, 'image');
					if(isset($model->image) && !empty($model->image)){
						$model->image->saveAs($path.'/upload/coupon/'.$model->image);
					}
					if($_POST['Coupon']['image_url'] == '')
					{
						$image_path=$url.'/upload/coupon/'.$model->image;
						$model->image_url=$image_path;
					}else{
						$model->image_url=$_POST['Coupon']['image_url'];
					}
				}
			}

			if(isset($_FILES['Coupon']['name']['image']) && empty($_FILES['Coupon']['name']['image']))
			{
				$model->image = $image;
			}
			if($model->save()){
				//Yii::app()->user->setFlash('error',Yii::t("messages",'Successfully Updated...'));
				$this->redirect(CController::createUrl('coupon/index'));
				Yii::app()->end();
			}




		}
		$this->render('index', array('model' => $model));
	}


	public function actionDelete($id){
		
		
		$model= new Coupon();
		if (!Yii::app()->getRequest()->getIsPostRequest()) {
			$coupon_record = Business::model()->findAll("coupon_id='".$id."'");
			$flag = 0;
			if(isset($coupon_record) && count($coupon_record) > 0)
			{
				$flag = 1;
			}
				
			if($flag == 0){
				$this->loadModel($id, 'Coupon')->delete();
				$this->redirect(CController::createUrl('coupon/index'));
			}else{
				
				$this->redirect(CController::createUrl('coupon/index?del=exist'));
				Yii::app()->end;
			}

			//}
			//$this->loadModel($id, 'Wines')->delete();
				
		} else
		throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}


	
}