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
	$.fn.yiiGridView.update('post-to-exchange-price-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage'); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'post-to-exchange-price-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		//'price_id',
		'no_days',
		'price',
		array(
					'name' => 'status',
					'value' => '($data->status === 0) ? Yii::t(\'app\', \'Inactive\') : Yii::t(\'app\', \'Active\')',
					'filter' => array('0' => Yii::t('app', 'Inactive'), '1' => Yii::t('app', 'Active')),
					),
		 array('class'=>'CButtonColumn',
    'template'=>'{update} {view}',
    'buttons'=>array (
        'update'=> array(
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-edit','title'=>'edit' ),
        ),
        'view'=>array(
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-search','title'=>'view' ),
        ),
    ),
),
	),
)); ?>