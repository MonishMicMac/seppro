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
$yuvaraj->getActiveSheet()->mergeCells('A1:P1');
if(@$_REQUEST["division_id"]!=""){
$SQL = mysql_query("SELECT division_name FROM mst_division WHERE division_id='".$_REQUEST["division_id"]."'");
while ($customer2=mysql_fetch_array($SQL)) {
    $division_name=$customer2["division_name"];
}
} else {
    $division_name='All Divisions';
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_REQUEST["from_date"]." - ".$division_name);
$yuvaraj->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:P1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:P1','9d9b9b');
mytemplate_design_fcolor('A1:P1','FFFFFF');
/////////////////////////////////////////////////////// DIVISION ///////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////// BILL STRING ///////////////////////////////////////////////////////////////
$yuvaraj->getActiveSheet()->mergeCells('A2:P2');


$SQL = mysql_query("SELECT dis_name FROM distributor WHERE dis_id='".$_REQUEST["distributor"]."'");
while ($customer21=mysql_fetch_array($SQL)) {
    $dis_name=$customer21["dis_name"];
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $dis_name." - Report Time: ".date("d/m/Y h:i:s"));
}

$yuvaraj->getActiveSheet()->getStyle('A1:T2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:T2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:T2','9d9b9b');
mytemplate_design_fcolor('A1:T2','FFFFFF');
/////////////////////////////////////////////////////// BILL STRING ///////////////////////////////////////////////////////////////


$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Product Name");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "PTR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "MRP");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "Opening Stock Qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "Opening Stock Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "Opening Free Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "Purchase Qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "Purchase Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 3, "Purchase Free Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 3, "Purchase Return Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, 3, "Sale Qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, 3, "Sale Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, 3, "Sale Free Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, 3, "Sale Return Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, 3, "Sale Replacement Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, 3, "Damage Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(17, 3, "Adjustment Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(18, 3, "Closing Stock Qty");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(19, 3, "Closing Stock Value");
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
$yuvaraj->getActiveSheet()->getStyle('A3:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:T3')->getFont()->setBold(true);
// $yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:T3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');   
mytemplate_design_bg('A3:T3','eceeef'); 

$styleArray = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ); 

$row = 4;





if(@$_REQUEST["division_id"]!=""){
    $division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
} else {
    if($_SESSION["division_id"]!="ALL")
        $division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
    else 
        $division_default = "";
}



   $a=mysql_query("select d.pro_name,f.pts,f.ptr,d.pro_mrp,sum(a.opening_stock*f.pts) as opening_stock, sum(a.opening_stock+a.opening_stock_free) as opening_stock_qty,sum((a.purchase+a.purchase_free-a.purchase_return)) as purchase_qty,sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))) as sale_qty,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closing_stock_qty,sum(a.opening_stock_free*f.pts) as opening_stock_free, sum(a.purchase*f.pts) as purchase, sum(a.purchase_free*f.pts) as purchase_free, sum(a.purchase_return*f.pts) as purchase_return, sum(a.sale*f.pts) as sale, sum(a.sale_free*f.pts) as sale_free, sum(a.sale_return*f.pts) as sale_return, sum(a.sale_replacement*f.pts) as sale_replacement, sum(a.damage*f.pts) as damage, sum(a.adjustment*f.pts) as adjustment, sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where a.bill_string='".@$_REQUEST["from_date"]."' ".$division_default." and a.distributor_id = '".@$_REQUEST["distributor"]."' and c.our_id !=0 GROUP BY d.id")or die(mysql_error());

