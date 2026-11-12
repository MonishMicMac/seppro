<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{

	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{

	if(isset($_POST['command']))
	{
		$command=$_POST['command'];
		if($command=='product_search')
		{
			$mark_id=$_POST['mark_id'];
			$_SESSION['mark_id']=$mark_id;
			echo "<script type='text/javascript'>window.location='product_search.php'</script>";
		}
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

				<div>		
					<div class="box span12">
						<div class="box-header well" data-original-title>
							<h2><i class="icon-user"></i> Customers List</h2>
							<div class="box-icon">

							</div>
						</div>
						<br/>
						<form name="thisForm" action="" method="post">
							<table style="width:100%;">
								<tr>

									<td>Representative</td>
									<td>:</td>
									<td><select id="rep_name" name="rep_name" onChange="region(this.value);" data-rel="chosen">
										<option value="">--Select--</option>
										<?php
										$res=mysql_query("SELECT * FROM representative");
										while($row_res=mysql_fetch_array($res)) {
											$rep_name1=$row_res['rep_name'];
											$id=$row_res['id'];
											?>
											<option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
											<?php } ?> 
										</select><script>document.thisForm.rep_name.value="<?php echo $_REQUEST["rep_name"]; ?>"</script></td>
										

									</tr>
								</table>
							</form>
							<div>&nbsp;</div>      
							<div style="height:auto;" id="consolidated1">
								<?php
								if(@$_REQUEST["rep_name"]==""){
									$res=mysql_query("SELECT * FROM clinetcreation WHERE 1 ")or die(mysql_error());
								}
								else{
									$res=mysql_query("SELECT * FROM clinetcreation WHERE 1 AND repid='".@$_REQUEST['rep_name']."'")or die(mysql_error());
								}?>
								<div style='float:right; width: 50px;'><a href="customers_list_diabetik_excel.php?repid=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
								<table class="table table-striped table-bordered bootstrap-datatable datatable" >
									<thead>
										<tr>
											<th>S.NO</th>
											<th>DR NAME</th>
											<th>CNT NO</th>
											<th>EMAIL</th>
											<th>HOSPITAL NAME</th>
											<th>ADDRESS</th>
											<th>PINCODE</th>
											<th>TYPE</th>
											<th>NEW/EX</th>
										</tr>
									</thead>   
									<tbody>
										<?php
										$i=1;


										// $res=mysql_query("SELECT * FROM clinetcreation WHERE repid='".$_REQUEST["rep_name"]."' ");

										while($row_res=mysql_fetch_array($res)){

											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row_res['name']; ?></td>
												<td><?php echo $row_res['mobileno']; ?></td>
												<td><?php echo $row_res['emailid']; ?></td>
												<td><?php echo $row_res['companyname']; ?></td>
												<td><?php echo $row_res['address'].','.$row_res['Addrtess_line1'].','.$row_res['Addrtess_line2']; ?></td>
												<td><?php echo $row_res['pincode']; ?></td>
												<td><?php echo $row_res['type']; ?></td>
												<td><?php echo $row_res['typeofcustomer']; ?></td>
											</tr>
											<?php
											$i++;
										}
										?>

									</tbody>
								</table>  


							</div> 

						</div>

					</div>

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
		<script type="text/javascript">
// 	$(document).ready(function() {
// 		// alert($('#rep_name').val());
// 		$.post("autosearch-y/excel_report.php?custometlistexcel=yuvi&rep="+$('#rep_name').val()+"",function(data){
//             // alert(data);
//             $("#consolidated1").html(data);
//         }); 
// 	});

// 	$('#rep_name').change(function(){  
//     $.post("autosearch-y/excel_report.php?custometlistexcel=yuvi&rep="+$('#rep_name').val()+"",function(data){
//             // alert(data);
//             $("#consolidated1").html(data);
//         }); 

// });
			function region(region){


				document.location = "customers_list_diabetik.php?rep_name="+region;


			}
		</script>

	</body>
	</html>
	<?php
}

?>
