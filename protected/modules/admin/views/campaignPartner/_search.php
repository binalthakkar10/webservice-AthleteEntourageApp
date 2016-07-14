<script>
$( document ).ready(function() {
	$('#CampaignPartner_twitter_screen_name').change(function(){
	var userId=	$(this).val();
	var dataString = 'uid='+ userId;
		$.ajax
		({
		type: "POST",
		url: "<?php echo Yii::app()->getBaseUrl(true);?>/admin/Campaign/GetId",
		data: dataString,
		cache: false,
		success: function(data)
		{
			$("#CampaignPartner_campaign_id").html(data);
		}
		});
			});
	 $('#CampaignPartner_campaign_id').change(function(){
	 var a=	$("#CampaignPartner_campaign_id").val();
	 $.ajax
		({
		type: "POST",
		url: "<?php echo Yii::app()->getBaseUrl(true);?>/admin/CampaignPartner/Admin",
		data: {'campaign_id':a},
		success: function(data)
		{
			$("#campaign-partner-grid").html(data);
		}
		});
 
 });	
				
			
});
</script>

<div class="form-actions">
								<a  type="button" class="btn btn-primary" href="<?php echo Yii::app()->baseUrl.'/admin/CampaignPartner/index'; ?>">Hire</a>
							  </div>
<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>
<?php $campaignPartner = new CampaignPartner(); ?>
<div class="row">
		<?php echo $form->label($campaignPartner, 'Entourage'); ?>
		<?php echo $form->dropDownList($campaignPartner, 'twitter_screen_name',Campaign::getCampaignData(),array('empty'=>'Select Entourage')); ?>
	</div>
	<div class="row">
		<?php echo $form->label($campaignPartner, 'Campaign Message'); ?>
		<?php echo $form->dropDownList($campaignPartner, 'campaign_id'); ?>
	</div>
	<!--<div class="row">
		<?php echo $form->label($model, 'Campaign'); ?>
		<?php
		   $data = CHtml::listData(Campaign::model()->findAll(), "campaign_id", "compaign_message");
		 echo $form->dropDownList($model, 'campaign_id',$data); ?>
	</div>-->

	<!--<div class="row">
		<?php echo $form->label($model, 'twitter_screen_name'); ?>
		<?php echo $form->textField($model, 'twitter_screen_name', array('maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_member'); ?>
		<?php echo $form->dropDownList($model, 'is_member', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_verified'); ?>
		<?php echo $form->dropDownList($model, 'is_verified', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>-->

	<!--<div class="row">
		<?php echo $form->label($model, 'impact_score'); ?>
		<?php echo $form->textField($model, 'impact_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'price'); ?>
		<?php echo $form->textField($model, 'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'reach'); ?>
		<?php echo $form->textField($model, 'reach'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'fb_post_id'); ?>
		<?php echo $form->textField($model, 'fb_post_id', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'twitter_post_id'); ?>
		<?php echo $form->textField($model, 'twitter_post_id', array('maxlength' => 250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'fb_reach'); ?>
		<?php echo $form->textField($model, 'fb_reach', array('maxlength' => 15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'twitter_reach'); ?>
		<?php echo $form->textField($model, 'twitter_reach', array('maxlength' => 15)); ?>
	</div>-->

	<!--<div class="row buttons">
		<?php echo GxHtml::Button(Yii::t('app', 'Search')); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- search-form -->