if(mysql_num_rows($a)>0) {


    $ptr_total = 0.00;
    $pts_total = 0.00;
    $pro_mrp_total = 0.00;
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

    while($customer=mysql_fetch_array($a)){

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, ($customer["pro_name"]!='')?$customer["pro_name"]:'-');

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ($customer["ptr"]!='')?number_format($customer["ptr"],2):'0.00');
        $ptr_total += $customer["ptr"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, $row, ($customer["pts"]!='')?number_format($customer["pts"],2):'0.00');
        $pts_total += $customer["pts"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, ($customer["pro_mrp"]!='')?number_format($customer["pro_mrp"],2):'0.00');
        $pro_mrp_total += $customer["pro_mrp"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, ($customer["opening_stock_qty"]!='')?round($customer["opening_stock_qty"],2):'0');
        $opening_stock_qty_total += $customer["opening_stock_qty"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, ($customer["opening_stock"]!='')?number_format($customer["opening_stock"],2):'0.00');
        $opening_stock_total += $customer["opening_stock"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, ($customer["opening_stock_free"]!='')?number_format($customer["opening_stock_free"],2):'0.00');
        $opening_stock_free_total += $customer["opening_stock_free"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, $row, ($customer["purchase_qty"]!='')?round($customer["purchase_qty"],2):'0');
        $purchase_qty_total += $customer["purchase_qty"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, $row, ($customer["purchase"]!='')?number_format($customer["purchase"],2):'0.00');
        $purchase_total += $customer["purchase"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, $row, ($customer["purchase_free"]!='')?number_format($customer["purchase_free"],2):'0.00');
        $purchase_free_total += $customer["purchase_free"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, $row, ($customer["purchase_return"]!='')?number_format($customer["purchase_return"],2):'0.00');
        $purchase_return_total += $customer["purchase_return"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, $row, ($customer["sale_qty"]!='')?round($customer["sale_qty"],2):'0');
        $sale_qty_total += $customer["sale_qty"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, $row, ($customer["sale"]!='')?number_format($customer["sale"],2):'0.00');
        $sale_total += $customer["sale"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, $row, ($customer["sale_free"]!='')?number_format($customer["sale_free"],2):'0.00');
        $sale_free_total += $customer["sale_free"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, $row, ($customer["sale_return"]!='')?number_format($customer["sale_return"],2):'0.00');
        $sale_return_total += $customer["sale_return"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, $row, ($customer["sale_replacement"]!='')?number_format($customer["sale_replacement"],2):'0.00');
        $sale_replacement_total += $customer["sale_replacement"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, $row, ($customer["damage"]!='')?number_format($customer["damage"],2):'0.00');
        $damage_total += $customer["damage"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(17, $row, ($customer["adjustment"]!='')?number_format($customer["adjustment"],2):'0.00');
        $adjustment_total += $customer["adjustment"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(18, $row, ($customer["closing_stock_qty"]!='')?round($customer["closing_stock_qty"],2):'0');
        $closing_stock_qty_total += $customer["closing_stock_qty"];

        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(19, $row, ($customer["closing_stock"]!='')?number_format($customer["closing_stock"],2):'0.00');
        $closing_stock_total += $customer["closing_stock"];


        $row++;
    }


    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Total");

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, number_format($ptr_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, $row, number_format($pts_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, number_format($pro_mrp_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, round($opening_stock_qty_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, number_format($opening_stock_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, number_format($opening_stock_free_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, $row, round($purchase_qty_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, $row, number_format($purchase_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, $row, number_format($purchase_free_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, $row, number_format($purchase_return_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, $row, round($sale_qty_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, $row, number_format($sale_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, $row, number_format($sale_free_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, $row, number_format($sale_return_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, $row, number_format($sale_replacement_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, $row, number_format($damage_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(17, $row, number_format($adjustment_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(18, $row, round($closing_stock_qty_total,2));

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(19, $row, number_format($closing_stock_total,2));


    $row++;

}

    // $yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(45);
    // $yuvaraj->getActiveSheet()->getStyle('A'.$row.':A'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    // $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer["pincode"]."-".$customer["area_name"]." PTR : [".round($customer["PTR"],2)."] PTS : [".round($customer["PTS"],2)."]");
    // $col++;



$SQL = mysql_query("SELECT division_name FROM mst_division WHERE division_id='".$_REQUEST["division_id"]."'");
while ($customer2=mysql_fetch_array($SQL)) {
    $division_name=$customer2["division_name"];
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $division_name);
}



if((@$_REQUEST["division_id"]!="")&&(@$_REQUEST["from_date"]!="")){
    $filename="Primary Report Distributorwise - ".$division_name." (".date("d/m/Y",strtotime($_REQUEST["from_date"])).").xls"; //just some random filename
} else {
    $filename="Primary Report Distributorwise.xls"; //just some random filename
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>