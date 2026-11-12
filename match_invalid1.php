<?php
error_reporting(0);
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{


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
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Product List</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
<form name="frm" action="invalid_save.php" method="post" enctype="multipart/form-data" />
<input type="hidden" name="command" id="command" value="update_invalid" />

						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
                           <tr>
                           <th colspan="7">Invalid Pinlist</th></tr>
                            <tr>
                            <th>i_id</th>
                             <th>a_id</th>
							  <th>Distributor Name</th>
                              	<th>Given Pincode</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Area Name</th>
                               <th>Our Pincode List</th></tr>
						  </thead>   
						  <tbody>
                          <?php
						  $i=1;
						  //echo "select * from invalid_total where status1='1'";
						  $res=mysql_query("select * from invalid_total where status1='1'");
						  while($row_res=mysql_fetch_array($res))
						  {
						$rr_id=$row_res['id'];
						$rrr_id=$row_res['r_id'];
						
						//echo "select * from areawise_temp where id='$rrr_id'";
						$aa=mysql_query("select * from areawise_temp where id='$rrr_id'");
						$row_a=mysql_fetch_array($aa);
						$dist_id=$row_a['dist_id'];
						$cust_name=$row_a['cust_name'];
						$pincode=$row_a['pincode'];
						$area_name=$row_a['area_name'];
						$pro_name=$row_a['pro_name'];
						$quantity=$row_a['quantity'];
						$b=mysql_query("select * from distributor where dis_id='$dist_id'");
						$row_b=mysql_fetch_array($b);
						
						
						?>
							<tr> 
                            <td><?php echo $rr_id; ?> </td>
                             <td><?php echo $rrr_id; ?> </td>
                           		<td>
								<input type="hidden" name="i_id[<?php echo  $i; ?>]" id="i_id" value="<?php echo  $rr_id; ?>" />
                                <input type="hidden" name="a_id[<?php echo  $i; ?>]" id="a_id" value="<?php echo  $rrr_id; ?>" />
								<?php echo $row_b['dis_name']; ?></td>
                                <td><?php echo $pincode; ?> </td>
                                <td><?php echo $cust_name; ?></td>
                                <td><?php echo $pro_name; ?></td>
                                 <td><?php echo $quantity; ?></td>
                                <td><?php echo $area_name; ?></td>
                                <td>
                                
                                <select name="our_id[<?php echo  $i; ?>]" id="our_id[<?php echo  $i; ?>]"  data-rel="chosen" >
                                <option value="">--Select--</option>
                                <?php 
								$a=mysql_query("select * from pincode_list order by id desc");
								
								while($row_a=mysql_fetch_array($a))
								{
								?>
                                <option value="<?php echo $row_a['pincode']; ?>"><?php echo $row_a['area_name']; ?>/<?php echo $row_a['pincode']; ?></option>
                                <?php
								}
								?>
                                </select>
                                </td></tr>
                                
							<?php
							$i++;
							}
							?>
                          
							
						  </tbody>
					  </table>  
                      <table>
                      <tr><td></td><td colspan="2" style="float:right;"><input type="submit" name="submit" id="submit" value="update" style="float:right;"   class="btn btn-primary"/></td></tr>
                      </table>
                      </form>  
                      
					</div>
				</div><!--/span-->
			
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
