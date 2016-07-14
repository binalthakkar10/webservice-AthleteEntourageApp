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
	$.fn.yiiGridView.update('campaign-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
	$height=35;
	$width=35;
?>
<h1><?php echo Yii::t('app') . ' ' . GxHtml::encode($model->label(2)); ?></h1>



<?php //echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'campaign-grid',
	'dataProvider' => $model->searchData(),
	'filter' => $model,
	'columns' => array(
		array(
                'header'=>'Partners Name', //column header
                'type'=>'html',
               'value'=>'CampaignPartner::getCampaignData($data->campaign_id)', //column name, php expression
               //'filter'=>CHtml::textField('twitter_screen_name', '', array('class'=>'asdf')),
                // 'filter' => CHtml::activeTextField($model, 'campaign_id'),
                
            ),
		'created_date',
		'message',
		//'video_url',
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
		//'image_url',
	),
)); ?>
<style>
.video-top{vertical-align:top !important;}
</style>