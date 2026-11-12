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
<h2><i class="icon-user"></i>Representative (INDIVIDUAL) kmwise Report <span style="color:#FF0000;float:right;"> 
<?php if(@$_REQUEST["submit"]=="DISTRIBUTOR REPORT"){
$a1=mysql_query("SELECT SUM(quantity) AS SQTY, SUM(free_quantity) AS SFQTY, SUM(replace_quantity) AS SRQTY, SUM(quantity*pts) AS TOTPTS, SUM(quantity*ptr) AS TOTPTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1); echo " <span style=\"padding-left:410px\"><span class=\"btn btn-primary\">PTR : ".round($customer11->TOTPTR,2)."</span> <span class=\"btn btn-success\">PTS : ".round($customer11->TOTPTS,2)."</span></span>";} ?></span></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
            	<td>DISTRIBUTOR NAME</td>
                <td>:</td>
                <td><select  id="dist_id" name="dist_id" data-rel="chosen">
<option value="">--Select--</option>
<?php
while($row_res=mysql_fetch_array($res))
{
$dis_name=$row_res['dis_name'];
$dist_id=$row_res['dis_id'];
?>
<option value="<?php echo $dist_id; ?>"><?php echo $dis_name; ?></option>
<?php } ?> 
</select><script>document.thisForm.dist_id.value="<?php echo $_REQUEST["dist_id"]; ?>"</script></td>
            </tr>            
           
        </table>
        
        <table style="width:100%;">
            <tr>
                <td><Label>From date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
                <td><input type="submit" name="submit" value="DISTRIBUTOR REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
            <tr>
            	<td colspan="8" align="right" style="padding-right:89px">
                	<?php if(@$_REQUEST["submit"]=="DISTRIBUTOR REPORT"){ ?>
                        <a href="report_distributor_individual_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&dist_id=<?php echo @$_REQUEST["dist_id"]; ?>" target="_blank"><img src="img/pdf.png" width="20" height="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_distributor_individual_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&dist_id=<?php echo @$_REQUEST["dist_id"]; ?>&m_id16=<?php echo $m_id16; ?> " target="_blank"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>
                        <?php } ?>
                </td>           
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
   	<tr><th align="center" style="text-align:center">Product Name</th><th align="center" style="text-align:center">Batch</th><th align="center" style="text-align:center">No of Pincodes Covered</th><th align="center" style="text-align:center">No of Customers Covered</th><th align="center" style="text-align:center">QTY</th><th align="center" style="text-align:center">FQTY</th><th align="center" style="text-align:center">RQTY</th><th align="center" style="text-align:center">PTS</th><th align="center" style="text-align:center">PTR</th></tr>
    <?php
        if(@$_REQUEST["submit"]=="DISTRIBUTOR REPORT"){	
		
		$DISTRIBUTOR=mysql_query("SELECT our_id FROM dist_prod WHERE dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_id");
		while($pid=mysql_fetch_object($DISTRIBUTOR)){
		
		$a=mysql_query("SELECT product.id AS PID,COUNT(DISTINCT(areawise_temp.pincode)) AS PIN, COUNT(DISTINCT(areawise_temp.our_cust_id)) AS CUST,product.pro_name AS PRODUCT, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, (SELECT sum(areawise_temp.quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS QTY, (SELECT sum(areawise_temp.free_quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS FQTY,(SELECT sum(areawise_temp.replace_quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS RQTY, (SELECT sum(quantity*ptr) FROM areawise_temp WHERE our_product_id='".$pid->our_id."' AND (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_product_id) AS PTR, (SELECT sum(quantity*pts) FROM areawise_temp WHERE our_product_id='".$pid->our_id."' AND (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_product_id) AS PTS  FROM product,dist_prod,areawise_temp WHERE dist_prod.dist_id='".$_REQUEST["dist_id"]."' AND dist_prod.our_id=product.id AND product.id=areawise_temp.our_product_id AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' AND dist_prod.our_id='".$pid->our_id."' GROUP BY dist_prod.our_id,areawise_temp.our_product_id");
       
        while($customer=mysql_fetch_object($a)){ 
    ?> 
    <tr>
        <td><?=$customer->PRODUCT;?></td>
    	<td><?=$customer->BATCH;?></td>
        <td style="text-align:center;" align="center"><?=$customer->PIN;?></td>
        <td style="text-align:center;" align="center"><?=$customer->CUST;?></td>
        <td style="background:#FDEAE0;text-align:center;" align="center">
        	<a href="comparision_qty_report.php?dist_id=<?=$_REQUEST["dist_id"]; ?>&from_date=<?=$_REQUEST["from_date"]; ?>&to_date=<?=$_REQUEST["to_date"]; ?>&product_id=<?=$customer->PID; ?>&pname=<?=$customer->PRODUCT;?>&qty=<?=$customer->QTY;?>"><?=$customer->QTY;?></a></td>
        <td style="background:#FDEAE0;text-align:center;" align="center"><?=$customer->FQTY;?></td>
        <td style="background:#FDEAE0;text-align:center;" align="center"><?=$customer->RQTY;?></td>
        <td style="background:#FDEAE0;text-align:right;" align="center"><?=round($customer->PTS,2);?></td>
        <td style="background:#FDEAE0;text-align:right;" align="center"><?=round($customer->PTR,2);?></td>
    </tr>
    <?php
	} }
		$a2=mysql_query("SELECT SUM(quantity*pts) AS TOTPTS, SUM(quantity*ptr) AS TOTPTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."'")or die(mysql_error());$customer2=mysql_fetch_object($a2);
	?>
    
    <tr><td colspan="4"><strong>Total</strong></td><td style="text-align:center" align="center"><?=$customer11->SQTY;?></td><td style="text-align:center" align="center"><?=$customer11->SFQTY;?></td><td style="text-align:center" align="center"><?=$customer11->SRQTY;?></td><td align="right" style="text-align:right"><?=round($customer11->TOTPTS,2);?></td><td style="text-align:right"><?=round($customer11->TOTPTR,2);?></td></tr>
    <?php } ?>   
    
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