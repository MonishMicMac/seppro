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
<h2><i class="icon-user"></i>CUSTOMER PRODUCTWISE SALES OPTIMIZATION </h2>
<div class="box-icon">

</div>
</div>
<div class="box-content">
<form name="thisForm" action="" method="post">
	<table style="width:100%;">
        	<tr>
            	<td>Representative</td>
                <td>:</td>
                <td>
                	<input id="dd_user_input" type="text" name="rep" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["rep"]!=""){ ?>value="<?php echo @$_REQUEST["rep"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
                </td>
                <td><input type="submit" name="submit" value="REPRESENTATIVE REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
            </tr> 
        </table>
 </form>
        <?php 
			if(@$_REQUEST["submit"]=="REPRESENTATIVE REPORT"){
				$rep = explode("-",$_REQUEST["rep"]);	
				$rep_sqls=mysql_query("SELECT id FROM representative WHERE mobile = '".$rep[1]."' ");
				$r=mysql_fetch_object($rep_sqls);
		?>
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
   <tr>
        <th>CUSTOMER</th>
        <th>PRODUCT</th>
        <th style="text-align:center">
			<?php
				$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day) FirstDay");
				$R_MDATE=mysql_fetch_object($MDATE);
				echo date("F Y",strtotime($R_MDATE->FirstDay))." QTY";
			?>
        </th>
        <th style="text-align:center">
			<?php
				$MDATE1 = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay");
				$R_MDATE1=mysql_fetch_object($MDATE1);
				echo date("F Y",strtotime($R_MDATE1->FirstDay))." QTY";
			?>
        </th>
        <th style="text-align:center; background:#efe6da">DIFFERENCE</th>
        <th style="text-align:right; background:#CCCCFF">PTR</th>
    </tr>
   
    <?php       	
		$AMMA = mysql_query("SELECT areawise_temp.our_cust_id AS CID, tbl_customer_master.shop_name AS SNAME FROM areawise_temp,tbl_customer_master WHERE (areawise_temp.`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -2 month)))) AND our_cust_id IN (SELECT our_cust_id FROM areawise_temp WHERE (`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -1 month)))) AND rep_id=".$r->id." GROUP BY our_cust_id) AND areawise_temp.rep_id = ".$r->id." AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_cust_id");       
        while($customer=mysql_fetch_object($AMMA)){	
		$SQL=mysql_query("SELECT DISTINCT(areawise_temp.our_product_id) AS PID,tbl_customer_master.shop_name AS CNAME, tbl_customer_master.pincode AS PINCODE, product.pro_name AS PNAME FROM areawise_temp, product,tbl_customer_master  WHERE (areawise_temp.`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -2 month)))) AND our_product_id IN (SELECT our_product_id FROM areawise_temp WHERE (`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -1 month)))) AND our_cust_id = '".$customer->CID."' AND rep_id=".$r->id." GROUP BY our_product_id) AND areawise_temp.rep_id = ".$r->id." AND areawise_temp.our_product_id=product.id AND our_cust_id = '".$customer->CID."' AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_product_id, areawise_temp.our_cust_id  ORDER BY  areawise_temp.our_product_id");				
				while($RS=mysql_fetch_object($SQL)){
				?><?php				
				$F=mysql_query("SELECT SUM(quantity) AS FQTY FROM areawise_temp WHERE (areawise_temp.`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -2 month)))) AND our_product_id = '".$RS->PID."' AND our_cust_id='".$customer->CID."' GROUP BY our_product_id"); $FRS=mysql_fetch_object($F);
				$S=mysql_query("SELECT SUM(quantity) AS SQTY FROM areawise_temp WHERE (areawise_temp.`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -1 month)))) AND our_product_id = '".$RS->PID."' AND our_cust_id='".$customer->CID."' GROUP BY our_product_id"); $SRS=mysql_fetch_object($S);
				if($FRS->FQTY<0){$FRS->FQTY=0;}
				if($SRS->SQTY<0){$SRS->SQTY=0;}
				$DIFF = $FRS->FQTY-$SRS->SQTY;
				if($DIFF>0){				
    ?> 
    		
			<tr>
            	<td><?=strtoupper($RS->PNAME);?></td>
            	<td><?=strtoupper($RS->CNAME)."-".$RS->PINCODE;?></td>
                <td style="text-align:center"><?=$FRS->FQTY;?></td>                               
                <td style="text-align:center"><?php echo $SRS->SQTY;?></td>
                <td style="text-align:center; background:#efe6da"><?=$DIFF; ?></td>
                <td style="text-align:right; background:#CCCCFF"><?php $P=mysql_query("SELECT SUM($DIFF*product.ptr) AS PTR FROM areawise_temp,product WHERE areawise_temp.our_product_id = '".$RS->PID."' AND areawise_temp.our_cust_id='".$customer->CID."' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id"); $PT = mysql_fetch_object($P); echo round($PT->PTR,2); ?></td>
            </tr>
           
            <?php } } } ?>    
 </table>
 		<?php } ?>
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