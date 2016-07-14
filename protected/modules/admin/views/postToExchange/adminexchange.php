<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
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
	$.fn.yiiGridView.update('post-to-exchange-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->
<?php
$height = '50';
$width = '50';
 ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'post-to-exchange-grid',
	'dataProvider' => $model->searchData(),
	'filter' => $model,
	'columns' => array(
		//'postexchange_id',
		//'user_id',
		//'campaign_id',

		//'compaign_message',
		//array(
			//'name' => 'campaignmessage',
			//'filter' => '',
		//),
		//'display_name',
		array(
			'name' => 'display_name',
			'filter' => '',
		),
		'message',
		//'created_date',
		array(
			'name'=>'Social Video',
			'filter'=>'',
			'type' => 'raw',
			'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , UtilityHtml::getSocialVideo(GxHtml::valueEx($data,\'video_url\')))',
			'htmlOptions' => array('class' => 'video-top'),
		),
		array(
			'name'=>'Social Image',
			'filter'=>'',
			'type' => 'html',
			'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array("height"=>\''.$height.'\',\'width\'=>\''.$width.'\',"src" => UtilityHtml::getSocialDisplay(GxHtml::valueEx($data,\'image_url\')))))',
		),
		),
)); ?>
