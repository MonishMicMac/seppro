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
$html.="<table style=\"width:100%;border-collapse: collapse\" border=1 >
    <tr style=\"background-color: #dcdcdc;\">
<th>Distributor</th>

<th>Opening qty</th>

<th>Opening Stock</th>
<th>Opening Free</th>

<th>Purchase qty</th>

<th>Purchase</th>
<th>Purchase Free</th>
<th>Purchase Return</th>

<th>Sale qty</th>

<th>Sale</th>
<th>Sale Free</th>
<th>Sale Return</th>
<th>Sale Replacement</th>
<th>Damage</th>
<th>Adjustment</th>

<th>Closing qty</th>

<th>Closing Stock</th>

    </tr>";





if(@$_REQUEST["from_date"]!=""){
    $bill_default = "and a.bill_string='".$_REQUEST["from_date"]."'";

} else {
    $SQL = mysql_query("SELECT bill_string FROM `primary_sales` order by str_to_date(concat(\"01\",LEFT(SUBSTRING_INDEX( SUBSTRING_INDEX( bill_string,  ' ', 1 ) ,  ' ', -1 ),3),TRIM( SUBSTR(  bill_string, LOCATE(  ' ',  bill_string ) ) )),\"%d%b%Y\") desc limit 1");
    while ($customer21=mysql_fetch_array($SQL)) {
        $bill_default="and a.bill_string='".$customer21["bill_string"]."'";
    }

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

} else {

    if($_SESSION["state_id"]!="ALL") {
        $state_check = " and b.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
    } else {
        $state_check = "";
    }

}


  $ea=mysql_query("select b.dis_name as distributor_name, sum((a.opening_stock+a.opening_stock_free)*d.ptr) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*d.ptr) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*d.ptr) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$state_check." ".$division_default." group by a.distributor_id")or die(mysql_error());
    
if(mysql_num_rows($ea)) {
   $openingqty = 0.00;
  $purchaseqty = 0.00;
  $saleqty = 0.00;
  $closingqty = 0.00;
  $opening_stock_total = 0.00;
  $opening_stock_free_total = 0.00;
  $purchase_total = 0.00;
  $purchase_free_total = 0.00;
  $purchase_return_total = 0.00;
  $sale_total = 0.00;
  $sale_free_total = 0.00;
  $sale_return_total = 0.00;
  $sale_replacement_total = 0.00;
  $damage_total = 0.00;
  $adjustment_total = 0.00;
  $closing_stock_total = 0.00;

  while($customer=mysql_fetch_array($ea)){ 
      
    $html.="<tr>
          <td >
            ".(($customer["distributor_name"]!='')?$customer["distributor_name"]:'-')."
          </td>
            <td >
            ".(($customer["openqty"]!='')?round($customer["openqty"],2):'0.00');
            $openingqty += $customer["openqty"];
    $html.="</td>
          <td >
            ".(($customer["opening_stock"]!='')?number_format($customer["opening_stock"],2):'0.00');
            $opening_stock_total += $customer["opening_stock"];
    $html.="</td>
          <td >
            ".(($customer["opening_stock_free"]!='')?number_format($customer["opening_stock_free"],2):'0.00');
            $opening_stock_free_total += $customer["opening_stock_free"];
    $html.="</td>
      <td >
            ".(($customer["purqty"]!='')?round($customer["purqty"],2):'0.00');
            $purchaseqty += $customer["purqty"];
    $html.="</td>
          <td >
            ".(($customer["purchase"]!='')?number_format($customer["purchase"],2):'0.00');
            $purchase_total += $customer["purchase"];
    $html.="</td>
          <td >
            ".(($customer["purchase_free"]!='')?number_format($customer["purchase_free"],2):'0.00');
            $purchase_free_total += $customer["purchase_free"];
    $html.="</td>
          <td >
            ".(($customer["purchase_return"]!='')?number_format($customer["purchase_return"],2):'0.00');
            $purchase_return_total += $customer["purchase_return"];
    $html.="</td>
      <td >
            ".(($customer["saleqty"]!='')?round($customer["saleqty"],2):'0.00');
            $saleqty += $customer["saleqty"];
    $html.="</td>
          <td >
            ".(($customer["sale"]!='')?number_format($customer["sale"],2):'0.00');
            $sale_total += $customer["sale"];
    $html.="</td>
          <td >
            ".(($customer["sale_free"]!='')?number_format($customer["sale_free"],2):'0.00');
            $sale_free_total += $customer["sale_free"];
    $html.="</td>
          <td >
            ".(($customer["sale_return"]!='')?number_format($customer["sale_return"],2):'0.00');
            $sale_return_total += $customer["sale_return"];
    $html.="</td>
          <td >
            ".(($customer["sale_replacement"]!='')?number_format($customer["sale_replacement"],2):'0.00');
            $sale_replacement_total += $customer["sale_replacement"];
    $html.="</td>
          <td >
            ".(($customer["damage"]!='')?number_format($customer["damage"],2):'0.00');
            $damage_total += $customer["damage"];
    $html.="</td>
          <td >
            ".(($customer["adjustment"]!='')?number_format($customer["adjustment"],2):'0.00');
            $adjustment_total += $customer["adjustment"];
    $html.="</td>
      <td >
            ".(($customer["closeqty"]!='')?round($customer["closeqty"],2):'0.00');
            $closingqty += $customer["closeqty"];
    $html.="</td>
          <td >
            ".(($customer["closing_stock"]!='')?number_format($customer["closing_stock"],2):'0.00');
            $closing_stock_total += $customer["closing_stock"];
    $html.="</td>
        </tr>";
  } 

  $html.="<tr>
        <td >
          Total
        </td>
         <td>
          ".round($openingqty,2);
  $html.="</td>
        <td>
          ".number_format($opening_stock_total,2);
  $html.="</td>
        <td>
          ".number_format($opening_stock_free_total,2);
  $html.="</td>
   <td>
          ".round($purchaseqty,2);
  $html.="</td>
        <td>
          ".number_format($purchase_total,2);
  $html.="</td>
        <td>
          ".number_format($purchase_free_total,2);
  $html.="</td>
        <td>
          ".number_format($purchase_return_total,2);
  $html.="</td>
   <td>
          ".round($saleqty,2);
  $html.="</td>
        <td>
          ".number_format($sale_total,2);
  $html.="</td>
        <td>
          ".number_format($sale_free_total,2);
  $html.="</td>
        <td>
          ".number_format($sale_return_total,2);
  $html.="</td>
        <td>
          ".number_format($sale_replacement_total,2);
  $html.="</td>
        <td>
          ".number_format($damage_total,2);
  $html.="</td>
        <td>
          ".number_format($adjustment_total,2);
  $html.="</td>
   <td>
          ".round($closingqty,2);
  $html.="</td>
        <td>
          ".number_format($closing_stock_total,2);
  $html.="</td>
      </tr>";
}
$html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9,'Times'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>