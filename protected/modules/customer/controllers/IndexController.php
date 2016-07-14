<?php
class IndexController extends FrontCoreController
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
		$this->render('index');

	}

	public function actionTab()
	{
		if(!isset($_SESSION['tab_type'])){
			$_SESSION['tab_type']='business';				
		}		
		$type=$_SESSION['tab_type'];
		
		//echo p($type,0); p($_POST); die;
		if(isset($_GET['tabname']) && !empty($_GET['tabname']))
		{
			$tabname = $_GET['tabname'];
			if($tabname == 'business')
			{
				$_SESSION['tab_type']='business';	
				$type=$_SESSION['tab_type'];
			}
			if($tabname == 'coupon')
			{
				$_SESSION['tab_type']='coupon';	
				$type=$_SESSION['tab_type'];
			}
			if($tabname == 'credit')
			{
				$_SESSION['tab_type']='credit';	
				$type=$_SESSION['tab_type'];
			}
		}
		//if(isset($_SESSION['tab_type']) && $_SESSION['tab_type'] == 'business' && isset($_POST['Coupon'])){
		if(isset($_SESSION['tab_type']) && $_SESSION['tab_type'] == 'coupon'){
			
			$model= new Coupon();
			if(isset($_POST['Coupon'])){
				//p($_FILES);
				$model->setAttributes($_POST['Coupon']);
				$model->user_id=Yii::app()->customer->id;

				//p($model->user_id);
				if($_POST['Coupon']['image_url']==''){
					if(($_FILES['Coupon']['name']['image']==''))
					{
						Yii::app()->user->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
						$this->render('index',array('model'=>$model,));
						Yii::app()->end();
					}else{
						$width = "320";
						$height = "436";
						$path	= 	YiiBase::getPathOfAlias('webroot');
						$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
						$model->image=$_FILES['Coupon']['name']['image'];
						$model->image = CUploadedFile::getInstance($model, 'image');
						$model->image->saveAs($path.'/upload/coupon/'.$model->image);
						$image = Yii::app()->image->load($path.'/upload/coupon/'.$model->image);
						$image->resize($width, $height);
						$image->save();
						$image_path=$url.'/upload/coupon/'.$model->image;
						$model->image_url=$image_path;

					}

				}else{
					$model->image_url=$_POST['Coupon']['image_url'];

				}
				
				if($model->save(false)){
					$business_model = Business::model()->find('id="'.$_SESSION['sess_business_id'].'"');
					$business_model->coupon_id = $model->id;
					$business_model->save(false);
					$_SESSION['tab_type'] = 'credit';
					$_SESSION['sess_coupon_id'] = $business_model->coupon_id;
					$this->redirect(CController::createUrl('index/tab'));
					Yii::app()->end();
				}
			}
			//$this->render(CController::createUrl('index/tab'));
			$this->render('/index/tab',array('type'=>$type));
			Yii::app()->end();
		}
		//echo p($type,0); p($_POST,0); p($_SESSION['tab_type']); die;
		if(isset($_SESSION['tab_type']) && $_SESSION['tab_type'] == 'business'){
			if(isset($_POST['Business'])){
				$model= new Business();
				if(isset($_POST['Business'])){
					$model->setAttributes($_POST['Business']);
					$model->user_id=Yii::app()->customer->id;
					$model->coupon_id = 1;
					/*if(isset($_POST['Business']['city_name']) && !empty($_POST['Business']['city_name'])){
						$model->city_id = '0';
					 	$model->city_name = $_POST['Business']['city_name'];
					 	$latlong = $this->afterlatlong($model->city_name);
					 	$lat_long = explode("||",$latlong);
					 	$model->latitude = $lat_long[0];
					 	$model->longitude = $lat_long[1];	
					}*/
					if($_POST['Business']['business_image']==''){
						if(($_FILES['Business']['name']['business_image']==''))
						{
							Yii::app()->user->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
							$this->render('index',array('model'=>$model,));
							Yii::app()->end();
						}else{
							$width = "320";
							$height = "436";
							$path	= 	YiiBase::getPathOfAlias('webroot');
							$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
							$model->business_image=$_FILES['Business']['name']['business_image'];
							$model->business_image = CUploadedFile::getInstance($model, 'business_image');
							$model->business_image->saveAs($path.'/upload/business/'.$model->business_image);
							$image = Yii::app()->image->load($path.'/upload/business/'.$model->business_image);
							$image->resize($width,$height);
							$image->save();
							$image_path=$url.'/upload/business/'.$model->business_image;
							$model->business_image_url=$image_path;
	
						}
	
					}else{
						$model->business_image_url=$_POST['Business']['business_image_url'];
	
					}					
					if($model->save(false)){
						$_SESSION['sess_business_id'] = $model->id;
						$_SESSION['tab_type'] = 'coupon';
					}
				}
				$this->redirect(CController::createUrl('index/tab'));
				Yii::app()->end();
			}
		}

				//insert creditcard information details.
		if(isset($_SESSION['tab_type']) && $_SESSION['tab_type'] == 'credit'){
			$user_id = Yii::app()->customer->id;
			$model= Creditcard::model()->find('user_id="'.$user_id.'"');
			//p($_POST);
			if(isset($_POST['Creditcard'])){
				$model->setAttributes($_POST['Creditcard']);				
				if($model->save(false)){
					//$this->redirect(CController::createUrl('register/login'));											
					$this->render('/index/index',array('type'=>$type));
					Yii::app()->end();
				}
			}
			

		}
	
		$this->render('tab',array('type'=>$type));
		Yii::app()->end();
	}
    function afterlatlong($cityname){
    	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address="'.$cityname.'"&sensor=false');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		return $latitude.'||'.$longitude;
    }

}