<?php
//error_reporting(0);
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
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 900);
if(isset($_SESSION['wise']))
{
$wise=$_SESSION['wise'];
$manager=$_SESSION['manager'];
$from_date=$_SESSION['from_date'];
$to_date=$_SESSION['to_date'];
$from_string=strtotime($from_date);
$to_string=strtotime($to_date);
/*echo $from_date;
echo $from_string;
echo $to_date;

echo $to_string;*/
}
include("encrypt.php");
require_once("include/select.php");
$ad=new select1();
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
				<a href="report1.php"><img src="img/back.jpg" height="50" width="150" /></a>
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Overall Report Result</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
                   <?php
                   if($manager!='1')
                   {
                   ?>
					<table>
                    <?php
                    $b=mysql_query("select * from representative where rep_id='$manager'");
					$row_b=mysql_fetch_array($b);
                    ?>
                    <tr><td>Manager Name:</td><td><?php echo $row_b['rep_name']; ?></td></tr>
                    <tr><td>Executive Name:</td><td></td></tr>
                     <?php
					$a=mysql_query("select * from representative where rep_under='$manager'");
					$count_a=mysql_num_rows($a);
					if($count_a>0)
					{
					while($row_a=mysql_fetch_array($a))
					{
					?>
                     <tr><td></td><td><?php echo $row_a['rep_name']; ?></td></tr>
                    <?php
					}
					?>
                    <tr><td>From Date:</td><td><?php echo $from_date; ?></td></tr>
                    <tr><td>To Date:</td><td><?php echo $to_date; ?></td></tr>
                    <?php
					}
					else
					{
					?>
                     <tr><td></td><td>No One Under Him</td></tr>
                    <?php
					}
					
					?>
                   </table>
                   <?php
				   }
				   else
				   {
				   ?>
                   <table>
                   <tr><td>Manager List</td><td></td></tr>
                   <?php
				   $c=mysql_query("select * from representative where position='manager'");
				   $count_c=mysql_num_rows($c);
				   if($count_c>0)
				   {
				   while($row_c=mysql_fetch_array($c))
				   {
				   ?>
                   <tr><td></td><td><?php echo $row_c['rep_name']; ?></td></tr>
                   <?php
				   }
				   ?>
                    <tr><td>From Date:</td><td><?php echo $from_date; ?></td></tr>
                    <tr><td>To Date:</td><td><?php echo $to_date; ?></td></tr>
                   <?php
				   }
				   else
				   {
				   ?>
                   <tr><td></td><td>No Manager Yet</td></tr>
                   <?php
				   }
				   ?>
                   </table>
                   <?php
                   }
                   ?>
                    <a href="print1.php" target="_blank"> <img src="img/print.png" style="float:left; margin-bottom:10px; margin-left:10px;" /></a>
                     <a href="#"> <img src="img/export.png" style="float:left; margin-bottom:10px; margin-left:10px;" /></a>
                    <?php
				   if($manager=='1')
				   {
				   $rr="where position='manager' and mark_id='$m_id16'";
				   }
				   else
				   {
				   $rr="where rep_id='$manager' and mark_id='$m_id16'";
				   }
				   ?>
                  
<table class="table table-striped table-bordered bootstrap-datatable datatable" style="border:#CCCCCC solid 1px;">
<tr>
<th style="border:#CCCCCC solid 1px;">Representative Name</th>
<th style="border:#CCCCCC solid 1px;">Position</th>
<th style="border:#CCCCCC solid 1px;">Pincode</th>
<th style="border:#CCCCCC solid 1px;">Area Name</th>
<th style="border:#CCCCCC solid 1px;">Pharmacy Name</th>
<th style="border:#CCCCCC solid 1px;">Distributor Name</th>
<th style="border:#CCCCCC solid 1px;">Product Name</th>
<th style="border:#CCCCCC solid 1px;">Bill Number</th>
<th style="border:#CCCCCC solid 1px;">Bill Date</th>
<th style="border:#CCCCCC solid 1px;">Quantity</th>
<th style="border:#CCCCCC solid 1px;">Rpl Qnty</th>
<th style="border:#CCCCCC solid 1px;">Free Qnty</th>
<th style="border:#CCCCCC solid 1px;">Sale Value</th>
<th style="border:#CCCCCC solid 1px;">Net Amount</th>
</tr>



