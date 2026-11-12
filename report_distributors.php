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
function baba(yu){
	window.location.href="report_distributors.php?dist_sdate="+yu;
}
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
<h2><i class="icon-user"></i>Distributor Covered <span style="color:#FF0000;float:right;"> 
<?php ?></span></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
            	<td>MONTH &amp; YEAR</td>
                <td>:</td>
                <td>
                	<select  id="rep_sdate" name="rep_sdate" data-rel="chosen" onChange="baba(this.value);">
                        <option value="">--Select--</option>            
                         <?php					
                            for($i=5;$i>=1;$i--){	
                                $SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay ORDER BY LastDay DESC");
                                while($RS=mysql_fetch_object($SQL)){  
                                            
                        ?>
                        <option value="<?php echo date("Y/m/d",strtotime($RS->FirstDay))."&dist_edate=".date("Y/m/d",strtotime($RS->LastDay))."&cur=".date("M y",strtotime($RS->FirstDay)); ?>"><?php echo  date("M y",strtotime($RS->FirstDay)); ?></option>
                        <?php }} ?> 
                        </select><?php if(@$_REQUEST["dist_sdate"]!=""){ echo "&nbsp;&nbsp;&nbsp;".date("M y",strtotime(@$_REQUEST["dist_sdate"])); } ?>
                </td>
            </tr>            
           
        </table>
        
        <table style="width:100%;">
            
            <tr>
            	<td colspan="8" align="right" style="padding-right:89px">
                	<?php if(@$_REQUEST["dist_sdate"]!=""){ ?>
                        <a href="report_distributors_pdf.php?dist_sdate=<?php echo @$_REQUEST["dist_sdate"]; ?>&dist_edate=<?php echo @$_REQUEST["dist_edate"]; ?>&cur=<?php echo @$_REQUEST["cur"]; ?>" target="_blank"><img src="img/pdf.png" width="20" height="20" alt="Export PDF"></a>
                        <?php } ?>
                </td>           
            </tr>
        </table>
    </form>
</div>
<div class="box-content">
<?php if(@$_REQUEST["dist_sdate"]!=""){ ?>
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
   	<tr><th align="center" style="text-align:center">SL. NO</th><th align="center" style="text-align:center">DISTRIBUTOR</th><th align="center" style="text-align:center">PRODUCTS COVERED</th><th align="center" style="text-align:center">SQTY</th><th align="center" style="text-align:center">FQTY</th><th align="center" style="text-align:center">RQTY</th><th align="center" style="text-align:center">PTS</th><th align="center" style="text-align:center">PTR</th></tr>
    <?php
		
		$I=1;$TPTR="";$TPTS="";
		$SQL = mysql_query("SELECT dis_name, dis_id FROM distributor");
		while($RS=mysql_fetch_object($SQL)){
		$a=mysql_query("SELECT DISTINCT(areawise_temp.dist_id) AS DID,COUNT(DISTINCT(areawise_temp.our_product_id)) AS PROD, SUM(areawise_temp.quantity) AS Q,SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.replace_quantity) AS R,SUM(areawise_temp.quantity*areawise_temp.pts) AS TOTPTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS TOTPTR FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["dist_sdate"]."' AND '".@$_REQUEST["dist_edate"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id='".$RS->dis_id."' GROUP BY '".$RS->dis_id."'");
        while($customer=mysql_fetch_object($a)){ 
    ?> 
    <tr>
    	<td style="text-align:center;" align="center"><?=$I; ?></td>
        <td style="text-align:left;" align="center"><?php  echo $RS->dis_name; ?></td>
        <td style="text-align:center;background:#FDEAE0;" align="center"><a href="comparision_product_report.php?dist_id=<?=$RS->dis_id; ?>&from_date=<?=$_REQUEST["dist_sdate"]; ?>&to_date=<?=$_REQUEST["dist_edate"]; ?>&qty=<?=$customer->Q;?>" target="_blank" class="btn btn-info btn-setting"><?=$customer->PROD;?></a><div class="control-group" style="height:auto;" id="show_dis"></div></td> 
        <td style="text-align:center;background:#FDEAE0;" align="center"><?=$customer->Q;?></td>
        <td style="text-align:center;background:#FDEAE0;" align="center"><?=$customer->F;?></td>
        <td style="text-align:center;background:#FDEAE0;" align="center"><?=$customer->R;?></td>
        <td style="background:#FDEAE0;text-align:center;" align="center"><?=round($customer->TOTPTS,2);?></td>
        <td style="text-align:center;background:#FDEAE0;" align="center"><?=round($customer->TOTPTR,2);?></td>      
    </tr>
    <?php
     $TPTS+=round($customer->TOTPTS,2); $TPTR+=round($customer->TOTPTR,2);
	 $I++; }}		
	?>  
    <tr><td colspan="6" style="background:#99FFFF;"><strong>TOTAL</strong></td><td  style="background:#99FFFF;text-align:center;"><strong><?=$TPTS; ?></strong></td><td style="background:#99FFFF;text-align:center;"><strong><?=$TPTR; ?></strong></td></tr>  
</table>
<DIV>&nbsp;</DIV>
 
 <h2>Distributor Uncovered</h2>
 
 <table width="100%" cellpadding="5" cellspacing="7" style="border:1px solid #CCCCCC; border-collapse:collapse">
 	<tr><th align="center" style="border:1px solid #CCCCCC;text-align:center">SL. NO</th><th align="center" style="border:1px solid #CCCCCC;text-align:left">DISTRIBUTOR</th><th align="center" style="border:1px solid #CCCCCC;text-align:left">PRODUCTS COVERED</th><th align="center" style="border:1px solid #CCCCCC;text-align:center">SQTY</th><th align="center" style="border:1px solid #CCCCCC;text-align:center">FQTY</th><th align="center" style="border:1px solid #CCCCCC;text-align:center">RQTY</th><th align="center" style="border:1px solid #CCCCCC;text-align:center">PTS</th><th align="center" style="border:1px solid #CCCCCC;text-align:center">PTR</th></tr>
 	<?php $J=1; $UC=mysql_query("SELECT dis_name FROM distributor WHERE dis_id NOT IN (SELECT `dist_id` FROM `areawise_temp` WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["dist_sdate"]."' AND '".@$_REQUEST["dist_edate"]."') GROUP BY `dist_id`)"); while($ucustomer=mysql_fetch_object($UC)){  ?>
 	<tr style="border:1px solid #CCCCCC; border-collapse:collapse"><td style="border:1px solid #CCCCCC; text-align:center"><?=$J; ?></td><td style="border:1px solid #CCCCCC; "><?=$ucustomer->dis_name; ?></td><td style="border:1px solid #CCCCCC; text-align:center">0</td><td style="border:1px solid #CCCCCC; text-align:center">0</td><td style="border:1px solid #CCCCCC; text-align:center">0</td><td style="border:1px solid #CCCCCC; text-align:center">0</td><td style="border:1px solid #CCCCCC; text-align:center">0</td><td style="border:1px solid #CCCCCC; text-align:center">0</td></tr>
    <?php $J++;} ?>
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