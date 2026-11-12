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
	source: "autosearch-y/pincode_search.php",
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
<h2><i class="icon-user"></i>Representative wise Offer Tracking
        <?php 
        if(@$_REQUEST["rep"]!=""){
        $b=mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND rep_id=".$_REQUEST["rep"]." AND our_cust_id!='' AND our_product_id!=''")or die(mysql_error()); $p = mysql_fetch_object($b); echo "<span style=\"padding-left:415px\"><span class=\"btn btn-primary\">PTR : ".round($p->PTR,2)."</span> <span class=\"btn btn-success\">PTS : ".round($p->PTS,2)."</span></span>"; } ?> </h2>
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
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
                <td></td>
            </tr>
             <tr align="right">
            	<td align="right" colspan="8" style="padding-right:80px;">
                
                <?php
                    if(@$_REQUEST["rep"]!=""){
                        $a=mysql_query("SELECT areawise_temp.pin_id,areawise_temp.pincode, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR FROM areawise_temp,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id=".$_REQUEST["rep"]." AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY areawise_temp.pincode")or die(mysql_error());
                        if(mysql_num_rows($a)){
                ?>
                    <a href="report_repwise_pincode_detailed_pdf_c.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo @$_REQUEST["rep"]; ?> " target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Export Excel"></a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="report_repwise_pincode_detailed_excecl.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep_id=<?php echo @$_REQUEST["rep"]; ?> " target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
                <?php }} ?>
                
                </td>
             </tr>
        </table>
    </form>
