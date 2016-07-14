<div id="msg_error" style="display:none; color:red; font-size:15px; "></div>
<div id="msg_success" style="display:none; color: green; font-size:15px;"></div>
<div class="form">
	<h5 style="color:#F05921;">Forgot Password</h5>
	<br>
	<div>
		<label class="required" for="Users_email">Email:</label>
		<input type="text" maxlength="30" id="Users_email" name="email">
	</div>
	<br>
	<div style="margin-left:265px;" class="row buttons">
		<input type="button" value="Submit" id="forgot_password" class="clsfindcity" name="yt0">
	</div>
</form>

</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".clsfindcity").click(function(){
		var email = $("#Users_email").val();
		$.ajax({
		    type: "POST",
		    url: '<?php echo Controller::createUrl('/register/getpasswordinfo');?>',
		    data:{'email':email},
		    success: function(response) {
		    	if(response == 1){
		    		$("#msg_error").show();	
					$("#msg_error").html("Email address does not exists.");
					return false;
			    }else{
				    $("#Users_email").val('');
			    	$("#msg_error").hide();
			    	$("#msg_success").show();
			    	$("#msg_success").html("New password is sent to your email address..");
				}
		    	
	     	}, error: function(jqXHR, textStatus, errorThrown){
	     		
	    	}
	     });
	});
});
</script>