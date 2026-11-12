<?php
include("include/connect.php");
session_start();
error_reporting(0);
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
function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
   /* echo 'Miles ='.$miles;
    echo '<br>Nautical Miles : '.$nautical_miles = $miles * 0.868976;
    echo '<br>Kilometers : '.$kilometers = $miles * 1.609344;*/
    //return round($miles * 1609.34);
    return round($miles * 1.609344,2);
    /*echo '<br>Yards : '.$yards = number_format(($miles * 1760),4);
    echo '<br>Feet : '.$feet = number_format(($miles * 5280),4);
    echo '<br>inches : '.$inches = number_format(($miles * 63360),4);*/
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
$( "#date" ).datepicker({
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
<h2><i class="icon-user"></i>Work Plan Report</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        
        <table style="width:40%;">
            <tr>
                <td><Label>Date</label></td>
                <td>:</td>
                <td><input type="text" name="date" id="date" readonly value="<?php echo @$_REQUEST["date"]; ?>"/></td>
                <td><button type="submit" name="submit" value="DOC REPORT" class="btn btn-primary" style="margin-top:-12px" >View Report</button></td>
                <td></td>
            </tr>
             
        </table>
    </form>
</div>
<div class="box-content">
<?php if(@$_REQUEST["submit"]=="DOC REPORT"){ ?>
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <?php
    $cnt_sql_doc=mysql_query("select count(*) as total,sum(case when attendancestatus='1' and drunavailablereason!='' then 1 else 0 end) as reported from tbl_work_plan WHERE date(wp_date)='".$_REQUEST["date"]."' and wp_rep_id='".$_SESSION["repid"]."' and wp_dc_id!='' and wp_dc='D'")or die(mysql_error());
    $cnt_doc=mysql_fetch_object($cnt_sql_doc);
    ?>
    <tr><td colspan="3"><h3>Doctor Report</h3></td><td style="padding-top: 13px;text-align: right;">[<?php if(isset($cnt_doc->total)) echo $cnt_doc->total; else echo '0'; ?> / <?php if(isset($cnt_doc->reported)) echo $cnt_doc->reported; else echo '0'; ?>]</td></tr>
    <tr>        
        <th>Doctor Name</th><th>Report</th><th>UP</th><th>Time</th>
    </tr>
    <?php
        $sql_doc=mysql_query("SELECT reportedtime,(select doctor_name from doctors where id=a.wp_dc_id) as doc_name,drunavailablereason,(case when attendancestatus='0' and UP='U' then 'U/M' else UP end) as attendance FROM tbl_work_plan as a WHERE date(wp_date)='".$_REQUEST["date"]."' and wp_rep_id='".$_SESSION["repid"]."' and wp_dc_id!='' and wp_dc='D'")or die(mysql_error());
        $doc_count=mysql_num_rows($sql_doc);
        if($doc_count > 0){
        while($row_doc=mysql_fetch_object($sql_doc)){
        if($row_doc->attendance == 'U/M'){
    ?>
    <tr>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_doc->doc_name; ?></td>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_doc->drunavailablereason; ?></td>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_doc->attendance; ?></td>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_doc->reportedtime; ?></td>
    </tr> 
    <?php } else { ?>
    <tr>
        <td><?php echo $row_doc->doc_name; ?></td>
        <td><?php echo $row_doc->drunavailablereason; ?></td>
        <td><?php echo $row_doc->attendance; ?></td>
        <td><?php echo $row_doc->reportedtime; ?></td>
    </tr>
    <?php }}} else { ?>
    <tr><td colspan="4" style="text-align:center">No Records</td></tr>
    <?php } ?>

    <?php
    $cnt_sql_chem=mysql_query("select count(*) as total,sum(case when attendancestatus='1' and drunavailablereason!='' then 1 else 0 end) as reported from tbl_work_plan WHERE date(wp_date)='".$_REQUEST["date"]."' and wp_rep_id='".$_SESSION["repid"]."' and wp_dc_id!='' and wp_dc='C'")or die(mysql_error());
    $cnt_chem=mysql_fetch_object($cnt_sql_chem);
    ?>
    <tr><td colspan="3"><h3>Chemist Report</h3></td><td style="padding-top: 13px;text-align: right;">[<?php if(isset($cnt_chem->total)) echo $cnt_chem->total; else echo '0'; ?> / <?php if(isset($cnt_chem->reported))echo $cnt_chem->reported; else echo '0'; ?>]</td></tr>
    <tr>        
        <th>Chemist Name</th><th>Report</th><th>UP</th><th>Time</th>
    </tr>
    <?php
        $sql_chem=mysql_query("SELECT reportedtime,(select shop_name from tbl_customer_master where id=a.wp_dc_id) as chem_name,drunavailablereason,(case when attendancestatus='0' and UP='U' then 'U/M' else UP end) as attendance FROM tbl_work_plan as a WHERE date(wp_date)='".$_REQUEST["date"]."' and wp_rep_id='".$_SESSION["repid"]."' and wp_dc_id!='' and wp_dc='C'")or die(mysql_error());
        $chem_count=mysql_num_rows($sql_chem);
        if($chem_count > 0){
        while($row_chem=mysql_fetch_object($sql_chem)){
        if($row_chem->attendance == 'U/M'){
    ?>
    <tr>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_chem->chem_name; ?></td>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_chem->drunavailablereason; ?></td>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_chem->attendance; ?></td>
        <td style="background:#C690D4;color:#FFFFFF;"><?php echo $row_chem->reportedtime; ?></td>
    </tr> 
    <?php } else { ?>
    <tr>
        <td><?php echo $row_chem->chem_name; ?></td>
        <td><?php echo $row_chem->drunavailablereason; ?></td>
        <td><?php echo $row_chem->attendance; ?></td>
        <td><?php echo $row_chem->reportedtime; ?></td>
    </tr> 
	<?php }}} else { ?>   
    <tr><td colspan="4" style="text-align:center">No Records</td></tr>
    <?php }} ?>
    
</table>
</div>        
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
});
</script>
</body>
</html>
<?php
}
?>
