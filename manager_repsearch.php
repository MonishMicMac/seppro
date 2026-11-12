<?php
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	$u_id16=$_SESSION['u_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{

if(isset($_POST['command']))
{
$command=$_POST['command'];
if($command=='report')
{
$wise=$_POST['wise'];
$rep_id=$_POST['rep_id'];
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];

$_SESSION['wise']=$wise;
$_SESSION['rep_id']=$rep_id;
$_SESSION['from_date']=$from_date;
$_SESSION['to_date']=$to_date;
if($wise=='1')
{
if($rep_id=='1')
{
echo "<script type='text/javascript'>window.location='manager_result1.php'</script>";
}
elseif($rep_id=='2')
{
echo "<script type='text/javascript'>window.location='manager_result2.php'</script>";
}
else
{
echo "<script type='text/javascript'>window.location='manager_result1.php'</script>";
}

}
if($wise=='2')
{
if($rep_id=='1')
{
echo "<script type='text/javascript'>window.location='manager_result3.php'</script>";
}
elseif($rep_id=='2')
{
echo "<script type='text/javascript'>window.location='manager_result4.php'</script>";
}
else
{
echo "<script type='text/javascript'>window.location='manager_result3.php'</script>";
}
}
}
}
include("encrypt.php");
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('representative','where rep_under='.$u_id16,'order by rep_name asc');
$res1=$ad->count1('representative','where rep_under='.$u_id16,'');
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
<link rel="stylesheet" type="text/css" media="all" href="date picker/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="date picker/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">

	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from_date",
			dateFormat:"%Y-%m-%d"
			});	
			
			new JsDatePick({
			useMode:2,
			target:"to_date",
			dateFormat:"%Y-%m-%d"
			});	
			
	};
	</script>
    <script type="text/javascript">
function valid()
{
var x=document.getElementById("wise").value;
if(x=="null" || x=="")
{
alert("Please Enter Categroy name");
return false; 
}
var b=document.getElementById("rep_id").value;
if(b=="null" || b=="")
{
alert("Please Enter Representative name");
return false; 
}
var z=document.getElementById("from_date").value;
if(z=="null" || z=="")
{
alert("Please Enter From Date");
return false; 
}
var a=document.getElementById("to_date").value;
if(a=="null" || a=="")
{
alert("Please Enter To Date");
return false; 
}
return true;
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
<h2><i class="icon-edit"></i>Representative Wise Search</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="manager_repsearch.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="report" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->


<div class="control-group"><label class="control-label" for="typeahead">Category<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="wise" name="wise" data-rel="chosen">
<option value="1">Areawise Product Report</option>
<option value="2">Productwise Area Report</option>
</select></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Rep Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="rep_id" name="rep_id" data-rel="chosen">
<option value="">--Select Rep--</option>
<option value="1">My Performance</option>
<option value="2">Team Performance</option>
<?php
if($res1>0)
{
while($row_res=mysql_fetch_array($res))
{
?>
<option value="<?php echo $row_res['rep_id']; ?>"><?php echo ucwords($row_res['rep_name']); ?></option>
<?php } ?>

<?php } ?>
</select>
</div></div>


<div class="control-group"><label class="control-label" for="typeahead">Report From:<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="from_date" id="from_date" />Report To:<span style="color:#FF0000;">*</span><input class="input-xlarge focused"  type="text" name="to_date" id="to_date" /></div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="Search"   onClick="return valid();"  /> </div>

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
