<div class="bg_coupon">
<h1 class="allcoupon">All Business</h1>
<?php 
$id=Yii::app()->customer->id;
$model= Business::model()->findAll('user_id="'.$id.'"');
$total=count($model);
?>
Total Business:<?php echo $total;
echo "</br>";
?>

<?php 
$id=Yii::app()->customer->id;
$model= Business::model()->findAll('user_id="'.$id.'" LIMIT 0,5 ');
foreach($model as $data){
	//p($data->attributes);
	
		echo $data->business_name;
		echo "</br>";
}
?>

</div>
