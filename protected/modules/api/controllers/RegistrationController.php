<?php
class RegistrationController extends ApiController{
	

public function objectToArray(&$object){
		$array=array();		
		foreach($object as $member=>$data)
		{
			$array[$member]=$data;
		}		
		return $array;
	}
	
	
	/**
	 * @Method		  :	POST
	 * @Params		  : user_type,profile_image,cover_image,display_name,description,device_id,device_type,is_verified,is_featured,facebook_screen_name,twitter_screen_name
	 					ratings,fb_followers,twitter_followers,is_page
	 * @author        : Binal Thakkar
	 * @Comment		  : Athlete OR Entourage Registration.
	**/
	public function actionUserRegistration(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		//p($data);
		if(!isset($data['data']['user_type']) && $data['data']['user_type'] == '' ||
		   !isset($data['data']['device_id']) && $data['data']['device_id'] == '' ||
		   !isset($data['data']['device_type']) && $data['data']['device_type'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
		}else{
				if(isset($data['data']['device_id']) && $data['data']['device_id'] != ''){
					$appUserDetails1 = UserDetail::model()->find("twitter_screen_name = '".$data['data']['twitter_screen_name']."'");
					if(!$appUserDetails1)
					{
					$appUserDetails = UserDetail::model()->find("device_id = '".$data['data']['device_id']."'");
					if($appUserDetails){
						$Id = $appUserDetails['user_id'];
						$modelData = $this->loadModel($Id, 'UserDetail');
						$modelData->device_id ="";
						$modelData->save(false);
						
						$model = new UserDetail();
						if(isset($data['data']['user_type']) && !empty($data['data']['user_type'])){
							$model->user_type = $data['data']['user_type'];
							$user_type=$model->user_type;
						}
						if(isset($data['data']['profile_image']) && !empty($data['data']['profile_image'])){
							$model->profile_image = $data['data']['profile_image'];
						}
						if(isset($data['data']['cover_image']) && !empty($data['data']['cover_image'])){
							$model->cover_image =$data['data']['cover_image'];
						}
						if(isset($data['data']['display_name']) && !empty($data['data']['display_name'])){
							$model->display_name = $data['data']['display_name'];
						}
						if(isset($data['data']['description']) && !empty($data['data']['description'])){
							$model->description = $data['data']['description'];
						}
						if(isset($data['data']['device_id']) && !empty($data['data']['device_id'])){
							$model->device_id = $data['data']['device_id'];
						}
						if(isset($data['data']['device_type']) && !empty($data['data']['device_type'])){
							$model->device_type = $data['data']['device_type'];
						}
						if(isset($data['data']['is_verified']) && !empty($data['data']['is_verified'])){
							$model->is_verified = $data['data']['is_verified'];
						}
						if(isset($data['data']['is_featured']) && !empty($data['data']['is_featured'])){
							$model->is_featured = $data['data']['is_featured'];
						}
						if(isset($data['data']['facebook_screen_name']) && !empty($data['data']['facebook_screen_name'])){
							$model->facebook_screen_name = $data['data']['facebook_screen_name'];
						}
						if(isset($data['data']['twitter_screen_name']) && !empty($data['data']['twitter_screen_name'])){
							$model->twitter_screen_name = $data['data']['twitter_screen_name'];
							
						}
						if(isset($data['data']['ratings']) && !empty($data['data']['ratings'])){
							$model->ratings = $data['data']['ratings'];	
						}
						if(isset($data['data']['fb_followers']) && !empty($data['data']['fb_followers'])){
							$model->fb_followers = $data['data']['fb_followers'];	
						}
						if(isset($data['data']['twitter_followers']) && !empty($data['data']['twitter_followers'])){
							$model->twitter_followers = $data['data']['twitter_followers'];	
						}
						if(isset($data['data']['is_page']) && !empty($data['data']['is_page'])){
							$model->is_page = $data['data']['is_page'];	
						}	

						if($model->save(false)){
							if($user_type==1)
							{
										$message = "A new athlete joined the roster";
							 			$pushToEntourage = UserDetail::model()->findAll('user_type IN (1,2) AND user_id NOT IN ( "'.$model->user_id.'") AND push_new_athletes IN (1)');
										// push notification when Package Called->Bronze,Silver,Platinum,Gold is selected
										foreach($pushToEntourage as $pushList)
										{
											$this->sendIphoneNotification($pushList['device_id'],$message);
										}
								
							}	
										if($model->user_type==1)
										{
											$this->sendAthleteVerification($model->user_id,$model->is_verified,$model->twitter_screen_name);
											$assignAthlete = AthleteNotification::model()->findAll();
											foreach($assignAthlete as $athlete)
											{
												$athleteId = $athlete['athlete_id'];
												$new_athlete = $athlete['new_athlete'];
												$athleteModelData = $this->loadModel($athleteId, 'AthleteNotification');
												$athleteModelData['new_athlete']=$new_athlete + 1;
												$athleteModelData->save(false);
												
											}
											
											$assignEntourage = EntourageNotification::model()->findAll();
											foreach($assignEntourage as $entourage)
											{
												$entourageId = $entourage['entourage_id'];
												$new_entourage = $entourage['new_entourage'];
												$entourageModelData = $this->loadModel($entourageId, 'EntourageNotification');
												$entourageModelData['new_entourage']=$new_entourage+1;
												$entourageModelData->save(false);
												
											}
											
											//---Simple Athlete notification---------
											$athleteNotification= new AthleteNotification();
											$athleteNotification->screen_name = $data['data']['twitter_screen_name'];
											$athleteNotification->user_id=$model->user_id;
											$athleteNotification->save(false);
											
											//-------application Athlete notification---
											
											$athleteAppNotification= new AthleteAppNotification();
											$athleteAppNotification->screen_name = $data['data']['twitter_screen_name'];
											$athleteAppNotification->user_id=$model->user_id;
											$athleteAppNotification->save(false);
											
											
											
										}elseif($model->user_type==2){
											//---Simple Entourage notification---------
											$entourageNotification = new EntourageNotification();
											$entourageNotification->screen_name = $data['data']['twitter_screen_name'];
											$entourageNotification->user_id=$model->user_id;
											$entourageNotification->save(false);
											
											//-------application Entourage notification---
											$entourageAppNotification = new EntourageAppNotification();
											$entourageAppNotification->screen_name = $data['data']['twitter_screen_name'];
											$entourageAppNotification->user_id=$model->user_id;
											$entourageAppNotification->save(false);
										}
							$response['status'] = "1";
							$response['data'] = "User Successfully Register";
							$response['user_id'] = $model->user_id;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
						}
					}else{
						
						$model = new UserDetail();
						if(isset($data['data']['user_type']) && !empty($data['data']['user_type'])){
							$model->user_type = $data['data']['user_type'];
						}
						if(isset($data['data']['profile_image']) && !empty($data['data']['profile_image'])){
							$model->profile_image = $data['data']['profile_image'];
						}
						if(isset($data['data']['cover_image']) && !empty($data['data']['cover_image'])){
							$model->cover_image = $data['data']['cover_image'];
						}
						if(isset($data['data']['display_name']) && !empty($data['data']['display_name'])){
							$model->display_name = $data['data']['display_name'];
						}
						if(isset($data['data']['description']) && !empty($data['data']['description'])){
							$model->description = $data['data']['description'];
						}
						if(isset($data['data']['device_id']) && !empty($data['data']['device_id'])){
							$model->device_id = $data['data']['device_id'];
						}
						if(isset($data['data']['device_type']) && !empty($data['data']['device_type'])){
							$model->device_type = $data['data']['device_type'];
						}
						if(isset($data['data']['is_verified']) && !empty($data['data']['is_verified'])){
							$model->is_verified = $data['data']['is_verified'];
						}
						if(isset($data['data']['is_featured']) && !empty($data['data']['is_featured'])){
							$model->is_featured = $data['data']['is_featured'];
						}
						if(isset($data['data']['facebook_screen_name']) && !empty($data['data']['facebook_screen_name'])){
							$model->facebook_screen_name = $data['data']['facebook_screen_name'];
						}
						if(isset($data['data']['twitter_screen_name']) && !empty($data['data']['twitter_screen_name'])){
							$model->twitter_screen_name = $data['data']['twitter_screen_name'];
							
						}
						if(isset($data['data']['ratings']) && !empty($data['data']['ratings'])){
							$model->ratings = $data['data']['ratings'];	
						}
						if(isset($data['data']['fb_followers']) && !empty($data['data']['fb_followers'])){
							$model->fb_followers = $data['data']['fb_followers'];	
						}
						if(isset($data['data']['twitter_followers']) && !empty($data['data']['twitter_followers'])){
							$model->twitter_followers = $data['data']['twitter_followers'];	
						}	
						if(isset($data['data']['is_page']) && !empty($data['data']['is_page'])){
							$model->is_page = $data['data']['is_page'];	
						}	

						if($model->save(false)){
							if($user_type==1)
							{
										$message = "A new athlete joined the roster";
							 			$pushToEntourage = UserDetail::model()->findAll('user_type IN (1,2) AND user_id NOT IN ( "'.$model->user_id.'") AND push_new_athletes IN (1)');
										// push notification when Package Called->Bronze,Silver,Platinum,Gold is selected
										foreach($pushToEntourage as $pushList)
										{
											$this->sendIphoneNotification($pushList['device_id'],$message);
										}
								}		
										if($model->user_type==1)
										{
											$this->sendAthleteVerification($model->user_id,$model->is_verified,$model->twitter_screen_name);
											$assignAthlete = AthleteNotification::model()->findAll();
											foreach($assignAthlete as $athlete)
											{
												$athleteId = $athlete['athlete_id'];
												$new_athlete = $athlete['new_athlete'];
												$athleteModelData = $this->loadModel($athleteId, 'AthleteNotification');
												$athleteModelData['new_athlete']=$new_athlete + 1;
												$athleteModelData->save(false);
												
											}
											
											$assignEntourage = EntourageNotification::model()->findAll();
											foreach($assignEntourage as $entourage)
											{
												$entourageId = $entourage['entourage_id'];
												$new_entourage = $entourage['new_entourage'];
												$entourageModelData = $this->loadModel($entourageId, 'EntourageNotification');
												$entourageModelData['new_entourage']=$new_entourage+1;
												$entourageModelData->save(false);
												
											}
											
											//---Simple Athlete notification---------
											$athleteNotification= new AthleteNotification();
											$athleteNotification->screen_name = $data['data']['twitter_screen_name'];
											$athleteNotification->user_id=$model->user_id;
											$athleteNotification->save(false);
											
											//-------application Athlete notification---
											
											$athleteAppNotification= new AthleteAppNotification();
											$athleteAppNotification->screen_name = $data['data']['twitter_screen_name'];
											$athleteAppNotification->user_id=$model->user_id;
											$athleteAppNotification->save(false);
											
											
											
										}elseif($model->user_type==2){
											//---Simple Entourage notification---------
											$entourageNotification = new EntourageNotification();
											$entourageNotification->screen_name = $data['data']['twitter_screen_name'];
											$entourageNotification->user_id=$model->user_id;
											$entourageNotification->save(false);
											
											//-------application Entourage notification---
											$entourageAppNotification = new EntourageAppNotification();
											$entourageAppNotification->screen_name = $data['data']['twitter_screen_name'];
											$entourageAppNotification->user_id=$model->user_id;
											$entourageAppNotification->save(false);
										}
							$response['status'] = "1";
							$response['data'] = "User Successfully Registered.";
							$response['user_id'] = $model->user_id;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
						}
					}
					}
				else{
					$response['status'] = "0";
					$response['data'] = "Twitter Screen Name Already exist";
					echo json_encode($response);
					exit();}
				}else{
					$response['status'] = "0";
					$response['data'] = "DeviceToken can not be blank.";
					echo json_encode($response);
					exit();
				}
		}
	}
		public function sendAthleteVerification($user_id,$is_verified,$twitter_screen_name)
		{
			
				$path=  Yii::app()->getBaseUrl(true);
				$url=$path.'/admin/login?user_id='.$user_id;
				setcookie("verification",$url, time()+3600*24,'/demo/roster/admin/login');
				$to = "db@doctorburke.net";
				$subject = "The Roster Network App Verification";
				$txt = "Dear Admin,\r\n\n";
				$txt .= "Please verify the $twitter_screen_name from this link.\r\n\n";
				$txt .= $url;
				$headers = "db@therosternetwork.com";
					
			$mail=	mail($to,$subject,$txt,"From: $headers");
			return $mail;
		}
		
		/**
	 * @Method		  :	POST
	 * @Params		  : user_id,first_name,last_name,password,email,phone_number
	 * @author        : Binal Thakkar
	 * @Comment		  : Update User Detail to add first_name,last_name,password,email,phone_number.
	**/
public function actionUserDetailUpdate()
{
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['user_id']) && $data['data']['user_id'] == ''||
		!isset($data['data']['first_name']) && $data['data']['first_name'] == ''||
		!isset($data['data']['last_name']) && $data['data']['last_name'] == ''||
		!isset($data['data']['password']) && $data['data']['password'] == ''||
		!isset($data['data']['email']) && $data['data']['email'] == ''||
		!isset($data['data']['phone_number']) && $data['data']['phone_number'] == ''){
					$response['status'] = "0";
					$response['data'] = "Please pass the Twitter Screen Name.";
					echo json_encode($response);
					exit();
		}else{	
			$userDetailUpdate = UserDetail::model()->find("user_id = '".$data['data']['user_id']."'");
				if($userDetailUpdate){
						$user_id = $userDetailUpdate['user_id'];
						$modelData = $this->loadModel($user_id, 'UserDetail');
						if(isset($data['data']['first_name']) && !empty($data['data']['first_name'])){
							$modelData->first_name = $data['data']['first_name'];
						}
						if(isset($data['data']['last_name']) && !empty($data['data']['last_name'])){
							$modelData->last_name = $data['data']['last_name'];
						}
						if(isset($data['data']['password']) && !empty($data['data']['password'])){
							$modelData->password = md5($data['data']['password']);
						}
						if(isset($data['data']['email']) && !empty($data['data']['email'])){
							$modelData->email = $data['data']['email'];
						}
						if(isset($data['data']['phone_number']) && !empty($data['data']['phone_number'])){
							$modelData->phone_number = $data['data']['phone_number'];
						}
						if($modelData->save(false)){
							
							$response['status'] = "1";
							$response['data'] = "User Successfully updated.";
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
						}
			}else{
							$response['status'] = "0";
							$response['data'] = "User_id does not match.";
							echo json_encode($response);
							exit();	
			}
		}	
}
/**
	 * @Method		  :	GET
	 * @Params		  : user_id
	 * @author        : Binal Thakkar
	 * @Comment		  : To fetch the records of particular user using user_id
	**/
public function actionGetUserDetails(){
		$response=array();	
		$u_id=$_REQUEST['user_id'];
		if(isset($u_id))
		{
						$userData = new UserDetail();		
						$response = $userData->getUserDetail($u_id);
						echo json_encode($response);
						exit();
					}else{
						$response['status']='0';
						$response['data'] = "please pass the user id";
						echo json_encode($response);
						exit();
		}
	}
	/**
	 * @Method		  :	POST
	 * @Params		  : email,twitter_screen_name,message
	 * @author        : Binal Thakkar
	 * @Comment		  : Send mail with attaching the Image
	**/
