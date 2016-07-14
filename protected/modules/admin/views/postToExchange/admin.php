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
	$.fn.yiiGridView.update('post-to-exchange-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<div class="row buttons" style="left: 85%; position: relative;">
        <?php echo CHtml::button('Delete',array('name'=>'btndeltall','class'=>'delete-button')); ?>
</div>

<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'post-to-exchange-grid',
	'dataProvider' => $model->search(),
		  'selectableRows'=>2,
	'filter' => $model,
	'columns' => array(
	 array(
			                
                'value'=>'$data->postexchange_id',
       			 'class'=>'CCheckBoxColumn',
       			// 'disabled'=>'($data->is_verified == 1)?true:false',
       			 'headerTemplate' => '',
      
                ),
		//'postexchange_id',
		//'user_id',
		//'campaign_id',

		//'compaign_message',
		//array(
			//'name' => 'campaignmessage',
			//'filter' => '',
		//),
		//'display_name',
							array(
					'name' => 'display_name',
					'filter' => '',
					),
							array(
					'name' => 'user_type',
					'value' => '($data->user_type ==1) ? Yii::t(\'app\', \'Athlete\') : Yii::t(\'app\', \'Entourage\')',
					'filter' => '',
					),
		'message',
		'created_date',
		 array('class'=>'CButtonColumn',
    		   'template'=>'{view}&nbsp;{socialmedia}&nbsp;{delete}',
			   'buttons'=>array (
			        'view'=>array(
			            'label'=>'',
			            'imageUrl'=>'',
			            'options'=>array( 'class'=>'icon-search','title'=>'view' ),
			        ),
			        'socialmedia' => array(
	        			'label'=>'Social Media',   
			        	'imageUrl'=>Yii::app()->baseUrl.'/images/social_media.png',    
			         	'url'=>'Yii::app()->createUrl(\'admin/PostToExchange/AdminMessage\', array(\'id\'=>$data->postexchange_id))',
					 ),
					 'delete' => array(
				            'label'=>'',
				            'visible'=>'$data->is_delete == 1',
				            'imageUrl'=>'',
				            'options'=>array( 'class'=>'icon-trash','title'=>'delete' ),
				            'url' => '"#".$data->postexchange_id',
				                	'click' => 'js:function() {
				                    if(confirm("Please preview details before delete Post To Exchange?")){
				                             deleteUser($(this).attr("href").replace("#", ""));
				                             $.fn.yiiGridView.update("post-to-exchange-grid");
				                             $(".grid-view-loading").css("background-image", "none");
				                    }
				                    }',
		        	 ),
			   ),
			),
		),
)); ?>

<script>

//---- Delete Single----
function deleteUser(Vid){

	var tag = $("<div></div>");
	
	tag.dialog({
		  autoOpen: false,
		  height: 500,
		  width: 1108,
		  modal: true,
		  buttons: {
		  	Delete: function () {
		  		var r = confirm("Are you sure want to delete the Exchange Post ?");
				if(r == true) {
		  		
		  			$.ajax({
				 type:'post',
				 url:"<?php echo CController::createUrl('/admin/PostToExchange/deleteExchange');?>",
				 data:{'exchange_id':Vid},
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
		 url:"<?php echo CController::createUrl('/admin/PostToExchange/AllInformation');?>",
		 data:{'id':Vid},
		 dataType:"text",
		 success:function(data){
		 tag.html(data).dialog({modal: true}).dialog('open');
		 }
	});
}



//-----DeleteAll------
	$('.delete-button').click(function(){
		var a = confirm("Are you sure want to delete the Exchange Post ?");
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
                alert('Please select atleast one Exchange post to delete');
        }
        else 
        {
 	
	$.ajax({
		 type:'post',
		 url:"<?php echo CController::createUrl('/admin/PostToExchange/deleteExchangeMultiple');?>",
		 data:{'exchange_id':checkbox_value},
		 dataType:"text",
		 success:function(data){
			location.reload();
		 }
	});  
    	}
}else{
	$( this ).dialog( "close" );
	
}
});
</script>