</div>
<div class="box-content">
    <?php 
        if(@$_REQUEST["submit"]=="REPORT"){
            $a=mysql_query("SELECT master_pincode.pin_id,master_pincode.pincode, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR FROM areawise_temp,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id=".$_REQUEST["rep"]." AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY master_pincode.pincode")or die(mysql_error());
            if(mysql_num_rows($a)){
    ?>
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <tr>
        <th>PINCODE</th>
        <th>CUSTOMER</th>
    </tr>
    <?php
        while($customer=mysql_fetch_object($a)){ 
    ?> 
    <tr>
    	<td style="width: 18%;text-align: center;">
    		<?php
    			echo "<strong style='font-size: 25px;'>".$customer->pincode."</strong><br><div style=\"margin-top:5px\" class=\"btn btn-primary\">PTR : ".round($customer->PTR,2)."</div><br><div style=\"margin-top:5px\" class=\"btn btn-success\">PTS : ".round($customer->PTS,2)."</div>";
    		?>
    	</td>
        <td>
        	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                <?php 
                $b=mysql_query("SELECT IFNULL((select doctor_name from doctors where id IN (select doctor_id from tbl_doctor_chemist where chemist_id=tbl_customer_master.id group by chemist_id)),'FLOATING') as doc_name, tbl_customer_master.id, tbl_customer_master.shop_name AS cust_name, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR  FROM areawise_temp,tbl_customer_master WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep"]."' AND areawise_temp.pin_id='".$customer->pin_id."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_cust_id ORDER BY areawise_temp.our_cust_id");
                while ($customer1=mysql_fetch_object($b)) {
                	$YQTY=0; $YFQTY=0; $YRQTY=0; $YPTR=0; $YPTS=0;  $texp=0;  $tqty=0;  $tfree=0;
                ?>

                <tr>
                    <td style="background:#FDEAE0;"><?php echo rtrim($customer1->cust_name,",");?></td>
                	<td style="background:#FDEAE0;"><?php echo rtrim($customer1->doc_name,",");?></td>
                	<td style="text-align:center;">
                		<table class="table table-striped table-bordered bootstrap-datatable datatable">
			            	<tr>
			            		<th style="background:#FFE4B5;text-align:center;">Product</th>
			            		<th style="background:#FFE4B5;text-align:center;">Batch</th>
			            		<th style="background:#FFE4B5;text-align:center;">Q</th>
                                <th style="background:#FFE4B5;text-align:center;">Q Split</th>
			            		<th style="background:#FFE4B5;text-align:center;">F</th>
			            		<th style="background:#FFE4B5;text-align:center;">R</th>
			            		<th style="background:#FFE4B5;text-align:center;">PTR</th>
			            		<th style="background:#FFE4B5;text-align:center;">PTS</th>
                                <th style="background:#FFE4B5;text-align:center;">BQ</th>
                                <th style="background:#FFE4B5;text-align:center;">BQf</th>
                                <th style="background:#FFE4B5;text-align:center;">Offer EXcess</th>
			            	</tr>
			                <?php 
			                $c=mysql_query("SELECT product.pro_name,product.id, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, SUM(quantity) AS QTY, IFNULL(SUM(free_quantity),0) AS FQTY, IFNULL(SUM(replace_quantity),0) AS RQTY, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep"]."' AND areawise_temp.pin_id='".$customer->pin_id."' AND areawise_temp.our_cust_id='".$customer1->id."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id ORDER BY areawise_temp.our_product_id");
			                while ($customer2=mysql_fetch_object($c)) {

			                ?>

			                <tr>
			                	<td style="text-align:left;"><?php echo $customer2->pro_name;?></td>
			                	<td style="text-align:center;"><?php echo $customer2->BATCH;?></td>
			                	<td style="text-align:center;"><?php echo $customer2->QTY; $YQTY=$YQTY+$customer2->QTY; ?></td>
                                <td style="text-align:left;">                                	
                                <?php
									$cy=mysql_query("SELECT CONCAT( '(', SUM( quantity ) , ') ', distributor.dis_name ) dname  FROM areawise_temp,product,distributor WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep"]."' AND areawise_temp.pin_id='".$customer->pin_id."' AND areawise_temp.our_cust_id='".$customer1->id."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_product_id='".$customer2->id."' AND areawise_temp.our_product_id=product.id and distributor.dis_id=areawise_temp.dist_id  GROUP BY dist_id ORDER BY areawise_temp.our_product_id");

									while($CHY=mysql_fetch_object($cy)){
                                      
								?> 
                                <p><?=$CHY->dname; ?> </p><?php } ?>
                                </td>
			                	<td style="text-align:center;"><?php echo $customer2->FQTY; $YFQTY=$YFQTY+$customer2->FQTY; ?></td>
			                	<td style="text-align:center;"><?php echo $customer2->RQTY; $YRQTY=$YRQTY+$customer2->RQTY; ?></td>
			                	<td style="text-align:right"><?php echo round($customer2->PTR,2); $YPTR=$YPTR+$customer2->PTR; ?></td>
			                	<td style="text-align:right"><?php echo round($customer2->PTS,2); $YPTS=$YPTS+$customer2->PTS; ?></td>
                                <?php      // $offerdate=date("Y/m/d",strtotime($F->S1)).'-';
                                        // echo "SELECT off_qty,off_free  FROM product_offer_tracking WHERE off_date like '%".$offerdate."%' off_doc_id='".$customer1->id."'  AND off_pdt_id='".$customer2->id."' AND off_rep_id='".$_REQUEST["rep"]."' ";
                                        $cyoffer=mysql_query("SELECT off_qty,off_free  FROM product_offer_tracking WHERE (off_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND off_doc_id='".$customer1->id."'  AND off_pdt_id='".$customer2->id."' AND off_rep_id='".$_REQUEST["rep"]."' AND off_id=(select max(off_id) from product_offer_tracking WHERE off_pdt_id='".$customer2->id."') ");
                                        $count_cyoffer=mysql_num_rows($cyoffer);
                                          if($count_cyoffer==0) {
                                // echo "SELECT gen_qty,gen_free  FROM product_offer_gemeral WHERE (gen_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')   AND gen_pdt_id='".$customer2->id."' AND gen_id=(select max(gen_id) from product_offer_gemeral WHERE gen_pdt_id='".$customer2->id."' ) ";
                                            $cyoffergen=mysql_query("SELECT gen_qty,gen_free  FROM product_offer_gemeral WHERE (gen_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')   AND gen_pdt_id='".$customer2->id."' AND gen_id=(select max(gen_id) from product_offer_gemeral WHERE gen_pdt_id='".$customer2->id."') ");
                                            $count_cyoffergen=mysql_num_rows($cyoffergen);
                                            if($count_cyoffergen==0) {
                                                ?>
                                                <td style="text-align:center;"><?php echo "0"; $tqty=$tqty+0; ?></td>
                                                    <td style="text-align:center;"><?php echo "0"; $tfree=$tfree+0;  ?></td>
                                                    <td style="text-align:right"><?php echo "0";  $texp=$texp+0; ?></td>
                                                    <?php

                                            }
                                            else
                                            {
                                                $CHY_cyoffergen=mysql_fetch_object($cyoffergen);
                                                    $bqty=$CHY_cyoffergen->gen_qty; $bfree=$CHY_cyoffergen->gen_free;
                                                    $cqty=$customer2->QTY; $cfree=$customer2->FQTY;
                                                    $bdiv=$cfree-($bfree*($cqty/$bqty));
                                                    // echo $cqty/$bqty.',';
                                                    //  echo $bfree.',';
                                                    //   echo $cfree.',';
                                                 $bdiv;
                                                 ?>
                                                  <td style="text-align:center;"><?php echo $CHY_cyoffergen->gen_qty; $tqty=$tqty+$CHY_cyoffergen->gen_qty; ?></td>
                                                    <td style="text-align:center;"><?php echo $CHY_cyoffergen->gen_free; $tfree=$tfree+$CHY_cyoffergen->gen_free;  ?></td>
                                                    <td style="text-align:right"><?php echo $bdiv;  $texp=$texp+$bdiv;  ?></td>
                                <?php
                                            }
                                          }
                                          else
                                          {
                                            $CHY_cyoffer=mysql_fetch_object($count_cyoffer);
                                                    $bqty=$CHY_cyoffer->off_qty; $bfree=$CHY_cyoffer->off_free;
                                                    $cqty=$customer2->QTY; $cfree=$customer2->FQTY;
                                                    $bdiv=$cfree-($bfree*($cqty/$bqty));
                                                    // echo $cqty/$bqty.',';
                                                    //  echo $bfree.',';
                                                    //   echo $cfree.',';
                                                 $bdiv;
                                                 ?>
                                                  <td style="text-align:center;"><?php echo $CHY_cyoffer->off_qty; $tqty=$tqty+$CHY_cyoffer->off_qty; ?></td>
                                                    <td style="text-align:center;"><?php echo $CHY_cyoffer->off_free; $tfree=$tfree+$CHY_cyoffer->off_free;  ?></td>
                                                    <td style="text-align:right"><?php echo $bdiv;  $texp=$texp+$bdiv;  ?></td>
                                                    <?php

                                          }  ?>
                               
			                </tr>
			                <?php } ?>

			                <tr>
			                	<td style="background:#BDFCC9;" colspan="2"><strong>Sub Total</strong></td>
			                	<td style="background:#BDFCC9;text-align:center" colspan="1" align="right"><strong><?php echo round($YQTY,2); ?></strong></td>
                                <td style="background:#BDFCC9;text-align:center" colspan="1" align="right"><strong><?php echo round($YQTY,2); ?></strong></td>
			                	<td style="background:#BDFCC9;text-align:center" align="right"><strong><?php echo round($YFQTY,2); ?></strong></td>
			                	<td style="background:#BDFCC9;text-align:center" align="right"><strong><?php echo round($YRQTY,2); ?></strong></td>
			                	<td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($YPTR,2); ?></strong></td>
			                	<!-- <td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($YPTS,2); ?></strong></td> -->
			                     <td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($YPTS,2); ?></strong></td>
                                 <td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($tqty,2); ?></strong></td>
                                <td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($tfree,2); ?></strong></td>
                                 <td style="background:#BDFCC9;text-align:right" colspan="1" align="right"><strong><?php echo round($texp,2); ?></strong></td>
                            </tr>

			            </table>
                	</td>
                </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
<?php } ?> 
</table>  
<?php }} ?>   
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
