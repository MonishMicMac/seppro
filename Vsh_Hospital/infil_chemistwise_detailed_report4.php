<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3000000);
ini_set('max_execution_time', 1500000);
set_time_limit(0);
error_reporting(E_ALL);

$_REQUEST["from_date"]=date("Y/m",strtotime($_REQUEST["from_date"]))."/01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);
$totq=0;$tot=0;


function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(3);
$DCHEMIST = mysql_query("SELECT local_stockist Stockist,local_rep_id rep_id FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]." GROUP BY headquarters_id");
$DCHY=mysql_fetch_object($DCHEMIST);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKISTWISE SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=1;	$row=3;
$Representative=mysql_query("SELECT id,pro_name,packing FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));	
	$row++;
}

$col=2;$row=2;	
$Dist=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$DCHY->Stockist.") ORDER BY id"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");

$row=3;$col=2;
$ProductSales=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){
		$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$DCHY->Stockist.") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND dist_id='".$R->dis_id."'");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q,0);	
				$col++;
		}
		$PSales1 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' and dist_id IN (".$DCHY->Stockist.")");
		$S1=mysql_fetch_object($PSales1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->Q,0);
		$col=2;$row++;
}

$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col=2;
$TOTAL = 0;
$DistributorTOT1=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$DCHY->Stockist.") ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($DistributorTOT1)){	
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$R->dis_id."' ");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->Q,0);	
		$col++;		
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");

//prepare download
$filename=" Daily_Sales_Report ".date("d/m/Y H:i:s").".csv"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>