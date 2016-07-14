<script>
$(document).ready(function(){
	setTimeout(function(){ $(".flash-error").hide(); },3000);
	setTimeout(function(){ $(".flash-success").hide(); },3000);
});
</script>
<?php
$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		//array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('system-config-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="delete_div" style="display:block;"></div>
<?php
	    foreach(Yii::app()->admin->getFlashes() as $key => $message) {
	        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	    }
?>
<h1><?php echo Yii::t("app", 'Manage System Configs'); ?></h1>
<div class="search_popupbox">
<h3 style="color:blank; font-family:bold;"><img src="<?php echo Yii::app()->baseUrl.'/images/search-128.png'?>" width="15px;" height="15px;" /> Search Tips:- </h3>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
</div>


<?php /*
<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->
*/?>


<?php
$template = '{update}';
if($this->userType=='admin')
	$template = '{update}&nbsp;&nbsp;{delete}'; 
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(

	'id' => 'system-config-grid',

//'summaryText' => UHtml::getGridSummaryText(),
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(

		
		/*array(
			'name'=> 'id',
		    'header'=>Yii::t("messages", 'Id'), 
			'value'=>'GxHtml::valueEx($data, \'id\')',
			//'headerHtmlOptions'=> array('style'=> 'width: 35px; margin-right:15px;'),
			),*/
		array(
				'name'=>'system_section_id',
				'header'=>Yii::t("messages", 'System Section'),
				'value'=>'GxHtml::valueEx($data, \'systemSection\')', 
				'filter'=>GxHtml::listDataEx(SystemSection::model()->findAllAttributes(null, true, 'status=1')),
				),
		array(
				'name'=>'system_group_id',
				'header'=>Yii::t("messages", 'System Group'),
				'value'=>'GxHtml::valueEx($data, \'systemGroup\')', 
				'filter'=>GxHtml::listDataEx(SystemGroup::model()->findAllAttributes(null, true, 'status=1')),
				),
		
		array(
				'name'=>'name',
				'header'=>Yii::t("messages", 'Name'),
				'value'=>'GxHtml::valueEx($data, \'name\')',
				),
	
		array(
				'name'=>'value',
				'header'=>Yii::t("messages", 'Value'),
				'value'=>'GxHtml::valueEx($data, \'value\')',
				),
		array(
			'name'=>'status',
			'type' => 'html',
			'filter'=> UtilityHtml::getStatusArray(),
			'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array( "src" => UtilityHtml::getStatusImage(GxHtml::valueEx($data, \'status\')))))',
		),
		//'input_type',
		/*
		'input_options',
		'status',
		'position',
		*/
		
		array(
			'class' => 'CButtonColumn',
			'header'=>'Action',
			'template'=>$template,
			'deleteConfirmation'=>"Are you sure want to delete this record?",
			'afterDelete'=>'function(){ $(".delete_div").html("<div class=flash-success>Successfully Delete Record!</div>"); setTimeout(function(){ $(".delete_div").hide(); },3000); }',
			'buttons'=>array
			(
			    'update' => array
			    (   
			     	'imageUrl'=>Yii::app()->request->baseUrl.'/images/update_1.png',
			         'url'=>'Yii::app()->createUrl(\'admin/SystemConfig/update\', array(\'id\'=>$data->id))',
			    ),
			    'delete' => array
			    (   
			     	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete_1.png',
			         'url'=>'Yii::app()->createUrl(\'admin/SystemConfig/delete\', array(\'id\'=>$data->id))',
			    ),
			),	
		),
	),
)); ?>