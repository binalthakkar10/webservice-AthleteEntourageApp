
<?php 
 $this->renderPartial('/layouts/subheader');
 ?>
<?php $height = SystemConfig::getValue('coupon_height');?>
<?php $width = SystemConfig::getValue('coupon_width');?>
<?php 
$this->breadcrumbs = array(
	'Coupon Template' => array('admin'),
	Yii::t('app', 'Manage'),
);
?>


<?php $id=Yii::app()->customer->id;?>
<div style="padding-top: 50px">
	<?php /*?><h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode('Coupon Template'); ?></h1><?php */?>
</div>
<?php 
if($_SESSION['free_user']=='1'){
	$userid 	= Yii::app()->customer->getId();
	$total_business = Business::model()->findAll('user_id = "'.$userid.'"');
	if(count($total_business) == 0){
		echo CHtml::button('Add Business', array('submit' => array('Business/AddBusiness'), 'class'=>'button_orange'));
	}
}else if($_SESSION['allow_retailer']=='1'){
 	echo CHtml::button('Add Business', array('submit' => array('Business/AddBusiness'), 'class'=>'button_orange'));
}
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'email-grid',
	
	'dataProvider' => $arrayDataProvider,
	'columns' => array(

array(
			'name' => 'Id',
			//'type' => 'raw',
			'value' => 'CHtml::encode($data["counter"])'
		),
		array(
			'name' => 'Business name',
			'type' => 'raw',
			'value' => 'CHtml::encode($data["business_name"])'
		),
		array(
			'name' => 'Business Image url',
			'value'=>'CHtml::link($data["business_image_url"], $data["business_image_url"], array(\'target\' => \'_blank\'))', 
			'type'=>'raw',
		),
		
		array(
			'name' => 'Business Phone number',
			'value' => 'CHtml::encode($data["business_phone_number"])'
		),
		array(
			'name' => 'coupon',
			'value' => 'CHtml::encode($data["coupon"])'
		),
		array(
			'name' => 'city',
			'value' => 'CHtml::encode($data["city"])'
		),
		array(
			'name' => 'category',
			'value' => 'CHtml::decode($data["category"])'
		),
		array(
			
			'class'=>'CButtonColumn',
			'header'=>'Action',
			'htmlOptions'=>array('width'=>'75px'),
	    	'template'=>'{Edit},{Delete}',
			'buttons'=>array
			(
			 		'Edit' => array
			        (   
			     		//'imageUrl'=>Yii::app()->request->baseUrl.'/images/update.png',
			         	'url'=>'Yii::app()->createUrl(\'customer/business/update\', array(\'id\'=>$data["id"]))',
			        	
			        
			        ),
			        'Delete' => array
			        (   
			     		//'imageUrl'=>Yii::app()->request->baseUrl.'/images/update.png',
			         	'url'=>'Yii::app()->createUrl(\'customer/business/delete\', array(\'id\'=>$data["id"]))',
			        	'options'=>array('confirm'=>'Are you sure want to Delete?'),
			        
			        ),
			        
			        
			        
	         
			),
		),
		
		
	),
));

?>