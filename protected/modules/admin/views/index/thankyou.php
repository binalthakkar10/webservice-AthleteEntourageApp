<script>
$(document).ready(function(){
	setTimeout(function(){ $(".flash-error").hide(); },3000);
});
</script>
<?php
$this->pageTitle=Yii::app()->name . ' - Login';
/*$this->breadcrumbs=array(
	'Login',
);*/
?>
<!-- <div class="repairersreg"><h1><a href="Repairersreg/create"> Repairer Registration </a></h1></div> -->
<div class="login_box">

<h1>Login</h1>
<div class="form">
<!--<p>Please fill out the following form with your login credentials:</p>-->
		


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ty-form',
	'enableAjaxValidation'=>false,
 
	'enableClientValidation'=>true,

      'clientOptions' => array(
		      'validateOnSubmit'=>true,
		      //'validateOnChange'=>true,
		      //'validateOnType'=>false,
          ),
)); ?>
	
Do you Want to verify The User

	<?php  $id= $_REQUEST['user_id'];
			$verify=$_REQUEST['verify'];  ?>
<div class="row buttons">
		<input type="button" id="verify" value="verify">
	</div>
	
	 

<?php $this->endWidget(); ?>
</div><!-- form -->

</div>
<script>
$(document).ready(function(){
	$("#verify").click(function(){
		alert("hello");		
	});
});	
	
</script>