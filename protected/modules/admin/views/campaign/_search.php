 <div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

<!--	<div class="row">
		<?php echo $form->label($model, 'campaign_id'); ?>
		<?php echo $form->textField($model, 'campaign_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'compaign_message'); ?>
		<?php echo $form->textField($model, 'compaign_message', array('maxlength' => 1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'post_to_exchange'); ?>
		<?php echo $form->dropDownList($model, 'post_to_exchange', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'total_cost'); ?>
		<?php echo $form->textField($model, 'total_cost'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- search-form -->
