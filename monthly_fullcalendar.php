<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
	if(@$_REQUEST['condition']=='add_doctor_list')
	{
		if(date('Y-m-d')<$_REQUEST['date'])
		{
			// echo "SELECT id,doctor_name,doc_pincode,rep_id FROM doctors WHERE rep_id='".$_REQUEST['rep_id']."' AND id NOT  IN (SELECT wp_dc_id FROM tbl_work_plan WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='".$_REQUEST['rep_id']."' and tbl_work_plan.wp_date='".$_REQUEST['date']."') ";

			$sql=mysql_query("SELECT id,doctor_name,doc_pincode,rep_id FROM doctors WHERE rep_id='".$_REQUEST['rep_id']."' AND id NOT  IN (SELECT wp_dc_id FROM tbl_work_plan WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='".$_REQUEST['rep_id']."' and tbl_work_plan.wp_date='".$_REQUEST['date']."') ");


			$i=1;
			?>

			<table class="table table-bordered bootstrap-datatable datatable" cellspacing="0" width="100%">
				<thead>
				<!-- <tr>
					<th style="color:red;">planned</th>
					<th style="color:green;">visited</th>
					<th style="color:blue;">missed</th>
				</tr> -->
				<tr>
					<th>#</th>
					<th>Doctor</th>
					<th>Pincode</th>
					<th>Action</th>
					<?php 
					// if(date('Y-m-d')>$_REQUEST['date'])
					// {
					// }
					// else
					// {
					?>
				<!-- 		<th>

			 		<a  href="delete.php?d_id=<?php echo $d_id; ?>&comm=representative" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash icon-red"></i>ALL </a>
			 	</th> -->
			 	<?php 
					// }
			 	?>

			 </tr>
			</thead>
			<tbody>
				<?php
				if(date('Y-m-d')>$_REQUEST['date'])
				{
					if(mysql_num_rows($sql)>0){ ?>

					<?php
					while ($row=mysql_fetch_array($sql)) { ?>

					<tr >
						<td><?php echo $i; ?></td>
						<td><?php echo $row['doctor_name']; ?></td>
						<td><?php echo $row['doc_pincode']; ?></td>
					</tr>
					<?php $i++; }} else { echo '<tr class="odd" style="color:red;"><td valign="top" colspan="6" class="dataTables_empty">No records found</td></tr>'; } 
				}
				else
				{
					if(mysql_num_rows($sql)>0){ ?>

					<?php
					while ($row=mysql_fetch_array($sql)) { ?>

					<tr >						<td><?php echo $i; ?></td>
						<td><?php echo $row['doctor_name']; ?></td>
						<td><?php echo $row['doc_pincode']; ?></td>
						<td><input type="hidden" class="did_do" value="<?php echo $row['id']; ?>"><input type="hidden" class="rp_do" value="<?php echo $row['rep_id']; ?>"><input type="hidden" class="date_do" value="<?php echo $_REQUEST['date']; ?>"><label id="add_doc" class="add_doc"><i class="icon-plus-sign icon-red"></i> </label>
						</tr>
						<?php $i++; }} else { echo '<tr class="odd" style="color:red;"><td valign="top" colspan="6" class="dataTables_empty">No records found</td></tr>'; } 

					}

					?>
				</tbody>
			</table>
			<script src='js/jquery.dataTables.min.js'></script>
			<script type="text/javascript">
			$('.add_doc').click(function(){
				var did = $(this).closest('tr').find('.did_do').val();
				var rpeid = $(this).closest('tr').find('.rp_do').val();
				var dateid = $(this).closest('tr').find('.date_do').val();
				// alert(did);
				$(this).closest("tr").remove();
				$.post("delete.php",{d_id:did,rpid:rpeid,dateid:dateid,comm:'twp_add'}, function(data){
					// alert(data);
					$.post("monthly_fullcalendar.php",{rep_id:rpeid,date:dateid,condition:'doctor_list'}, function(data){
					// alert(data);
					$('#pands').html(data);
					$('#calendar1').fullCalendar('removeEventSource', "monthly_fullcalendar_operation.php?rep_id="+$("#representative").val());
					$('#calendar1').fullCalendar('addEventSource', "monthly_fullcalendar_operation.php?rep_id="+$("#representative").val());
				});
					
				}); 
				
			});
			</script>
			<?php
		}
		exit;

	}

	if(@$_REQUEST['condition']=='doctor_list'){
		// echo "SELECT tbl_work_plan.wp_id,doctors.id,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.attendancestatus,tbl_work_plan.drunavailable,tbl_work_plan.mtp FROM doctors,tbl_work_plan WHERE tbl_work_plan.wp_dc='D' and doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_rep_id='".$_REQUEST['rep_id']."' and tbl_work_plan.wp_date='".$_REQUEST['date']."'and (tbl_work_plan.mtp='1' or tbl_work_plan.attendancestatus='1')";
		$sql=mysql_query("SELECT tbl_work_plan.wp_id,doctors.id,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.attendancestatus,tbl_work_plan.drunavailable,tbl_work_plan.mtp FROM doctors,tbl_work_plan WHERE tbl_work_plan.wp_dc='D' and doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_rep_id='".$_REQUEST['rep_id']."' and tbl_work_plan.wp_date='".$_REQUEST['date']."' AND tbl_work_plan.mtp='1'");

		$sql5=mysql_query("SELECT tbl_work_plan.wp_id,doctors.id,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.attendancestatus,tbl_work_plan.drunavailable,tbl_work_plan.mtp FROM doctors,tbl_work_plan WHERE tbl_work_plan.wp_dc='D' and doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_rep_id='".$_REQUEST['rep_id']."' and tbl_work_plan.wp_date='".$_REQUEST['date']."' AND tbl_work_plan.attendancestatus='1' ");

		$sql10=mysql_query("SELECT tbl_work_plan.wp_id,doctors.id,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.attendancestatus,tbl_work_plan.drunavailable,tbl_work_plan.mtp FROM doctors,tbl_work_plan WHERE tbl_work_plan.wp_dc='D' and doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_rep_id='".$_REQUEST['rep_id']."' and tbl_work_plan.wp_date='".$_REQUEST['date']."' AND tbl_work_plan.mtp='1' AND tbl_work_plan.attendancestatus='0'");

			$sql11=mysql_query("SELECT tbl_work_plan.wp_id,doctors.id,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.attendancestatus,tbl_work_plan.drunavailable,tbl_work_plan.mtp FROM doctors,tbl_work_plan WHERE tbl_work_plan.wp_dc='D' and doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_rep_id='".$_REQUEST['rep_id']."' and tbl_work_plan.wp_date='".$_REQUEST['date']."' AND tbl_work_plan.mtp='0' AND tbl_work_plan.attendancestatus='0'");

		$i=1;
		?>

		<table class="table table-bordered bootstrap-datatable datatable" cellspacing="0" width="100%">
			<thead>
				<!-- <tr>
					<th style="color:red;">planned</th>
					<th style="color:green;">visited</th>
					<th style="color:blue;">missed</th>
				</tr> -->
				<tr>
					<th>#</th>
					<th>Doctor</th>
					<th>Pincode</th>
					
					<?php 
					if(date('Y-m-d')>$_REQUEST['date'])
					{
					}
					else
					{
					?>
					<th>Action</th>
						<!-- <th>

							<a  href="delete.php?d_id=<?php echo $d_id; ?>&comm=representative" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash icon-red"></i>ALL </a>
						</th> -->
						<?php 
					}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
					if(date('Y-m-d')>$_REQUEST['date'])
					{
						if(mysql_num_rows($sql)>0){ ?>
						<tr><th style="color:red;" colspan="3"></th></tr>
						<?php
						while ($row=mysql_fetch_array($sql)) { ?>

						<tr style="color:red;">
							<td><?php echo $i; ?></td>
							<td><?php echo $row['doctor_name']; ?></td>
							<td><?php echo $row['doc_pincode']; ?></td>
						</tr>
						<?php $i++; }} else { echo '<tr class="odd" style="color:red;"><td valign="top" colspan="6" class="dataTables_empty">swp planned No records found </td></tr>'; } ?>

						<?php
						if(mysql_num_rows($sql5)>0){ ?>
						<tr><th style="color:green;" colspan="3">unplanned visited</th></tr>
						<?php
						while ($row5=mysql_fetch_array($sql5)) { ?>
						<tr style="color:green;">
							<td><?php echo $i; ?></td>
							<td><?php echo $row5['doctor_name']; ?></td>
							<td><?php echo $row5['doc_pincode']; ?></td>
						</tr>
						<?php $i++; }} else { echo '<tr class="odd" style="color:green;"><td valign="top" colspan="6" class="dataTables_empty">unplanned visited No records found</td></tr>'; } ?>

						<?php
						if(mysql_num_rows($sql10)>0){ ?>
						<tr><th style="color:blue;" colspan="3">swp missed</th></tr>
						<?php
						while ($row10=mysql_fetch_array($sql10)) { ?>
						<tr style="color:blue;">
							<td><?php echo $i; ?></td>
							<td><?php echo $row10['doctor_name']; ?></td>
							<td><?php echo $row10['doc_pincode']; ?></td>
						</tr>
						<?php $i++; }} else { echo '<tr class="odd" style="color:blue;"><td valign="top" colspan="6" class="dataTables_empty">swp missed No records found</td></tr>'; }
					} 
					else
					{
						// echo "hi";
						if(mysql_num_rows($sql)>0){ ?>
						<tr><th style="color:red;" colspan="4">SWP planned</th></tr>
						<?php
						while ($row=mysql_fetch_array($sql)) { 
						 // $d_id=$row['wp_id'];
							?>

							<tr style="color:red;">
								<td><?php echo $i; ?></td>
								<td><?php echo $row['doctor_name']; ?></td>
								<td><?php echo $row['doc_pincode']; ?></td>
								<td><input type="hidden" class="did" value="<?php echo $row['wp_id']; ?>"><input type="hidden" class="rp_do" value="<?php echo $_REQUEST['rep_id']; ?>"><input type="hidden" class="date_do" value="<?php echo $_REQUEST['date']; ?>"><label id="delete" class="delete"><i class="icon-remove icon-red"></i> </label>
								</td>
							</tr>
							<?php $i++; }} else { echo '<tr class="odd" style="color:red;"><td valign="top" colspan="4" class="dataTables_empty">SWP planned No records found</td></tr>'; }

							if(mysql_num_rows($sql11)>0){ ?>
						<tr><th style="color:gray;" colspan="4">Un planned</th></tr>
						<?php
						while ($row11=mysql_fetch_array($sql11)) { 
						 // $d_id=$row['wp_id'];
							?>

							<tr style="color:gray;">
								<td><?php echo $i; ?></td>
								<td><?php echo $row11['doctor_name']; ?></td>
								<td><?php echo $row11['doc_pincode']; ?></td>
								<td><input type="hidden" class="did" value="<?php echo $row11['wp_id']; ?>"><input type="hidden" class="rp_do" value="<?php echo $_REQUEST['rep_id']; ?>"><input type="hidden" class="date_do" value="<?php echo $_REQUEST['date']; ?>"><label id="delete" class="delete"><i class="icon-remove icon-red"></i> </label>
								</td>
							</tr>
							<?php $i++; }} else { echo '<tr class="odd" style="color:red;"><td valign="top" colspan="4" class="dataTables_empty">Un planned No records found</td></tr>'; } 
						}
						?>
					</tbody>
				</table>
				<script src='js/jquery.dataTables.min.js'></script>
				<script type="text/javascript">
				$('.delete').click(function(){
					var did = $(this).closest('tr').find('.did').val();
					var rpeid = $(this).closest('tr').find('.rp_do').val();
				var dateid = $(this).closest('tr').find('.date_do').val();
					$(this).closest("tr").remove();
					$.post("delete.php",{d_id:did,comm:'twp_delete'}, function(data){
						alert(data);
							$.post("monthly_fullcalendar.php",{rep_id:rpeid,date:dateid,condition:'add_doctor_list'}, function(data){
								$('#adddoc').html(data);
						$('#calendar1').fullCalendar('removeEventSource', "monthly_fullcalendar_operation.php?rep_id="+$("#representative").val());
						$('#calendar1').fullCalendar('addEventSource', "monthly_fullcalendar_operation.php?rep_id="+$("#representative").val());
					});
					}); 
				});
				</script>
				<?php 
				exit;
			}

			require_once("include/select.php");
			$ad=new select1();

			$select=mysql_query("SELECT schedule_fromdate,schedule_todate FROM tour_manage");
			$row=mysql_fetch_array($select);

			$YWeekend=mysql_query("SELECT calendar_weekdays FROM master_calendar");
			$YP=mysql_fetch_object($YWeekend);
			if($YP->calendar_weekdays!=""){
				$StyleWeekend = mysql_query("SELECT weekday_id,weekday_shortname FROM mst_weekdays WHERE weekday_id IN (".$YP->calendar_weekdays.")");
				while($S=mysql_fetch_object($StyleWeekend)){
					$weekdays_id[]=$S->weekday_id;
					$week_days[]=$S->weekday_shortname;
					@$SW.=".fc-".$S->weekday_shortname.",";
				}
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
				.h2 {
					font-size: 10px;
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
				<link href="css/bootstrap-cerulean.min.css" id="bs-css" rel="stylesheet">
				<link rel="shortcut icon" href="img/favicon1.ico">
				<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>  
				<script type="text/javascript" src="google_dynamic_map.js"></script>   
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
				<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
				<link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
			</head>

			<body onLoad="initialize();">
				<?php include("include/header.php"); ?>
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
										<h2><i class="icon-edit"></i>Show Tour Plan</h2>
										<div class="box-icon">
										</div>
									</div>
									<div style="float:right;margin-top:5px;margin-right:80px">
										<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
									</div>
									<div class="box-content">
										<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm">
											<fieldset>
												<input type="hidden" id="full_cur_date" value="<?php echo date("Y-m-d"); ?>">
												<div class="control-group">
													<label class="control-label" for="typeahead">Current Representative<span style="color:#FF0000;">*</span> </label>
													<div class="controls">
														<select name="representative" id="representative" data-rel="chosen">
															<option value="">---Select---</option>
															<?php $P=mysql_query("SELECT * FROM representative WHERE rep_activatedeactivate=0 ORDER BY id"); while($I=mysql_fetch_object($P)){ ?>
															<option value="<?=$I->id; ?>"><?=$I->rep_name; ?></option>
															<?php } ?>
															</select><script>document.getElementById("representative").value="<?=$_REQUEST["representative"] ?>";</script>
														</div>
													</div>

													<div class="tray tray-center">
														<div class="span6">
															<div id='calendar1'></div>
														</div>

														<div id='pands' class="span3">

														</div>
														<div id='adddoc' class="span3">
														</div>

													</div>
												</fieldset>
											</form>
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
					<script type="text/javascript">
					$(document).ready(function(){
						$('#pands').hide();
						$('#adddoc').hide();
						var Calendar = $('#calendar1');
						Calendar.fullCalendar({
							header: {
								left: 'prev,next today',
								center: 'title',
								right: ''
							},
							events: 'monthly_fullcalendar_operation.php?rep_id='+$("#representative").val(),
							dayclick: function(date, jsEvent, view) {
								alert("hi");
							},
							eventClick: function(event, jsEvent, view) {

								var year=event.start.getFullYear();
								var month=parseInt(event.start.getMonth())+1;
								var day=event.start.getDate();
								var full_date = year + '-' +(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;
								$(".date_title").html(full_date);
								var full_datec=$("#full_cur_date").val();
							// if(full_datec>full_date)
							// {
								$.ajax({
									url: "monthly_fullcalendar.php",
									data: "&date="+full_date+"&rep_id="+$("#representative").val()+"&condition=doctor_list",
									type: "post",
									success: function(result){
										$('#pands').show();
										$('#pands').html(result);
									}
								});

								$.ajax({
									url: "monthly_fullcalendar.php",
									data: "&date="+full_date+"&rep_id="+$("#representative").val()+"&condition=add_doctor_list",
									type: "post",
									success: function(result1){
										$('#adddoc').show();
										// alert(result1);
										$('#adddoc').html(result1);
									}
								});

							// $('#myModal').modal('show');
						// }
						// else
						// {
						// 	$('#pands').show();
						// 	document.location = "monthly_fullcalendar.php?representative="+$("#representative").val()+"&full_date="+full_date;
						// }
					}
				});

$("#representative").change(function(){
	document.location = "monthly_fullcalendar.php?representative="+$(this).val();
});
});

</script>
</body>
</html>
<?php
}
?>
