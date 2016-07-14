<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'sponser-form',
	'enableAjaxValidation' => false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
        'validateOnChange'=>true,
		'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model, 'username'); ?>
		<?php echo $form->error($model,'username'); ?>
		</div><!-- row -->
		<?php if($model->isNewRecord!='1'){ ?>
		<div class="row">	      	
		<?php echo CHtml::activeLabel($model,'iphone_image',array('required' => true));?>
		<?php echo $form->fileField($model, 'iphone_image', array('maxlength' => 100)); ?>
		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/upload/Sponser/iPhone/'.$model->iphone_image,"image",array("width"=>80)); ?>
		<span style="color:red;"><b>(image size should be  640 X 312)</b></span>
		<?php echo $form->error($model,'iphone_image'); ?>
		</div><!-- row -->
		<?php }else{ ?>
		<div class="row">
		<?php echo CHtml::activeLabel($model,'iphone_image',array('required' => true));?>
		<?php echo $form->fileField($model, 'iphone_image', array('maxlength' => 100)); ?>
		<span style="color:red;"><b>(image size should be  640 X 312)</b></span>
		<?php echo $form->error($model,'iphone_image'); ?>	
		</div><!-- row -->
		<?php }?>
<!---- Ipad---->	
		<?php if($model->isNewRecord!='1'){ ?>	
		<div class="row">
		<?php echo CHtml::activeLabel($model,'ipad_image',array('required' => true)); ?>
		<?php echo $form->fileField($model, 'ipad_image', array('maxlength' => 100)); ?>
		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/upload/Sponser/iPad/'.$model->iphone_image,"image",array("width"=>80)); ?>
		<span style="color:red;"><b>(image size should be  1536 X 552)</b></span>
		<?php echo $form->error($model,'ipad_image'); ?>
		</div><!-- row -->
		<?php }else{ ?>
		<div class="row">
		<?php echo CHtml::activeLabel($model,'ipad_image',array('required' => true));?>
		<?php echo $form->fileField($model, 'ipad_image', array('maxlength' => 100)); ?>
		<span style="color:red;"><b>(image size should be  1536 X 552)</b></span>
		<?php echo $form->error($model,'ipad_image'); ?>	
		</div><!-- row -->
		<?php }?>
		<div class="row">
		<?php echo CHtml::activeLabel($model,'facebook_screen_name', array('required' => true)); ?>
		<?php echo $form->textField($model, 'fb_screen_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'fb_screen_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'twitter_screen_name'); ?>
		<?php echo $form->textField($model, 'twitter_screen_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'twitter_screen_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo CHtml::activeLabel($model,'total_tweet', array('required' => true)); ?>
		<?php echo $form->textField($model, 'total_twitt'); ?>
		<?php echo $form->error($model,'total_twitt'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo CHtml::activeLabel($model,'total_retweet', array('required' => true)); ?>
		<?php echo $form->textField($model, 'total_retwitt'); ?>
		<?php echo $form->error($model,'total_retwitt'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo CHtml::activeLabel($model,'facebook_likes', array('required' => true)); ?>
		<?php echo $form->textField($model, 'fb_likes'); ?>
		<?php echo $form->error($model,'fb_likes'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo CHtml::activeLabel($model,'facebook_friends', array('required' => true)); ?>
		<?php echo $form->textField($model, 'fb_friends'); ?>
		<?php echo $form->error($model,'fb_friends'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'facebook_followers'); ?>
		<?php echo $form->textField($model, 'facebook_followers'); ?>
		<?php echo $form->error($model,'facebook_followers'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'twitter_followers'); ?>
		<?php echo $form->textField($model, 'twitter_followers'); ?>
		<?php echo $form->error($model,'twitter_followers'); ?>
		</div><!-- row -->
	<!--	<div class="row">
		<?php echo $form->labelEx($model,'impact_score'); ?>
		<?php echo $form->textField($model, 'impact_score'); ?>
		<?php echo $form->error($model,'impact_score'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'team'); ?>
		<?php echo $form->textField($model, 'team', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'team'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model, 'position', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'position'); ?>
		</div><!-- row -->
	<!--	<div class="row">
		<?php echo $form->labelEx($model,'flag'); ?>
		<?php echo $form->checkBox($model, 'flag'); ?>
		<?php echo $form->error($model,'flag'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->