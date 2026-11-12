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
<a href="report_repwise_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Export PDF"></a>
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Representative wise Report <span style="color:#FF0000;float:right;"> 
<?php $total=0;
$a1=mysql_query("SELECT SUM(areawise_temp.net_amount) AS REPTOT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.Pincode IN (SELECT pincode_list.pincode FROM pincode_list WHERE pincode_list.pin_id IN (SELECT rep_area.pin_id FROM rep_area) GROUP BY pincode_list.pincode)")or die(mysql_error());while($customer11=mysql_fetch_object($a1)){ $total+=$customer11->REPTOT; echo " -- ".round($total,2);} ?></span></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

               
        <table style="width:100%;">
            <tr>
                <td><Label>From date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
                <td><Label>To date</label></td>
                <td>:</td>
                <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
                <td><input type="submit" name="submit" value="REPRESENTATIVE REPORT" class="btn btn-primary" style="margin-top:-6px" ></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <?php
		
        if(@$_REQUEST["submit"]=="REPRESENTATIVE REPORT"){
				
			$areatotal=0;
			$repname = mysql_query("SELECT rep_name, id FROM representative");while($rn=mysql_fetch_object($repname)){
	?>
    	<tr><td colspan="1" style="background:#333333; color:#FFFFFF;"><span style="font-size:13px;">Representative Name</span>: <span style="font-size:15px;"><strong><?php echo $rn->rep_name; ?></strong></span></td><td style="background:#333333;text-align:right; color:#FFFFFF"><span style="font-size:13px;">Rep Total</span>: <span style="font-size:15px;"><strong><?php $rtotal = 0;$reptotal = mysql_query("SELECT SUM(areawise_temp.net_amount) AS NETAMOUNT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.Pincode IN (SELECT pincode_list.pincode FROM pincode_list WHERE pincode_list.pin_id IN (SELECT rep_area.pin_id FROM rep_area WHERE rep_area.rep_id = ".$rn->id." ) GROUP BY pincode_list.pincode) GROUP BY areawise_temp.pincode"); while($reptot = mysql_fetch_object($reptotal)){ $rtotal+= $reptot->NETAMOUNT; } echo round($rtotal,2); ?></strong></span></td></tr>
    <?php
			
        $a=mysql_query("SELECT areawise_temp.pincode, areawise_temp.pro_name, areawise_temp.net_amount FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.Pincode IN (SELECT pincode_list.pincode FROM pincode_list WHERE pincode_list.pin_id IN (SELECT rep_area.pin_id FROM rep_area WHERE rep_area.rep_id = ".$rn->id." ) GROUP BY pincode_list.pincode) GROUP BY areawise_temp.pincode")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){ 
    ?> 
    <tr>
    	<td style="background:#FDEAE0;"><?=$customer->pincode;?></td><td style="background:#FDEAE0;text-align:right">Total: <?php $sqlnet=mysql_query("SELECT SUM(net_amount) AS NETAMT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND pincode=".$customer->pincode.""); while($yuvaraj=mysql_fetch_object($sqlnet)){ echo round($yuvaraj->NETAMT,2); }?></td>
    </tr>
    <tr>
        <td colspan="2">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <?php 
			$sql = mysql_query("SELECT pro_name FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND pincode = ".$customer->pincode." GROUP BY pro_name");
			while($baba=mysql_fetch_object($sql)){
		?>
        	<tr>
            	<td><?=$baba->pro_name;?></td>
                <td>
        	<table class="table table-striped table-bordered bootstrap-datatable datatable">
            	<tr><th style="background:#FFE4B5">Customer</th><th style="background:#FFE4B5">Distributor</th><th style="background:#FFE4B5">Quantity</th><th style="background:#FFE4B5">Free Quantity</th><th style="background:#FFE4B5">Replace Quantity</th><th style="background:#FFE4B5">Sale Value</th><th style="background:#FFE4B5">Net Amount</th></tr>
                <?php $subtotal = 0; $sql_customer = "SELECT cust_name, dist_id, SUM(quantity) AS quantity, SUM(free_quantity) AS free_quantity, SUM(replace_quantity) AS replace_quantity, SUM(sale_value) AS sale_value, SUM(net_amount) AS net_amount FROM areawise_temp WHERE pro_name = '".$baba->pro_name."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND pincode = ".$customer->pincode." GROUP BY cust_name, dist_id ORDER BY dist_id"; $rs_customer = mysql_query($sql_customer); while($y_customer=mysql_fetch_object($rs_customer)){?>
                <tr>
                    <td><?=$y_customer->cust_name;?></td>
                    <td>
                        <?php $sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$y_customer->dist_id.""); $rd=mysql_fetch_object($sqld); echo $rd->dis_name; ?>
                    </td>
                    <td style="text-align:center;"><?=$y_customer->quantity;?></td><td style="text-align:center;"><?=$y_customer->free_quantity;?></td><td style="text-align:center;"><?=$y_customer->replace_quantity;?></td><td style="text-align:right;"><?=round($y_customer->sale_value,2);?></td><td style="text-align:right;"><?=round($y_customer->net_amount,2); $subtotal+=$y_customer->net_amount;?></td>
                </tr>
				<?php } ?>  
                <tr><td style="background:#BDFCC9;" colspan="6"><strong>Sub Total</strong></td><td style="background:#BDFCC9;text-align:right;" colspan="1"><strong><?=round($subtotal,2);?></strong></td></tr>              
            </table>
        </td>
            </tr>
         <?php } ?>
        </table>        
        </td>
    </tr>
                   
       
    <?php } } } ?>   
    
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
