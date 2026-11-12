<?php
include("include/connect.php");

session_start();
error_reporting(E_ALL);
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}else{

	$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -4 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -3 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);
	?>
	<script language="JavaScript">
		function state(state){
			document.location = "home.php?state="+state;
		}
	</script>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<?php include("include/title.php"); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="micandmac.in, micandmac, micandmacsolutions, micandmac solutions pvt ltd, micandmac" />
		<meta name="keywords" content="micandmacsolutionspvtltd" />
		<meta name="author" content="micandmacsolutionspvtltd" /> 
		<meta name="keywords" content="micandmacsolutions" />
		<meta name="author" content="micandmacsolutions" /> 
		<meta name="keywords" content="micandmac.in" />
		<meta name="author" content="micandmac.in" /> 

		<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
		<style type="text/css">
		body 
		{
			padding-bottom: 40px;
		}
		.sidebar-nav 
		{
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
	<link rel="shortcut icon" href="img/favicon.ico">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="chart/js/highcharts-admin-height.js"></script>
	<script src="chart/js/highcharts-3d-admin.js"></script>	
	<script src="chart/js/modules/drilldown.js"></script>
</head>

<body>
	<?php include("include/header.php"); ?>
	<div class="container-fluid">
		<div class="row-fluid">

			<?php include("include/menu.php"); ?>

			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="#" target="_blank">Java Script</a> enabled to use this site.</p>
				</div>
			</noscript>

			<div id="content" class="span10" style="clear:0 both;float:right;">

				<div>&nbsp;</div>
				<div class="sortable row-fluid" style="height: 80px;">
					<a title="Total Products" class="well span6 top-block" href="#">
						<?php
						$z=mysql_query("SELECT COUNT(DISTINCT(product_id)) as count FROM product_order_booking WHERE distributor_id='".$_SESSION['id']."'");
						$row_z=mysql_fetch_array($z);
						?>
						<div>Total Products</div>
						<div style="color:#FF0000;"><?php echo $row_z['count']; ?></div>
					</a>

					<a title="Total Hospitals" class="well span6 top-block" href="#">
						<?php
						$z1=mysql_query("SELECT COUNT(DISTINCT(hospital_id)) as count FROM product_order_booking WHERE distributor_id='".$_SESSION['id']."'");
						$row_z1=mysql_fetch_array($z1);
						?>
						<div>Total Hospitals</div>
						<div style="color:#FF0000;"><?php echo $row_z1['count']; ?></div>
					</a>
				</div>



				<script>
					$(function () {
						$('#INDIA').highcharts({
							chart: {
								type: 'column'
							},
							title: {
								text: 'Distributor Sales Report'
							},
							xAxis: {
								type: 'category'
							},

							legend: {
								enabled: false
							},

							plotOptions: {
								series: {
									borderWidth: 0,
									dataLabels: {
										enabled: true,
									}
								}
							},
							series: [{
								name: 'Sales',
								mannual_name: 'Total Sales',
								colorByPoint: true,
								data: [
								<?php
								$SQL = mysql_query("SELECT distributor_id, DATE_FORMAT(c_datetime,'%b %Y') as cur_month, SUM(product_qty) as product_qty, product_amount FROM product_to_hospital WHERE DATE_FORMAT(c_datetime,'%m-%Y')='".date('m-Y')."' AND distributor_id='".$_SESSION['id']."' GROUP BY distributor_id");
								while($RS=mysql_fetch_object($SQL)){
									?>
									{
										name: '<?php echo $RS->cur_month; ?>',
										attr: '<?php echo 'Total Sales : '.$RS->product_qty; ?>',
										y: <?php echo $RS->product_qty; ?>,
										drilldown: '<?php echo $RS->distributor_id; ?>'
									},
									<?php
								}
								?>
								]
							}],
							drilldown: {
								series: [
								<?php
								$SQL = mysql_query("SELECT distributor_id, DATE_FORMAT(c_datetime,'%m-%Y') as cur_month, product_qty, product_amount FROM product_to_hospital WHERE DATE_FORMAT(c_datetime,'%m-%Y')='".date('m-Y')."' AND distributor_id='".$_SESSION['id']."' GROUP BY distributor_id");
								while($RS=mysql_fetch_object($SQL)){
									?>
									{
										name: 'Sales',
										mannual_name: 'Sales For Hospital',
										id: '<?php echo $RS->distributor_id; ?>',
										data: [
										<?php 
										$query=mysql_query("SELECT distributor_id, hospital_id, DATE_FORMAT(c_datetime,'%m-%Y') as cur_month, SUM(product_qty) as product_qty, product_amount FROM product_to_hospital WHERE DATE_FORMAT(c_datetime,'%m-%Y')='".date('m-Y')."' AND distributor_id='".$_SESSION['id']."' GROUP BY hospital_id");
										while($row=mysql_fetch_object($query)){

											$sql_hosp=mysql_query("SELECT hos_name FROM Hospitalname WHERE id='".$row->hospital_id."'");
											$row_hosp=mysql_fetch_array($sql_hosp);

											?>
											{
												name: '<?php echo $row_hosp['hos_name']; ?>',
												attr: '<?php echo 'Sales : '.$row->product_qty; ?>',
												y: <?php echo $row->product_qty; ?>
											},
											<?php
										}
										?>
										]

									},
									<?php
								}
								?>
								]
							}
						});
					});
				</script>


				<div class="box">
					<div class="box-content">
						<div id="INDIA"></div>		
					</div>
				</div>

			</div>
		</div>

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

	</div>
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
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$("#from_date").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "1990:2020",
			dateFormat:"yy-mm-dd"
		});
	</script>
</body>
</html>
<?php
}
?>