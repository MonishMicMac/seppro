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
	require_once("include/select.php");
	$ad=new select1();
//$res=$ad->view('distributor','where 1','order by id desc');

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
							<h2><i class="icon-user"></i> Distributors List
								<!--<a href="distuber_import_new.php" style="margin-left:150px !important;" class="btn btn-primary">Import DISTRIBUTOR</a>--></h2>
								<div class="box-icon">
<a href="add_distributor_sfp.php" style="width:150px !important;" class="btn btn-primary">ADD DISTRIBUTOR</a>
								</div>
							</div>
							<div class="box-content">
								<form class="form-horizontal" action="" enctype="multipart/form-data" method="post" name="frm">

									<input type="text" name="stockist_name" id="stockist_name" placeholder="Stockist Name" value="<?php echo @$_REQUEST['stockist_name']; ?>">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="text" name="mobile_number" id="mobile_number" placeholder="Mobile Number" value="<?php echo @$_REQUEST['mobile_number']; ?>">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									<select class="input-xlarge focused" name="country" id="country" style="width: 220px">
										<option value="">-- Select Country --</option>
										<?php
										$sql_country=mysql_query("SELECT id,country_name FROM mst_countries WHERE status='1'");
										while($row_country=mysql_fetch_array($sql_country)){
											?>
											<option value="<?php echo $row_country['id']; ?>" <?php echo ($row_country['id']==$_REQUEST['country'])?'selected':''; ?>><?php echo $row_country['country_name']; ?></option>
											<?php
										}
										?>
									</select>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									<select class="input-xlarge focused" name="state" id="state" style="width: 220px">
										<option value="">-- Select State --</option>
										<?php
										$sql_state=mysql_query("SELECT state_id,state_name FROM master_state WHERE country_id='".$_REQUEST['country']."' AND status='1'");
										while($row_state=mysql_fetch_array($sql_state)){
											?>
											<option value="<?php echo $row_state['state_id']; ?>" <?php echo ($row_state['state_id']==$_REQUEST['state'])?'selected':''; ?>><?php echo $row_state['state_name']; ?></option>
											<?php
										}
										?>
									</select>
									<br>
									<br>

									<select class="input-xlarge focused" name="district" id="district" style="width: 220px">
										<option value="">-- Select District --</option>
										<?php
										$state=$row['state_id'];
										$sql_dist=mysql_query("SELECT district_id,district_name FROM master_district WHERE country_id='".$_REQUEST['country']."' AND state_id='".$_REQUEST['state']."' AND status='1'");
										while($row_dist=mysql_fetch_array($sql_dist)){
											?>
											<option value="<?php echo $row_dist['district_id']; ?>" <?php echo ($row_dist['district_id']==$_REQUEST['district'])?'selected':''; ?>><?php echo $row_dist['district_name']; ?></option>
											<?php
										}
										?>
									</select>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									<select class="input-xlarge focused" name="town" id="town" style="width: 220px">
										<option value="">-- Select Town --</option>
										<?php
										$sql_town=mysql_query("SELECT id,area_name FROM pincode_list WHERE country_id='".$_REQUEST['country']."' AND state_id='".$_REQUEST['state']."' AND dist_id='".$_REQUEST['district']."' AND status='1'");
										while($row_town=mysql_fetch_array($sql_town)){
											?>
											<option value="<?php echo $row_town['id']; ?>" <?php echo ($row_town['id']==$_REQUEST['town'])?'selected':''; ?>><?php echo $row_town['area_name']; ?></option>
											<?php
										}
										?>
									</select>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php 
								// echo "SELECT id,name FROM beadname WHERE country_id='".$_REQUEST['country']."' AND state_id='".$_REQUEST['state']."' AND district_id='".$_REQUEST['district']."' AND town_id='".$_REQUEST['town']."' AND status='1'";
									?>
									<!--<select class="input-xlarge focused" name="area" id="area" style="width: 220px">
										<option value="">-- Select Area --</option>
										<?php
										$sql_area=mysql_query("SELECT id,name FROM beadname WHERE country_id='".$_REQUEST['country']."' AND state_id='".$_REQUEST['state']."' AND district_id='".$_REQUEST['district']."' AND town_id='".$_REQUEST['town']."' AND status='1' AND country_id!='0' AND state_id!='0' AND district_id!='0' AND town_id!='0'");
										while($row_area=mysql_fetch_array($sql_area)){
											?>
											<option value="<?php echo $row_area['id']; ?>" <?php echo ($row_area['id']==$_REQUEST['area'])?'selected':''; ?>><?php echo $row_area['name']; ?></option>
											<?php
										}
										?>
									</select>  -->
									

									<select class="input-xlarge focused" name="representative" id="representative" style="width: 220px">
										<option value="">-- Select Representative --</option>
										<?php
										$sql_rep=mysql_query("SELECT id,rep_name FROM representative WHERE 1 ".$repmgrid2."");
										while($row_rep=mysql_fetch_array($sql_rep)){
											?>
											<option value="<?php echo $row_rep['id']; ?>" <?php echo ($row_rep['id']==$_REQUEST['representative'])?'selected':''; ?>><?php echo $row_rep['rep_name']; ?></option>
											<?php
										}
										?>
									</select>

									<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" style="margin-left: 5%">
								</form>

								<br>

								<div style="float:right; width: 50px;">
									<a href="view_distributor_sfp_excel.php?stockist_name=<?php echo $_REQUEST['stockist_name']; ?>&mobile_number=<?php echo $_REQUEST['mobile_number']; ?>&country=<?php echo $_REQUEST['country']; ?>&state=<?php echo $_REQUEST['state']; ?>&district=<?php echo $_REQUEST['district']; ?>&town=<?php echo $_REQUEST['town']; ?>&area=<?php echo $_REQUEST['area']; ?>&representative=<?php echo $_REQUEST['representative']; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>
								</div>

								<table class="table table-striped table-bordered bootstrap-datatable datatable">
									<thead>
										<tr>
											<th>Distributor Name</th>
											<!--<th>Distributor Beat</th>-->
											<th>Distributor Rep</th>
											<th>Contact Person</th>
											<th>Contact Person Number</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>   
									<tbody>
										<?php
										$stockist_name='';
										if(@$_REQUEST['stockist_name']!=''){
											$stockist_name="AND doctor_name LIKE '%".$_REQUEST['stockist_name']."%'";
										}
										$mobile_number='';
										if(@$_REQUEST['mobile_number']!=''){
											$mobile_number="AND doc_contact_no='".$_REQUEST['mobile_number']."'";
										}
										$country='';
										if(@$_REQUEST['country']!=''){
											$country="AND country='".$_REQUEST['country']."'";
										}
										$state='';
										if(@$_REQUEST['state']!=''){
											$state="AND state='".$_REQUEST['state']."'";
										}
										$district='';
										if(@$_REQUEST['district']!=''){
											$district="AND district='".$_REQUEST['district']."'";
										}
										$town='';
										if(@$_REQUEST['town']!=''){
											$town="AND town='".$_REQUEST['town']."'";
										}
										$area='';
										if(@$_REQUEST['area']!=''){
											$area="AND beatid='".$_REQUEST['area']."'";
										}
										$representative='';
										if(@$_REQUEST['representative']!=''){
											$representative="AND rep_assign='".$_REQUEST['representative']."'";
										}
										// echo "SELECT * FROM doctors1 WHERE id!='' $stockist_name $mobile_number $country $state $district $town $area $representative";
										// echo "SELECT * FROM doctors1 WHERE id!='' $stockist_name $mobile_number $country $state $district $town $area $representative  ".$repmgrid3." ORDER BY doctor_name ASC";
										$res=mysql_query("SELECT * FROM doctors1 WHERE id!='' $stockist_name $mobile_number $country $state $district $town $area $representative  ".$repmgrid3." ORDER BY doctor_name ASC");
										while($row_res=mysql_fetch_array($res))
										{
											// echo "hi";
											$d_id=$row_res['id'];
											$beatid=$row_res['beatid'];
											$doctor_name=$row_res['doctor_name'];
											$rep_id=$row_res['rep_id'];
											$doc_hospital_clinic_name=$row_res['doc_hospital_clinic_name'];
											$doc_contact_no=$row_res['doc_contact_no'];

											?>
											<tr>
												<td><?php echo $doctor_name; ?></td>
												<!--<td>
													<?php 
													$sql_beat=mysql_query("SELECT * FROM beadname where id='$beatid'");
													$row_beat=mysql_fetch_array($sql_beat);
													echo $row_beat['name'];
													?>

												</td>-->
												<td>
													<?php 
													$sql_rep=mysql_query("SELECT * FROM representative where id='$rep_id'");
													$sql_rep=mysql_fetch_array($sql_rep);
													echo $sql_rep['rep_name'];
													?>

												</td>
												<td><?php echo $doc_hospital_clinic_name; ?></td>
												<td><?php echo $doc_contact_no; ?></td>
												<td><?php echo ($row_res['status']==1)?"<div class='col-xs-12 label label-success' style='text-align:center'>Active</div>":"<div class='col-xs-12 label label-warning' style='text-align:center'>InActive</div>"; ?></td>
												<td class="center" style="width:17%;">
													<a class="" title="edit stockist" href="edit_distributor_sfp.php?d_id=<?php echo $d_id; ?>"><i class="icon-edit"></i></a>
													<!--<a class="" title="view Stockist" href="edit_distributor_view_sfp.php?d_id=<?php echo $d_id; ?>"><i class="icon-search"></i></a>
													<a class="" title="viewStock" href="view_distributor_stocklist_sfp.php?d_id=<?php echo $d_id; ?>"><i class="icon-barcode"></i></a>
													<a class="" title="Order" href="pob_manual_booking_ars.php?d_id=<?php echo $d_id; ?>"><i class="icon-shopping-cart"></i></a>-->
												</td>
											</tr>
											<?php
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

			// $( "#from_date" ).datepicker({
			// 	changeMonth: true,
			// 	changeYear: true,
			// 	yearRange: "1990:2020",
			// 	dateFormat:"dd/mm/yy"
			// });

			// $( "#to_date" ).datepicker({
			// 	changeMonth: true,
			// 	changeYear: true,
			// 	yearRange: "1990:2020",
			// 	dateFormat:"dd/mm/yy"
			// });

				$("#country").change(function(){
					var country=$(this).val();

					$.ajax({
						url:"get_ajax_details.php",
						type:"post",
						data:"condition=state&country="+country,
						success:function(html){
							$("#state").html(html);
						}
					});
				});

				$("#state").change(function(){
					var country=$("#country").val();
					var state=$(this).val();

					$.ajax({
						url:"get_ajax_details.php",
						type:"post",
						data:"condition=district&country="+country+"&state="+state,
						success:function(html){
							$("#district").html(html);
						}
					});
				});

				$("#district").change(function(){
					var country=$("#country").val();
					var state=$("#state").val();
					var district=$(this).val();

					$.ajax({
						url:"get_ajax_details.php",
						type:"post",
						data:"condition=town&country="+country+"&state="+state+"&district="+district,
						success:function(html){
							$("#town").html(html);
						}
					});
				});

				$("#town").change(function(){
					var country=$("#country").val();
					var state=$("#state").val();
					var district=$("#district").val();
					var town=$(this).val();

					$.ajax({
						url:"get_ajax_details.php",
						type:"post",
						data:"condition=area&country="+country+"&state="+state+"&district="+district+"&town="+town,
						success:function(html){
							$("#area").html(html);
						}
					});
				});
			});
		</script>
		
	</body>
	</html>
	<?php
}
?>
