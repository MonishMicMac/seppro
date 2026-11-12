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
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
yearRange: "2015:2025",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "2015:2025",
dateFormat:"yy/mm/dd"
});
    // $('#from_date').datepicker( {
    //     changeMonth: true,
    //     changeYear: true,
    //     showButtonPanel: true,
    //     dateFormat: 'MM yy',
    //     yearRange: '1980:' + new Date().getFullYear(),
    //     beforeShow: function(el, dp) { 
    //         $('#ui-datepicker-div').addClass('hide-calendar');
    //     },
    //     onClose: function(dateText, inst) { 
    //         $('#ui-datepicker-div').removeClass('hide-calendar');
    //         var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    //         $(this).datepicker('setDate', new Date(year, month, 1));
    //     }
    // });

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
<style>
/* .ui-datepicker-calendar {
   display: none;
 }*/
</style>

	
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
<h2><i class="icon-user"></i>REP Attendance Report</h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">
    	<table style="width:100%;">
            <tr>
            	<?php if($_SESSION['AUTH']=='3'){ ?>
            	<td style="width:10%;">Representative</td>
                <td>:</td>
                <td><select id="rep_name" name="rep_name" data-rel="chosen">
				<option value="">--Select--</option>
				<?php
				$res=mysql_query("SELECT * FROM representative");
				while($row_res=mysql_fetch_array($res)) {
				$rep_name1=$row_res['rep_name'];
				$id=$row_res['id'];
				?>
				<option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
				<?php } ?> 
				</select><script>document.thisForm.rep_name.value="<?php echo $_REQUEST["rep_name"]; ?>"</script></td>
				<?php } ?>
                <!-- <td><Label>Month &amp; Year</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly/></td>
                
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td> -->
                <td style="width:10%;"></td>
                <td></td>
                <td></td>
                  <td style="width:10%;"></td>
                <td></td>
                <td></td>
            </tr>
        </table>

    <table style="width:100%;">
    <tr>
        <td style="width:10%;"><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td style="width:10%;"><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td style="width:10%;"><input type="submit"  name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
    </tr>
    </table>

    </form>
</div><br>
<?PHP if(@$_REQUEST["submit"]=="REPORT"){ 

	
?>
 <div style='float:right; width: 50px;'><a href="rep_attendance_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div>

<div class="box-content">
<h2>Attendance REPORT</h2>
<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>
	<th style="text-align:center">S.NO</th>
	<th hidden></th><th style="text-align:center">Date</th>
	<th style="text-align:center">Day</th>
	<th style="text-align:center">Plan</th>
	<th style="text-align:center">Reason</th>

</tr>
</thead>   
<tbody>
	<?php	
		$p=1;	
		$Daysperiod=mysql_query("select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' ");
while($D=mysql_fetch_object($Daysperiod)){  ?>
				     <tr class="amma"><td style="text-align:center"><?=$p; ?></td>                        
            <td ><?php echo $D->selected_date; ?></td>
                <td ><?php echo date('l', strtotime($D->selected_date));  ?></td>
                        <?php
		$SQL=mysql_query("SELECT * from repgivenasleave where leaveapplieddate ='".date("Y-m-d",strtotime($D->selected_date))."' AND `repid`='".$_REQUEST['rep_name']."'");
        $Y=mysql_num_rows($SQL);
        if($Y > 0)
        {
		$Y=mysql_fetch_object($SQL);	
		
			?>
	
		 		<td ><?php echo $Y->expenses; ?></td>
		 		<td ><?php echo $Y->reason; ?></td></tr>

   
    <?php 
    }
        else
            
        { 
            $clientcheck=mysql_query("SELECT  wp_dc_id from tbl_work_plan WHERE wp_date ='".date("Y-m-d",strtotime($D->selected_date))."' AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND attendancestatus='1'");
            $clientcheck_row=mysql_num_rows($clientcheck);
            if($clientcheck_row > 0)
            {
                $SQLdoc=mysql_query("SELECT GROUP_CONCAT(wp_dc_id) AS dcid  from tbl_work_plan WHERE wp_date ='".date("Y-m-d",strtotime($D->selected_date))."' AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND attendancestatus='1' ");
                $SQLdoc_row=mysql_fetch_object($SQLdoc);  
               
                 $SQLpin=mysql_query("SELECT GROUP_CONCAT(doc_pin_id) AS dcpin from doctors WHERE `rep_id`='".$_REQUEST['rep_name']."' AND id IN (".$SQLdoc_row->dcid.")");
                $SQLpin_row=mysql_fetch_object($SQLpin);  
               
                 $SQLstn=mysql_query("SELECT distinct(station) AS plandre from stationplanforrep where `repid`='".$_REQUEST['rep_name']."' AND pinid IN (".$SQLpin_row->dcpin.")");
                $SQLstn_row=mysql_fetch_object($SQLstn); 
             
                   if($SQLstn_row->plandre=='local')
                   {  ?>
                    <td ><?php echo $SQLstn_row->plandre; ?></td>
                    <td ><?php echo $SQLstn_row->plandre; ?></td></tr>
                    <?php
                   }
                   else
                   {  ?>
                    <td ><?php echo "out"; ?></td>
                    <td ><?php echo "out"; ?></td></tr>
                    <?php
                   }
            }
            else
            { ?>                
                <td ><?php echo "-"; ?></td>
                <td ><?php echo "-"; ?></td></tr>
                <?php
            }

     
        }
        $p++;
             }?>
</tbody>
</table>  


</div>   <hr style="border:1px solid #317eac;height: 0px;">
<?PHP } ?>
<div>&nbsp;</div>      
<div style="height:auto;" id="consolidated1"></div>  
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


});
	$('.amma').click(function(){
// alert("hi");
		$.get("autosearch-y/rep_reporting.php?customerwise=yuvi&daterep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep="+$('#rep_name').val()+"",function(data){
			// alert(data);
			$("#consolidated1").html(data);
		});	
		$.get("autosearch-y/rep_reporting.php?consolidated=yuvi&from_date="+$('#from_date').val()+"&to_date="+$('#to_date').val()+"&rep="+$(this).closest('tr').find('td:eq(1)').text()+"&rep_name="+$(this).closest('tr').find('td:eq(2)').text()+"",function(data){
			$("#consolidated").html(data);
		});		
	});

	

</script>
</body>
</html>
<?php
}
?>
