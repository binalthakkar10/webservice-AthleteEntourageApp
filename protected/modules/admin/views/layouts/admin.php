<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="description" content="letsgoout">
	<meta name="author" content="letsgoout">
	<meta name="keyword" content="letsgoout">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link href=<?php echo Yii::app()->baseUrl."/css_new/bootstrap.min.css" ?> rel="stylesheet">
	<link href=<?php echo Yii::app()->baseUrl."/css_new/bootstrap-responsive.min.css"?> rel="stylesheet">
	<link href=<?php echo Yii::app()->baseUrl."/css_new/style.min.css" ?> rel="stylesheet">
	<link href=<?php echo Yii::app()->baseUrl."/css_new/style-responsive.min.css" ?> rel="stylesheet">
	<link href=<?php echo Yii::app()->baseUrl."/css_new/retina.css" ?> rel="stylesheet">
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
	
	<!-- start: Favicon and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href=<?php echo Yii::app()->baseUrl."/ico/apple-touch-icon-144-precomposed.png" ?> >
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href=<?php echo Yii::app()->baseUrl."/ico/apple-touch-icon-114-precomposed.png" ?> >
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href=<?php echo Yii::app()->baseUrl."/ico/apple-touch-icon-72-precomposed.png" ?> >
	<link rel="apple-touch-icon-precomposed" href=<?php echo Yii::app()->baseUrl."/ico/apple-touch-icon-57-precomposed.png" ?> >
	<link rel="shortcut icon" href=<?php echo Yii::app()->baseUrl."/r_favicon.ico" ?>>
	<!-- end: Favicon and Touch Icons -->	
		
</head>

<body>
<!-- start: Header -->
<?php require_once('header.php')?>
<!-- End: Header -->
	<div class="maincont"> 
		
		<div id="sidebar-left" class="span2" style="margin-left:0px !important; width:177px !important; height:591px !important;">
		
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="<?php echo Yii::app()->baseUrl.'/admin/index';?>"><i class="icon-bar-chart"></i><span class="hidden-tablet">Network</span></a></li>
						<li class='users'><a href="<?php echo Yii::app()->baseUrl.'/admin/UserDetail/admin';?>"><i class="icon-user"></i><span class="hidden-tablet" id="users">Users</span></a></li>
							<li class='users'><a href="<?php echo Yii::app()->baseUrl.'/admin/CampaignPartner/admin';?>"><i class="icon-user-md"></i><span class="hidden-tablet" id="users">Hire</span></a></li>
						<li class='users'><a href="<?php echo Yii::app()->baseUrl.'/admin/Campaign/admin';?>"><i class="icon-reorder"></i><span class="hidden-tablet" id="users">Campaigns</span></a></li>
						<li class='users'><a href="<?php echo Yii::app()->baseUrl.'/admin/PostToExchange/admin';?>"><i class="icon-comment"></i><span class="hidden-tablet" id="users">Exchange Posts</span></a></li>
						
						<!--<li class='system_config'><a href="javascript:;"><i class="icon-star"></i><span class="hidden-tablet" id="system_config">Campaigns</span></a></li>
						<li class='system_config'><a href="javascript:;"><i class="icon-bullhorn"></i><span class="hidden-tablet" id="system_config">Posts</span></a></li>-->
						<li class='system_config'><a href="<?php echo Yii::app()->baseUrl.'/admin/Transaction/admin';?>"><i class="icon-credit-card"></i><span class="hidden-tablet" id="system_config">Payment</span></a></li>
					<!--	<li class='system_config'><a href="<?php echo Yii::app()->baseUrl.'/admin/PostToExchangePrice/admin';?>"><i class="icon-money"></i><span class="hidden-tablet" id="system_config">Price</span></a></li>-->
						<li class='system_config'><a href="<?php echo Yii::app()->baseUrl.'/admin/Cashout/admin';?>"><i class="icon-external-link"></i><span class="hidden-tablet" id="system_config">Cashout</span></a></li>
						<li class='system_config'><a href="<?php echo Yii::app()->baseUrl.'/admin/Sponser/admin';?>"><i class="icon-magic"></i><span class="hidden-tablet" id="system_config">Sponsor</span></a></li>
					<li class='system_config'><a href="<?php echo Yii::app()->baseUrl.'/admin/PackagePrice/admin';?>"><i class="icon-money"></i><span class="hidden-tablet" id="system_config">Package Price</span></a></li>
					<!--	<li class='system_config'><a href="javascript:;"><i class="icon-desktop"></i><span class="hidden-tablet" id="system_config">Website</span></a></li>
						<li class='system_config'><a href="javascript:;"><i class="icon-wrench"></i><span class="hidden-tablet" id="system_config">Settings</span></a></li>-->
						<li><a href="<?php echo Yii::app()->baseUrl.'/admin/index/logout';?>"><i class="icon-off"></i><span class="hidden-tablet">Logout</span></a></li>
					</ul>
				</div>
			</div>
		
			<div id="content" class="span10" style="width:1000px !important;">
			<?php $controller = Yii::app()->controller->id;
				  $action = Yii::app()->controller->action->id;
				  if($controller != 'index' && $action != 'index'){ ?>
			<div class="breadcrumb" style="width:300px;">
				<?php  $this->widget('application.extensions.inx.AdminBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				
				));
					//m($this); //->breadcrumbs->homeLink = 'admin';
				?>
			 </div>
		 
		
			 <div class="content_left">
				 <div id="sidebar">
			        <?php
						$this->beginWidget('zii.widgets.CPortlet', array(
						));
						$this->widget('zii.widgets.CMenu', array(
							'items'=>$this->menu,
							'htmlOptions'=>array('class'=>'operations'),
						));
						$this->endWidget();
					?>
			      </div>
		      </div>
	      	<?php } ?>
	     
		 <?php echo $content; ?>
		</div>
			<!--/.fluid-container-->
			<!-- Require the footer -->
			<?php require_once('footer.php')?>
	</div>
		
	

		    
</body>
</html>