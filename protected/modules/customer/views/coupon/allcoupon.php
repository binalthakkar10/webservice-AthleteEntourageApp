<div class="bg_coupon">
<h1 class="allcoupon">All Coupon</h1>

<?php 
$id=Yii::app()->customer->id;
$model= Coupon::model()->findAll('user_id="'.$id.'"');
$total=count($model);
?>

Total Coupon:<?php echo $total;
echo "</br>";
?>

<?php 
$model= Coupon::model()->findAll('user_id="'.$id.'" LIMIT 0,5 ');
foreach($model as $data){
		echo $data->deal_title;
		echo "</br>";

}
?>



</div>