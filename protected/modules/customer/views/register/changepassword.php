
<?php 
 $this->renderPartial('/layouts/subheader');
 ?>
<div class="form form_main">
<div class="bg">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pwd-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
     'clientOptions' => array(
		      'validateOnSubmit'=>true,
		      //'validateOnChange'=>true,
		      //'validateOnType'=>false,
          ),
)); ?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>


	
   <?php
	 
	
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
	<?php echo $form->errorSummary($model, Yii::t('app','Please fix the following input errors:')); ?>
	
	<div class="row">
	
			<?php echo $form->labelEx($model,'oldpassword'); ?>
			<?php echo $form->passwordField($model,'oldpassword',array('size'=>40,'maxlength'=>40,'value'=>'')); ?>
			<?php echo $form->error($model,'oldpassword'); ?>
			
	</div>
	<div class="row">
	
			<?php echo $form->labelEx($model,'new_password'); ?>
			<?php echo $form->passwordField($model,'new_password',array('size'=>40,'maxlength'=>40,'value'=>'')); ?>
			<?php echo $form->error($model,'new_password'); ?>
			
	</div>
	
	<div class="row">
	
			<?php echo $form->labelEx($model,'password_repeat'); ?>
			<?php echo $form->passwordField($model,'password_repeat',array('size'=>40,'maxlength'=>40,'value'=>'')); ?>
			<?php echo $form->error($model,'password_repeat'); ?>
			
	</div>
	
  <div class="row buttons b_sub">
		<?php echo CHtml::submitButton(Yii::t('app','Change Password')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</div>