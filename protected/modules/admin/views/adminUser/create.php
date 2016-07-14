<?php
$this->breadcrumbs=array(
	'User'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<h1>
<?php echo Yii::t("messages", 'Create User'); ?>
</h1>

 

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php 
	$controller = Yii::app()->controller->id;
	$action = Yii::app()->controller->action->id;
	if($controller == 'adminUser' && $action == 'create'){
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