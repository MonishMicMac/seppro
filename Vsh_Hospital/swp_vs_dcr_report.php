<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {
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

		<script type="text/javascript">
			function valid2()
			{
				var x=document.getElementById("rep_id1").value;
				if(x === "null" || x === "")
				{
					alert("Please Select Representative Name");
					return false; 
				}
				return true;
			}
		</script>


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
								<h2><i class="icon-edit"></i> SWP Vs DCR Report</h2>
								<div class="box-icon">
								</div>
							</div>
							<div class="box-content">
								<br>
								<form class="form-horizontal" action="swp_vs_dcr_report.php" enctype="multipart/form-data" method="post" name="frm">
									<table style="width: 100%">
										<tr>
											<td>
												<div class="control-group">
													<label class="control-label" for="typeahead">Representative Name<span style="color:#FF0000;">*</span> </label>
													<div class="controls">
														<select id="rep_id" name="rep_id" data-rel="chosen" style="color:#0066FF" required>
															<option value="">--Select--</option>
															<?php
															$res=mysql_query("SELECT * FROM representative");
															while($row_res=mysql_fetch_array($res)){
																?>
																<option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['rep_name']; ?></option>
																<?php
															}
															?> 
														</select><script>document.getElementById("rep_id").value="<?php echo @$_REQUEST["rep_id"] ?>";</script>
													</div>
												</div>
											</td>

											<td>
												<div class="control-group">
													<label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span></label>
													<div class="controls"><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST['from_date']; ?>" readonly required/></div>
												</div>
											</td>
											<td>
												<input type="hidden" name="condition" value="show_swp_vs_dcr">
												<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" style="margin-top: -22px;">
											</td>
										</tr>
										<?php if($_REQUEST['condition']=='show_swp_vs_dcr') { ?>
										<tr>
											<td></td>
											<td></td>
											<td>
												<a href="swp_vs_dcr_report_excel.php?rep_id=<?=$_REQUEST["rep_id"]; ?>&from_date=<?=$_REQUEST["from_date"]; ?>" target="_blank"><img src="img/excel.png" width="24" height="24"></a>
											</td>
										</tr>
										<?php } ?>
									</table>
								</form>

								<?php if($_REQUEST['condition']=='show_swp_vs_dcr') { ?>
								<table class="table table-striped table-bordered">
									<thead>
										<th>Date</th>
										<th colspan="2">SWP</th>
										<th>DCR</th>
										<th>SWP Visited</th>
										<th>DCR Visited</th>
										<th>SWP Missed</th>
									</thead>
									<?php
									$full_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
									$rep_id=$_REQUEST["rep_id"];
									$total_date=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

									$sql_g=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='".$rep_id."' ORDER BY id DESC LIMIT 1");
									$row_g=mysql_fetch_array($sql_g);
									$last_date=$row_g['last_date'];
									$last_day=substr($row_g['last_day'], -1);

									if($last_day!=''){
										$next_first_date=$full_date;
										$prev_first_date='';

										$d=1;
										while ($prev_first_date < $next_first_date) {
											$prev_day=date('l', strtotime($last_date . ' +'.$d.' day'));
											if($prev_day=='Sunday'){
												if($last_day==1){
													$last_day='2';
												} elseif($last_day==2){
													$last_day='1';
												}
											}
											$prev_first_date=date('Y-m-d', strtotime($last_date . ' +'.$d.' day'));
											$d++;
										}
									} else {
										$last_day=1;
									}
									$last=$last_day;


									for ($i=0; $i < $total_date; $i++) {
										$date=date('Y-m-d',strtotime($full_date.'+'.$i.' day'));
										$day=date('l',strtotime($date));
										$h=date('d',strtotime($date));

										if($day=='Sunday' && $h!='1'){
											if($last=='1'){
												$last=2;
											} elseif($last=='2'){
												$last=1;
											}
										}

										$value='0';
										if($day!='Sunday'){
											?>
											<tr>
												<td style="vertical-align: middle;"><?php echo $date; ?></td>
												<td style="vertical-align: middle;width: 40px;">
													<?php
													$week_day=$day.$last;
													$sql2=mysql_query("SELECT count(*) as cnt,GROUP_CONCAT(wp_dc_id) as wp_dc_id FROM mst_tour_plan WHERE wp_day='$week_day' AND wp_rep_id='$rep_id'");
													$row2=mysql_fetch_array($sql2);
													$value=$row2['cnt'];
													$wp_dc_id=$row2['wp_dc_id'];
													echo $value;
													?>
												</td>
												<td style="vertical-align: middle;width: 40px;">
													<?php
													$sql_t=mysql_query("SELECT (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doc_name FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_date='$date' AND wp_rep_id='$rep_id' AND wp_dc_id IN ($wp_dc_id)");
													$num_row_t=mysql_num_rows($sql_t);

													if($num_row_t!=''){ $cnt=number_format(($num_row_t/$value)*100,2); } else { $cnt='0'; }
													echo $cnt;
													?>
												</td>
												<td style="vertical-align: middle;width: 40px;">
													<?php
													$sql_t1=mysql_query("SELECT (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doc_name FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_date='$date' AND wp_rep_id='$rep_id' AND wp_dc_id NOT IN ($wp_dc_id)");
													$num_row_t1=mysql_num_rows($sql_t1);

													if($num_row_t1!=''){ $cnt1=$num_row_t1; } else { $cnt1='0'; }
													echo $cnt1;
													?>
												</td>
												<td style="vertical-align: middle;">
													<div style="word-wrap: break-word;width: 237px;">
														<table border='1' class="table table-striped table-bordered" style="border-collapse:collapse !important;">
															<tr>
																<?php 
																$t=1;
																while ($row_t=mysql_fetch_array($sql_t)) {
																	echo "<td style='background-color:rgba(55, 157, 215, 0.27);border-color: white;'>".strtoupper($row_t['doc_name'])."</td>";
																	if($t%3==0){
																		echo '</tr><tr>';
																	}
																	$t++;
																}
																?>
															</tr>
														</table>
													</div>
												</td>
												<td style="vertical-align: middle;">
													<div style="word-wrap: break-word;width: 237px;">
														<table border='1' class="table table-striped table-bordered" style="border-collapse:collapse !important;">
															<tr>
																<?php 
																$t1=1;
																while ($row_t1=mysql_fetch_array($sql_t1)) {
																	echo "<td style='background-color:rgba(55, 157, 215, 0.27);border-color: white;'>".strtoupper($row_t1['doc_name'])."</td>";
																	if($t1%3==0){
																		echo '</tr><tr>';
																	}
																	$t1++;
																}
																?>
															</tr>
														</table>
													</div>
												</td>
												<td style="vertical-align: middle;">
													<div style="word-wrap: break-word;width: 237px;">
														<table border='1' class="table table-striped table-bordered" style="border-collapse:collapse !important;">
															<tr>
																<?php 
																$t2=1;
																$sql_t2=mysql_query("SELECT (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doc_name FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='1' AND wp_date='$date' AND wp_rep_id='$rep_id' AND wp_dc_id IN ($wp_dc_id)");
																while ($row_t2=mysql_fetch_array($sql_t2)) {
																	echo "<td style='background-color:rgba(55, 157, 215, 0.27);border-color: white;'>".strtoupper($row_t2['doc_name'])."</td>";
																	if($t2%3==0){
																		echo '</tr><tr>';
																	}
																	$t2++;
																}
																?>
															</tr>
														</table>
													</div>
												</td>
											</tr>
											<?php 
										}
									} ?>
								</table>
								<?php } ?>
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
			$(function() {
				$('#from_date').datepicker({
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					dateFormat: 'MM yy',
					yearRange: '1980:' + new Date().getFullYear(),
					beforeShow: function(el, dp) { 
						$('#ui-datepicker-div').addClass('hide-calendar');
					},
					onClose: function(dateText, inst) { 
						$('#ui-datepicker-div').removeClass('hide-calendar');
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).datepicker('setDate', new Date(year, month, 1));
					}
				});
			});

		</script>
		<style>
			.ui-datepicker-calendar {
				display: none;
			}
		</style>
	</body>
	</html>
	<?php
}
?>
