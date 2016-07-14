<?php Yii::app()->clientScript->registerScript(null,'$("select#Users_user_type").focus();'); ?>
<script>
$(document).ready(function(){
	$("select#Users_user_type").change(function(){
		var id = this.value;
		if(id == 'vip'){
			$.ajax({
		        url: "<?php echo CController::createUrl('/admin/AdminUser/randomcode');?>",
		        type: "post",
		        data: {"code":id},
		        success: function(data){
		        	$("span#code_value").html(data);
		        	$("span#code_value").css({ 'color': 'red', 'font-size': '25px' });
		        	$("#Users_code").val(data);
		        },
		        error:function(){
		            $("#result").html('There is error while submit');
		        }
		    });
		}
		if(id == 'vip'){
			$("#code_display").css("display","block");
		}else{
			$("#code_display").css("display","none");
		}
	});
	$('#form-reset-button').click(function()
			{
			        $('#search-form form input, #search-form form select').each(function(i, o)
			        {
			                if (($(o).attr('type') != 'submit') && ($(o).attr('type') != 'reset')) $(o).val('');
			        });

			        $.fn.yiiGridView.update('user-form', {data: $('#search-form form').serialize()});

			        return false;
	});
});
</script>
<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
        'validateOnChange'=>true,
		'validateOnSubmit'=>true,
    )
));
?>
	
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php //echo $form->errorSummary($model); ?>
	
	<?php
	 
	
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    
		<div class="row">
		<?php echo $form->labelEx($model,'user_type'); ?>
		<?php echo $form->dropDownList($model,'user_type',array(''=>'Select Usertype','admin'=>'admin','user'=>'user','vip'=>'vip')); ?>
		<?php echo $form->error($model,'user_type'); ?>
		</div>
		<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>40,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'username'); ?>
		</div>
		<?php if($this->getAction()->id == 'create'):?>
		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('maxlength'=>20,'value'=>'')); ?>
			<?php echo $form->error($model,'password'); ?>
		<div> 
			<?php endif;?>
		<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>32,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'firstname'); ?>
		</div>
		<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>32,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'lastname'); ?>
		</div>
		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
		<div class="row">
	   <?php echo $form->labelEx($model,'is_active'); ?>
		 <?php //if(Yii::app()->admin->getId() == $model->id): ?>
			<?php //echo UtilityHtml::getStatusImageIcon($model->is_active); ?>
		<?php //else: ?>
			<?php echo $form->dropDownlist($model,'is_active', array('1'=>'Active','0'=>'InActive')); ?>
		<?php //endif;?>
		<?php echo $form->error($model,'is_active'); ?>
		</div>
		<div class="row" id="code_display" style="display:none;">
		<?php echo $form->labelEx($model,'code'); ?>
		<span id="code_value"></span>
		<?php echo $form->hiddenField($model,'code',array('size'=>60,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'code'); ?>
		</div>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save')); echo "&nbsp;&nbsp;"; 
echo GxHtml::resetButton(Yii::t('app', 'Reset'),array('id'=>'form-reset-button')); echo "&nbsp;&nbsp;"; ?>
<input type="button" name="yt2" onclick="javascript:window.location.href='<?php echo Yii::app()->baseUrl.'/admin/adminUser/admin'?>'" value="Cancel" />
<?php  $this->endWidget(); ?>
</div><!-- form -->
</div>