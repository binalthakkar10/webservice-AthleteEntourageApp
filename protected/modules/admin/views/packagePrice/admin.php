<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
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
	$.fn.yiiGridView.update('package-price-grid', {
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
	'id' => 'package-price-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		//'package_id',
		'package_name',
		 array(
		 	'type'=>'html',
		 	'header'=>'Package Price($)',
            'name'=>'package_price',
            'value'=>'Yii::app()->numberFormatter->formatCurrency($data->package_price, "USD")',
            'htmlOptions'=>array('style'=>'text-align: center'),
        ),
	 array('class'=>'CButtonColumn',
    'template'=>'{update}',
    'buttons'=>array (
        'update'=> array(
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-edit','title'=>'edit' ),
        ),
    ),
),
	),
)); ?>