<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
session_start();
error_reporting(0);
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');
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
 .ui-datepicker-calendar {
   display: none;
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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
</head>

<body id="mm">
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
<h2><i class="icon-user"></i>Doctor Product Promoting</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
	<div>
	    <form class="form-horizontal" name="thisForm" action="" method="post">
	        <table style="width:100%;">
	            <tr>
	                <td><Label>Month &amp; Year</label></td>
	                <td>:</td>
	                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>" required/></td>
	                <td><Label>Representative</label></td>
	                <td>:</td>
	                <td>
		                <select id="rep_name" name="rep_name" data-rel="chosen" style="width: 250px;">
		                    <option value="">--Select--</option>
		                    <?php 
		                    if($_SESSION["AUTH"]=='2'){
		                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND id in (select repid from assigningreptomanager where managerid='".$_SESSION["id"]."')");
		                    } else {
		                    	$select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' AND rep_id='0' ORDER BY rep_name ASC");
		                    }
		                    while($row_sel=mysql_fetch_array($select)){ 
		                    ?>
		                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
		                    <?php } ?> 
		                </select><script>document.getElementById("rep_name").value="<?php echo $_REQUEST['rep_name'] ?>";</script>
	                </td>
	                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary"></td>
	                <td></td>
	            </tr>
	        </table>
	    </form>
	</div>

<?php if(@$_REQUEST['rep_name']!='') { ?>
	<br>
	<div class="box-content">
			<?php
		    	$date=date("Y-m",strtotime($_REQUEST['from_date']));
		    	$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($date)),date("Y",strtotime($date)));

		    	$from=date("Y-m",strtotime($_REQUEST['from_date'])).'-01';
		    	$to=date("Y-m",strtotime($_REQUEST['from_date'])).'-'.$no_of_days;


		    	$begin = new DateTime(date("Y-m-d",strtotime($from)));
		    	$end = new DateTime(date("Y-m-d",strtotime($to . " +1 days")));

		    	$interval = DateInterval::createFromDateString('1 day');
		    	$period = new DatePeriod($begin, $interval, $end);

		    	$cnt_days=0;
		    	foreach ( $period as $dt ){
		    		if($dt->format("l") != 'Sunday'){
		    			$cnt_days++;

		    			$leave=mysql_query("SELECT * FROM mst_leave_dates WHERE leave_date='".$dt->format("Y-m-d")."'");
		    			if(mysql_num_rows($leave)>0){
		    				$cnt_days--;
		    			}
		    		}
		    	}


		    	$SQL=mysql_query("SELECT wp_date FROM tbl_work_plan WHERE (wp_date BETWEEN '$from' AND '$to') AND wp_rep_id='".$_REQUEST['rep_name']."'");
		    	while($Y=mysql_fetch_object($SQL)){

		    		$cnt_leave_add=$cnt_days;
		    		$leave_cnt=mysql_query("SELECT * FROM mst_leave_dates WHERE leave_date='".$Y->wp_date."'");
		    		if(mysql_num_rows($leave_cnt) == 0){
		    			$cnt_leave_add=$cnt_days+1;
		    		}
		    	}


				$sql2=mysql_query("SELECT (select rep_name from representative where id=tbl_work_plan.wp_rep_id) as rep_name, (select mobile from representative where id=tbl_work_plan.wp_rep_id) as mobile_no,(select count(id) from doctors where rep_id=tbl_work_plan.wp_rep_id) as doc_cnt, sum(case when attendancestatus='1' and drunavailable='0' then 1 else 0 end) as visited, sum(case when attendancestatus='0' and drunavailable='0' then 1 else 0 end) as missed, sum(case when promotion_service!='' then 1 else 0 end) as call_types, sum(case when promotion_service='Regular visit' then 1 else 0 end) as regular_visit, sum(case when promotion_service='Surgery' then 1 else 0 end) as surgery, sum(case when prescriptionvalue='Case review' then 1 else 0 end) as CR, sum(case when prescriptionvalue='Demo' then 1 else 0 end) as D, sum(case when prescriptionvalue='kb discussion' then 1 else 0 end) as KBD, sum(case when prescriptionvalue='Opportunity followup' then 1 else 0 end) as OF, sum(case when prescriptionvalue='Payment followup' then 1 else 0 end) as PF, sum(case when prescriptionvalue='revision surgery' then 1 else 0 end) as RS, sum(case when prescriptionvalue='surgery assistance' then 1 else 0 end) as SA FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$_REQUEST['rep_name']."' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_rep_id");
				$row2=mysql_fetch_array($sql2);

				$cover_sql=mysql_query("SELECT wp_id FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='".$_REQUEST["rep_name"]."' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id");
				$covered=mysql_num_rows($cover_sql);

				$sel1=mysql_query("SELECT wp_id FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='".$_REQUEST["rep_name"]."' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)=1");
				$one=mysql_num_rows($sel1);

				$sel2=mysql_query("SELECT wp_id FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='".$_REQUEST["rep_name"]."' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)=2");
				$two=mysql_num_rows($sel2);

				$sel3=mysql_query("SELECT wp_id FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='".$_REQUEST["rep_name"]."' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)=3");
				$three=mysql_num_rows($sel3);

				$sel4=mysql_query("SELECT wp_id FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_dc='D' AND wp_rep_id='".$_REQUEST["rep_name"]."' AND (wp_date BETWEEN '$from' AND '$to') GROUP BY wp_dc_id HAVING COUNT(wp_dc_id)>3");
				$threeplus=mysql_num_rows($sel4);
			?>
			<table class="table table-bordered">
				<tr>
				    <td><b>Call Average : </b><?php echo round($row2['visited']/$cnt_leave_add); ?></td>
				    <td rowspan="2">
				    	<h2>Call Types</h2>
						<table class="table table-striped table-bordered" border="1">
							<thead>
								<th title="Regular Visit">Regular Visit</th>
								<th title="Surgery">Surgery</th>
								<th title="Total">Total</th>
							</thead>
							<tr>
								<td><?php echo $row2['regular_visit']; ?></td>
								<td><?php echo $row2['surgery']; ?></td>
								<td><?php echo $row2['call_types']; ?></td>
							</tr>
						</table>
				    </td>
				    <td class="visit_report" value="visit1"><b>1V : </b><?php if($one!=''){ echo $one; } else { echo '0'; } ?></td>
				</tr>
				<tr>
				    <td class="visit_report" value="visited_doctors"><b>Doctors : </b><?php echo $covered.' ('.$row2['doc_cnt'].')'; ?></td>
				    <td class="visit_report" value="visit2"><b>2V : </b><?php if($two!=''){ echo $two; } else { echo '0'; } ?></td>
				</tr>
				<tr>
				    <td  class="visit_report" value="total_visited"><b>Visit : </b><?php echo $row2['visited']; ?></td>
				    <td rowspan="2">
				    	<h2>Call Stages</h2>
						<table class="table table-striped table-bordered" border="1">
							<thead>
								<th title="Case Review">Case Review</th>
								<th title="Demo">Demo</th>
								<th title="KB Discussion">KB Discussion</th>
								<th title="Opportunity Followup">Opportunity Followup</th>
								<th title="Payment Followup">Payment Followup</th>
								<th title="Revision Surgery">Revision Surgery</th>
								<th title="Surgery Assistance">Surgery Assistance</th>
							</thead>
							<tr>
								<td><?php echo $row2['CR']; ?></td>
								<td><?php echo $row2['D']; ?></td>
								<td><?php echo $row2['KBD']; ?></td>
								<td><?php echo $row2['OF']; ?></td>
								<td><?php echo $row2['PF']; ?></td>
								<td><?php echo $row2['RS']; ?></td>
								<td><?php echo $row2['SA']; ?></td>
							</tr>
						</table>
				    </td>
				    <td class="visit_report" value="visit3"><b>3V : </b><?php if($three!=''){ echo $three; } else { echo '0'; } ?></td>
				</tr>
				<tr>
				    <td class="visit_report" value="missed_doctors"><b>Missed : </b><?php echo $row2['missed']; ?></td>
				    <td class="visit_report" value="visit>3"><b>3+ : </b><?php if($threeplus!=''){ echo $threeplus; } else { echo '0'; } ?></td>
				</tr>
			</table>
		<br/>
		<br/>

		<table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
			<thead>
				<th>S.No</th>
				<th>Date</th>
				<th>Doctor</th>
				<th>Type</th>
				<th>Promoted Products</th>
				<th>Call Stage</th>
				<th>Comments</th>
			</thead>
			<?php
				$i=1;
				$sql=mysql_query("SELECT wp_date, (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doctor, promotion_service, productname, prescriptionvalue, drunavailablereason, ifnull((select rep_name from representative where id=tbl_work_plan.jointworkby),'N/A') as mgr_name FROM tbl_work_plan WHERE productname!='' AND wp_rep_id='".$_REQUEST['rep_name']."' AND (wp_date BETWEEN '$from' AND '$to') ORDER BY wp_date DESC");
				while ($row=mysql_fetch_array($sql)) {
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo date('d-m-Y',strtotime($row['wp_date'])); ?></td>
					<td><?php echo $row['doctor']; ?></td>
					<td><?php echo $row['promotion_service']; ?></td>
					<td>
						<?php
							if($row['productname']!=''){
								echo "<table class='table-bordered'><tr><th>Product</th></tr>"; 
								$prom=explode(',',$row['productname']); 
								foreach ($prom as $prom_pro) {
									$sql1=mysql_query("SELECT pro_name FROM product WHERE id='$prom_pro'");
									$row1=mysql_fetch_array($sql1);
									echo "<tr><td>".$row1['pro_name']."</td></tr>";
								}
								echo "</table>";
							}
						?>
					</td>
					<td><?php echo $row['prescriptionvalue']; ?></td>
					<td><?php echo $row['drunavailablereason']; ?></td>
				</tr>
			<?php $i++; } ?>
		</table>
	</div>
<?php } ?>

