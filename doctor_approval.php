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
if(@$_REQUEST["mode"]=="approval"){
	
	mysql_query("UPDATE  doctors SET doc_status = '1' WHERE id = ".@$_REQUEST["d_id"]."");
	header("location:doctor_approval.php");
	die();
}
include("encrypt.php");
include("include/select.php");
$fun = new select1;
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
</div>
</noscript>

<div id="content" class="span10">

<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i> Doctor List<a href="add_doctor.php" style="margin-left:700px;" class="btn btn-primary">ADD DOCTOR</a></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.NO</th>
<th>Doctor Name</th>
<th>Specialist</th>
<th>Qualification</th>
<th>District</th>
<th>Contact Number</th>
<th>Email</th>
<th>Hospital Name</th>
<th>Action</th>
</tr>
</thead>   
<tbody>
<?php
$a=mysql_query("select * from doctors WHERE doc_status='0' order by id desc")or die(mysql_error());
$count_a=mysql_num_rows($a);
$x=1;
if($count_a > 0)
{
while($row_a=mysql_fetch_array($a))
     { 
        $spec_name=$fun->get_speciality($row_a['doc_specilist_id']);
        $dis_name=$fun->get_district($row_a['doc_district_id']);
        ?> 
        <tr>
        <td><?=$x;?></td>
        <td><?=$row_a['doctor_name'];?></td>
        <td <?php if($spec_name === 'No match found') { echo 'style="color:red;"';}?>><?=$spec_name;?></td>
        <td><?php $Q=mysql_query("SELECT deg_name FROM mst_doctor_degree WHERE deg_id='".$row_a['doc_qualification']."'"); echo mysql_error(); $R=mysql_fetch_object($Q); echo $R->deg_name; ?></td>
        <td <?php if($dis_name === 'No match found') { echo 'style="color:red;"';}?>><?=$dis_name;?></td>
        <td><?=$row_a['doc_contact_no'];?></td>
        <td><?=substr($row_a['email'],0,5)."...";?></td>
        <td><?=$row_a['doc_hospital_clinic_name'];?></td>
        <td class="center">
        <a class="btn btn-info" href="edit_doctor.php?d_id=<?=encrypt($row_a['id']);?>"><i class="icon-edit icon-white"></i>Edit
        </a>
        <a class="btn btn-danger" href="delete.php?d_id=<?=encrypt($row_a['id']);?>&comm=doctor" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash icon-white"></i> Delete</a>
        <a class="btn btn-primary" href="doctor_approval.php?d_id=<?=$row_a['id']; ?>&mode=approval" onClick="return confirm('Do you want to Approve?')"><i class="icon-asterisk"></i> Approve</a>
        </td>
        </tr>
<?php
     $x++;
     }
}
else
{ 
?>
        <tr><td colspan="9" align="center">No Data Found</td></tr>    
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
</body>
</html>
<?php
}
?>
