<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'package-price-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'package_name'); ?>
		<?php echo $form->textField($model, 'package_name', array('maxlength' => 50,'disabled'=>true)); ?>
		<?php echo $form->error($model,'package_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'package_price'); ?>
		<?php echo $form->textField($model, 'package_price'); ?>
		<?php echo $form->error($model,'package_price'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->