public function actionMailSent()
	{
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		
		if(!isset($data['data']['email']) && $data['data']['email'] == ''||
		!isset($data['data']['twitter_screen_name']) && $data['data']['twitter_screen_name'] == ''||
			!isset($data['data']['message']) && $data['data']['message'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
		}else{
			if(isset($data['data']['email']) && ($data['data']['message']) )
			{
				// Mail Sent With Attachment
				$image=$data['data']['image'];
				$email=$data['data']['email'];
				$message=$data['data']['message'];
				$screenName=$data['data']['twitter_screen_name'];
				$subject = 'Support to @'.$screenName."\r\n";
				if($image!="")
				{
				$path = YiiBase::getPathOfAlias('webroot');
				$file = $path . "/upload/support_directory/" . $image;
			    $file_size = filesize($file);
			    $handle = fopen($file, "r");
			    $content = fread($handle, $file_size);
			    fclose($handle);
			    $content = chunk_split(base64_encode($content));
			
			    // a random hash will be necessary to send mixed content
			    $separator = md5(time());
			
			    // carriage return type (we use a PHP end of line constant)
			    $eol = PHP_EOL;
			
			    // main header (multipart mandatory)
			    $headers = "From: ROSTER <roster@roster.com>" . $eol;
			    $headers .= "MIME-Version: 1.0" . $eol;
			    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
			    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
			    $headers .= "This is a MIME encoded message." . $eol . $eol;
			
			    // message
			    $headers .= "--" . $separator . $eol;
			    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
			    $headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
			    $headers .= $message . $eol . $eol;
			
			    // attachment
			    $headers .= "--" . $separator . $eol;
			    $headers .= "Content-Type: application/octet-stream; name=\"" . $image . "\"" . $eol;
			    $headers .= "Content-Transfer-Encoding: base64" . $eol;
			    $headers .= "Content-Disposition: attachment" . $eol . $eol;
			    $headers .= $content . $eol . $eol;
			    $headers .= "--" . $separator . "--";
			    }
			
			    //SEND Mail
			     if (mail($email,$subject,$message,$headers)) {
				     	$response['status']='1';
						$response['data'] = "mail send ... OK";
						echo json_encode($response);
						exit();
			      } else {
			      		$response['status']='0';
						$response['data'] = "mail send ... ERROR!";
						echo json_encode($response);
						exit();
			      }
				// End Mail Attachment	
					
			}
	}
	}
	/**
	 * @Method		  :	POST
	 * @Params		  : twitter_screen_name,device_id
	 * @author        : Binal Thakkar
	 * @Comment		  : Check User is Registered OR not
	**/
public function actionCheckUserLogin()
{		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['twitter_screen_name']) && $data['data']['twitter_screen_name'] == '' ||
		!isset($data['data']['device_id']) && $data['data']['device_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Please pass the Twitter Screen Name.";
					echo json_encode($response);
					exit();
		}else{	
			$twitterData = UserDetail::model()->find("twitter_screen_name = '".$data['data']['twitter_screen_name']."'");
			if($twitterData)
			{
				$appUserDetails = UserDetail::model()->find("device_id = '".$data['data']['device_id']."'");
					if($appUserDetails){
						$Id = $appUserDetails['user_id'];
						$modelData = $this->loadModel($Id, 'UserDetail');
						$modelData->device_id ="";
						$modelData->save(false);
						$twitterData->device_id=$data['data']['device_id'];
						$twitterData->save(false);
						
						$response['status'] = "1";
						$response['user_id'] = $twitterData->user_id;
						$response['display_name'] = $twitterData->display_name;
						$response['description'] = $twitterData->description;
						$response['user_type'] = $twitterData->user_type;
							if($response['user_type']== 1)
							{
							$athleteNoti = AthleteNotification::model()->find("screen_name = '".$data['data']['twitter_screen_name']."'");
							$response['campaign']=$athleteNoti->campaign;
							$response['new_athlete']=$athleteNoti->new_athlete;
							$response['post_to_exchange']=$athleteNoti->post_to_exchange;
							}elseif($response['user_type']== 2)
							{
							$entourageNoti = EntourageNotification::model()->find("screen_name = '".$data['data']['twitter_screen_name']."'");
							$response['new_entourage']=$entourageNoti->new_entourage;
							$response['post_to_exchange']=$entourageNoti->post_to_exchange;
							}
						$response['profile_image'] = $twitterData->profile_image;
						$response['cover_image'] = $twitterData->cover_image;
						$response['device_id'] = $twitterData->device_id;
						$response['device_type'] = $twitterData->device_type;
						$response['push_score_change'] = $twitterData->push_score_change;
						$response['push_get_contacted'] = $twitterData->push_get_contacted;
						$response['push_new_exchanges'] = $twitterData->push_new_exchanges;
						$response['push_new_athletes'] = $twitterData->push_new_athletes;
						$response['is_verified'] = $twitterData->is_verified;
						$response['is_featured'] = $twitterData->is_featured;
						$response['is_delete'] = $twitterData->is_delete;
						$response['facebook_screen_name'] = $twitterData->facebook_screen_name;
						$response['twitter_screen_name'] = $twitterData->twitter_screen_name;
						$response['ratings'] = $twitterData->ratings;
						$response['impact_score'] = $twitterData->impact_score;
						$response['fb_followers'] = $twitterData->fb_followers;
						$response['twitter_followers'] = $twitterData->twitter_followers;
						$response['is_page'] = $twitterData->is_page;
						$response['data'] = "User Already Registered";
						echo json_encode($response);
						exit();
						
					}else{
				//p($twitterData->display_name);
					$twitterData->device_id=$data['data']['device_id'];
					$twitterData->save(false);
					$response['status'] = "1";
					$response['user_id'] = $twitterData->user_id;
					$response['display_name'] = $twitterData->display_name;
					$response['description'] = $twitterData->description;
					$response['user_type'] = $twitterData->user_type;
					
						if($response['user_type']== 1)
						{
						$athleteNoti = AthleteNotification::model()->find("screen_name = '".$data['data']['twitter_screen_name']."'");
							$response['campaign']=$athleteNoti->campaign;
							$response['new_athlete']=$athleteNoti->new_athlete;
							$response['post_to_exchange']=$athleteNoti->post_to_exchange;
						}elseif($response['user_type']== 2)
						{
						$entourageNoti = EntourageNotification::model()->find("screen_name = '".$data['data']['twitter_screen_name']."'");
						$response['new_entourage']=$entourageNoti->new_entourage;
						$response['post_to_exchange']=$entourageNoti->post_to_exchange;
						}
					$response['profile_image'] = $twitterData->profile_image;
					$response['cover_image'] = $twitterData->cover_image;
					$response['device_id'] = $twitterData->device_id;
					$response['device_type'] = $twitterData->device_type;
					$response['push_score_change'] = $twitterData->push_score_change;
					$response['push_get_contacted'] = $twitterData->push_get_contacted;
					$response['push_new_exchanges'] = $twitterData->push_new_exchanges;
					$response['push_new_athletes'] = $twitterData->push_new_athletes;
					$response['is_verified'] = $twitterData->is_verified;
					$response['is_featured'] = $twitterData->is_featured;
					$response['is_delete'] = $twitterData->is_delete;
					$response['facebook_screen_name'] = $twitterData->facebook_screen_name;
					$response['twitter_screen_name'] = $twitterData->twitter_screen_name;
					$response['ratings'] = $twitterData->ratings;
					$response['impact_score'] = $twitterData->impact_score;
					$response['fb_followers'] = $twitterData->fb_followers;
					$response['twitter_followers'] = $twitterData->twitter_followers;
					$response['is_page'] = $twitterData->is_page;
					$response['data'] = "User Already Registered";
					echo json_encode($response);
					exit();
					}	
		}else{
			$response['status'] = "0";
					$response['data'] = "New User";
					echo json_encode($response);
					exit();
			}
		}	
}

	/**
	 * @Method		  :	POST
	 * @Params		  : twitter_screen_name
	 * @author        : Binal Thakkar
	 * @Comment		  :  To Check USer Exist OR not
	**/
public function actionCheckUserExist()
{
		$res = array();
		$response=array();
		$getData = array();
		$twitterData = array();
		$data1 = json_decode(file_get_contents('php://input'), TRUE);
		$arr=array();
		if(!isset($data1) && $data1== ''){
					$response['status'] = "0";
					$response['data'] = "Please pass the Twitter Screen Name.";
					echo json_encode($response);
					exit();
		}else{
				for ($i=0; $i <count($data1['data']) ; $i++) {
					$res['twitter_screen_name']=$data1['data'][$i]['twitter_screen_name'];
					$twitterData = UserDetail::model()->find("twitter_screen_name = '".$data1['data'][$i]['twitter_screen_name']."'");
					if($twitterData){
						$res['isMember'] = "1";
						$res['is_delete']=$twitterData['is_delete'];
					}else{
						$res['isMember'] = "0";
						$res['is_delete']=$twitterData['is_delete'];
					}
					$response[] = $res;
				 }
				 if($response){
				 	$getData['data']=$response;
				 	echo json_encode($getData);
					exit();
				 }else{
				 			$getData['status'] = "0";
							$getData['data'] = "No Data Available. ";
							echo json_encode($getData);
							exit();
				 }	
		}	
}

	/**
	 * @Method		  :	POST
	 * @Params		  : campaign_id
	 * @author        : Binal Thakkar
	 * @Comment		  :  To Delete Campaign completely from all the tables
	**/
public function actionDeleteCampaign(){
		$res = array();
		$response=array();	
		$camp_id=$_REQUEST['campaign_id'];
		$post_id=$_REQUEST['postexchange_id'];
		if(isset($camp_id))
		{
			$campDel=Campaign::model()->find("campaign_id = '".$camp_id."'"); 
			$campDel->delete();
			
			$mediaDel=Media::model()->findAll("campaign_id = '".$camp_id."'"); 
			foreach($mediaDel as $mediaData)
			{
			$mediaData->delete();
			}
			$postToExchangeDel=PostToExchange::model()->find("campaign_id = '".$camp_id."'"); 
			$postToExchangeDel->delete();
			
			$transactionDel=Transaction::model()->find("campaign_id = '".$camp_id."'"); 
			$transactionDel->delete();
			
			if($campDel && $mediaData && $postToExchangeDel && $transactionDel)
			{
					$response['status'] = "1";
					$response['data'] = "Campaign Successfully deleted.";
					echo json_encode($response);
					exit();
			}else{
					$response['status'] = "0";
					$response['data'] = "Fail to delete campaign.";
					echo json_encode($response);
					exit();
			}
		}elseif(isset($post_id)){
			$postDel=PostToExchange::model()->find("postexchange_id = '".$post_id."'"); 
			$postDel->delete();
					if($postDel)
					{
							$response['status'] = "1";
							$response['data'] = "POst to exchange Successfully deleted.";
							echo json_encode($response);
							exit();
					}else{
							$response['status'] = "0";
							$response['data'] = "Fail to delete POst to exchange.";
							echo json_encode($response);
							exit();
					}
			
			
			
		}else{
						$response['status']='0';
						$response['data'] = "Please pass the camp Id oR post to exchange Id";
						echo json_encode($response);
						exit();
		}
	}

	/**
	 * @Method		  :	 POST
	 * @Params		  :  email,message
	 * @author        :  Binal Thakkar
	 * @Comment		  :  To invite user via email
	**/
// to send the invitation via email
public function actionInvitation()
	{
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		
		if(!isset($data['data']['email']) && $data['data']['email'] == ''||
			!isset($data['data']['message']) && $data['data']['message'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
		}else{
			if(isset($data['data']['email']) && ($data['data']['message']) )
			{
				$email=$data['data']['email'];
				$message=$data['data']['message'];
				$headers = 'Invite from The Roster Network App' . "\r\n";
				$mail = mail($email,$headers,$message);
				if($mail)
					{
						$response['status']='1';
						$response['data'] = "mail sent";
						echo json_encode($response);
						exit();
					}	
				else
					{
						$response['status']='0';
						$response['data'] = "Error in sending mail";
						echo json_encode($response);
						exit();
					}
			}
	}
}
		// To get All Campaign List
public function actionListOfCampaign(){
		$res = array();
		$response=array();	
		$u_id=$_REQUEST['user_id'];
		if(isset($u_id))
		{
			$campaignData = new Campaign();
			$response = $campaignData->getListofCampaign($u_id);
			header('Content-type:application/json');
			echo CJSON::encode($response);
			exit();	
		}else{
						$response['status']='0';
						$response['data'] = "Please pass the user Id";
						echo json_encode($response);
						exit();
		}
	}
		// To get All Campaign Social POst

public function actionListOfCampaignSocialPost(){
		$response=array();	
		$campaign_id=$_REQUEST['campaign_id'];
		if(isset($campaign_id))
		{
		$socialData = new SocialPosts();
		$response = $socialData->getListofSocialData($campaign_id);
		header('Content-type:application/json');
		echo CJSON::encode($response);
		exit();	
		}else{
						$response['status']='0';
						$response['data'] = "Please pass the Campaign Id";
						echo json_encode($response);
						exit();
		}
	}

// List of Campaign Partner Data
public function actionCampaignPartnerData(){
		$response=array();	
		$type=$_REQUEST['twitter_screen_name'];
		if(isset($type))
		{
		$campaignData = new Campaign();
		$response = $campaignData->getCampaignPartnerData($type);
	//	header('Content-type:application/json');
		echo json_encode($response);
		exit();
		}else{
						$response['status']='0';
						$response['data'] = "Please pass the Twitter Screen Name";
						echo json_encode($response);
						exit();
		}	
	}
	
	
	//List of Featured OR Verified Athlete
			
			
	public function actionListOfFeaturedUser()
	{
		$response=array();
		$type=$_REQUEST['type'];
		$user_id=$_REQUEST['user_id'];
		if(isset($type) && isset($user_id))
		{
		$userDetailData = new UserDetail();
		$response = $userDetailData->ListOfFeaturedUser($type,$user_id);
		header('Content-type:application/json');
		echo json_encode($response);
		exit();	
		}else{
						$response['status']='0';
						$response['data'] = "Please pass the user Type with user id";
						echo json_encode($response);
						exit();
		}
	}
	

// push notification for user settings
		public function actionUserPushSettings(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['twitter_screen_name']) && $data['data']['twitter_screen_name'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
		}else{	
			$pushData = UserDetail::model()->find("twitter_screen_name = '".$data['data']['twitter_screen_name']."'");
			if($pushData)
			{
			$pushId = $pushData['user_id'];
			$pushListData = $this->loadModel($pushId, 'UserDetail');
			if(isset($data['data']['push_score_change']) && $data['data']['push_score_change'] != "" ){
				$pushListData->push_score_change = $data['data']['push_score_change'];
			}
			if(isset($data['data']['push_get_contacted']) && $data['data']['push_get_contacted'] != "" ){
				$pushListData->push_get_contacted = $data['data']['push_get_contacted'];
			}
			if(isset($data['data']['push_new_exchanges']) && $data['data']['push_new_exchanges'] != "" ){
				$pushListData->push_new_exchanges = $data['data']['push_new_exchanges'];
			}
			if(isset($data['data']['push_new_athletes']) && $data['data']['push_new_athletes'] != ""){
				$pushListData->push_new_athletes = $data['data']['push_new_athletes'];
			}
			if(isset($data['data']['display_name']) && $data['data']['display_name'] != "" ){
				$pushListData->display_name = $data['data']['display_name'];
			}
			if(isset($data['data']['description']) && $data['data']['description'] != ""){
				$pushListData->description = $data['data']['description'];
			}
			if(isset($data['data']['cover_image']) && !empty($data['data']['cover_image'])){
			$pushListData->cover_image = $data['data']['cover_image'];
			}
			if(isset($data['data']['profile_image']) && !empty($data['data']['profile_image'])){
			$pushListData->profile_image = $data['data']['profile_image'];
			}
			if($pushListData->save(false)){
				
					$response['status'] = "1";
					$response['data'] = "Setting Successfully Updated.";
					$response['push_score_change'] = $pushListData->push_score_change;
					$response['push_get_contacted'] = $pushListData->push_get_contacted;
					$response['push_new_exchanges'] = $pushListData->push_new_exchanges;
					$response['push_new_athletes'] = $pushListData->push_new_athletes;
					$response['display_name'] = $pushListData->display_name;
					$response['description'] = $pushListData->description;
					echo json_encode($response);
					exit();
			}else{
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}	
		}else{
			$response['status'] = "0";
					$response['data'] = "User Id not found";
					echo json_encode($response);
					exit();
			}
		}
	}

