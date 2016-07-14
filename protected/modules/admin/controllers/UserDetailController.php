<?php

class UserDetailController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'UserDetail'),
		));
	}
	public function actionCreate() {
		$model = new UserDetail;


		if (isset($_POST['UserDetail'])) {
			$model->setAttributes($_POST['UserDetail']);
			if($_POST['UserDetail']['profile_image']==''){
					if(($_FILES['UserDetail']['name']['profile_image']==''))
					{
							Yii::app()->user->setFlash('error', Yii::t("messages","Please Upload a One of Them Images"));
							$this->render('create', array( 'model' => $model));
							Yii::app()->end();
					}else{
						$width = "320";
						$height = "436";
						$path	= 	YiiBase::getPathOfAlias('webroot');
						$url ='http://'.$_SERVER['HTTP_HOST']. Yii::app()->baseUrl;
						$model->profile_image=$_FILES['UserDetail']['name']['profile_image'];
						$model->profile_image = CUploadedFile::getInstance($model, 'profile_image');
						$model->profile_image->saveAs($path.'/upload/UserMedia/'.$model->profile_image);
						$image = Yii::app()->image->load($path.'/upload/UserMedia/'.$model->profile_image);
						$image->resize($width, $height);
						$image->save();
						$image_path=$url.'/upload/UserMedia/'.$model->profile_image;
						$model->profile_image= $model->profile_image;
					}

			}else{
					$model->profile_image = $_POST['UserDetail']['profile_image'];

			}
			if ($model->save(false)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin', 'id' => $model->user_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}
	/*public function actionCreate() {
		$this->pageTitle = "Create Users || Roster Network";
		$model = new UserDetail;


		if (isset($_POST['UserDetail'])) {
			$model->setAttributes($_POST['UserDetail']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin'));
			}
		}

		$this->render('create', array( 'model' => $model));
	}*/

	public function actionUpdate($id) {
		$this->pageTitle = "Update Users || Roster Network";
		$model = $this->loadModel($id, 'UserDetail');


		if (isset($_POST['UserDetail'])) {
			$model->setAttributes($_POST['UserDetail']);
			
			
			if ($model->save()) {
			

				$this->redirect(array('admin'));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'UserDetail')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('UserDetail');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->pageTitle = "Users || Roster Network";
		$model = new UserDetail('search');
		$model->unsetAttributes();
		if (isset($_GET['UserDetail']))
			$model->setAttributes($_GET['UserDetail']);
		$this->render('admin', array(
			'model' => $model,
		));
	}


public function actionDeleteAll()
{
	
		$var=	$_REQUEST['id'];
        if (isset($var))
        {
        			$explode=(explode(",",$var));
            			 for($i = 0; $i < count($explode); $i++)
           				 {	
  						  $appUserDetails = UserDetail::model()->find("user_id = '".$explode[$i]."'");
						  if($appUserDetails)
						  {
						  		$uid=$appUserDetails['user_id'];
								$screenName=$appUserDetails['twitter_screen_name'];
							    $userdata=$this->loadModel($uid, 'UserDetail');
								if($userdata['is_verified']==0)
								{

								$userdata->is_verified=1;
								if($userdata->save(false)){
									Yii::app()->admin->setFlash('error', 'selected user has been  verified.');
									$this->redirect(array('admin'));	  
								}
							}else{
								Yii::app()->admin->setFlash('error', 'selected user is already verified.');
								$this->redirect(array('admin'));
							}
							
						}  
						 }
							
              
        }
        else
        {
                Yii::app()->user->setFlash('error', 'Please select at least one record to verify.');
                $this->redirect(array('admin'));
        }    
		
	
		
		           
}
		/*public function actionAllInformation()
		{
			$u_id=$_POST['id'];
			$camList= array();
			//$campaignIdArray=array();
			//$partner=array();
			$userDetaildata = UserDetail::model()->find("user_id = '".$u_id."' AND is_delete=1");
			if($userDetaildata)	
			{
				
				$userScreenName=$userDetaildata['twitter_screen_name'];
				$user_type=$userDetaildata['user_type'];
				echo '<h1 align="center">'.$userScreenName.'</h1>';
				$campaignDetails = "SELECT campaign.`campaign_id`,count(campaign.`compaign_message`) as ctotal,campaign.`compaign_message`,campaign.`total_cost`,campaign_partner.twitter_screen_name 
									FROM `campaign` JOIN campaign_partner ON campaign.`campaign_id`=campaign_partner.campaign_id WHERE campaign.`is_delete`=1 
									AND campaign.`user_id`='".$u_id."' GROUP BY campaign.`compaign_message`";
				$campData = Yii::app()->db->createCommand($campaignDetails);
						$campaignList = $campData->queryAll();					
					if($campaignList)
					{
						echo '<div>';
						echo'<table>';
						echo '<tr><th> Campaign Name </th><th> Total Cost</th><th>Total Partners</th><th>Activity</th></tr>';
						foreach($campaignList as $campaignData)
						{
							$campaign_id=$campaignData['campaign_id'];		
							echo '<tr><td>'.$campaignData['compaign_message'].'</td><td>'.$campaignData['total_cost'].'</td><td>'.$campaignData['ctotal'].'</td>' ;						
							$socialData = SocialPosts::model()->find("campaign_id = '".$campaign_id."'");	
										{
											if($socialData)
											{
											echo '<td>'."1".'</td>';
											}else{
												echo '<td>'."0".'</td>';
											}
											
										}
										
										
						}
						
					echo	'</table>';	
					echo '</div>';				
					}	
					
					
					if($user_type==1){
						echo '<div>';	
						echo'<table style="margin-top: 11px;">';
						echo '<tr><th> Balance </th><th>No of Shares</th><th>Cashout Status</th></tr>';
									$balData = Balance::model()->find("user_id = '".$u_id."'  AND is_delete=1");	
										{
											if($balData)
											{
											echo '<tr><td>'.$balData['balance'].'</td>';
											}else{
												echo '<td>'."0".'</td>';
											}
											
										}
										
										$shareData = ConvertToShare::model()->find("user_id = '".$u_id."'  AND is_delete=1");	
										{
											if($shareData)
											{
											echo '<td>'.$shareData['no_of_shares'].'</td>';
											}else{
												echo '<td>'."0".'</td>';
											}
											
										}
										
										$cashoutData = Cashout::model()->find("user_id = '".$u_id."'  AND is_delete=1");	
										{
											if($cashoutData)
											{
												if($cashoutData['is_verified']==0){
													echo '<td>'."Pending...".'</td></tr>';
												}elseif($cashoutData['is_verified']==1){
													echo '<td>'."Processed".'</td></tr>';
												}
											}else{
												echo '<td>'."0".'</td></tr>';
											}
											
										}
										
									echo	'</table>';			
									echo '</div>';
					}
								
					
				
				
			}else{
                echo 'The User Is Already Deleted';
        }  
			
			
		}	

		public function actionDeleteData()
		{
			$u_id=$_POST['id'];
				// User Detail
			$userDetaildata = UserDetail::model()->find("user_id = '".$u_id."' AND is_delete=1");
		
			if($userDetaildata)	
			{			
						$id = $userDetaildata['user_id'];
						$screenName=$userDetaildata['twitter_screen_name'];
						$modelData = $this->loadModel($id, 'UserDetail');
						$modelData->is_delete ="0";
						$modelData->save(false);
						
						// Cashout
						$cashoutAlldata = Cashout::model()->findAll("user_id = '".$u_id."' AND is_delete=1");
						if($cashoutAlldata){
						foreach($cashoutAlldata as $cashoutData){
								$cashoutId = $cashoutData['cashout_id'];
								$cashmodelData = $this->loadModel($cashoutId, 'Cashout');
								$cashmodelData->is_delete ="0";
								$cashmodelData->save(false);
								}	
						}
						// Balance
						$balanceAlldata = Balance::model()->findAll("user_id = '".$u_id."' AND is_delete=1");
						if($balanceAlldata){
						foreach($balanceAlldata as $balData){
								$balId = $balData['balance_id'];
								$balmodelData = $this->loadModel($balId, 'Balance');
								$balmodelData->is_delete ="0";
								$balmodelData->save(false);
								}	
						}
						
						// Transaction
						$transactionAlldata = Transaction::model()->findAll("user_id = '".$u_id."' AND is_delete=1");
						if($transactionAlldata){
						foreach($transactionAlldata as $transactionData){
								$tranId = $transactionData['transaction_id'];
								$transmodelData = $this->loadModel($tranId, 'Transaction');
								$transmodelData->is_delete ="0";
								$transmodelData->save(false);
								}	
						}
						
							// Convert To Share
						$convertAlldata = ConvertToShare::model()->findAll("user_id = '".$u_id."' AND is_delete=1");
						if($convertAlldata){
						foreach($convertAlldata as $convertData){
								$convertId = $convertData['convert_id'];
								$convertmodelData = $this->loadModel($convertId, 'ConvertToShare');
								$convertmodelData->is_delete ="0";
								$convertmodelData->save(false);
								}	
						}
						
						
						// Campaign
						$campaignDetails = Campaign::model()->findAll("user_id = '".$u_id."'  AND is_delete=1");
						{
							if($campaignDetails){
								foreach($campaignDetails as $campaignData){
									$camId = $campaignData['campaign_id'];
									$camData = $this->loadModel($camId, 'Campaign');
									$camData->is_delete ="0";
									$camData->save(false);
								// Campaign Partners
										$campaignPartner = CampaignPartner::model()->findAll("campaign_id = '".$camId."' AND is_delete=1");	
										if($campaignPartner)
										{											
											foreach($campaignPartner as $campaignpartnerData)
											{
												$campPartnerId = $campaignpartnerData['id'];
												$campPartnerData = $this->loadModel($campPartnerId, 'CampaignPartner');
												$campPartnerData->is_delete ="0";
												$campPartnerData->save(false);									
											}
										}	
									// Campaign Social Data
										$socialData = SocialPosts::model()->find("campaign_id = '".$camId."' AND is_delete=1");	
										{
											if($socialData)
											{
													$socialId = $socialData['social_id'];
													$socialdata = $this->loadModel($socialId, 'SocialPosts');
													$socialdata->is_delete ="0";
													$socialdata->save(false);
											}
										}
										// Campaign Media
										$mediaData = Media::model()->findAll("campaign_id = '".$camId."' AND is_delete=1");	
										{
											if($mediaData)
											{
												foreach($mediaData as $media)
												{
													$mediaId = $media['media_id'];
													$mediadata = $this->loadModel($mediaId, 'Media');
													$mediadata->is_delete ="0";
													$mediadata->save(false);
												}
											}
										}
										// Campaign P-T-E
										$postToExchange = PostToExchange::model()->findAll("campaign_id = '".$camId."' AND is_delete=1");	
										{
											if($postToExchange)
											{
												foreach($postToExchange as $postToExchangeData)
												{
													$postId = $postToExchangeData['postexchange_id'];
													$postData = $this->loadModel($postId, 'PostToExchange');
													$postData->is_delete ="0";
													$postData->save(false);
												}
											}
										}
										// Campaign Transaction
										$transactionData = Transaction::model()->findAll("campaign_id = '".$camId."' AND is_delete=1");	
										{
											if($transactionData)
											{
												foreach($transactionData as $transaction)
												{
													$transID = $transaction['transaction_id'];
													$transData = $this->loadModel($transID, 'Transaction');
													$transData->is_delete ="0";
													$transData->save(false);
												}
											}
										}
										// Campaign Ratings
										$ratingData = Ratings::model()->find("campaign_id = '".$camId."' AND is_delete=1");	
										{
											if($ratingData)
											{
													$ratingId = $ratingData['rating_id'];
													$ratingdata = $this->loadModel($ratingId, 'Ratings');
													$ratingdata->is_delete ="0";
													$ratingdata->save(false);
											}
										}

								}
							}
						
						}
								// User HAve done P-T-E
								$postToExchange1 = PostToExchange::model()->findAll("user_id = '".$u_id."' AND is_delete=1");	
										{
											if($postToExchange1)
											{
												foreach($postToExchange1 as $postToExchangeData1)
												{
													$postId1 = $postToExchangeData1['postexchange_id'];
													$postData1 = $this->loadModel($postId1, 'PostToExchange');
													$postData1->is_delete ="0";
													$postData1->save(false);
													
													$mediaData1 = Media::model()->findAll("postexchange_id = '".$postId1."'");	
													{
														if($mediaData1)
														{
															foreach($mediaData1 as $media1)
															{
																$mediaId1 = $media1['media_id'];
																$mediadata1 = $this->loadModel($mediaId1, 'Media');
																$mediadata1->is_delete ="0";
																$mediadata1->save(false);
															}
														}
													}
												}
											}
										}
										
								$campaignPartner1 = CampaignPartner::model()->findAll("twitter_screen_name = '".$screenName."' AND is_delete=1");	
										if($campaignPartner1)
										{											
											foreach($campaignPartner1 as $campaignpartnerData1)
											{
												$campPartnerId1 = $campaignpartnerData1['id'];
												$campPartnerData1 = $this->loadModel($campPartnerId1, 'CampaignPartner');
												$campPartnerData1->is_delete ="0";
												$campPartnerData1->save(false);									
											}
										}	
										
								
			}else{
                Yii::app()->user->setFlash('error', 'The user is already deleted.');
                $this->redirect(array('admin'));
        } 
		}
		
		public function loadModel($id, $type, $errorMessage = 'This page does not exist', $errorNum = 404) {
		eval('$model = ' . $type . '::model()->findByPk($id);');
		if ($model === null)
			throw new CHttpException($errorNum, $errorMessage);
		return $model;
	}*/
	
}
?>
