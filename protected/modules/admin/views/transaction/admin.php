<?php

$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	//Yii::t('app', 'Manage'),
);

$this->menu = array(
		//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		//array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'transaction-grid',
	'dataProvider' => $model->search(),
	//'filter' => $model,
	'columns' => array(
		//	'transaction_id',
		array(
				'name'=>'user_id',
			//	'value'=>'GxHtml::valueEx($data->user)',
				'value'=>'UserDetail::getDisplayName($data->user_id)',
				//'filter'=>GxHtml::listDataEx(UserDetail::getDisplayName($data->user_id)),
				),
		'email',
		'twitter_screen_name',
		'payment_gateway_id',
		//'amount',
		 array(
		 	'header'=>'Amount($)',
            'name'=>'amount',
            'value'=>'$data->amount/100',
           // 'value'=>'$data->amount/100.\' \'.$b',
       
            
        ),
		
		array(
				'name'=>'campaign_id',
				'value'=>'Campaign::getCampaignmessage($data->campaign_id)',
				//'filter'=>GxHtml::listDataEx(Campaign::model()->findAllAttributes(null, true)),
				),
		'created_date',
		array(
					'name' => 'payment_status',
					'value' => '($data->payment_status === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		
 array('class'=>'CButtonColumn',
    'template'=>'{view}',
    'buttons'=>array (
        'view'=>array(
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-search','title'=>'view' ),
        ),
    ),
),
	),
)); ?>