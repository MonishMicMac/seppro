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

$_REQUEST["hq_name"] = 4;

$_REQUEST["from_date"]="2017/01/01";
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
$HQNAME = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id='".$_REQUEST["hq_name"]."'");
$HQN = mysql_fetch_object($HQNAME);
$HEADQUARTERNAME = strtoupper($HQN->headquarters_name);

$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);
$yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAME MRWISE SALES");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAME Consolidated MR sales Report Quantity with Value ".date("F Y",strtotime($_REQUEST["from_date"])));
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "UNIT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "PTS");

$REP11 = mysql_query("SELECT group_concat(id) rep_id FROM representative WHERE headquarter_id in (".$_REQUEST["hq_name"].")");
$REPALL=mysql_fetch_object($REP11);

$REP2 = mysql_query("SELECT group_concat(dis_id) rdist_id FROM distributor WHERE headquarters_id IN (".$_REQUEST["hq_name"].")");
$REPSTK=mysql_fetch_object($REP2);

$CommonCredit = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='0' and dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
$CC=mysql_fetch_object($CommonCredit);



// TOTAL HQ SUM

$CommonCreditSTK = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id IN (".$REPALL->rep_id.")");
$CCSTK=mysql_fetch_object($CommonCreditSTK);



$col=0;	$row=3;
$PRODUCT=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($PRODUCT)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pts));	
	$row++;
}
$col=3;	$row=2;
$REPRESENTATIVE=mysql_query("SELECT rep_name FROM representative  WHERE headquarter_id='".$_REQUEST["hq_name"]."' ORDER BY id"); // PRODUCT DETAILS	
while($REP=mysql_fetch_object($REPRESENTATIVE)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($REP->rep_name)." Q");	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($REP->rep_name)." PTS");	
	$col++;
}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "HQ Q");	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "HQ PTS");	
	$col++;
$col=3;$row=3;
$PRODUCT1=mysql_query("SELECT id,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R1=mysql_fetch_object($PRODUCT1)){
	
	$REPRESENTATIVE1=mysql_query("SELECT id,rep_name,sales_credit FROM representative  WHERE headquarter_id='".$_REQUEST["hq_name"]."' ORDER BY id"); // PRODUCT DETAILS	
	while($REP1=mysql_fetch_object($REPRESENTATIVE1)){
	
	
		$SALESDETAILS = mysql_query("SELECT IFNULL(SUM(quantity),0) Q, ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE our_product_id = '".$R1->id."' AND rep_id IN (".$REP1->id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
		$SALES=mysql_fetch_object($SALESDETAILS); // MR SALES
		
		$SALESDETAILS1 = mysql_query("SELECT IFNULL(SUM(medplus_qty),0) Q,round(IFNULL(SUM(medplus_pts),0),0) PTS FROM tbl_medplus WHERE medplus_product_id = '".$R1->id."' AND medplus_rep_id IN (".$REP1->id.") AND medplus_billdate BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
		$SALES1=mysql_fetch_object($SALESDETAILS1); // MR SALES
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SALES->Q+$SALES1->Q);
		$TOTQ+=$SALES->Q+$SALES1->Q;
		$col++;		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($R1->pts*($SALES->Q),0)+$SALES1->PTS);
		$TOTPTS+=round($R1->pts*($SALES->Q),0)+$SALES1->PTS;
		$col++;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTQ);	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTPTS);	
	$col++;
	$TOTQ = 0;$TOTPTS = 0;
	$row++;$col=3;
}
$col=0;$row++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Stockist Total");
$col=3;
$REPRESENTATIVE2=mysql_query("SELECT id,rep_name,sales_credit FROM representative  WHERE headquarter_id='".$_REQUEST["hq_name"]."' ORDER BY id"); // PRODUCT DETAILS	
while($REP1=mysql_fetch_object($REPRESENTATIVE2)){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
		$col++;
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
$col++;



//prepare download
$filename=" Daily_Sales_Report ".date("d/m/Y H:i:s").".csv"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>