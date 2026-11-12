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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"> 
	$(function() {
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/individual_product.php",
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
<?php /*?><a href="report_productwise_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Export PDF"></a><?php */?>
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Individidual Product wise <?php if(@$_REQUEST["submit"]=="PRODUCT REPORT"){ ?>[<?php echo @$_REQUEST["product_name"]; ?>] <?php } ?> - Report <?php if(@$_REQUEST["submit"]=="PRODUCT REPORT"){	
		$baba = mysql_query("SELECT id FROM product WHERE pro_name='".$_REQUEST["product_name"]."'"); $SREEP = mysql_fetch_object($baba); 
		
		$a1=mysql_query("SELECT SUM(areawise_temp.quantity) AS SQTY, SUM(areawise_temp.free_quantity) AS SFQTY, SUM(areawise_temp.replace_quantity) AS SRQTY,SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id GROUP BY areawise_temp.our_product_id");
		$customer11=mysql_fetch_object($a1); echo " <span style=\"padding-left:320px\"><span class=\"btn btn-primary\">PTR : ".round($customer11->TOTPTR,2)."</span> <span class=\"btn btn-success\">PTS : ".round($customer11->TOTPTS,2)."</span></span>"; } ?></h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<ul  class="list" style="list-style-type:none;">
<li>
<form name="thisForm" action="" method="post">
<table style="width:100%;">
        	<tr>
            	<td>Product</td>
                <td>:</td>
                <td>
                	<input id="dd_user_input" type="text" name="product_name" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["product_name"]!=""){ ?>value="<?php echo @$_REQUEST["product_name"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
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
        <td><input type="submit" name="submit" value="PRODUCT REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
    </tr>
    <tr>
            <td colspan="8" align="right" style="padding-right:89px">
            	<?php if(@$_REQUEST["submit"]=="PRODUCT REPORT"){ ?>
<a href="report_productwise_individual_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&product_name=<?php echo @$_REQUEST["product_name"]; ?>&m_id16=<?php echo $m_id16; ?> " target="_blank"><img src="img/pdf.png" width="20" height="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_productwise_individual_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&product_name=<?php echo @$_REQUEST["product_name"]; ?>&m_id16=<?php echo $m_id16; ?> " target="_blank"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>
<?php } ?>            
			</td>
            </tr>
</table>
</form>

<div id="yuvaraj">
<table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">

	<?php	
	if(@$_REQUEST["submit"]=="PRODUCT REPORT"){	
		$baba = mysql_query("SELECT id FROM product WHERE pro_name='".$_REQUEST["product_name"]."'"); $SREEP = mysql_fetch_object($baba); 	
			
		$a=mysql_query("SELECT  count(DISTINCT(areawise_temp.pin_id)) AS PIN,count(DISTINCT(areawise_temp.our_cust_id)) AS CUST, areawise_temp.rep_id AS RNAME,  areawise_temp.rep_id AS RID, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY,SUM(areawise_temp.quantity*product.ptr) AS YPTR, SUM(areawise_temp.quantity*product.pts) AS YPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id AND areawise_temp.rep_id>0 GROUP BY areawise_temp.our_product_id, areawise_temp.rep_id");	
		echo mysql_error();	
		?>
        <tr><th style="text-align:center">Rep Name</th><th style="text-align:center">No of Pincodes Covered</th><th style="text-align:center">No of Customers Covered</th><th style="text-align:center">QTY</th><th style="text-align:center">RQTY</th><th style="text-align:center">FQTY</th><th style="text-align:center">PTR</th><th style="text-align:center">PTS</th></tr>
        <?php
		while($YUVARAJ=mysql_fetch_object($a)){	
			
		$SQL = mysql_query("SELECT rep_name FROM representative WHERE id='".$YUVARAJ->RNAME."'");
		$RS = mysql_fetch_object($SQL);
	?>
			
		
        <tr><td><?php echo $RS->rep_name; ?></td><td align="center" style="text-align:center"><?=$YUVARAJ->PIN; ?></td><td align="center" style="text-align:center"><?=$YUVARAJ->CUST; ?></td><td style="text-align:center"><?=$YUVARAJ->QTY; ?></td><td style="text-align:center"><?=$YUVARAJ->RQTY; ?></td><td style="text-align:center"><?=$YUVARAJ->FQTY; ?></td><td  style="text-align:right"><?php echo round($YUVARAJ->YPTR,2); ?></td><td style="text-align:right"><?php echo round($YUVARAJ->YPTS,2); ?></td></tr>
		<?php
		}//}
         $a1=mysql_query("SELECT  count(DISTINCT(areawise_temp.pin_id)) AS PIN,count(DISTINCT(areawise_temp.our_cust_id)) AS CUST, areawise_temp.rep_id AS RNAME,  areawise_temp.rep_id AS RID, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY,SUM(areawise_temp.quantity*product.ptr) AS YPTR, SUM(areawise_temp.quantity*product.pts) AS YPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id AND areawise_temp.rep_id=0 GROUP BY areawise_temp.our_product_id");$YUVI=mysql_fetch_object($a1);
		?>
                <tr><td>Vacant / Unassigned</td><td align="center" style="text-align:center"><?=$YUVI->PIN; ?></td><td align="center" style="text-align:center"><?=$YUVI->CUST; ?></td><td style="text-align:center"><?=$YUVI->QTY; ?></td><td style="text-align:center"><?=$YUVI->RQTY; ?></td><td style="text-align:center"><?=$YUVI->FQTY; ?></td><td  style="text-align:right"><?php echo round($YUVI->YPTR,2); ?></td><td style="text-align:right"><?php echo round($YUVI->YPTS,2); ?></td></tr>

        <tr><td colspan="3"><?php echo "<strong>TOTAL</strong>"; ?></td><td style="text-align:center"><?=$customer11->SQTY; ?></td><td style="text-align:center"><?=$customer11->SRQTY; ?></td><td style="text-align:center"><?=$customer11->SFQTY; ?></td><td  style="text-align:right"><?=round($customer11->TOTPTR,2); ?></td><td style="text-align:right"><?=round($customer11->TOTPTS,2); ?></td></tr>
        <?php
		 } ?>    

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
