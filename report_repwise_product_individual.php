<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
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

<div id="content" class="span10">

<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Representative (INDIVIDUAL) wise Report <span style="color:#FF0000;margin-left:200px;"> 
<?php 
	if(@$_REQUEST["submit"]=="REPRESENTATIVE REPORT"){
			
			$SQL = mysql_query("SELECT SUM(quantity*ptr) AS PTR, SUM(quantity*pts) AS PTS FROM areawise_temp WHERE rep_id = ".$_REQUEST["rep"]." AND our_cust_id<>'' AND our_product_id<>'' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')")or die(mysql_error());
			$R = mysql_fetch_object($SQL);
			 echo "<span style=\"padding-left:0px\"><span class=\"btn btn-primary\">PTR Value: ".round($R->PTR,2)."</span> <span class=\"btn btn-success\">PTS Value: ".round($R->PTS,2);
	}
?></span></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
            	<td>Representative</td>
                <td>:</td>
                <td>
                    <select name="rep" id="rep" data-rel="chosen" required>
                        <option value="">---Select---</option>
                        <?php $P=mysql_query("SELECT * FROM representative ORDER BY id"); while($I=mysql_fetch_object($P)){ ?>
                            <option value="<?=$I->id; ?>"><?=$I->rep_name; ?></option>
                        <?php } ?>
                    </select><script>document.getElementById("rep").value="<?=$_REQUEST["rep"] ?>";</script>
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
                <td><input type="submit" name="submit" value="REPRESENTATIVE REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
            <?php  if(@$_REQUEST["submit"]=="REPRESENTATIVE REPORT"){ ?>
            <tr><td colspan="8" style="padding-left:740px;"><a href="report_repwise_product_individual_pdf.php?rep=<?=$_REQUEST["rep"]; ?>&from_date=<?=$_REQUEST["from_date"]; ?>&to_date=<?=$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/pdf.png" width="24" height="24"></a>&nbsp;&nbsp;<a href="report_repwise_product_individual_excel.php?rep=<?=$_REQUEST["rep"]; ?>&from_date=<?=$_REQUEST["from_date"]; ?>&to_date=<?=$_REQUEST["to_date"]; ?>"><img src="img/excel.png" width="24" height="24"></a></td></tr>
            <?php } ?>
        </table>
    </form>
</div>
<div class="box-content">
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <?php
		//echo "SELECT pincode,pro_name FROM areawise_temp WHERE Pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM rep_area WHERE rep_id = 1) GROUP BY PINCODE) GROUP BY pincode";	
        if(@$_REQUEST["submit"]=="REPRESENTATIVE REPORT"){
			
			$areatotal=0; $PINTOT = 0;
			
					
        $a=mysql_query("SELECT product.pro_name AS PNAME, areawise_temp.our_product_id AS PID, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS FROM areawise_temp, product WHERE areawise_temp.rep_id = ".$_REQUEST["rep"]." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND product.id=areawise_temp.our_product_id GROUP BY areawise_temp.our_product_id ORDER BY product.pro_name")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){ 
    ?> 
    <tr style="background:#FDEAE0;">
    	<td style="background:#FDEAE0;" align="right"><?=$customer->PNAME;?></td><td style="background:#FDEAE0;float:right;clear:0 both;" align="right"><?php   echo "<span style=\"padding-left:0px\"><span class=\"btn btn-primary\">PTR Value: ".round($customer->PTR,2)."</span> <span class=\"btn btn-success\">PTS Value: ".round($customer->PTS,2)."</span></span>"; ?></td>
    </tr>
    <?php
		$pin = mysql_query("SELECT areawise_temp.pin_id AS PIN, master_pincode.pincode AS pincode FROM areawise_temp,master_pincode WHERE areawise_temp.rep_id = ".$_REQUEST["rep"]." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$customer->PID."' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY areawise_temp.pin_id");
		while($REP_PIN=mysql_fetch_object($pin)){ 
	?>
    <tr> <!-- PINCODE -->
    	<td colspan="2">
        	<table width="100%" style="border:1px solid #CCCCCC">
            	<tr>
            		<td style="background:#FDEAE0;" width="10%">
						<strong><?php echo $REP_PIN->pincode; $AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$REP_PIN->pincode."' GROUP BY '".$REP_PIN->pincode."'"); $AREA_NAME=mysql_fetch_object($AREA); echo " - ".$AREA_NAME->area_name; ?></strong>
                    </td>
                    
                    <td width="90%">
                    <table width="100%" style="border:1px solid #CCCCCC">
                    <tr><th width="35%">CUSTOMER NAME</th><th width="35%">BATCH</th><th width="30%" style="text-align:left">DISTRIBUTOR</th><th width="5%" style="text-align:center">QTY</th><th style="text-align:center" width="5%">RQTY</th><th style="text-align:center" width="5%">FQTY</th><th style="text-align:right" width="5%">PTR</th><th style="text-align:right" width="6%">PTS</th></tr>
                    	<?php							
							$TQ=""; $TF=""; $TR=""; $TPTR=""; $TPTS="";
							$CUST = mysql_query("SELECT tbl_customer_master.shop_name AS CNAME, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, areawise_temp.our_cust_id AS CID, (SELECT dis_name FROM distributor WHERE dis_id=areawise_temp.dist_id) AS DID,  areawise_temp.pincode as PIN, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.replace_quantity) AS R, SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.quantity*areawise_temp.ptr) AS CPTR, SUM(areawise_temp.quantity*areawise_temp.pts) AS CPTS FROM areawise_temp,product,tbl_customer_master WHERE areawise_temp.rep_id = ".$_REQUEST["rep"]." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$customer->PID."' AND areawise_temp.pin_id='".$REP_PIN->PIN."' AND product.id='".$customer->PID."' AND tbl_customer_master.id=areawise_temp.our_cust_id GROUP BY our_cust_id");
							while($CUST_R=mysql_fetch_object($CUST)){ $TQ+=$CUST_R->Q; $TF+=$CUST_R->F; $TR+=$CUST_R->R; $TPTR+=round($CUST_R->CPTR,2); $TPTS+=round($CUST_R->CPTS,2);
						?>
                        
                        	<tr style="border:1px solid #CCCCCC">
                            	<td width="35%"><?=strtoupper($CUST_R->CNAME); ?></td><td width="35%"><?=strtoupper($CUST_R->BATCH); ?></td><td width="30%"><?=strtoupper($CUST_R->DID); ?></td><td  width="5%" style="text-align:center"><?=$CUST_R->Q; ?></td><td style="text-align:center"  width="5%"><?=$CUST_R->R; ?></td><td style="text-align:center"  width="5%"><?=$CUST_R->F; ?></td><td style="text-align:right"  width="5%"><?=round($CUST_R->CPTR,2); ?></td><td style="text-align:right"  width="6%"><?=round($CUST_R->CPTS,2); ?></td>
                            </tr>
                        
                        <?php } ?>
                        <tr style="font-weight:bold">
                        	<td style="background:#BDFCC9;"  width="65%" colspan="3"><?php echo "SUB TOTAL"; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$TQ; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$TR; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$TF; ?></td><td style="background:#BDFCC9;text-align:right"  width="5%"><?=$TPTR; ?></td><td style="background:#BDFCC9;text-align:right"  width="6%"><?=$TPTS; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                </table>
         </td>        
    </tr> <!-- PINCODE -->
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
