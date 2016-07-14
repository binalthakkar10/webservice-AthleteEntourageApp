
<?php
if(!isset($type)){
 $this->renderPartial('/layouts/subheader');
}
 ?>
<div class="form form_main">
<div class="bg">

    
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'creditcard-information-_form-form',
    'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
     'clientOptions' => array(
		      'validateOnSubmit'=>true,
		      //'validateOnChange'=>true,
		      //'validateOnType'=>false,
          ),
     'stateful'=>false,
)); ?>

    <p class="note" style="color:#F05921;">Fields with <span class="required">*</span> are required.</p>
    <p>Friendly Reminder: Your credit card will NOT be charge until after your Free Trial expires. And you can cancel at any time during the Free Trial to not be charged.<p>

   <?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    <?php echo $form->errorSummary($model); ?>
	<div class="row">
        <?php echo $form->labelEx($model,'cardholder_name'); ?>
        <?php echo $form->textField($model,'cardholder_name'); ?>
        <?php echo $form->error($model,'cardholder_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'credit_card_no'); ?>
            <?php echo $form->textField($model,'credit_card_no'); ?>
        <?php echo $form->error($model,'credit_card_no'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'card_type'); ?>
       <span class="field"><?php echo $form->dropDownList($model, 'card_type', Creditcard::model()->getDefinedCardType()); ?></span>
        <?php echo $form->error($model,'card_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'expired_date'); ?>
       <?php 
		Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
		    	$this->widget('CJuiDateTimePicker',array(
		        'model'=>$model, //Model object
		        'attribute'=>'expired_date', //attribute name
		         'mode'=>'datetime',
		    	 'language' => '',
		        'options'=>array('dateFormat'=>SystemConfig::getValue('js_date_format'),'timeFormat'=>SystemConfig::getValue('js_time_format')) // jquery plugin options
    	));
   		 ?>
        <?php echo $form->error($model,'expired_date'); ?>
    </div>

	<?php /* 
    <div class="row">
        <?php echo $form->labelEx($model,'phone'); ?>
        <?php echo $form->textField($model,'phone',array("id"=>"credit_phone")); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>
    */?>
    
    <?php /*?>
    <div class="row">
        <?php echo $form->labelEx($model,'allow_deduction'); ?>
        <span class="field"><?php echo $form->dropDownlist($model,'allow_deduction', array('Y'=>'Yes','N'=>'No')); ?></span>
        <?php echo $form->error($model,'allow_deduction'); ?>
    </div>
    <?php */?>
    

<?php /*
    <div class="row">
        <?php echo $form->labelEx($model,'user_id'); ?>
        <?php echo $form->textField($model,'user_id'); ?>
        <?php echo $form->error($model,'user_id'); ?>
    </div>
    
   */?> 


     <div class="row buttons b_sub">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>
</div>
</div>
</div><!-- form -->	
<script src="<?php echo Yii::app()->baseUrl;?>/js/jquery.maskedinput.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
$(window).load(function() {
	   $("#credit_phone").mask("(999)9999999");
	});
});
</script>