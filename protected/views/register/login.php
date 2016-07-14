<div class="form form_main red_spa">
<div class="bg">
<?php
$this->pageTitle=Yii::app()->name . ' - Login';
/*$this->breadcrumbs=array(
	'Login',
);*/
?>
<!-- <div class="repairersreg"><h1><a href="Repairersreg/create"> Repairer Registration </a></h1></div> -->
<div class="login_box">


<div class="form">
<!--<p>Please fill out the following form with your login credentials:</p>-->
		


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action'=>'login',
	'enableAjaxValidation'=>false,
 	'enableClientValidation'=>true,
     'clientOptions' => array(
		      'validateOnSubmit'=>true,
		      //'validateOnChange'=>true,
		      //'validateOnType'=>false,
          ),
)); ?>
	
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>
	<?php echo $form->errorSummary($model); ?>
	<?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' login_wrong_password">' . $message . "</div>\n";
    }
    ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			
		</p>
	</div>

	<div class="row rememberMe">
    
    	
	</div>


	
	<div class="row buttons b_sub" >
		<a href="<?php echo CController::createUrl("/register/forgor_password");?>" id="forgot_password" style="margin-left:430px; font-weight:bold; color:#F05921;">Forgot Password?</a>
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	 

<?php $this->endWidget(); ?>
</div><!-- form -->

</div>
</div>
</div>
<script>
<?
		$this->widget('application.extensions.fancybox.EFancyBox', array(
		        'target'=>'a#forgot_password',
		        'config'=>array(),));  
?>  
</script>