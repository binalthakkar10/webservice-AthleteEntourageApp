<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('admin')),
	//array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	//array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->user_id)),
	//array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->user_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
//'user_id',

array(
					'name' => 'user_type',
					'value' => ($model->user_type ==1) ? Yii::t('app', 'Athlete') : Yii::t('app', 'Entourage'),
					//'filter' => array('1' => Yii::t('app', 'Athlete'), '2' => Yii::t('app', 'Entourage')),
					),
'profile_image',
'display_name',
//'first_name',
//'last_name',
'description',
//'email',
//'phone_number',
//'oauth_provider',
//'oauth_uid',
'device_id',
array(
					'name' => 'device_type',
					'value' => ($model->device_type ==1) ? Yii::t('app', 'Android') : Yii::t('app', 'IOS'),
					//'filter' => array('1' => Yii::t('app', 'Athlete'), '2' => Yii::t('app', 'Entourage')),
					),
'push_score_change:boolean',
'push_get_contacted:boolean',
'push_new_exchanges:boolean',
'push_new_athletes:boolean',
//'impact_score',
'created_date',
'is_verified:boolean',
'is_featured:boolean',
'facebook_screen_name',
'twitter_screen_name',
	),
)); ?>

<div></div>
