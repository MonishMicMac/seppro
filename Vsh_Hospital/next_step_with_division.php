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
	
		if(!isset($_REQUEST['last_id']))
	{

		echo "<script type='text/javascript'>alert('Invalid File no');window.location='upload_areawise_with_division.php'</script>"; 
	}
	
	$last_id=$_REQUEST['last_id'];
        require_once("include/select.php");
        $ad=new select1();
        $res=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
        $res1=$ad->view('dist_prod','','order by id desc');
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
<h2><i class="icon-edit"></i>Match Column Names</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="areawise_save_with_division.php" enctype="multipart/form-data" method="post"  name="frm"   >
<input type="hidden" name="command" id="command" value="xls" />
<input type="hidden" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" />
<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>" />
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo $id; ?>" />
<input type="hidden" name="dist_id" id="dist_id" value="<?php echo $id; ?>" />
<input type="hidden" name="record_id" id="record_id" value="<?php echo $last_id; ?>" />
<fieldset>

<div style="float:left; width:50%;">


<div class="control-group">
<label class="control-label" for="typeahead">Division<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="division_id" name="division_id" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/division/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>
</div>

<div class="control-group">
<label class="control-label" for="typeahead">Customer Code<span style="color:#FF0000;">*</span> </label>
<div class="controls"><select  id="cust_id" name="cust_id" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/customer code/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>
</div>

<div class="control-group">
<label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="pincode" name="pincode" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/pin/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>

<div class="control-group">
<label class="control-label" for="typeahead">Bill No<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="bill_no" name="bill_no" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/bill number/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>
</div>
<div class="control-group">
<label class="control-label" for="typeahead">Product id<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="pro_id" name="pro_id" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/product code/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>


<div class="control-group">
<label class="control-label" for="typeahead">Quantity<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="quantity" name="quantity" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/quantity/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>

<div class="control-group">
<label class="control-label" for="typeahead">Net Amount<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="net_amount" name="net_amount" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/net/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>
<div class="control-group">
<label class="control-label" for="typeahead">Free Quantity<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="free_quantity" name="free_quantity" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/free/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>




</div>
<div style="width:50%; float:right;">




<div class="control-group">
<label class="control-label" for="typeahead">Batch<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="batch_id" name="batch_id" data-rel="chosen">
<option value="">--Select Batch---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/batch/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>

<div class="control-group">
<label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="cust_name" name="cust_name" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/customer name/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>


<div class="control-group">
<label class="control-label" for="typeahead">Area Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="area_name" name="area_name" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/area name/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>

<div class="control-group">
<label class="control-label" for="typeahead">Bill Date<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="bill_date" name="bill_date" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/bill date/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>



<div class="control-group">
<label class="control-label" for="typeahead">Product Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="pro_name" name="pro_name" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/product name/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>
<div class="control-group">
<label class="control-label" for="typeahead">Sale Value<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="sale_value" name="sale_value" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/sale value/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>
<div class="control-group">
<label class="control-label" for="typeahead">Replacement Qty<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="replace_quantity" name="replace_quantity" data-rel="chosen">
<option value="">--Select Column---</option>
<?php
$a=mysql_query("select * from excel_heading where record_id='$last_id' order by heading_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
?>
<option value="<?php echo $row_a['heading_no']; ?>" <?php if(preg_match("/replacement/i", $row_a['heading_name'])) { echo "selected"; } ?>><?php echo ucwords($row_a['heading_name']); ?></option>
<?php  } } ?>  
</select></div>

</div>



<div class="control-group">
<label class="control-label" for="typeahead">Date Formate<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="date_format" name="date_format" >
<option value="">--Select Date Formate---</option>
<option value="d-m-y">dd-mm-yy</option>
<option value="d-m-y">dd-mm-yyyy</option>
<option value="d-m-y">dd/mm/yy</option>
<option value="d-m-y">dd/mm/yyyy</option>
<option value="y-m-d">yy/mm/dd</option>
<option value="y-m-d">yyyy/mm/dd</option>
<option value="y-m-d">yy-mm-dd</option>
<option value="y-m-d">yyyy-mm-dd</option>
</select></div>

</div>



</div>









<div class="control-group"><label class="control-label" for="typeahead"><span style="color:#FF0000;"></span> </label>
<div class="controls"></div></div>




<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" onClick="return valid();"  /> <input type="reset" class="btn" value="Cancel" /></div>

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
