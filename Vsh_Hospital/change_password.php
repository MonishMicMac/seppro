<?php
$GLOBALS["VddorbZAScwRCQBmKSYA"]=base64_decode("YXV0aG9yaXR5");$GLOBALS["GRRlWnNJKFdmQzMzyRqf"]=base64_decode("dV9pZDE2");$GLOBALS["vXjpuQeiRtPyECNULhgN"]=base64_decode("bV9pZDE2");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["CGbFgRIFcNnyLvvmfknU"]=base64_decode("Jw==");$GLOBALS["EOhzcWvLheQfQBegcXGg"]=base64_decode("c2VsZWN0ICogZnJvbSBhZG1pbiB3aGVyZSB1X25hbWU9Jw==");$GLOBALS["JyetPmcGcjfVOGKljFQB"]=base64_decode("PHNjcmlwdCB0eXBlPSd0ZXh0L2phdmFzY3JpcHQnPndpbmRvdy5sb2NhdGlvbj0naW5kZXgucGhwP2Vycic8L3NjcmlwdD4=");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]=base64_decode("aW5jbHVkZS90aXRsZS5waHA=");$GLOBALS["PBLWvAuEsHHzJxJcoBaP"]=base64_decode("aW5jbHVkZS9oZWFkZXIucGhw");$GLOBALS["ceLpMtfDxtWMNPunDlCC"]=base64_decode("aW5jbHVkZS9tZW51LnBocA==");$GLOBALS["UdElpHHfUPjqXpaaPuNN"]=base64_decode("aW5jbHVkZS9mb290ZXIucGhw");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); session_start(); $id=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $drHwlbyHHweIeFkcMuoY=$_SESSION[$GLOBALS["vXjpuQeiRtPyECNULhgN"]]; $VdXknABGclyLSLPDJkrm=$_SESSION[$GLOBALS["GRRlWnNJKFdmQzMzyRqf"]]; if(!isset($_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]])) { echo $GLOBALS["JyetPmcGcjfVOGKljFQB"]; } else { $FWNSzHhpxfDpXsIhloLE=mysql_query($GLOBALS["EOhzcWvLheQfQBegcXGg"].$drHwlbyHHweIeFkcMuoY.$GLOBALS["CGbFgRIFcNnyLvvmfknU"]); $itcvjioLnJTniDyFVVjM=mysql_fetch_array($FWNSzHhpxfDpXsIhloLE); $uQAETqIhDBBwfArdpUNy=$itcvjioLnJTniDyFVVjM[$GLOBALS["VddorbZAScwRCQBmKSYA"]]; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> <?php include($GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
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
function valid()
{
	var x=document.getElementById("c_pass").value;
	if(x=="null" || x=="")
	{
	alert("Please Enter Current Password");
	return false; 
	}
	var y=document.getElementById("n_pass").value;
	if(y=="null" || y=="")
	{
	alert("Please Enter New Password to set");
	return false; 
	}
	var z=document.getElementById("r_pass").value;
	if(z=="null" || z=="")
	{
	alert("Please Enter Confirmation Password");
	return false; 
	}
	
return true;
}
</script>
<script language="javascript">
function pswcheck()
{
var psw=document.getElementById("n_pass").value;
var rpsw=document.getElementById("r_pass").value;
if(psw!=rpsw)
{
alert("password Mismatch");
document.getElementById("n_pass").value="";
document.getElementById("r_pass").value="";
document.getElementById("n_pass").focus();
}
}
</script>
<script language="javascript">
var xmlhttp
function cpswcheck(str)
{
	
if (str.length==0)
  {
  document.getElementById("cp").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="rep_pass_check.php";
url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged_unameck;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged_unameck()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("cp").innerHTML=xmlhttp.responseText;
  
  if(xmlhttp.responseText=="Password Incorrect")
  {
  document.getElementById("c_pass").value="";
  }
  else
  {
  }
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
</script>
</head>

<body>
		<!-- topbar starts -->
 <?php include($GLOBALS["PBLWvAuEsHHzJxJcoBaP"]); ?>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
	 <?php include($GLOBALS["ceLpMtfDxtWMNPunDlCC"]); ?>
			
			<noscript>
				<div class="alert alert-block span10">
					<!--<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>-->
				</div>
			</noscript>
			
<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Change Password</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="update.php" enctype="multipart/form-data" method="post"   onsubmit="return valid();" name="frm" >
<input type="hidden" name="command" id="command" value="rep_password" />
<input type="hidden" name="u_id16" id="u_id16" value="<?php echo $VdXknABGclyLSLPDJkrm; ?>" />
<input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>" />


<fieldset>
<!--onKeyUp="AllowAlphabet()"-->


<div class="control-group"><label class="control-label" for="typeahead">Old Password<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="password" name="c_pass" id="c_pass"  onblur="cpswcheck(this.value);" /><div id="cp" class="cp"></div></div></div>



<div class="control-group"><label class="control-label" for="typeahead">New Password<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="password" name="n_pass" id="n_pass" /></div></div>


<div class="control-group"><label class="control-label" for="typeahead">Confirm Password<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="password" name="r_pass" id="r_pass" onBlur="pswcheck();" /></div></div>


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" /> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset></form></div></div></div>
<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div> <?php include($GLOBALS["UdElpHHfUPjqXpaaPuNN"]); ?>
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
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
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
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
</html> <?php } ?>
 