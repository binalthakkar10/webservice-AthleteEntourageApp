<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-detail-form',
	'enableAjaxValidation' => false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'user_type'); ?>
		<?php echo $form->dropdownList($model, 'user_type',array(0=>'Select',1=>'Athlete',2=>'Entourage')); ?>
		<?php echo $form->error($model,'user_type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'profile_image'); ?>
		<?php echo $form->fileField($model, 'profile_image', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'profile_image'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'display_name'); ?>
		<?php echo $form->textField($model, 'display_name', array('maxlength' => 25)); ?>
		<?php echo $form->error($model,'display_name'); ?>
		</div><!-- row -->
	<!--	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model, 'first_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'first_name'); ?>
		</div><!-- row -->
	<!--	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model, 'last_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'last_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, 'description', array('maxlength' => 1000)); ?>
		<?php echo $form->error($model,'description'); ?>
		</div><!-- row -->
		<div class="row">
	<!--<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'phone_number'); ?>
		<?php echo $form->textField($model, 'phone_number', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'phone_number'); ?>
		</div><!-- row -->
		<div class="row">
	<!--	<?php echo $form->labelEx($model,'oauth_provider'); ?>
		<?php echo $form->textField($model, 'oauth_provider', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'oauth_provider'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'oauth_uid'); ?>
		<?php echo $form->textField($model, 'oauth_uid', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'oauth_uid'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'device_id'); ?>
		<?php echo $form->textField($model, 'device_id', array('maxlength' => 500)); ?>
		<?php echo $form->error($model,'device_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'device_type'); ?>
		<?php echo $form->dropdownList($model, 'device_type',array(0=>'Select',1=>'Android',2=>'IOS')); ?>
		<?php echo $form->error($model,'device_type'); ?>
		</div><!-- row -->
		<div class="row">
		<!--<?php echo $form->labelEx($model,'push_score_change'); ?>
		<?php echo $form->checkBox($model, 'push_score_change'); ?>
		<?php echo $form->error($model,'push_score_change'); ?>
		</div><!-- row -->
	<!--	<div class="row">
		<?php echo $form->labelEx($model,'push_get_contacted'); ?>
		<?php echo $form->checkBox($model, 'push_get_contacted'); ?>
		<?php echo $form->error($model,'push_get_contacted'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'push_new_exchanges'); ?>
		<?php echo $form->checkBox($model, 'push_new_exchanges'); ?>
		<?php echo $form->error($model,'push_new_exchanges'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'push_new_athletes'); ?>
		<?php echo $form->checkBox($model, 'push_new_athletes'); ?>
		<?php echo $form->error($model,'push_new_athletes'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'impact_score'); ?>
		<?php echo $form->textField($model, 'impact_score'); ?>
		<?php echo $form->error($model,'impact_score'); ?>
		</div><!-- row -->
		<div class="row">
	<!--	<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
		</div><!-- row -->
	<!--	<div class="row">
		<?php echo $form->labelEx($model,'is_verified'); ?>
		<?php echo $form->checkBox($model, 'is_verified'); ?>
		<?php echo $form->error($model,'is_verified'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'is_featured'); ?>
		<?php echo $form->checkBox($model, 'is_featured'); ?>
		<?php echo $form->error($model,'is_featured'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'facebook_screen_name'); ?>
		<?php echo $form->textField($model, 'facebook_screen_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'facebook_screen_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'twitter_screen_name'); ?>
		<?php echo $form->textField($model, 'twitter_screen_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'twitter_screen_name'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->