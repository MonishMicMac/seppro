<?php
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
	include("encrypt.php");
	if(isset($_REQUEST['d_id'])) 
	{
	$d_id=decrypt($_REQUEST['d_id']);
	}
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('distributor','where id='.$d_id,'');
//echo $res;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
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
var x=document.getElementById("dis_name").value;
if(x=="null" || x=="")
{
alert("Please Enter Distributor Name");
return false; 
}
var z=document.getElementById("dis_abb").value;
if(z=="null" || z=="")
{
alert("Please Enter Distributor Abbrevation");
return false; 
}
var c=document.getElementById("reg_addr").value;
if(c=="null" || c=="")
{
alert("Please Enter Registered office Address");
return false; 
}
var d=document.getElementById("reg_area").value;
if(d=="null" || d=="")
{
alert("Please Enter Area Name");
return false; 
}
var f=document.getElementById("reg_pin").value;
if(f=="null" || f=="")
{
alert("Please Enter Area Pincode");
return false; 
}
var i=document.getElementById("corp_addr").value;
if(i=="null" || i=="")
{
alert("Please Enter Corporate office Address");
return false; 
}
var j=document.getElementById("corp_area").value;
if(j=="null" || j=="")
{
alert("Please Enter Area Name");
return false; 
}
var k=document.getElementById("corp_pin").value;
if(k=="null" || k=="")
{
alert("Please Enter Area Pincode");
return false; 
}
var g=document.getElementById("cp_name").value;
if(g=="null" || g=="")
{
alert("Please Enter Contact Person Name");
return false; 
}

var y=document.getElementById("").value;
if(y=="null" || y=="")
{
alert("Please Enter Email Id");
return false; 
}
var a=document.getElementById("cp_no").value;
if(a=="null" || a=="")
{
alert("Please Enter Contact person Number");
return false; 
}
var b=document.getElementById("class_name").value;
if(b=="null" || b=="")
{
alert("Please Select Classified Name");
return false; 
}
return true;
}

function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true; }

function validate_Email(email) {
var x=document.getElementById("email").value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
{
alert("Not a valid e-mail address");
document.getElementById("email").value="";
return false;
}
return true;
}
</script>
<link rel="stylesheet" type="text/css" media="all" href="date picker/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="date picker/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date01",
			dateFormat:"%d-%m-%Y"
			});	
			
	};
	</script>
    <script type="text/javascript">
function AllowAlphabet(){
               if (!frm.f_name.value.match(/^[a-zA-Z]+$/) && frm.f_name.value !="")
               {
                    frm.f_name.value="";
                    frm.f_name.focus(); 
                    alert("Please Enter only alphabets in text");
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
var url="pass_check.php";
url=url+"?q="+str;
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
  if(xmlhttp.responseText=="Not Avaliable")
  {
  document.getElementById("dis_abb").value="";
  alert("Already used by another Distributor");
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
	<?php include("include/header.php"); ?>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
		<?php include("include/menu.php"); ?>
			
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
<h2><i class="icon-edit"></i>Edit Distributors</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"   onsubmit="return valid();" name="frm" >
<input type="hidden" name="command" id="command" value="edit_distributor" />
<input type="hidden" name="d_id" id="d_id" value="<?php echo $d_id; ?>" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->
<?php

$row_dis=mysql_fetch_array($res);
?>
<div class="control-group"><label class="control-label" for="typeahead">Distributor's Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="dis_name" id="dis_name" value="<?php echo $row_dis['dis_name']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Distributor's Id<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" value="<?php echo $row_dis['dis_id']; ?>" name="dis_id" id="dis_id" disabled></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Distributor's Abbrevation<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" name="dis_abb" id="dis_abb"  onblur="cpswcheck(this.value);" maxlength="4" disabled value="<?php echo $row_dis['dis_abb']; ?>" /><div id="cp" class="cp"></div></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Registered Office Address<span style="color:#FF0000;">*</span> </label>
<div class="controls"><textarea rows="4" cols="20" name="reg_addr" id="reg_addr"><?php echo $row_dis['reg_addr']; ?></textarea></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="reg_area" id="reg_area" value="<?php echo $row_dis['reg_area']; ?>" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Area Pincode<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="reg_pin" id="reg_pin" onKeyPress="return onlyNumbers(event)" maxlength="6"  value="<?php echo $row_dis['reg_pin']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Corporate Office Address<span style="color:#FF0000;">*</span> </label>
<div class="controls"><textarea rows="4" cols="20" name="corp_addr" id="corp_addr"><?php echo $row_dis['corp_addr']; ?></textarea></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="corp_area" id="corp_area"  value="<?php echo $row_dis['corp_area']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Area Pincode<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="corp_pin" id="corp_pin" onKeyPress="return onlyNumbers(event)" maxlength="6" value="<?php echo $row_dis['corp_pin']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Contact Person Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="cp_name" id="cp_name"  value="<?php echo $row_dis['cp_name']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Contact Person Number<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="cp_no" id="cp_no" onKeyPress="return onlyNumbers(event)" maxlength="10" value="<?php echo $row_dis['cp_no']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Alternate No1 </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="alternate_no1" id="alternate_no1" onKeyPress="return onlyNumbers(event)" maxlength="10" value="<?php echo $row_dis['alternate_no1']; ?>" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Alternate No2 </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="alternate_no2" id="alternate_no2" onKeyPress="return onlyNumbers(event)" maxlength="10" value="<?php echo $row_dis['alternate_no2']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Email Id</label>
<div class="controls"><input class="input-xlarge focused"  type="email"  name="email" id="email" onBlur="return validate_Email(this);" value="<?php echo $row_dis['email']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Fax No </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="fax_no" id="fax_no" value="<?php echo $row_dis['fax_no']; ?>"/></div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" />
<a href="view_distributor.php"><input type="button" class="btn" value="Cancel" /></a>
 
 
 
 </div>

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
		</div>
<?php include("include/footer.php"); ?>
		
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
</html>
<?php
}
?>
