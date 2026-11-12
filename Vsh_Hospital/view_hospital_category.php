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
	if(isset($_REQUEST['coneditcr']))
        { 
        	mysql_query("UPDATE mst_category SET status='5' WHERE category_id ='".$_REQUEST['coneditcr']."'")or die(mysql_error()); 
        }
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
							<h2><i class="icon-user"></i>Hospital Category List</h2>
							<div class="box-icon">
								<a href="add_hospital_category.php" class="btn btn-primary" style="width: 150px !important;">Add Hospital Category</a>
							</div>
						</div>
						<div class="box-content">
							<table class="table table-striped table-bordered bootstrap-datatable datatable">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Main Category</th>
										<th>Hospital Category</th>
										<th>Status</th>
										<th align="center">Actions</th>
									</tr>
								</thead>   
								<tbody>
									<?php
									$i=1;
									$res=mysql_query("SELECT * FROM mst_category WHERE status!='5' ORDER BY main_cat,category_name ASC");
									while($row_res=mysql_fetch_array($res))
									{
										$d_id=$row_res['category_id'];
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row_res['main_cat']; ?></td>
											<td><?php echo $row_res['category_name']; ?></td>
											<td><?php echo ($row_res['status']==1)?"<div class='col-xs-12 label label-success' style='text-align:center'>Active</div>":"<div class='col-xs-12 label label-warning' style='text-align:center'>InActive</div>"; ?></td>

											<td class="center" style="width:20%;">
												<a class="btn btn-info" href="edit_hospital_category.php?d_id=<?php echo encrypt($d_id); ?>"><i class="icon-edit icon-white"></i>Edit</a>
												<a class="btn btn-danger" is_id="<?php echo $d_id; ?>"  onclick="custassign(this)" ><i class="icon-remove icon-white"></i>Delete</a>
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
	<script>
	   function custassign(id)
      {
        if (confirm("Are you sure want to delete..?")) {
          $.post("view_hospital_category.php",{coneditcr:$(id).attr("is_id")},function(data){
            // $(".modal-bodycr").html(data);
            // $("#myModalcr").modal(open);
            alert("deleted successfully");
            window.location.reload();

          }); 
        }
      }
	</script>
</body>
</html>
<?php
}

