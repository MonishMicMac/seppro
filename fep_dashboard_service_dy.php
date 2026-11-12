<?php
include("include/connect.php");

session_start();
error_reporting(E_ALL);
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
	if(@$_REQUEST["state"]==""){ $_REQUEST["state"] = 1;}
	if(@$_REQUEST["state"]!=""){ $_REQUEST["state"] = $_REQUEST["state"];}	
	
	
	
	$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -4 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -3 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);


	
	?>
	<script language="JavaScript">
		function state(state){
			document.location = "home.php?state="+state;
		}

	</script>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<?php include("include/title.php"); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="micandmac.in, micandmac, micandmacsolutions, micandmac solutions pvt ltd, micandmac" />
		<meta name="keywords" content="micandmacsolutionspvtltd" />
		<meta name="author" content="micandmacsolutionspvtltd" /> 
		<meta name="keywords" content="micandmacsolutions" />
		<meta name="author" content="micandmacsolutions" /> 
		<meta name="keywords" content="micandmac.in" />
		<meta name="author" content="micandmac.in" /> 

		<!-- The styles -->
		<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
		<style type="text/css">
			body 
			{
				padding-bottom: 40px;
			}
			.sidebar-nav 
			{
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
		<link rel="shortcut icon" href="img/favicon.ico">
		<!-- The styles Ends-->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="chart/js/highcharts-3d-admin.js"></script>	
		<script src="chart/js/highcharts-admin.js"></script>
		<script src="chart/js/modules/drilldown.js"></script>
	</head>

	<body>
		<!-- top bar starts -->
		<?php include("include/header.php"); ?>
		<!-- top bar ends -->
		<div class="container-fluid">
			<div class="row-fluid">
				
				<!-- left menu starts -->
				<?php include("include/menu.php"); ?><!--/span-->
				<!-- left menu ends -->

				<noscript>
					<div class="alert alert-block span10">
						<h4 class="alert-heading">Warning!</h4>
						<p>You need to have <a href="#" target="_blank">Java Script</a> enabled to use this site.</p>
					</div>
				</noscript>

				<div id="content" class="span10" style="clear:0 both;float:right;">
					<div>&nbsp;</div>
					<!-- content starts -->
					<div class="sortable row-fluid" style="height: 80px;">
						<a title="Pending" class="well span4 top-block" href="#">
							<?php
							$z=mysql_query("select * from product");
							$count_z=mysql_num_rows($z);
							?>
							<div>Total Products</div>
							<div style="color:#FF0000;"><?php echo $count_z; ?></div>
						</a>
						<?php
						$z1=mysql_query("select *  from clinetcreation");
						$count_z1=mysql_num_rows($z1);
						?>

						<a title="Total Distributors" class="well span4 top-block" href="#">
							<div>Total Client</div>
							<div style="color:#FF0000;"><?php echo $count_z1; ?></div>
						</a>

						<a title="Total Sales of Last  month" class="well span4 top-block" href="#">					
							<div>Today Planning</div>
							<div style="color:#FF0000;">
								<?php $Sales = mysql_query("SELECT count(*) plan, sum(case when attendance='1' then 1 else 0 end) as visit FROM reorting WHERE tdate=CURDATE()");  $Rs_Sales=mysql_fetch_array($Sales);
								if($Rs_Sales["visit"]!=''){ $visited=$Rs_Sales["visit"]; } else { $visited="0"; }
								if($Rs_Sales["plan"]!=''){ $plan=$Rs_Sales["plan"]; } else { $plan="0"; }
								echo "<strong><span style='color:#0000FF'>".$visited." (".$plan.")</span> </strong>"; ?> 
							</div>
						</a>
					</div>


					<div class="box">
						<script>
							$(function () {
								$('#INDIA').highcharts({
									chart: {
										type: 'column'
									},
									title: {
										text: 'Datewise Manager & Representative Report'
									},
									xAxis: {
										type: 'category'
									},


									legend: {
										enabled: false
									},

									plotOptions: {
										series: {
											borderWidth: 0,
											dataLabels: {
												enabled: true,
											}
										}
									},

									series: [{
										name: 'Visit',
										mannual_name: 'DateWise Visit',
										colorByPoint: true,
										data: [
										<?php
										for($i=7;$i>=0;$i--){
											$SQL = mysql_query("SELECT DAYNAME(date_add(CURDATE(), interval -$i day)) as Day,date_add(CURDATE(), interval -$i day) FirstDay");
											$RS=mysql_fetch_object($SQL);
											if($RS->Day!='Sunday'){
												?>
												{
													name: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>',
													<?php
													$cur_date=date("Y-m-d",strtotime($RS->FirstDay));
													$Sales1 = mysql_query("SELECT count(*) plan, sum(case when attendance='1' then 1 else 0 end) as visit FROM reorting WHERE tdate='$cur_date' ");
													$Rs_Sales1=mysql_fetch_array($Sales1);
													$Sales = mysql_query("SELECT count(*) sales, sum(case when attendance='1' then 1 else 0 end) as visit FROM reorting WHERE tdate='$cur_date' AND typeofcall='SALES CALL'");
													$Rs_Sales=mysql_fetch_array($Sales);
													$service = mysql_query("SELECT count(*) service, sum(case when attendance='1' then 1 else 0 end) as visit FROM reorting WHERE tdate='$cur_date' AND typeofcall='SERVICE CALL'");
													$Rs_service=mysql_fetch_array($service);
													?>	
													attr: '<?='Planned sales : '.round($Rs_Sales["sales"],0).' / service : '.round($Rs_service["service"],0); ?>',
													y: <?=round($Rs_Sales1["plan"],0); ?>
													<?php if(round($Rs_service["service"],0)>0){ ?>
														,drilldown: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>'
														<?php } ?>
														<?php if(round($Rs_Sales["sales"],0)>0){ ?>
															,drilldown: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>'
															<?php } ?>
														},
														<?php }} ?>
														]
													}],
													drilldown: {
														series: [
														<?php
														for($i=7;$i>=0;$i--){
															$SQL = mysql_query("SELECT DAYNAME(date_add(CURDATE(), interval -$i day)) as Day,date_add(CURDATE(), interval -$i day) FirstDay");
															$RS=mysql_fetch_object($SQL);
															if($RS->Day!='Sunday'){
																?>
																{
																	name: 'Visit',
																	mannual_name: 'Repwise Visit',
																	id: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>',
																	data: [
																	<?php 
																	$query=mysql_query("SELECT count(*) plan, sum(case when attendance='1' then 1 else 0 end) as visit, (select rep_name from representative where id=reorting.repid) as rep_name,(select id from representative where id=reorting.repid) as repid FROM reorting WHERE tdate='".$RS->FirstDay."' GROUP BY repid,typeofcall");
																	while($row=mysql_fetch_object($query)){
																		$cur_date=date("Y-m-d",strtotime($RS->FirstDay));
																		$Sales1 = mysql_query("SELECT count(*) sales1 FROM reorting WHERE tdate='$cur_date' AND repid='".$row->repid."' AND typeofcall='SALES CALL' and attendance='1'");
																		$Rs_Sales1=mysql_fetch_object($Sales1);
																		$service1 = mysql_query("SELECT count(*) service1 FROM reorting WHERE tdate='$cur_date' AND repid='".$row->repid."' AND typeofcall='SERVICE CALL' and attendance='1'");
																		$Rs_service1=mysql_fetch_object($service1);
																		?>
																		{

																			name: '<?=strtoupper($row->rep_name); ?>',
																			attr: '<?='Visited Sales : '.round($Rs_Sales1->sales1,0).' / service : '.round($Rs_service1->service1,0); ?>',
																			y: <?=round($row->visit,0); ?>
																		},
																		<?php } ?>
																		]

																	},
																	<?php }} ?>
																	]}
																});
});
</script>
<div class="box-content">
	<div id="INDIA"></div>		
</div>
</div>

<div style="float:right;margin: 17px 21px 0px 0px;">
	DATE: <input type="text" id="from_date" readonly style="height:27px;width:100px;" value="<?=date("Y-m-d")?>">
</div>

<div class="box">
	<script>
		$(function () {
			getAjaxData($("#from_date").val());

			$("#from_date").change(function(){
				getAjaxData($(this).val());
			});

			function getAjaxData(date){
				$.getJSON('data_sale_service.php', {date: date}, function(chartData) {
					$('#new_drilldown').highcharts({
						chart: {
							type: 'column'
						},
						tooltip: {
							headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>', 
							pointFormat: '<span style="color:{point.color}">\u25cf</span> {series.name}: <b>{point.y}</b><br/>'
						},
						plotOptions: {
							column: {
								dataLabels: {
									overflow: 'none',
									crop: false,
									enabled: true,
									style: {
										fontWeight: 'bold'
									},
									formatter: function() {
										return this.y
									}
								}
							}
						},
						title: {
							text: 'Manager & Representative Report'
						},
						xAxis: {
							categories: chartData.repname
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Value'
							}
						},
						series: chartData.values
					});
				});
			}
		});
	</script>
	<div class="box-content">
		<div id="new_drilldown"></div>		
	</div>
