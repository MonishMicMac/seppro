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
	<?php include("include/header.php"); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include("include/menu.php"); ?>
			<div id="content" class="span10">
				<div class="row-fluid sortable">		
					<div class="box span12">
						<div class="box-header well" data-original-title>
							<h2><i class="icon-user"></i> State List</h2>
							<div class="box-icon">
								<a href="add_state.php" class="btn btn-primary" style="width: 100px !important;">Add State</a>
							</div>
						</div>
						<div class="box-content">
							<form class="form-horizontal" action="" enctype="multipart/form-data" method="post" name="frm">
								<select class="input-xlarge focused" name="country" id="country">
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
								<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Report" style="margin-left: 5%">
							</form>

							<br>

							<table class="table table-striped table-bordered bootstrap-datatable datatable">
								<thead>
									<tr>
										<th>S.No</th>
										<th>State Name</th>
										<th>Short Name</th>
										<th>Country</th>
										<th>Super Stockist Appicable</th>
										<th>Status</th>
										<th align="center">Actions</th>
									</tr>
								</thead>   
								<tbody>
									<?php
									$country='';
									if(@$_REQUEST['country']!=''){
										$country="AND country_id='".$_REQUEST['country']."'";
									}

									$i=1;
									$res=mysql_query("SELECT state_id, state_name, short_name, (select country_name from mst_countries where id=master_state.country_id) country_name, super_stockist, status FROM master_state WHERE state_id!='' $country ORDER BY state_name ASC");
									while($row_res=mysql_fetch_array($res))
									{
										$d_id=$row_res['state_id'];
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row_res['state_name']; ?></td>
											<td><?php echo $row_res['short_name']; ?></td>
											<td><?php echo $row_res['country_name']; ?></td>
											<td><?php echo ($row_res['super_stockist']==1)?"Yes":"No"; ?></td>
											<td><?php echo ($row_res['status']==1)?"<div class='col-xs-12 label label-success' style='text-align:center'>Active</div>":"<div class='col-xs-12 label label-warning' style='text-align:center'>InActive</div>"; ?></td>

											<td class="center" style="width:20%;">
												<a class="btn btn-info" href="edit_state.php?d_id=<?php echo encrypt($d_id); ?>"><i class="icon-edit icon-white"></i>Edit</a>
											</td>
										</tr>
										<?php
										$i++;
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
</body>
</html>
<?php
}

