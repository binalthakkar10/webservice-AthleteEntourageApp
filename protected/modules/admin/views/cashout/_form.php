<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cashout-form',
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
		<?php echo $form->labelEx($model,'amount_to_cashout'); ?>
		<?php echo $form->textField($model, 'amount_to_cashout'); ?>
		<?php echo $form->error($model,'amount_to_cashout'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'acc_no'); ?>
		<?php echo $form->textField($model, 'acc_no'); ?>
		<?php echo $form->error($model,'acc_no'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name_on_acc'); ?>
		<?php echo $form->textField($model, 'name_on_acc'); ?>
		<?php echo $form->error($model,'name_on_acc'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'bank_swift_id'); ?>
		<?php echo $form->textField($model, 'bank_swift_id'); ?>
		<?php echo $form->error($model,'bank_swift_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'bank_name'); ?>
		<?php echo $form->textField($model, 'bank_name'); ?>
		<?php echo $form->error($model,'bank_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'bank_address'); ?>
		<?php echo $form->textField($model, 'bank_address'); ?>
		<?php echo $form->error($model,'bank_address'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'is_verified'); ?>
		<?php echo $form->dropdownList($model, 'is_verified',array(0=>'No',1=>'Yes')); ?>
		<?php echo $form->error($model,'is_verified'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'updated_date'); ?>
		<?php echo $form->textField($model, 'updated_date'); ?>
		<?php echo $form->error($model,'updated_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model, 'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->