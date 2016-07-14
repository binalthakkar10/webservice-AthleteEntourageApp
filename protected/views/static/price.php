<?
foreach($data as $value){
			echo '</br>';
			echo $content=$value->content;
		}
?>
<div class="category price_category" style="margin-left:80px;">
		<?php if(!Yii::app()->customer->id):?>
		<div class="one price_one"><a href=<?php echo  CController::createUrl('register/index'); ?>><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/iphone-5.png" /></a></div>
		<?php else:?>
		<div class="one price_one"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/iphone-5.png" /></a></div>
		<?php endif;?>
		<div class="a_one price_a_one"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/blank.png" /></div>
		<div class="two price_two"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ipad.png" /></a></div>
		<div class="a_two price_a_two"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/blank.png" /></div>
		<div class="three price_three" style="margin-left: 20px; float: left;"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ipod.png" /></a></div>
</div>

<div class="signup">
<?php if(Yii::app()->customer->id):?>
<?php 
$_SESSION['tab_type'] = 'business';
$type = $_SESSION['tab_type'];
?>
<a href="<?php echo  CController::createUrl('index/tab',array('tab_type'=>$type)); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/get_started.png" /></a>
<?php else: ?>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/register/index"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/get_started.png" /></a>
<?php endif;?>
</div>