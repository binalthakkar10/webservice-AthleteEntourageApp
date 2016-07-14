<?php $height = SystemConfig::getValue('coupon_height');?>
<?php $width = SystemConfig::getValue('coupon_width');?>
<?php
if(!isset($type)){ 
	$this->renderPartial('/layouts/subheader');
}
 ?>
<div class="form form_main">
<div class="bg">
    
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'coupon-form',
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
    
    <?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    
    
    <?php echo $form->hiddenField($model,'id');?>

    <?php echo $form->errorSummary($model); ?>


	 
	
    <div class="row fl" style="overflow:visible; position: relative;">
        <?php echo $form->labelEx($model,'deal_title'); ?>
        <a href="#" class="deal_business_image"><span class="deal_business_image" style="left:67px; position:absolute; top:3px;"><img src="<?php echo Yii::app()->baseUrl;?>/images/icon_help.png" alt="business"></span>
         <div class="tl_tip_popup">
	                  <div class="tl_tip_popupt"> <img  src="<?php echo Yii::app()->baseUrl.'/images/tl_tip_popup_t.png'?>" /></div>
	                   	 <div class="tl_tip_popupm_deal">
	                   	 	  <span><b>This is the written explanation of your ad So if you have a Buy 1 Latte Get 1 Latte Free, put exactly that!  Make it short, and make it enticing!</b></span> 
	                     </div>
	                  <div class="tl_tip_popupb"> <img  src="<?php echo Yii::app()->baseUrl.'/images/tl_tip_popup_b.png'?>" /></div>                  
	        </div>         </a>
        <?php echo $form->textField($model,'deal_title'); ?>
        <?php echo $form->error($model,'deal_title'); ?>
    </div>
	 
	<div class="row" style="overflow:visible; position: relative;">
        <?php echo $form->labelEx($model,'the_fine_print'); ?>
         <a href="#" class="question_image"><span class="business_image" style="left:99px; position:absolute; top:3px;"><img src="<?php echo Yii::app()->baseUrl;?>/images/icon_help.png" alt="business"></span>
         <div class="tl_tip_popup">
	                  <div class="tl_tip_popupt"> <img  src="<?php echo Yii::app()->baseUrl.'/images/tl_tip_popup_t.png'?>" /></div>
	                   	 <div class="tl_tip_popupm_fine">
	                   	 	  <span><b>Here's where you can add some fine print about your coupon.  We suggest you make it as limitless as possible since, of course, the goal is to increase foot traffic. Some popular options are: Expiry Date, Limited 1 use per customer per day, any legalese or anything else you want to add.</b></span> 
	                     </div>
	                  <div class="tl_tip_popupb"> <img  src="<?php echo Yii::app()->baseUrl.'/images/tl_tip_popup_b.png'?>" /></div>                  
	        </div>         </a>
        <?php echo $form->textField($model,'the_fine_print'); ?>
        <?php echo $form->error($model,'the_fine_print'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'start_date'); ?>
        <?php 
		Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
		    	$this->widget('CJuiDateTimePicker',array(
		        'model'=>$model, //Model object
		        'attribute'=>'start_date', //attribute name
		         'mode'=>'datetime',
		    	 'language' => '',
		        'options'=>array('dateFormat'=>SystemConfig::getValue('js_date_format'),'timeFormat'=>SystemConfig::getValue('js_time_format')) // jquery plugin options
    	));
   		 ?>
        <?php echo $form->error($model,'start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'expiry_date'); ?>
        <?php 
		Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
		    	$this->widget('CJuiDateTimePicker',array(
		        'model'=>$model, //Model object
		        'attribute'=>'expiry_date', //attribute name
		         'mode'=>'datetime',
		    	 'language' => '',
		        'options'=>array('dateFormat'=>SystemConfig::getValue('js_date_format'),'timeFormat'=>SystemConfig::getValue('js_time_format')) // jquery plugin options
    	));
   		 ?>
        <?php echo $form->error($model,'expiry_date'); ?>
    </div>

    
    
    <?php /*
    <div class="row">
        <?php echo $form->labelEx($model,'user_id'); ?>
    <?php echo $form->dropDownList($model, 'user_id', Users::model()->Showusernamedd()); ?>
        <?php echo $form->error($model,'user_id'); ?>
    </div>
    */?>
    
    
	 <div class="row">
	        <?php echo $form->labelEx($model,'image_url'); ?>
	        <?php echo $form->textField($model,'image_url'); ?>
	        <?php echo $form->error($model,'image_url'); ?>
	  </div>
	  
	  OR
	    
    <div class="row">
        <?php echo $form->labelEx($model,'image',array('style'=>'line-height:33px')); ?>
        <?php echo $form->FileField($model,'image'); ?>
        <br>
        <span class="image_business_image">
        <?php echo Yii::t('inx', '(Image Size:- 320px(Width)* 436px(Height))');?>
        </span>
        <?php echo $form->error($model,'image'); ?>
    </div>
    
    <?php 
		
		if($this->getAction()->id == 'update'){
			    $baseUrl = Yii::app()->baseUrl;
			    $img = $baseUrl.'/upload/coupon/'.$model->image;
			    $img1 = $baseUrl.'/upload/coupon/images.jpg';
			    if($img!='' && file_exists(Yii::app()->request->baseUrl.'/upload/coupon/').$img) {
				echo CHtml::image($img,'',array("height"=>$height,"width"=>$width)); 
				}else {
				echo CHtml::image($img1,'',array("height"=>$height,"width"=>$width));
				}
		}
		?>

   

<?php /*
    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description'); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->textField($model,'status'); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
*/?>

     <div class="row buttons b_sub">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</div>