</div>

<div class="box">
	<script>
		$(function () {
			$('#INDIA1').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Calls & Visitor Report'
				},
				xAxis: {
					type: 'category'
				},


				legend: {
					enabled: false
				},

				plotOptions: {
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
						}
					}
				},

				series: [{
					name: 'Visit',
					mannual_name: 'DateWise Visit',
					colorByPoint: true,
					data: [
					<?php
					for($i=7;$i>=0;$i--){
						$SQL = mysql_query("SELECT DAYNAME(date_add(CURDATE(), interval -$i day)) as Day,date_add(CURDATE(), interval -$i day) FirstDay");
						$RS=mysql_fetch_object($SQL);
						if($RS->Day!='Sunday'){
							?>
							{
								name: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>',
								<?php
								$cur_date=date("Y-m-d",strtotime($RS->FirstDay));
								$Sales1 = mysql_query("SELECT count(*) feedback_calls FROM marketing_sales_call WHERE m_updatetime='$cur_date' ");
								$Rs_Sales1=mysql_fetch_array($Sales1);
								$Sales = mysql_query("SELECT count(*) visitcalls FROM mst_visitior_record WHERE c_date='$cur_date' ");
								$Rs_Sales=mysql_fetch_array($Sales);

								?>	
								attr: '<?='Calls : '.round($Rs_Sales1["feedback_calls"],0).' / visitor : '.round($Rs_Sales["visitcalls"],0); ?>',
								y: <?=round($Rs_Sales1["feedback_calls"],0); ?>
								<?php if(round($Rs_Sales1["feedback_calls"],0)>0){ ?>
									,drilldown: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>'
									<?php } ?>
								},
								<?php }} ?>
								]
							},{
								name: 'Visit',
								mannual_name: 'DateWise Visit',
								colorByPoint: true,
								data: [
								<?php
								for($i=7;$i>=0;$i--){
									$SQL = mysql_query("SELECT DAYNAME(date_add(CURDATE(), interval -$i day)) as Day,date_add(CURDATE(), interval -$i day) FirstDay");
									$RS=mysql_fetch_object($SQL);
									if($RS->Day!='Sunday'){
										?>
										{
											name: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>',
											<?php
											$cur_date=date("Y-m-d",strtotime($RS->FirstDay));
											$Sales1 = mysql_query("SELECT count(*) feedback_calls FROM marketing_sales_call WHERE m_updatetime='$cur_date' ");
											$Rs_Sales1=mysql_fetch_array($Sales1);
											$Sales = mysql_query("SELECT count(*) visitcalls FROM mst_visitior_record WHERE c_date='$cur_date' ");
											$Rs_Sales=mysql_fetch_array($Sales);
										
											?>	
											attr: '<?='Calls : '.round($Rs_Sales1["feedback_calls"],0).' / visitor : '.round($Rs_Sales["visitcalls"],0); ?>',
											y: <?=round($Rs_Sales["visitcalls"],0); ?>
											<?php if(round($Rs_Sales["visitcalls"],0)>0){ ?>
												,drilldown: '<?=date("m-d-Y",strtotime($RS->FirstDay)); ?>'
												<?php } ?>
											},
											<?php }} ?>
											]
										}],

									});
		});
	</script>
	<div class="box-content">
		<div id="INDIA1"></div>		
	</div>
</div>



</div>






</div>

<hr>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Settings</h3>
	</div>
	<div class="modal-body">
		<p>Here settings can be configured...</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<a href="#" class="btn btn-primary">Save changes</a>
	</div>
</div>

<?php include("include/footer.php"); ?>

</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

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
	
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$("#from_date").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "1990:2020",
			dateFormat:"yy-mm-dd"
		});
	</script>

</body>
</html>
<?php
}
?>