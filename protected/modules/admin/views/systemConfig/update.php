<?php

$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	GxHtml::valueEx($model),
	Yii::t('app', 'Update'),
);

$this->menu = array(
	//array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	//array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	//array('label' => Yii::t('app', 'View') . ' ' . $model->label(), 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
	array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php //echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
<h1><?php echo Yii::t('app', 'Update SystemConfig')  ?></h1>
<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>
<?php 
	$controller = Yii::app()->controller->id;
	$action = Yii::app()->controller->action->id;
	if($controller == 'systemConfig' && $action == 'update'){
?>
<script>
$(document).ready(function(){
	$("div#sidebar-left ul li.system_config").each(function(){
		var span_val=$("div#sidebar-left ul li.system_config").find('span').attr('id');
		if(span_val == 'system_config'){
			$("div#sidebar-left ul li.system_config").addClass('active');
		}
	});
});
</script>
<?php } ?>