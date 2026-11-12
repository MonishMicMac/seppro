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

                              <td style="vertical-align: top"><span class="btn btn-success" style="height: 16px">Closing Stock Value : <?php

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


                            // if($_SESSION["state_id"]!="ALL") {
                            //     $state_check = " and b.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
                            // } else {
                            //     $state_check = " ";
                            // }
                              if(@$_REQUEST["st_id"]) {
                                $state_check = "and b.state_id='".(@$_REQUEST["st_id"])."'";
                                $state_url = "&state_id=".(@$_REQUEST["st_id"]);
                            } else {

                                if($_SESSION["state_id"]!="ALL") {
                                    $state_check = " and b.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
                                } else {
                                    $state_check = "";
                                }

                                $state_url = "";
                            }



                            if(@$_REQUEST["product_id"]!=""){
                                $pdt_default = "and c.our_id='".@$_REQUEST["product_id"]."'";
                                $pdt_url="&product_id=".$_REQUEST["product_id"];
                            } else {
                                $pdt_default = "and c.our_id!=''";
                                $pdt_group= "GROUP BY d.id"; 
                                $pdt_url="";
                            }


                            // if((@$_REQUEST["division_id"]!="")&&(@$_REQUEST["from_date"]!="")){

                            //     $a=mysql_query("select sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".@$_REQUEST["from_date"]."' and a.division_id='".@$_REQUEST["division_id"]."' AND c.our_id='".@$_REQUEST["product_id"]."' ")or die(mysql_error());

                            // } 
                            // else {
                            //     $a=mysql_query("select sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id ")or die(mysql_error());
                            // }

                            $a=mysql_query("select sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  1 ".$bill_default."  ".$state_check." ".$pdt_default." ".$division_default)or die(mysql_error());


                            if(mysql_num_rows($a)){
                              while($csvalue=mysql_fetch_array($a)) {
                                echo (@($csvalue["closing_stock"])?$csvalue["closing_stock"]:'0');
                            }
                        } else {
                          echo '0';
                      }

                      ?></span></td>
                      
                    <!--   <td style="vertical-align: top"> <div class="control-group">          
                        <select name="state_id" id="state_id"  onChange="state(this.value);" data-rel="chosen">
                            <option value="">-- Select State --</option>
                            <?php $SQL = mysql_query("SELECT * FROM master_state"); while($STATE=mysql_fetch_object($SQL)){ ?>              
                            <option value="<?php echo $STATE->state_id; ?>"><?php echo $STATE->state_name; ?></option>
                            <?php } ?>
                        </select>
                    
                    </div>
                </td> -->
                
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
                        <td>Product</td>
                        <td>:</td>
                        <td>
                            <select name="product_id" id="product_id" data-rel="chosen" >
                                <option value="">---Select---</option>
                                <?php $P=mysql_query("SELECT * FROM product "); while($I=mysql_fetch_object($P)){ ?>
                                <option value="<?=$I->id; ?>"><?=$I->pro_name; ?></option>
                                <?php } ?>
                                </select><script>document.getElementById("product_id").value="<?=$_REQUEST["product_id"] ?>";</script>
                            </td>
                            <td><Label>Month &amp; Year</label></td>
                            <td>:</td>
                            <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo ((@$_REQUEST["from_date"])?$_REQUEST["from_date"]:''); ?>"  /></td>
                            <td><input type="submit" name="button" value="REPORT" id="submit" class="btn btn-primary" style="margin-top:-12px" ><!-- <input type="button" name="button" value="REPORT" class="btn btn-primary" style="margin-top:-12px" onclick="search_submit()"> --></td>
                            <td></td>
                        </tr>


                        <tr>

                           
                            <td colspan="8" id="error_append_search" style="color: #ce3737;text-align: center"></td>

                        </tr>
                        <tr align="right">
                            <td align="right" colspan="10" style="padding-right:80px;">

                                <?php
                                // if((@$_REQUEST["division_id"]!="")&&(@$_REQUEST["from_date"]!="")){

                                //     $a=mysql_query("select a.id from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".@$_REQUEST["from_date"]."' and a.division_id='".@$_REQUEST["division_id"]."' AND c.our_id='".@$_REQUEST["product_id"]."' group by c.our_id")or die(mysql_error());

                                // } else {
                                //     $a=mysql_query("select a.id from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id group by a.distributor_id")or die(mysql_error());
                                // }
                                $a=mysql_query("select a.id from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  1 ".$bill_default."  ".$state_check." ".$pdt_default." ".$division_default." group by c.our_id")or die(mysql_error());


                                if(mysql_num_rows($a)){
                                    ?>
                                    <a href="report_primary_productwise_new_pdf.php?division_id=<?php echo @$_REQUEST["division_id"]; ?><?php echo $bill_url; echo $pdt_url; echo $state_url; ?>" target="_blank"><img src="img/pdf.png" height="20" width="20" alt="Download PDF"></a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="report_primary_productwise_new_excel.php?division_id=<?php echo @$_REQUEST["division_id"]; ?><?php echo $bill_url; echo $pdt_url; echo $state_url; ?>" target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
                                    <?php }
                                    ?>

                                </td>
                            </tr>
                        </table>
                      
                    </form>
                </div>
                   <div id="stateid">
                    <?php 
                    $P5=mysql_query("SELECT b.state_id,e.state_name from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join master_state e on b.state_id=e.state_id WHERE 1 ".$bill_default."   ".$pdt_default." ".$division_default." GROUP BY b.state_id ");
                    $I5=mysql_num_rows($P5);
                    ?>
                     <tr style="background:#FDEAE0;">
                                <!-- <td style="background:#FDEAE0;" align="right"><?=$customer->pronamepro;?></td> --><td style="background:#FDEAE0;float:right;clear:0 both;" align="right">state count : <?php   echo "<span style=\"padding-left:0px;\"><span style=\"width: 3%;\" class=\"btn btn-primary\"> ".$I5."</span> "; ?></td>
                            </tr>
                     <!-- <td style="background:#FDEAE0;float:right;clear:0 both;"><?php echo $I5;?> state FOR</td> -->
                     <td></td>
                        <td>:</td>
                             <td>
                            <select name="st_id" id="st_id" class="form-control" >
                                <option value="">---Select---</option>
                                <?php
                                
                                  $P=mysql_query("SELECT b.state_id,e.state_name from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join master_state e on b.state_id=e.state_id WHERE 1 ".$bill_default."   ".$pdt_default." ".$division_default." GROUP BY b.state_id "); while($I=mysql_fetch_object($P)){ ?>
                                 <option value="<?=$I->state_id; ?>"><?=$I->state_name; ?></option>
                               <?php 
                           }
                            ?>
                                </select><script>document.getElementById("st_id").value="<?=$_REQUEST["st_id"] ?>";</script>
                            </td>
                        </div>
                
                <div class="box-content">
                    <?php

                           $a=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,d.pro_mrp,d.id,b.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  1 ".$bill_default."  ".$state_check." ".$pdt_default." ".$division_default." group by b.state_id ORDER BY b.state_id")or die(mysql_error());
                    if(mysql_num_rows($a)){

                        ?>
                        <table width="100%" class="table table-striped table-bordered bootstrap-datatable datatable">
                            <?php
        //echo "SELECT pincode,pro_name FROM areawise_temp WHERE Pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM rep_area WHERE rep_id = 1) GROUP BY PINCODE) GROUP BY pincode";   


                            $areatotal=0; $PINTOT = 0;

                            while($customer=mysql_fetch_object($a)){ 
                                ?>
                                 <tr>
                                            <td style="background:#aaad7d;" width="10%">
                                                <strong><?php $SQLst = mysql_query("SELECT * FROM master_state WHERE state_id='".$customer->state_id."'"); $STATEst=mysql_fetch_object($SQLst);  echo $STATEst->state_name; ?></strong>
                                            </td>
                                            <td width="90%">
                                            <?php

                                $a10=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,d.pro_mrp,d.id,b.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  1 ".$bill_default."  ".$pdt_default." ".$division_default." AND  b.state_id='".$customer->state_id."' group by a.distributor_id,b.state_id ORDER BY b.state_id")or die(mysql_error());
                                while($customer10=mysql_fetch_object($a10)){ 

                             $TQ=""; $TF=""; $TR=""; $TPTR=""; $TPTS=""; $TQY=""; $OPQY=""; $PURQY=""; $SLRQY=""; $CLRQY="";

                              $a6=mysql_query("select d.pro_name,f.pts,f.ptr,d.pro_mrp,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default."   ".$pdt_default." ".$division_default." AND  b.state_id='".$customer10->state_id."' and `distributor_id` = '".@$customer10->distID."' ".$pdt_group." ")or die(mysql_error());
                             $ptr6=0;
                             $pts6=0;
                             while($customer6=mysql_fetch_object($a6))
                             {
                                $ptr6+=$customer6->ptr;
                                $pts6+=$customer6->pts;
                            }
                             ?>
                             
                                            
                                                
                                                    <table width="100%" style="border:1px solid #CCCCCC">
                                                    <tr style="background:#FDEAE0;">
                                                         <td style="background:#FDEAE0;"  >
                                                <strong><?php echo $customer10->distributor_name; ?></strong>
                                            </td>
                                <!-- <td style="background:#FDEAE0;" align="right"><?=$customer->pronamepro;?></td> --><td style="background:#FDEAE0;float:right;clear:0 both;" align="right"><?php   echo "<span style=\"padding-left:0px\"><span class=\"btn btn-primary\">PTR Value: ".round($ptr6,2)."</span> <span class=\"btn btn-success\">PTS Value: ".round($pts6,2)."</span></span>"; ?></td>
                            </tr>
                        </table>
                       
                        <table width="100%" style="border:1px solid #CCCCCC">
                                                    <tr><th >PRODUCT</th><th >PTR</th><th >PTS</th><th>MRP</th><th>OPENQTY</th><th >OPENING STOCK</th><th>PURQTY</th><th >PURCHASE</th><th>SALEQTY</th><th >SALES</th><th>CLOSEQTY</th><th >CLOSING STOCK</th><!-- <th>PTS</th> --></tr>
                                                    <?php 
                                                   
                                                      $a5=mysql_query("select d.pro_name,f.pts,f.ptr,d.pro_mrp,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default."  ".$state_check." ".$pdt_default." ".$division_default." and `distributor_id` = '".@$customer10->distID."' ".$pdt_group." ")or die(mysql_error());                   
                                                    while($customer5=mysql_fetch_object($a5)){
                                                      $TQ+=$customer5->opening_stock; $TF+=$customer5->sale; $TR+=$customer5->purchase; $OPQY+=$customer5->openqty; $PURQY+=$customer5->purqty; $SLRQY+=$customer5->saleqty; $CLRQY+=$customer5->closeqty; $TPTR+=$customer5->closing_stock;
                           // $TPTS+=round($CUST_R->CPTS,2);
                                                      ?>

                                                      <tr style="border:1px solid #CCCCCC">
                                                       <td ><?=$customer5->pro_name; ?></td>
                                                       <td ><?=$customer5->ptr; ?></td><td ><?=$customer5->pts; ?></td><td ><?=$customer5->pro_mrp; ?></td><td ><?=$customer5->openqty; ?></td><td  ><?=round($customer5->opening_stock, 2); ?><td ><?=$customer5->purqty; ?></td></td><td ><?=round($customer5->purchase, 2); ?><td ><?=$customer5->saleqty; ?></td><td ><?=round($customer5->sale, 2); ?></td><td ><?=$customer5->closeqty; ?></td><td ><?=round($customer5->closing_stock, 2); ?></td><!-- <td ><?=$customer->CPTS; ?></td> -->
                                                   </tr>
                                                   <?php } ?>

                                                   <tr style="font-weight:bold">
                                                    <td style="background:#BDFCC9;"  width="50%" colspan="4"><?php echo "SUB TOTAL"; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$OPQY; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$TQ; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$PURQY; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$TR; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$SLRQY; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$TF; ?></td><td style="background:#BDFCC9;text-align:center"  width="5%"><?=$CLRQY; ?></td><td style="background:#BDFCC9;text-align:right"  width="5%"><?=$TPTR; ?></td><!-- <td style="background:#BDFCC9;text-align:right"  width="6%"><?=$TPTS; ?></td> -->
                                                </tr>
                                                    </table>
                                                     <table width="100%" style="border:1px solid #CCCCCC">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                                               
                                                <?php }
                                                ?>
                                                 </td>
                                        </tr>
                                            <?php
                                      
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
// alert("hi");
if($("#product_id").val()=='')
{
$('#stateid').hide();
}


   $("#st_id").change(function () {
          // alert("hi");
             var product_id=$('#product_id').val();
             var division_id=$('#division_id').val();
             var st_id=$('#st_id').val();
             var from_date=$('#from_date').val();
              document.location="report_primary_productwise_new.php?product_id="+product_id+"&division_id="+division_id+"&st_id="+st_id+"&from_date="+from_date;
            
        });

    // $("#submit").click(function () {
    //     $('#stateid').show(); 
    // }

$(document).ready(function() {

    // $('#example').dataTable();
    
     // $("#product_id").change(function () {
     //        if ($(this).attr('value') == "product_id") {
     //            $('#stateid').show();                
     //        } else {
     //            $('#stateid').hide();               
     //        }
     //    });
});

function state(state){
  if(state)
    document.location = "report_primary_productwise.php?state="+state;
else
    document.location = "report_primary_productwise.php";
}

// function search_submit(){
//   if($('#division_id').val()!='' && $('#from_date').val()!='' && $('#product_id').val()!='')
//     $("#searchForm").submit()
// else {
//     $("#error_append_search").html("Division and Product and Month required!")
//     return false
// }

// }
</script>
</body>
</html>
<?php
}
?>
