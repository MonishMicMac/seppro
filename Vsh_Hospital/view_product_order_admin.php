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
	if(@$_REQUEST['reject_id']!=''){
		$sql=mysql_query("SELECT * FROM product_order_booking WHERE id='".$_REQUEST['reject_id']."' AND status IN (0,1) ");
		$row=mysql_num_rows($sql);
		mysql_query("UPDATE product_order_booking SET status='3' WHERE id='".$_REQUEST['reject_id']."'");

		echo "<script type='text/javascript'>alert('Your Order Has Been Reject!'); window.location='view_product_order_admin.php'</script>";
	}
	if(@$_REQUEST['conform_id']!=''){
		mysql_query("UPDATE product_order_booking SET status='1' WHERE id='".$_REQUEST['conform_id']."'");

		echo "<script type='text/javascript'>alert('Your Order Has Been conform!'); window.location='view_product_order_admin.php'</script>";
	}

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
							<h2><i class="icon-user"></i> Your Orders</h2>
							<div class="box-icon">
								<a href="view_product_order_admin.php" class="btn btn-primary" style="width: 150px !important;">Reload</a>
							</div> 
						</div>
						<div class="box-content">
							<table class="table table-striped table-bordered bootstrap-datatable datatable">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Transcation ID</th>
										<th>Distributor Name</th>
										<th>Hospital Name</th>
										<th>Products</th>

										<th >Action</th>
									</tr>
								</thead>   
								<tbody>
									<?php
									$i=1;
									$res=mysql_query("SELECT id, order_id,transaction_id,(select doctor_name from doctors1 where doctors1.id=product_order_booking.distributor_id) AS disname, distributor_id, hospital_id, product_id, product_qty, product_amount, status FROM product_order_booking WHERE status IN (0,1) ORDER BY id DESC");
									while($row_res=mysql_fetch_array($res)){

										$sql_hosp=mysql_query("SELECT hos_name FROM Hospitalname WHERE id='".$row_res['hospital_id']."'");
										$row_hosp=mysql_fetch_array($sql_hosp);

										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row_res['transaction_id']; ?></td>
											<td><?php echo $row_res['disname']; ?></td>
											<td><?php echo $row_hosp['hos_name']; ?></td>
											<td>
												<table class="table table-bordered">
													<th>Product</th>
													<th>Quantity</th>
													<th>Amount</th>
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
											<td>
												<?php	
												if($row_res['status']==0) {
													?>
													<a class="btn btn-success Conform" order_id="<?php echo $row_res['id']; ?>" href="javascript:void(0)"><i class="icon-ok icon-white"></i> Conform</a>
													<a class="btn btn-danger reject" order_id="<?php echo $row_res['id']; ?>" href="javascript:void(0)"><i class="icon-remove icon-white"></i> Reject</a> 
													<?php 
												}	elseif($row_res['status']==1) { 
													?>
													<a class="btn btn-danger reject" order_id="<?php echo $row_res['id']; ?>" href="javascript:void(0)"><i class="icon-remove icon-white"></i> Reject</a>
													<?php
												}
												?>
											</td>
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
		$(document).ready(function(){
			$(".reject").click(function(){
				if(confirm("Do you really want to reject this order?")==true){
					window.location.href="view_product_order_admin.php?reject_id="+$(this).attr("order_id");
				}
			});

			$(".Conform").click(function(){
				if(confirm("Do you really want to conform this order?")==true){
					window.location.href="view_product_order_admin.php?conform_id="+$(this).attr("order_id");
				}
			});
		});
	</script>

</body>
</html>
<?php
}

