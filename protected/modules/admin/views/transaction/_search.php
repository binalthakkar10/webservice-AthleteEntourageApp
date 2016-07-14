<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<!--<div class="row">
		<?php echo $form->label($model, 'transaction_id'); ?>
		<?php echo $form->textField($model, 'transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(UserDetail::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'twitter_screen_name'); ?>
		<?php echo $form->textField($model, 'twitter_screen_name', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'payment_gateway_id'); ?>
		<?php echo $form->textField($model, 'payment_gateway_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'amount'); ?>
		<?php echo $form->textField($model, 'amount', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'campaign_id'); ?>
		<?php echo $form->dropDownList($model, 'campaign_id', GxHtml::listDataEx(Campaign::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'payment_status'); ?>
		<?php echo $form->dropDownList($model, 'payment_status', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- search-form -->
