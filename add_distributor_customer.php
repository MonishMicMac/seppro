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
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('distributor_customer','','order by id desc');
$res1=$ad->count1('distributor_customer','','order by id desc');
$res2=$ad->view('district','','');
$res3=$ad->view('pincode_list','','');
$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
var x=document.getElementById("cust_name").value;
if(x==="null" || x==="")
{
alert("Please Enter Customer Name");
return false; 
}
var y=document.getElementById("dist_id").value;
if(y==="null" || y==="")
{
alert("Please Enter District Name");
return false; 
}
var z=document.getElementById("cust_addr").value;
if(z==="null" || z==="")
{
alert("Please Enter Customer Address");
return false; 
}
var a=document.getElementById("cont_no").value;
if(a==="null" || a==="")
{
alert("Please Enter Contact Number");
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
    <script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
var xmlhttp=false;	
try{
	xmlhttp=new XMLHttpRequest();
	}
	catch(e)	
	{		
	try{			
	xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
	try{
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e1){
	xmlhttp=false;
	}
	}
	}
 	return xmlhttp;
	}
//Function for Displaying cities
function getcat(title)
{
 var strURL="getInfo1.php?title="+title;
 //alert(strURL);
 var req = getXMLHTTP();
 if (req)
 {
     req.onreadystatechange = function()
     {
      if (req.readyState === 4)
      {
  // only if "OK"
  if (req.status === 200)
         {
     document.getElementById('sub_category').innerHTML=req.responseText;
  } else {
       alert("There was a problem while using XMLHTTP:\n" + req.statusText);
  }
       }
      };
   req.open("GET", strURL, true);
   req.send(null);
   } 
  }
</script>
    </head>

<body>
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>		
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Add Distributed Customer</h2>
<div class="box-icon">
</div>
</div><div style="float:right;"> <a href="import_customer.php">Import Distributed Customers in Excel</a></div>
<div style="float:right; margin-right:15px;"> <a href="excelformat/customer_test.csv">Download Distributed Customer Excel Sheet Format</a></div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_customer" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
 <fieldset>
<div class="control-group"><label class="control-label" for="typeahead">Distributor's Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="distrib_id" name="distrib_id" data-rel="chosen">
<option value="">--Select--</option>
<?php
while($row_res7=mysql_fetch_array($res7))
{
$dis_name1=$row_res7['dis_name'];
$dist_id1=$row_res7['dis_id'];
?>
<option value="<?php echo $dist_id1; ?>"><?php echo $dis_name1; ?></option>
<?php } ?> 
</select></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Distributors Customer's Id<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="dc_id" id="dc_id" maxlength="15"/></div></div>


<div class="control-group"><label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="cust_name" id="cust_name" /></div></div>
<?php 
if($res1>0)
{
$row_dis=mysql_fetch_array($res);
$cus_no=$row_dis['cust_id'];
$cus_next=$cus_no+1;
}
else
{
$cus_next=100001;
}
?>
<div class="control-group"><label class="control-label" for="typeahead">Customer's Id<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" value="<?php echo $cus_next; ?>" name="cust_id1" id="cust_id1" disabled></div></div>
<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $cus_next; ?>" />


<div class="control-group"><label class="control-label" for="typeahead">District Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="dist_id" name="dist_id" data-rel="chosen" onChange="getcat(this.value);">
<option value="">--Select--</option>
<?php
while($row_res=mysql_fetch_array($res2))
{
$dist_id=$row_res['id'];
$dist_name=$row_res['dist_name'];
$state_name=$row_res['state_name'];
?>
<option value="<?php echo $dist_id; ?>"><?php echo $state_name; ?>/<?php echo $dist_name; ?></option>
<?php } ?> 
</select></div></div>




<div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><div id="sub_category" class="sub_cat1"> </div>  </div></div>

<div class="control-group"><label class="control-label" for="typeahead">Customer Address<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="cust_addr" id="cust_addr" style="width:371px; height:160px;" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Contact No<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="cont_no" id="cont_no" onKeyPress="return onlyNumbers(event)" maxlength="15"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Email Id</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="email" id="email" onBlur="return validate_Email(this);" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Customer License No 1</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="cust_license1" id="cust_license1" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Valid Upto</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="valid1" id="valid1" style="width:150px;" /></div></div>


<div class="control-group"><label class="control-label" for="typeahead">Customer License No 2</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="cust_license2" id="cust_license2" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Valid Upto</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="valid2" id="valid2" style="width:150px;" /></div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return valid();" /> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset></form></div></div></div>

</div>
</div>

<hr>

<?php include("include/footer.php"); ?>
</div>
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="js/bootstrap-transition.js"></script>
	<script src="js/bootstrap-alert.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/bootstrap-scrollspy.js"></script>
	<script src="js/bootstrap-tab.js"></script>
	<script src="js/bootstrap-tooltip.js"></script>
	<script src="js/bootstrap-popover.js"></script>
	<script src="js/bootstrap-button.js"></script>
	<script src="js/bootstrap-collapse.js"></script>
	<script src="js/bootstrap-carousel.js"></script>
	<script src="js/bootstrap-typeahead.js"></script>
	<script src="js/bootstrap-tour.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src='js/fullcalendar.min.js'></script>
	<script src='js/jquery.dataTables.min.js'></script>
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<script src="js/jquery.chosen.min.js"></script>
	<script src="js/jquery.uniform.min.js"></script>
	<script src="js/jquery.colorbox.min.js"></script>
	<script src="js/jquery.cleditor.min.js"></script>
	<script src="js/jquery.noty.js"></script>
	<script src="js/jquery.elfinder.min.js"></script>
	<script src="js/jquery.raty.min.js"></script>
	<script src="js/jquery.iphone.toggle.js"></script>
	<script src="js/jquery.autogrow-textarea.js"></script>
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<script src="js/jquery.history.js"></script>
	<script src="js/charisma.js"></script>	
</body>
</html>
<?php
}
