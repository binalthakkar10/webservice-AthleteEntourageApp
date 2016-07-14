<?php 
if(isset($_SESSION['sess_business_id'])){ 
$id = $_SESSION['sess_business_id'];
$model = Business::model()->find('id = "'.$id.'"');
}
?>
<?php
if(!isset($type)){
 $this->renderPartial('/layouts/subheader');
}
 ?>
<div class="form form_main">
<?php if(Yii::app()->controller->id == 'index' && Yii::app()->controller->action->id == 'tab'):?>
	<div class="bg_business">
<?php else:?>
	<div class="bg">
<?php endif;?>
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
     
     <?php if(isset($model->business_image) && !empty($model->business_image)) { ?>
     <div class="row">
        <?php echo $form->labelEx($model,'Existing Image'); ?>
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/business/<?php echo $model->business_image; ?>">
        
    </div>
     <?php } ?>
    
    <div class="row">
        <?php echo $form->labelEx($model,'business_phone_number'); ?>
        <?php echo $form->textField($model,'business_phone_number'); ?>
        <?php echo $form->error($model,'business_phone_number'); ?>
    </div>
    
    <?php /*?>
     <div class="row">
        <?php echo $form->labelEx($model,'coupon_id'); ?>
       <span class="field"><?php echo $form->dropDownList($model,'coupon_id', CHtml::listData(Coupon::model()->findAll("user_id=$model->user_id"),'id','title')); ?></span>
        <?php echo $form->error($model,'coupon_id'); ?>
    <a href="javascript:;" style="padding:6px;" id="add" >Add Coupon</a></li>
    </div>
    <?php */ ?>
    
    
    
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
        <span class="field"><?php echo $form->dropDownList($model, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true))); ?></span>
        <?php echo $form->error($model,'city_id'); ?>
    </div>
    
    <?php /* 
    <span class="add_city_name" style="margin-left:539px;"><a href="javascript:;" id="add_optinal_city">+ Add Other</a></span>
    
    <div class="row" style="display:none;" id="city_name_field">
        <?php echo $form->labelEx($model,'city_name'); ?>
        <?php echo $form->textField($model,'city_name'); ?>
        <?php echo $form->error($model,'city_name'); ?>
    </div>
    */?>
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
   
    <?php /*?>
    <div class="row">
        <?php echo $form->labelEx($model,'latitude'); ?>
        <?php echo $form->textField($model,'latitude'); ?>
        <?php echo $form->error($model,'latitude'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'longitude'); ?>
        <?php echo $form->textField($model,'longitude'); ?>
        <?php echo $form->error($model,'longitude'); ?>
    </div>
    */?>

    <div class="row fl" style="overflow:visible; float:left;">
        <?php echo $form->labelEx($model,'category_id'); ?>
        <span class="field"><?php echo $form->dropDownList($model, 'category_id', Categories::getAllCategory()); ?></span>
        <?php echo $form->error($model,'category_id'); ?>
    </div>
   
   

    <div class="row buttons b_sub" style="overflow:visible;" id="submit">
        <?php echo CHtml::submitButton('Submit'); ?>
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
	  $("#tabs").tabs();

	  $('#add').click(function() {
		  var $tabs = $("#tabs").tabs({event: 'click'}); 
		  $tabs.tabs("select", 1);
		  $("#tabs").tabs({disabled: [0,2]});
          //return false;
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
      $("#add_optinal_city").click(function(){
    	  $("#city_name_field").toggle();
      });
	   
	});
</script>
