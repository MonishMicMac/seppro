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
							<h2><i class="icon-user"></i> Client List
								<!--<a href="distuber_import_new.php" style="margin-left:150px !important;" class="btn btn-primary">Import DISTRIBUTOR</a>--></h2>
								<div class="box-icon">
									<a href="client_creation_ges.php" style="width:150px !important;" class="btn btn-primary">ADD Client</a>
								</div>
							</div>
							<div class="box-content">
								<form class="form-horizontal" action="" enctype="multipart/form-data" method="post" name="frm">

									<input type="text" name="Client_name" id="Client_name" placeholder="Client Name" value="<?php echo @$_REQUEST['Client_name']; ?>">
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
									
									<select class="input-xlarge focused" id="areahos" name="areahos" data-rel="chosen"  style="width: 220px" >
										<option value="">---Select area---</option>
										<?php
										$spe=mysql_query("select area_hos from Hospitalname WHERE status='1' AND area_hos!='' GROUP BY area_hos ORDER BY area_hos ASC")or die(mysql_error());
										$count_spe=mysql_num_rows($spe);
										if($count_spe > 0) {
											while($row_spe=mysql_fetch_array($spe)) {
												?>
												<!-- <option value="<?=$row_spe['id']?>" ><?=$row_spe['specilist_name'];?></option>   -->
												<option value="<?php echo $row_spe['area_hos']; ?>" <?php echo ($row_spe['area_hos']==$_REQUEST['areahos'])?'selected':''; ?>><?php echo $row_spe['area_hos']; ?></option>        
												<?php
											}
										} else {
											?>
											<option value="">No Area added</option>
											<?php
										}
										?>
									</select>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select class="input-xlarge focused" name="representative" id="representative" data-rel="chosen" style="width: 220px">
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

									


									
									<br/>
									<br/>
									<select class="input-xlarge focused" name="category" id="category" data-rel="chosen" style="width: 220px">
										<option value="">-- Select Category --</option>
										<?php
										$sql_repc=mysql_query("SELECT main_cat,category_name,category_id FROM mst_category WHERE status='1' ".$repmgrid2."");
										while($row_repc=mysql_fetch_array($sql_repc)){
											?>
											<option value="<?php echo $row_repc['category_id']; ?>" <?php echo ($row_repc['category_id']==$_REQUEST['category'])?'selected':''; ?>><?php echo $row_repc['main_cat'].'('.$row_repc['category_name'].')'; ?></option>
											<?php
										}
										?>
									</select>

										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select class="input-xlarge focused" id="specialisty" name="specialisty" data-rel="chosen"  style="width: 220px" >
										<option value="">---Select specialist---</option>
										<?php
										$spe=mysql_query("select * from specilist_list WHERE status='1' ORDER BY specilist_name ASC")or die(mysql_error());
										$count_spe=mysql_num_rows($spe);
										if($count_spe > 0) {
											while($row_spe=mysql_fetch_array($spe)) {
												?>
												<!-- <option value="<?=$row_spe['id']?>" ><?=$row_spe['specilist_name'];?></option>   -->
												<option value="<?php echo $row_spe['id']; ?>" <?php echo ($row_spe['id']==$_REQUEST['specialisty'])?'selected':''; ?>><?php echo $row_spe['specilist_name']; ?></option>        
												<?php
											}
										} else {
											?>
											<option value="">No Speciality added</option>
											<?php
										}
										?>
									</select>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select class="input-xlarge focused" id="designation" name="designation" data-rel="chosen" data-rel="chosen"  style="width: 220px">
										<option value="">---Select designation---</option>
										<?php
										$spe=mysql_query("select * from designation_list WHERE status='1' ORDER BY designation_name ASC")or die(mysql_error());
										$count_spe=mysql_num_rows($spe);
										if($count_spe > 0)
										{
											while($row_spe=mysql_fetch_array($spe))
											{
												?>
											<!--	<option value="<?=$row_spe['designation_name']?>" ><?=$row_spe['designation_name'];?></option>     -->      

												<option value="<?php echo $row_spe['designation_name']; ?>" <?php echo ($row_spe['designation_name']==$_REQUEST['designation'])?'selected':''; ?>><?php echo $row_spe['designation_name']; ?></option> 
												<?php 
											}
										} else {
											?>
											<option value="">No designation added</option>
											<?php
										}
										?>
									</select> 

									<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" style="margin-left: 5%">
								</form>

								<br>

								<div style="float:right; width: 50px;">
									<!--	<a href="view_distributor_sfp_excel.php?stockist_name=<?php echo $_REQUEST['stockist_name']; ?>&mobile_number=<?php echo $_REQUEST['mobile_number']; ?>&country=<?php echo $_REQUEST['country']; ?>&state=<?php echo $_REQUEST['state']; ?>&district=<?php echo $_REQUEST['district']; ?>&town=<?php echo $_REQUEST['town']; ?>&area=<?php echo $_REQUEST['area']; ?>&representative=<?php echo $_REQUEST['representative']; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>  -->
								</div>

								<table class="table table-striped table-bordered bootstrap-datatable datatable">
									<thead>
										<tr>
											<th>Hospital Name</th>
											<!--<th>Distributor Beat</th>-->
											<th>Rep</th>

											<th>Country</th>
											<th>State</th> 
											<th>District</th> 
											<th>town</th> 

											<th>area</th> 

											<th>Doctor Details</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>   
									<tbody>
										<?php
										$stockist_name='';
										if(@$_REQUEST['Client_name']!=''){
											$Client_name="AND hos_name LIKE '%".$_REQUEST['Client_name']."%'";
										}
										$mobile_number='';
										if(@$_REQUEST['mobile_number']!=''){
											$mobile_number="AND mobile_no='".$_REQUEST['mobile_number']."'";
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
										if(@$_REQUEST['areahos']!=''){
											$area="AND area_hos='".$_REQUEST['areahos']."'";
										}
										$representative='';
										if(@$_REQUEST['representative']!=''){
											$representative="AND rep_id='".$_REQUEST['representative']."'";
										}
										$category='';
										if(@$_REQUEST['category']!=''){
											$category="AND hos_category='".$_REQUEST['category']."'";
										}
										$specialisty='';
										if(@$_REQUEST['specialisty']!=''){
											$specialisty="AND doc_specilist_id='".$_REQUEST['specialisty']."'";

											$specialistyhos=" AND id IN (select doc_hospital_clinic_name from doctors where doc_specilist_id='".$_REQUEST['specialisty']."' ) ";
										}
										$designation='';
										if(@$_REQUEST['designation']!=''){
											$designation=" AND doc_designation='".$_REQUEST['designation']."'";

											// $designationhos=" id IN (select doc_hospital_clinic_name from doctors where doc_designation='".$_REQUEST['designation']."' ) ";
										}


										// echo "SELECT * FROM doctors1 WHERE id!='' $stockist_name $mobile_number $country $state $district $town $area $representative";
										// echo "SELECT * FROM doctors1 WHERE id!='' $stockist_name $mobile_number $country $state $district $town $area $representative  ".$repmgrid3." ORDER BY doctor_name ASC";
										// echo "SELECT * FROM Hospitalname WHERE id!='' AND status='1' $stockist_name $mobile_number $country $state $district $town $area $representative   ORDER BY hos_name ASC";

										// echo "SELECT rep_id,hos_name,id,status,(SELECT country_name FROM mst_countries WHERE mst_countries.id=Hospitalname.country) AS country,(SELECT state_name FROM master_state WHERE master_state.state_id=Hospitalname.state) AS state,(SELECT district_name FROM master_district WHERE master_district.district_id=Hospitalname.district) AS district,(SELECT area_name FROM pincode_list WHERE pincode_list.id=Hospitalname.town) AS town,area_hos FROM Hospitalname WHERE id!='' AND status='1' AND hos_name!='' $stockist_name $mobile_number $country $state $district $town $area $representative $category  ORDER BY hos_name ASC";


										// echo "SELECT rep_id,hos_name,id,status,(SELECT country_name FROM mst_countries WHERE mst_countries.id=Hospitalname.country) AS country,(SELECT state_name FROM master_state WHERE master_state.state_id=Hospitalname.state) AS state,(SELECT district_name FROM master_district WHERE master_district.district_id=Hospitalname.district) AS district,(SELECT area_name FROM pincode_list WHERE pincode_list.pin_id=Hospitalname.town) AS town,area_hos FROM Hospitalname WHERE id!='' AND status='1' AND hos_name!='' $specialistyhos $designationhos $stockist_name $mobile_number $country $state $district $town $area $representative $category  ORDER BY hos_name ASC";


										$res=mysql_query("SELECT rep_id,hos_name,id,status,(SELECT country_name FROM mst_countries WHERE mst_countries.id=Hospitalname.country) AS country,(SELECT state_name FROM master_state WHERE master_state.state_id=Hospitalname.state) AS state,(SELECT district_name FROM master_district WHERE master_district.district_id=Hospitalname.district) AS district,(SELECT area_name FROM pincode_list WHERE pincode_list.pin_id=Hospitalname.town LIMIT 1) AS town,area_hos FROM Hospitalname WHERE id!='' AND status='1' AND hos_name!='' $specialistyhos $designationhos $stockist_name $mobile_number $country $state $district $town $area $representative $category  ORDER BY hos_name ASC");
										while($row_res=mysql_fetch_array($res))
										{
											// echo "hi";
											// $d_id=$row_res['id'];
											// $beatid=$row_res['beatid'];
											// $doctor_name=$row_res['doctor_name'];
											// $rep_id=$row_res['rep_id'];
											// $doc_hospital_clinic_name=$row_res['doc_hospital_clinic_name'];
											// $doc_contact_no=$row_res['doc_contact_no'];

											?>
											<tr>
												<td><?php echo $row_res['hos_name']; ?></td>
												<!--<td>
												<?php 
												$sql_beat=mysql_query("SELECT * FROM beadname where id='$beatid'");
												$row_beat=mysql_fetch_array($sql_beat);
												echo $row_beat['name'];
												?>

											</td>-->
											<td>
												<?php 
												$sql_rep=mysql_query("SELECT * FROM representative where id='".$row_res['rep_id']."'");
												$sql_rep=mysql_fetch_array($sql_rep);
												echo $sql_rep['rep_name'];
												?>

											</td>
											<td><?php echo $row_res['country']; ?></td>
											<td><?php echo $row_res['state']; ?></td>
											<td><?php echo $row_res['district']; ?></td>
											<td><?php echo $row_res['town']; ?></td>
											<td><?php echo $row_res['area_hos']; ?></td>
											<td>

											<?php $res_doc=mysql_query("SELECT doctor_name,doc_designation,(select specilist_name from specilist_list where specilist_list.id=doctors.doc_specilist_id) AS specialityname FROM doctors WHERE doc_hospital_clinic_name='".$row_res['id']."' ".$specialisty." ".$designation." ");

											if(mysql_num_rows($res_doc)!='0')
											{
											?>
												<table style="width:100%" >	
													<thead>
														<tr>
															<th>Doctor Name</th>
															
															<th>Speciality</th>
															<th>Designation</th>
															<th>location</th>
														</tr>
													</thead>  
													<tbody> 
														<?php $res_doc=mysql_query("SELECT doctor_name,doc_designation,(select specilist_name from specilist_list where specilist_list.id=doctors.doc_specilist_id) AS specialityname,corebrand,respect_doctor FROM doctors WHERE doc_hospital_clinic_name='".$row_res['id']."' ".$specialisty." ".$designation." ORDER BY doctor_name ASC");
														while($res_doc_res=mysql_fetch_array($res_doc))
															{?>
																<tr>
																	<td style="width:25%"><?php echo $res_doc_res['respect_doctor'].' '.$res_doc_res['doctor_name']; ?></td>
																	<td style="width:25%"><?php echo $res_doc_res['specialityname']; ?></td>
																	<td style="width:25%"><?php echo $res_doc_res['doc_designation']; ?></td>
																	<td style="width:25%"><?php echo $res_doc_res['corebrand']; ?></td>
																</tr>
																<?php } ?>
															</tbody>
														</table>

														<?php } ?>
													</td>
													<!--<td><?php echo $doc_hospital_clinic_name; ?></td>
													<td><?php echo $doc_contact_no; ?></td>  -->
													<td><?php echo ($row_res['status']==1)?"<div class='col-xs-12 label label-success' style='text-align:center'>Active</div>":"<div class='col-xs-12 label label-warning' style='text-align:center'>InActive</div>"; ?></td>
													<td class="center" style="width:17%;">
														<a class="" title="edit stockist" href="client_creation_product_ges.php?mode=edit&id1=<?php echo $row_res['id']; ?>"><i class="icon-edit"></i></a>
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
