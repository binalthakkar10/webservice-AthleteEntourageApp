<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'transaction-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(UserDetail::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'twitter_screen_name'); ?>
		<?php echo $form->textField($model, 'twitter_screen_name', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'twitter_screen_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'payment_gateway_id'); ?>
		<?php echo $form->textField($model, 'payment_gateway_id'); ?>
		<?php echo $form->error($model,'payment_gateway_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model, 'amount', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'amount'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'campaign_id'); ?>
		<?php echo $form->dropDownList($model, 'campaign_id', GxHtml::listDataEx(Campaign::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'campaign_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'payment_status'); ?>
		<?php echo $form->checkBox($model, 'payment_status'); ?>
		<?php echo $form->error($model,'payment_status'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->