<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'post-to-exchange-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<!--<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model, 'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
	<!--	<div class="row">
		<?php echo $form->labelEx($model,'campaign_id'); ?>
		<?php echo $form->textField($model, 'campaign_id'); ?>
		<?php echo $form->error($model,'campaign_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user_type'); ?>
		<?php echo $form->dropdownList($model, 'user_type',array(1=>'Athlete',2=>'Entourage')); ?>
		<?php echo $form->error($model,'user_type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textField($model, 'message', array('maxlength' => 5000)); ?>
		<?php echo $form->error($model,'message'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->