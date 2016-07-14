<?php
class IndexController extends AdminCoreController
{
	public $defaultAction = 'index';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function defaultAccessRules()
	{
		//$rules = parent::accessRules();
	 
		$rules = array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('login','logout','forgot'),
				'users'=>array('*'),
				'desc'=>'Login and Logout',
		),
		
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('admin'),
				'desc'=>'Dashboard',
		),
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('superadmin'),
				'desc'=>'Dashboard',
		),
		);
		return $rules;
	}

	public function actionIndex()
	{
		//$this->actionLogin();
		$this->pageTitle = "Dashboard || Roster Network";
		$this->render('index');
		//$this->forward('adminUser/admin');
		 
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new AdminLoginForm;
		
		
			
			
		if(isset($_COOKIE["verification"]))
		{
			if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
				$u_id=$_REQUEST['user_id'];
				$verify=$_REQUEST['verify'];
				$userModel= UserDetail::model()->find("user_id = '".$u_id."'");
				if($userModel){
				$user_id = $userModel['user_id'];
				$device = $userModel['device_id'];	
				$modelData = $this->loadModel($user_id, 'UserDetail');
				if($modelData->is_verified==0)
				{
					$modelData->is_verified="1";
					if($modelData->save(false))
					{
							setcookie("verification", "", 1,'/Roster_Network/admin/login');
						unset($_COOKIE["verification"]);
						$deviceToken=$device;
						$messsage="You are now Verified";
					
						$this->sendIphoneNotification($deviceToken,$messsage);
						$modeluser = new UserDetail();
						$this->layout = 'admin_login';
						$path=  Yii::app()->getBaseUrl(true);
						
						$this->redirect($path.'/admin/UserDetail/admin',array('model'=>$modeluser));
					}
				}
			}	
			
		}else{
						$modeluser = new UserDetail();	
						$this->layout = 'admin_login';
						$path=  Yii::app()->getBaseUrl(true);
						$this->redirect($path.'/admin/UserDetail/admin',array('model'=>$modeluser));
		}
			
		}else{
		$this->layout = 'admin_login';
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes=$_POST['AdminLoginForm'];
			// validate user input and redirect to the previous page if valid

			if($model->login())
			$this->redirect("index");
		}


		// display the login form
		$this->render('login',array('model'=>$model));
		}
	}
	
	/*public function thankyou()
	{
				
		$this->render('thankyou', array( 'model' => $model));
			
	}*/
	

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->admin->logout(false);
		$this->redirect(AdminModule::getUrl('home'));
	}
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			echo $error['message'];
			else
			$this->render('error', $error);
		}
	}
	public function actionCreatepdf(){
 		yii::import('ext.tcpdf.MYPDF');
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        spl_autoload_register(array('YiiBase','autoload'));
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('Lets Go Out');
		$pdf->SetSubject('Lets Go Out');
		$pdf->SetKeywords('Lets Go Out TCPDF, PDF');

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);
		
		// remove default footer
		$pdf->setPrintFooter(false);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		// set font
		$pdf->SetFont('times', '', 48);

		// add a page
		$pdf->AddPage();
		// --- example with background set on page ---
		
		// remove default header
		$pdf->setPrintHeader(false);

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		//$pdf->SetAutoPageBreak(false, 0);
		//$pdf->setJPEGQuality(200);
		//$pdf->setImageScale(1);
		// set bacground image);
		$img_file = yii::app()->baseUrl.'/images/business_card.jpg';
		$pdf->Image($img_file, 35, 25, 145, 73, '', '', '', false, 300, '', false, false, 0);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();
		
		// Print a text
		$pdf->SetY(70);
		$pdf->SetX(36);
		$html = '<span style="color:blue; text-align:left;">Ankit Sompura&nbsp;</span>
		<span stroke="0.1" fill="false" strokecolor="blue" color="blue" style="font-family:helvetica;font-weight:bold;font-size:15pt;text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ankit.sompura@letsnurture.com</span>';
		$pdf->writeHTML($html, true, false, true, false, '');

		//Close and output PDF document
		$pdf->Output('example_demo.pdf', 'I'); //D means open and save pdf file.
		Yii::app()->end();
		 
	}
	public function loadModel($id, $type, $errorMessage = 'This page does not exist', $errorNum = 404) {
		eval('$model = ' . $type . '::model()->findByPk($id);');
		if ($model === null)
			throw new CHttpException($errorNum, $errorMessage);
		return $model;
	}
	
	public function sendIphoneNotification($deviceToken,$message){
		
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
				$body['aps'] = array('badge' => '0' ,'alert' => $message, 'sound' => 'default');
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
				
	}
	
}