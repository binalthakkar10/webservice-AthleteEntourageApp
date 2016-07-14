<?php

$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	//GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
//'sponser_id',
'username',
'iphone_image',
'ipad_image',
'fb_screen_name',
'twitter_screen_name',
'total_twitt',
'total_retwitt',
'fb_likes',
'fb_friends',
'facebook_followers',
'twitter_followers',
'impact_score',
'team',
'position',
'flag:boolean',
	),
)); ?>

