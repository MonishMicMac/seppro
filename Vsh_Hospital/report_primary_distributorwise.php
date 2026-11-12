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
  <i class="icon-user"></i>Statewise Distributor Report 

</h2>
           <div class="controls" style="float:right;">
           <table ><tr>
          
          <td style="vertical-align: top"><span class="btn btn-success" style="height: 16px">Closing Value <?php


                    if(@$_REQUEST["from_date"]!=""){
                        $bill_default = "and a.bill_string='".$_REQUEST["from_date"]."'";
                        $bill_url = "&from_date=".$_REQUEST["from_date"];

                        echo ":";

                    } else {
                        $SQL = mysql_query("SELECT bill_string FROM `primary_sales` order by str_to_date(concat(\"01\",LEFT(SUBSTRING_INDEX( SUBSTRING_INDEX( bill_string,  ' ', 1 ) ,  ' ', -1 ),3),TRIM( SUBSTR(  bill_string, LOCATE(  ' ',  bill_string ) ) )),\"%d%b%Y\") desc limit 1");
                        while ($customer21=mysql_fetch_array($SQL)) {
                            $bill_default1=$customer21["bill_string"];
                            $bill_default="and a.bill_string='".$customer21["bill_string"]."'";
                            $bill_url="&from_date=".$customer21["bill_string"];
                        }

                        echo " for ".$bill_default1." :";
                    }

                    if(@$_REQUEST["division_id"]!=""){
                        $division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
                    } else {
                        if($_SESSION["division_id"]!="ALL")
                            $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
                        else 
                            $division_default = "";
                    }

                

                    if(@$_REQUEST["state"]) {
                        $state_check = "and b.state_id='".(@$_REQUEST["state"])."'";
                        $state_url = "&state_id=".(@$_REQUEST["state"]);
                    } else {

                        if($_SESSION["state_id"]!="ALL") {
                            $state_check = " and b.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
                        } else {
                            $state_check = "";
                        }

                        $state_url = "";
                    }


                        $a=mysql_query("select FORMAT(sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts),2) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$state_check." ".$division_default."  AND c.our_id!=''" )or die(mysql_error());



							 
                        if(mysql_num_rows($a)){
                          while($csvalue=mysql_fetch_array($a)) {
                            echo (@($csvalue["closing_stock"])?$csvalue["closing_stock"]:'0');

                          }
                        } else {
                          echo '0';
                        }
              ?></span></td>
          
          <td style="vertical-align: top"> <div class="control-group">          
                <select name="state_id" id="state_id"  onChange="state(this.value);" data-rel="chosen">
                    <option value=""><?php echo (($_SESSION["state_id"]=="ALL")?"PAN India":"All") ?></option>
                <?php $SQL = mysql_query("SELECT * FROM master_state".(($_SESSION["state_id"]!="ALL")?(" where state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')"):"")." order by state_name"); while($STATE=mysql_fetch_object($SQL)){ ?>              
                    <option value="<?php echo $STATE->state_id; ?>"><?php echo $STATE->state_name; ?></option>
                    <?php } ?>
                </select>
                <script>document.getElementById("state_id").value="<?php echo (@$_REQUEST["state"]); ?>";</script>
              </div>
          </td>
           
          </tr>
          </table>
            </div>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" id="searchForm" action="" method="post">


        
        <table style="width:100%;">
            <tr>
                
                <td>Division</td>
                <td>:</td>
                <td>
                    <select name="division_id" id="division_id" data-rel="chosen" >
                        <option value="">---Select---</option>
                        <?php $P=mysql_query("SELECT * FROM mst_division".(($_SESSION["division_id"]!="ALL")?(" where division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')"):"")." ORDER BY division_id"); while($I=mysql_fetch_object($P)){ ?>
                            <option value="<?=$I->division_id; ?>"><?=$I->division_name; ?></option>
                        <?php } ?>
                    </select><script>document.getElementById("division_id").value="<?=$_REQUEST["division_id"] ?>";</script>
                </td>
                <td><Label>Month &amp; Year</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo ((@$_REQUEST["from_date"])?$_REQUEST["from_date"]:''); ?>"  /></td>
                <td><input type="submit" name="button" value="REPORT" class="btn btn-primary" style="margin-top:-12px">

                <!-- <input type="button" name="button" value="REPORT" class="btn btn-primary" style="margin-top:-12px" onclick="search_submit()"> -->

                </td>
                <td></td>
            </tr>


            <tr>
                
                <td colspan="8" id="error_append_search" style="color: #ce3737;text-align: center"></td>
            </tr>
             <tr align="right">
                <td align="right" colspan="8" style="padding-right:80px;">
                
                <?php



                        $a=mysql_query("select a.id from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$state_check." ".$division_default."  AND c.our_id!='' group by a.distributor_id")or die(mysql_error());



                        if(mysql_num_rows($a)){
                ?>
                    <a href="report_primary_distributorwise_pdf.php?division_id=<?php echo @$_REQUEST["division_id"]; ?><?php echo $bill_url; echo $state_url; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Download PDF"></a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="report_primary_distributorwise_excel.php?division_id=<?php echo @$_REQUEST["division_id"]; ?><?php echo $bill_url; echo $state_url; ?>" target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
                <?php }
                ?>
                
                </td>
             </tr>
        </table>
    </form>
</div>
<div class="box-content">
    <?php 

            $a=mysql_query("select b.dis_name as distributor_name,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$state_check." ".$division_default." AND c.our_id!='' group by a.distributor_id")or die(mysql_error());

          

            if(mysql_num_rows($a)){
          
    ?>
   <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <tr>
        <th>Distributor</th>
        <th>Opening Qty</th>
        <th>Opening Stock Value</th>
        <th>Purchase Qty</th>
        <th>Purchase Value</th>
        <th>Sale Qty</th>
        <th>Sale Value</th>
        <th>Closing Qty</th>
        <th>Closing Stock Value</th>
    </tr>
    <?php
    $opening_stock_total = 0.00;
    $purchase_total = 0.00;
    $sale_total = 0.00;
    $closing_stock_total = 0.00;
    $openqty= 0.00;
    $purqty= 0.00;
    $saleqty= 0.00;
    $closeqty= 0.00;

        while($customer=mysql_fetch_array($a)){
            if(round($customer["openqty"],2)!==0 || round($customer["purqty"],2)!==0 || round($customer["saleqty"],2)!==0 || round($customer["closeqty"],2)!==0) {
    ?> 
    <tr >
        <td style="width: 18%;text-align: center;">
        <a href="report_primary_distributorwise_sub.php?division_id=<?php echo @$_REQUEST["division_id"]; ?><?php echo $bill_url ?>&dist_id=<?php echo $customer["distID"]; ?>" target="_blank">
            <?php echo ($customer["distributor_name"]!='')?$customer["distributor_name"]:'-' ?>
            </a>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["openqty"]!=''){ $openqty+=$customer["openqty"]; echo round($customer["openqty"],2); } else { echo '0.00'; } ?>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["opening_stock"]!=''){ $opening_stock_total+=$customer["opening_stock"]; echo number_format($customer["opening_stock"],2); } else { echo '0.00'; } ?>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["purqty"]!=''){ $purqty+=$customer["purqty"]; echo round($customer["purqty"],2); } else { echo '0.00'; } ?>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["purchase"]!=''){ $purchase_total+=$customer["purchase"]; echo number_format($customer["purchase"],2); } else { echo '0.00'; } ?>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["saleqty"]!=''){ $saleqty+=$customer["saleqty"]; echo round($customer["saleqty"],2); } else { echo '0.00'; } ?>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["sale"]!=''){ $sale_total+=$customer["sale"]; echo number_format($customer["sale"],2); } else { echo '0.00'; } ?>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["closeqty"]!=''){ $closeqty+=$customer["closeqty"]; echo round($customer["closeqty"],2); } else { echo '0.00'; } ?>
        </td>

        <td style="width: 18%;text-align: center;">
            <?php if($customer["closing_stock"]!=''){ $closing_stock_total+=$customer["closing_stock"]; echo number_format($customer["closing_stock"],2); } else { echo '0.00'; } ?>
        </td>
        </tr>
        <?php }
        } ?>
        <tr>
            <td style="width: 18%;text-align: center;">Total</td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo round($openqty,2); ?></span></td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo number_format($opening_stock_total,2); ?></span></td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo round($purqty,2); ?></span></td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo number_format($purchase_total,2); ?></span></td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo round($saleqty,2); ?></span></td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo number_format($sale_total,2); ?></span></td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo round($closeqty,2); ?></span></td>
            <td style="width: 18%;text-align: center;"><span class="btn btn-success"><?php echo number_format($closing_stock_total,2); ?></span></td>
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

function state(state){
  if(state)
    document.location = "report_primary_distributorwise.php?state="+state;
  else
    document.location = "report_primary_distributorwise.php";
}

/*function search_submit(){
  if($('#division_id').val()!='' && $('#from_date').val()!='')
    $("#searchForm").submit()
  else {
    $("#error_append_search").html("Division and Month required!")
    return false
  }

}*/
</script>
</body>
</html>
<?php
}
?>
