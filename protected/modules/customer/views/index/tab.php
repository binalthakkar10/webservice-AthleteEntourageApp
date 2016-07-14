  <script>
  $(document).ready(function(){
	  $("#tabs").tabs();
	  var $myTabs = $("#tabs");
	  var type = '<?php echo $type; ?>';
	  
		$myTabs.tabs({ 
		                   // select: function(event, ui) { return allowTabChange; }, 
		                   // show: function(event, ui) { allowTabChange = true; }, 
		               }); 

		 

		if(type == 'coupon'){
			offsetTab(1);
		}
		if(type == 'credit'){
			offsetTab(2);
		}

		$('#tabs').tabs({ event: 'change' });
	  function offsetTab(offset){		  		  		   
		    var tab_num = $myTabs.tabs('option', 'selected'); 
		    var nextTab = tab_num + offset;
		     
		    if ( check_tab(nextTab) ) {
			  allowTabChange = true; 
		      $myTabs.tabs('select', nextTab); 
		    } 
		  }

	  function check_tab(tab_num){		          
		    return tab_num >= 0 && tab_num < $myTabs.tabs('length'); 
		  } 
  	});
  </script>
  
  
</head>
<body style="font-size:62.5%;">
<div class="business_title">Get Started With Your 30-Day Free Trial & Get Your Ad Live Today!</div>  
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span>Step 1-Business</span></a></li>
        <li><a href="#fragment-2"><span>Step 2-Coupon</span></a></li>
        <li><a href="#fragment-3"><span>Step 3-Credit Card Information</span></a></li>
    </ul>
    <div id="fragment-1">
      <?php
   		$model= new Business();
		$this->renderPartial('/business/tabbusiness',array('model' => $model,'type'=>'business'));
       ?>
     
    </div>
    <div id="fragment-2">
     <?php
   		$model= new Coupon();
		$this->renderPartial('/coupon/tabcoupon',array('model' => $model,'type'=>'coupon'));
       ?>
        
    </div>
    <div id="fragment-3">
      <?php
   		$model= new Creditcard();
		$this->renderPartial('/creditcard/index',array('model' => $model,'type'=>'credit'));
       ?>
     <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/customer/index" class="logo">Go To Home Page &#187</a></li>
    </div>
    
<script type="text/javascript">
$(function() {
	var $tabs = $('#tabs').tabs();
	var business = '<?php echo Yii::app()->controller->action->id; ?>';
	$(".ui-tabs-panel").each(function(i){
	  var totalSize = $(".ui-tabs-panel").size() - 1;
	  if (i != totalSize) {
	      next = i + 2;
	      if(business != 'tab'){
   		  	$(this).append("<a href='#' class='next-tab mover' rel='" + next + "'>Skip &#187;</a>");
	      }
	  }
	});
	$('.next-tab').click(function() { 
           $tabs.tabs('select', $(this).attr("rel"));
           return false;
       });
       

});
		


</script>
</div>



