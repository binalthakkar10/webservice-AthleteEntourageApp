<?php

/*$name = $_POST['name'];
$filename = $_POST['filename'];
echo "Name = '" . $name . "', filename = '" . $filename . "'.";*/
$type=$_REQUEST['type'];
//$pathUser = Yii::app()->getBaseUrl(true).'/upload/UserMedia/';
//$pathCamp = Yii::app()->getBaseUrl(true).'/upload/CampaignMedia/';
if($type==1)
{
//$image=move_uploaded_file($_FILES['uploadedfile']['tmp_name'], "UserMedia/".$_FILES["uploadedfile"]["name"]);

move_uploaded_file($_FILES['uploadedfile']['tmp_name'], "UserMedia/".$_FILES["uploadedfile"]["name"]);
$image="UserMedia/".$_FILES["uploadedfile"]["name"];
if(!empty($image))
{
	
	$response['status'] = "1";
	//$response['data'] =$pathUser.$image;
	echo json_encode($response);
	exit();
	
}
}
elseif($type==2)
{
move_uploaded_file($_FILES['uploadedfile']['tmp_name'], "CampaignMedia/".$_FILES["uploadedfile"]["name"]);
$image1="CampaignMedia/".$_FILES["uploadedfile"]["name"];
if(!empty($image1))
{
	$response['status'] = "1";
	//$response['data'] =$pathCamp.$image;
	echo json_encode($response);
	exit();
	
}		
}
elseif($type==3)
{
move_uploaded_file($_FILES['uploadedfile']['tmp_name'], "ExchangePostMedia/".$_FILES["uploadedfile"]["name"]);
$image2="ExchangePostMedia/".$_FILES["uploadedfile"]["name"];
if(!empty($image2))
{
	$response['status'] = "1";
	//$response['data'] =$pathCamp.$image;
	echo json_encode($response);
	exit();
	
}		
}
elseif($type==4)
{
move_uploaded_file($_FILES['uploadedfile']['tmp_name'], "support_directory/".$_FILES["uploadedfile"]["name"]);
$image3="support_directory/".$_FILES["uploadedfile"]["name"];
if(!empty($image3))
{
	$response['status'] = "1";
	//$response['data'] =$pathCamp.$image;
	echo json_encode($response);
	exit();
	
}		
}
else {
				$response['status'] = "0";
				$response['data'] = "No Image Inserted.";
				echo json_encode($response);
				exit();
}
//error_log ( "Name = '" . $name . "', filename = '" . $filename . "'." );

?>