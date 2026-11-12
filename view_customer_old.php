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
<h2><i class="icon-user"></i> Customer List <a href="add_customer.php" style="margin-left:700px;" class="btn btn-primary">ADD CUSTOMER</a></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.NO</th>
<th>Shop Name</th>
<th>Chemist Pincode</th>
<th>DOCTOR / FLOATING</th>
<?php if($_SESSION['repid']==""){ ?><th align="center">Action</th><?php } ?>
</tr>
</thead>   
<tbody>
<?php
if($_SESSION['repid']==""){
$a=mysql_query("select * from tbl_customer_master order by id desc")or die(mysql_error());
}if($_SESSION['repid']!=""){$a=mysql_query("select * from tbl_customer_master where rep_id='".$_SESSION["repid"]."' order by id desc")or die(mysql_error());}
$count_a=mysql_num_rows($a);
$x=1;
if($count_a > 0)
{
while($row_a=mysql_fetch_array($a))
     { 
        $district_name=$fun->get_district($row_a['district_id']);
        $area_name=$fun->get_area($row_a['area_id']);
        $cust_ty=$row_a['customer_type'];
        ?> 
        <tr>
        <td><?=$x;?></td>
        <td><?=$row_a['shop_name'];?></td>
        <td><?=$row_a['pincode'];?></td>
        <td><?php 
        if($row_a['doctor_id'] =='')
            { 
               echo "Floating"; 
            } 
            else  
            {
               $DR=mysql_query("SELECT doctor_name,doc_pincode FROM doctors WHERE id IN (".$row_a['doctor_id'].")"); while($D=mysql_fetch_object($DR)){ @$DOCTOR.=$D->doctor_name." - ".$D->doc_pincode.", ";}
			   echo substr(@$DOCTOR,1,-2);
            }?>
        </td>
        <?php if($_SESSION['repid']==""){ ?>
<td class="center" style="width:20%">
    <a class="btn btn-info" href="edit_cust.php?c_id=<?=encrypt($row_a['id']);?>"><i class="icon-edit icon-white"></i>Edit
    </a>
    <a class="btn btn-danger" href="delete.php?c_id=<?=encrypt($row_a['id']);?>&comm=cust" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash icon-white"></i> Delete</a>
</td>
<?php } ?>
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
