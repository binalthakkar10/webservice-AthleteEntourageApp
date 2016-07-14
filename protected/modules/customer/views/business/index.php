
<?php
if(!isset($type)){
 $this->renderPartial('/layouts/subheader');
}
 ?>
<div class="form form_main">
<div class="bg">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'business-_form-form',
    'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
     'clientOptions' => array(
		      'validateOnSubmit'=>true,
		      //'validateOnChange'=>true,
		      //'validateOnType'=>false,
          ),
     'stateful'=>false,
	'htmlOptions'=>array('enctype' => 'multipart/form-data')

)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    
    <?php echo $form->hiddenField($model,'id');?>
    
    <?php 
    
    $model->user_id=Yii::app()->customer->id;
    ?>
         <?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    
   
 <div class="row">
        <?php echo $form->labelEx($model,'business_name'); ?>
        <?php echo $form->textField($model,'business_name'); ?>
        <?php echo $form->error($model,'business_name'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'business_image_url'); ?>
        <?php echo $form->textField($model,'business_image_url'); ?>
        <?php echo $form->error($model,'business_image_url'); ?>
    </div>
     
	  OR
	    
    <div class="row">
        <?php echo $form->labelEx($model,'business_image',array('style'=>'line-height:33px')); ?>
        <?php echo $form->FileField($model,'business_image'); ?>
        <br>
        <span class="image_business_image">
        <?php echo Yii::t('inx', '(Image Size:- 320px(Width)* 436px(Height))');?>
        </span>
        <?php echo $form->error($model,'business_image'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'business_phone_number'); ?>
        <?php echo $form->textField($model,'business_phone_number'); ?>
        <?php echo $form->error($model,'business_phone_number'); ?>
    </div>
    
    
     <div class="row">
        <?php echo $form->labelEx($model,'coupon_id'); ?>
       <span class="field"><?php echo $form->dropDownList($model,'coupon_id', CHtml::listData(Coupon::model()->findAll("user_id=$model->user_id"),'id','deal_title')); ?></span>
        <?php echo $form->error($model,'coupon_id'); ?>
    </div>
    
    
    <div class="row">
        <?php echo $form->labelEx($model,'place'); ?>
        <?php echo $form->textField($model,'place'); ?>
        <?php echo $form->error($model,'place'); ?>
    </div>

	<?php /* 
    <div class="row">
        <?php echo $form->labelEx($model,'street_address'); ?>
        <?php echo $form->textField($model,'street_address'); ?>
        <?php echo $form->error($model,'street_address'); ?>
    </div>
	*/?>
	
	<div class="row">
        <?php echo $form->labelEx($model,'city_id'); ?>
        <span class="field"><?php echo $form->dropDownList($model, 'city_id', City::GetCityNameLast()); ?></span>
        <?php echo $form->error($model,'city_id'); ?>
    </div>
   
   	<!--<span class="add_city_name" style="margin-left:539px;"><a href="javascript:;" id="add_optinal_city">+ Add Other</a></span>
    
    --><div class="row city_name_search" style="display:none;" id="city_name_field">
        <?php echo Yii::t("inx","Enter your postal/zip code to search your city") ?><br>
        <?php echo $form->textField($model,'city_name',array('style'=>'width:157px;float:left;')); ?>
        <?php echo $form->error($model,'city_name'); ?>
        <div style="float:left;">&nbsp;&nbsp;</div>
        <input type="button" id="find_city" value="Find City" class="clsfindcity" style="float:left;" />
        <div style="float:left;">&nbsp;&nbsp;</div>
        <img src="<?php echo Yii::app()->baseUrl.'/images/loading.star.gif';?>" alt="image" id="loading_image" style="display:none; width:20px; height:20px;"/>
    </div>
    
    <div class="row">
    	<label>&nbsp;</label>
    	<span class="addressta" style="display:none;"></span>
    	<input type="hidden" id="Customer_address" name="Business[p_address]" value="">
		<input type="hidden" id="Customer_town" name="Business[p_town]" value="">
		<input type="hidden" id="Customer_country" name="Business[p_country]" value="">
		<input type="hidden" id="Customer_lat" name="Business[p_lat]" value="">
		<input type="hidden" id="Customer_lng" name="Business[p_lng]" value=""><br />
    </div>
    
   	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<span class="field"><?php echo $form->dropDownlist($model,'country', array('Canada'=>'Canada','United States'=>'United States'),array('id'=>'country_code')); ?></span>
		<?php echo $form->error($model,'country'); ?>
	 </div>
   
   	<div class="row" >
        <span style="display:block" id="zipcode_value"><?php echo $form->labelEx($model,'business_zipcode1'); ?></span>
        <span style="display:none" id="postalcode_value"><?php echo $form->labelEx($model,'business_zipcode2'); ?></span>
         <?php echo $form->textField($model,'business_zipcode'); ?>
        <?php echo $form->error($model,'business_zipcode'); ?>
    </div>
   
    <div class="row fl" style="overflow:visible; float:left;">
        <?php echo $form->labelEx($model,'category_id'); ?>
        <span class="field"><?php echo $form->dropDownList($model, 'category_id', Categories::getAllCategory()); ?></span>
        <?php echo $form->error($model,'category_id'); ?>
    </div>

    <div class="row buttons b_sub" style="overflow:visible; clear:both; text-align:right;" id="submit">
        <?php echo CHtml::submitButton('Submit',array("class"=>"clear_button")); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</div>
<script src="<?php echo Yii::app()->baseUrl;?>/js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
		$(window).load(function() {
		   $("#Business_business_phone_number").mask("(999)9999999");
		});
		$("#Business_city_id").change(function () {
			var val = $(this).val();
			if(val == "Other"){
				$("#city_name_field").toggle();
			}
		});
		$("#country_code").change(function(){
	    	  var selectVal = $('#country_code :selected').val();
	    	  if(selectVal == 'Canada'){
	    		 $("#zipcode_value").css("display","block");
	    		 $("#postalcode_value").css("display","none");
	    	  }
	    	  if(selectVal == 'United States'){
	    		  $("#zipcode_value").css("display","none");
	     		  $("#postalcode_value").css("display","block"); 
	    	  }
	      });
		$('#find_city').live('click',function(){
			var zip_code = $("#Business_city_name").val();
			$("#Business_business_zipcode").val(zip_code);
			$("#loading_image").css("display","block");
			var Customer_postcode = $('#Business_city_name').val();
			var addressfrompostcodeurl = '<?php echo CController::CreateUrl('/customer/Business/addressfrompostcode'); ?>';
			$.ajax({
				  url: addressfrompostcodeurl,
				  type: 'GET',
				  data: 'Customer_postcode='+Customer_postcode+'&type=personal',
				  success: function(data) {
					//called when successful
					if($.trim(data) == ''){
						alert('Invalid post code.');
						$('#Business_city_name').focus();					
					}else{
						$('.addressta').html(data);
						$('.addressta').show();
						$("#loading_image").css("display","none");
					}								
				  },
				  error: function(e) {				 
					
				  }
			});
		});  

		$('#select_tradesman_address').live('click',function(){
			var val = this.value;
			var address_arr = val.split(', ');
			$('#Customer_address').val(address_arr[0]);
			$('#Customer_town').val(address_arr[1]);
			$('#Customer_country').val(address_arr[2]);
			$('#Customer_lat').val(address_arr[3]);
			$('#Customer_lng').val(address_arr[4]);
		});
		
	});
</script>