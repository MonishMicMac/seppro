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
<h2><i class="icon-user"></i>CUSTOMER NOT PURCHASED : </h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">


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
   <table class="table table-striped table-bordered bootstrap-datatable datatable" width="50%">   	
    <?php
       	
		$AMMA = mysql_query("SELECT areawise_temp.our_cust_id AS CID, tbl_customer_master.shop_name AS SNAME FROM areawise_temp,tbl_customer_master WHERE (areawise_temp.`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -2 month)))) AND our_cust_id NOT IN (SELECT our_cust_id FROM areawise_temp WHERE (`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -1 month)))) AND rep_id=1 GROUP BY our_cust_id) AND areawise_temp.rep_id = 1 AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_cust_id");       
        while($customer=mysql_fetch_object($AMMA)){ 
		$SQL=mysql_query("SELECT product.pro_name AS PNAME, SUM(quantity) AS Q, SUM(replace_quantity) AS R,SUM(free_quantity) AS F, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE (`bill_date` BETWEEN (select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day)) AND (select LAST_DAY(date_add(now(),interval -2 month)))) AND our_cust_id = '".$customer->CID."' AND rep_id=1 AND our_cust_id<>'' AND our_product_id<>'' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id HAVING  SUM(quantity) > 0");
				$CNT = mysql_num_rows($SQL);
				if($CNT>0){
    ?> 
    <tr>
    	<td style="background:#CC6600; color:#FFFFFF; font-weight:bold" width="30%"><?=strtoupper($customer->SNAME);?></td>
        <td>
        	<table class="table table-striped table-bordered bootstrap-datatable datatable">
            <tr><th width="25%" style=" border:1px solid #CCCCCC; background:#99FFFF;">PRODUCT</th><th width="10%" style="text-align:center; border:1px solid #CCCCCC; background:#99FFFF;">Q</th><th width="10%" style="text-align:center; border:1px solid #CCCCCC; background:#99FFFF;">F</th><th width="10%" style="text-align:center; border:1px solid #CCCCCC; background:#99FFFF;">R</th><th width="10%" style="text-align:right; border:1px solid #CCCCCC; background:#99FFFF;">PTR</th><th width="10%" style="text-align:right; border:1px solid #CCCCCC; background:#99FFFF;">PTS</th></tr>
        	<?php
				
				while($RS=mysql_fetch_object($SQL)){
			?>
            	<tr><td width="25%" style=" border:1px solid #CCCCCC"><?=$RS->PNAME; ?></td><td style="text-align:center; border:1px solid #CCCCCC"><?=$RS->Q; ?></td><td style="text-align:center; border:1px solid #CCCCCC"><?=$RS->F; ?></td><td style="text-align:center; border:1px solid #CCCCCC"><?=$RS->R; ?></td><td style="text-align:right; border:1px solid #CCCCCC"><?=round($RS->PTR,2); ?></td><td style="text-align:right; border:1px solid #CCCCCC"><?=round($RS->PTS,2); ?></td></tr>
            <?php } ?>
            </table> 
            <?php } ?>
        </td> 
        	   
               
    </tr>
    <?php
	 }		
	?>    
</table>
<?php } ?>
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