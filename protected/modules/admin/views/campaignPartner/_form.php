<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'campaign-partner-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'campaign_id'); ?>
		<?php echo $form->textField($model, 'campaign_id'); ?>
		<?php echo $form->error($model,'campaign_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'twitter_screen_name'); ?>
		<?php echo $form->textField($model, 'twitter_screen_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'twitter_screen_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'is_member'); ?>
		<?php echo $form->checkBox($model, 'is_member'); ?>
		<?php echo $form->error($model,'is_member'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'is_verified'); ?>
		<?php echo $form->checkBox($model, 'is_verified'); ?>
		<?php echo $form->error($model,'is_verified'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'impact_score'); ?>
		<?php echo $form->textField($model, 'impact_score'); ?>
		<?php echo $form->error($model,'impact_score'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model, 'price'); ?>
		<?php echo $form->error($model,'price'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'reach'); ?>
		<?php echo $form->textField($model, 'reach'); ?>
		<?php echo $form->error($model,'reach'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'fb_post_id'); ?>
		<?php echo $form->textField($model, 'fb_post_id', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'fb_post_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'twitter_post_id'); ?>
		<?php echo $form->textField($model, 'twitter_post_id', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'twitter_post_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'fb_reach'); ?>
		<?php echo $form->textField($model, 'fb_reach', array('maxlength' => 15)); ?>
		<?php echo $form->error($model,'fb_reach'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'twitter_reach'); ?>
		<?php echo $form->textField($model, 'twitter_reach', array('maxlength' => 15)); ?>
		<?php echo $form->error($model,'twitter_reach'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->