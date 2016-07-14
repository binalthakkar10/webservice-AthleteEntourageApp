<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

<!--	<div class="row">
		<?php echo $form->label($model, 'user_id'); ?>
		<?php echo $form->textField($model, 'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'user_type'); ?>
		<?php echo $form->textField($model, 'user_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'profile_image'); ?>
		<?php echo $form->textField($model, 'profile_image', array('maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'display_name'); ?>
		<?php echo $form->textField($model, 'display_name', array('maxlength' => 25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'first_name'); ?>
		<?php echo $form->textField($model, 'first_name', array('maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'last_name'); ?>
		<?php echo $form->textField($model, 'last_name', array('maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'description'); ?>
		<?php echo $form->textField($model, 'description', array('maxlength' => 1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'phone_number'); ?>
		<?php echo $form->textField($model, 'phone_number', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'oauth_provider'); ?>
		<?php echo $form->textField($model, 'oauth_provider', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'oauth_uid'); ?>
		<?php echo $form->textField($model, 'oauth_uid', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'device_id'); ?>
		<?php echo $form->textField($model, 'device_id', array('maxlength' => 500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'device_type'); ?>
		<?php echo $form->textField($model, 'device_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'push_score_change'); ?>
		<?php echo $form->dropDownList($model, 'push_score_change', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'push_get_contacted'); ?>
		<?php echo $form->dropDownList($model, 'push_get_contacted', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'push_new_exchanges'); ?>
		<?php echo $form->dropDownList($model, 'push_new_exchanges', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'push_new_athletes'); ?>
		<?php echo $form->dropDownList($model, 'push_new_athletes', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'impact_score'); ?>
		<?php echo $form->textField($model, 'impact_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_verified'); ?>
		<?php echo $form->dropDownList($model, 'is_verified', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_featured'); ?>
		<?php echo $form->dropDownList($model, 'is_featured', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'facebook_screen_name'); ?>
		<?php echo $form->textField($model, 'facebook_screen_name', array('maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'twitter_screen_name'); ?>
		<?php echo $form->textField($model, 'twitter_screen_name', array('maxlength' => 100)); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- search-form -->
