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
$res=$ad->view('product','where id='.$d_id,'');
$res1=$ad->view('marketer','','order by id desc');
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
var x=document.getElementById("mark_id").value;
if(x=="null" || x=="")
{
alert("Please Enter Marketer Name");
return false; 
}
var z=document.getElementById("pro_name").value;
if(z=="null" || z=="")
{
alert("Please Enter Product Name");
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
<h2><i class="icon-edit"></i>Edit Product</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"   onsubmit="return valid();" name="frm" >
<input type="hidden" name="command" id="command" value="edit_product" />
<input type="hidden" name="d_id" id="d_id" value="<?php echo $d_id; ?>" />
<fieldset>
<!--onKeyUp="AllowAlphabet()"-->
<?php
$row_pro=mysql_fetch_array($res);
$mark_i=$row_pro['mark_id'];
?>
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $mark_i; ?>" />

<div class="control-group"><label class="control-label" for="typeahead">Product Name<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="pro_name" id="pro_name" value="<?php echo $row_pro['pro_name']; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Product Id<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge disabled"  type="text" value="<?php echo $row_pro['dummy_id']; ?>" name="pro_id" id="pro_id" disabled></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Combinations<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="comb" id="comb" style="width:371px; height:160px;" value="<?php echo $row_pro['comb']; ?>" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Packing<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="packing" id="packing" value="<?php echo $row_pro['packing']; ?>" /></div></div>
<?php
$type1=$row_pro['type1'];
//echo $type1;
?>
<div class="control-group"><label class="control-label" for="typeahead">Type<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="type1" name="type1" data-rel="chosen">
<option value="">--Select--</option>
<option value="CAP" <?php if($type1=='CAP') { ?> selected<?php } ?>>CAP</option>
<option value="TAB" <?php if($type1=='TAB') { ?> selected<?php } ?>>TAB</option>
<option value="SYP" <?php if($type1=='SYP') { ?> selected<?php } ?>>SYP</option>
<option value="VIAL" <?php if($type1=='VIAL') { ?> selected<?php } ?>>VIAL</option>
<option value="INJ" <?php if($type1=='INJ') { ?> selected<?php } ?>>INJ</option>
<option value="AMB" <?php if($type1=='AMB') { ?> selected<?php } ?>>AMB</option>
<option value="OIN" <?php if($type1=='OIN') { ?> selected<?php } ?>>OIN</option>
<option value="CREAM" <?php if($type1=='CREAM') { ?> selected<?php } ?>>CREAM</option>
<option value="DROPS" <?php if($type1=='DROPS') { ?> selected<?php } ?>>DROPS</option>
</select>
</div></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit"  onClick="return valid();"/> 
<a href="view_product.php" ><input type="button" class="btn" value="Cancel" /></a></div>

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
