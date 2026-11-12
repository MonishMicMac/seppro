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

    $('#from_date').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: '1980:' + new Date().getFullYear(),
        beforeShow: function(el, dp) { 
            $('#ui-datepicker-div').addClass('hide-calendar');
        },
        onClose: function(dateText, inst) { 
            $('#ui-datepicker-div').removeClass('hide-calendar');
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
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
<style>
 .ui-datepicker-calendar {
   display: none;
 }
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
<h2><i class="icon-user"></i>STOCK AND SALES CLIENT REPORT</h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="stocksales_moth_client_report_excel.php" method="post">
    	<table style="width:100%;">
            <tr>
            	<?php if($_SESSION['AUTH']=='3'){ ?>
            	<td><CENTER>Client Name</CENTER></td>
                <td>:</td>
                <td><select id="cli_name" name="cli_name" data-rel="chosen">
				<option value="">--Select--</option>
				<?php
				echo "SELECT * FROM clinetcreation WHERE id IN (select clientid from productinsertt GROUP BY clientid)";
				$res=mysql_query("SELECT * FROM clinetcreation WHERE id IN (select clientid from productinsertt GROUP BY clientid) ORDER BY cast(id as unsigned)");
				while($row_res=mysql_fetch_array($res)) {				
				?>
				<option value="<?php echo $row_res['id']; ?>"><?php echo $row_res['companyname']; ?></option>
				<?php } ?> 
				</select><script>document.thisForm.rep_name.value="<?php echo $_REQUEST["companyname"]; ?>"</script></td>
				<?php } ?>
                <td><Label>Month &amp; Year</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly/></td>
                
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td>
            </tr>
        </table>
   <!--      <center>
         <div style='float:right; width: 50px;'><a href="expenses_rep_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"></a></div>
     </center> -->
    </form>
</div><br>
<?PHP if(@$_REQUEST["submit"]=="REPORT"){ 
$from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

	
?>
<!--  <div style='float:right; width: 50px;'><a href="expenses_rep_report_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&rep_name=<?php echo @$_REQUEST["rep_name"]; ?>" target="_blank" style="margin-left: -30px;"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a></div> -->
    <br/>
<br/>
<!-- <div class="box-content">
<h2>LIST OF CUSTOMER</h2>
<table id="example" class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>
	<th style="text-align:center">S.NO</th>
	<th hidden></th><th style="text-align:center">Date</th>
	<th style="text-align:center">AREA COVERED</th>
	<th style="text-align:center">KMS</th>
	<th style="text-align:center">ALLOWANCE</th>


</tr>
</thead>   
<tbody>
	<?php	

$sqlsqq=mysql_query("SELECT rep_hq_wages FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
$aqq=mysql_fetch_array($sqlsqq);
$wages=$aqq['rep_hq_wages'];


		$p=1;	
	

		$SQL=mysql_query("SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,doc_qualification,drorchemist,doc_gender,doc_specilist_id,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,IFNULL((select targetamount from targetachievemneet where cusid=doctors.id AND month='".date("m",strtotime($from_date))."' AND year='".date("Y",strtotime($from_date))."'),'No target') as area_name FROM doctors WHERE rep_assign='".$_REQUEST['rep_name']."' ORDER BY id DESC");
		while($Y=mysql_fetch_object($SQL)){	
		
		        $sql1=mysql_query("SELECT productid,qty FROM pobbooking1 where client_id='".$Y->id."' AND cdate BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'");
		$pr=0;
		while($row1=mysql_fetch_object($sql1))
		{	

 		 $sqlpr=mysql_query("SELECT pro_mrp FROM product where id='".$row1->productid."'");
			$rowpr=mysql_fetch_object($sqlpr);
				

			$rt=$row1->qty*$rowpr->pro_mrp;

		$pr=($pr+$rt);
			
		}
		
			?>
		 <tr class="amma"><td style="text-align:center"><?=$p; ?></td>
		 	
		 	<td ><?php echo $Y->doctor_name; ?></td>
		 	<td ><?php echo $Y->drorchemist; ?></td>
		 	<td ><?php echo $Y->area_name ?></td>
		 	<td ><?php  echo $pr; ?></td>
		 		</tr>

   
    <?php $p++;} ?>
</tbody>
</table>  


</div>  -->  
<!-- <hr style="border:1px solid #317eac;height: 0px;"> -->
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

</body>
</html>
<?php
}
?>
