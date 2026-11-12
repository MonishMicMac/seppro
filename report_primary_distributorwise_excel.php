<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1'); 
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
/////////////////////////////////////////////////////// DIVISION ///////////////////////////////////////////////////////////////
$yuvaraj->getActiveSheet()->mergeCells('A1:Q1');
$SQL = mysql_query("SELECT division_name FROM mst_division WHERE division_id='".$_REQUEST["division_id"]."'");
while ($customer2=mysql_fetch_array($SQL)) {
    $division_name=$customer2["division_name"];
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $division_name);
}
$yuvaraj->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:Q1','9d9b9b');
mytemplate_design_fcolor('A1:Q1','FFFFFF');
/////////////////////////////////////////////////////// DIVISION ///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////// BILL STRING ///////////////////////////////////////////////////////////////
$yuvaraj->getActiveSheet()->mergeCells('A2:Q2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $_REQUEST["from_date"]);
$yuvaraj->getActiveSheet()->getStyle('A1:Q2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:Q2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:Q2','9d9b9b');
mytemplate_design_fcolor('A1:Q2','FFFFFF');
/////////////////////////////////////////////////////// BILL STRING ///////////////////////////////////////////////////////////////
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Distributor");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Opening qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "Opening Stock");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "Opening Free");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "Purchase qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "Purchase");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "Purchase Free");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "Purchase Return");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "Sale qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 3, "Sale");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 3, "Sale Free");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, 3, "Sale Return");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, 3, "Sale Replacement");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, 3, "Damage");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, 3, "Adjustment");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, 3, "Closing qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, 3, "Closing Stock");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "DOCTOR NAME");
// $yuvaraj->getActiveSheet()->getStyle('A4:A4')->getAlignment()->setShrinkToFit(true);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "PRODUCT NAME");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "BATCH");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "QTY");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(50);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "Q Split");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "FQTY");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "RQTY");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 4, "PTR");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 4, "PTS");
$yuvaraj->getActiveSheet()->getStyle('A3:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:Q3')->getFont()->setBold(true);
// $yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:Q3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');   
mytemplate_design_bg('A3:Q3','eceeef'); 
$styleArray = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ); 
$row = 4;
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
    $a=mysql_query("select b.dis_name as distributor_name, sum((a.opening_stock+a.opening_stock_free)*d.ptr) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*d.ptr) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*d.ptr) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.ptr) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$state_check." ".$division_default." group by a.distributor_id")or die(mysql_error());
if(mysql_num_rows($a)) {
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
  while($customer=mysql_fetch_array($a)){
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, ($customer["distributor_name"]!='')?$customer["distributor_name"]:'-');
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ($customer["openqty"]!='')?round($customer["openqty"],2):'0.00');
        $openingqty += $customer["openqty"];
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, $row, ($customer["opening_stock"]!='')?number_format($customer["opening_stock"],2):'0.00');
        $opening_stock_total += $customer["opening_stock"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, ($customer["opening_stock_free"]!='')?number_format($customer["opening_stock_free"],2):'0.00');
        $opening_stock_free_total += $customer["opening_stock_free"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, ($customer["purqty"]!='')?round($customer["purqty"],2):'0.00');
        $purchaseqty += $customer["purqty"];
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, ($customer["purchase"]!='')?number_format($customer["purchase"],2):'0.00');
        $purchase_total += $customer["purchase"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, ($customer["purchase_free"]!='')?number_format($customer["purchase_free"],2):'0.00');
        $purchase_free_total += $customer["purchase_free"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, $row, ($customer["purchase_return"]!='')?number_format($customer["purchase_return"],2):'0.00');
        $purchase_return_total += $customer["purchase_return"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, $row, ($customer["saleqty"]!='')?round($customer["saleqty"],2):'0.00');
        $saleqty += $customer["saleqty"];
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, $row, ($customer["sale"]!='')?number_format($customer["sale"],2):'0.00');
        $sale_total += $customer["sale"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, $row, ($customer["sale_free"]!='')?number_format($customer["sale_free"],2):'0.00');
        $sale_free_total += $customer["sale_free"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, $row, ($customer["sale_return"]!='')?number_format($customer["sale_return"],2):'0.00');
        $sale_return_total += $customer["sale_return"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, $row, ($customer["sale_replacement"]!='')?number_format($customer["sale_replacement"],2):'0.00');
        $sale_replacement_total += $customer["sale_replacement"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, $row, ($customer["damage"]!='')?number_format($customer["damage"],2):'0.00');
        $damage_total += $customer["damage"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, $row, ($customer["adjustment"]!='')?number_format($customer["adjustment"],2):'0.00');
        $adjustment_total += $customer["adjustment"];
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, $row, ($customer["closeqty"]!='')?round($customer["closeqty"],2):'0.00');
        $closingqty += $customer["closeqty"];
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, $row, ($customer["closing_stock"]!='')?number_format($customer["closing_stock"],2):'0.00');
        $closing_stock_total += $customer["closing_stock"];
        
        $row++;
  }
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Total");
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, round($openingqty,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, $row, number_format($opening_stock_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, number_format($opening_stock_free_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, round($purchaseqty,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, number_format($purchase_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, number_format($purchase_free_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, $row, number_format($purchase_return_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, $row, round($saleqty,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, $row, number_format($sale_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, $row, number_format($sale_free_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, $row, number_format($sale_return_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, $row, number_format($sale_replacement_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, $row, number_format($damage_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, $row, number_format($adjustment_total,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, $row, round($closingqty,2));
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, $row, number_format($closing_stock_total,2));
  $row++;
}
    // $yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(45);
    // $yuvaraj->getActiveSheet()->getStyle('A'.$row.':A'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    // $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer["pincode"]."-".$customer["area_name"]." PTR : [".round($customer["PTR"],2)."] PTS : [".round($customer["PTS"],2)."]");
    // $col++;
if($state_check!==""){
  $SQL = mysql_query("SELECT state_name FROM `master_state` WHERE state_id='".$_REQUEST["state_id"]."'");
  while($customer2=mysql_fetch_array($SQL)) {
      $state_name=$customer2["state_name"];
  }
} else {
  $state_name = "PAN India";
}
$filename="Primary Report Distributorwise - [".$state_name."]";
if((@$_REQUEST["division_id"]!="")){
    $filename.=" - ".$division_name; 
}
if((@$_REQUEST["from_date"]!="")){
    $filename.=" (".date("d/m/Y",strtotime($_REQUEST["from_date"])).")"; //just some random filename
}
    $filename.=".xls"; 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
exit; //done.. exiting!
?>