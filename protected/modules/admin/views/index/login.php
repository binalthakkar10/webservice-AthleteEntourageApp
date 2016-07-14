<script>
$(document).ready(function(){
	setTimeout(function(){ $(".flash-error").hide(); },3000);
});
</script>
<?php
$this->pageTitle=Yii::app()->name . ' - Login';
/*$this->breadcrumbs=array(
	'Login',
);*/
?>
<!-- <div class="repairersreg"><h1><a href="Repairersreg/create"> Repairer Registration </a></h1></div> -->
<div class="login_box">

<h1>Login</h1>
<div class="form">
<!--<p>Please fill out the following form with your login credentials:</p>-->
		


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
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
	<?php
	    foreach(Yii::app()->admin->getFlashes() as $key => $message) {
	        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	    }
	?>
	<?php Yii::app()->clientScript->registerScript(null,'$("#AdminLoginForm_username").focus();') ?>
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			
		</p>
	</div>

	<?php /* ?>
	<div class="row rememberMe">
    	<div class="remember-me-div fl">
				<?php echo $form->checkBox($model,'rememberMe'); ?>
                <?php echo $form->label($model,'rememberMe'); ?>
                <?php echo $form->error($model,'rememberMe'); ?>
        </div>
       <div class="forgot-password-div fl"> 
        <a href="Site/forgot"> Forgot Password? </a>
        </div>
		
	</div>
	<?php */ ?>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	 

<?php $this->endWidget(); ?>
</div><!-- form -->

</div>