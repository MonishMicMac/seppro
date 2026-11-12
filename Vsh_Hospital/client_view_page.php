<?php
include("include/connect.php");
// session_start();
error_reporting(0);
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
   echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{

function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return round($miles * 1.609344,2);
}

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
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
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
<h2><i class="icon-user"></i>Client View </h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
            <tr>
                <td style="width:15%;"><Label>Product Name</label></td>
                <td>:</td>
                <td>
	                <select id="productname" name="productname" data-rel="chosen" >
	                    <option value="">--Select--</option>
	                    <?php 
	                    $select=mysql_query("SELECT * FROM product ");
	                    while($row_sel=mysql_fetch_array($select)){ 
	                    ?>
	                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['pro_name']; ?></option>
	                    <?php } ?> 
	                </select><script>document.getElementById("productname").value="<?=$_REQUEST['productname'] ?>";</script>
                </td>
                <td style="width:15%;"><Label>Source Name</label></td>
                <td>:</td>
                <td><select  name="sourcename" id="sourcename" data-rel="chosen" class="sourcename" >
               <option value="">-----Select Source-----</option>
                <option value="BNI">BNI</option>
                <option value="JUCTDAIL">JUSTDAIL</option>
                <option value="JUSTCALL">JUSTCALL</option>
                <option value="INDIAMART">INDIAMART</option>
                <option value="GOOGLE">GOOGLE</option>
                <option value="EXISTING">EXISTING</option>
                <option value="OTHERS">OTHERS</option>  
            </select><script>document.getElementById("sourcename").value="<?=$_REQUEST['sourcename'] ?>";</script>
                </td>
                
                 </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr>
                <td style="width:15%;">
                  <label >Type</label></td>
                  <td>:</td>
             <td><select name="pay" id="pay" class="pay" data-rel="chosen" onchange="pay_type(this)">
         <option value="">-----Select Type-----</option>
          <option value="AMC">AMC</option>
          <option value="warranty">warranty</option>
          <option value="nonamc">nonamc</option>
          </select><script>document.getElementById("pay").value="<?=$_REQUEST['pay'] ?>";</script></td>
           <td style="width:15%;">
                  <label >Pincode</label></td>
                  <td>:</td>
             <td>   <select id="pincode" name="pincode" data-rel="chosen" >
                        <option value="">-----Select pincode-----</option>
                        <?php 
                        $select1=mysql_query("SELECT * FROM clinetcreation");
                        while($row_sel1=mysql_fetch_array($select1)){ 
                        ?>
                        <option value="<?php echo $row_sel1['pincode']; ?>"><?php echo $row_sel1['pincode']; ?></option>
                        <?php } ?> 
                    </select><script>document.getElementById("pincode").value="<?=$_REQUEST['pincode'] ?>";</script></td>
            </tr>
              <tr><td></td></tr>
            <tr><td></td></tr>  
            <tr><td></td></tr>
            <tr><td></td></tr> 
              <tr>
                
           <td style="width:15%;">
                  <label >Area Name</label></td>
                  <td>:</td>
             <td>   <select id="areaname" name="areaname" data-rel="chosen" >
                        <option value="">-----Select areaname-----</option>
                        <?php 
                        $select1=mysql_query("SELECT * FROM clinetcreation GROUP BY areaname");
                        while($row_sel1=mysql_fetch_array($select1)){ 
                        ?>
                        <option value="<?php echo $row_sel1['areaname']; ?>"><?php echo $row_sel1['areaname']; ?></option>
                        <?php } ?> 
                    </select><script>document.getElementById("areaname").value="<?=$_REQUEST['areaname'] ?>";</script></td>
            </tr>
        </table>
           <center>
<div class="form-actions"><input type="submit" name="submit" id="submit"  class="btn btn-primary" value="REPORT" style="background-color: #2fb87a;border-color: #2fb87a;" /><input type="reset" class="btn" value="Cancel" /></div>
</center>
    </form>
</div>


