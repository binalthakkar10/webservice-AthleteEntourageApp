<?php

$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	//GxHtml::valueEx($model),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	//array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	//array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->postexchange_id)),
	//array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->postexchange_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
	
	
	array(
                'label'=>'User Type', //column header
                'type'=>'html',
               'value'=>UserDetail::getUsertype($model->user_type), //column name, php expression
                //  'value'=>'$data->campaignPartners->twitter_screen_name', //column name, php expression
            ),
	
	array(
                'label'=>'Display Name', //column header
                'type'=>'html',
               'value'=>UserDetail::getDisplayName($model->user_id), //column name, php expression  
            ),	
	
array(
                'label'=>'Campaign Message', //column header
                'type'=>'html',
               'value'=>Campaign::getCampaignmessage($model->campaign_id), //column name, php expression
                //  'value'=>'$data->campaignPartners->twitter_screen_name', //column name, php expression
            ),
'message',
'created_date',
	),
)); ?>

