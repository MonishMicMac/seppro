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
    <link href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css' rel='stylesheet'>
    
    
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
<h2><i class="icon-user"></i>Representative Report</h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">

<div><br/>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
            <tr>
                <td><Label>Representative Name</label></td>
                <td>:</td>
                <td>
	                <select id="representative1" name="representative1" data-rel="chosen" style="width: 250px;">
	                    <option value="">--Select--</option>
                        
	                    <?php 
	                    $select=mysql_query("SELECT * FROM representative WHERE rep_activatedeactivate=0 ORDER BY id");
	                    while($row_sel=mysql_fetch_array($select)){ 
	                    ?>
	                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
	                    <?php } ?> 
	                </select><script>document.getElementById("representative1").value="<?=$_REQUEST['representative1'] ?>";</script>
                </td>
            
            	<td><Label>From date</label></td>
        <td>:</td>
        <td><input type="date" name="from_date" id="from_date"  value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td><Label>To date</label></td>
        <td>:</td>
        <td><input type="date" name="to_date" id="to_date"  value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
              <!--   <td><Label>Date</label></td>
                <td>:</td>
                <td><input type="text" name="date" id="date" value="<?php echo @$_REQUEST["date"]; ?>" readonly/></td>
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td> -->
            </tr>
        </table>
    </form>
</div><br>
<?php if($_REQUEST['submit']=='REPORT'){ ?>
<br/>
<div class="box-content">

<div style='float:right; width: 50px;'><a href="rep_daily_report_service_ababil_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo @$_REQUEST["representative1"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>

<h2>REPRESENTATIVE REPORT</h2>

 
<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>
	<tr><th>DATE</th><th>SALES EGINEER NAME</th><th>HOSPITAL NAME</th><th>ADDRESS/LOCATION</th><th>TOWN</th><th>CONTACT PERSON</th><th>DESIGNATION</th><th>CONTACT NUMBER</th><th>CALL DATE</th><th>PRODUCT DISCUSSED</th><th>CALL TYPE</th><th>PROSPECT / LEAD STAGE</th><th>DISCUSSION HAPPENED (REMARKS)</th><th>NEXT FOLLOWUP DATE</th></tr>
</tr>
</thead>   
<tbody>
	<?php
		$i=1;
	//$sql=mysql_query("SELECT  remarks,latt,longg,reporteddate,reportedtime,complaints,clientid,repremarks FROM reorting WHERE attendance='1' AND repid='".$_REQUEST['rep_name']."' AND reporteddate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' ");
    $rep_daily=mysql_query("SELECT * FROM reorting  WHERE repid='".$_REQUEST["representative1"]."' AND tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."'");
    
    //echo "SELECT * FROM reorting  WHERE repid='".$_REQUEST["representative1"]."' AND tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."'";
    
		while($REPDAILY=mysql_fetch_object($rep_daily)){

			//$sqlcl=mysql_query("SELECT companyname,pincode,address,mobileno,latts,longgs FROM clinetcreation WHERE id='".$row['clientid']."'");
			//$rowcl=mysql_fetch_array($sqlcl)
		// echo $row['client'].' ('.$row['pincode'].')';
         $rep_doc=mysql_query("SELECT * FROM clinetcreation WHERE id='".$REPDAILY->clientid."' ");
       $doc=mysql_fetch_object($rep_doc);
       
        $pro_arr = mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name from product where id IN (".$REPDAILY->repreportedpro.")");
        $prod_name=mysql_fetch_array($pro_arr); 
        
        $rep1=mysql_query("SELECT rep_name FROM representative WHERE id='".$REPDAILY->repid."'")or die(mysql_error());
        $rep_arr=mysql_fetch_array($rep1);
	
	?>
   <tr>
        <td><?=date("d/m/Y",strtotime($REPDAILY->tdate)); ?></td>
        <td><?php echo $rep_arr['rep_name']; ?></td>
        <td><?php echo $doc->companyname; ?></td>
        <td><?php echo $doc->address.",".$doc->Address_line1; ?></td>
        <td><?php echo $doc->Address_line2; ?></td>
        <td><?php echo $doc->name; ?></td>
        <td><?php echo $doc->desgination; ?></td>
        <td><?php echo $doc->mobileno; ?></td>
        <td><?=date("d/m/Y",strtotime($REPDAILY->tdate)); ?></td>
        <td><?php echo $prod_name['pro_name']; ?></td>
        <td><?php echo $REPDAILY->typeofcall; ?></td>
        <td><?php echo $REPDAILY->prospect_stage; ?></td>
        <td><?php echo $REPDAILY->remarks; ?></td>
        <td><?php echo $REPDAILY->scheduleddate; ?></td>
       
                
        </tr>
    <?php $i++;} ?>
</tbody>
</table>   
</div> 
<?php } ?> 
</div>
</div>
</div>
</div>
</div>
<hr>

<?php include("include/footer.php"); ?>

</div>

<!--<script src="js/jquery-1.7.2.min.js"></script>-->
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script>
    $(document).ready(function() {
    $('#example').DataTable( {
        //"scrollY": 200,
        "scrollX": true
    } );
} );

	
	</script>
</body>
</html>
<?php
}
?>
