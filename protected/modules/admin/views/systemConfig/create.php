<?php

$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	Yii::t('app', 'Create'),
);

$this->menu = array(
	//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php //echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h1>
<h1><?php echo Yii::t('app', 'Create SystemConfigs')  ?></h1>
<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>
<?php 
	$controller = Yii::app()->controller->id;
	$action = Yii::app()->controller->action->id;
	if($controller == 'systemConfig' && $action == 'create'){
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