// Save Post for Athlete
			///////////////////-----------15/5/2014-----------------///////////
		public function actionSavePostToExchange(){
		$res = array();
		$response=array();
		$athleteMessage="An athlete posted an exchange";
		$entourageMessage="An entourage posted an exchange";
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['message']) && $data['data']['message'] == '' ||
		   !isset($data['data']['user_id']) && $data['data']['user_id'] == '' ||
		   !isset($data['data']['user_type']) && $data['data']['user_type'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
				}else{
						if(isset($data['data']['message']) && $data['data']['message'] != ''){
						$appcampDetails = PostToExchange::model()->find("postexchange_id = '".$data['data']['postexchange_id']."'");
						if($appcampDetails){
							$response['status'] = "0";
							$response['data'] = "The User of this ID is already registered.";
							echo json_encode($response);
							exit();
					}else{
						$userType=$data['data']['user_type'];
						if($userType==1)
						{
						$model = new PostToExchange();
						if(isset($data['data']['message']) && !empty($data['data']['message'])){
							$model->message = $data['data']['message'];
						}
						if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
							$model->user_id = $data['data']['user_id'];
							$athleteUserId=$data['data']['user_id'];
						}
						if(isset($data['data']['user_type']) && !empty($data['data']['user_type'])){
							$model->user_type = $data['data']['user_type'];
						}
						if(isset($data['data']['post_type']) && !empty($data['data']['post_type'])){
							$model->post_type = $data['data']['post_type'];
						}
						if(isset($data['data']['cost']) && !empty($data['data']['cost'])){
							$model->cost = $data['data']['cost'];											
						}
						if(isset($data['data']['is_paid']) && !empty($data['data']['is_paid'])){
							$model->is_paid = $data['data']['is_paid'];										
						}
						    $model->start_date = date('Y/m/d H:i:s');
						    $model->end_date = date('Y/m/d H:i:s' , strtotime($model->start_date . '+7 day'));
						
							//$model->end_date = $data['data']['end_date'];

						if($model->save(false)){
								$pushToEntourage=UserDetail::model()->findAll('user_type= 2 AND push_new_exchanges IN(1)');
								// push notification when atlete do PTE and notification goes to all entourage user of the system
								foreach($pushToEntourage as $pushList)
								{
									$entBadge = EntourageAppNotification::model()->find("screen_name ='".$pushList['twitter_screen_name']."'");
									$this->sendIphoneNotification($pushList['device_id'],$athleteMessage,$entBadge['badge']);
								}
								
								///----------Simple Notification-------
								$entourageNoti=EntourageNotification::model()->findAll();
									foreach($entourageNoti as $notiList)
									{
										$engid = $notiList['entourage_id'];
										$engData = $this->loadModel($engid, 'EntourageNotification');
										$badge = ($engData['post_to_exchange']+1);
										$engData->post_to_exchange = 	$badge;
										$engData->save(false);
									}	
							//---------- App level Noti---------
									$entourageAppNoti=EntourageAppNotification::model()->findAll();
									foreach($entourageAppNoti as $notiAppList)
									{
										$engAppid = $notiAppList['ent_app_id'];
										$engAppData = $this->loadModel($engAppid, 'EntourageAppNotification');
										$badgeApp = ($engAppData['badge']+1);
										$engAppData->badge = 	$badgeApp;
										$engAppData->save(false);
									}

							//------ Notification to Athlete
								$userScreenName = UserDetail::model()->find('user_id="'.$athleteUserId.'"');
								$screenname=$userScreenName['twitter_screen_name'];
								$pushToAthlete=UserDetail::model()->findAll('user_type= 1 AND push_new_exchanges IN(1) AND user_id NOT IN("'.$athleteUserId.'")');
								// push notification when entourage do PTE and notification goes to all athlete user of the system
								foreach($pushToAthlete as $pushListAthlete)
								{
									$antBadge = AthleteAppNotification::model()->find("screen_name ='".$pushListAthlete['twitter_screen_name']."'");
									$this->sendIphoneNotification($pushListAthlete['device_id'],$athleteMessage,$antBadge['badge']);
								}
								$athleteNoti=AthleteNotification::model()->findAll('screen_name NOT IN("'.$screenname.'")');
								foreach($athleteNoti as $atheList)
								{
									$antid = $atheList['athlete_id'];
									$antData = $this->loadModel($antid, 'AthleteNotification');
									$badge = ($antData['post_to_exchange']+1);
									$antData->post_to_exchange = 	$badge;
									$antData->save(false);
								}	
									//---------- App level Notification---------
									$athleteAppNoti=AthleteAppNotification::model()->findAll('screen_name NOT IN("'.$screenname.'")');
									foreach($athleteAppNoti as $notiAppList)
									{
										$athAppid = $notiAppList['ath_app_id'];
										$athAppData = $this->loadModel($athAppid, 'AthleteAppNotification');
										$badgeApp = ($athAppData['badge']+1);
										$athAppData->badge = 	$badgeApp;
										$athAppData->save(false);
									}
							
							
							//----- End----
							$postToExchangeId=$model->postexchange_id;
							
							for ($i=0; $i <count($data['data']['media']) ; $i++) 
										{
											$model2 = new Media(); 
											
										if(isset($data['data']['media'][$i]['file_name']) && !empty($data['data']['media'][$i]['file_name'])){
										$model2->file_name = $data['data']['media'][$i]['file_name'];
										}
										if(isset($data['data']['media'][$i]['media_type']) && !empty($data['data']['media'][$i]['media_type'])){
										$model2->media_type = $data['data']['media'][$i]['media_type'];
										}
										if(isset($postToExchangeId) && !empty($postToExchangeId)){
											$id[$i]=$postToExchangeId;
											
										$model2->postexchange_id = $id[$i];
										}
										if($model2->save(false)){
											$res=$model2;
										}
										}
										//p($res);
										if($model){
											
											$response['status'] = "1";
											$response['postexchange_id']=$postToExchangeId;
											$response['data'] = "Athlete Post Successfully added.";
											echo json_encode($response);
											exit();
										}else{
											$response['status'] = "0";
											$response['data'] = "Fail to add Athlete Post.";
											echo json_encode($response);
											exit();
											}
										
						
						
						}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
						}
					}elseif($userType==2)
						{
						$model = new PostToExchange();
						if(isset($data['data']['message']) && !empty($data['data']['message'])){
							$model->message = $data['data']['message'];
						}
						if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
							$model->user_id = $data['data']['user_id'];
						}
						if(isset($data['data']['user_type']) && !empty($data['data']['user_type'])){
							$model->user_type = $data['data']['user_type'];
						}
						if(isset($data['data']['post_type']) && !empty($data['data']['post_type'])){
							$model->post_type = $data['data']['post_type'];
						}
						if(isset($data['data']['start_date']) && !empty($data['data']['start_date'])){
							$model->start_date = $data['data']['start_date'];
						}
						if(isset($data['data']['end_date']) && !empty($data['data']['end_date'])){
							$model->end_date = $data['data']['end_date'];
						}
						if(isset($data['data']['cost']) && !empty($data['data']['cost'])){
							$model->cost = $data['data']['cost'];
																		
						}
						if($model->save(false)){

								
							$postToExchangeId=$model->postexchange_id;
							
							for ($i=0; $i <count($data['data']['media']) ; $i++) 
										{
											$model2 = new Media(); 
											
										if(isset($data['data']['media'][$i]['file_name']) && !empty($data['data']['media'][$i]['file_name'])){
										$model2->file_name = $data['data']['media'][$i]['file_name'];
										}
										if(isset($data['data']['media'][$i]['media_type']) && !empty($data['data']['media'][$i]['media_type'])){
										$model2->media_type = $data['data']['media'][$i]['media_type'];
										}
										if(isset($postToExchangeId) && !empty($postToExchangeId)){
											$id[$i]=$postToExchangeId;
											
										$model2->postexchange_id = $id[$i];
										}
										if($model2->save(false)){
											$res=$model2;
										}
										}
										//p($res);
										if($model){
											
											$response['status'] = "1";
											$response['postexchange_id']=$postToExchangeId;
											$response['data'] = "Entourage Post Successfully added.";
											echo json_encode($response);
											exit();
										}else{
											$response['status'] = "0";
											$response['data'] = "Fail to add Athlete Post.";
											echo json_encode($response);
											exit();
											}
										
						
						
						}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
						}
				}
					
				}
		
		
		}
		}
		}
	
		// Edit Post to exchange
		public function actionEditPostToExchange(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['postexchange_id']) && $data['data']['postexchange_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
				}else{
						if(isset($data['data']['postexchange_id']) && $data['data']['postexchange_id'] != ''){
						$appPostDetails = PostToExchange::model()->find("postexchange_id = '".$data['data']['postexchange_id']."'");
						if($appPostDetails){
							$id = $appPostDetails['postexchange_id'];
							$model = $this->loadModel($id, 'PostToExchange');
						if(isset($data['data']['message']) && !empty($data['data']['message'])){
							$model->message = $data['data']['message'];
						}
						if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
							$model->user_id = $data['data']['user_id'];
						}
						if(isset($data['data']['user_type']) && !empty($data['data']['user_type'])){
							$model->user_type = $data['data']['user_type'];
						}
						if(isset($data['data']['post_type']) && !empty($data['data']['post_type'])){
							$model->post_type = $data['data']['post_type'];
						}
						if(isset($data['data']['start_date']) && !empty($data['data']['start_date'])){
							$model->start_date = $data['data']['start_date'];
						}
						if(isset($data['data']['end_date']) && !empty($data['data']['end_date'])){
							$model->end_date = $data['data']['end_date'];
						}
						if(isset($data['data']['cost']) && !empty($data['data']['cost'])){
							$model->cost = $data['data']['cost'];
																		
						}
						if($model->save(false)){
							
							$postToExchangeId=$model->postexchange_id;		
												$i = 0;	
												$appmediaDetails = Media::model()->findAll("postexchange_id = '".$postToExchangeId."'");
												if($appmediaDetails){
															foreach ($appmediaDetails as $appmediaList) {
																$mediaId = $appmediaList['media_id'];
																$mediaData = $this->loadModel($mediaId, 'Media');
																
																if(isset($data['data']['media'][$i]['media_type']) && !empty($data['data']['media'][$i]['media_type'])){
																	$mediaData->media_type = $data['data']['media'][$i]['media_type'];	
																}
																if(isset($data['data']['media'][$i]['file_name']) && !empty($data['data']['media'][$i]['file_name'])){
																	$mediaData->file_name = $data['data']['media'][$i]['file_name'];	
																}
																if(isset($postToExchangeId) && !empty($postToExchangeId)){
																	$mediaData->postexchange_id = $postToExchangeId;	
																	
																}
																$mediaData->save(false);
																$i++;	
															}	
													}
										
										
										//p($res);
										if($model){
											
											$response['status'] = "1";
											$response['postexchange_id']=$postToExchangeId;
											$response['data'] = "Entourage Post Successfully updated.";
											echo json_encode($response);
											exit();
										}else{
											$response['status'] = "0";
											$response['data'] = "Fail to add Athlete Post.";
											echo json_encode($response);
											exit();
											}
						}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
						}
				}
				}
		}
		
		}

