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
<a href="report_productwise_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Export PDF"></a>
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Product wise / Area wise - Report <?php if(@$_REQUEST["submit"]=="PRODUCT REPORT"){ $ptotal = 0;	
		$a1=mysql_query("SELECT  SUM(net_amount) AS NPTOT FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM `rep_area`) GROUP BY pincode) AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pro_name  ORDER BY pro_name, pincode"); while($p = mysql_fetch_object($a1)){  $ptotal+=$p->NPTOT;}echo "<span style='color:#ff0000'>: ".round($ptotal,2)."</span>";} ?></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<ul  class="list" style="list-style-type:none;">
<li>
<form name="thisForm" action="" method="post">

<table style="width:100%;">
    <tr>
        <td><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td><input type="submit" name="submit" value="PRODUCT REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
    </tr>
</table>
</form>

<div id="yuvaraj">
<table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">

	<?php	
	if(@$_REQUEST["submit"]=="PRODUCT REPORT"){	
		$a=mysql_query("SELECT  pro_name AS PRODUCT, SUM(net_amount) AS NAMT, pincode AS PINCODE FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM `rep_area`) GROUP BY pincode) AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pro_name  ORDER BY pro_name, pincode");
		while($product=mysql_fetch_object($a)){ ?>
        <tr style="background:#ea3511; color:#FFFFFF; border:none;"><td style="background:#ea3511; color:#FFFFFF;border:none;"><?=$product->PRODUCT; ?> </td><td style="background:#ea3511; color:#FFFFFF;border:none;float:right;">Product Total: <?=round($product->NAMT,2); ?> </td></tr>
        <?php $repwise = mysql_query("SELECT representative.rep_name AS rep, pincode_list.pincode AS pincodes FROM representative, rep_area, pincode_list, areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND representative.id = rep_area.rep_id AND pincode_list.pin_id = rep_area.pin_id AND areawise_temp.pincode = pincode_list.pincode AND areawise_temp.pro_name = '".$product->PRODUCT."' GROUP BY pincode_list.pincode"); while($repwise_rs = mysql_fetch_object($repwise)){  ?>
        <tr><td colspan="2">
        <table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
        <tr style="background:#3D3C3A; color:#FFFFFF;">
        <td style="background:#3D3C3A;"><strong>Rep Name: <?php echo  $repwise_rs->rep; ?></strong> </td>
        <td style="background:#3D3C3A;float:right;"><strong>Rep Total : <?php $reptotal = mysql_query("SELECT SUM(net_amount) AS RTOT FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pro_name = '".$product->PRODUCT."' AND pincode = ".$repwise_rs->pincodes.""); while($reptotal_rs=mysql_fetch_object($reptotal)){ echo round($reptotal_rs->RTOT,2); } ?></strong> </td>
        </tr> 
        </table>
        </td></tr>       
        <tr style="background:#DEB887;"><td colspan="2" style="background:#DEB887;"><strong><?=$repwise_rs->pincodes; ?></strong></td></tr>
        
        <tr><td colspan="2">
                <table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
                   <tr><th style="background:#fbd8d1">Customer Name</th><th style="background:#fbd8d1">Distributor</th><th style="background:#fbd8d1">Doctor Type</th><th style="background:#fbd8d1">Quantity</th><th style="background:#fbd8d1">Free Quantity</th><th style="background:#fbd8d1">Replace Quantity</th><th style="background:#fbd8d1">Sale Value</th><th style="background:#fbd8d1">Net Amount</th></tr> 
                    <?php $sql1 = "SELECT cust_name,dist_id,SUM(quantity) AS Q,SUM(free_quantity) AS F,SUM(replace_quantity) AS R,SUM(sale_value) AS S,SUM(net_amount) AS N  FROM `areawise_temp` WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `pro_name` = '".$product->PRODUCT."' AND pincode = ".$repwise_rs->pincodes." AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY cust_name, dist_id"; $rs1 = mysql_query($sql1); while($res1 = mysql_fetch_object($rs1)){ ?>
                    <tr><td><?=$res1->cust_name; ?></td><td><?php $subtotal = 0;$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$res1->dist_id.""); $rd=mysql_fetch_object($sqld); echo $rd->dis_name; ?></td><td>Floating</td><td><?=$res1->Q; ?></td><td><?=$res1->F; ?></td><td><?=$res1->R; ?></td><td><?=round($res1->S,2); ?></td><td><?=round($res1->N,2); ?></td></tr>                    
                    <?php } ?>
                </table>
            </td></tr>
        	
             <tr><td colspan="2">
            <table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
            <tr  style="background:#DEB887;"><td style="background:#DEB887;"><?=$repwise_rs->pincodes; ?> - Subtotal</td><td style="background:#DEB887;float:right;"><?php $rtot=0; $sql2 = "SELECT SUM(net_amount) AS Y  FROM `areawise_temp` WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `pro_name` = '".$product->PRODUCT."' AND pincode = ".$repwise_rs->pincodes." AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pincode"; $rs2 = mysql_query($sql2); while($res3 = mysql_fetch_object($rs2)){ $rtot+= $res3->Y; echo round($rtot,2); } ?></td></tr>
            </table>
            </td></tr>
                         
	<?php }}} ?>    

</table>
</div>
</li>
</ul> 
</div>      
</div>
</div>
</div>
</div>
</div>
<hr>

<?php include("include/footer.php"); ?>

</div>
<script>
var options = {
    valueNames: [ 'name']
};

var hackerList = new List('hacker-list', options);
</script>
<script src="js/jsl.js" type="text/javascript"></script>
<script src="js/common.js" type="text/javascript"></script>
<script src="datepicker/calendar.js" type="text/javascript"></script>
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

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', '', 'height=7016,width=4960');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }
	
	function doit(){
		if (!window.print){
		alert("You need NS4.x to use this print button!")
		return
		}
		window.print()
		}

</script>		
</body>
</html>
<?php
}
?>
