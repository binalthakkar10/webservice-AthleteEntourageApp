<?php

  require_once('config.php');
  $conn=mysql_connect("10.168.1.49","letsnurt_roster","YcCeH3Dr6tefJ2i") or die("Could not connect database");
	  mysql_select_db("letsnurt_roster",$conn) or die("Could not select Database");	
	$response=array();
	$data = json_decode(file_get_contents('php://input'), TRUE);
  $token  = $data['data']['stripeToken'];
  $user_id  = $data['data']['user_id'];
  $amount  = $data['data']['amount'];
  $email  = $data['data']['email'];
  $twitter_screen_name    = $data['data']['twitter_screen_name'];
  $campaign_id    = $data['data']['campaign_id'];
  $post_id    = $data['data']['postexchange_id'];

  
  $customerData=Stripe_Customer::all();
  
  	if($customerData['data'][0]['email']==$email)
	{
		$customer_id  = $customerData['data'][0]['id'];
	}else{
		$customer = Stripe_Customer::create(array(
      				'email' => $email,
      				'card'  => $token));	
		$customer_id  = $customer['id'];
	}
 
  $charge = Stripe_Charge::create(array(
      'customer' => $customer_id,
      'amount'   => $amount,
      'currency' => 'usd'
  ));

if($charge)
{
	if(!empty($campaign_id))
	{
		
		
		$created_date=date('Y/m/d H:i:s');
	$dbInsertData="INSERT INTO `transaction`(`user_id`, `email`, `twitter_screen_name`, `payment_gateway_id`, `amount`, `campaign_id`, 
					`created_date`, `payment_status`) VALUES ('".$user_id."','".$email."','".$twitter_screen_name."','".$customer_id."','".$amount."','".$campaign_id."','".$created_date."',1)";
	$insertData=mysql_query($dbInsertData);		
				if($insertData!="")
				{
					$updateCamp=mysql_query("UPDATE `campaign` SET `is_paid`=1 WHERE `campaign_id`='".$campaign_id."'");
					if($updateCamp)
					{
					$response['status'] = "1";
					$response['data'] = "Successfully charged.";
					echo json_encode($response);
					exit();
					}
					}
					}elseif(!empty($post_id)){
					
						
							$created_date=date('Y/m/d H:i:s');
							$dbInsertData="INSERT INTO `transaction`(`user_id`, `email`, `twitter_screen_name`, `payment_gateway_id`, `amount`, `campaign_id`, 
											`created_date`, `payment_status`) VALUES ('".$user_id."','".$email."','".$twitter_screen_name."','".$customer_id."','".$amount."',0,'".$created_date."',1)";

							$insertData=mysql_query($dbInsertData);	
							if($insertData!="")
							{
								$updatePost=mysql_query("UPDATE `post_to_exchange` SET `is_paid`=1 WHERE `postexchange_id`='".$post_id."'");
								if($updatePost){
									$response['status'] = "1";
							$response['data'] = "Successfully charged.";
							echo json_encode($response);
							exit();
							}
							}
						
					}		
}else{
	$created_date=date('Y/m/d H:i:s');
	$dbInsertData="INSERT INTO `transaction`(`user_id`, `email`, `twitter_screen_name`, `payment_gateway_id`, `amount`, `campaign_id`, 
					`created_date`, `payment_status`) VALUES ('".$user_id."','".$email."','".$twitter_screen_name."','".$customer_id."','".$amount."','".$campaign_id."','".$created_date."',0)";
	$insertData=mysql_query($dbInsertData);				
					$response['status'] = "0";
					$response['data'] = "Problem in Payment.";
					echo json_encode($response);
					exit();
	
}
 // echo '<h1>Successfully charged $50.00!</h1>';
?>