</div>
</div>
</div>
</div>
</div>
<hr>




  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


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
$(function() {
    $('#from_date').datepicker( {
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

$(".visit_report").click(function(){
	var value=$(this).attr("value");
	var rep_id=$("#rep_name").val();
	var date=$("#from_date").val();

	var post_data={ condition:value, rep_id:rep_id, date:date };

	$.ajax({
		url:"product_promoting_all_report.php",
		type:"post",
		context:value,
		data:post_data,
		success:function(result){
			if(value=='visited_doctors'){
				$(".modal-title").html("<h3>Visited Doctors Report</h3>");
			} else if(value=='total_visited'){
				$(".modal-title").html("<h3>Total Visited Report</h3>");
			} else if(value=='missed_doctors'){
				$(".modal-title").html("<h3>Missed Doctors Report</h3>");
			} else if(value=='visit1'){
				$(".modal-title").html("<h3>1 Time Visited Report</h3>");
			} else if(value=='visit2'){
				$(".modal-title").html("<h3>2 Time Visited Report</h3>");
			} else if(value=='visit3'){
				$(".modal-title").html("<h3>3 Time Visited Report</h3>");
			} else if(value=='visit>3'){
				$(".modal-title").html("<h3>3+ Visited Report</h3>");
			}
			$(".modal-body").html(result);
			$('#myModal').modal();
		}
	})

});
</script>
</body>
</html>
<?php
}
?>