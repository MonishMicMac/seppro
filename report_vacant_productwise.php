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

<div id="content" class="span10" >

<?php } ?>
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Customer wise Report <?php if(@$_REQUEST["submit"]=="PRODUCT REPORT"){ echo "[".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."]"; } ?> </h2> 
</div>
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<?php $customer2 = explode("-",@$_REQUEST["cust_name"]); ?>
<h3><i class="icon-user"></i>Customer wise Report <?php  if(@$_REQUEST["submit"]=="PRODUCT REPORT"){	
			$SQL = mysql_query("SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id  FROM rep_area GROUP BY pin_id) GROUP BY pincode");
			while($RS=mysql_fetch_assoc($SQL)){
				@$YUVI.=$RS["pincode"].",";
			}
			$mama=@$YUVI; // VACANT PINCODE
			$SQL1=mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM `areawise_temp`,product WHERE `pincode` NOT IN (".substr(@$mama,0,-1).") AND pincode>0 AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id");		
		
          $p = mysql_fetch_object($SQL1);  echo "<span style=\"padding-left:440px\"><span class=\"btn btn-primary\">PTR Value: ".round($p->PTR,2)."</span> <span class=\"btn btn-success\">PTS: Value: ".round($p->PTS,2)."</span></span>"; } ?> </h3>
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
                <td><input type="submit" name="submit" value="PRODUCT REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
             <tr align="right">
            	<td align="right" colspan="8" style="padding-right:80px;">
                	<?php if($_REQUEST["submit"]=="PRODUCT REPORT"){ ?>
<a href="report_vacant_productwise_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
				<?php } ?>
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <?php
		
        if(@$_REQUEST["submit"]=="PRODUCT REPORT"){
			$SQL = mysql_query("SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id  FROM rep_area GROUP BY pin_id) GROUP BY pincode");
			while($RS=mysql_fetch_assoc($SQL)){
				@$YUVI.=$RS["pincode"].",";
			}
			$mama=@$YUVI; // VACANT PINCODE
			$SQL1=mysql_query("SELECT `pincode` FROM `areawise_temp` WHERE `pincode` NOT IN (".substr(@$mama,0,-1).") AND pincode>0 GROUP BY pincode ORDER BY pincode");
			while($RS1=mysql_fetch_assoc($SQL1)){
			?>
            <tr style="background:#FDEAE0;"><td style="background:#FDEAE0;"><strong><?=$RS1["pincode"];?></strong></td><td style="float:right"><?php $PT=mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE areawise_temp.pincode='".$RS1["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id "); $customer11=mysql_fetch_object($PT); echo " <span><span class=\"btn btn-primary\">PTR : ".round($customer11->PTR,2)."</span> <span class=\"btn btn-success\">PTS : ".round($customer11->PTS,2)."</span></span>"; ?></td></tr>
            <?php  $product=mysql_query("SELECT product.pro_name AS PNAME, product.id AS PID FROM areawise_temp,product WHERE areawise_temp.pincode='".$RS1["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id"); while($RS2=mysql_fetch_array($product)){ ?>
            <tr>
                <td colspan="2">
                	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                    	<tr>
                        	<td style="background:#FDEAE0;"><strong><?=$RS2["PNAME"]; ?></strong></td>
                            <td>
                            	 <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                 	<tr><th style="background:#FFE4B5;text-align:center;">CUSTOMER NAME</th><th style="background:#FFE4B5;text-align:center;">DISTRIBUTOR</th><th style="background:#FFE4B5;text-align:center;">QTY</th><th style="background:#FFE4B5;text-align:center;">FQTY</th><th style="background:#FFE4B5;text-align:center;">RQTY</th><th style="background:#FFE4B5;text-align:center;">PTR</th><th style="background:#FFE4B5;text-align:center;">PTS</th></tr>
                                    <?php $details = mysql_query("SELECT tbl_customer_master.shop_name AS SNAME,distributor.dis_name,SUM(areawise_temp.quantity) AS QTY,SUM(areawise_temp.free_quantity) AS FQTY,SUM(areawise_temp.replace_quantity) AS RQTY, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product,tbl_customer_master,distributor WHERE areawise_temp.our_product_id='".$RS2["PID"]."' AND areawise_temp.pincode='".$RS1["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND tbl_customer_master.id=areawise_temp.our_cust_id AND areawise_temp.our_product_id=product.id AND distributor.dis_id=areawise_temp.dist_id GROUP BY dist_id"); while($RS3=mysql_fetch_array($details)){ ?>
                                    <tr><td><?=$RS3["SNAME"]; ?></td><td><?=$RS3["dis_name"]; ?></td><td style="text-align:center"><?=$RS3["QTY"]; ?></td><td style="text-align:center"><?=$RS3["FQTY"]; ?></td><td style="text-align:center"><?=$RS3["RQTY"]; ?></td><td style="text-align:right"><?=round($RS3["PTR"],2); ?></td><td style="text-align:right"><?=round($RS3["PTS"],2); ?></td></tr>
                                    
                                    <?php } ?>
                                    
                                    <?php $details1 = mysql_query("SELECT SUM(areawise_temp.quantity) AS QTY,SUM(areawise_temp.free_quantity) AS FQTY,SUM(areawise_temp.replace_quantity) AS RQTY, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE areawise_temp.our_product_id='".$RS2["PID"]."' AND areawise_temp.pincode='".$RS1["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id"); $RS4=mysql_fetch_array($details1); ?>
                                    <tr><td  style="background:#BDFCC9;" colspan="2"><strong>Sub Total</strong></td><td style="background:#BDFCC9;text-align:center"><?=$RS4["QTY"]; ?></td><td style="background:#BDFCC9;text-align:center"><?=$RS4["FQTY"]; ?></td><td style="background:#BDFCC9;text-align:center"><?=$RS4["RQTY"]; ?></td><td style="background:#BDFCC9;text-align:right"><?=round($RS4["PTR"],2); ?></td><td style="background:#BDFCC9;text-align:right"><?=round($RS4["PTS"],2); ?></td></tr>
                                 </table>                           
                            </td>
                        </tr>
                    </table>                
                </td>
            </tr>
            <?php
			}					
				//$details = mysql_query("SELECT SUM()");
			}
		
		
		} ?>   
    
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
//}
?>