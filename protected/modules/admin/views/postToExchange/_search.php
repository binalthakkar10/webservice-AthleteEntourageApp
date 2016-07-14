<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<!--<div class="row">
		<?php echo $form->label($model, 'postexchange_id'); ?>
		<?php echo $form->textField($model, 'postexchange_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'user_id'); ?>
		<?php echo $form->textField($model, 'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'campaign_id'); ?>
		<?php echo $form->textField($model, 'campaign_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'user_type'); ?>
		<?php echo $form->textField($model, 'user_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'message'); ?>
		<?php echo $form->textField($model, 'message', array('maxlength' => 5000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- search-form -->
