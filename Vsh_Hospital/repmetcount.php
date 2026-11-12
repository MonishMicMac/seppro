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

	require_once("include/select.php");
	$ad=new select1();
	$dist=$ad->view('district','','');
	$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
	define('WP_MEMORY_LIMIT', '512M');
	?><html lang="en">
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
		<link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'>
		<link rel="shortcut icon" href="img/favicon1.ico">
	</head>
	<script src="jquery.js" type="text/javascript"></script>    
	<body>
		<?php include("include/header.php"); ?>
		<div class="container-fluid">
			<div class="row-fluid">
				<?php include("include/menu.php"); ?>s
				<div id="content" class="span10">
					<div class="row-fluid sortable">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-edit"></i>Representative Meeting Count 
									<div class="box-icon">
									</div>
								</div>
								<div class="box-content">
									<fieldset>
										<form class="form-vertical" action="" enctype="multipart/form-data" method="post" >
											<input type="hidden" name="command" id="command" value="add_customer" />
											<input type="hidden" name="m_id16" id="m_id16" value="<?php echo $m_id16; ?>"/>
											<table style="width:40%;">
												<tr>
													<td><Label>Select Date</label></td>
													<td>:</td>
													<td><input type="text" name="mdate" id="date" class="form-control" readonly value="<?php echo @$_REQUEST["mdate"]; ?>" required/></td>
													<td><input type="submit" name="submit" value="Search" class="btn btn-primary" style="margin-top:-12px" ></td>
												</tr>
											</table>
										</form>
									</fieldset>
									<?php
									if($_REQUEST['submit']=='Search')
									{
										if($_REQUEST['mdate']=='')
										{
											echo "<script type='text/javascript'>alert('Date required');window.location='repmetcount.php'</script>"; 
										}
										else
										{

											$edate=explode("-",$_REQUEST['mdate']);

											$fdate=$edate[0]."-".$edate[1]."-"."01";
											?>
											<table class="table table-striped table-bordered bootstrap-datatable datatable">
												<thead>
													<tr>
														<th>S.No</th><th>Representaive Name</th><th>Meet Once</th><th>Meet Twice</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$j=1;
													$list=mysql_query("SELECT * FROM tbl_work_plan,representative WHERE reporteddate BETWEEN '".$fdate."' AND '".$_REQUEST['mdate']."' AND tbl_work_plan.wp_rep_id=representative.id AND representative.rep_id='0' AND attendancestatus='1' GROUP BY tbl_work_plan.wp_rep_id");
													while($list_res=mysql_fetch_array($list))
													{
														?>
														<tr>
															<td><?php echo $j;?></td>
															<td><?php echo $list_res['rep_name'];?></td>
															<?php
															$metonce=mysql_query("SELECT COUNT(wp_dc_id)  AS M1 FROM tbl_work_plan WHERE wp_rep_id='".$list_res['wp_rep_id']."' AND wp_dc='D' AND reporteddate BETWEEN '".$fdate."' AND '".$_REQUEST['mdate']."' GROUP BY wp_dc_id HAVING COUNT(wp_dc_id) =1");
															$mro=mysql_num_rows($metonce);
															?>
															<td><?php echo $mro;?></td>
															<?php
															$mettwice=mysql_query("SELECT COUNT(wp_dc_id)  AS M2 FROM tbl_work_plan WHERE wp_rep_id='".$list_res['wp_rep_id']."' AND wp_dc='D' AND reporteddate BETWEEN '".$fdate."' AND '".$_REQUEST['mdate']."' GROUP BY wp_dc_id HAVING COUNT(wp_dc_id) >=2");
															$mrt=mysql_num_rows($mettwice);
															?>
															<td><?php echo $mrt;?></td>
														</tr>
														<?php 
														$j++;
													}
													?>
												</tbody>
											</table>
											<?php
										}
									}
									?>
									<?php include("include/footer.php"); ?>

									<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
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
									<script src="js/jquery-ui-timepicker-addon.js"></script>
									<script>
										$(function() {
											$( "#date" ).datepicker({
												changeMonth: true,
												changeYear: true,
												yearRange: "1990:2020",
												dateFormat:"yy-mm-dd"
											});
										});

									</script>
								</body>
								</html>
								<?php
							}

							?>