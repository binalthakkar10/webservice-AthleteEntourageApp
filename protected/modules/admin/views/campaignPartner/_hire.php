<div class="view">
     <ul style="float: left; width: 100%; margin: 0; padding: 0;">
     <?php 
     $id=$_GET['id'];
     $postData = PostToExchange::model()->find("postexchange_id=".$id);
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
									<input  type="button" class="btn btn-primary" style=" right: 40%; top:0; position: absolute; " value="Hire"  onclick="hireUser(<?php echo $id ?>);">
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
	
	</ul>
</div>

<script>
function hireUser(Vid){
	var tag = $("<div></div>");
	
	tag.dialog({
		  autoOpen: false,
		  height: 500,
		  width: 1108,
		  modal: true,
		  buttons: {
		  	Done: function () {
		  		var r = confirm("Are you sure? want to hire the user");
				if(r == true) {
		  		var formData = new FormData($("#formdata")[0]);
		  			$.ajax({
				 type:'post',
				 url:"<?php echo CController::createUrl('/admin/CampaignPartner/HireConfirm');?>",
				 data: formData,
				processData: false, 
				contentType: false, 
				cache:false,
				async:false,
				 success:function(data){
				 location.reload();
				 tag.html(data).dialog({modal: true}).dialog('close');
				 	
				 }
				});
			}else{
				 $( this ).dialog( "close" );
			}
                    
               },
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
			 
		  }
		 
		});
	$.ajax({
		 type:'post',
		 url:"<?php echo CController::createUrl('/admin/CampaignPartner/HireUser');?>",
		 data:{'id':Vid},
		 dataType:"text",
		 success:function(data){
		 tag.html(data).dialog({modal: true}).dialog('open');
		 }
	});
}
	</script>