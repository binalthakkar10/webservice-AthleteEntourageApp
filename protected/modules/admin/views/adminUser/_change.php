<script>
$(document).ready(function(){
	$('#form-reset-button').click(function()
			{
			        $('#search-form form input, #search-form form select').each(function(i, o)
			        {
			                if (($(o).attr('type') != 'submit') && ($(o).attr('type') != 'reset')) $(o).val('');
			        });

			        $.fn.yiiGridView.update('pwd-form', {data: $('#search-form form').serialize()});

			        return false;
	});
});
</script>
<div class="form">

<?php $form=$this->beginWidget('GxActiveForm', array(
	'id'=>'pwd-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
        'validateOnChange'=>true,
		'validateOnSubmit'=>true,
    )
)); ?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php //echo $form->errorSummary($model, Yii::t('app','Please fix the following input errors:')); ?>
	<div class="row">
			<?php echo $form->labelEx($model,'oldpassword'); ?>
			<?php echo $form->passwordField($model,'oldpassword',array('size'=>40,'maxlength'=>40)); ?>
			<?php echo $form->error($model,'oldpassword'); ?>
	</div>
	<?php
	    	foreach(Yii::app()->admin->getFlashes() as $key => $message) {
	       	 	echo '<div class="error_event" style="color:red; margin-left:171px;">' . $message . "</div>\n";
	    	}
	?>
	
	<div class="row">
	<?php ?>
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>40,'maxlength'=>40)); ?>
			<?php echo $form->error($model,'password'); ?>
			
	</div>
	
	<div class="row">
	<?php ?>
			<?php echo $form->labelEx($model,'password_repeat'); ?>
			<?php echo $form->passwordField($model,'password_repeat',array('size'=>40,'maxlength'=>40)); ?>
			<?php echo $form->error($model,'password_repeat'); ?>
			
	</div>
	
<div class="row buttons">
	
<?php echo CHtml::submitButton(Yii::t('app','Change Password')); echo "&nbsp;&nbsp;";
echo GxHtml::resetButton(Yii::t('app', 'Reset'),array('id'=>'form-reset-button')); echo "&nbsp;&nbsp;"; ?>
<input type="button" name="yt2" onclick="javascript:window.location.href='<?php echo Yii::app()->baseUrl.'/admin/adminUser/setting'?>'" value="Cancel" />
<?php  $this->endWidget(); ?> 
</div>
</div><!-- form -->