<?php
$GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]=base64_decode("aW5jbHVkZS90aXRsZS5waHA=");$GLOBALS["bMtoQubpGhmVCYaZHurr"]=base64_decode("ZXJy");
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 <?php include($GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]); ?>
	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>

	<link rel="shortcut icon" href="img/favicon1.ico">
    <script type="text/javascript">
function validateForm()
{
	var y=document.getElementById("u_name").value;
	if(y=="null" || y=="")
	{
	alert("Please Enter Your User Name");
	return false; 
	}
	var y=document.getElementById("pass").value;
	if(y=="null" || y=="")
	{
	alert("Password Field Should not be Empty");
	return false; 
	}
}
</script>
    <script type="text/javascript">
        function hello(val)
        {
            if(val==='1')
            {
            var i="http://localhost/Yuvaraj/ssr-full-project/ssr/ceo.php";
            window.location.href=i;
            }
            if(val==='2')
            {
            var i="http://localhost/Yuvaraj/ssr-full-project/ssr/admin.php";
            window.location.href=i;
            }
			if(val==='4')
            {
            var i="http://localhost/Yuvaraj/ssr-full-project/ssr/rep.php";
            window.location.href=i;
            }
        }
    </script>
    
    <script type="text/javascript">
        function change_url1(val)
		 {
		 if(val===1)
		 {
	/*	 var i="http://www.micandmac.in/sample_company/ceo.php";*/
		 var i="http://localhost/Yuvaraj/ssr-full-project/ssr/ceo.php";
            window.location=i;
        }
		
		
		}
    </script>
		
</head>

<body>
		<div class="container-fluid">
		<div class="row-fluid">
		
			<div class="row-fluid">
				<div class="span12 center login-header">
					<h2>Welcome Representative!!</h2>
				</div><!--/span-->
			</div><!--/row-->
			
			<div class="row-fluid">
				<div class="well span5 center login-box">
                <?php if(isset($_REQUEST[$GLOBALS["bMtoQubpGhmVCYaZHurr"]])) { ?>
					<div class="alert alert-info">
						Your session Expired. Please Login to continue
					</div>
				 <?php } ?>
                    <form name="frm" action="login_check.php" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this);">
						<input type="hidden" name="command" id="command" value="login" />
						<fieldset>                      
                        
							<div class="input-prepend" title="Username" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span5" name="u_name" id="u_name" type="text"/>
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input class="input-large span5" name="pass" id="pass" type="password" />
							</div>
							<div class="clearfix"></div>

							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" class="btn btn-primary">Login</button><!-- <br>
                            <br><a href="forgot_password.php">Forgot Your Password ?</a>-->
                            
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
				</div><!--/fluid-row-->
		
	</div><!--/.fluid-container-->

	
	<script src="js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<!--<script src='js/jquery.dataTables.min.js'></script>-->

	<!-- chart libraries start -->
	
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	
		
</body>
</html>
