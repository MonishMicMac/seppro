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
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
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
<?php if($_REQUEST["submit"]=="CUSTOMER REPORT"){ ?>
<a href="report_customerwise_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_customerwise_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/icon_excel.png" height="20" width="20" alt="Export Excel"></a>
<?php } ?>
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Customer wise / Area wise - Report</h2>
<div class="box-icon">
<?php $cyp = mysql_query("SELECT SUM(areawise_temp.quantity*product.pts) AS TOTPTS, SUM(areawise_temp.quantity*product.ptr) AS TOTPTR FROM areawise_temp,product WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id" ); $customer11=mysql_fetch_object($cyp); echo " <span style=\"padding-left:410px\"><span class=\"btn btn-primary\">PTR : ".round($customer11->TOTPTR,2)."</span> <span class=\"btn btn-success\">PTS : ".round($customer11->TOTPTS,2)."</span></span>"; ?>
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
            <tr>
                <td><Label>From date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo $_REQUEST["from_date"]; ?>"/></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo $_REQUEST["to_date"]; ?>"/></td>
                <td><input type="submit" name="submit" value="CUSTOMER REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
	<table class="table table-striped table-bordered bootstrap-datatable datatable">
    <?php
		if($_REQUEST["submit"]=="CUSTOMER REPORT"){
			$SQL = mysql_query("SELECT areawise_temp.pincode AS pincode,SUM(areawise_temp.quantity*product.ptr) AS PTR,SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE pincode > '0' AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id GROUP BY pincode ORDER BY pincode"); 
			while($RS=mysql_fetch_object($SQL)){ // ROOT - THALA
	?>
    	<tr><td><?=$RS->pincode; ?></td><td style="float:right;">PTR : <?=round($RS->PTR,2); ?> | PTS : <?=round($RS->PTS,2); ?></td></tr>
     <?php 
	 	$CUST=mysql_query("SELECT tbl_customer_master.shop_name AS SHOPNAME, areawise_temp.our_cust_id AS CUSTID  FROM areawise_temp,tbl_customer_master WHERE tbl_customer_master.id=areawise_temp.our_cust_id AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.pincode='".$RS->pincode."' GROUP BY areawise_temp.our_cust_id ORDER BY tbl_customer_master.shop_name");
		
		while($CUSTOMER=mysql_fetch_object($CUST)){ // SECOND - LEVEL - CUST - START
	 ?>   
        <tr>
        	<td colspan="2">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
            <tr>
        	<td><?=$CUSTOMER->SHOPNAME; ?></td>
            <?php
				$CPT = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS PTR,SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE areawise_temp.pincode='".$RS->pincode."' AND areawise_temp.our_cust_id='".$CUSTOMER->CUSTID."' AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id GROUP BY '".$CUSTOMER->CUSTID."'");
				while($PT=mysql_fetch_object($CPT)){ 
			?>
            	<td align="right" style="float:right;">PTR : <?=round($PT->PTR,2); ?> | PTS : <?=round($PT->PTS,2); ?></td>                
            <?php  } ?>
            </tr>
            </table>
            </td>
        </tr>        
    <?php		
				} // SECOND - LEVEL - CUST - END
			} // ROOT - THALA - END
		}
	?>
    
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
