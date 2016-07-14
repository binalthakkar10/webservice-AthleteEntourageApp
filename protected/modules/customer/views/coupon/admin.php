
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
$delete = '';
if(isset($_GET['del']) && !empty($_GET['del']))
{
	$delete = $_GET['del'];
}	
?>
<script type="text/javascript">
	$(document).ready(function(){
		var del = '<?php echo $delete; ?>';
		if(del == 'exist')
		{
			alert('Coupon cannot be deleted, it is related to business');
			window.location.href = '<?php echo CController::createUrl('/customer/coupon/index');?>';
		}
	});
</script>

<?php $this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'a[class=fancybox1]',
    'config'=>array(),
    )
); ?>

<?php $id=Yii::app()->customer->id;?>
<div style="padding-top: 50px">
	<?php /*?><h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode('Coupon Template'); ?></h1><?php */?>
</div>
<?php
if($_SESSION['free_user']=='1'){
	$userid 	= Yii::app()->customer->getId();
	$total_coupon = Coupon::model()->findAll('user_id = "'.$userid.'"');
	if(count($total_coupon) == 0){
		echo CHtml::button('Add Coupon', array('submit' => array('Coupon/AddCoupon'), 'class'=>'button_orange'));
	}
}else if($_SESSION['allow_retailer']=='1'){
	echo CHtml::button('Add Coupon', array('submit' => array('Coupon/AddCoupon'), 'class'=>'button_orange'));	
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
		
		/*array(
			'name' => 'Username',
			'value' => 'CHtml::encode($data["username"])'
		),*/
		array(
			'name' => 'Coupon Title',
			'type' => 'raw',
			'value' => 'CHtml::encode($data["coupon title"])'
		),
		 array(
		
        'name'=>'image',
        'type'=>'html',
        //'value'=>'CHtml::image(Yii::app()->assetManager->publish('.$assetsDir.'$model->image),"",array("style"=>"width:25px;height:25px;"))',
        //'value' => 'CHtml::tag("img", array("src" => $model->image ? "340-Koala.jpg" : "340-Koala.jpg"), "")'   
       'value'=>'(!empty($data["image"])) ? CHtml::link(CHtml::tag("img",array("height"=>\''.$height.'\',\'width\'=>\''.$width.'\',"src" => UtilityHtml::getImageCoupon(GxHtml::valueEx($data,\'image\')))),"",array("class"=>"fancybox1","href"=> UtilityHtml::getImageCoupon(GxHtml::valueEx($data,\'image\')))) :  CHtml::tag("img",array("height"=>\''.$height.'\',\'width\'=>\''.$width.'\',"src" => UtilityHtml::getImageCoupon(GxHtml::valueEx($data,\'image\'))))',
		),	
		array(
			'name' => 'Image url',
			'value'=>'CHtml::link($data["image_url"], $data["image_url"], array(\'target\' => \'_blank\'))', 
			'type'=>'raw',
		),
		array(
			'name' => 'Start Date',
			'value' => 'CHtml::encode($data["start_date"])'
		),
		array(
			'name' => 'Expiry date',
			'value' => 'CHtml::encode($data["expiry_date"])'
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
			         	'url'=>'Yii::app()->createUrl(\'customer/coupon/update\', array(\'id\'=>$data["id"]))',
			        	
			        
			        ),
			        'Delete' => array
			        (   
			     		//'imageUrl'=>Yii::app()->request->baseUrl.'/images/update.png',
			         	'url'=>'Yii::app()->createUrl(\'customer/coupon/delete\', array(\'id\'=>$data["id"]))',
			        	'options'=>array('confirm'=>'Are you sure want to Delete?'),
			        
			        ),
			        
			        
			        
	         
			),
		),
		
	),
));

?>

<script type="text/javascript">
	$(document).ready(function() {
	    $(".fancybox1").fancybox({
	          helpers: {
	              title : {
	                  type : 'float'
	              }
	          }
	      });
	});
	
</script>

