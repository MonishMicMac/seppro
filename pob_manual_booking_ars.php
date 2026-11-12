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
	if(isset($_REQUEST['pdtid']))
	{
		$a=mysql_query("SELECT pts from product WHERE id='".$_REQUEST['pdtid']."' ") or die(mysql_error());
		$row=mysql_fetch_array($a);		
		echo $row['pts'];
		exit();
	}

	if(@isset($_REQUEST["categoryid"])!=""){
		$reg_cus = "SELECT * FROM product WHERE category_id='".$_REQUEST['categoryid']."'";
	}
	else
	{
		$reg_cus="";
	}



	include("encrypt.php");
	include("include/select.php");
	$fun = new select1;
	$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');

	function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
		$theta = $longitude1 - $longitude2;
		$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
		$miles = acos($miles);
		$miles = rad2deg($miles);
		$miles = $miles * 60 * 1.1515;
		return round($miles * 1.609344,2);
	}
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
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script>
			$(function() {

				$( "#from_date" ).datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "1990:2025",
					dateFormat:"yy/mm/dd"
				});

//ajax Starts
				$("#search_box").keypress(function(){
					var from_date =$("#from_date").val();
					var to_date    =$("#to_date").val();
					var content =$("#search_box").val();
					var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
					$.get(url,function(data,status){
						$("#search").html(data);
					});
				});
//ajax Ends
			});


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
					</div>
				</noscript>

				<div id="content" class="span10">
					<div class="row-fluid sortable">		
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-user"></i>Order Booking</h2>
								<div class="box-icon">
								</div>
							</div>

							<div class="box-content">

								<div>
									<form name="thisForm" action="" method="post">
										<div class="control-group">
											<div class="controls" style="float:right;">
												<a class="btn btn-info" href="view_distributor_sfp.php">Back</a>
											</div>
										</div>
										<input type="hidden" id="d_id" value="<?php echo $_REQUEST['d_id']; ?>" />
										<table style="width:100%;">
											<tr>

												<td>Category</td>
												<td>:</td>
												<td><select id="catname" name="catname"  data-rel="chosen"  onChange="categoryname(this.value);">
													<option value="">--Select--</option>
													<?php
													$res=mysql_query("SELECT * FROM product_category");
													while($row_res=mysql_fetch_array($res)) {

														?>
														<option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['product_category']; ?></option>
														<?php } ?> 
													</select><script>document.thisForm.catname.value="<?php echo $_REQUEST["categoryid"]; ?>"</script></td>

													<td>Product</td>
													<td>:</td>
													<td><select id="pdtname" name="pdtname" data-rel="chosen" >
														<option value="">--Select--</option>
														<?php 
														if($reg_cus!='')
															{$res12=mysql_query("".$reg_cus."")or die(mysql_error());

														?>
														<option value="">--Select--</option>
														<?php
												// echo '2';
														while($row_res12=mysql_fetch_array($res12)) {

															?>
															<option value="<?php echo $row_res12['id']; ?>"><?php echo $row_res12['pro_name']; ?></option>
															<?php } }?> 

														</select><script>document.thisForm.pdtname.value="<?php echo $_REQUEST["pdtname"]; ?>"</script></td>

													</tr>
													<tr>

														<td>Price</td>
														<td>:</td>
														<td>

															<input type="text" name="pricevalue" id="pricevalue" value="0" disabled />
														</td>

														<td>Quantity</td>
														<td>:</td>
														<td><input type="text" name="quantityvalue" id="quantityvalue" /></td>
														<td><label  name="totalprice" id="totalprice" >0</label></td>
														<td><input type="submit" name="submit" value="SUBMIT" class="btn btn-primary" ></td>



													</tr>


												</table>

											</form>
										</div><br>
										<?php if(@$_REQUEST["submit"]=="SUBMIT"){ 

											$d=mysql_query("select * from pobbooking_prime where stockistid='".$_REQUEST['d_id']."' AND  cdate='".date('Y-m-d')."' AND productid='".$_REQUEST['pdtname']."' AND qty='".$_REQUEST['quantityvalue']."' ");


											$count_d=mysql_num_rows($d);
											if($count_d==0) {
												$drep=mysql_query("select * from doctors1 where id='".$_REQUEST['d_id']."' ");
												$drep_res=mysql_fetch_array($drep);
												

												mysql_query("INSERT INTO `pobbooking_prime`(`pob_type`, `stockistid`, `productid`, `qty`, `cdate`, `ctime`, `repid`, paymentterms) VALUES ('C','".$_REQUEST['d_id']."','".$_REQUEST['pdtname']."','".$_REQUEST['quantityvalue']."','".date('Y-m-d')."','".date('H:i:s')."','".$drep_res['rep_id']."','web')")or die(mysql_error());

	// header("location:order_booking_ars.php");
												echo "<script type='text/javascript'>alert('Added Successfully');window.location.href='pob_manual_booking_ars.php?categoryid=".$_REQUEST['d_id']."';</script>";

											}
											else
											{												
												echo "<script type='text/javascript'>alert('Already Added');window.location.href='pob_manual_booking_ars.php?categoryid=".$_REQUEST['d_id']."';</script>";
											} 
										}?>
										<div>&nbsp;</div>      
										<div style="height:auto;" id="consolidated1"></div>  
										<div>&nbsp;</div>      
										<div style="height:auto;" id="consolidated"></div>      
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


				<script>
					function categoryname(categoryname){
						document.location = "pob_manual_booking_ars.php?categoryid="+categoryname+"&d_id="+$('#d_id').val(); 
					}
					$("#pdtname").change(function(){  
						$.post("pob_manual_booking_ars.php",{pdtid:$('#pdtname').val()}, function( data ) {
							// alert(data);
							$('#pricevalue').val(data);
						});  
					});
					$("#quantityvalue").keyup(function(){  
						// alert($('#pricevalue').val());
						var totalprice=$('#pricevalue').val()*$("#quantityvalue").val();
						// alert(totalprice);
						// alert('1');
						$("#totalprice").text(totalprice);
					});

				</script>


			</body>
			</html>
			<?php
		}
		?>
