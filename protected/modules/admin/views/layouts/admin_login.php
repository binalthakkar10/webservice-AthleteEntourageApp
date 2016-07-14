<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<title>Login || Roster</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin_main.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
<link rel="shortcut icon" href=<?php echo Yii::app()->baseUrl."/r_favicon.ico" ?>>

</head>

<body  class="loginpage">
  <div id="header">
  		<div class="content">
	    	<div id="logo">
      <?php /*?><img src="<?php echo Yii::app()->baseUrl.'/images/logo.png'?>" alt="" height="30" /> <?php */?>
      <div class="header-left">
      <span style="line-height:36px;">Admin Panel</span>
      </div>
  </div>
		  </div>
  </div>
  <!-- header -->
  <div class="login_content">
  <div class="content">
     <?php echo $content; ?> 
     </div>
  </div>
</div>
  <!-- footer -->
  <div id="footer"> Copyright &copy; <?php echo date('Y'); ?> by <?php echo SystemConfig::getValue('site_name')?>. All Rights Reserved.<br/>
  </div>
<!-- page -->
</body>
</html>