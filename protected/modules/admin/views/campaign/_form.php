<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'campaign-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'compaign_message'); ?>
		<?php echo $form->textField($model, 'compaign_message', array('maxlength' => 1000)); ?>
		<?php echo $form->error($model,'compaign_message'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'post_to_exchange'); ?>
		<?php echo $form->checkBox($model, 'post_to_exchange'); ?>
		<?php echo $form->error($model,'post_to_exchange'); ?>
		</div><!-- row -->
		<!--<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'total_cost'); ?>
		<?php echo $form->textField($model, 'total_cost'); ?>
		<?php echo $form->error($model,'total_cost'); ?>
		</div><!-- row -->

		

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->