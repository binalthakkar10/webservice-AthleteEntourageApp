<?php

class PostToExchangeController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'PostToExchange'),
		));
	}

	public function actionCreate() {
		$model = new PostToExchange;


		if (isset($_POST['PostToExchange'])) {
			$model->setAttributes($_POST['PostToExchange']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->postexchange_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'PostToExchange');


		if (isset($_POST['PostToExchange'])) {
			$model->setAttributes($_POST['PostToExchange']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->postexchange_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'PostToExchange')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
	
		public function actiondeleteExchange(){
		$exchangeId = $_REQUEST['exchange_id'];
		$exchangeData = $this->loadModel($exchangeId,'PostToExchange');
		$exchangeData->is_delete = '0';
		if($exchangeData->save(false))
		{
										$mediaData = Media::model()->findAll("postexchange_id = '".$exchangeId."'");	
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
													$socialData = SocialPostsExchange::model()->findAll("postexchange_id = '".$exchangeId[$i]."'");	
													{
														if($socialData)
														{
															foreach($socialData as $social)
															{
																$socialId = $social['social_id'];
																$socialdata = $this->loadModel($socialId, 'SocialPostsExchange');
																$socialdata->is_delete ="0";
																$socialdata->save(false);
																
															}
														}
													}
													
		
		   }
	}
		public function actiondeleteExchangeMultiple(){
		$exchange = $_REQUEST['exchange_id'];
	
		 $exchangeId=(explode(",",$exchange));
		
		 for($i = 0; $i < count($exchangeId)-1; $i++)
           {
		$exchangeData = $this->loadModel($exchangeId[$i],'PostToExchange');
		$exchangeData->is_delete = '0';
		if($exchangeData->save(false))
		{
										$mediaData = Media::model()->findAll("postexchange_id = '".$exchangeId[$i]."'");	
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
													$socialData = SocialPostsExchange::model()->findAll("postexchange_id = '".$exchangeId[$i]."'");	
													{
														if($socialData)
														{
															foreach($socialData as $social)
															{
																$socialId = $social['social_id'];
																$socialdata = $this->loadModel($socialId, 'SocialPostsExchange');
																$socialdata->is_delete ="0";
																$socialdata->save(false);
																
															}
														}
													}
		}
		   }
	}
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('PostToExchange');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->pageTitle = "Posts || Roster Network";
		$model = new PostToExchange('search');
		$model->unsetAttributes();

		if (isset($_GET['PostToExchange']))
			$model->setAttributes($_GET['PostToExchange']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionAdminMessage() {
		$this->pageTitle = "SocialPostsExchange || Roster Network";
		$model = new SocialPostsExchange('searchData');
		$model->unsetAttributes();

		if (isset($_GET['SocialPostsExchange']))
			$model->setAttributes($_GET['SocialPostsExchange']);

		$this->render('adminexchange', array(
			'model' => $model,
		));
	}
	public function actionAllInformation(){
		
		
		?>
		<div class="view">
     <ul style="float: left; width: 100%; margin: 0; padding: 0;">
     <?php 
     $id=$_POST['id'];
     $postData = PostToExchange::model()->find("postexchange_id=".$id);
						$postMessage= $postData['message'];
						$mediaDetails = Media::model()->find("postexchange_id=$id");
						$postMedia= $mediaDetails['file_name'];
						
						$postMediaName= $mediaDetails['media_type'];?>
						<li style="float: right; width: 100%; list-style: none; margin-bottom: 20px; ">
							<div style="float: right; width: 89%; position: relative;">
							<span style="display:block;"><h1><?php echo $postMessage; ?></h1>
								<h3>
								<div style="margin-top: 10px; display: block">
									<?php if($postMedia && ($postMediaName=="image")){?>
									<img style="float:left; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>"  height="100" width="100">
								<?php }elseif($postMedia && ($postMediaName=="video")){
								?>	
								 <video width="220px" height="227px" controls>
    		    <source type="video/mp4"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/ogv"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/webm"  src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
 </video>
								</div>
								<?php }
								echo "<div style='display:table;'>";
								$socialDetails = SocialPostsExchange::model()->find("postexchange_id=$id");
								if($socialDetails['twitter_screen_name']){
									echo "<div style='display:inline-block; width:100%; float:left;'><span style='width:20%; float:left;'>Social post done by </span><span style='width:68%; float:left; font-weight:normal; '>".$socialDetails['twitter_screen_name']."</span></div>";
								}
								if($socialDetails['message']){
									echo "<div style='margin:15px 0 0; width:100%; float:left; display:inline-block;'><span style='width:20%; float:left;'>With message </span><span style='width:68%; font-weight:normal; float:left;'>".$socialDetails['message']."</span></div>";
								}
							$image=	trim($socialDetails['image_url']);
							$video=	trim($socialDetails['video_url']);
							
								?>
								
									<span style="margin-top: 10px; display: inline-block">
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
								
								
								
								<?php }else{?>
									<img style="float:left; width:390px; height:200px; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/novideo.png'?>" >
								<?php }
								echo "</span>";
									echo "</div>";
								
								?>
							</div>
						</li>
	
	</ul>
	
</div>


<?php
		
		
	

}

}