// Add Campaign
public function actionAddCampaign(){
		$res = array();
		$res1 = array();
		$res2= array();
		$response=array();
		$message="A message campaign is ready";
		$getData=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['campaign_message']) && $data['data']['campaign_message'] == '' ||
		  !isset($data['data']['post_to_exchange']) && $data['data']['post_to_exchange'] == ''||
		  !isset($data['data']['user_id']) && $data['data']['user_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
					}else{
						if(isset($data['data']['campaign_message']) && $data['data']['campaign_message'] != ''){
						$appcampDetails = Campaign::model()->find("campaign_id = '".$data['data']['campaign_id']."'");
						if($appcampDetails){
							$response['status'] = "0";
							$response['data'] = "The User of this ID is already registered.";
							echo json_encode($response);
							exit();
						}else{
								// Campaign Model	
								$model = new Campaign();
								if(isset($data['data']['campaign_message']) && !empty($data['data']['campaign_message'])){
									$model->compaign_message = $data['data']['campaign_message'];
								}
								if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
									$model->user_id = $data['data']['user_id'];
								}
								if(isset($data['data']['post_to_exchange']) && !empty($data['data']['post_to_exchange'])){
									$model->post_to_exchange = $data['data']['post_to_exchange'];
									$post_to_exchange=$data['data']['post_to_exchange'];
								}
								if(isset($data['data']['total_cost']) && !empty($data['data']['total_cost'])){
									$model->total_cost = $data['data']['total_cost'];
								}
								if(isset($data['data']['is_campaign']) && !empty($data['data']['is_campaign'])){
									$model->is_campaign = $data['data']['is_campaign'];	
									$is_camp = $model->is_campaign;
								}
								if(isset($data['data']['package_name']) && !empty($data['data']['package_name'])){
									$model->package_name = $data['data']['package_name'];	
									$campPackage=$model->package_name;
								}
								if(isset($data['data']['package_followers']) && !empty($data['data']['package_followers'])){
									$model->package_followers = $data['data']['package_followers'];	
									$model->followers_bal = $data['data']['package_followers'];	
								}
								if(isset($data['data']['is_close']) && !empty($data['data']['is_close'])){
									$model->is_close = $data['data']['is_close'];	
								}														
								// Save above data in Campaign table
								if($model->save(false)){

									
								$campaignId=$model->campaign_id;
									if(isset($data['data']['media']))
										{
											for ($i=0; $i <count($data['data']['media']) ; $i++) 
											{
												$model1 = new Media();
															if(isset($data['data']['media'][$i]['media_type']) && !empty($data['data']['media'][$i]['media_type'])){
															$model1->media_type = $data['data']['media'][$i]['media_type'];	
															}
															if(isset($data['data']['media'][$i]['file_name']) && !empty($data['data']['media'][$i]['file_name'])){
															$model1->file_name = $data['data']['media'][$i]['file_name'];	
																
															}
															if(isset($campaignId) && !empty($campaignId)){	
															$id[$i]=$campaignId;
															$model1->campaign_id = $id[$i];	
															}
															($model1->save(false));
													}
								}
															if(isset($data['data']['partner_data']))
															{
																					
																for ($j=0; $j <count($data['data']['partner_data']) ; $j++) 
																	{ 
																		// Campaign Partner Model for multiple Campaign Partners 
																		$model2= new CampaignPartner;
																		if(isset($campaignId) && !empty($campaignId)){
																		$model2->campaign_id = $campaignId;	
																		}
																		if(isset($data['data']['partner_data'][$j]['twitter_screen_name']) && !empty($data['data']['partner_data'][$j]['twitter_screen_name'])){
																		$model2->twitter_screen_name = $data['data']['partner_data'][$j]['twitter_screen_name'];	
																			//p($model2->twitter_screen_name,0);
																			
																		}
																		if(isset($data['data']['partner_data'][$j]['twitter_screen_name']) && !empty($data['data']['partner_data'][$j]['twitter_screen_name'])){
																			$twitterData = UserDetail::model()->find("twitter_screen_name = '".$data['data']['partner_data'][$j]['twitter_screen_name']."'");
																			if($twitterData)
																				{
																					$model2->is_member = 1;
																				}
																			else {
																				$model2->is_member = 0;
																			}
																		}
																		if(isset($data['data']['partner_data'][$j]['impact_score']) && !empty($data['data']['partner_data'][$j]['impact_score'])){
																		$model2->impact_score = $data['data']['partner_data'][$j]['impact_score'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['price']) && !empty($data['data']['partner_data'][$j]['price'])){
																		$model2->price = $data['data']['partner_data'][$j]['price'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['reach']) && !empty($data['data']['partner_data'][$j]['reach'])){
																		$model2->reach = $data['data']['partner_data'][$j]['reach'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['fb_post_id']) && !empty($data['data']['partner_data'][$j]['fb_post_id'])){
																		$model2->fb_post_id = $data['data']['partner_data'][$j]['fb_post_id'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['twitter_post_id']) && !empty($data['data']['partner_data'][$j]['twitter_post_id'])){
																		$model2->twitter_post_id = $data['data']['partner_data'][$j]['twitter_post_id'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['fb_reach']) && !empty($data['data']['partner_data'][$j]['fb_reach'])){
																		$model2->fb_reach = $data['data']['partner_data'][$j]['fb_reach'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['twitter_reach']) && !empty($data['data']['partner_data'][$j]['twitter_reach'])){
																		$model2->twitter_reach = $data['data']['partner_data'][$j]['twitter_reach'];	
																		}
																		($model2->save(false));

															}
															}		
																//if($res){
																if(($data['data']['post_to_exchange'])==1)
																	{	
																	$model3 = new PostToExchange();
																	if(isset($data['data']['campaign_message']) && !empty($data['data']['campaign_message'])){
																		$model3->message = $data['data']['campaign_message'];
																		
																	}
																	if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
																		$model3->user_id = $data['data']['user_id'];
																		
																	}
																	if(isset($data['data']['user_type']) && !empty($data['data']['user_type'])){
																		$model3->user_type = $data['data']['user_type'];
																		
																	}
																	if(isset($campaignId) && !empty($campaignId)){
																		$model3->campaign_id = $campaignId;	
																		//$model3->post_type = 'CPE';
																	}
																		if(isset($data['data']['post_type']) && !empty($data['data']['post_type'])){
																		$model3->post_type = $data['data']['post_type'];
																		
																	}
																		if(isset($data['data']['start_date']) && !empty($data['data']['start_date'])){
																		$model3->start_date = $data['data']['start_date'];
																		
																	}
																		if(isset($data['data']['end_date']) && !empty($data['data']['end_date'])){
																		$model3->end_date = $data['data']['end_date'];
																		
																	}
																		if(isset($data['data']['cost']) && !empty($data['data']['cost'])){
																		$model3->cost = $data['data']['cost'];
																		
																	}			
																	if($model3->save(false)){
																		$postToExchangeId=$model3->postexchange_id;
																		//$userId=$model3->user_id;
																			for ($k=0; $k<count($data['data']['media']); $k++) 
																			{
																				$model4 = new Media(); 
																			if(isset($data['data']['media'][$k]['media_type']) && !empty($data['data']['media'][$k]['media_type'])){
																			$model4->media_type = $data['data']['media'][$k]['media_type'];
																				
																			}
																			if(isset($data['data']['media'][$k]['file_name']) && !empty($data['data']['media'][$k]['file_name'])){
																			$model4->file_name = $data['data']['media'][$k]['file_name'];
																			}
																			if(isset($postToExchangeId) && !empty($postToExchangeId)){
																			$id2[$k]=$postToExchangeId;
																				$model4->postexchange_id = $id2[$k];
																				
																			}
																			if($model4->save(false)){
																				$res2=$model4;
																			}
																		}
																			//p($res2);
																			if($model3){
																			$response['status'] = "1";
																			$response['campaign_id'] =$campaignId;
																			$response['data'] = "Post to exchange successfully added.";	
															 				echo json_encode($response);
																			exit();
															 				}
															 			}else{
																		$response['status'] = "0";
																		$response['data'] = "Fail to Inserted Post exchange data.";
																		echo json_encode($response);
																		exit();
																		}
																		
														}else{
														$response['status'] = "1";
														$response['campaign_id'] =$campaignId;
														$response['data'] = "Campaign with partners successfully added.";
														echo json_encode($response);
														exit();
															}
													/*}else{
													$response['status'] = "0";
													$response['data'] = "Unable to insert Campaign partner records.";
													echo json_encode($response);
													exit();
													}	*/	 
												}else{
												$response['status'] = "0";
												$response['data'] = "unable to insert campaign records";
												echo json_encode($response);
												exit();
												}	
							}
				}
		}
	}
// Call this when Payment gets Successfull
public function actionPaymentSuccess(){
	$data = json_decode(file_get_contents('php://input'), TRUE);
	$appcampDetails = Campaign::model()->find("campaign_id = '".$data['data']['campaign_id']."'");
	$campPackage=$appcampDetails['package_name'];
	$is_camp=$appcampDetails['is_campaign'];
	$message="A message campaign is ready";
	$entourageMessage="An entourage posted an exchange";
	if($data['data']['campaign_id']!=""){
							$u_id=$data['data']['user_id'];
							$user_type=$data['data']['user_type'];
							$userScreenName = UserDetail::model()->find('user_id="'.$u_id.'"');
							$screenname=$userScreenName['twitter_screen_name'];
						if($user_type==2){
								if($campPackage!= 'Custom' && $campPackage!='' && $is_camp==1){
									//$pushToEntourage=UserDetail::model()->findAll('user_type= 1 AND (is_verified = 1 OR is_featured = 1 )');
										$pushToEntourage = UserDetail::model()->findAll('user_type= 1 AND push_get_contacted IN (1)');
										
										// push notification when Package Called->Bronze,Silver,Platinum,Gold is selected
											foreach($pushToEntourage as $pushList)
												{
													$athleteBadge = AthleteAppNotification::model()->find("screen_name ='".$pushList['twitter_screen_name']."'");	
													$this->sendIphoneNotification($pushList['device_id'],$message,$athleteBadge['badge']);
													}
													//------ Simple Notification--------
													$athleteNoti=AthleteNotification::model()->findAll();
													foreach($athleteNoti as $atheList)
													{
														$antid = $atheList['athlete_id'];
														$antData = $this->loadModel($antid, 'AthleteNotification');
														$campBadge = ($antData['campaign']+1);
														$antData->campaign = $campBadge;
														$antData->save(false);
													}	
													//------ Application level--------
													$athleteAppNoti=AthleteAppNotification::model()->findAll();
													foreach($athleteAppNoti as $atheAppList)
													{
														$antAppid = $atheAppList['ath_app_id'];
														$antAppData = $this->loadModel($antAppid, 'AthleteAppNotification');
														$badgeApp = ($antAppData['badge']+1);
														$antAppData->badge = $badgeApp;
														$antAppData->save(false);
													}	
													
													
									}elseif($is_camp==1 && $campPackage== 'Custom')	
									{
										$appcampDetails = CampaignPartner::model()->findAll("campaign_id = '".$data['data']['campaign_id']."'");
										foreach($appcampDetails as $camList)
										{
											$twitterScreenName=$camList['twitter_screen_name'];
											$twitterData = UserDetail::model()->find("twitter_screen_name = '".$twitterScreenName."'");
											$user_id=$twitterData['user_id'];
											
																														//---- Simple Notification---
																			$athleteNoti = AthleteNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteNoti){
																				$athlete_id = $athleteNoti['athlete_id'];
																				$campBadge = $athleteNoti['campaign'];
																				$notiData = $this->loadModel($athlete_id, 'AthleteNotification');
																				$notiData->campaign=$campBadge+1;
																				$notiData->save(false);
																				
																			}

																			//---- App level Notification
																			
																			$athleteAppNoti = AthleteAppNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteAppNoti){
																				$athleteApp_id = $athleteAppNoti['ath_app_id'];
																				$badgeApp = $athleteAppNoti['badge'];
																				$notiAppData = $this->loadModel($athleteApp_id, 'AthleteAppNotification');
																				$notiAppData->badge=$badge+1;
																				$badgeToNoti=$notiAppData->badge;
																				$notiAppData->save(false);
																				
																			}
																			//---- Send Notification to phone
																	$this->sendIphoneNotification($twitterData->device_id,$message,$badgeToNoti);
										}
										
									}elseif($is_camp==0)
									{
										$appcampDetails = CampaignPartner::model()->findAll("campaign_id = '".$data['data']['campaign_id']."'");
										foreach($appcampDetails as $camList)
										{
											$twitterScreenName=$camList['twitter_screen_name'];
											$twitterData = UserDetail::model()->find("twitter_screen_name = '".$twitterScreenName."'");
											$user_id=$twitterData['user_id'];
											
																														//---- Simple Notification---
																			$athleteNoti = AthleteNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteNoti){
																				$athlete_id = $athleteNoti['athlete_id'];
																				$campBadge = $athleteNoti['campaign'];
																				$notiData = $this->loadModel($athlete_id, 'AthleteNotification');
																				$notiData->campaign=$campBadge+1;
																				$notiData->save(false);
																				
																			}

																			//---- App level Notification
																			
																			$athleteAppNoti = AthleteAppNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteAppNoti){
																				$athleteApp_id = $athleteAppNoti['ath_app_id'];
																				$badgeApp = $athleteAppNoti['badge'];
																				$notiAppData = $this->loadModel($athleteApp_id, 'AthleteAppNotification');
																				$notiAppData->badge=$badge+1;
																				$badgeToNoti=$notiAppData->badge;
																				$notiAppData->save(false);
																				
																			}
																			//---- Send Notification to phone
																			$this->sendIphoneNotification($twitterData->device_id,$message,$badgeToNoti);
										}
									}
								
								
							}elseif($user_type==1){
								if($campPackage!= 'Custom' && $campPackage!='' && $is_camp==1){
										$pushToEntourage = UserDetail::model()->findAll('user_type= 1 AND push_get_contacted IN (1) AND user_id NOT IN("'.$u_id.'")');
										// push notification when Package Called->Bronze,Silver,Platinum,Gold is selected
											foreach($pushToEntourage as $pushList)
												{
													$athleteBadge = AthleteAppNotification::model()->find("screen_name ='".$pushList['twitter_screen_name']."'");	
													$this->sendIphoneNotification($pushList['device_id'],$message,$athleteBadge['badge']);
													}
													//------ Simple Notification--------
													$athleteNoti=AthleteNotification::model()->findAll('screen_name NOT IN("'.$screenname.'")');
													foreach($athleteNoti as $atheList)
													{
														$antid = $atheList['athlete_id'];
														$antData = $this->loadModel($antid, 'AthleteNotification');
														$campBadge = ($antData['campaign']+1);
														$antData->campaign = $campBadge;
														$antData->save(false);
													}	
													//------ Application level--------
													$athleteAppNoti=AthleteAppNotification::model()->findAll('screen_name NOT IN("'.$screenname.'")');
													foreach($athleteAppNoti as $atheAppList)
													{
														$antAppid = $atheAppList['ath_app_id'];
														$antAppData = $this->loadModel($antAppid, 'AthleteAppNotification');
														$badgeApp = ($antAppData['badge']+1);
														$antAppData->badge = $badgeApp;
														$antAppData->save(false);
													}	
													
													
									}elseif($is_camp==1 && $campPackage== 'Custom')	
									{
										$appcampDetails = CampaignPartner::model()->findAll("campaign_id = '".$data['data']['campaign_id']."'");
									
										foreach($appcampDetails as $camList)
										{
											$twitterScreenName=$camList['twitter_screen_name'];
											$twitterData = UserDetail::model()->find("twitter_screen_name = '".$twitterScreenName."'");
											$user_id=$twitterData['user_id'];
											
																														//---- Simple Notification---
																			$athleteNoti = AthleteNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteNoti){
																				$athlete_id = $athleteNoti['athlete_id'];
																				$campBadge = $athleteNoti['campaign'];
																				$notiData = $this->loadModel($athlete_id, 'AthleteNotification');
																				$notiData->campaign=$campBadge+1;
																				$notiData->save(false);
																				
																			}

																			//---- App level Notification
																			
																			$athleteAppNoti = AthleteAppNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteAppNoti){
																				$athleteApp_id = $athleteAppNoti['ath_app_id'];
																				$badgeApp = $athleteAppNoti['badge'];
																				$notiAppData = $this->loadModel($athleteApp_id, 'AthleteAppNotification');
																				$notiAppData->badge=$badge+1;
																				$badgeToNoti=$notiAppData->badge;
																				$notiAppData->save(false);
																				
																			}
																			//---- Send Notification to phone
																	$this->sendIphoneNotification($twitterData->device_id,$message,$badgeToNoti);
										}
										
									}elseif($is_camp==0)
									{
									$appcampDetails = CampaignPartner::model()->findAll("campaign_id = '".$data['data']['campaign_id']."' AND user_id NOT IN($u_id)");
									
										foreach($appcampDetails as $camList)
										{
											$twitterScreenName=$camList['twitter_screen_name'];
											$twitterData = UserDetail::model()->find("twitter_screen_name = '".$twitterScreenName."'");
											$user_id=$twitterData['user_id'];
											
																														//---- Simple Notification---
																			$athleteNoti = AthleteNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteNoti){
																				$athlete_id = $athleteNoti['athlete_id'];
																				$campBadge = $athleteNoti['campaign'];
																				$notiData = $this->loadModel($athlete_id, 'AthleteNotification');
																				$notiData->campaign=$campBadge+1;
																				$notiData->save(false);
																				
																			}

																			//---- App level Notification
																			
																			$athleteAppNoti = AthleteAppNotification::model()->find("user_id = '".$user_id."'");
																			if($athleteAppNoti){
																				$athleteApp_id = $athleteAppNoti['ath_app_id'];
																				$badgeApp = $athleteAppNoti['badge'];
																				$notiAppData = $this->loadModel($athleteApp_id, 'AthleteAppNotification');
																				$notiAppData->badge=$badge+1;
																				$badgeToNoti=$notiAppData->badge;
																				$notiAppData->save(false);
																				
																			}
																			//---- Send Notification to phone
																			$this->sendIphoneNotification($twitterData->device_id,$message,$badgeToNoti);
										}
									}
								
								
								
							}
							
}else{
									$pushToEntourage=UserDetail::model()->findAll('user_type= 1 AND push_new_exchanges IN(1)');
								// push notification when entourage do PTE and notification goes to all athlete user of the system
								foreach($pushToEntourage as $pushList)
								{
									$antBadge = AthleteAppNotification::model()->find("screen_name ='".$pushList['twitter_screen_name']."'");
									$this->sendIphoneNotification($pushList['device_id'],$entourageMessage,$antBadge['badge']);
								}
								$athleteNoti=AthleteNotification::model()->findAll();
								foreach($athleteNoti as $atheList)
								{
									$antid = $atheList['athlete_id'];
									$antData = $this->loadModel($antid, 'AthleteNotification');
									$badge = ($antData['post_to_exchange']+1);
									$antData->post_to_exchange = 	$badge;
									$antData->save(false);
								}	
									//---------- App level Notification---------
									$athleteAppNoti=AthleteAppNotification::model()->findAll();
									foreach($athleteAppNoti as $notiAppList)
									{
										$athAppid = $notiAppList['ath_app_id'];
										$athAppData = $this->loadModel($athAppid, 'AthleteAppNotification');
										$badgeApp = ($athAppData['badge']+1);
										$athAppData->badge = 	$badgeApp;
										$athAppData->save(false);
									}
}

}

