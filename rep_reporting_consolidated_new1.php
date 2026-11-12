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
				$( "#from_date" ).datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "2015:2025",
					dateFormat:"yy/mm/dd"
				});
				$( "#to_date" ).datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "2015:2025",
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
							<h2><i class="icon-user"></i>Representative Consolidate Visit Report</h2>
							<div class="box-icon">
							</div>
						</div>

						<div class="box-content">
							<div>
								<form name="thisForm" action="" method="post">

									<table style="width:100%;">
										<tr>
											<td><Label>From date</label></td>
											<td>:</td>
											<td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly/></td>
											<td><Label>To date</label></td>
											<td>:</td>
											<td><input type="text" name="to_date" id="to_date" value="<?php echo @$_REQUEST["to_date"]; ?>" readonly/></td>
											<td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
											<td></td>
										</tr>
									</table>
								</form>
							</div><br>
							<?PHP if(@$_REQUEST["submit"]=="REPORT"){ ?>
							<!-- <div style='float:right; width: 50px;'><a href="rep_reporting_consolidated_excel.php?from_date=<?php //echo @$_REQUEST["from_date"]; ?>&to_date=<?php //echo @$_REQUEST["to_date"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div> -->
							<br/>
							<div class="box-content">
								<h2>LIST OF REP CONSOLIDATE VISIT REPORT</h2>
								<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
									<thead>
										<tr>
											<th style="text-align:center">S.NO</th><th hidden></th>
											<th style="text-align:center">REPRESENTATIVE</th>
											<?php if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){ ?>
											<th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th>
											<th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL1"]); ?></th>
											<?php } else { ?>
											<th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th>
											<?php } ?>
											<th style="text-align:center">Action</th>
										</tr>
									</thead>   
									<tbody>
										<?php	
										$p=1;					
										$SQL=mysql_query("SELECT representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN `wp_dc`= 'D' THEN `wp_dc_id` END) as D,COUNT(DISTINCT CASE WHEN `wp_dc`= 'C' THEN `wp_dc_id` END) as C FROM `tbl_work_plan`,representative WHERE (`tbl_work_plan`.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `tbl_work_plan`.`wp_rep_id`=representative.id GROUP BY `tbl_work_plan`.`wp_rep_id` ORDER BY wp_rep_id DESC");
										while($Y=mysql_fetch_object($SQL)){		
											$DR=mysql_query("SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id='".$Y->R."'");$DRCNT=mysql_fetch_object($DR);
											$CHY=mysql_query("SELECT COUNT(*) AS CHEMIST FROM tbl_customer_master WHERE rep_id='".$Y->R."'");$CHYCNT=mysql_fetch_object($CHY);
											?>
											<tr class="amma">
												<td style="text-align:center"><?=$p; ?></td>
												<td hidden><?php echo $Y->R; ?></td>
												<td><?=$Y->REP; ?></td>
												<?php if($_SESSION['doc_cnt']>0){ ?>
												<td style="text-align:right"><?php echo $Y->D." (".$DRCNT->DOCTOR.") "; ?></td>
												<?php } ?>
												<?php if($_SESSION['chem_cnt']>0){ ?>
												<td style="text-align:right"><?php echo $Y->C." (".$CHYCNT->CHEMIST.") "; ?></td>
												<?php } ?>
												<td><div style='float:right; width: 50px;'><a href="rep_reporting_consolidated_excel_new1.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo $Y->R;?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div></td>
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