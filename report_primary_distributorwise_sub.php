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
$('#from_date').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: '1980:' + new Date().getFullYear(),
        beforeShow: function(el, dp) { 
            $('#ui-datepicker-div').addClass('hide-calendar');
        },
        onClose: function(dateText, inst) { 
            $('#ui-datepicker-div').removeClass('hide-calendar');
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });



//ajax Ends
});
</script>
<style>
 .ui-datepicker-calendar {
      display: none;
 }
 .ui-widget-content {
      width: 250px!important;
  }
</style>
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
<h2>
  <i class="icon-user"></i>
  <?php $P=mysql_query("SELECT dis_name FROM distributor where dis_id='".$_REQUEST["dist_id"]."'"); while($I=mysql_fetch_object($P)){ ?>
                           <?php echo $I->dis_name; ?> 
                        <?php } ?>

</h2>
           <div class="controls" style="clear:0 both;float:right;margin-top: 4px">
                  <div class="control-group">          
                <input type="button" name="button" value="Close" class="btn btn-primary" style="margin-top:-5px" onclick="window.close()">
                </div>
            </div>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
        <table style="width:100%;">
             <tr align="right">
                <td align="right" colspan="8" style="padding-right:80px;">
                
                <?php




if(@$_REQUEST["division_id"]!=""){
    $division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
} else {
    if($_SESSION["division_id"]!="ALL")
        $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
    else 
        $division_default = "";
}




                       $a=mysql_query("select a.id from primary_sales a left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where 1 and a.bill_string='".$_REQUEST["from_date"]."' ".$division_default." and `distributor_id` = '".@$_REQUEST["dist_id"]."' and c.our_id !=0 GROUP BY d.id")or die(mysql_error());


                       
                        if(mysql_num_rows($a)){
                ?>
                    <a href="report_primary_distributorwise_sub_pdf.php?division_id=<?php echo @$_REQUEST["division_id"]; ?>&from_date=<?php echo @$_REQUEST["from_date"]; ?>&distributor=<?php echo @$_REQUEST["dist_id"]; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Download PDF"></a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="report_primary_distributorwise_sub_excel.php?division_id=<?php echo @$_REQUEST["division_id"]; ?>&from_date=<?php echo @$_REQUEST["from_date"]; ?>&distributor=<?php echo @$_REQUEST["dist_id"]; ?>" target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
                <?php }
                 ?>
                
                </td>
             </tr>
        </table>
  
</div>
<div class="box-content">
    <?php 
     




   $a=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,d.pro_mrp,d.pts,d.ptr,f.product_id,d.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*d.ptr) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*d.ptr) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*d.ptr) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where a.bill_string='".@$_REQUEST["from_date"]."' ".$division_default." and `distributor_id` = '".@$_REQUEST["dist_id"]."' and c.our_id !=0 GROUP BY d.id")or die(mysql_error());




            if(mysql_num_rows($a)){
    ?>
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <tr>
        <th>Product Name</th>
        <!-- <th>PTR</th>
        <th>PTS</th>
        <th>MRP</th> -->
        <th>Opening Stock Qty</th>
        <th>Opening Stock Value</th>
        <th>Purchase Qty</th>
        <th>Purchase Value</th>
        <th>Sale Qty</th>
        <th>Sale Value</th>
        <th>Closing Stock Qty</th>
        <th>Closing Stock Value</th>
    </tr>
    <?php


$opening_stock_qty_total = 0.00;
$opening_stock_total = 0.00;
$purchase_qty_total = 0.00;
$purchase_total = 0.00;
$sale_qty_total = 0.00;
$sale_total = 0.00;
$closing_stock_qty_total = 0.00;
$closing_stock_total = 0.00;


    while($customer=mysql_fetch_array($a)){
        if(round($customer["openqty"],2)!=0 || round($customer["purqty"],2)!=0 || round($customer["saleqty"],2)!=0 || round($customer["closeqty"],2)!=0) {
    ?> 

    <tr>
        <td style="width: 18%;text-align: center;">
            <?= ($customer["pronamepro"]!='')?$customer["pronamepro"]:'-' ?>
        </td>
        <!-- <td style="width: 18%;text-align: center;">
            <? // ($customer["ptr"]!='')?$customer["ptr"]:'-' ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <? // ($customer["pts"]!='')?$customer["pts"]:'-' ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <? // ($customer["pro_mrp"]!='')?$customer["pro_mrp"]:'-' ?>
        </td> -->
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["openqty"]!='')?round($customer["openqty"],2):'0';
            $opening_stock_qty_total += $customer["openqty"];
             ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["opening_stock"]!='')?number_format($customer["opening_stock"],2):'0.00';
            $opening_stock_total += $customer["opening_stock"];
             ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["purqty"]!='')?round($customer["purqty"],2):'0';
            $purchase_qty_total += $customer["purqty"];
             ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["purchase"]!='')?number_format($customer["purchase"],2):'0.00';
            $purchase_total += $customer["purchase"];
             ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["saleqty"]!='')?round($customer["saleqty"],2):'0';
            $sale_qty_total += $customer["saleqty"];
             ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["sale"]!='')?number_format($customer["sale"],2):'0.00';
            $sale_total += $customer["sale"];
             ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["closeqty"]!='')?round($customer["closeqty"],2):'0';
            $closing_stock_qty_total += $customer["closeqty"];
             ?>
        </td>
        <td style="width: 18%;text-align: center;">
            <?php echo ($customer["closing_stock"]!='')?number_format($customer["closing_stock"],2):'0.00';
            $closing_stock_total += $customer["closing_stock"];
             ?>
        </td>
    </tr>

<?php } 
} ?>



    <tr>
        <td style="width: 18%;text-align: center;">
            Total
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo round($opening_stock_qty_total,2);
             ?></span>
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo number_format($opening_stock_total,2);
             ?></span>
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo round($purchase_qty_total,2);
             ?></span>
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo number_format($purchase_total,2);
             ?></span>
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo round($sale_qty_total,2);
             ?></span>
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo number_format($sale_total,2);
             ?></span>
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo round($closing_stock_qty_total,2);
             ?></span>
        </td>
        <td style="width: 18%;text-align: center;">
            <span class="btn btn-success"><?php echo number_format($closing_stock_total,2);
             ?></span>
        </td>
    </tr>


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
