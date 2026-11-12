<?php
include("include/connect.php");
// session_start();
error_reporting(0);
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
$res2=mysql_query("SELECT DISTINCT(dist_id) FROM pincode_list")or die(mysql_error());
$abc=mysql_query("SELECT * FROM tbl_customer_master order by id desc limit 1")or die(mysql_error());
$row_abc=mysql_fetch_array($abc);
$co_abc=mysql_num_rows($abc);
if($co_abc > 0)
{
    $cust_id=$row_abc['id']+1;
}
else 
{
    $cust_id="10001";
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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
$( "#from_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "2015:2025",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "2015:2025",
dateFormat:"yy/mm/dd"
});
//ajax Starts
$("#search_box").keypress(function(){
    var from_date =$("#from_date").val();
    var to_date    =$("#to_date").val();
    var content =$("#search_box").val();
    var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
    $.get(url,function(data,status){
        $("#search").html(data);
    });
});
//ajax Ends
});
</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>  
 <script type="text/javascript" src="google_dynamic_map.js"></script>
    </head>

<body onLoad="initialize();">
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>
			
			
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>REPRESENTATIVE WISE DOCTOR YIELD REPORT</h2>
<div class="box-icon">
</div>
</div>   

<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
 	<div class="control-group"><label class="control-label" for="typeahead">Current Representative<span style="color:#FF0000;">*</span> </label>
<div class="controls">
	<select name="representative" id="representative" data-rel="chosen" required>
    	<option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM representative WHERE rep_activatedeactivate=0 ORDER BY id"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?=$I->id; ?>"><?=$I->rep_name; ?></option>
        <?php } ?>
    </select><script>document.getElementById("representative").value="<?=$_REQUEST["representative"] ?>";</script>
</div></div>
<div class="control-group"><label class="control-label" for="typeahead">Report Date Range<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <table style="width:100%;">
    <tr>
        <td><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td><input type="submit" id="rep_report" name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
    </tr>
    </table>
</div></div>


</fieldset>
</form>
</div>
<br>
<?PHP if(@$_REQUEST["submit"]=="REPORT"){ 
	
?>
 <div style='float:right; width: 50px;'><a href="rep_yield_report_zinnia_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&representative=<?php echo @$_REQUEST["representative"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>
<br/>
<div class="box-content">
<h2>CUSTOMER DETAILS</h2>
<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>
	<th style="text-align:center">S.NO</th>
	<th style="text-align:center">DR NAME</th>
	<th style="text-align:center">CATEGORY</th>
	<th style="text-align:center">AREA</th>
	<th style="text-align:center">PINCODE</th>
	<th style="text-align:center">QLY</th>
	<th style="text-align:center">SQLY</th>
	<th style="text-align:center">CHEMIST</th>
	<th style="text-align:center">Covered Date</th>


</tr>
</thead>   
<tbody>
	<?php	
		$p=1;	
		/* echo "SELECT * from doctors,tbl_work_plan where doctors.`rep_id`=tbl_work_plan.`wp_rep_id` AND doctors.`rep_id`='".$_REQUEST['rep_name']."' AND tbl_work_plan.attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."')"; exit;*/
		// echo "SELECT doctor_name,doc_qualification,doc_specilist_id,doc_pin_id,(select GROUP_CONCAT(shop_name) AS chemist from tbl_customer_master where id IN (doctors.chemist_id)) AS chemistname from doctors where  `rep_id`='".$_REQUEST['representative']."' AND id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."'))";
		$SQL=mysql_query("SELECT id,doctor_name,doc_qualification,doc_category,doc_specilist_id,doc_pin_id,(select GROUP_CONCAT(shop_name) AS chemist from tbl_customer_master where id IN (doctors.chemist_id)) AS chemistname from doctors where  `rep_id`='".$_REQUEST['representative']."' AND id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."'))");
		while($Y=mysql_fetch_object($SQL)){	
			$pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$Y->doc_pin_id."' ");	
			$pinarea_res=mysql_fetch_object($pinarea);

			$visitdate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate FROM tbl_work_plan WHERE wp_dc_id ='".$Y->id."' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')  ");	
			$visitdate_res=mysql_fetch_object($visitdate);
		
		
			?>
		 <tr class="amma"><td style="text-align:center"><?=$p; ?></td>
		 	
		 	<td ><?php echo $Y->doctor_name; ?></td>
		 	<td ><?php echo $Y->doc_category; ?></td>
		 	<td ><?php echo $pinarea_res->area_name; ?></td>
		 	<td ><?php echo $pinarea_res->pincode; ?></td>
		 	<td ><?php echo $Y->doc_qualification; ?></td>
		 	<td ><?php echo $Y->doc_specilist_id; ?></td>
		 	<td ><?php  echo $Y->chemistname; ?></td>
		 	<td ><?php  echo $visitdate_res->rpdate; ?></td>
		 		</tr>

   
    <?php $p++;} ?>
</tbody>
</table>  


</div>   
<?PHP } ?>
</div>
</div>

</div>
</div>

<hr>
      
    </div>

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
