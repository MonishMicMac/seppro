<?php
include("include/connect.php");
session_start();
//error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{

echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
include("encrypt.php");
require_once("include/select.php");
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_addr=$_SERVER['REMOTE_ADDR']; 
$cur_year=date('Y');


$ad=new select1();
 $co_mat=$ad->count1("unmat_tble_customer_master", "where mat_status = '0'", "");
$co_umat=$ad->count1("unmat_tble_customer_master", "where mat_status = '1'", "");
$mat=$ad->view("unmat_tble_customer_master", "where mat_status = '0'", "");
$umat=$ad->view("unmat_tble_customer_master", "where mat_status = '1'", "");
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
<h2><i class="icon-user"></i>Mismatched Customer Details</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="customer_imports.php" enctype="multipart/form-data" method="post"  name="frm" >
<fieldset>
<div class="control-group">
    <label class="control-label" for="typeahead">
         District Controversy
    </label>
    <div class="controls">
        <input type="text" value="<?=$co_mat;?>" readonly/><a href="#" id="unmatched">Click here</a>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">
         Pin Codes Not Avaliable In Database
    </label>
    <div class="controls">
        <input type="text" value="<?=$co_umat;?>" readonly/><a href="#" id="tot_unmatched">Click here</a>
    </div>
</div> 
<div class="control-group">
    <div class="controls">
        <a class="btn btn-success" href="unmatched_cust_list.php?close='yes'">Update</a>
    </div>
</div>     
</fieldset>
</form>        
</div>
</div>
</div>
</div>
<?php
if(isset($_REQUEST['un_id']))
{
    $pin_code=$_REQUEST['un_id'];
    $sel_pin=$ad->view("unmat_tble_customer_master","where pincode = '$pin_code'","");
    while($row_a=mysql_fetch_array($sel_pin))
    {
      $dist_id=$row_a['mat_district'];  
      $state_name="tamilnadu";
      $cust_type="floating";
      $area_name=ucfirst(strtolower($row_a['area_name']));
      $pin_code_d=$row_a['pincode'];
      $co_p=$ad->count1("pincode_list", "where dist_id = '$dist_id' and  pincode='$pin_code_d' and area_name = '$area_name'", "");
      if($co_p > 0)
      {
         $co_p_view=$ad->view("pincode_list", "where dist_id = '$dist_id' and pincode='$pin_code_d' and area_name = '$area_name'", "");
         $row_ac=mysql_fetch_array($co_p_view);
         $las_id=$row_ac['id'];  
      }
      else
      {
	  	$SQL = mysql_query("SELECT state_id, pin_id FROM master_pincode WHERE pincode = '".$pin_code_d."'");
		$RS = mysql_fetch_object($SQL);
         mysql_query("insert into pincode_list(state_id,state_name,dist_id,area_name,pin_id,pincode,c_date,c_time)values('".$RS->state_id."','".$state_name."','".$dist_id."','".$area_name."','".$RS->pin_id."','".$pin_code_d."','".$c_date."','".$c_time."')")or die(mysql_error()); 
         $las_id=mysql_insert_id();     
      }
      $REP = mysql_query("SELECT rep_id FROM rep_area WHERE pin_id = (SELECT master_pincode.pin_id FROM master_pincode WHERE master_pincode.pincode = '".$pin_code_d."' GROUP BY master_pincode.pincode)");
      $C = mysql_num_rows($REP);
      if($C>0){
	$R = mysql_fetch_object($REP);
	$REP_ID = $R->rep_id;
      }
      if($C==0){$REP_ID = 0; }
      $AREA = mysql_query("SELECT id,state_id,dist_id,pin_id FROM pincode_list WHERE pin_id = (SELECT master_pincode.pin_id FROM master_pincode WHERE master_pincode.pincode = '".$pin_code_d."' GROUP BY master_pincode.pincode) GROUP BY pincode_list.pincode");
      $A = mysql_fetch_object($AREA);

      mysql_query("insert into tbl_customer_master(shop_name,customer_name,mobile_no,drug_lincense_no1,drug_lincense_no2,customer_address,state_id,district_id,pin_id,area_id,rep_id,customer_type) values('".$row_a['shop_name']."','".$row_a['customer_name']."','".$row_a['mobile_no']."','".$row_a['drug_lic_no1']."','".$row_a['drug_licence_no2']."','".$row_a['cust_address']."','".$A->state_id."','".$A->dist_id."','".$A->pin_id."','".$A->id."','".$REP_ID."','".$cust_type."')")or die(mysql_error()); 
    }
    $ad->delete("unmat_tble_customer_master","where pincode = '$pin_code'","");
    echo "<script type='text/javascript'>window.location.href='unmatched_cust_list.php'</script>";
}
?>    
<!----------------------------------------------------------------------------->   
<div id="content1" class="span10">
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Customer Pin Code Matched With Other District</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Shop name</th>
<th>Matched District</th>
<th>Given District</th>
<th>Given Area Name</th>
<th>Given Pin code</th>
<th style="width:20%;">Action</th>
</tr>
</thead>   
<tbody>
<?php
while($row_mat=mysql_fetch_array($mat))
{
?>
<tr>
<td><?=$row_mat['shop_name'];?></td>
<td><?=$ad->get_district($row_mat['mat_district']);?></td>
<td><?=$ad->get_district($row_mat['expected_district']);?></td>
<td><?=$row_mat['area_name'];?></td>
<td><?=$row_mat['pincode'];?></td>
<td class="center" style="width:20%;">
    <a class="btn btn-success" href="unmatched_cust_list.php?un_id=<?=$row_mat['pincode'];?>">Accept</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>            
</div>
</div>
</div>
</div>
<!------------------------------------------------------------------------------>    
 
<!----------------------------------------------------------------------------->   
<div id="content2" class="span10" style="display:none;">
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Customer Un avaliable pin code</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Shop name</th>
<th>Given District</th>
<th>Given Area Name</th>
<th>Given Pin code</th>
<th style="width:20%;">Action</th>
</tr>
</thead>   
<tbody>
<?php
while($row_umat=mysql_fetch_array($umat))
{
?>
<tr>
<td><?=$row_umat['shop_name'];?></td>
<td><?=$ad->get_district($row_umat['expected_district']);?></td>
<td><?=$row_umat['area_name'];?></td>
<td><?=$row_umat['pincode'];?></td>
<td class="center" style="width:20%;">
<a class="btn btn-info" href="edit_distributor.php?d_id=<?php echo encrypt($d_id); ?>)"><i class="icon-edit icon-white"></i>Edit
</a>
<a class="btn btn-danger" href="delete.php?d_id=<?php echo $d_id; ?>&comm=distributor" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash icon-white"></i> Delete</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table> 
    <div class="form-actions" align="right">
        <input type="button" class="btn btn-danger" name="delete_all" id="delete_all" value="Delete All" /> 
    </div>   
</div>
</div>
</div>
</div>
<!------------------------------------------------------------------------------>  

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
    $(document).ready(function(){
        $("#unmatched").click(function(){
            $("#content1").toggle();
        });
        $("#tot_unmatched").click(function(){
            $("#content2").toggle();
        });
        $("#delete_all").click(function(){
        var url="delete.php?comm=del_un_mat";
           $.get(url,function(data,status){
               alert(data);
               location.reload();
           });
        });
    });
</script>


</body>
</html>
<?php
}
?>
