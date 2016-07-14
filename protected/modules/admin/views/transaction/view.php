<?php

$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	//GxHtml::valueEx($model),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	//array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	//array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->transaction_id)),
	//array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->transaction_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
//'transaction_id',
array(
			'name' => 'user',
			'type' => 'raw',
			'value' =>UserDetail::getDisplayName($model->user_id),
			),
'email',
'twitter_screen_name',
'payment_gateway_id',
'amount',
/*array(
			'name' => 'campaign',
			'type' => 'raw',
			'value' => $model->campaign !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->campaign)), array('campaign/view', 'id' => GxActiveRecord::extractPkValue($model->campaign, true))) : null,
			),*/
			
			array(
				'name'=>'campaign_id',
				'value'=>Campaign::getCampaignmessage($model->campaign_id),
				//'filter'=>GxHtml::listDataEx(Campaign::model()->findAllAttributes(null, true)),
				),		
'created_date',
'payment_status:boolean',
	),
)); ?>

