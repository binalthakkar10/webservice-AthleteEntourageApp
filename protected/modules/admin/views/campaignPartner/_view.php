<div class="view">
     <ul style="float: left; width: 100%; margin: 0; padding: 0;">
     	
     <?php
     
      $appcampDetails = PostToExchange::model()->findAll("user_type=1 AND DATE(end_date) >= CURDATE()");
	 
	  foreach($appcampDetails as $postData){
						$userId= $postData['user_id'];
		  				$userDetails = UserDetail::model()->find("user_id=$userId");
		  				$postId= $postData['postexchange_id'];
						$mediaDetails = Media::model()->find("postexchange_id=$postId");
						$postMedia= $mediaDetails['file_name'];
						
						$postMediaName= $mediaDetails['media_type'];
						$profileImage = $userDetails['profile_image'];?>
						<li style="float: left; width: 100%; list-style: none; margin-bottom: 20px; ">
							<img style="float:left; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/UserMedia/'.$profileImage;?>"  height="100" width="100">
							<div style="float: left; width: 89%; position: relative;">
								<span style="display:block;"><?php echo $userDetails['twitter_screen_name'] ; ?>
									<a  type="button" class="btn btn-primary" href="<?php echo Yii::app()->baseUrl.'/admin/CampaignPartner/index?id='.$postId; ?>" style=" right: 40%; top:0; position: absolute; ">Hire</a>
								</span>
								
								<span style="display:block;width:50%;"><?php echo $postData['message'] ; ?></span>
								<span style="margin-top: 10px; display: block">
									<?php if($postMedia && ($postMediaName=="image")){?>
									<img style="float:left; margin-right: 10px;" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>"  height="100" width="100">
								
								<?php }elseif($postMedia && ($postMediaName=="video")){
								?>	
								 <video width="220px" height="227px" controls>
    		    <source type="video/mp4" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/ogv" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
                    <source type="video/webm" src="<?php  echo Yii::app()->baseUrl.'/upload/CampaignMedia/'.$postMedia;?>">
 </video>
								
								<?php }?>
								</span>
							</div>
						</li>
	<?php   } ?>
	</ul>
</div>