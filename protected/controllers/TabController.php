<?php
session_start();
class TabController extends FrontCoreController
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
   public function actionIndex()
	{	
		if(!isset($_SESSION['tab_type'])){
			$_SESSION['tab_type']='business';				
		}
		if(isset($_REQUEST['tab_type'])){	
			$type = 'business';
		}else{	
			$type=$_SESSION['tab_type'];
		}
		
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
				if(isset($_POST['Coupon']['id']) && !empty($_POST['Coupon']['id'])){
					$model = Coupon::model()->find('id="'.$_POST['Coupon']['id'].'"');					
				}
				$model->setAttributes($_POST['Coupon']);
				$model->user_id=$_SESSION['sess_bogo']['uid'];
				if($_POST['Coupon']['image_url']==''){
					if(($_FILES['Coupon']['name']['image']==''))
					{
					  if(isset($_POST['Coupon']['existing_image']) && !empty($_POST['Coupon']['existing_image'])){
								$model->image = $_POST['Coupon']['existing_image'];
					  }else{
							Yii::app()->user->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
							$this->render('index',array('model'=>$model,));
							Yii::app()->end();
					  }
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
					$this->redirect(CController::createUrl('tab/index'));
					Yii::app()->end();
				}
			}
			
			//$this->render(CController::createUrl('index/tab'));
			$this->render('tab',array('type'=>$type));
			Yii::app()->end();
		}
		
		//echo p($type,0); p($_POST,0); p($_SESSION['tab_type']); die;
		if(isset($_SESSION['tab_type']) && $_SESSION['tab_type'] == 'business'){
			$model= new Business();
			if(isset($_POST['Business'])){
				if(isset($_POST['Business']['id']) && !empty($_POST['Business']['id'])){
					$model = Business::model()->find('id="'.$_POST['Business']['id'].'"');					
				}
				$model->setAttributes($_POST['Business']);
				$model->user_id=$_SESSION['sess_bogo']['uid'];
				$model->coupon_id = 1;
				if((isset($_POST['Business']['city_name'])) && (isset($_POST['Business']['p_town'])) && !empty($_POST['Business']['city_name']) && !empty($_POST['Business']['p_town'])){
					$citymodel = City::model()->find('city_name = "'.$_POST['Business']['p_town'].'" && zipcode = "'.$_POST['Business']['business_zipcode'].'"');
					if(isset($citymodel) && !empty($citymodel))
					{
						$model->city_id = $citymodel->id;
					}else{
						$citymodel = new City();
						$citymodel->city_name = strtoupper($_POST['Business']['p_town']);
						$citymodel->latitude = $_POST['Business']['p_lat'];
						$citymodel->longitude = $_POST['Business']['p_lng'];
						$citymodel->zipcode = $_POST['Business']['business_zipcode'];
						$citymodel->type = 'STANDARD';
						$citymodel->save(false);
						$model->city_id = $citymodel->id;
					}	
				}
				 
				if($_POST['Business']['business_image']==''){
					if(($_FILES['Business']['name']['business_image']==''))
					{
						if(isset($_POST['Business']['existing_image']) && !empty($_POST['Business']['existing_image'])){
							$model->business_image = $_POST['Business']['existing_image'];
						}else{
							Yii::app()->user->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
							$this->render('index',array('model'=>$model,));
							Yii::app()->end();
						}
					}else{
						$width = "320";
						$height = "436";
						$path	= 	YiiBase::getPathOfAlias('webroot');
						$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
						$model->business_image=$_FILES['Business']['name']['business_image'];
						$model->business_image = CUploadedFile::getInstance($model, 'business_image');
						$model->business_image->saveAs($path.'/upload/business/'.$model->business_image);
						$image = Yii::app()->image->load($path.'/upload/business/'.$model->business_image);
						$image->resize($width, $height);
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
			
				$this->redirect(CController::createUrl('tab/index'));
				Yii::app()->end();
			}
		}

		//insert creditcard information details.
		if(isset($_SESSION['tab_type']) && $_SESSION['tab_type'] == 'credit'){
			$user_id = $_SESSION['sess_bogo']['uid'];
			$model= Creditcard::model()->find('user_id="'.$user_id.'"');
			//p($_POST);
			if(isset($_POST['Creditcard'])){
				$model->setAttributes($_POST['Creditcard']);				
				if($model->save(false)){								
					$this->redirect(CController::createUrl('register/login'));			
					//$this->render('/index/index',array('type'=>$type));
					Yii::app()->end();
				}
			}
		}
	
		$this->render('tab',array('type'=>$type));
		Yii::app()->end();
	}
	public function actionAddressFromPostCode()
	{	                
		if(isset($_GET['Customer_postcode']) && !empty($_GET['Customer_postcode'])){
			    // First, we need to take their postcode and get the lat/lng pair:
			    $postcode = $_GET["Customer_postcode"];
			    // Sanitize their postcode:
			    $search_code = urlencode($postcode);
			    $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $search_code . '&sensor=false';
			    $json = json_decode(file_get_contents($url));
			    $lat = $json->results[0]->geometry->location->lat;
			    $lng = $json->results[0]->geometry->location->lng;
			    // Now build the lookup:
			    $address_url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=false';
			    $address_json = json_decode(file_get_contents($address_url));
			    $array = $address_json->results;
			    $this->renderPartial('../tab/business/_postcodeaddress',array('address'=>$array,'type'=>$_GET['type']));
		}
	}
	
}
?>