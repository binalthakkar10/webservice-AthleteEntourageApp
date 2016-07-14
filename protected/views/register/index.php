
<?php 
// echo $this->renderPartial('/index/index');
 ?>
<div class="form form_main">
<div class="bg">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'action'=>'create',
	'clientOptions' => array(
		      'validateOnSubmit'=>true,
		      /*'validateOnChange'=>true,
		      'validateOnType'=>false,*/
          ),
)); ?>

<p class="note">Fields with <span class="required">*</span> are
required.</p>
<?php  echo $form->errorSummary($model); ?> 

<?php

	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="errorSummary">' . $message . "</div>\n";
	}

?>

		

<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'user_type'); ?> 
		<span class="field"><?php echo $form->dropDownList($model, 'user_type',array('advertiser'=>'Advertiser','retailer'=>'Retailer')); ?></span>
		<?php echo $form->error($model,'user_type'); ?>
	</div>
	
*/?>	
	<div class="row">
	<?php echo $form->labelEx($model,'username'); ?> 
	<?php echo $form->textField($model,'username',array('size'=>40,'maxlength'=>30)); ?>
	<?php echo $form->error($model,'username'); ?>
	</div>
	<?php 
	$password_bogo = '';
	if(isset($_POST['FrontRegisterValidationForm']['password']) && !empty($_POST['FrontRegisterValidationForm']['password']))
	{
		$password_bogo = $_POST['FrontRegisterValidationForm']['password'];
	}
	?>
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?> 
	<?php echo $form->passwordField($model,'password',array('size'=>40,'maxlength'=>150,'value'=>$password_bogo)); ?>
	<?php echo $form->error($model,'password'); ?>
	</div>


 
	<div class="row">
	<?php echo $form->labelEx($model,'firstname'); ?> 
	<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>30)); ?>
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
	<?php 
	$repeat_email = '';
	if(isset($_POST['FrontRegisterValidationForm']['repeat_email']) && !empty($_POST['FrontRegisterValidationForm']['repeat_email']))
	{
		$repeat_email = $_POST['FrontRegisterValidationForm']['repeat_email'];
	}
	?>
	<div class="row">
	<?php echo $form->labelEx($model,'repeat_email'); ?> 
	<?php echo $form->textField($model,'repeat_email',array('size'=>60,'maxlength'=>30,'value'=>$repeat_email)); ?>
	<?php echo $form->error($model,'repeat_email'); ?>
	</div>
	
	
	
<div class="agree_full">
	<div class="reg_checkbox">
			   <?php echo $form->checkBox($model, 'checkbox', array('size'=>1,'maxlength'=>1, 'value'=>'S', 'uncheckValue'=>'N')); ?>
	I agree to the 
			<span><a  target="_blank" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/static/terms" class="logo">Terms &amp; Conditions</a></span> 
			
			and the <span><a target="_blank" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/static/privacy">Privacy Policy</a></span>
	</div>

</div>

  <div class="row buttons b_sub">
        <?php echo CHtml::submitButton('Sign Up',array('class'=>'signup')); ?>
    </div>

<?php $this->endWidget(); ?>

</div>
</div>
<!-- form -->