<?php 
$d=mysql_query("select * from representative " .$rr);
$count_d=mysql_num_rows($d);
if($count_d>0)
{

while($row_d=mysql_fetch_array($d))
{
$rep_id_d=$row_d['rep_id'];
?>
<tr>
<td><?php echo $row_d['rep_name']; ?></td>
<td><?php echo $row_d['position']; ?></td>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<?php
$e=mysql_query("select * from rep_area where rep_id='$rep_id_d'");
$count_e=mysql_num_rows($e);
if($count_e>0)
{
$tot_rep=0;
while($row_e=mysql_fetch_array($e))
{
$area_id=$row_e['area_id'];
$f=mysql_query("select * from pincode_list where id='$area_id'");
$row_f=mysql_fetch_array($f);
$f_pincode=$row_f['pincode'];
?>
<tr>
<td colspan="2"></td>
<td><?php echo $row_f['pincode']; ?></td>
<td><?php echo $row_f['area_name']; ?></td>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<?php
$g=mysql_query("select * from areawise_temp where pincode='$f_pincode' and  bill_date>='$from_date' AND bill_date<='$to_date'");
$count_g=mysql_num_rows($g);
if($count_g>0)
{
$tot_area=0;
while($row_g=mysql_fetch_array($g))
{
$dist_id123=$row_g['dist_id'];
$f1=mysql_query("select * from distributor where dis_id='$dist_id123'");
$row_f1=mysql_fetch_array($f1);
$net_amount=$row_g['net_amount'];
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td><?php echo ucwords($row_g['cust_name']); ?></td>
<td><?php echo ucwords($row_f1['dis_name']); ?></td>
<td><?php echo ucwords($row_g['pro_name']); ?></td>
<td><?php echo $row_g['bill_no']; ?></td>
<td><?php echo $row_g['bill_date']; ?></td>
<td><?php echo $row_g['quantity']; ?></td>
<td><?php echo $row_g['replace_quantity']; ?></td>
<td><?php echo $row_g['free_quantity']; ?></td>
<td><?php echo $row_g['sale_value']; ?></td>
<td><?php echo $row_g['net_amount']; ?></td>
</tr>
<?php
$tot_area=$net_amount+$tot_area;
}
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="9"><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;">Total/Area (<?php echo $row_f['pincode']; ?> / <?php echo $row_f['area_name']; ?>) </span></td>
<td><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;"><?php echo round($tot_area,2); ?></span></td>
</tr>
<?php
}
else
{
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="10">No Sales in this area ( <?php echo $row_f['pincode']; ?> / <?php echo $row_f['area_name']; ?> )</td></tr>
<?php
}
$tot_rep=$tot_area+$tot_rep;
}
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="9"><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;">Total/Representative (<?php echo $row_d['rep_name']; ?> / <?php echo $row_d['rep_id']; ?>) </span></td>
<td><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;"><?php echo round($tot_rep,2); ?></span></td>
</tr>
<?php
}
else
{
?>
<tr><td colspan="2"></td><td colspan="12">No Area Under this Representative</td></tr>
<?php
}
?>
<?php
$k=mysql_query("select * from representative where rep_under='$rep_id_d'");
$count_k=mysql_num_rows($k);
if($count_k>0)
{

while($row_k=mysql_fetch_array($k))
{
$rep_id_d12=$row_k['rep_id'];
?>
<tr bgcolor="#CCCCFF">
<td><?php echo $row_k['rep_name']; ?></td>
<td><?php echo $row_k['position']; ?></td>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<?php
$e12=mysql_query("select * from rep_area where rep_id='$rep_id_d12'");
$count_e12=mysql_num_rows($e12);
if($count_e12>0)
{
$tot_rep12=0;
while($row_e12=mysql_fetch_array($e12))
{
$area_id12=$row_e12['area_id'];
$f12=mysql_query("select * from pincode_list where id='$area_id12'");
$row_f12=mysql_fetch_array($f12);
$f_pincode12=$row_f12['pincode'];
?>
<tr>
<td colspan="2"></td>
<td><?php echo $row_f12['pincode']; ?></td>
<td><?php echo $row_f12['area_name']; ?></td>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<?php
$g12=mysql_query("select * from areawise_temp where pincode='$f_pincode12' and  bill_date>='$from_date' AND bill_date<='$to_date'");
$count_g12=mysql_num_rows($g12);
if($count_g12>0)
{
$tot_area12=0;
while($row_g12=mysql_fetch_array($g12))
{
$dist_id12312=$row_g12['dist_id'];
$f112=mysql_query("select * from distributor where dis_id='$dist_id12312'");
$row_f112=mysql_fetch_array($f112);
$net_amount12=$row_g12['net_amount'];
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td><?php echo ucwords($row_g12['cust_name']); ?></td>
<td><?php echo ucwords($row_f112['dis_name']); ?></td>
<td><?php echo ucwords($row_g12['pro_name']); ?></td>
<td><?php echo $row_g12['bill_no']; ?></td>
<td><?php echo $row_g12['bill_date']; ?></td>
<td><?php echo $row_g12['quantity']; ?></td>
<td><?php echo $row_g12['replace_quantity']; ?></td>
<td><?php echo $row_g12['free_quantity']; ?></td>
<td><?php echo $row_g12['sale_value']; ?></td>
<td><?php echo $row_g12['net_amount']; ?></td>
</tr>
<?php
$tot_area12=$net_amount12+$tot_area12;
if($tot_area12=='')
{
$tot_area1234=0;
}
if($tot_area12!='')
{
$tot_area1234=$tot_area12;
}

}
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="9"><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;">Total/Area (<?php echo $row_f12['pincode']; ?> / <?php echo $row_f12['area_name']; ?>) </span></td>
<td><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;"><?php echo round($tot_area12,2); ?></span></td>
</tr>
<?php
}
else
{
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="10">No Sales in this area ( <?php echo $row_f12['pincode']; ?> / <?php echo $row_f12['area_name']; ?> )</td></tr>
<?php
}
echo $tot_area1234;
$tot_rep12=$tot_area1234+$tot_rep12;
}
?>
<tr>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="9"><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;">Total/Representative (<?php echo $row_k['rep_name']; ?> / <?php echo $row_k['rep_id']; ?>) </span></td>
<td><span style="float:right; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#0000FF;"><?php echo round($tot_rep12,2); ?></span></td>
</tr>
<?php
}
else
{
?>
<tr><td colspan="2"></td><td colspan="12">No Area Under this Representative</td></tr>
<?php
}
?>



















<?php
}
}
else
{
?><tr><td colspan="2"></td><td colspan="12">No Representative Under this Representative</td></tr>
<?php
}
?>

<?php








}
}
else
{
?>
<tr><td colspan="14">No Manager</td></tr>
<?php
}
?>


                   
</table>
              
               
          <a href="report1.php"><img src="img/back.jpg" height="50" width="150" /></a>
               
         </div>
				<!--/span-->
			
			</div>
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
