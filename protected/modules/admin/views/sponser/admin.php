<?php

$this->breadcrumbs = array(
	$model->label(2) => array('admin'),
	//Yii::t('app', 'Manage'),
);

$this->menu = array(
		//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sponser-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
	    foreach(Yii::app()->admin->getFlashes() as $key => $message) {
	        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	    }
?>
<h1><?php echo Yii::t('app') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
<div class="row buttons" style="left: 95%;top: 8%; position: relative;">
        <?php echo CHtml::button('Active',array('name'=>'Active','class'=>'active-button')); ?>
</div>



<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->
<?php 
$height=50;
$width=50;
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'sponser-grid',
	'dataProvider' => $model->search(),
	'selectableRows'=>2,
	'filter' => $model,
	'columns' => array(
					                  array(
				'name'=>'checkbox',	                  
                'value'=>'$data->sponser_id',
       			 'class'=>'CCheckBoxColumn',
       			 'disabled'=>'($data->flag == 1)?true:false',
       			 'headerTemplate' => '',
      
                ),
	
		//'sponser_id',
		'username',
							array(
			'name'=>'iphone_image',
			'filter'=>'',
			'type' => 'html',
			'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array("height"=>\''.$height.'\',\'width\'=>\''.$width.'\',"src" => UtilityHtml::getiPhoneImageDisplay(GxHtml::valueEx($data,\'iphone_image\')))))',
		),
							array(
			'name'=>'ipad_image',
			'filter'=>'',
			'type' => 'html',
			'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array("height"=>\''.$height.'\',\'width\'=>\''.$width.'\',"src" => UtilityHtml::getiPadImageDisplay(GxHtml::valueEx($data,\'ipad_image\')))))',
		),
		'fb_screen_name',
		'twitter_screen_name',
		array(
					'name' => 'flag',
					'value' => '($data->flag == 0) ? Yii::t(\'app\', \'Inactive\') : Yii::t(\'app\', \'Active\')',
					'filter' => '',
					),
		/*
		'total_twitt',
		'total_retwitt',
		'fb_likes',
		'fb_friends',
		'facebook_followers',
		'twitter_followers',
		'impact_score',
		'team',
		'position',
		array(
					'name' => 'flag',
					'value' => '($data->flag === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		*/
 array('class'=>'CButtonColumn',
    'template'=>'{view}',
    'buttons'=>array (
        'view'=>array(
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-search','title'=>'view' ),
        ),

    ),
    ),
	),
)); ?>



<script type="text/javascript">

$('.active-button').click(function(){
        	 var checkbox_value = '';
    $(':checkbox').each(function () {
        var ischecked = $(this).is(':checked');
        $a =$(this).val();
        if (ischecked) {
            checkbox_value += $(this).val() + ',';
        }
    });
    var split = checkbox_value.split(',');
    

    
   var atLeastOneIsChecked = checkbox_value.length > 0;
   var moreThanOne= split.length > 2;
        if (!atLeastOneIsChecked)
        {
                alert('Please select atleast one user to verify');
        }
        else if (moreThanOne)
        {
               alert('Please select only one user to verify');
        }
        else 
        {
   
    window.location.href ="<?php echo Yii::app()->getBaseUrl(true);?>/admin/Sponser/ActiveUser?id="+checkbox_value;
    	}

});
</script>
<script>
$(document).ready(function(){
	setTimeout(function(){ $(".flash-error").hide(); },3000);
	setTimeout(function(){ $(".flash-success").hide(); },3000);
});
</script>