<div id="header">	
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a id="main-menu-toggle" class="hidden-phone open"><i class="icon-reorder"></i></a>		
				<div class="row-fluid">
				<a class="brand span2" href="<?php echo Yii::app()->baseUrl.'/admin/index';?>"><span>Admin Panel</span></a>
				</div>		
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
								<div class="user">
									<span class="hello" style="color:#000000;">Welcome! &nbsp;&nbsp; <?php echo ucfirst(Yii::app()->admin->name);?></span>
								</div>
							</a>
							<?php /* ?>
							<ul class="dropdown-menu">
								<li class="dropdown-menu-title"></li>
								<li><a href="<?php echo Yii::app()->baseUrl.'/admin/index/logout';?>"><i class="icon-off"></i> Logout</a></li>
							</ul>
							<?php */ ?>
						</li>
					<?php /* ?>	<li><a href="<?php echo CController::createUrl('/admin/index/logout');?>" style="color:black; text-shadow:none;"><i class="icon-off"></i> Logout</a></li> <?php */ ?>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
</div>
<!-- start: JavaScript-->
	   <?php
	    $baseUrl = Yii::app()->baseUrl; 
	    $cs = Yii::app()->getClientScript();
	    // $cs->registerCssFile($baseUrl.'/js_new/jquery-2.0.2.min.js');
	    // $cs->registerCssFile($baseUrl.'/js_new/jquery-migrate-1.0.0.min.js');
	    // $cs->registerCssFile($baseUrl.'/js_new/jquery-ui-1.10.3.custom.min.js');
	    // $cs->registerCssFile($baseUrl.'/js_new/custom.min.js');
	   	   $controller = Yii::app()->controller->id;
		   $action = Yii::app()->controller->action->id;
		   if($controller != 'index' && $action != 'index'){
			  $cs->registerCssFile($baseUrl.'/js_new/jquery-2.0.2.min.js'); ?>
		   <?php } else { ?>
	    		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery-2.0.2.min.js" ?> ></script>
	       <?php } ?>
	       
	    <script src=<?php echo Yii::app()->baseUrl."/js_new/jquery-migrate-1.0.0.min.js" ?> ></script>
	    <script src=<?php echo Yii::app()->baseUrl."/js_new/jquery-ui-1.10.3.custom.min.js" ?> ></script>
	    <script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.ui.touch-punch.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/modernizr.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/bootstrap.min.js" ?>></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.cookie.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/fullcalendar.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.dataTables.min.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/excanvas.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.flot.js"?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.flot.pie.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.flot.stack.js" ?> ></script>
		<script src=<?php //echo Yii::app()->baseUrl."/js_new/jquery.flot.resize.min.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.flot.time.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/gauge.min.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.chosen.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.uniform.min.js" ?> ></script>		
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.cleditor.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.noty.js"?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.elfinder.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.raty.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.iphone.toggle.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.uploadify-3.1.min.js" ?>></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.gritter.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.imagesloaded.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.masonry.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.knob.modified.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.sparkline.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/counter.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/raphael.2.1.0.min.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/justgage.1.0.1.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.autosize.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/retina.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.placeholder.min.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/wizard.min.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/core.min.js" ?> ></script>
		<script src=<?php echo Yii::app()->baseUrl."/js_new/custom.min.js" ?> ></script>	
		<script src=<?php echo Yii::app()->baseUrl."/js_new/charts.min.js" ?> ></script>	 
		<script src=<?php echo Yii::app()->baseUrl."/js_new/jquery.yiigridview.js" ?> ></script>
		
	<!-- end: JavaScript-->