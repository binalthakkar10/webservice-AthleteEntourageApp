



<link rel="stylesheet" type="text/css" media="all, print" href="<?php echo Yii::app()->baseUrl.'/css/cardprint.css'; ?>" />

	
<script>
$(document).ready(function(){
	$("div.portlet-content ul li a:first").addClass('first_div');
	$(".first_div").click(function(){
		//var path = "<?php// echo Yii::app()->baseUrl.'/css/cardprint.css'; ?>";
		var fullname = $("#Users_fullname").val();
		var email=$("#Users_email").val();
		var logos=$("#Users_code").val();
		
		var firstletter_capital = fullname.charAt(0).toUpperCase() + fullname.slice(1).toLowerCase();
		var printWindow = window.open("", divContents, "height=400,width=800");
		//printWindow.document.write('<link rel="stylesheet" type="text/css" media="all" href="'+path+'" />');
		var divContents = '<div style="background-image: url(../../images/business_card.jpg) !important;float:none;position:relative;display:inline-block;margin:0;text-align:center;height:216px;width:360px;background-color: #000;background-size: 100% 100%;-webkit-print-color-adjust: exact;"><span class="firstname1" style="color: #FFC933;font-family:glegooregular;position: absolute;bottom:93%;font-size:11px;left:4%;font-weight: bold;-webkit-print-color-adjust: exact;">'+firstletter_capital+'</span><span style="color: #FFC933;font-family:glegooregular;font-weight: bold;position: absolute;top:2px;font-size:11px;left:65%;-webkit-print-color-adjust: exact;">Code: '+logos+'</span><span style="color: #FFC933;font-family:glegooregular;position: absolute;bottom:5px;font-weight: bold;font-size:11px;left:5%;-webkit-print-color-adjust: exact;">'+email+'</span><a href="www.lgopromo.com" id="logo_span" style="font-weight:bold;color: #FFC933;font-family:glegooregular;font-size: 11px;font-weight: bold;left: 36%;top:91%;position: relative;">www.lgopromo.com</a></div>';
        printWindow.document.write(divContents);
      	printWindow.document.close();
        printWindow.print(); 
	});
});
</script>
<!--  <script><!--
$(document).ready(function(){
	$("div.portlet-content ul li a:first").addClass('first_div');
	$(".first_div").click(function(){
		var path = "<?php echo Yii::app()->baseUrl.'/css/cardprint.css'; ?>";
		var fullname = $("#Users_fullname").val();
		var firstletter_capital = fullname.charAt(0).toUpperCase() + fullname.slice(1).toLowerCase();
		var printWindow = window.open("", divContents, "height=400,width=800");
		printWindow.document.write('<link rel="stylesheet" type="text/css" media="all" href="'+path+'" />');
		var divContents = '<div id="vip_iframe_load"><span class="firstname1">'+firstletter_capital+'</span></div>';
        printWindow.document.write(divContents);
      	printWindow.document.close();
        printWindow.print(); 
	});
});
</script>-->

<?php
$this->breadcrumbs=array(
	'User'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Print Preview', 'url'=>'javascript:;'),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<h1>
<?php echo Yii::t("messages", 'Create User'); ?>
</h1>

 

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php 
	$controller = Yii::app()->controller->id;
	$action = Yii::app()->controller->action->id;
	if($controller == 'adminUser' && $action == 'create'){
?>
<script>
$(document).ready(function(){
	$("div#sidebar-left ul li.users").each(function(){
		var span_val=$("div#sidebar-left ul li.users").find('span').attr('id');
		if(span_val == 'users'){
			$("div#sidebar-left ul li.users").addClass('active');
		}
	});
});
</script>
<?php } ?>