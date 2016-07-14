<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<!--<div class="row">
		<?php echo $form->label($model, 'package_id'); ?>
		<?php echo $form->textField($model, 'package_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'package_name'); ?>
		<?php echo $form->textField($model, 'package_name', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'package_price'); ?>
		<?php echo $form->textField($model, 'package_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- search-form -->
