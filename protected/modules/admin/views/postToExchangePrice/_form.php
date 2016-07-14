<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'post-to-exchange-price-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'no_days'); ?>
		<?php echo $form->textField($model, 'no_days'); ?>
		<?php echo $form->error($model,'no_days'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model, 'price'); ?>
		<?php echo $form->error($model,'price'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropdownList($model, 'status',array(1=>'Active',0=>'Inactive')); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->