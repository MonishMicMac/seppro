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
	<?php include("include/header.php"); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include("include/menu.php"); ?>
			<div id="content" class="span10">
				<div class="row-fluid sortable">		
					<div class="box span12">
						<div class="box-header well" data-original-title>
							<h2><i class="icon-user"></i> Delivered Orders</h2>
							<div class="box-icon">
								<a href="add_product_to_hospital.php" class="btn btn-primary" style="width: 200px !important;">Delivered Products Entry</a>
							</div>
						</div>
						<div class="box-content">
							<table class="table table-striped table-bordered bootstrap-datatable datatable">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Order ID</th>
										<th>Hospital Name</th>
										<th>Products</th>
										<th>Hospital P.O.</th>
										<th>Invoice</th>
										<th>Remarks</th>
										<th>Status</th>
									</tr>
								</thead>   
								<tbody>
									<?php
									$h=1;
									$res=mysql_query("SELECT id, order_id, distributor_id, hospital_id, product_id, product_qty, product_amount, hospital_po, invoice_filename, remarks FROM product_to_hospital WHERE distributor_id='".$_SESSION['id']."' ORDER BY id DESC");
									while($row_res=mysql_fetch_array($res)){

										$sql_hosp=mysql_query("SELECT hos_name FROM Hospitalname WHERE id='".$row_res['hospital_id']."'");
										$row_hosp=mysql_fetch_array($sql_hosp);
										?>
										<tr>
											<td><?php echo $h; ?></td>
											<td><?php echo $row_res['order_id']; ?></td>
											<td><?php echo $row_hosp['hos_name']; ?></td>
											<td>
												<table class="table table-bordered">
													<th>Product</th>
													<th>Quantity</th>
													<th>PTC</th>
													<?php
													$product_id=explode(",", $row_res['product_id']);
													$product_qty=explode(",", $row_res['product_qty']);
													$product_amount=explode(",", $row_res['product_amount']);

													for ($i=0; $i < count($product_id); $i++) { 

														$sql_prod=mysql_query("SELECT product.pro_name, stock_keeping_unit.sku_name FROM product,stock_keeping_unit WHERE product.sku_id=stock_keeping_unit.id AND product.id='".$product_id[$i]."'");
														$row_prod=mysql_fetch_array($sql_prod);

														echo '<tr>';
														echo '<td>'.$row_prod['pro_name'].'</td>';
														echo '<td>'.$product_qty[$i].' '.$row_prod['sku_name'].'</td>';
														echo '<td>'.$product_amount[$i].'</td>';
														echo '</tr>';
													}
													?>
												</table>
											</td>
											<td style="text-align: center;">
												<a href="hospital_po/<?php echo $row_res['hospital_po']; ?>" target="_blank"><img src="img/pdf.png" title="<?php echo $row_res['hospital_po']; ?>"></a>
											</td>
											<td style="text-align: center;">
												<a href="invoice_files/<?php echo $row_res['invoice_filename']; ?>" target="_blank"><img src="img/pdf.png" title="<?php echo $row_res['invoice_filename']; ?>"></a>
											</td>
											<td style="width: 20%;"><?php echo $row_res['remarks']; ?></td>
											<td>
												<div class='col-xs-12 label label-success' style='text-align:center'>Delivered</div>
											</td>
										</tr>
										<?php
										$h++;
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
</body>
</html>
<?php
}

