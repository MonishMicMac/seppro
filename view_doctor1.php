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
	if($_SESSION["CID"]=='SEP1069')
		{
			header("location:view_dashboard_emp_pon.php"); 
		}
if(@$_REQUEST["mode"]=="del"){
	mysql_query("DELETE FROM doctors WHERE id=".$_REQUEST["DID"]."");
	header("location:view_doctor.php?pincode=".$_REQUEST["pincode"]."");
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
<h2><i class="icon-user"></i> <?php echo $_SESSION["LABEL"]; ?> List<a href="add_doctor.php" style="margin-left:700px;" class="btn btn-primary">ADD <?php echo strtoupper($_SESSION["LABEL"]); ?></a></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">


<!-- <div class="control-group">
	<div class="controls">
	Select Category : 
	<select  id="doc_category" name="doc_category" data-rel="chosen">
	    <option value="">---All Category---</option>
		<?php $spe=mysql_query("select * from mst_category")or die(mysql_error());
		$count_spe=mysql_num_rows($spe);
		while($row_spe=mysql_fetch_array($spe)) { ?>
		<option value="<?=$row_spe['category_id'];?>" <?php if(@$_REQUEST["cat_id"]==$row_spe['category_id']){echo "selected";} ?>><?=$row_spe['category_name'];?></option>           
		<?php } ?>
	</select>
	</div>
</div> -->
<div class="control-group">
	<div class="controls">
	Select Rep : 
	<select  id="rep" name="rep" data-rel="chosen">
	    <option value="">---All Reps---</option>
		<?php $spe=mysql_query("select * from representative")or die(mysql_error());
		$count_spe=mysql_num_rows($spe);
		while($row_spe=mysql_fetch_array($spe)) { ?>
		<option value="<?=$row_spe['id'];?>" <?php if(@$_REQUEST["id"]==$row_spe['id']){echo "selected";} ?>><?=$row_spe['rep_name'];?></option>           
		<?php } ?>
	</select>
	</div>
</div>
<br/>

 <div style='float:right; width: 50px;'><a href="customers_list_excel.php?repid=<?php echo @$_REQUEST["id"]; ?>" target="_blank"  value="" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>

<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.NO</th>
<th><?php echo $_SESSION["LABEL"]; ?> Name</th>
<th><?php echo $_SESSION["LABEL"]; ?> Category</th>
<?php if(@$_SESSION['id']==""){ ?><th>Rep</th> <?php } ?>
<th>Area</th>
<th>Contact No</th>
<th>Address</th>
<th>Pincode</th>
<?php if(@$_SESSION['id']==""){ ?>
<th>Edit</th>
<th>Delete</th>
<th>Location</th>
<?php } ?>
</tr>
</thead>   
<tbody>
<?php
$id='';
if(@$_REQUEST['id']!=''){
	$sql="WHERE rep_id='".$_REQUEST['id']."'";
}

$a=mysql_query("SELECT doctor_name,(select category_name from mst_category where category_id=doctors.doc_category) as doc_category,(select rep_name from representative where id=doctors.rep_id) as rep_name ,doctor_addrs,doc_pincode,doc_pin_id,doc_contact_no,areanameee FROM doctors $sql ORDER BY id");

$count_a=mysql_num_rows($a);
$x=1;
while($row_a=mysql_fetch_array($a))
     { 
        
        ?> 
        <tr>
            <td><?=$x;?></td>
            <td><?=$row_a['doctor_name'];?></td>
            <td><?=$row_a['doc_category'];?></td>
            <?php if($_SESSION['id']==""){ ?><td><?=$row_a['rep_name'];?></td><?php } ?> 
            <td><?=$row_a['areanameee'];?></td>   
            <td><?=$row_a['doc_contact_no'];?></td>   
            <td><?=$row_a['doctor_addrs'];?></td>     
            <td><?=$row_a['doc_pincode'];?></td>
            <?php if($_SESSION['id']==""){ ?>
            <td><a href="edit_doctor.php?DID=<?=$row_a['id'];?>"><img src="img/edition2.png" width="32" height="32" alt="Doctor Edit"></a></td>            
            <td><a href="#"><img src="img/delete119.png" width="32" height="32" onClick="yuvaraj(<?=$row_a['id'];?>,<?=$row_a['doc_pin_id'];?>);" alt="Doctor Delete"></a></td>
            <td><img src="img/show_map.png" width="32" height="32" alt="Doctor Location"></td>
            <?php } ?>
        </tr>
<?php
     $x++;
     }

?>
</tbody>
</table> 
<script>
function yuvaraj(DID,pin){
	if(confirm("Are sure you want to Delete this Doctor Details!!!!")){
		window.location.href="view_doctor.php?mode=del&DID="+DID+"&pincode="+pin+"";
	}
}
function pin_chy(pin){
	window.location.href="view_doctor.php?pincode="+pin;
}
</script>           
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
	$("#rep").change(function(){
		window.location="view_doctor1.php?id="+$(this).val();
	});
    
</script>

</body>
</html>
<?php
}
?>
