<?php if($_SESSION['allow_retailer']=='0'){?>
	<span class="subcription_period">Your subscription period is over. Kindly submit your credit card information to renew your subscription? <a href="<?php echo CController::createUrl('CreditCard/index');?>" style="color:blue;font-size:14px;">Click To Renew</a></span>
<?php }?>
<br>
<?php echo CHtml::button('Home', array('submit' => array('index/index'), 'class'=>'button_orange')); ?>
&nbsp;
<?php echo CHtml::button('Profile', array('submit' => array('register/profile'), 'class'=>'button_orange')); ?>
&nbsp;
<?php echo CHtml::button('Change Password', array('submit' => array('register/changepassword'), 'class'=>'button_orange')); ?>
&nbsp;

<?php 
if($_SESSION['allow_retailer']=='1'){
echo CHtml::button('Coupon', array('submit' => array('coupon/index'), 'class'=>'button_orange'));
 
?>

&nbsp;

<?php echo CHtml::button('Business', array('submit' => array('business/index'), 'class'=>'button_orange')); ?>
&nbsp;
<?php }?>
<?php echo CHtml::button('Credit Card Information', array('submit' => array('CreditCard/index'), 'class'=>'button_orange')); ?>
&nbsp;
<?php echo CHtml::button('Subscription', array('submit' => array('Subscription/index'), 'class'=>'button_orange')); ?>
<br />

