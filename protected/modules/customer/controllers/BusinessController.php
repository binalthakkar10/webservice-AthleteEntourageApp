<?php

class BusinessController extends FrontCoreController
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
		$i=1;
		$id=Yii::app()->customer->id;
		$model=Business::model()->findAll('user_id="'.$id.'"');

		$criteria = new CDbCriteria;
		$criteria->select = 't.*, tc.city_name,tn.category_name,co.deal_title';
		$criteria->join = 'LEFT JOIN city as tc on tc.id = t.city_id
							LEFT JOIN categories as tn on tn.id = t.category_id  
							LEFT JOIN coupon as co on co.id = t.coupon_id  ';
		$criteria->addCondition('t.user_id="'.$id.'"');
		$resultSet	=	Business::model()->findAll($criteria);


		$data_arr = array();
		foreach($resultSet as $data){
			//p($data->title);
			$data_arr[]=array(
					'counter'=>$i++,
					'id'=>$data->id,
					'business_name'=> $data->business_name,
					'business_image_url'=> $data->business_image_url,
					'business_phone_number'=>$data->business_phone_number,
					'coupon'=>$data->deal_title,
					'city'=>$data->city_name,
					'category'=>$data->category_name,
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

	public function actionAddBusiness(){
		$model= new Business();
		if(isset($_POST['Business'])){
			$model->setAttributes($_POST['Business']);
			$model->user_id=Yii::app()->customer->id;
			
			if((isset($_POST['Business']['city_name'])) && (isset($_POST['Business']['p_town'])) && !empty($_POST['Business']['city_name']) && !empty($_POST['Business']['p_town'])){
				$citymodel = City::model()->find('city_name = "'.$_POST['Business']['p_town'].'" AND zipcode = "'.$_POST['Business']['business_zipcode'].'"');
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
							$image->resize($width, $height);
							$image->save();
							$image_path=$url.'/upload/business/'.$model->business_image;
							$model->business_image_url=$image_path;
	
						}
	
					}else{
						$model->business_image_url=$_POST['Business']['business_image_url'];
	
					}
			if($model->save(false)){
				$this->redirect('index');
				Yii::app()->end();
			}
		}
		$this->render('index',array('model'=>$model));
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
			    $this->renderPartial('_postcodeaddress',array('address'=>$array,'type'=>$_GET['type']));
		}
	}
	public function actionUpdate($id){

		$model = Business::model()->find('id="'.$id.'"');
		if(isset($_POST['Business']) && !empty($_POST['Business'])){
			$model->setAttributes($_POST['Business']);
			
			if($model->save(false)){
				$this->redirect(CController::createUrl('business/index'));
				Yii::app()->end();
			}	
				
			
		}
		$this->render('index', array('model' => $model));
	}
	
	public function actionDelete($id){
		$model=Business::model()->deleteAll("id='".$id."'");
		$this->redirect(CController::createUrl('business/index'));
		
		
	}



	




}