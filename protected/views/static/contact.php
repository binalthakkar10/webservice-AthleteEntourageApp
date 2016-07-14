
<div class="form form_main">
<div class="bg">
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'contactus-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    
    <?php
 

	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}
?>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'message'); ?>
        <?php echo $form->textArea($model,'message'); ?>
        <?php echo $form->error($model,'message'); ?>
    </div>


<?php /*
    <div class="row">
        <?php echo $form->labelEx($model,'send_date'); ?>
        <?
		$this->widget('application.extensions.jui.EDatePicker',
		              array(
		                    'name'=>'send_date',
		                    'language'=>'no',
		                    'mode'=>'focus',
		                    'fontSize'=>'0.8em',
		                    'htmlOptions'=>array('size'=>30,'class'=>'date'),
		                   )
		             );
?>
        <?php echo $form->error($model,'send_date'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'staus'); ?>
        <?php echo $form->textField($model,'staus'); ?>
        <?php echo $form->error($model,'staus'); ?>
    </div>
    */?>


    <div class="row buttons b_sub">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>
</div>
</div>
</div><!-- form -->