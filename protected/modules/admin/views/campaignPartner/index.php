<?php




 $controller = Yii::app()->controller->id;
 $actions = Yii::app()->controller->action->id;
?>
<?php //if($controller == '') ?>
<?php
$this->renderPartial('_hire', array(
		'model' => $model));
?>