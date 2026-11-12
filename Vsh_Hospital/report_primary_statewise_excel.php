<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1'); 
//load Excel template file
error_reporting(0);
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


$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "State");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Distributor");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "PRODUCT");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "PTR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "PTS");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "MRP");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "OPENQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "OPENING STOCK");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "PURQTY");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 3, "PURCHASE");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 3, "SALEQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, 3, "SALES");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, 3, "CLOSEQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, 3, "CLOSING STOCK");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, 3, "Damage");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, 3, "Adjustment");

// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, 3, "Closing Qty");

// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, 3, "Closing Stock");
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
  $bill_url = "&from_date=".$_REQUEST["from_date"];

                                // echo ":";

} else {
  $SQL = mysql_query("SELECT bill_string FROM `primary_sales` order by str_to_date(concat(\"01\",LEFT(SUBSTRING_INDEX( SUBSTRING_INDEX( bill_string,  ' ', 1 ) ,  ' ', -1 ),3),TRIM( SUBSTR(  bill_string, LOCATE(  ' ',  bill_string ) ) )),\"%d%b%Y\") desc limit 1");
  while ($customer21=mysql_fetch_array($SQL)) {
    $bill_default1=$customer21["bill_string"];
    $bill_default="and a.bill_string='".$customer21["bill_string"]."'";
    $bill_url="&from_date=".$customer21["bill_string"];
  }

                                // echo " for ".$bill_default1." :";
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
$a=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  1 ".$bill_default."  ".$state_check." ".$division_default." and c.our_id!='' group by b.state_id ORDER BY b.state_id")or die(mysql_error());
if(mysql_num_rows($a)){


  while($customer=mysql_fetch_array($a)){
    $SQLst = mysql_query("SELECT * FROM master_state WHERE state_id='".$customer["state_id"]."'"); $STATEst=mysql_fetch_array($SQLst);  

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $STATEst["state_name"]);
    $a10=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  1 ".$bill_default." ".$division_default." AND  b.state_id='".$customer["state_id"]."' group by a.distributor_id,b.state_id ORDER BY b.state_id")or die(mysql_error());
    while($customer10=mysql_fetch_array($a10)){ 

     $TQ=""; $TF=""; $TR=""; $TPTR=""; $TPTS=""; $TQY=""; $OPQY=""; $PURQY=""; $SLRQY=""; $CLRQY="";

     $a6=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$division_default." and `distributor_id` = '".@$customer10["distID"]."' and c.our_id !=0 group by a.distributor_id,b.state_id ORDER BY b.dis_name")or die(mysql_error());
     $ptr6=0;
     $pts6=0;
     while($customer6=mysql_fetch_array($a6))
     {
      $ptr6+=$customer6["ptr"];
      $pts6+=$customer6["pts"];
    }
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $customer10["distributor_name"]);
    $a5=mysql_query("select b.dis_name as distributor_name,d.pro_name as pronamepro,d.pro_mrp,f.pts,f.ptr,f.product_id,f.state_id,a.distributor_id as distID ,sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock,sum((a.opening_stock+a.opening_stock_free)) as openqty, sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase,sum((a.purchase+a.purchase_free-a.purchase_return)) as purqty, sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as saleqty, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$division_default." and `distributor_id` = '".@$customer10["distID"]."' and c.our_id !=0 GROUP BY d.id")or die(mysql_error());                   
    while($customer5=mysql_fetch_array($a5)){
      $TQ+=$customer5["opening_stock"]; $TF+=$customer5["sale"]; $TR+=$customer5["purchase"]; $OPQY+=$customer5["openqty"]; $PURQY+=$customer5["purqty"]; $SLRQY+=$customer5["saleqty"]; $CLRQY+=$customer5["closeqty"]; $TPTR+=$customer5["closing_stock"];
      



      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $customer5["pronamepro"]);
      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $customer5["ptr"]);

      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $customer5["pts"]);

      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $customer5["pro_mrp"]);
      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $customer5["openqty"]);
      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, $row, round($customer5["opening_stock"], 2));

      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $customer5["purqty"]);

      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, $row, round($customer5["purchase"], 2));
      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $customer5["saleqty"]);
      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, $row, round($customer5["sale"], 2));
      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $customer5["closeqty"]);
      $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, $row, round($customer5["closing_stock"], 2));
      $row++;
    }
     $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "SUB TOTAL");
     $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $OPQY);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $TQ);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $PURQY);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $TR);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $SLRQY);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $TF);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $CLRQY);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $TPTR);
    $row++;
  }
}


    // $yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(45);
    // $yuvaraj->getActiveSheet()->getStyle('A'.$row.':A'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    // $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer["pincode"]."-".$customer["area_name"]." PTR : [".round($customer["PTR"],2)."] PTS : [".round($customer["PTS"],2)."]");
    // $col++;

$SQL = mysql_query("SELECT state_name FROM `master_state` WHERE state_id='".$_REQUEST["state_id"]."'");
while($customer2=mysql_fetch_array($SQL)) {

  $state_name=$customer2["state_name"];
}


if((@$_REQUEST["division_id"]!="")&&(@$_REQUEST["from_date"]!="")){
    $filename="Primary Report Distributorwise - [".$state_name.'] - '.$division_name." (".date("d/m/Y",strtotime($_REQUEST["from_date"])).").xls"; //just some random filename
  } else {
    $filename="Primary Report Distributorwise - [".$state_name."].xls"; //just some random filename
  }


  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$filename.'"');
  header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!
}
?>