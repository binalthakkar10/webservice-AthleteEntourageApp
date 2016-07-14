<?php

class CampaignPartnerController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'CampaignPartner'),
		));
	}

	public function actionCreate() {
		$model = new CampaignPartner;


		if (isset($_POST['CampaignPartner'])) {
			$model->setAttributes($_POST['CampaignPartner']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'CampaignPartner');


		if (isset($_POST['CampaignPartner'])) {
			$model->setAttributes($_POST['CampaignPartner']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'CampaignPartner')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionHire() {
			$model = new CampaignPartner();
		$this->render('hire', array(
				'model' => $model,
				));

	}

	public function actionIndex() {
		$model = new CampaignPartner();
		$this->render('index', array(
				'model' => $model,
				));
	}


	public function actionAdmin() {
		$campaign_id=$_REQUEST['campaign_id'];
		$model = new CampaignPartner('search');
		$model->unsetAttributes();

		if (isset($_GET['CampaignPartner']))
			$model->setAttributes($_GET['CampaignPartner']);
		if(isset($campaign_id) && !empty($campaign_id)){
			$this->renderPartial('admin', array(
			'model' => $model,'campaign_id'=> $campaign_id
			));
		}else{
			$this->render('admin', array(
			'model' => $model,
			));	
		}
		
	}
	
	public function actionHireUser(){
		
		?>
		<div class="view">
     <ul style="float: left; width: 100%; margin: 0; padding: 0;">
     <?php 
     $id=$_POST['id'];
     $postData = PostToExchange::model()->find("postexchange_id=".$id);
						$userId= $postData['user_id'];
		  				$userDetails = UserDetail::model()->find("user_id=$userId");
		  				$postId= $postData['postexchange_id'];
						$mediaDetails = Media::model()->find("postexchange_id=$postId");
						$postMedia= $mediaDetails['file_name'];
						
						$postMediaName= $mediaDetails['media_type'];
						$profileImage = $userDetails['profile_image'];?>
						<li style="float: right; width: 100%; list-style: none; margin-bottom: 20px; ">
							<form id="formdata" method="POST" enctype="multipart/form-data">
							<img style="float:left; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/UserMedia/'.$profileImage;?>"  height="100" width="100">
							<div style="float: right; width: 89%; position: relative;">
							<span style="display:block;"><input type="text" name="screen_name" value="<?php echo $userDetails['twitter_screen_name'] ; ?>" readonly>
								<span style="display:block;"><textarea name="message"><?php echo $postData['message'] ; ?></textarea></span>
								<span style="margin-top: 10px; display: block">
									<?php if($postMedia && ($postMediaName=="image")){?>
									<img id="imgprvw" style="float:left; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>"  height="100" width="100">
									<input type="file" name="filename" id="filUpload" onchange="showimagepreview(this)" />		
				

									<input type="hidden" name="hidden_image" value="<?php echo $postMedia;?>">							
									 
								<?php }elseif($postMedia && ($postMediaName=="video")){
								?>	
								 <video width="220px" height="227px" controls>
    		    <source type="video/mp4"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/ogv"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/webm"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
 </video>
								
								<?php }?>
								</span>
							</div>
							</form>
						</li>
	
	</ul>
	
</div>
 <script type="text/javascript">
function showimagepreview(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}
</script>

<?php
		
		
	}
		public function actionHireConfirm()
		{
			
			$model = new Campaign();
			if(isset($_POST['message']) && !empty($_POST['message'])){
			$userDetails = UserDetail::model()->find("twitter_screen_name = '".$_POST['screen_name']."'");
			$model->compaign_message = $_POST['message'];
			$model->total_cost=$userDetails['impact_score']*30;
			$model->package_followers=$userDetails['twitter_followers'];
		
			$model->user_id=95;
			$model->is_campaign=0;
			$model->is_paid=1;
			}														
				
			if($model->save(false)){	
			$campaignId=$model->campaign_id;
			if(isset($_FILES['filename']['name']))
				{
				$modelMedia = new Media();
					if(isset($_FILES['filename']['name']) && !empty($_FILES['filename']['name'])){
						$filename=$_FILES['filename']['name'];
						$modelMedia->media_type = "image";
						$path	= 	YiiBase::getPathOfAlias('webroot');
						$modelMedia->file_name = $filename;
						
						move_uploaded_file($_FILES["filename"]["tmp_name"],
      					"upload/CampaignMedia/" . $_FILES["filename"]["name"]);
						$modelMedia->campaign_id=$campaignId;	
						}else{
							$filename=$_POST['hidden_image'];
							$modelMedia->media_type = "image";
							$modelMedia->file_name = $filename;
							$modelMedia->campaign_id=$campaignId;
						}
					($modelMedia->save(false));
													
				}
					if(isset($_POST['screen_name']))
						{ 
							$modelPartner= new CampaignPartner;	
							$modelPartner->campaign_id =$campaignId;
							$modelPartner->twitter_screen_name=$_POST['screen_name'];
							$modelPartner->is_member=1;
							$modelPartner->is_verified=1;
							$modelPartner->impact_score=$userDetails['impact_score'];
							($modelPartner->save(false));															
						}							
				}
				}
		
			
		
}
