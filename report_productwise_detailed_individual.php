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
		$a1 = mysql_query("SELECT SUM(quantity*ptr) AS TOTPTR, SUM(quantity*pts) AS TOTPTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `our_cust_id` <> '' AND `our_product_id` <> '' AND our_product_id = '".$SREEP->id."' AND rep_id>0 GROUP BY our_product_id");
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
<a href="report_productwise_detailed_individual_pdf.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&product_name=<?php echo @$_REQUEST["product_name"]; ?>" target="_blank"><img src="img/pdf.png" width="20" height="20" alt="Export PDF"></a>&nbsp;&nbsp;&nbsp;<a href="report_productwise_detailed_individual_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&product_name=<?php echo @$_REQUEST["product_name"]; ?>&m_id16=<?php echo $m_id16; ?> " target="_blank"><img src="img/excel.png" width="20" height="20" alt="Export Excel"></a>
<?php } ?>            
			</td>
            </tr>
</table>
</form>

<div id="yuvaraj">
<table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
	<tr><th width="15%">REP NAME</th><th width="1%">PINCODE</th></tr>
	<?php	
	if(@$_REQUEST["submit"]=="PRODUCT REPORT"){	
		$baba = mysql_query("SELECT id FROM product WHERE pro_name='".$_REQUEST["product_name"]."'"); $SREEP = mysql_fetch_object($baba); 
		$a=mysql_query("SELECT rep_id, SUM(quantity*ptr) AS PTR,SUM(quantity*pts) AS PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `our_cust_id` <> '' AND `our_product_id` <> '' AND `our_product_id` = '".$SREEP->id."' AND rep_id>0 GROUP BY rep_id");				
		while($YUVARAJ=mysql_fetch_object($a)){				
		?>
        	<tr>
            	<td width="15%">
					<?php
					$NPIN=mysql_query("SELECT COUNT(DISTINCT(areawise_temp.pin_id)) AS NPINCODE,COUNT(DISTINCT(areawise_temp.our_cust_id)) AS NCUST,COUNT(DISTINCT(areawise_temp.dist_id)) AS NDIST FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.`our_product_id` = '".$SREEP->id."' GROUP BY areawise_temp.rep_id");
					$NP=mysql_fetch_object($NPIN);
					$SQL=mysql_query("SELECT rep_name FROM representative WHERE id=".$YUVARAJ->rep_id.""); $R=mysql_fetch_object($SQL); echo "<strong>".strtoupper($R->rep_name)."</strong><div style=\"margin-top:5px\"><span class=\"btn btn-primary\">PTR : ".round($YUVARAJ->PTR,2)."</div><div  style=\"margin-top:5px\" class=\"btn btn-success\">PTS : ".round($YUVARAJ->PTS,2)."</div><div style='background:#e1881e;margin-top:8px;padding:5px;border-radius:8px;color:#FFFFFF;'><strong><div>Pincodes &nbsp;&nbsp;&nbsp;&nbsp;: ".$NP->NPINCODE."</div><div>Chemists &nbsp;&nbsp;&nbsp;&nbsp;: ".$NP->NCUST."</div><div>Distributors : ".$NP->NDIST."</div></strong></div>"; ?>
                    
                </td>
                <td width="85%">
                	<?php					
						$PIN=mysql_query("SELECT COUNT(DISTINCT(areawise_temp.our_cust_id)) AS NCUST,COUNT(DISTINCT(areawise_temp.dist_id)) AS NDIST,master_pincode.pincode AS PINCODE,master_pincode.pin_id AS pin_id  FROM areawise_temp,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.`our_product_id` = '".$SREEP->id."' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY areawise_temp.rep_id, areawise_temp.pin_id");
						while($P=mysql_fetch_object($PIN)){ 						
						$stockist=mysql_query("SELECT COUNT(DISTINCT(areawise_temp.dist_id)) AS NDIST FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.`our_product_id` = '".$SREEP->id."' AND areawise_temp.pin_id='".$P->pin_id."' GROUP BY areawise_temp.rep_id, areawise_temp.pin_id");
						$S=mysql_fetch_object($stockist);
						$AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='".$P->PINCODE."' ORDER BY id LIMIT 1");
						$A=mysql_fetch_object($AREA);
					?>                    
                    <table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
                    	<tr>
                        	<td width="15%" style="background:#e1881e;color:#FFFFFF; letter-spacing:0.08em;"><strong><?=$P->PINCODE."<div style='border-bottom:1px solid #FFFFFF;'>".$A->area_name."</div><div>Chemist : ".$P->NCUST."</div><div>Stockist : ".$S->NDIST."</div>"; ?></strong></td>
                            <td>
                            	<table class="table table-striped table-bordered bootstrap-datatable datatable"  id="hacker-list">
                                <tr><th width="15%" style="background:#73A839; color:#FFFFFF">CHEMIST</th><th width="15%" style="background:#73A839; color:#FFFFFF">BATCH</th><th width="15%" style="background:#73A839; color:#FFFFFF">DOCTOR</th><th width="15%" style="background:#73A839; color:#FFFFFF">STOCKIST</th><th width="5%" style="text-align:center;background:#73A839; color:#FFFFFF">Q</th><th width="5%" style="text-align:center;background:#73A839; color:#FFFFFF">F</th><th width="5%" style="text-align:center;background:#73A839; color:#FFFFFF">R</th><th width="10%" style="text-align:right;background:#73A839; color:#FFFFFF">PTR</th><th width="10%" style="text-align:right;background:#73A839; color:#FFFFFF">PTS</th></tr>                            	
								<?php								
                                    $R=mysql_query("SELECT tbl_customer_master.id AS id,GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH,tbl_customer_master.shop_name AS cust_name,distributor.dis_name AS DID, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.replace_quantity) AS R,SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR,SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS FROM areawise_temp,tbl_customer_master,distributor WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.`our_product_id` = '".$SREEP->id."' AND areawise_temp.pin_id=".$P->pin_id." AND tbl_customer_master.id=areawise_temp.`our_cust_id` AND distributor.dis_id=areawise_temp.dist_id GROUP BY areawise_temp.`our_cust_id`,dist_id");
                                    while($R1=mysql_fetch_object($R)){									
									$DOCTOR=mysql_query("SELECT doctors.doctor_name FROM  tbl_doctor_chemist,doctors WHERE tbl_doctor_chemist.chemist_id='".$R1->id."' AND tbl_doctor_chemist.doctor_id=doctors.id"); $D1=mysql_fetch_object($DOCTOR); 
                                ?>
                                	
                                	<tr>
                                        <td width="15%" style="border-top:1px solid #CCCCCC"><?=strtoupper($R1->cust_name); ?></td>
                                        <td width="15%" style="border-top:1px solid #CCCCCC"><?=strtoupper($R1->BATCH); ?></td>
                                        <td width="15%" style="border-top:1px solid #CCCCCC"><?php if($D1->doctor_name==""){ echo "Floating";} if($D1->doctor_name!=""){ echo strtoupper($D1->doctor_name);} ?></td>
                                        <td width="15%" style="border-top:1px solid #CCCCCC"><?=$R1->DID; ?></td>
                                        <td width="5%" style="text-align:center; border-top:1px solid #CCCCCC"><?=$R1->Q; ?></td>
                                        <td width="5%" style="text-align:center; border-top:1px solid #CCCCCC"><?=$R1->F; ?></td>
                                        <td width="5%" style="text-align:center; border-top:1px solid #CCCCCC"><?=$R1->R; ?></td>
                                        <td width="10%" style="text-align:right; border-top:1px solid #CCCCCC"><?=round($R1->PTR,2); ?></td>
                                        <td width="10%" style="text-align:right; border-top:1px solid #CCCCCC"><?=round($R1->PTS,2); ?></td>
                                 	</tr>                                                                                                        
                                <?php } ?>
                                <?php								
                                    $D=mysql_query("SELECT SUM(quantity) AS Q, SUM(free_quantity) AS F, SUM(replace_quantity) AS R,SUM(quantity*ptr) AS PTR,SUM(quantity*pts) AS PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `our_cust_id` <> '' AND `our_product_id` <> '' AND rep_id=".$YUVARAJ->rep_id." AND `our_product_id` = '".$SREEP->id."' AND pin_id=".$P->pin_id." GROUP BY `our_product_id`");
                                    $D1=mysql_fetch_object($D); 
                                ?>
                                	<tr style="background:#00CCFF">
                                    	<td colspan="4"  style="border-top:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF">SUB TOTAL</td>
                                        <td style="text-align:center;border-top:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF"><?=$D1->Q; ?></td>
                                        <td style="text-align:center;border-top:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF"><?=$D1->F; ?></td>
                                        <td style="text-align:center;border-top:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF"><?=$D1->R; ?></td>
                                        <td style="text-align:right;border-top:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF"><?=round($D1->PTR,2); ?></td>
                                        <td style="text-align:right;border-top:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF"><?=round($D1->PTS,2); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>
                </td>
            </tr>
		<?php } } ?>
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
