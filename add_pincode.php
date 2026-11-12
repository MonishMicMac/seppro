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
$res=$ad->view('marketer','','order by id desc');
$dist=$ad->view('district','','order by id desc');
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
var x=document.getElementById("state_name").value;
if(x === "null" || x === "")
{
alert("Please Enter State Name");
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
<h2><i class="icon-edit"></i>Add Pincode</h2>
<div class="box-icon">
</div>
</div>
<div style="height:40px;" >
    <div style="float:right;"> <a href="import_pincode.php">Import Pin code in Excel</a></div>
<div style="float:right; margin-right:15px;"> <a href="excelformat/area.csv">Download Area Pin code Excel Sheet Format</a></div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="add_pincode" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->


 <div class="control-group"><label class="control-label" for="typeahead">State Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="state_name" name="statename" data-rel="chosen">
<option value="">--Select--</option>
<option value="tamilnadu">Tamilnadu</option>
<option value="andhrapradesh">Andhra pradesh</option>
<option value="kerala">Kerala</option>
<option value="karnataka">Karnataka</option>
</select>
</div></div>



<div class="control-group"><label class="control-label" for="typeahead">Select Category<span style="color:#FF0000;">*</label><div class="controls">
<label class="radio"><input type="checkbox" name="add" id="add" value="2" > Add Area Pincode </label></div></div>

 

    <div id="fill" style="display:none;">
    
     <div class="control-group"><label class="control-label" for="typeahead">District Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="dist_id" name="dist_id" data-rel="chosen">
<option value="">--Select--</option>
<?php
while($dist_res=mysql_fetch_array($dist))
{
$dist_id=$dist_res['id'];
$dist_name=$dist_res['dist_name'];
$state_name=$dist_res['state_name'];
?>
<option value="<?php echo $dist_id; ?>"><?php echo $dist_name; ?></option>
<?php } ?> 
</select></div></div>


 <div class="control-group"><label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="area_name" id="area_name" /></div></div>

 <div class="control-group"><label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="pincode" id="pincode" onKeyPress="return onlyNumbers(event)" maxlength="6"/></div></div>

</div>

 

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" onClick="return valid();"  /> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset></form></div></div></div>
<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
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
        <script type="text/javascript">
            $(document).ready(function(){
                $("#add").click(function(){
                    $("#fill").toggle();
                });
            });
        </script>    
	
		
</body>
</html>
<?php
}
?>
