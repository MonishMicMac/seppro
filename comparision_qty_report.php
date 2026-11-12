<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"> 
	$(function() {
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/rep_search.php",
	minLength: 2,
	select: function(event, ui) {
	var getUrl = ui.item.id;
	if(getUrl != '#') {
	location.href = getUrl;
	}
	},
	
	html: true, 
	
	open: function(event, ui) {
	$(".ui-autocomplete").css("z-index", 1000);
	}
	});
	
	});
	</script>	
    
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

<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>DISTRIBUTOR SALES VERFICATION : <?php $SQL = mysql_query("SELECT dis_name FROM distributor WHERE dis_id='".$_REQUEST["dist_id"]."'"); $R=mysql_fetch_object($SQL); echo $R->dis_name; ?> PRODUCT : <?=$_REQUEST["pname"]; ?> QTY : <?=$_REQUEST["qty"]; ?><span style="color:#FF0000;float:right;"> 
</span></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">


<div class="box-content">
<table align="right"><tr><td style="float:right"><a href="history.go('-1');" style="float:right">&laquo; BACK</a></td></tr></table>
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
   	<tr><th align="center" style="text-align:center">Customer Name</th><th align="center" style="text-align:center">Pincode</th><th align="center" style="text-align:center">QTY</th><th align="center" style="text-align:center">FQTY</th><th align="center" style="text-align:center">RQTY</th></tr>
    <?php
    // echo "SELECT tbl_customer_master.shop_name AS SNAME, master_pincode.pincode AS P, areawise_temp.quantity AS Q,areawise_temp.free_quantity AS F,areawise_temp.replace_quantity AS R FROM areawise_temp,tbl_customer_master,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND  areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' AND  areawise_temp.our_product_id='".$_REQUEST["product_id"]."'  AND areawise_temp.our_cust_id=tbl_customer_master.id AND areawise_temp.pin_id=master_pincode.pin_id";
		
		$a=mysql_query("SELECT tbl_customer_master.shop_name AS SNAME, master_pincode.pincode AS P, areawise_temp.quantity AS Q,areawise_temp.free_quantity AS F,areawise_temp.replace_quantity AS R FROM areawise_temp,tbl_customer_master,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND  areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' AND  areawise_temp.our_product_id='".$_REQUEST["product_id"]."'  AND areawise_temp.our_cust_id=tbl_customer_master.id AND tbl_customer_master.pin_id=master_pincode.pin_id");
		echo mysql_error();
      	$TQ="";$FQ="";$RQ="";
        while($customer=mysql_fetch_object($a)){ $TQ+=$customer->Q;$FQ+=$customer->F;$RQ+=$customer->R;
    ?> 
    <tr>    	
        <td style="text-align:left;" align="center"><?=$customer->SNAME;?></td>
        <td style="text-align:left;" align="center"><?=$customer->P;?></td>
        <td style="text-align:center;" align="center"><?=$customer->Q;?></td>
        <td style="background:#FDEAE0;text-align:center;" align="center"><?=$customer->F;?></a></td>
        <td style="background:#FDEAE0;text-align:center;" align="center"><?=$customer->R;?></td>
    </tr>
    <?php
	} 
	?>
    <tr><td colspan="2">SUB TOTAL</td><td style="text-align:center"><?=$TQ; ?></td><td style="text-align:center"><?=$FQ; ?></td><td style="text-align:center"><?=$RQ; ?></td></tr>
    
</table>
<table align="right"><tr><td style="float:right"><a href="javascript:history.go(-1);" style="float:right">&laquo; BACK</a></td></tr></table>
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