<?php
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	//Yii::t('app', 'Manage'),
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
	$.fn.yiiGridView.update('user-detail-grid', {
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
<div class="row buttons" style="left: 85%; position: relative;">
        <?php echo CHtml::button('Verify',array('name'=>'btnverifyall','class'=>'verify-button')); ?>
        <?php echo CHtml::button('Delete',array('name'=>'btndeltall','class'=>'delete-button')); ?>
</div>



<div id="basicModal">
  
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-search-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype' => 'multipart/form-data','action'=>Yii::app()->createUrl('Controller/action'))
));?>

<?php $height=50;
$width=50;?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'user-detail-grid',
	'dataProvider' => $model->search(),
	  'selectableRows'=>2,
	'filter' => $model,
	'columns' => array(
			                  array(
			                
                'value'=>'$data->user_id',
       			 'class'=>'CCheckBoxColumn',
       			// 'disabled'=>'($data->is_verified == 1)?true:false',
       			 'headerTemplate' => '',
      
                ),
        

					array(
					'name' => 'user_type',
					'value' => '($data->user_type ==1) ? Yii::t(\'app\', \'Athlete\') : Yii::t(\'app\', \'Entourage\')',
					'filter' => array('1' => Yii::t('app', 'Athlete'), '2' => Yii::t('app', 'Entourage')),
					),
			array(
			'name'=>'profile_image',
			'filter'=>'',
			'type' => 'html',
			'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array("height"=>\''.$height.'\',\'width\'=>\''.$width.'\',"src" => UtilityHtml::getImageDisplay(GxHtml::valueEx($data,\'profile_image\')))))',
		),
		'display_name',
		'twitter_screen_name',
						array(
					'name' => 'is_verified',
					'value' => '($data->is_verified == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					//'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					'filter' =>'',
					),


					
		//'first_name',
		//'last_name',
		/*
		'description',
		'email',
		'phone_number',
		'oauth_provider',
		'oauth_uid',
		'device_id',
		'device_type',
		array(
					'name' => 'push_score_change',
					'value' => '($data->push_score_change === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'push_get_contacted',
					'value' => '($data->push_get_contacted === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'push_new_exchanges',
					'value' => '($data->push_new_exchanges === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'push_new_athletes',
					'value' => '($data->push_new_athletes === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		'impact_score',
		'created_date',

		array(
					'name' => 'is_featured',
					'value' => '($data->is_featured === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		'facebook_screen_name',
		'twitter_screen_name',
		*/
		/*array(
			'class' => 'CButtonColumn',
		),*/
  array('class'=>'CButtonColumn',
    'template'=>'{view} {delete} {active}',
    'buttons'=>array (
        'view'=>array(
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-search','title'=>'view' ),
        ),
             'delete'=>array(
            'label'=>'',
            'visible'=>'$data->is_delete == 1',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-trash','title'=>'delete' ),
            'url' => '"#".$data->user_id',
                	'click' => 'js:function() {
                    if(confirm("Please review User details before delete")){
                             deleteUser($(this).attr("href").replace("#", ""));
                             $.fn.yiiGridView.update("user-grid");
                             $(".grid-view-loading").css("background-image", "none");
                    }
                    }',
        ),
        
		'active'=>array(
            'label'=>'',
            'visible'=>'$data->is_delete == 0',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-ok','title'=>'active' ),
            'url' => '"#".$data->user_id',
                	'click' => 'js:function() {
                    if(confirm("Are you sure? want to active the user")){
                             activeUser($(this).attr("href").replace("#", ""));
                             $.fn.yiiGridView.update("user-grid");
                             $(".grid-view-loading").css("background-image", "none");
                    }
                    }',
        ),
        
		  
        
    ),
),
	),
)); ?>


<?php $this->endWidget(); ?>
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
        }
        else 
        {
   
    window.location.href ="<?php echo Yii::app()->getBaseUrl(true);?>/admin/UserDetail/deleteAll?id="+checkbox_value;
    	}

});

function deleteUser(Vid){
	var tag = $("<div></div>");
	
	tag.dialog({
		  autoOpen: false,
		  height: 500,
		  width: 1108,
		  modal: true,
		  buttons: {
		  	Delete: function () {
		  		var r = confirm("Are you sure? want to delete the user");
				if(r == true) {
		  		
		  			$.ajax({
				 type:'post',
				 url:"<?php echo CController::createUrl('/admin/Posts/DeleteData');?>",
				 data:{'id':Vid},
				 dataType:"text",
				 success:function(data){
				 	location.reload();
				 	tag.html(data).dialog({modal: true}).dialog('close');
				 	
				 }
				});
			}else{
				 $( this ).dialog( "close" );
			}
                    
               },
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
			 
		  }
		 
		});
	$.ajax({
		 type:'post',
		 url:"<?php echo CController::createUrl('/admin/Posts/AllInformation');?>",
		 data:{'id':Vid},
		 dataType:"text",
		 success:function(data){
		 tag.html(data).dialog({modal: true}).dialog('open');
		 }
	});
}
//--------- Activate the User-----
function activeUser(Vid){
	$.ajax({
		 type:'post',
		 url:"<?php echo CController::createUrl('/admin/Posts/ActiveUser');?>",
		 data:{'id':Vid},
		 dataType:"text",
		 success:function(data){
			location.reload();
		 }
	});
}


//-----DeleteAll------
	$('.delete-button').click(function(){
		var a = confirm("Please review User details before delete");
			if(a == true) {
		
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
                alert('Please select atleast one user to delete');
        }
        else 
        {
 				var tag = $("<div></div>");
	
	tag.dialog({
		  autoOpen: false,
		  height: 500,
		  width: 1108,
		  modal: true,
		  buttons: {
		  	Delete: function () {
		  		var r = confirm("Are you sure? want to delete the user");
				if(r == true) {
		  		
		  			$.ajax({
				 type:'post',
				 url:"<?php echo CController::createUrl('/admin/Posts/DeleteData');?>",
				 data:{'id':checkbox_value},
				 dataType:"text",
				 success:function(data){
				 	location.reload();
				 	tag.html(data).dialog({modal: true}).dialog('close');
				 	
				 }
				});
			}else{
				 $( this ).dialog( "close" );
			}
                    
               },
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
			 
		  }
		 
		});
	$.ajax({
		 type:'post',
		 url:"<?php echo CController::createUrl('/admin/Posts/AllInformation');?>",
		 data:{'id':checkbox_value},
		 dataType:"text",
		 success:function(data){
		 tag.html(data).dialog({modal: true}).dialog('open');
		 }
	});  
    	}
}else{
	$( this ).dialog( "close" );
	
}
});
</script>
<script>
$(document).ready(function(){
	//setTimeout(function(){ $(".flash-error").hide(); },3000);
	//setTimeout(function(){ $(".flash-success").hide(); },3000);
});
</script>
