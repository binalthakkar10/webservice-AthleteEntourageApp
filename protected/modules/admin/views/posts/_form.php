<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'posts-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'post_text'); ?>
		<?php echo $form->textField($model, 'post_text', array('maxlength' => 5000)); ?>
		<?php echo $form->error($model,'post_text'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(UserDetail::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('postExchanges')); ?></label>
		<?php echo $form->checkBoxList($model, 'postExchanges', GxHtml::encodeEx(GxHtml::listDataEx(PostExchange::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->