<script>
$(document).ready(function(){
	setTimeout(function(){ $(".flash-error").hide(); },3000);
	setTimeout(function(){ $(".flash-success").hide(); },3000);
});
</script>
<?php 
$this->breadcrumbs=array(
	'User'=>array('admin'),
	'Manage',
);
	$user_id=Yii::app()->getUser()->getId();
	 
	if(isset($user_id))
		{
			$resultset=User::model()->find("id='$user_id'");
			if(isset($resultset->attributes))
			{
				$data=$resultset->attributes;	
				//p($data);							
				//ECHO $data['user_type'];
				if($data['user_type']!="user")
				{
					$this->menu=array(
	
	//array('label'=>'List User', 'url'=>array('index')),
	//array('label'=>'Create User', 'url'=>array('create')),
					);
				}		
			}
		}	


$this->menu = array(
		//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
			array('label'=>'Create User', 'url'=>array('create')),
	);		
 
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
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
<h1>Manage Users </h1>
<div class="search_popupbox">
<h3 style="color:blank; font-family:bold;"><img src="<?php echo Yii::app()->baseUrl.'/images/search-128.png'?>" width="15px;" height="15px;" /> Search Tips:- </h3>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
</div>

<?php /*
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/?>


<?php
$template = '{update}{delete}';
if($this->userType=='admin')
	$template = '{update} {delete}'; 
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'beforeAjaxUpdate'=>'function(id, options){
		var strUrl = options.url;
		var regex = /id=([0-9]+)&/;
		if(regex.test(strUrl) == true) {
			var ar = strUrl.match(regex);
			if(ar[1]){
				if(ar[1] == '.Yii::app()->admin->id.') {
					alert("You can not delete your own account!");
					return false;
				}
			}
		}
		
	}',
	'columns'=>array(
		//'id',
		'user_type',
		'username',
		//'user_type',
        'firstname',
		'lastname',
		//'email',

		
		
		
		array(
			'name' => 'email',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->email), "mailto:".CHtml::encode($data->email))',
		),
		//'is_active',
		array(
					'name'=>'is_active',
					'filter'=> array('1'=>'Active','0'=>'Inactive'), 
					'type' => 'html',
					'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array( "src" => UtilityHtml::getStatusImage(GxHtml::valueEx($data, \'is_active\')))))',
		),
		//'created_at',
		//'updated_at',
		/*
		'password',
		
		'logdate',
		'lognum',
		'extra',
		*/
		array(
			
			'class'=>'CButtonColumn',
			'header'=>'Action',
			'deleteConfirmation'=>"Are You Sure Want To Delete?",
			'afterDelete'=>'function(){ $(".delete_div").html("<div class=flash-success>Successfully Delete Record!</div>"); setTimeout(function(){ $(".delete_div").hide(); },3000); }',	
			'htmlOptions'=>array('width'=>'75px'),
	    	'template'=>'{update}&nbsp;&nbsp;{delete}',
			'buttons'=>array
			(
			    'update' => array
			    (   
			     	'imageUrl'=>Yii::app()->request->baseUrl.'/images/update_1.png',
			         'url'=>'Yii::app()->createUrl(\'admin/adminUser/update\', array(\'id\'=>$data->id))',
			    ),
			    'delete' => array
			    (   
			     	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete_1.png',
			         'url'=>'Yii::app()->createUrl(\'admin/adminUser/delete\', array(\'id\'=>$data->id))',
			    ),
			),
		),
	),
)); ?>
<?php 
	$controller = Yii::app()->controller->id;
	$action = Yii::app()->controller->action->id;
	if($controller == 'adminUser' && $action == 'admin'){
?>
<script>
$(document).ready(function(){
	$("div#sidebar-left ul li.users").each(function(){
		var span_val=$("div#sidebar-left ul li.users").find('span').attr('id');
		if(span_val == 'users'){
			$("div#sidebar-left ul li.users").addClass('active');
		}
	});
});
</script>
<?php } ?>
