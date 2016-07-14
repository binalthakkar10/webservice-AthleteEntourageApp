<?php

$this->breadcrumbs = array(
	PostToExchange::label(2),
	Yii::t('app', 'admin'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . PostToExchange::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . PostToExchange::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(PostToExchange::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 