<div class="box-content">
<h2>Client List</h2>
<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>
	<th style="text-align:center">S.NO</th>
  <th hidden></th>
	<th style="text-align:center">CLIENT</th>
	<th style="text-align:center">MOBILE NUMBER</th>
	<th style="text-align:center">ADDRESS</th>
    <th style="text-align:center">PIN CODE</th>
    <th style="text-align:center">AREA NAME</th>
	<!-- <th style="text-align:center">LATITUDE</th>
	<th style="text-align:center">LONGTITUDE</th>
	<th style="text-align:center">REPORT DATETIME</th>
	<th style="text-align:center">DISTANCE</th> -->
</tr>
</thead>   
<tbody>
	<?php
		$i=1;
        $source1=null;
        $produtt1=null;
        $pay1=null;
        if(@$_REQUEST['sourcename']!=''){
            $source1="AND  client_product_list.source='".@$_REQUEST['sourcename']."'";
        }

        if(@$_REQUEST['productname']!=''){
            $produtt1="AND client_product_list.product_id='".@$_REQUEST['productname']."'";
        }

        if(@$_REQUEST['pay']!=''){
            $pay1="AND client_product_list.type='".@$_REQUEST['pay']."'";
        }

        if(@$_REQUEST['pincode']!=''){
            $pincode1="AND clinetcreation.pincode='".@$_REQUEST['pincode']."'";
        }
        if(@$_REQUEST['areaname']!=''){
            $areaname1="AND clinetcreation.areaname='".@$_REQUEST['areaname']."'";
        }
         $_REQUEST['productname'];
	    if(@$_REQUEST['productname']!=''){
            $produttreorting1="AND reorting.productrequested like '".@$_REQUEST['productname']."'";
        }

       // echo "SELECT * FROM client_product_list,clinetcreation WHERE clinetcreation.id=client_product_list.clientid AND  client_product_list.id!=''  $source1  $produtt1  $pay1 $pincode1 $areaname1 GROUP BY client_product_list.clientid OREDR BY client_product_list.clientid ASC ";
		
		$sql=mysql_query("SELECT * FROM client_product_list,clinetcreation WHERE clinetcreation.id=client_product_list.clientid AND  client_product_list.id!=''  $source1  $produtt1  $pay1 $pincode1 $areaname1 GROUP BY client_product_list.clientid ORDER BY clinetcreation.id ASC ");
		while($row=mysql_fetch_array($sql)){	
            $sql1=mysql_query("SELECT * FROM clinetcreation WHERE id='".$row['clientid']."' ");
        $row1=mysql_fetch_array($sql1)
		// echo $row['client'].' ('.$row['pincode'].')';
	
	?>
    <tr class="amma" onclick="amma(this)">
    	<td style="text-align:center"><?php echo $i; ?></td>
      <!-- <input type="hidden" name="clientid" id="clientid" value="<?php echo $row1['clientid']; ?>"> -->
        <td hidden><?php echo $row1['id']; ?></td>
    	<td style="text-align:center"><?php echo $row1['companyname']; ?></td>
    	<td style="text-align:center"><?php echo $row1['mobileno']; ?></td>
    	<td style="text-align:center"><?php echo $row1['address']; ?></td>
    	<td style="text-align:center"><?php echo $row1['pincode']; ?></td>
    	<td style="text-align:center"><?php echo $row1['areaname']; ?></td>
    	
    </tr>
    <?php $i++;} ?>
</tbody>
</table>   
</div> 

<!-- <div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Past Service Call List<div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filter" class="form-control pull-right" placeholder="Search">  
             
        </div>
    </div></h2>

</div> -->

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
  // $('.amma').click(function(){    
  //   // alert($(this).closest('tr').find('td:eq(1)').text());
  //   $.get("autosearch-y/client_metro.php?clientidviewreport=yuvi&clientview="+$(this).closest('tr').find('td:eq(1)').text()+"",function(data){
  //     // alert(data);
  //     $("#consolidated").html(data);
  //   });   
  // });
});
</script>
<script type="text/javascript">
function amma(fs)
{
  // alert($(fs).closest('tr').find('td:eq(1)').text());  
 $.get("autosearch-y/client_metro.php?clientidviewreport=yuvi&clientview="+$(fs).closest('tr').find('td:eq(1)').text()+"",function(data){
      // alert(data);
      $("#consolidated").html(data);
    });  
}
</script>
</body>
</html>
<?php
}
?>
