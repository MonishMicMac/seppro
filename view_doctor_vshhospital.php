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
if(@$_REQUEST["mode"]=="del"){
	mysql_query("DELETE FROM doctors WHERE id=".$_REQUEST["DID"]."");
	header("location:view_doctor_vshhospital.php?pincode=".$_REQUEST["pincode"]."");
	die();
}

if(@$_REQUEST["hq"] || @$_REQUEST["cat_id"]) {
		if(@$_REQUEST["hq"]=='All' && @$_REQUEST["cat_id"]=='All')
		{
			$wheredoctor = "";
		}
		if(@$_REQUEST["hq"]=='All' && @$_REQUEST["cat_id"]!='All')
		{
      if($_REQUEST["cat_id"]=='SDP')
      {
        $wheredoctor = "and swid='1' ";
      }
      elseif($_REQUEST["cat_id"]=='SAS')
      {
        $wheredoctor = "and favourite='1'  ";
      }			
		}
		if(@$_REQUEST["hq"]!='All' && @$_REQUEST["cat_id"]=='All')
		{			
			$wheredoctor = "and `rep_id` IN (select id from representative WHERE headquarter_id='".$_REQUEST["hq"]."') ";
		}
    if(@$_REQUEST["hq"]!='All' && @$_REQUEST["cat_id"]!='All')
    {
      if($_REQUEST["cat_id"]=='SDP')
      {
        $wheredoctor = "and `rep_id` IN (select id from representative WHERE headquarter_id='".$_REQUEST["hq"]."') and swid='1'";
      }
      elseif($_REQUEST["cat_id"]=='SAS')
      {
        $wheredoctor = "and `rep_id` IN (select id from representative WHERE headquarter_id='".$_REQUEST["hq"]."') and favourite='1' ";
      } 
      
		}

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
<h2><i class="icon-user"></i> Doctor List<a href="add_doctor1.php" style="margin-left:700px;" class="btn btn-primary">ADD DOCTOR</a></h2>
<div class="box-icon">
</div>
</div>
<br/>

    <table style="width:100%;">
                 <tr>
                  <td><strong>Category</strong></td>
                  <td>:</td>
                  <td>
                    <select name="cat_id" id="cat_id" data-rel="chosen" onChange="cat_id(this.value);">
                     <option value="All" <?php if($_REQUEST["cat_id"]=='All'){ echo 'selected'; } ?>>ALL</option> 
                      <option value="SDP" <?php if($_REQUEST["cat_id"]=='SDP'){ echo 'selected'; } ?>>SDP</option> 
                       <option value="SAS" <?php if($_REQUEST["cat_id"]=='SAS'){ echo 'selected'; } ?>>SAS</option> 
                  </td>


                  <td><strong>HEADQUARTERS</strong> </td>
                  <td>:</td>
                  <td>
                   <select  id="hq" name="hq" data-rel="chosen" onChange="hq(this.value);" >
                    <option value="All" <?php if($_REQUEST["hq"]=='All'){ echo 'selected'; } ?>>ALL</option> 
                    <?php
                    $HQ = mysql_query("SELECT * FROM mst_headquarters WHERE headquarters_id!='' order by headquarters_name ASC");
                    while($Y = mysql_fetch_object($HQ)){
                      ?>
                      <option value="<?=$Y->headquarters_id; ?>" <?php if($Y->headquarters_id==$_REQUEST["hq"]){ echo 'selected'; } ?>><?=strtoupper($Y->headquarters_name); ?></option> 
                      <?php } ?>
                    </select>
                  </td>
                </tr>     
              </table>
              <br/>

<div class="box-content">
<div style='float:right; width: 50px;'><a href="customers_list_excel.php?repid=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>S.NO</th>
<th>Doctor Name</th>
<th>Doctor Category</th>
<?php if(@$_SESSION['id']==""){ ?><th>Rep</th> <?php } ?>
<th>Address</th>
<th>Category</th>

<th>Pincode</th>
<th>CHEMIST</th>
<th>DOB</th>
<th>ANNIVERSARY</th>

<th>Edit</th>
<!--<th>Delete</th>
<th>Location</th>-->

</tr>
</thead>   
<tbody>
<?php
// echo "SELECT * FROM doctors WHERE 1 ".$wheredoctor." ORDER BY id";
$a=mysql_query("SELECT * FROM doctors WHERE 1 ".$wheredoctor." ORDER BY id");
$count_a=mysql_num_rows($a);
$x=1;
if($count_a > 0)
{
while($row_a=mysql_fetch_array($a))
     {     

     $sql5bid=mysql_query("select GROUP_CONCAT(DISTINCT shop_name) AS shop_name from tbl_customer_master where id IN (".$row_a['chemist_id'].") ");
  $sql5bid_row=mysql_fetch_array($sql5bid);    
        ?> 
        <tr>
            <td><?=$x;?></td>
            <td><?=$row_a['doctor_name'];?></td>
            <td><?php if($row_a['swid']=='1') { echo "SDP"; } elseif($row_a['favourite']=='1') { echo "SAS";
            };?></td>
            <?php if($_SESSION['id']==""){ ?><td><?=$row_a['rep_name'];?></td><?php } ?> 
            <td><?=$row_a['doctor_addrs'];?></td>   
            <td><?=$row_a['doc_category'];?></td>     

            <td><?=$row_a['doc_pincode'];?></td>
            <td><?=$sql5bid_row['shop_name'];?></td>
             <td><?=$row_a['dob'];?></td>
              <td><?=$row_a['anniversary'];?></td>
           
            <td> <a class="btn btn-info" href="edit_doctor.php?d_id=<?=encrypt($row_a['id']);?>"><i class="icon-edit icon-white"></i>Edit
    </a></td>            
            <!--<td><a href="#"><img src="img/delete119.png" width="32" height="32" onClick="yuvaraj(<?=$row_a['id'];?>,<?=$row_a['doc_pin_id'];?>);" alt="Delete"></a></td>
            <td><img src="img/show_map.png" width="32" height="32" alt="Doctor Location"></td>-->
         
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
<script>
function yuvaraj(DID,pin){
	if(confirm("Are sure you want to Delete this Doctor Details!!!!")){
		window.location.href="view_doctor_vshhospital.php?mode=del&DID="+DID+"&pincode="+pin+"";
	}
}
function pin_chy(pin){
	window.location.href="view_doctor_vshhospital.php?pincode="+pin;
}

 function hq(hq){
 	var cat_id=$("#cat_id").val();
    if(hq)
      document.location = "view_doctor_vshhospital.php?hq="+hq+"&cat_id="+cat_id;
    else
      document.location = "view_doctor_vshhospital.php";
  }
  function cat_id(cat_id){
 	var hq=$("#hq").val();
    if(cat_id)
      document.location = "view_doctor_vshhospital.php?hq="+hq+"&cat_id="+cat_id;
    else
      document.location = "view_doctor_vshhospital.php";
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
</body>
</html>
<?php
}
?>
