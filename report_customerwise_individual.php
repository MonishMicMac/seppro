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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"> 
	$(function() {
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/customer_search.php",
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

<div id="content" class="span10" >

<?php } ?>
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Customer wise Report <?php if($_REQUEST["cust_name"]!=""){ echo "[".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."]"; } ?> </h2> 
</div>
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<?php $customer2 = explode("-",@$_REQUEST["cust_name"]); ?>
<h3><i class="icon-user"></i>Customer wise Report <?php if($_REQUEST["cust_name"]!=""){ echo "[".$_REQUEST["cust_name"]; ?>]  <?php $customer2 = explode("-",@$_REQUEST["cust_name"]);	
		
        $b=mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND pincode='".@$customer2[0]."' AND our_cust_id IN (SELECT DISTINCT(id) FROM tbl_customer_master WHERE shop_name = '".@$customer2[1]."') AND our_cust_id <> '' AND our_product_id <> ''")or die(mysql_error());  $p = mysql_fetch_object($b);  echo "<span style=\"padding-left:150px\"><span class=\"btn btn-primary\">PTR Value: ".round($p->PTR,2)."</span> <span class=\"btn btn-success\">PTS: Value: ".round($p->PTS,2)."</span></span>"; } ?> </h3>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
            	<td>Customer Name</td>
                <td>:</td>
                <td>
                	<input id="dd_user_input" type="text" name="cust_name" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["cust_name"]!=""){ ?>value="<?php echo @$_REQUEST["cust_name"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
                </td>
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
                <td><input type="submit" name="submit" value="CUSTOMER REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
            <tr align="right">
            	<td align="right" colspan="8" style="padding-right:80px;">
                	<?php if($_REQUEST["cust_name"]!=""){ ?>
<a href="report_customerwise_individual_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&cust_name=<?php echo @$_REQUEST["cust_name"]; ?> " target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_customerwise_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&cust_name=<?php echo @$_REQUEST["cust_name"]; ?>" target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <?php
		
        if(@$_REQUEST["submit"]=="CUSTOMER REPORT"){
			$customer = explode("-",$_REQUEST["cust_name"]);	
										
        $a=mysql_query("SELECT DISTINCT(areawise_temp.our_product_id) AS PID, areawise_temp.our_cust_id AS CID, product.pro_name AS PNAME FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.pincode='".$customer[0]."' AND areawise_temp.our_cust_id IN (SELECT DISTINCT(id) FROM tbl_customer_master WHERE shop_name LIKE '%".@$customer2[1]."%' AND pincode='".$customer[0]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){ 
    ?> 
    <tr>
    	<td style="background:#FDEAE0;"><?=$customer->PNAME;?></td>
        <td>
        	<table class="table table-striped table-bordered bootstrap-datatable datatable">
            	<tr><th style="background:#FFE4B5;text-align:center;">Distributor</th><th style="background:#FFE4B5;text-align:center;">Batch</th><th style="background:#FFE4B5;text-align:center;">Doctor Type</th><th style="background:#FFE4B5;text-align:center;">Quantity</th><th style="background:#FFE4B5;text-align:center;">Free Quantity</th><th style="background:#FFE4B5;text-align:center;">Replace Quantity</th><th style="background:#FFE4B5;text-align:center;">PTR S.Value</th><th style="background:#FFE4B5;text-align:center;">PTS S.Value</th></tr>
                <?php $customer1 = explode("-",$_REQUEST["cust_name"]); $b=mysql_query("SELECT dist_id AS DID, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(sale_value) AS SV, SUM(net_amount) AS NV, SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR  FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode='".$customer1[0]."' AND our_cust_id= '".$customer->CID."' and our_cust_id != '' AND our_product_id != '' AND our_product_id ='".$customer->PID."' GROUP BY dist_id"); while($customer1=mysql_fetch_object($b)){ ?>
                <tr><td><?php $subtotal = 0;$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$customer1->DID.""); $rd=mysql_fetch_object($sqld); echo $rd->dis_name; ?></td><td style="text-align:center"><?=$customer1->BATCH;?><td>Floating</td><td style="text-align:center"><?=$customer1->QTY;?></td><td style="text-align:center"><?=$customer1->FQTY;?></td><td style="text-align:center"><?=$customer1->RQTY;?></td><td style="text-align:right"><?php echo round($customer1->PTR,2); ?></td><td style="text-align:right"><?php echo round($customer1->PTS,2); ?></td></tr>
                <?php }?>
                
                <?php
				
					$b1=mysql_query("SELECT SUM(quantity) AS DQTY, SUM(free_quantity) AS DFQTY, SUM(replace_quantity) AS DRQTY, SUM(quantity*pts) AS YPTS, SUM(quantity*ptr) AS YPTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND pincode='".@$customer2[0]."' AND our_product_id ='".$customer->PID."' AND our_cust_id <> '' AND our_product_id <> '' AND our_cust_id = '".$customer->CID."'")or die(mysql_error());  $p1 = mysql_fetch_object($b1);
				
				?>                
               
                <tr><td style="background:#BDFCC9;" colspan="3"><strong>Sub Total</strong></td><td style="background:#BDFCC9;text-align:center" colspan="1" align="right"><strong><?php echo round($p1->DQTY,2); ?></strong></td><td style="background:#BDFCC9;text-align:center" colspan="1" align="right"><strong><?php echo round($p1->DFQTY,2); ?></strong></td><td style="background:#BDFCC9;text-align:center" colspan="1" align="right"><strong><?php echo round($p1->DRQTY,2); ?></strong></td><td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($p1->YPTR,2); ?></strong></td><td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($p1->YPTS,2); ?></strong></td></tr>
            </table>
        </td>
    </tr>
                   
       
    <?php } } ?>   
    
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
