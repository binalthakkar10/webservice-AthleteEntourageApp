<?php

class CampaignController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Campaign'),
		));
	}

	public function actionCreate() {
		$model = new Campaign;


		if (isset($_POST['Campaign'])) {
			$model->setAttributes($_POST['Campaign']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->campaign_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Campaign');


		if (isset($_POST['Campaign'])) {
			$model->setAttributes($_POST['Campaign']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->campaign_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Campaign')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actiondeleteCampaign(){
		$campaignId = $_REQUEST['camp_id'];
		
		 
		$campaignData = $this->loadModel($campaignId,'Campaign');
		$campaignData->is_delete = '0';
		$campaignData->is_close = '1';
		if($campaignData->save(false)){
			$campaignPartner = CampaignPartner::model()->findAll("campaign_id = '".$campaignId."' AND is_delete=1");	
								foreach($campaignPartner as $campaignpartnerData)
											{
												$campPartnerId = $campaignpartnerData['id'];
												$campPartnerData = $this->loadModel($campPartnerId, 'CampaignPartner');
												$campPartnerData->is_delete ="0";
												$campPartnerData->save(false);									
											}
								$mediaData = Media::model()->findAll("campaign_id = '".$campaignId."' AND is_delete=1");	
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
							$postToExchange = PostToExchange::model()->findAll("campaign_id = '".$campaignId."' AND is_delete=1");	
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
							$ratingData = Ratings::model()->find("campaign_id = '".$campaignId."' AND is_delete=1");	
										{
											if($ratingData)
											{
													$ratingId = $ratingData['rating_id'];
													$ratingdata = $this->loadModel($ratingId, 'Ratings');
													$ratingdata->is_delete ="0";
													$ratingdata->save(false);
											}
										}
							$socialData = SocialPosts::model()->find("campaign_id = '".$campaignId."' AND is_delete=1");	
										{
											if($socialData)
											{
													$socialId = $socialData['social_id'];
													$socialdata = $this->loadModel($socialId, 'SocialPosts');
													$socialdata->is_delete ="0";
													$socialdata->save(false);
											}
										}										
		}
		
		}
	
	public function actiondeleteCampaignMultiple(){
		$campaign = $_REQUEST['camp_id'];
		 $campaignId=(explode(",",$campaign));
		 for($i = 0; $i < count($campaignId)-1; $i++)
           {
		$campaignData = $this->loadModel($campaignId[$i],'Campaign');
		$campaignData->is_delete = '0';
		$campaignData->is_close = '1';
		if($campaignData->save(false)){
			$campaignPartner = CampaignPartner::model()->findAll("campaign_id = '".$campaignId[$i]."' AND is_delete=1");	
								foreach($campaignPartner as $campaignpartnerData)
											{
												$campPartnerId = $campaignpartnerData['id'];
												$campPartnerData = $this->loadModel($campPartnerId, 'CampaignPartner');
												$campPartnerData->is_delete ="0";
												$campPartnerData->save(false);									
											}
								$mediaData = Media::model()->findAll("campaign_id = '".$campaignId[$i]."' AND is_delete=1");	
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
							$postToExchange = PostToExchange::model()->findAll("campaign_id = '".$campaignId[$i]."' AND is_delete=1");	
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
							$ratingData = Ratings::model()->find("campaign_id = '".$campaignId[$i]."' AND is_delete=1");	
										{
											if($ratingData)
											{
													$ratingId = $ratingData['rating_id'];
													$ratingdata = $this->loadModel($ratingId, 'Ratings');
													$ratingdata->is_delete ="0";
													$ratingdata->save(false);
											}
										}
							$socialData = SocialPosts::model()->find("campaign_id = '".$campaignId[$i]."' AND is_delete=1");	
										{
											if($socialData)
											{
													$socialId = $socialData['social_id'];
													$socialdata = $this->loadModel($socialId, 'SocialPosts');
													$socialdata->is_delete ="0";
													$socialdata->save(false);
											}
										}										
		}
		
		}
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Campaign');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->pageTitle = "Campaign || Roster Network";
		$model = new Campaign('search');
		$model->unsetAttributes();

		if (isset($_GET['Campaign']))
			$model->setAttributes($_GET['Campaign']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionAdminMessage() {
		$this->pageTitle = "SocialPosts || Roster Network";
		$model = new SocialPosts('searchData');
		$model->unsetAttributes();

		if (isset($_GET['SocialPosts']))
			$model->setAttributes($_GET['SocialPosts']);

		$this->render('admincampaign', array(
			'model' => $model,
		));
	}
	
	public function actionGetId(){
				$user_id=$_REQUEST['uid'];
				$appUserDetails = Campaign::model()->findAll("user_id = '".$user_id."'");
				?><select name="cam_message" id="camp">
					<option value="0">Select Campaign Message</option>
					<?php
						foreach($appUserDetails as $userList)
						{
							echo'<option value="'.$userList['campaign_id'].'">'.$userList['compaign_message'].'</option>';
						}
					?>
					</select>
					<?php
				
		}
public function actionAllInformation(){
		
		
		?>
		<div class="view">
     <ul style="float: left; width: 100%; margin: 0; padding: 0;">
     <?php 
     $id=$_POST['id'];
     $campData = Campaign::model()->find("campaign_id=".$id);
						$campaignMessage= $campData['compaign_message'];
						$mediaDetails = Media::model()->find("campaign_id=$id");
						$postMedia= $mediaDetails['file_name'];
						
						$postMediaName= $mediaDetails['media_type'];?>
						<li style="float: right; width: 100%; list-style: none; margin-bottom: 20px; ">
							<div style="float: right; width: 89%; position: relative;">
							<span style="display:block;"><h1><?php echo $campaignMessage; ?></h1>
								<h3>
								<span style="margin-top: 10px; display: block">
									<?php if($postMedia && ($postMediaName=="image")){?>
									<img style="float:left; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>"  height="100" width="100">
								<?php }elseif($postMedia && ($postMediaName=="video")){
								?>	
								 <video width="220px" height="227px" controls>
    		    <source type="video/mp4"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/ogv"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/webm"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
 </video>
								</span>
								<?php }
									echo "<div style='display:table;'>";
								$socialDetails = SocialPosts::model()->find("campaign_id=$id");
								if($socialDetails['twitter_screen_name']){
									echo "<div style='display:inline-block; width:100%; float:left;'><span style='width:20%; float:left;'>Social post done by</span><span style='width:68%; float:left; font-weight:normal;'>".$socialDetails['twitter_screen_name']."</span></div>";
								}
								if($socialDetails['message']){
									echo "<div style='margin:15px 0 0; width:100%; float:left; display:inline-block;'><span style='width:20%; float:left;'>With message</span><span style='width:68%; font-weight:normal; float:left;'>".$socialDetails['message']."</span></div>";
								}
								
							$image=	trim($socialDetails['image_url']);
							$video=	trim($socialDetails['video_url']);
								
								?>
								
									<span style="margin-top: 10px; display: block">
									<?php if($image){?>
									<img style="float:left; width:200px; height:200px; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$image;?>" >
								<?php }else{?>
									<img style="float:left; width:200px; height:200px; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/images.jpg'?>" >
								<?php }
								
								if($video){
								?>	
								  <video style="width:200px; height:200px;"  controls>
    		    <source type="video/mp4"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$video;?>">
                    <source type="video/ogv"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$video;?>">
                    <source type="video/webm"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$video;?>">
 </video>
								</span>
								
								<?php }else{?>
									<img style="float:left; width:390px; height:200px; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/novideo.png'?>" >
								<?php }
								echo "</div>";
								?>
							</div>
						</li>
	
	</ul>
	
</div>


<?php
		
		
	

}

}
?>