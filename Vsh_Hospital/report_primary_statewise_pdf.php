<?php
include("include/connect.php");
session_start();

$SQL = mysql_query("SELECT division_name FROM mst_division WHERE division_id='".$_REQUEST["division_id"]."'");
while($customer2=mysql_fetch_array($SQL)) {

  $division_name=$customer2["division_name"];
}
if ($division_name=='') {
  $html="<table style=\"width:100%\">
  <tr>
  <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">
  </tr>
  <tr>
  <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">All Division</tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\"> Primary Report</td>
  </tr>
  </table>";
}
else{  
  $html="<table style=\"width:100%\">
  <tr>
  <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">
  </tr>
  <tr>
  <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Division: ".$division_name." [Month and Year: ".$_REQUEST["from_date"]."] </tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\"> Primary Report</td>
  </tr>
  </table>";
}


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

if(@$_REQUEST["state_id"]) {
    $state_check = "and b.state_id='".(@$_REQUEST["state_id"])."'";
    $state_url = "&state_id=".(@$_REQUEST["state_id"]);
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
// $ea=mysql_query("select b.dis_name as distributor_name, sum((a.opening_stock+a.opening_stock_free)*d.ptr) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*d.ptr) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*d.ptr) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where 1 ".$bill_default."  ".$state_check." ".$pdt_default." ".$division_default." group by a.distributor_id")or die(mysql_error());

// if((@$_REQUEST["division_id"]!="")&&(@$_REQUEST["from_date"]!="")){
//     $ea=mysql_query("select b.dis_name as distributor_name, sum(a.opening_stock*d.ptr) as opening_stock, sum(a.opening_stock_free*d.ptr) as opening_stock_free, sum(a.purchase*d.ptr) as purchase, sum(a.purchase_free*d.ptr) as purchase_free, sum(a.purchase_return*d.ptr) as purchase_return, sum(a.sale*d.ptr) as sale, sum(a.sale_free*d.ptr) as sale_free, sum(a.sale_return*d.ptr) as sale_return, sum(a.sale_replacement*d.ptr) as sale_replacement, sum(a.damage*d.ptr) as damage, sum(a.adjustment*d.ptr) as adjustment, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".@$_REQUEST["from_date"]."' and a.division_id='".@$_REQUEST["division_id"]."' AND c.our_id='".@$_REQUEST["product_id"]."' group by a.distributor_id")or die(mysql_error());
// } else {
//     $ea=mysql_query("select b.dis_name as distributor_name, sum(a.opening_stock*d.ptr) as opening_stock, sum(a.opening_stock_free*d.ptr) as opening_stock_free, sum(a.purchase*d.ptr) as purchase, sum(a.purchase_free*d.ptr) as purchase_free, sum(a.purchase_return*d.ptr) as purchase_return, sum(a.sale*d.ptr) as sale, sum(a.sale_free*d.ptr) as sale_free, sum(a.sale_return*d.ptr) as sale_return, sum(a.sale_replacement*d.ptr) as sale_replacement, sum(a.damage*d.ptr) as damage, sum(a.adjustment*d.ptr) as adjustment, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id WHERE c.our_id!='' group by a.distributor_id")or die(mysql_error());
// }


// while($customer=mysql_fetch_array($ea)){ 

//   $html.="<tr>
//   <td >
//   ".(($customer["distributor_name"]!='')?$customer["distributor_name"]:'-')."
//   </td>

//   <td >
//   ".round((($customer["openqty"]!='')?$customer["openqty"]:'0.00'),2)."
//   </td>

//   <td >
//   ".round((($customer["opening_stock"]!='')?$customer["opening_stock"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["opening_stock_free"]!='')?$customer["opening_stock_free"]:'0.00'),2)."
//   </td>

//  <td >
//   ".round((($customer["purqty"]!='')?$customer["purqty"]:'0.00'),2)."
//   </td>

//   <td >
//   ".round((($customer["purchase"]!='')?$customer["purchase"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["purchase_free"]!='')?$customer["purchase_free"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["purchase_return"]!='')?$customer["purchase_return"]:'0.00'),2)."
//   </td>

//  <td >
//   ".round((($customer["saleqty"]!='')?$customer["saleqty"]:'0.00'),2)."
//   </td>

//   <td >
//   ".round((($customer["sale"]!='')?$customer["sale"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["sale_free"]!='')?$customer["sale_free"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["sale_return"]!='')?$customer["sale_return"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["sale_replacement"]!='')?$customer["sale_replacement"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["damage"]!='')?$customer["damage"]:'0.00'),2)."
//   </td>
//   <td >
//   ".round((($customer["adjustment"]!='')?$customer["adjustment"]:'0.00'),2)."
//   </td>

//  <td >
//   ".round((($customer["closeqty"]!='')?$customer["closeqty"]:'0.00'),2)."
//   </td>
  
//   <td >
//   ".round((($customer["closing_stock"]!='')?$customer["closing_stock"]:'0.00'),2)."
//   </td>
//   </tr>";
// } 



                           $a=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  1 ".$bill_default."  ".$state_check." ".$pdt_default." ".$division_default." group by b.state_id ORDER BY b.state_id")or die(mysql_error());
                    if(mysql_num_rows($a)){

                   $html.="<table width=\"100%\" class=\"table table-striped table-bordered bootstrap-datatable datatable\">";
                      


                            $areatotal=0; $PINTOT = 0;

                            while($customer=mysql_fetch_object($a)){ 
                               $a6=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default."   ".$pdt_default." ".$division_default." AND  b.state_id='".$customer->state_id."'  ".$pdt_group." ")or die(mysql_error());
                             $ptr6=0;
                             $pts6=0;
                             while($customer6=mysql_fetch_object($a6))
                             {
                                $ptr6+=$customer6->ptr;
                                $pts6+=$customer6->closing_stock;
                            }
                              $SQLst = mysql_query("SELECT * FROM master_state WHERE state_id='".$customer->state_id."'"); $STATEst=mysql_fetch_object($SQLst);  
                               $html.="  <tr>
                                            <td style=\"background:#aaad7d;\" width=\"10%\">
                                                <strong>
                                                 ".$STATEst->state_name.""; 
                                                $html.="  </strong>
                                            </td>
                                            <td width=\"90%\">
                                              <table width=\"100%\" style=\"border:1px solid #CCCCCC\">
                                                <tr>";
                                             $html.=" <td style=\"background:#FDEAE0;float:right;clear:0 both;\" align=\"right\"><span class=\"btn btn-success\">Closing Value: ".round($pts6,2)."</span></span>"; 
                                $html.=" </td>
                                </tr>
                                            </table>";
                                           

                                $a10=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  1 ".$bill_default."  ".$pdt_default." ".$division_default." AND  b.state_id='".$customer->state_id."' group by a.distributor_id,b.state_id ORDER BY b.state_id")or die(mysql_error());
                                while($customer10=mysql_fetch_object($a10)){ 

                             $TQ=""; $TF=""; $TR=""; $TPTR=""; $TPTS=""; $TQY=""; $OPQY=""; $PURQY=""; $SLRQY=""; $CLRQY="";

                             
                       
                             
                                            
                                                
                                                    $html.=" <table width=\"100%\" style=\"border:1px solid #CCCCCC\">
                                                    <tr style=\"background:#FDEAE0;\">
                                                         <td style=\"background:#FDEAE0;\">
                                                <strong>
                                                  ".$customer10->distributor_name."";
                                                  $html.=" </strong>
                                            </td>
                               
                            </tr>
                        </table>
                       
                        <table width=\"100%\" style=\"border:1px solid #CCCCCC\">
                                                    <tr><th >PRODUCT</th><th>OPENQTY</th><th >OPENING STOCK</th><th>PURQTY</th><th >PURCHASE</th><th>SALEQTY</th><th >SALES</th><th>CLOSEQTY</th><th >CLOSING STOCK</th></tr>";

                                                      $a5=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default."  ".$state_check." ".$pdt_default." ".$division_default." and `distributor_id` = '".$customer10->distID."' ".$pdt_group." ")or die(mysql_error()); 
                                                             
                                                    while($customer5=mysql_fetch_object($a5)){
                                                      $TQ+=$customer5->opening_stock; $TF+=$customer5->sale; $TR+=$customer5->purchase; $OPQY+=$customer5->openqty; $PURQY+=$customer5->purqty; $SLRQY+=$customer5->saleqty; $CLRQY+=$customer5->closeqty; $TPTR+=$customer5->closing_stock;
                          

                                                      $html.=" <tr style=\"border:1px solid #CCCCCC\">
                                                       <td >".$customer5->pronamepro."</td>
                                                       <td >".$customer5->openqty."</td><td  >".round($customer5->opening_stock, 2)."<td >".$customer5->purqty."</td></td><td >".round($customer5->purchase, 2)."<td >".$customer5->saleqty."</td><td >".round($customer5->sale, 2)."</td><td >".$customer5->closeqty."</td><td >".round($customer5->closing_stock, 2)."</td>
                                                   </tr>";
                                                  } 
                                                   $html.=" <tr style=\"font-weight:bold\">
                                                    <td style=\"background:#BDFCC9;\"  width=\"50%\" colspan=\"1\">SUB TOTAL </td><td style=\"background:#BDFCC9;text-align:center\"  width=\"5%\">".$OPQY."</td><td style=\"background:#BDFCC9;text-align:center\"  width=\"5%\">".$TQ."</td><td style=\"background:#BDFCC9;text-align:center\"  width=\"5%\">".$PURQY."</td><td style=\"background:#BDFCC9;text-align:center\"  width=\"5%\">".$TR."</td><td style=\"background:#BDFCC9;text-align:center\"  width=\"5%\">".$SLRQY."</td><td style=\"background:#BDFCC9;text-align:center\"  width=\"5%\">".$TF."</td><td style=\"background:#BDFCC9;text-align:center\"  width=\"5%\">".$CLRQY."</td><td style=\"background:#BDFCC9;text-align:right\"  width=\"5%\">".$TPTR."</td>
                                                </tr>
                                                    </table>
                                                     <table width=\"100%\" style=\"border:1px solid #CCCCCC\">
                            <tr>
                                <td></td>
                            </tr>
                        </table>";
                                               
                                              }
                                                
                                                $html.="  </td>
                                        </tr>";
                                           
                                      
                    }
                    } 

               $html.=" </table>";
// $html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9,'Times'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>