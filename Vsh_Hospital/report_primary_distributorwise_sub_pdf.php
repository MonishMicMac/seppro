<?php
include("include/connect.php");
session_start();
if(@$_REQUEST["division_id"]) {
$SQL = mysql_query("SELECT division_name FROM mst_division WHERE division_id='".$_REQUEST["division_id"]."'");
while($customer2=mysql_fetch_array($SQL)) {

    $division_name=$customer2["division_name"];
}
} else {
  $division_name = "All";
}

$html="<table style=\"width:100%\">
        <tr>
          <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">
        </tr>
        <tr>
          <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Division: ".$division_name." [Month and Year: ".$_REQUEST["from_date"]."] </tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\"> Division Primary Report</td>
        </tr>
      </table>";

$html.="<table style=\"width:100%;border-collapse: collapse\" border=1 >
    <tr style=\"background-color: #dcdcdc;\">
      <th>Product Name</th>
      <th>PTR</th>
      <th>PTS</th>
      <th>MRP</th>
      <th>Opening Stock Qty</th>
      <th>Opening Stock Value</th>
      <th>Opening Free Value</th>
      <th>Purchase Qty</th>
      <th>Purchase Value</th>
      <th>Purchase Free Value</th>
      <th>Purchase Return Value</th>
      <th>Sale Qty</th>
      <th>Sale Value</th>
      <th>Sale Free Value</th>
      <th>Sale Return Value</th>
      <th>Sale Replacement Value</th>
      <th>Damage Value</th>
      <th>Adjustment Value</th>
      <th>Closing Stock Qty</th>
      <th>Closing Stock Value</th>

    </tr>";





if(@$_REQUEST["division_id"]!=""){
    $division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
} else {
    if($_SESSION["division_id"]!="ALL")
        $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
    else 
        $division_default = "";
}

  $ea=mysql_query("select d.pro_name,f.pts,f.ptr,d.pro_mrp,sum(a.opening_stock*f.pts) as opening_stock, sum(a.opening_stock+a.opening_stock_free) as opening_stock_qty,sum((a.purchase+a.purchase_free-a.purchase_return)) as purchase_qty,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as sale_qty,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closing_stock_qty,sum(a.opening_stock_free*f.pts) as opening_stock_free, sum(a.purchase*f.pts) as purchase, sum(a.purchase_free*f.pts) as purchase_free, sum(a.purchase_return*f.pts) as purchase_return, sum(a.sale*f.pts) as sale, sum(a.sale_free*f.pts) as sale_free, sum(a.sale_return*f.pts) as sale_return, sum(a.sale_replacement*f.pts) as sale_replacement, sum(a.damage*f.pts) as damage, sum(a.adjustment*f.pts) as adjustment, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where a.bill_string='".@$_REQUEST["from_date"]."' ".$division_default." and a.distributor_id = '".@$_REQUEST["distributor"]."' and c.our_id !=0 GROUP BY d.id")or die(mysql_error());


$ptr_total = 0.00;
$pts_total = 0.00;
$mrp_total = 0.00;
$opening_stock_qty_total = 0.00;
$opening_stock_total = 0.00;
$opening_stock_free_total = 0.00;
$purchase_qty_total = 0.00;
$purchase_total = 0.00;
$purchase_free_total = 0.00;
$purchase_return_total = 0.00;
$sale_qty_total = 0.00;
$sale_total = 0.00;
$sale_free_total = 0.00;
$sale_return_total = 0.00;
$sale_replacement_total = 0.00;
$damage_total = 0.00;
$adjustment_total = 0.00;
$closing_stock_qty_total = 0.00;
$closing_stock_total = 0.00;

if(mysql_num_rows($ea)>0) {
  while($customer=mysql_fetch_array($ea)){
      
    $html.="<tr>
          <td >
            ".(($customer["pro_name"]!='')?$customer["pro_name"]:'-')."
          </td>
          <td >
            ".(($customer["ptr"]!='')?number_format($customer["ptr"],2):'0.00');
            $ptr_total += $customer["ptr"];
    $html.="</td>
          <td >
            ".(($customer["pts"]!='')?number_format($customer["pts"],2):'0.00');
            $pts_total += $customer["pts"];
    $html.="</td>
          <td >
            ".(($customer["mrp"]!='')?number_format($customer["pro_mrp"],2):'0.00');
            $mrp_total += $customer["mrp"];
    $html.="</td>
          <td >
            ".(($customer["opening_stock_qty"]!='')?round($customer["opening_stock_qty"],2):'0');
            $opening_stock_qty_total += $customer["opening_stock_qty"];
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
            ".(($customer["purchase_qty"]!='')?round($customer["purchase_qty"],2):'0');
            $purchase_qty_total += $customer["purchase_qty"];
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
            ".(($customer["sale_qty"]!='')?round($customer["sale_qty"],2):'0');
            $sale_qty_total += $customer["sale_qty"];
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
            ".(($customer["closing_stock_qty"]!='')?round($customer["closing_stock_qty"],2):'0');
            $closing_stock_qty_total += $customer["closing_stock_qty"];
    $html.="</td>
          <td >
            ".(($customer["closing_stock"]!='')?number_format($customer["closing_stock"],2):'0.00');
            $closing_stock_total += $customer["closing_stock"];
    $html.="</td>
        </tr>";
  } 



  $html.="<tr>
        <td >Total</td>
        <td >
          ".number_format($ptr_total,2);
  $html.="</td>
        <td >
          ".number_format($pts_total,2);
  $html.="</td>
        <td >
          ".number_format($mrp_total,2);
  $html.="</td>
        <td >
          ".round($opening_stock_qty_total,2);
  $html.="</td>
        <td >
          ".number_format($opening_stock_total,2);
  $html.="</td>
        <td >
          ".number_format($opening_stock_free_total,2);
  $html.="</td>
        <td >
          ".round($purchase_qty_total,2);
  $html.="</td>
        <td >
          ".number_format($purchase_total,2);
  $html.="</td>
        <td >
          ".number_format($purchase_free_total,2);
  $html.="</td>
        <td >
          ".number_format($purchase_return_total,2);
  $html.="</td>
        <td >
          ".round($sale_qty_total,2);
  $html.="</td>
        <td >
          ".number_format($sale_total,2);
  $html.="</td>
        <td >
          ".number_format($sale_free_total,2);
  $html.="</td>
        <td >
          ".number_format($sale_return_total,2);
  $html.="</td>
        <td >
          ".number_format($sale_replacement_total,2);
  $html.="</td>
        <td >
          ".number_format($damage_total,2);
  $html.="</td>
        <td >
          ".number_format($adjustment_total,2);
  $html.="</td>
        <td >
          ".round($closing_stock_qty_total,2);
  $html.="</td>
        <td >
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