<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<!--<div class="row">
		<?php echo $form->label($model, 'post_id'); ?>
		<?php echo $form->textField($model, 'post_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'post_text'); ?>
		<?php echo $form->textField($model, 'post_text', array('maxlength' => 5000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(UserDetail::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
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