//Edit Campaign
	public function actionEditCampaign(){
		$res = array();
		$res1 = array();
		$res2= array();
		$response=array();
		$getData=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['campaign_id']) && $data['data']['campaign_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
					}else{
						if(isset($data['data']['campaign_id']) && $data['data']['campaign_id'] != ''){
						$appcampDetails = Campaign::model()->find("campaign_id = '".$data['data']['campaign_id']."'");
						if($appcampDetails){
							$id = $appcampDetails['campaign_id'];
							$model = $this->loadModel($id, 'Campaign');
								if(isset($data['data']['campaign_message']) && !empty($data['data']['campaign_message'])){
									$model->compaign_message = $data['data']['campaign_message'];
									
								}
								if(isset($data['data']['post_to_exchange']) && !empty($data['data']['post_to_exchange'])){
									$model->post_to_exchange = $data['data']['post_to_exchange'];
									$post_to_exchange=$data['data']['post_to_exchange'];
									
								}
									if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
									$model->user_id = $data['data']['user_id'];
								}
								if(isset($data['data']['total_cost']) && !empty($data['data']['total_cost'])){
									$model->total_cost = $data['data']['total_cost'];
									
								}
								if(isset($data['data']['is_campaign']) && !empty($data['data']['is_campaign'])){
									$model->is_campaign = $data['data']['is_campaign'];
									
								}
								
								// Save above data in Campaign table
								if($model->save(false)){
												$campaignId=$model->campaign_id;
												
												//Start media data update code
												$i = 0;	
												$appmediaDetails = Media::model()->findAll("campaign_id = '".$data['data']['campaign_id']."'");
												if($appmediaDetails){
															foreach ($appmediaDetails as $appmediaList) {
																$mediaId = $appmediaList['media_id'];
																$mediaData = $this->loadModel($mediaId, 'Media');
																if(isset($data['data']['media'][$i]['media_type']) && !empty($data['data']['media'][$i]['media_type'])){
																	$mediaData->media_type = $data['data']['media'][$i]['media_type'];	
																}
																if(isset($data['data']['media'][$i]['file_name']) && !empty($data['data']['media'][$i]['file_name'])){
																	$mediaData->file_name = $data['data']['media'][$i]['file_name'];		
																}
																if(isset($campaignId) && !empty($campaignId)){	
																	$mediaData->campaign_id = $campaignId;	
																}
																$mediaData->save(false);
																$i++;	
															}	
													}
												// End media data update code
													
															//if($res1)
															//{
																$j=0;
													$appPartnerDetails = CampaignPartner::model()->findAll("campaign_id = '".$data['data']['campaign_id']."'");
																if($appPartnerDetails){
																	
																foreach ($appPartnerDetails as $appPartnerList) 
																	{
																		$IdPartner = $appPartnerList['id'];	
																		$partnerData = $this->loadModel($IdPartner, 'CampaignPartner'); 
																		if(isset($campaignId) && !empty($campaignId)){
																		$partnerData->campaign_id = $campaignId;		
																		}
																		if(isset($data['data']['partner_data'][$j]['twitter_screen_name']) && !empty($data['data']['partner_data'][$j]['twitter_screen_name'])){
																		$partnerData->twitter_screen_name = $data['data']['partner_data'][$j]['twitter_screen_name'];		
																		}
																		if(isset($data['data']['partner_data'][$j]['twitter_screen_name']) && !empty($data['data']['partner_data'][$j]['twitter_screen_name'])){
																			$twitterData = UserDetail::model()->find("twitter_screen_name = '".$data['data']['partner_data'][$j]['twitter_screen_name']."'");
																			if($twitterData)
																				{
																					$partnerData->is_member = 1;
																				}
																			else {
																				$partnerData->is_member = 0;
																			}
																		}		
																		if(isset($data['data']['partner_data'][$j]['impact_score']) && !empty($data['data']['partner_data'][$j]['impact_score'])){
																		$partnerData->impact_score = $data['data']['partner_data'][$j]['impact_score'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['is_verified']) && !empty($data['data']['partner_data'][$j]['is_verified'])){
																		$partnerData->is_verified = $data['data']['partner_data'][$j]['is_verified'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['price']) && !empty($data['data']['partner_data'][$j]['price'])){
																		$partnerData->price = $data['data']['partner_data'][$j]['price'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['reach']) && !empty($data['data']['partner_data'][$j]['reach'])){
																		$partnerData->reach = $data['data']['partner_data'][$j]['reach'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['fb_post_id']) && !empty($data['data']['partner_data'][$j]['fb_post_id'])){
																		$partnerData->fb_post_id = $data['data']['partner_data'][$j]['fb_post_id'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['twitter_post_id']) && !empty($data['data']['partner_data'][$j]['twitter_post_id'])){
																		$partnerData->twitter_post_id = $data['data']['partner_data'][$j]['twitter_post_id'];	
																		}
																		if(isset($data['data']['partner_data'][$j]['fb_reach']) && !empty($data['data']['partner_data'][$j]['fb_reach'])){
																		$partnerData->fb_reach = $data['data']['partner_data'][$j]['fb_reach'];	
																		}	
																		if(isset($data['data']['partner_data'][$j]['twitter_reach']) && !empty($data['data']['partner_data'][$j]['twitter_reach'])){
																		$partnerData->twitter_reach = $data['data']['partner_data'][$j]['twitter_reach'];	
																		}	
																	
																$partnerData->save(false);
																$j++;
															}
															}		
																	
																if(($data['data']['post_to_exchange'])==1)
																{
								
																	$appPostDetails = PostToExchange::model()->find("campaign_id = '".$data['data']['campaign_id']."'");
																	if($appPostDetails)
																	{
																		$postId = $appPostDetails['postexchange_id'];
																		$postData = $this->loadModel($postId, 'PostToExchange');
																		if(isset($data['data']['campaign_message']) && !empty($data['data']['campaign_message'])){
																		$postData->message = $data['data']['campaign_message'];
																		
																	}
																	if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
																		$postData->user_id = $data['data']['user_id'];
																		
																	}
																	if(isset($data['data']['user_type']) && !empty($data['data']['user_type'])){
																		$postData->user_type = $data['data']['user_type'];
																		
																	}
																	if(isset($data['data']['post_type']) && !empty($data['data']['post_type'])){
																		$postData->post_type = $data['data']['post_type'];
																		
																	}
																	if(isset($data['data']['start_date']) && !empty($data['data']['start_date'])){
																		$postData->start_date = $data['data']['start_date'];
																		
																	}
																	if(isset($data['data']['end_date']) && !empty($data['data']['end_date'])){
																		$postData->end_date = $data['data']['end_date'];
																		
																	}
																	if(isset($data['data']['cost']) && !empty($data['data']['cost'])){
																		$postData->cost = $data['data']['cost'];
																		
																	}
																	if(isset($campaignId) && !empty($campaignId)){
																		$postData->campaign_id = $campaignId;
																		
																	}
																	if($postData->save(false)){
																		$postToExchangeId=$postData->postexchange_id;
																					$k = 0;	
																					$partnermediaDetails = Media::model()->findAll("postexchange_id = '".$postToExchangeId."'");
																					if($partnermediaDetails){
																					foreach ($partnermediaDetails as $partnermediaList) {
																					$partnermediaId = $partnermediaList['media_id'];
																					$partnermediaData = $this->loadModel($partnermediaId, 'Media');
																					if(isset($data['data']['media'][$k]['media_type']) && !empty($data['data']['media'][$k]['media_type'])){
																						$partnermediaData->media_type = $data['data']['media'][$k]['media_type'];	
																						}
																								if(isset($data['data']['media'][$k]['file_name']) && !empty($data['data']['media'][$k]['file_name'])){
																									$partnermediaData->file_name = $data['data']['media'][$k]['file_name'];		
																								}
																								if(isset($postToExchangeId) && !empty($postToExchangeId)){
																												$partnermediaData->postexchange_id = $postToExchangeId;	
																								}
																								$partnermediaData->save(false);
																								$k++;	
																							}	
																					}
																			if($postData){
																			$response['status'] = "1";
																			$response['campaign_id'] =$campaignId;
																			$response['data'] = "successfully updated.";	
															 				echo json_encode($response);
																			exit();
															 				}
															 				
															 			}else{
																		$response['status'] = "0";
																		$response['data'] = "Fail to Inserted Post exchange data.";
																		echo json_encode($response);
																		exit();
																		}
																}		
																		
														}else{
														$response['status'] = "1";
														$response['campaign_id'] =$campaignId;
														$response['data'] = "Campaign with partners successfully updated.";
														echo json_encode($response);
														exit();
															}
													}else{
													$response['status'] = "0";
													$response['data'] = "Unable to insert Campaign records.";
													echo json_encode($response);
													exit();
													}		 	
								
							}
				}
		}
	}
		
				//-----Transaction-----
	public function actionTransaction(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['campaign_id']) && $data['data']['campaign_id'] == '' ||
		   !isset($data['data']['amount']) && $data['data']['amount'] == '' ||
		   !isset($data['data']['paypal_id']) && $data['data']['paypal_id'] == '' ){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}else{
				$model = new Transaction();
				if(isset($data['data']['campaign_id']) && !empty($data['data']['campaign_id'])){
					$model->campaign_id = $data['data']['campaign_id'];
					
				}
				if(isset($data['data']['amount']) && !empty($data['data']['amount'])){
					$model->amount = $data['data']['amount'];
				
				}
				if(isset($data['data']['paypal_id']) && !empty($data['data']['paypal_id'])){
					$model->paypal_id = $data['data']['paypal_id'];
				
				}
				if(isset($data['data']['intent']) && !empty($data['data']['intent'])){
					$model->intent = $data['data']['intent'];
				
				}
				if($model->save(false)){
					$response['status'] = "1";
					$response['data'] = "Transaction Successfully Registered.";
					$response['transaction_id'] = $model->transaction_id;
					echo json_encode($response);
					exit();
				}else{
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
				}
			}
		}
	
	// Social Post Data
	public function actionSocialData(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);

		if(!isset($data['data']['fb_post_id']) && $data['data']['fb_post_id'] == '' ||
		   !isset($data['data']['twitter_post_id']) && $data['data']['twitter_post_id'] == '' ||
		   !isset($data['data']['fb_reach']) && $data['data']['fb_reach'] == '' ||
		   !isset($data['data']['campaign_id']) && $data['data']['campaign_id'] == '' ||
		   !isset($data['data']['user_id']) && $data['data']['user_id'] == '' ||
		   !isset($data['data']['impact_score']) && $data['data']['impact_score'] == '' ||
		   !isset($data['data']['twitter_reach']) && $data['data']['twitter_reach'] == '' ){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}else{
				$model = new SocialPosts();
				if(isset($data['data']['fb_post_id']) && !empty($data['data']['fb_post_id'])){
					$model->fb_post_id = $data['data']['fb_post_id'];
					
				}
				if(isset($data['data']['twitter_post_id']) && !empty($data['data']['twitter_post_id'])){
					$model->twitter_post_id = $data['data']['twitter_post_id'];
				
				}
				if(isset($data['data']['fb_reach']) && !empty($data['data']['fb_reach'])){
					$model->fb_reach = $data['data']['fb_reach'];
				
				}
				if(isset($data['data']['twitter_reach']) && !empty($data['data']['twitter_reach'])){
					$model->twitter_reach = $data['data']['twitter_reach'];
					$twitterReach=$model->twitter_reach;
				}
				if(isset($data['data']['campaign_id']) && !empty($data['data']['campaign_id'])){
					$model->campaign_id = $data['data']['campaign_id'];
				
				}
				if(isset($data['data']['message']) && !empty($data['data']['message'])){
					$model->message = $data['data']['message'];
				
				}
				if(isset($data['data']['video_url']) && !empty($data['data']['video_url'])){
					$model->video_url = $data['data']['video_url'];
				
				}
				if(isset($data['data']['image_url']) && !empty($data['data']['image_url'])){
					$model->image_url = $data['data']['image_url'];
				
				}
				if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
					$model->user_id = $data['data']['user_id'];
					$u_id=$model->user_id; 
				
				}
				if(isset($data['data']['twitter_screen_name']) && !empty($data['data']['twitter_screen_name'])){
					$model->twitter_screen_name = $data['data']['twitter_screen_name'];
				
				}
				if(isset($data['data']['fb_screen_name']) && !empty($data['data']['fb_screen_name'])){
					$model->fb_screen_name = $data['data']['fb_screen_name'];
					$impactScore=$data['data']['impact_score'];
				
				}
			/*	if(isset($data['data']['price']) && !empty($data['data']['price'])){
					$model->price = $data['data']['price'];
				
				}*/
				if(isset($data['data']['is_exchange']) && !empty($data['data']['is_exchange'])){
					$model->is_exchange = $data['data']['is_exchange'];
				}
				//if($model->save(false)){
					
						if($model)
						{
							
								if(isset($data['data']['campaign_id']) && $data['data']['campaign_id'] != ''){
								$campData = Campaign::model()->find("campaign_id = '".$data['data']['campaign_id']."'");
								if($campData)
								{
									$campid = $campData['campaign_id'];
									$userid = $campData['user_id'];
									$is_camp = $campData['is_campaign'];
									$campFollowerBal = $campData['followers_bal'];
									$campTotalCost = $campData['total_cost'];

									//$newPrice=($impactScore/100)*(0.25*$campTotalCost);
									
									$campPackage = $campData['package_name'];
									$campmodel = $this->loadModel($campid, 'Campaign');
									$campmodel->followers_bal=$campFollowerBal-$twitterReach;
									$checkCampBal=$campmodel->followers_bal;
									
									
									$userData = UserDetail::model()->find("user_id = '".$userid."'");
									
									$getScreenName = UserDetail::model()->find("user_id = '".$u_id."'");
									if($userData)
									{
										$socialPuchMessage="Your message was posted by '".$getScreenName['twitter_screen_name']."'";	
										$this->sendIphoneNotification($userData['device_id'],$socialPuchMessage);
									}
									
									if($checkCampBal==0)
									{
										$campmodel->is_close=1;
									}
									($campmodel->save(false));
									if($campPackage!= 'Custom' && $campPackage!='' && $is_camp==1)
									{
										
										if($campPackage=='Gold')
										{
											$newPrice=$twitterReach*((0.5*1999)/750000);
													
										}elseif($campPackage=='Platinum')
										{
											$newPrice= $twitterReach*((0.5*2499)/1000000);
										}elseif($campPackage=='Bronze')
										{
											$newPrice= $twitterReach*((0.5*999)/250000);
										}elseif($campPackage=='Silver')	
										{
											$newPrice= $twitterReach*((0.5*1499)/500000);
										}
										
										$userData = UserDetail::model()->find("user_id = '".$data['data']['user_id']."'");
										if($userData)
										{
											$partnerModel = new CampaignPartner();
											$partnerModel->campaign_id=$campid;
											$partnerModel->twitter_screen_name=$userData['twitter_screen_name'];
											$partnerModel->is_member=1;
											$partnerModel->is_verified=$userData['is_verified'];
											$partnerModel->impact_score=$userData['impact_score'];
											$partnerModel->price=$newPrice;
											$partnerModel->reach=$userData['twitter_followers'];
											($partnerModel->save(false));
											
										}
									}elseif($campPackage== 'Custom' && $campPackage!='' && $is_camp==1){
										$sum=0;
										$camTwitter=CampaignPartner::model()->find("campaign_id = '".$data['data']['campaign_id']."' AND twitter_screen_name='".$data['data']['twitter_screen_name']."'");
										$campData = CampaignPartner::model()->findAll("campaign_id = '".$data['data']['campaign_id']."'");
										foreach($campData as $camList)
										{
										$sum+=$camList['reach'];
										}
										$newPrice=$camTwitter['reach']*((0.5*$campTotalCost)/$sum);
									}elseif($is_camp==0){
										
										$newPrice=(0.5*$campTotalCost);
									}							
								}else{
										$response['status'] = "0";
										$response['data'] = "campaign Records not found";
										echo json_encode($response);
										exit();
									}
								}
							
							
								if(isset($data['data']['user_id']) && $data['data']['user_id'] != ''){
								$appBalDetails = Balance::model()->find("user_id = '".$data['data']['user_id']."'");
								if($appBalDetails){
								$id = $appBalDetails['balance_id'];
								$balprice=$appBalDetails['balance'];
							//	$newPrice=($impactScore/100)*(0.25*$campTotalCost);
								$balmodel = $this->loadModel($id, 'Balance');
								if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
								$balmodel->user_id =  $data['data']['user_id'];
								}
								$model->price =	$newPrice;	
								$balmodel->balance = $balprice + $newPrice;
								$balmodel->updated_date = date('Y/m/d H:i:s');
								if($balmodel->save(false) && $model->save(false)){
										$response['status'] = "1";
										$response['data'] = "User balance Updated";
										echo json_encode($response);
										exit();
								}else{
										$response['status'] = "0";
										$response['data'] = "Invalid Parameters Inserted.";
										echo json_encode($response);
										exit();
									}
								}else{
									$balmodel = new Balance();
									if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
										$balmodel->user_id = $data['data']['user_id'];
										}
										//$newPrice=($impactScore/100)*(0.25*$campTotalCost);
										$model->price =	$newPrice;
										$balmodel->balance = $newPrice;
										$balmodel->updated_date = date('Y/m/d H:i:s');

						if($balmodel->save(false) && $model->save(false)){
							$response['status'] = "1";
							$response['data'] = "New User Balance Successfully Added.";
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
						}
					}	
					}		
					}
						/*}else{
							$response['status'] = "0";
							$response['data'] = "Unable to save social post.";
							echo json_encode($response);
							exit();
						}*/
			}
		}	


	// Social Post Data Exchange
	public function actionSocialDataExchange(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		
		if(!isset($data['data']['fb_post_id']) && $data['data']['fb_post_id'] == '' ||
		   !isset($data['data']['twitter_post_ids']) && $data['data']['twitter_post_ids'] == '' ||
		   !isset($data['data']['user_id']) && $data['data']['user_id'] == '' ){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}else{
				$model = new SocialPostsExchange();
				if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
					$model->user_id = $data['data']['user_id'];
				}
				if(isset($data['data']['twitter_screen_name']) && !empty($data['data']['twitter_screen_name'])){
					$model->twitter_screen_name = $data['data']['twitter_screen_name'];
				}
				if(isset($data['data']['fb_screen_name']) && !empty($data['data']['fb_screen_name'])){
					$model->fb_screen_name = $data['data']['fb_screen_name'];
				}
				if(isset($data['data']['postexchange_id']) && !empty($data['data']['postexchange_id'])){
					$model->postexchange_id = $data['data']['postexchange_id'];
				}
				if(isset($data['data']['fb_post_id']) && !empty($data['data']['fb_post_id'])){
					$model->fb_post_id = $data['data']['fb_post_id'];
				}
				if(isset($data['data']['twitter_post_ids']) && !empty($data['data']['twitter_post_ids'])){
					$model->twitter_post_ids = $data['data']['twitter_post_ids'];
				}
				if(isset($data['data']['message']) && !empty($data['data']['message'])){
					$model->message = $data['data']['message'];
				}
				if(isset($data['data']['video_url']) && !empty($data['data']['video_url'])){
					$model->video_url = $data['data']['video_url'];
				}
				if(isset($data['data']['image_url']) && !empty($data['data']['image_url'])){
					$model->image_url = $data['data']['image_url'];
				}
				if($model->save(false)){
							$response['status'] = "1";
							$response['data'] = "New Social Data for exchange Successfully Added.";
							echo json_encode($response);
							exit();
				}else{
							$response['status'] = "0";
							$response['data'] = "Invalid Parameters Inserted.";
							echo json_encode($response);
							exit();
				}		
			}
		}
	
			// Get Campaign Balance
	public function actionGetCampBal(){
		$res=array();
		$response=array();	
		$campaign_id=$_REQUEST['campaign_id'];
					if(isset($campaign_id)){
						$campBalData = Campaign::model()->find("campaign_id= '".$campaign_id."' AND is_delete=1");
						if($campBalData)
						{
							$res['followers_bal'] = $campBalData['followers_bal'];
							$response['status']="1";
							$response['data']=$res;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "No data Available";
							echo json_encode($response);
							exit();
						}
							
			}else{
				$response['status'] = "0";
				$response['data'] = "Please pass the Campaign Id.";
				echo json_encode($response);
				exit();
		}
	}
	
	// Check Whether Campaign is open Or Not
	public function actionCampOpen(){
		$res=array();
		$response=array();	
		$campaign_id=$_REQUEST['campaign_id'];
					if(isset($campaign_id)){
						$campBalData = Campaign::model()->find("campaign_id= '".$campaign_id."' AND is_delete = 1");
						if($campBalData)
						{
							$res['is_close'] = $campBalData['is_close'];
							$response['status']="1";
							$response['data']=$res;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "No data Available";
							echo json_encode($response);
							exit();
						}
							
			}else{
				$response['status'] = "0";
				$response['data'] = "Please pass the Campaign Id.";
				echo json_encode($response);
				exit();
		}
	}
	
	
	//GEt total Impact score of a user
		public function actionGetImpactScore(){
		$res=array();
		$response=array();	
		$twitter_screen_name=$_REQUEST['twitter_screen_name'];
					if(isset($twitter_screen_name)){
						$userImpactScore = UserDetail::model()->find("twitter_screen_name= '".$twitter_screen_name."' AND is_delete=1");
						if($userImpactScore)
						{
							$res['impact_score'] = $userImpactScore['impact_score'];
							$response['status']="1";
							$response['data']=$res;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "No data Available";
							echo json_encode($response);
							exit();
						}
							
			}else{
				$response['status'] = "0";
				$response['data'] = "Please pass the Campaign Id.";
				echo json_encode($response);
				exit();
		}
	}


	// Convert to share
	
	public function actionConvertToShare(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['no_of_shares']) && $data['data']['no_of_shares'] == '' ||
		   !isset($data['data']['share_price']) && $data['data']['share_price'] == '' ||
		   !isset($data['data']['user_id']) && $data['data']['user_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}else{
				
					$model = new ConvertToShare();
						if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
							$model->user_id = $data['data']['user_id'];
							}
						if(isset($data['data']['no_of_shares']) && !empty($data['data']['no_of_shares'])){
						$model->no_of_shares = $data['data']['no_of_shares'];
							$noOfShares=$model->no_of_shares;
						}
						if(isset($data['data']['share_price']) && !empty($data['data']['share_price'])){
						$model->share_price = $data['data']['share_price'];
							$sharePrice=$model->share_price;
						$model->total_share_price =$noOfShares * $sharePrice;
						$model->updated_date = date('Y/m/d H:i:s');
						$totalSharePrice=$model->total_share_price;
						}
						if($model->save(false)){
						if(!empty($model))
						{
							
							$totShare = TotalShare::model()->find("user_id = '".$data['data']['user_id']."'");
							if($totShare){
								$id = $totShare['total_share_id'];
								$shares = $totShare['no_of_shares'];
								$sharemodel = $this->loadModel($id, 'TotalShare');
								if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
								$sharemodel->user_id =  $data['data']['user_id'];
								}
								if(isset($data['data']['no_of_shares']) && !empty($data['data']['no_of_shares'])){
								$sharemodel->no_of_shares =  $shares+$data['data']['no_of_shares'];
									$sharemodel->updated_date = date('Y/m/d H:i:s');
								}
								($sharemodel->save(false));
								}else{
									$sharemodel = new TotalShare();
								if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
								$sharemodel->user_id =  $data['data']['user_id'];
								}
								if(isset($data['data']['no_of_shares']) && !empty($data['data']['no_of_shares'])){
								$sharemodel->no_of_shares =  $data['data']['no_of_shares'];
									$sharemodel->updated_date = date('Y/m/d H:i:s');
								}
								($sharemodel->save(false));
									
								}
							if($sharemodel)
							{
								$appBalDetails = Balance::model()->find("user_id = '".$data['data']['user_id']."'");
								if($appBalDetails){
								$id = $appBalDetails['balance_id'];
								$bal = $appBalDetails['balance'];
								$balmodel = $this->loadModel($id, 'Balance');
								if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
								$balmodel->user_id =  $data['data']['user_id'];
								}
								if($bal > $totalSharePrice){
								$balmodel->balance =  $bal - $totalSharePrice;
								$balmodel->updated_date = date('Y/m/d H:i:s');
								}else{
										$response['status'] = "0";
										$response['data'] = "You do not have enough balance to deduct.";
										echo json_encode($response);
										exit();
								}
								if($balmodel->save(false)){
										$response['status'] = "1";
										$response['data'] = "User balance Updated";
										echo json_encode($response);
										exit();
								}else{
										$response['status'] = "0";
										$response['data'] = "Invalid Parameters Inserted.";
										echo json_encode($response);
										exit();
									}
							}else{
							$response['status'] = "0";
							$response['data'] = "user Id not fount in Balance table .";
							echo json_encode($response);
							exit();
						}
					}				
					}else{
							$response['status'] = "0";
							$response['data'] = "Unable to save social post.";
							echo json_encode($response);
							exit();
						}
			}
		}
	}
	


		// Cashout
	public function actionCashOut(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		
		if(!isset($data['data']['amount_to_cashout']) && $data['data']['amount_to_cashout'] == '' ||
		   !isset($data['data']['user_id']) && $data['data']['user_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}else{
				
				if(isset($data['data']['user_id']) && $data['data']['user_id'] != ''){
					$cashout = Cashout::model()->find("user_id = '".$data['data']['user_id']."' AND is_verified=0");
					if(!empty($cashout)){
						$cashId = $cashout['cashout_id'];
						$cash_verify=$cashout['is_verified'];
						$model = $this->loadModel($cashId, 'Cashout');
						if($cash_verify==0)
						{
										$response['status'] = "2";
										$response['data'] = "Sorry your previous Cashout Request is still pending";
										echo json_encode($response);
										exit();
						}else{
											
						$model = new Cashout();
						if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
							$model->user_id = $data['data']['user_id'];
						}
						if(isset($data['data']['acc_no']) && !empty($data['data']['acc_no'])){
						$model->acc_no = $data['data']['acc_no'];
						}
						if(isset($data['data']['name_on_acc']) && !empty($data['data']['name_on_acc'])){
						$model->name_on_acc = $data['data']['name_on_acc'];
						}
						if(isset($data['data']['bank_swift_id']) && !empty($data['data']['bank_swift_id'])){
						$model->bank_swift_id = $data['data']['bank_swift_id'];
						}
						if(isset($data['data']['bank_name']) && !empty($data['data']['bank_name'])){
						$model->bank_name = $data['data']['bank_name'];
						}
						if(isset($data['data']['bank_address']) && !empty($data['data']['bank_address'])){
						$model->bank_address = $data['data']['bank_address'];
						}
						if(isset($data['data']['amount_to_cashout']) && !empty($data['data']['amount_to_cashout'])){
						$model->amount_to_cashout = $data['data']['amount_to_cashout'];
						$model->updated_date = date('Y/m/d H:i:s');
						}
					}	
				}else{
						$model = new Cashout();
						if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
							$model->user_id = $data['data']['user_id'];
						}
						if(isset($data['data']['acc_no']) && !empty($data['data']['acc_no'])){
						$model->acc_no = $data['data']['acc_no'];
						}
						if(isset($data['data']['name_on_acc']) && !empty($data['data']['name_on_acc'])){
						$model->name_on_acc = $data['data']['name_on_acc'];
						}
						if(isset($data['data']['bank_swift_id']) && !empty($data['data']['bank_swift_id'])){
						$model->bank_swift_id = $data['data']['bank_swift_id'];
						}
						if(isset($data['data']['bank_name']) && !empty($data['data']['bank_name'])){
						$model->bank_name = $data['data']['bank_name'];
						}
						if(isset($data['data']['bank_address']) && !empty($data['data']['bank_address'])){
						$model->bank_address = $data['data']['bank_address'];
						}
						if(isset($data['data']['amount_to_cashout']) && !empty($data['data']['amount_to_cashout'])){
						$model->amount_to_cashout = $data['data']['amount_to_cashout'];
						$model->updated_date = date('Y/m/d H:i:s');
						}
				}				
						if($model->save(false)){
										$this->sendcashoutemail($model->user_id);
										$response['status'] = "1";
										$response['data'] = "User Cashout Request Successfully Sent";
										echo json_encode($response);
										exit();
								}else{
										$response['status'] = "0";
										$response['data'] = "Invalid Parameters Inserted.";
										echo json_encode($response);
										exit();
									}
						
					}
				
				}
				}				
			
	 //cashout email 	
	 	
	public function sendcashoutemail($user_id)
	{
			$userData = UserDetail::model()->find("user_id = '".$user_id."'");
			$path=  Yii::app()->getBaseUrl(true);
			$url=$path.'/admin/Cashout/admin';
			$to = "db@doctorburke.net";
			$subject = "The Roster Network-Cashout Request";
			$txt = "Dear Admin,\r\n\n";
			$txt .= "Please check below url for cashout request receive.\r\n\n";
			$txt .= $url;
			$headers = "db@therosternetwork.com";
				
		$mail=	mail($to,$subject,$txt,"From: $headers");
		return $mail;
	}
	// Get total Share  Data
	public function actionGetTotalShare(){
		$response=array();
		$res=array();
		$u_id=$_REQUEST['user_id'];
		if(isset($u_id))
		{	
					$totalShareModel = TotalShare::model()->find('user_id = "'.$u_id.'"');
						if($totalShareModel)
						{
							$res['no_of_shares'] = $totalShareModel['no_of_shares'];
							$response['status']="1";
							$response['data']=$res;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "No data Available";
							echo json_encode($response);
							exit();
						}
		}else{
			$response['status'] = "0";
			$response['data'] = "Please pass the user Id.";
			echo json_encode($response);
			exit();
		}
	}
	
	
	
	
	
		// GET Balance
	public function actionGetTotalBal(){
		$response=array();
		$res=array();
		$u_id=$_REQUEST['user_id'];
		if(isset($u_id))
		{	
					$balData = Balance::model()->find('user_id = "'.$u_id.'" AND is_delete = 1');
						if($balData)
						{
							$res['balance'] = $balData['balance'];
							$response['status']="1";
							$response['data']=$res;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "No data Available";
							echo json_encode($response);
							exit();
						}
		}else{
			$response['status'] = "0";
			$response['data'] = "Please pass the user Id.";
			echo json_encode($response);
			exit();
		}
	}
	
	
	public function actionChangeBadge(){
		$response=array();
		$res=array();
		$screen_name=$_REQUEST['screen_name'];
		$type=$_REQUEST['type'];
		if($type == '1')
		{	
				$athleteData = AthleteNotification::model()->find('screen_name = "'.$screen_name.'"');
				if($athleteData)
				{
					$athelteid = $athleteData['athlete_id'];
					$athelateData = $this->loadModel($athelteid, 'AthleteNotification');
					$athelateData->badge = '0';
					if($athelateData->save(false)){
							$response['status'] = "1";
							$response['data'] = "Athete User Badge Updated.";
							echo json_encode($response);
							exit();
					}
				}

		}elseif($type == '2'){
				$entourageData = EntourageNotification::model()->find('screen_name = "'.$screen_name.'"');
				if($entourageData)
				{
					$entourageid = $entourageData['entourage_id'];
					$entourageData = $this->loadModel($entourageid, 'EntourageNotification');
					$entourageData->badge = '0';
					if($entourageData->save(false)){
							$response['status'] = "1";
							$response['data'] = "Entourage User Badge Updated.";
							echo json_encode($response);
							exit();
					}
				}
		}
	}
	
	
	
	//Clear App level Badge
	
		public function actionClearAppBadge(){
		$response=array();
		$res=array();
		$screen_name=$_REQUEST['screen_name'];
		$type=$_REQUEST['type'];
		if($type == '1')
		{	
				$athleteData = AthleteAppNotification::model()->find('screen_name = "'.$screen_name.'"');
				if($athleteData)
				{
					$athelteid = $athleteData['ath_app_id'];
					$athelateData = $this->loadModel($athelteid, 'AthleteAppNotification');
					$athelateData->badge = '0';
					if($athelateData->save(false)){
							$response['status'] = "1";
							$response['data'] = "Athete User Badge Updated.";
							echo json_encode($response);
							exit();
					}
				}

		}elseif($type == '2'){
				$entourageData = EntourageAppNotification::model()->find('screen_name = "'.$screen_name.'"');
				if($entourageData)
				{
					$entourageid = $entourageData['ent_app_id'];
					$entourageData = $this->loadModel($entourageid, 'EntourageAppNotification');
					$entourageData->badge = '0';
					if($entourageData->save(false)){
							$response['status'] = "1";
							$response['data'] = "Entourage User Badge Updated.";
							echo json_encode($response);
							exit();
					}
				}
		}
	}
	
		//CashOut Get Details
	public function actiongetCashOutDetails(){
		$res = array();
		$response=array();	
		$userId = $_REQUEST['user_id'];
		$cashOutData = new Cashout();
		$response = $cashOutData->getCashOutDetails($userId);
		echo json_encode($response);
		exit();	
	}
	
	// Get social Messages
	public function actionGetSocialMessages(){
		$response=array();	
		$u_id=$_REQUEST['user_id'];
					if(isset($u_id)){
						$socialData = new SocialPosts();
						$response = $socialData->getListofsocialMessages($u_id);
						header('Content-type:application/json');
						echo json_encode($response);
						exit();	
					}else{
							$response['status'] = "0";
							$response['data'] = "Please pass the user Id.";
							echo json_encode($response);
							exit();
		}
	}		
	
	// Inbox data-9/5/2014
	public function actionInboxData(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['from_user_id']) && $data['data']['from_user_id'] == '' ||
		   !isset($data['data']['message']) && $data['data']['message'] == '' ||
		   !isset($data['data']['to_user_id']) && $data['data']['to_user_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
		}else{
			$inboxInfo = Inbox::model()->find("inbox_id = '".$data['data']['inbox_id']."'");
			if($inboxInfo){
				/*$Id = $inboxInfo['inbox_id'];
				$model = $this->loadModel($userId, 'BankingInfo');
				if(isset($data['data']['user_id']) && !empty($data['data']['user_id'])){
					$model->user_id = $data['data']['user_id'];
				}
				if(isset($data['data']['name_on_account']) && !empty($data['data']['name_on_account'])){
					$model->name_on_account = $data['data']['name_on_account'];
				}
				if(isset($data['data']['account_no']) && !empty($data['data']['account_no'])){
					$model->account_no = $data['data']['account_no'];
				}
				if(isset($data['data']['bank_swift_id']) && !empty($data['data']['bank_swift_id'])){
					$model->bank_swift_id = $data['data']['bank_swift_id'];
				}
				if(isset($data['data']['bank_name']) && !empty($data['data']['bank_name'])){
					$model->bank_name = $data['data']['bank_name'];
				}
				if(isset($data['data']['bank_address']) && !empty($data['data']['bank_address'])){
					$model->bank_address = $data['data']['bank_address'];
				}
				if($model->save(false)){
					$response['status'] = "1";
					$response['data'] = "User Bank Information Successfully Updated";
					$response['user_id'] = $model->user_id;
					echo json_encode($response);
					exit();
				}else{
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
				}*/
			}else{
				
				$model = new Inbox();
				if(isset($data['data']['from_user_id']) && !empty($data['data']['from_user_id'])){
					$model->from_user_id = $data['data']['from_user_id'];
				}
				if(isset($data['data']['message']) && !empty($data['data']['message'])){
					$model->message = $data['data']['message'];
				}
				if(isset($data['data']['to_user_id']) && !empty($data['data']['to_user_id'])){
					$model->to_user_id = $data['data']['to_user_id'];
				}
				if($model->save()){
					
					  if(isset($data['data']['media_type']) && isset($data['data']['file_name']))
					  {
					  	$inboxId = $model->inbox_id;
						
						$model2 = new Media();
						if(isset($data['data']['media_type']) && !empty($data['data']['media_type']))
							{
							$model2->media_type = $data['data']['media_type'];	
							}
							if(isset($data['data']['file_name']) && !empty($data['data']['file_name'])){
							$model2->file_name = $data['data']['file_name'];	
							}
							if(isset($inboxId) && !empty($inboxId)){
							$model2->inbox_id = $inboxId;	
							}
							if($model2->save(false)){
								$response['status'] = "1";
								$response['data'] = "Success.";
								//$response['inbox_id'] = $model->inbox_id;
								echo json_encode($response);
							}else{
												$response['status'] = "0";
												$response['data'] = "Invalid Parameters Inserted.";
												echo json_encode($response);
												exit();
									}
							
					  }else{
					  
					$response['status'] = "1";
					$response['data'] = "Success.";
					$response['inbox_id'] = $model->inbox_id;
					echo json_encode($response);
					exit();
					  }
				}else{
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
				}
			}
		}
	}
	// Start List Of Entourage and Athlete
	public function actionListOfUser(){
		$response=array();	
		$typeName = $_REQUEST['type'];
		if(isset($typeName))
		{
		$userDetailData = new UserDetail();
		$response = $userDetailData->getListofUser($typeName);
		header('Content-type:application/json');
		echo CJSON::encode($response);
		exit();	
		}else{
					$response['status'] = "0";
					$response['data'] = "Pass the User Type";
					echo json_encode($response);
					exit();
		}
	}
	// End List Of Entourage and Athlete
	
	// List Of Post Data
	public function actionListOfExchangePostData(){
		$res = array();
		$response=array();	
		$getData = array();
		$typeName = $_REQUEST['type'];
		$user_id = $_REQUEST['user_id'];
		if(isset($typeName) && isset($user_id))
		{
		$postData = new PostToExchange();
		$response = $postData->getListOfExchangePostData($typeName,$user_id);
		header('Content-type:application/json');
		echo CJSON::encode($response);
		exit();	
		}else{
					$response['status'] = "0";
					$response['data'] = "Pass the User Type with user_id.";
					echo json_encode($response);
					exit();
		}
		}
		
	// End List Of Data  
	public function loadModel($id, $type, $errorMessage = 'This page does not exist', $errorNum = 404) {
		eval('$model = ' . $type . '::model()->findByPk($id);');
		if ($model === null)
			throw new CHttpException($errorNum, $errorMessage);
		return $model;
	}
	
	
	
					//-----Ratings-----
	public function actionUserRatings(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['campaign_id']) && $data['data']['campaign_id'] == '' ||
		   !isset($data['data']['from_user_id']) && $data['data']['from_user_id'] == '' ||
		   !isset($data['data']['to_user_id']) && $data['data']['to_user_id'] == '' ||
		   !isset($data['data']['ratings']) && $data['data']['ratings'] == '' ){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}else{
				
					$userData = UserDetail::model()->find("user_id = '".$data['data']['to_user_id']."'");
					$userRate=$userData->ratings;
					$model = new Ratings();
				if(isset($data['data']['campaign_id']) && !empty($data['data']['campaign_id'])){
					$model->campaign_id = $data['data']['campaign_id'];
					
				}
				if(isset($data['data']['from_user_id']) && !empty($data['data']['from_user_id'])){
					$model->from_user_id = $data['data']['from_user_id'];
				
				}
				if(isset($data['data']['to_user_id']) && !empty($data['data']['to_user_id'])){
					$model->to_user_id = $data['data']['to_user_id'];
				
				}
				if(isset($data['data']['ratings']) && !empty($data['data']['ratings'])){
					$finalRate=($data['data']['ratings']+$userRate)/2;
					$model->ratings = $finalRate;
				}
				if($model->save(false)){
							
								$u_id = $userData['user_id'];
								$modelData = $this->loadModel($u_id, 'UserDetail');
								$modelData->ratings =$finalRate;
								$modelData->save(false);
								$socialData = SocialPosts::model()->find("user_id = '".$data['data']['to_user_id']."' AND campaign_id = '".$data['data']['campaign_id']."'");
								  if($userData)
								  {
								  	$socialId = $socialData['social_id'];
									$socialModel = $this->loadModel($socialId, 'SocialPosts');
									$socialModel->rated =1;
									$socialModel->save(false);
								  }
								if($modelData)
								{
									$response['status'] = "1";
									$response['data'] = "Rating Successfully done.";
									echo json_encode($response);
									exit();
								}else{
										$response['status'] = "0";
										$response['data'] = "Error In rating.";
										echo json_encode($response);
										exit();
									}

						
					
				}else{
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
				}
			}
		}
	
