<?php
include("include/connect.php");
// session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
	include("encrypt.php");
	include("include/select.php");
	$fun = new select1;
	$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
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

				var currentDate = new Date();
                var currentMonth = currentDate.getMonth();
                var currentYear = currentDate.getFullYear();

                // Calculate the first day of the current month
                var firstDayOfCurrentMonth = new Date(currentYear, currentMonth, 1);

                // Calculate the first day of the month before the previous two months
                var firstDayOfPreviousMonth2 = new Date(currentYear, currentMonth - 2, 1);

                // Calculate the last day of the current month
                var lastDayOfCurrentMonth = new Date(currentYear, currentMonth + 1, 0);

                // Calculate the last day of the previous two months
                var lastDayOfPreviousMonth2 = new Date(currentYear, currentMonth - 1, 0);
				$("#from_date").datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "2015:2030",
					dateFormat:"yy-mm-dd",
					minDate: firstDayOfPreviousMonth2
				});
				$("#to_date").datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "2015:2030",
					dateFormat:"yy-mm-dd",
					minDate: firstDayOfPreviousMonth2

				});
//ajax Starts
$("#search_box").keypress(function(){
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();
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
							<h2><i class="icon-user"></i>SALES REPORT</h2>
							<div class="box-icon">
							</div>
						</div>

						<div class="box-content">

							<div>
								<form name="thisForm" action="" method="post">

									<table style="width:100%;">
										<tr>
										<td>
												<div class="control-group">
													<label class="control-label" for="typeahead">Representative :<span style="color:#FF0000;"></span> </label>
													<div class="controls">
														<select id="rep_id" name="rep_id" data-rel="chosen" style="color:#0066FF" >
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

											<td><Label>From date</label></td>
											<td>:</td>
											<td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly /></td>
											
											<td><Label>To date</label></td>
											<td>:</td>
											<td><input type="text" name="to_date" id="to_date" value="<?php echo @$_REQUEST["to_date"]; ?>" readonly/></td>
											<td><input type="submit" name="submit" value="REPORT" id="submit"  class="btn btn-primary" ></td>
											<td></td>
										</tr>
									</table>
								</form>
							</div><br>
							<?PHP if(@$_REQUEST["submit"]=="REPORT"){ 
                                // print_r($_REQUEST);exit();
                                
                                ?>

                                <div style='float:right; width: 50px;'><a href="status_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?=$_REQUEST["rep_id"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
							<br/>
							<div class="box-content">
								<h2>LIST OF SALES REPORT</h2>
								<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
									<thead>
                                    <tr>
											<th>S.NO</th>
											<th>DATE OF VISIT</th>
											<th>RM NAME</th>
											<th>DOCTOR NAME</th>
											<th>SPECIALITY</th>
											<th>CATEGORY</th>
											<th>LOCATION</th>
											<th>MOBILE NO</th>
											<th>NO OF OP'S PER DAY</th>
											<th>NO OF REFERRALS PER MONTH</th>
											<th>VS-SHARE</th>
											<th>NO OF HOSPITALS WHICH HE IS CURRENTLY REFERRING</th>
											<th>HOW DO YOU RATE(HOT/COLD/WARM/NOT INTERESTED)</th>
											<th>DO SENIOR VISITS REQUIRED(Y/N) </th>
											<th>REVISIT DATE </th>
											<th>INTIME </th>
											<th>OUTTIME </th>
											<th>SPEND TIME </th>
											<th>RM'S REMARKS </th>
											</tr>
									</thead>   
									<tbody>
										<?php	
										$p=1;	

										// $from = date('Y-m-d', strtotime($_REQUEST["from_date"]));
										// $to = date('Y-m-d', strtotime($_REQUEST["to_date"]));

										$from = $_REQUEST['from_date'];
										$to = $_REQUEST['to_date'];
										$repid = $_REQUEST['rep_id'];

										if($repid !='' && $from !='' && $to !=''){
											// print_r('fg');exit();

	                                          $SQL=mysql_query("SELECT * FROM tbl_work_plan 
											WHERE wp_rep_id='".$repid."' AND wp_date BETWEEN '".$from."' AND '".$to."'  ORDER BY wp_id DESC");
										}
										if($repid =='' && $from !='' && $to !=''){
											// print_r('jj');exit();

	                                           $SQL=mysql_query("SELECT * FROM tbl_work_plan 
											WHERE wp_date BETWEEN '".$from."' AND '".$to."'  ORDER BY wp_id DESC");
										}

										while($Y=mysql_fetch_object($SQL)){		
											// print_r($Y);exit();

											$DR=mysql_query("SELECT * FROM representative WHERE id='".$Y->wp_rep_id."'");
                                            
                                            $DRCNT=mysql_fetch_object($DR);

											$DR1=mysql_query("SELECT * FROM doctors WHERE id='".$Y->wp_dc_id."'
											 ");
											//  AND rep_id='".$Y->wp_rep_id."'///
                                            
                                            $DRCNT1=mysql_fetch_object($DR1);
											
											if($Y->intime !='' && $Y->reportedtime !=''){
												//print_r($Y->intime);exit();

												$time1 = date("H:i:s", strtotime($Y->intime));
												$time2 = date("H:i:s", strtotime($Y->reportedtime));

												// Convert the times to seconds since midnight
												$time1_seconds = strtotime($time1) - strtotime('00:00:00');
												$time2_seconds = strtotime($time2) - strtotime('00:00:00');

												// Calculate the time difference in seconds
												$time_difference = $time2_seconds - $time1_seconds;

												$trf = gmdate("H:i:s", $time_difference);
												//print_r($time_difference);exit();

											}else{
												$trf='--';
											}

											?>
											<tr>
                                            <td style="text-align:center"><?=$p; ?></td>

												<td style="text-align:center;"><?php echo $Y->wp_date; ?></td>
                                                <td style="text-align:center"><?php echo $DRCNT->rep_name; ?></td>
                                                <td style="text-align:center"><?php echo $DRCNT1->doctor_name; ?></td>
                                                <td style="text-align:center"><?php echo $DRCNT1->doc_specilist_id; ?></td>
                                                <td style="text-align:center"><?php echo $DRCNT1->doc_category; ?></td>
                                                <td style="text-align:center"><?php echo $DRCNT1->doctor_addrs; ?></td>
                                                <td style="text-align:center"><?php echo $DRCNT1->doc_contact_no; ?></td>
                                                <td style="text-align:center"><?php echo $Y->no_if_op_perday; ?></td>
                                                <td style="text-align:center"><?php echo $Y->no_of_referrals_per_month; ?></td>
                                                <td style="text-align:center"><?php echo $Y->vs_share; ?></td>
                                                <td style="text-align:center"><?php echo $Y->no_of_hospital_current_ref; ?></td>
                                                <td style="text-align:center"><?php  echo $Y->rate; ?></td>
                                                <td style="text-align:center"><?php echo $Y->senior_vis_req; ?></td>
                                                <td style="text-align:center"><?php echo $Y->visit_date; ?></td>
												<td style="text-align:center"><?php  echo $Y->intime; ?></td>
                                                <td style="text-align:center"><?php echo $Y->reportedtime; ?></td>
                                                <td style="text-align:center"><?php echo $trf; ?></td>
												<?php	
												if($Y->c_type =='1'){
													$rest=$Y->drunavailablereason;
												}else{
													$rest=$Y->drunavailablereason;
													
												} ?>
												
												<?php
												// if($rest ='1'){
													?>
													<!-- <td style="text-align:center"><?php echo $trf; ?></td> -->

<?php
												// }else{
													?>
													<!-- <td style="text-align:center"><?php echo $trf; ?></td> -->
<?php
												// }
												?>
												
                                                <td style="text-align:center"><?php  echo $rest; ?></td>

											</tr>
											<?php $p++;} ?>
										</tbody>
									</table>   
								</div>  
								<?PHP } ?>
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
		<script type="text/javascript">
			$(document).ready(function() {
				$('#example').dataTable();
				$('.amma').click(function(){
					$.get("autosearch-y/rep_reporting.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
						$("#consolidated").html(data);
					});		
				});
			});
		</script>
	</body>
	</html>
	<?php
}
?>
