<?php

$this -> breadcrumbs = array($model -> label(2) => array('admin'),
//Yii::t('app', 'Manage'),
);

$this -> menu = array(
//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
//array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
);

Yii::app() -> clientScript -> registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cashout-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
foreach (Yii::app()->admin->getFlashes() as $key => $message) {
	echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>

<h1><?php echo Yii::t('app') . ' ' . GxHtml::encode($model -> label(2)); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="search-form">
<?php $this -> renderPartial('_search', array('model' => $model, )); ?>
</div><!-- search-form -->
<div class="row buttons" style="margin-left: 3px; margin-bottom: 8px;">
        <label style="float: left;">Cashout Message:</label>
        <?php echo CHtml::textarea('Message',array('name'=>'cashout_message','id'=>'cashout_message','class'=>'')); ?>
        <br>
        <?php echo CHtml::button('Verify', array('name' => 'btnverifyall', 'class' => 'verify-button')); ?>
</div>
<?php $this -> widget('zii.widgets.grid.CGridView', 
	array('id' => 'cashout-grid', 
			'dataProvider' => $model -> search(), 
			'filter' => $model, 
			'selectableRows'=>'50',
			'columns' =>array(
			array(
            'value' => '$data->cashout_id',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50',
            'disabled' => '($data->is_verified == 1)?true:false',
            'headerTemplate' => ''  
        ),
				/*
				array(
									array('value' => '$data->cashout_id', 
											'class' => 'CCheckBoxColumn', 
											'disabled' => '($data->is_verified == 1)?true:false', 
										)*/
				
	//	'cashout_id',
	'display_name',
	array(
	 'header'=>'Balance',
	 'name'=>'user_id',
	 'value'=>'Cashout::getBalanceInfo($data->user_id)',
	 ),
	'amount_to_cashout',
	'acc_no',
	'bank_swift_id', 'bank_name', array('name' => 'is_verified', 'value' => '($data->is_verified == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')', 'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), ),
	 array('class' => 'CButtonColumn',
	 				  'template' => '{view}',
	 				   'buttons' => array(
	 				   				//'update' => array('label' => '', 'imageUrl' => '', 'options' => array('class' => 'icon-edit', 'title' => 'edit'),), 
	 				   				'view' => array('label' => '', 'imageUrl' => '', 'options' => array('class' => 'icon-search', 'title' => 'view'),),
	 				   				  ), ), ), ));
 ?>


<script type="text/javascript">

	$('.verify-button').click(function(){
    	var checkbox_value = '';
    $(':checkbox').each(function () {
        var ischecked = $(this).is(':checked');
        
        if (ischecked) {
            checkbox_value += $(this).val() + ',';
        }
        
    });
    
   	var atLeastOneIsChecked = checkbox_value.length > 0;
	if (!atLeastOneIsChecked)
	{
	    alert('Please select atleast one user to verify');
	    $('textarea').attr('readonly','readonly');
	}
	else 
	{
		
		window.location.href ="<?php echo Yii::app() -> getBaseUrl(true); ?>/admin/Cashout/deleteAll?id="+checkbox_value+"&cashout_message="+$('textarea#Message').val();
	}

});
</script>
<script>
	$(document).ready(function() {
		//$('input[type="text"], textarea').attr('readonly','readonly');
		//setTimeout(function(){ $(".flash-error").hide(); },3000);
		//setTimeout(function(){ $(".flash-success").hide(); },3000);
	}); 
</script>