//	Check Social is rated or not
	public function actionGetUserRating(){
		$res=array();
		$response=array();	
		$parterdata=array();
		$getPartnerData=array();
		$SocialListData=array();
		$user_id=$_REQUEST['user_id'];
									if(isset($user_id)){
						/*$campDetails="SELECT campaign.campaign_id,campaign.compaign_message,campaign_partner.`twitter_screen_name` FROM `campaign` 
									  JOIN campaign_partner ON campaign.campaign_id=campaign_partner.campaign_id WHERE campaign.user_id='".$user_id."'";*/
						$campDetails="SELECT campaign.campaign_id,campaign.compaign_message,campaign_partner.`twitter_screen_name`,user_detail.user_id,user_detail.facebook_screen_name,user_detail.profile_image,user_detail.twitter_screen_name,user_detail.impact_score
						 FROM `campaign` JOIN campaign_partner ON campaign.campaign_id=campaign_partner.campaign_id JOIN
						 user_detail ON campaign_partner.`twitter_screen_name`= user_detail.twitter_screen_name WHERE campaign.is_delete=1 AND campaign.user_id='".$user_id."'";			  
						$campData = Yii::app()->db->createCommand($campDetails);
						$campBalData = $campData->queryAll();
			
						foreach($campBalData as $camplist)
						{
									$res['user_id']=$camplist['user_id']; 
									$res['facebook_screen_name']=$camplist['facebook_screen_name']; 
									$res['campaign_id']=$camplist['campaign_id'];
									$res['profile_image']=$camplist['profile_image'];
									$res['impact_score']=$camplist['impact_score'];
									$res['twitter_screen_name']=$camplist['twitter_screen_name'];  
									$response[]['record']=$res;	
						}	
						$count = count($response);
						
						for ($i=0; $i < $count; $i++) {
							$socialDetails = SocialPosts::model()->find("campaign_id = '".$response[$i]['record']['campaign_id']."' AND user_id = '".$response[$i]['record']['user_id']."' AND rated=0 AND is_delete=1");
							$campaignDetails = Campaign::model()->find("campaign_id = '".$socialDetails['campaign_id']."' AND is_delete=1");
							$parterdata['compaign_message']=$campaignDetails['compaign_message'];
                                                        if($campaignDetails['total_cost']!="")
                                                        {
                                                        $parterdata['total_cost']=$campaignDetails['total_cost'];
                                                        }else{
                                                            $parterdata['total_cost']="";
                                                        }
							$parterdata['rated']= $socialDetails['rated'];
							$parterdata['fb_post_id']= $socialDetails['fb_post_id'];
							$parterdata['twitter_post_id']= $socialDetails['twitter_post_id'];
							$parterdata['price']= $socialDetails['price'];
							$parterdata['user_id']= $response[$i]['record']['user_id'];
							$parterdata['profile_image']= $response[$i]['record']['profile_image'];
							$parterdata['facebook_screen_name']= $response[$i]['record']['facebook_screen_name'];
							$parterdata['impact_score']= $response[$i]['record']['impact_score'];
							$parterdata['campaign_id']= $response[$i]['record']['campaign_id'];
							$parterdata['twitter_screen_name']= $response[$i]['record']['twitter_screen_name'];
							if($parterdata['rated']!="" && $parterdata['compaign_message']!="")
							$getPartnerData[]=$parterdata;
						}						
						if($getPartnerData)
						{
							$SocialListData['status']="1";
							$SocialListData['data']=$getPartnerData;
							echo json_encode($SocialListData);
							exit();
						}else{
							$SocialListData['status'] = "0";
							$SocialListData['data'] = "No data Available";
							echo json_encode($SocialListData);
							exit();
						}	
						
					
			}else{
							$SocialListData['status'] = "0";
							$SocialListData['data'] = "Please Pass the user Id";
							echo json_encode($SocialListData);
							exit();
						}
	}



		//CalculateImpactScore
	public function actionCalculateImpactScore(){
		$getData=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
				if(!isset($data['data']['fb_followers']) && $data['data']['fb_followers'] == '' ||
				   !isset($data['data']['fb_friends']) && $data['data']['fb_friends'] == '' ||
				   !isset($data['data']['fb_likes']) && $data['data']['fb_likes'] == '' ||
				   !isset($data['data']['twitter_tweets']) && $data['data']['twitter_tweets'] == '' ||
				   !isset($data['data']['retweets']) && $data['data']['retweets'] == '' ||
				   !isset($data['data']['twitter_followers']) && $data['data']['twitter_followers'] == '' ||
				   !isset($data['data']['user_id']) && $data['data']['user_id'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
			}else{
				if(isset($data['data']['fb_followers']) && isset($data['data']['twitter_followers']) && isset($data['data']['user_id']))
				{
						$twitterFollower=$data['data']['twitter_followers'];
						$fbFollower=$data['data']['fb_followers'];
								$impact_score=(0.75*(2.8437*(pow($twitterFollower, 0.2728))))+(0.25*(1.3497*(pow($fbFollower,0.3866))));
									$appUserDetails = UserDetail::model()->find("user_id='".$data['data']['user_id']."'");
									$user_Id = $appUserDetails['user_id'];
									$userModelData = $this->loadModel($user_Id, 'UserDetail');	
									if($userModelData)
									{
										$userModelData->twitter_followers=$twitterFollower;
										$userModelData->fb_followers=$fbFollower;
										$userModelData->fb_friends=$data['data']['fb_friends'];
										$userModelData->fb_likes=$data['data']['fb_likes'];
										$userModelData->twitter_tweets=$data['data']['twitter_tweets'];
										$userModelData->retweets=$data['data']['retweets'];
										$userModelData->impact_score=$impact_score;
										($userModelData->save(false));
											if($userModelData){
												$matchImpactScore=round($impact_score,5);
												if($appUserDetails['impact_score'] != $matchImpactScore){
													$message = "Your impact score has changed";
										 			$pushToEntourage = UserDetail::model()->find('user_id IN ( "'.$data['data']['user_id'].'") AND push_score_change IN (1)');
													// push notification when Package Called->Bronze,Silver,Platinum,Gold is selected
													$this->sendIphoneNotification($pushToEntourage['device_id'],$message);
												}
												$getData['status'] = "1";
												$getData['data'] = $userModelData->impact_score; 
												echo json_encode($getData);
												exit();
												
											}else{
												$getData['status'] = "0";
												$getData['data'] = "No Data Available"; 
												echo json_encode($getData);
												exit();
											}
									}
				}
			}	
				
	}
	// Last entered Sponser Data
	public function actionSponser(){
		$response=array();
		$res=array();
						$sponserDetails="SELECT * FROM `sponser` WHERE `flag`= 1 ORDER BY `sponser_id` DESC LIMIT 1 ";			  
						$sponserData = Yii::app()->db->createCommand($sponserDetails);
						$sponser = $sponserData->queryRow();
					
						if($sponser)
						{
							$res['user_id'] = $sponser['user_id'];
							$res['iphone_image'] = $sponser['iphone_image'];
							$res['ipad_image'] = $sponser['ipad_image'];
							$res['user_id'] = $sponser['fb_screen_name'];
							$res['twitter_screen_name'] = $sponser['twitter_screen_name'];
							$res['total_twitt'] = $sponser['total_twitt'];
							$res['total_retwitt'] = $sponser['total_retwitt'];
							$res['fb_likes'] = $sponser['fb_likes'];
							$res['fb_friends'] = $sponser['fb_friends'];
							$res['twitter_followers'] = $sponser['twitter_followers'];
							$res['facebook_followers'] = $sponser['facebook_followers'];
							$res['team'] = $sponser['team'];
							$res['position'] = $sponser['position'];
							$res['impact_score'] = $sponser['impact_score'];
							$res['flag'] = $sponser['flag'];
							$response['status']="1";
							$response['data']=$res;
							echo json_encode($response);
							exit();
						}else{
							$response['status'] = "0";
							$response['data'] = "No data Available";
							echo json_encode($response);
							exit();
						}
		
	}
	public function sendIphoneNotification($deviceToken,$message,$badge = false){
		
				$baseDir = YiiBase::getPathOfAlias('webroot') . '/SimplePush/';
	
				// Put your private key's passphrase here:
				$passphrase = 'Letsdoit@123';
				// Put your alert message here:
				if (file_exists($baseDir)) {
					//echo "file Exists";
				}
				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', $baseDir . 'ck.pem');
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	 
				// Open a connection to the APNS server
				$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
				// $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
				if (!$fp)
					exit("Failed to connect: $err $errstr" . PHP_EOL);
	
				//echo 'Connected to APNS' . PHP_EOL;
				// Create the payload body
				$body['aps'] = array('badge' => ($badge)?$badge+1:+1 ,'alert' => $message, 'sound' => 'default');
				// Encode the payload as JSON
				$payload = json_encode($body);
				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {
					
					
					//echo 'Message not delivered' . PHP_EOL;
					fclose($fp);
					return false;
				} else {
					//echo 'Message successfully delivered' . PHP_EOL;
					fclose($fp);
					return true;
				}
				return true;
				exit ;
	}



/*public function actionTwitterApi()
	{
			 require_once(YiiBase::getPathOfAlias('webroot').'/protected/modules/api/views/twitter-api-php-master/TwitterAPIExchange.php');
			$settings = array(
			'oauth_access_token' => "583677596-wu7zzR9BNf9AXpkbmKKQCEWRe2GRcO1cIABIbANw",
			'oauth_access_token_secret' => "7jRzwvxQzQ9kj2EYc4qax3DerlSOn6oQWLBvbRJ1kLNB7",
			'consumer_key' => "VSWFaFkmP1RhHKl1ATNlsaFaN",
			'consumer_secret' => "CTr6iEsbkvSHNsfFjlS5dYgUKaKmmobywz2VprsQV58TiH2bpM"
			);
			$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
			$getfield = "?screen_name=Cristiano";
			$requestMethod = "GET";
			$twitter = new TwitterAPIExchange($settings);
			$string = json_decode($twitter->setGetfield($getfield)
			->buildOauth($url, $requestMethod)
			->performRequest(),$assoc = TRUE);
			$followers_count=$string[0]['user']['followers_count'];
			$followers_count1=$string[0]['user']['screen_name'];
			
			echo $followers_count1;
			//p($string);
	} */
	
	
	
	public function actionFbApi()
	{		
			require(YiiBase::getPathOfAlias('webroot').'/protected/modules/api/views/facebook_api/src/facebook.php');
			//require(YiiBase::getPathOfAlias('webroot').'/protected/modules/api/views/facebook_api/src/base_facebook.php');
					$facebook = new Facebook(array(
				'appId' => '594880890607276', 
				'secret' => 'e26c19f294c0124e7853068578a94478', 
				));
				  $access_token = $facebook->getAccessToken();
				    echo($access_token);
				    $me = null; 
				
				    try 
				    { 
				        $uid = $facebook->getUser(); 
				        $me = $facebook->api('/'.$uid); 
				        echo "Welcome User: " . $me['name'] . "<br />"; 
				        //access permission
				        $permissions_needed = array('publish_stream', 'read_stream', 'offline_access', 'manage_pages');
				        foreach($permissions_needed as $perm) 
				        {  
				            if( !isset($permissions_list['data'][0][$perm]) || $permissions_list['data'][0][$perm] != 1 )
				            {    
				            $login_url_params = array(
				                'scope' => 'publish_stream,read_stream,offline_access,manage_pages',         
				                'fbconnect' =>  1,         
				                'display'   =>  "page",         
				                'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']      
				                );    
				            $login_url = $facebook->getLoginUrl($login_url_params);   
				            header("Location: {$login_url}");
				            exit(); 
				            }
				        }
				        //Access permission
				
				        $post_id = $facebook->api("/$uid/feed", "post", array("message"=>"Hello World!")); 
				        if(isset($post_id)) 
				        {
				            echo "A new post to your wall has been posted with id: $post_id"; 
				        }
				    } 
				    catch (FacebookApiException $e) 
				    { 
				        echo($e); 
				    } 
				
						 
			
	}

	// Delete Campaign Data 
	public function actionDeleteCampaignData(){
		$response = array();
		$campaignId = $_REQUEST['campaign_id'];
		if(isset($campaignId) && !empty($campaignId)){
			Campaign::model()->deleteAll("campaign_id IN ('".$campaignId."')");
			CampaignPartner::model()->deleteAll("campaign_id = '".$campaignId."'");
			$response['status'] = "1";
			$response['data'] = "Successfully Campaign Deleted";
			echo json_encode($response);
			exit();
		}else{
			$response['status'] = "0";
			$response['data'] = "Please passed campaign id";
			echo json_encode($response);
			exit();
		}
	}	
	
			// Clear UDID
	public function actionClearAccessToken(){
		$response = array();
		$user_id = $_REQUEST['user_id'];
		if(isset($user_id) && !empty($user_id)){
			$appUserDetails = UserDetail::model()->find("user_id = '".$user_id."'");
			if($appUserDetails)
			{
						$user_id = $appUserDetails['user_id'];
						$modelData = $this->loadModel($user_id, 'UserDetail');
						$modelData['device_id']='0';
						$modelData->save(false);
			$response['status'] = "1";
			$response['data'] = "Device Token of given user id is blank";
			echo json_encode($response);
			exit();
			}
		}else{
			$response['status'] = "0";
			$response['data'] = "Please passed user id";
			echo json_encode($response);
			exit();
		}
	}
		///----- Add Image to User detail--///
		public function actionImageSave(){
		$res = array();
		$response=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		if(!isset($data['data']['user_id']) && $data['data']['user_id'] == '' ||
		!isset($data['data']['image_type']) && $data['data']['image_type'] == '' ||
		!isset($data['data']['file_name']) && $data['data']['file_name'] == ''){
					$response['status'] = "0";
					$response['data'] = "Invalid Parameters Inserted.";
					echo json_encode($response);
					exit();
		}else{	
			$ImageData = UserDetail::model()->find("user_id = '".$data['data']['user_id']."'");
			if($ImageData)
			{
			$imageId = $ImageData['user_id'];
			$imageListData = $this->loadModel($imageId, 'UserDetail');
			if($data['data']['image_type']=='1')// Profile Image
			{
				if(isset($data['data']['file_name']) && $data['data']['file_name'] != "" ){
					$imageListData->profile_image = $data['data']['file_name'];
				}
			}elseif($data['data']['image_type']=='2')// Cover Image
			{
				if(isset($data['data']['file_name']) && $data['data']['file_name'] != "" ){
					$imageListData->cover_image = $data['data']['file_name'];
				}
			}else{
					$response['status'] = "0";
					$response['data'] = "Please pass correct Image type I.e Either 1 OR 2.";
					echo json_encode($response);
					exit();
			}
			if($imageListData->save(false)){
				
					$response['status'] = "1";
					$response['data'] = "Image successfully Added.";
					echo json_encode($response);
					exit();
			}else{
					$response['status'] = "0";
					$response['data'] = "Error in updating Image.";
					echo json_encode($response);
					exit();
			}	
		}else{
			$response['status'] = "0";
					$response['data'] = "User Id not found";
					echo json_encode($response);
					exit();
			}
		}
	}
	// Clear Notification Center
		public function actionClearNotificatons(){
		$response=array();
		$res=array();
		$data = json_decode(file_get_contents('php://input'), TRUE);
		$campaign=$data['data']['campaign'];
		$screen_name=$data['data']['screen_name'];
		$new_athlete=$data['data']['new_athlete'];
		$post_to_exchange=$data['data']['post_to_exchange'];
		$new_entourage=$data['data']['new_entourage'];
		$type=$data['data']['type'];
		if($type == '1')
		{	
				$athleteData = AthleteNotification::model()->find('screen_name = "'.$screen_name.'"');
				if($athleteData)
				{
					$athelteid = $athleteData['athlete_id'];
					$athelateData = $this->loadModel($athelteid, 'AthleteNotification');
					if($campaign == 1)
					{
					$athelateData->campaign = '0';
					}
					if($new_athlete == 1){
						$athelateData->new_athlete = '0';
					}
					if($post_to_exchange == 1){
						$athelateData->post_to_exchange = '0';
					}
					if($athelateData->save(false)){
							$response['status'] = "1";
							$response['data'] = "Athete User Badge Updated.";
							echo json_encode($response);
							exit();
					}
				}

		}elseif($type == '2'){
				$entourageData = EntourageNotification::model()->find('screen_name = "'.$screen_name.'"');
				if($entourageData)
				{
					$entourageid = $entourageData['entourage_id'];
					$entourageData = $this->loadModel($entourageid, 'EntourageNotification');
					if($post_to_exchange == 1)
					{
					$entourageData->post_to_exchange = '0';
					}elseif($new_entourage == 1){
						$entourageData->new_entourage = '0';
					}
					if($entourageData->save(false)){
							$response['status'] = "1";
							$response['data'] = "Entourage User Badge Updated.";
							echo json_encode($response);
							exit();
					}
				}
		}
	}
public function actionGetPackagePrice(){
	$response=array();
	$res=array();
	$getData=array();
	$packagePrice=PackagePrice::model()->findAll();
	if($packagePrice)
	{
		foreach($packagePrice as $price)
		{
			$response['package_name']=$price['package_name'];
			$response['package_price']=$price['package_price'];
			$res[]=$response;
		}
		if($res){
			$getData['data'] = $res;
			$getData['status'] = "1";
		}else{
			$getData['data'] = "no data found";
			$getData['status'] = "0";
		}
		echo json_encode($getData);
							exit();
	}
	
}
	}
?>