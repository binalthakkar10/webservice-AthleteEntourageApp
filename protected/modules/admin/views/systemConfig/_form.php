<?php Yii::app()->clientScript->registerScript(null,'$("#SystemConfig_system_section_id").focus();') ?>
<script>
$(document).ready(function(){
	$('#form-reset-button').click(function()
			{
			        $('#search-form form input, #search-form form select').each(function(i, o)
			        {
			                if (($(o).attr('type') != 'submit') && ($(o).attr('type') != 'reset')) $(o).val('');
			        });

			        $.fn.yiiGridView.update('system-config-form', {data: $('#search-form form').serialize()});

			        return false;
	});
});
</script>
<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'system-config-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php //echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'system_section_id'); ?>
		<?php echo $form->dropDownList($model, 'system_section_id',SystemSection::model()->findAllAttributes(null, true, 'status=1'),array('prompt'=>'Select Section ID')); ?>
		<?php echo $form->error($model,'system_section_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'system_group_id'); ?>
		<?php echo $form->dropDownList($model, 'system_group_id', SystemGroup::model()->findAllAttributes(null, true, 'status=1'),array('prompt'=>'Select Group ID')); ?>
		<?php echo $form->error($model,'system_group_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<h3><?php echo $form->textField($model, 'name', array('maxlength' => 30)); ?></h3>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textArea($model, 'value'); ?>
		<?php echo $form->error($model,'value'); ?>
		</div><!-- row -->
		<?php /* 
		<div class="row">
		<?php echo $form->labelEx($model,'input_type'); ?>
		<?php echo $form->textArea($model, 'input_type'); ?>
		<?php echo $form->error($model,'input_type'); ?>
		</div><!-- row -->
		
		<div class="row">
		<?php echo $form->labelEx($model,'input_options'); ?>
		<?php echo $form->textArea($model, 'input_options'); ?>
		<?php echo $form->error($model,'input_options'); ?>
		</div><!-- row -->
		*/ ?>
		<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model, 'position'); ?>
		<?php echo $form->error($model,'position'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', array('1'=>Yii::t('app','Active'),'0'=>Yii::t('app','Inactive'))); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save')); echo "&nbsp;&nbsp;";
echo GxHtml::resetButton(Yii::t('app', 'Reset'),array('id'=>'form-reset-button')); echo "&nbsp;&nbsp;"; ?>
<input type="button" name="yt2" onclick="javascript:window.location.href='<?php echo Yii::app()->baseUrl.'/admin/systemConfig/admin'?>'" value="Cancel" />
<?php  $this->endWidget(); ?>
</div><!-- form -->
