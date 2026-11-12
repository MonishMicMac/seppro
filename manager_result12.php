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
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 900);
if(isset($_SESSION['wise']))
{
$wise=$_SESSION['wise'];
$dist_id14=$_SESSION['dist_id'];
$rep_id=$u_id16;
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
			<a href="repsale_search.php"><img src="img/back.jpg" height="50" width="150" /></a>       
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Overall Report Result</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
                         <table>
                    <tr><td>Result For :</td><td>Area wise Product Report</td></tr>
                    <?php 
					$rs=mysql_query("select * from representative where rep_id='$rep_id'");
					$row_rs=mysql_fetch_array($rs);
					?>
                    <tr><td></td><td>Representative Name :</td><td><?php echo $row_rs['rep_name']; ?></td></tr>
                     <tr><td></td><td>From Date :</td><td><?php echo $from_date; ?></td></tr>
                     <tr><td></td><td>To Date :</td><td><?php echo $to_date; ?></td></tr>
                    </table>
                     <a href="print5.php" target="_blank"> <img src="img/print.png" style="float:left; margin-bottom:10px; margin-left:10px;" /></a>
                     <a href="#"> <img src="img/export.png" style="float:left; margin-bottom:10px; margin-left:10px;" /></a>

<table class="table table-striped table-bordered bootstrap-datatable datatable">
<tbody>
<tr>
<th>Product Name</th>
<th>Pincode</th>
<th>Area Name</th>
<th>Distributor Name</th>
<th>Pharmacy Name</th>
<th>Bill Date</th>
<th>Bill No</th>
<th>Quantity</th>
<th>Sale Value</th>
<th>Net Amount</th>
<th>Rpl Qnty</th>
<th>Free Qnty</th>
</tr>
<?php
$x=mysql_query("select * from rep_area where rep_id='$rep_id'");
$count_x=mysql_num_rows($x);
if($count_x>0)
{
while($row_x=mysql_fetch_array($x))
{
$area_id=$row_x['area_id'];
$y=mysql_query("select * from pincode_list where id='$area_id'");
$row_y=mysql_fetch_array($y);
$pin=$row_y['pincode'];
?>
<?php
$a=mysql_query("select DISTINCT pro_id from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and  pincode='$pin' and dist_id='$dist_id14' order by pro_name asc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{
while($row_a=mysql_fetch_array($a))
{
$pro_id=$row_a['pro_id'];
$b=mysql_query("select * from dist_prod where pro_id='$pro_id'");
$row_b=mysql_fetch_array($b);
$our_id=$row_b['our_id'];
if($our_id=='')
{
$d=mysql_query("select * from areawise_temp where pro_id='$pro_id'  and  m_id16='$m_id16'  and dist_id='$dist_id14'");
$row_d=mysql_fetch_array($d);
$product_name=$row_d['pro_name'];
}
else
{
$c=mysql_query("select * from product where id='$our_id'");
$row_c=mysql_fetch_array($c);
$product_name=$row_c['pro_name'];
}

$b65=mysql_query("select * from  representative where rep_id='$rep_id'");
$row_b65=mysql_fetch_array($b65);
?>
<tr>
<td><?php echo $row_b65['rep_name']; ?>(Manager)</td>
<td <?php if($our_id=='') { ?> style="color:#FF0000;" <?php } ?>><?php echo $product_name; ?></td>
<td colspan="11"></td>
</tr>
<?php
$e=mysql_query("select DISTINCT pincode from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pro_id='$pro_id' and pincode='$pin' and dist_id='$dist_id14' order by area_name asc");
$count_e=mysql_num_rows($e);
if($count_e>0)
{
$tot_pincode=0;
while($row_e=mysql_fetch_array($e))
{
$pincode=$row_e['pincode'];

$f=mysql_query("select * from  pincode_list where pincode='$pincode'");
$count_f=mysql_num_rows($f);
if($count_f>0)
{
$row_f=mysql_fetch_array($f);
$area_name=$row_f['area_name'];
}
else
{
$g=mysql_query("select * from areawise_temp where pincode='$pincode'  and  m_id16='$m_id16' and dist_id='$dist_id14'");
$row_g=mysql_fetch_array($g);
$area_name=$row_g['area_name'];
}
?>
<tr>
<td colspan="2"></td>
<td><?php echo $pincode; ?></td>
<td <?php if($count_f=='0') { ?> style="color:#FF0000;" <?php } ?>><?php echo $area_name; ?></td>
<td colspan="9"></td>
</tr>
<?php
$h=mysql_query("select * from  areawise_temp where   bill_date>='$from_date' AND bill_date<='$to_date'  and  m_id16='$m_id16' and pro_id='$pro_id' and pincode='$pincode' and dist_id='$dist_id14' order by cust_name asc");
$count_h=mysql_num_rows($h);
if($count_h>0)
{
$tot_pharma=0;
while($row_h=mysql_fetch_array($h))
{
$cust_id=$row_h['cust_id'];
$dist_id=$row_h['dist_id'];
$net_amount=$row_h['net_amount'];
$a3=mysql_query("select dis_name  from   distributor  where  dis_id='$dist_id'");
$row_a3=mysql_fetch_array($a3);
$dis_name=$row_a3['dis_name'];
$a6=mysql_query("select * from  customer  where  dc_id='$cust_id'");
$count_a6=mysql_num_rows($a6);
if($count_a6=='0')
{
$a7=mysql_query("select cust_name  from  areawise_temp  where  cust_id='$cust_id'  and  m_id16='$m_id16'");
$row_a7=mysql_fetch_array($a7);
$customer_name=$row_a7['cust_name'];
}
else
{
$row_a6=mysql_fetch_array($a6);
$customer_name=$row_a6['cust_name'];
}
?>
<tr>
<td colspan="4"></td>
<td><?php echo $dis_name; ?></td>
<td <?php if($count_a6=='0') { ?> style="color:#FF0000;" <?php } ?>><?php echo $customer_name; ?></td>
<td><?php echo $row_h['bill_no']; ?></td>
<td><?php echo $row_h['bill_date']; ?></td>
<td><?php echo $row_h['quantity']; ?></td>
<td><?php echo $row_h['sale_value']; ?></td>
<td><?php echo $row_h['net_amount']; ?></td>
<td><?php echo $row_h['replace_quantity']; ?></td>
<td><?php echo $row_h['free_quantity']; ?></td>
</tr>
<?php
}
$tot_pharma=$net_amount+$tot_pharma;
}
?>
<tr><td colspan="2"></td><td colspan="11">
<span style="float:right; color:#0000FF; font-size:14px; font-weight:bold;">Total / Area (<?php echo $area_name; ?>) : <?php echo $tot_pharma;  ?></span>
</td></tr>
<?php
$tot_pincode=$tot_pharma+$tot_pincode;
}
?>
<tr><td colspan="13">
<span style="float:right; color:#FF0000; font-size:16px; font-weight:bold;">Total / Product (<?php echo $product_name; ?>) : <?php echo $tot_pincode;  ?></span>
</td></tr>
<?php
}
?>
<?php
}
}
?>
<?php
}
}
?>

</tbody>
</table>    
  <a href="repsale_search.php"><img src="img/back.jpg" height="50" width="150" /></a>             
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
