<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
/*include("include/function.php");
$conn=mysql_connect("localhost","root","");
mysql_select_db("xylo");*/
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
$REP = mysql_query("SELECT id,rep_name FROM representative WHERE id='".$_REQUEST['rep_name']."'");
$R=mysql_fetch_object($REP);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->calculateColumnWidths();
$yuvaraj->getActiveSheet()->mergeCells('A1:H1');
// $yuvaraj->getActiveSheet()->getStyle('A1:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->mergeCells('A2:H2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, strtoupper($R->rep_name)." - DAILY SALES REPORT on ".date("Y-m-d",strtotime($_REQUEST['from_date'])));
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(15);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Sl.No");
$yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "NAME OF RETAIL COUNTER");
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('A3:BX99')->getAlignment()->setWrapText(true);
$col=2;

$Product=mysql_query("SELECT * FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."'  AND cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' GROUP BY productid ORDER BY pob_id"); // PRODUCT DETAILS	
while($P=mysql_fetch_object($Product)){
	
	$Prodview=mysql_query("SELECT * FROM product WHERE id='".$P->productid."' "); // PRODUCT DETAILS	
		$Prodview_row=mysql_fetch_object($Prodview);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, strtoupper($Prodview_row->pro_name));
	$yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$col++;	
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, "NSR VALUE IN RS");

// STOCKIST POB - START
// $distributor=mysql_query("SELECT doctors.doctor_name FROM disbooked,doctors WHERE disbooked.dc_id=doctors.id AND disbooked.repid='".$_REQUEST['rep_name']."' AND disbooked.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' GROUP BY disbooked.dc_id");
// $D=mysql_fetch_object($distributor);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, strtoupper($D->doctor_name));
// $row=4;$col=2;
// $Product1=mysql_query("SELECT id,pro_name,IFNULL(disbooked.qty,'NA') Q FROM `product` LEFT OUTER JOIN disbooked ON product.id=disbooked.productid
// AND disbooked.repid='".$_REQUEST['rep_name']."' AND disbooked.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' ORDER BY product.id"); // PRODUCT DETAILS	
// while($P1=mysql_fetch_object($Product1)){	
// 		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($P1->Q));
// 		$col++;
// 		$yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);	
// }
// $Stockist_tot=mysql_query("SELECT ROUND(SUM(disbooked.qty*product.pts),2) PTS FROM disbooked,product WHERE disbooked.repid='".$_REQUEST['rep_name']."' AND disbooked.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' AND disbooked.productid=product.id");
// $S_tot=mysql_fetch_object($Stockist_tot);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $S_tot->PTS);
// STOCKIST POB - END
// CLIENT POB - START 
$row=5;$col=2;$YP = 1;
$TOT=0;
$client = mysql_query("SELECT doctors.doctor_name,doctors.id,doctors.drorchemist,doctors.doc_pincode FROM pobbooking,doctors WHERE pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' AND doctors.id=pobbooking.client_id  GROUP BY pobbooking.client_id ORDER BY pobbooking.pob_id");
while($C=mysql_fetch_object($client)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $YP);
	$yuvaraj->getActiveSheet()->getStyle('A'.$row.':A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle('A'.$row.':A'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$col=1;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($C->drorchemist.'_'.$C->doctor_name));
	$col=2;	
	// echo "SELECT id,pro_name,IFNULL((SELECT qty from pobbooking WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' AND client_id='".$C->id."' AND productid=product.id LIMIT 1),'NA') AS qty FROM product WHERE id IN (SELECT productid FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."') ORDER BY product.id";
	$Client_details = mysql_query("SELECT id,pro_name,IFNULL((SELECT qty from pobbooking WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' AND client_id='".$C->id."' AND productid=product.id LIMIT 1),'NA') AS Q FROM product WHERE id IN (SELECT productid FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."') ORDER BY product.id");
	while($C1=mysql_fetch_object($Client_details)){		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->Q);
		$col++;
		// $yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);		
	}

	$Client_details1 = mysql_query("SELECT ROUND(SUM(pobbooking.qty*product.pts),2) pts FROM `product`, pobbooking WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' AND pobbooking.client_id='".$C->id."' ");
	$C2=mysql_fetch_object($Client_details1);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C2->pts);
	$TOT+=$C2->pts;
	$YP++;$row++;	
}
// exit();
// CLIENT POB - END
$col=2;
// TOTAL SUMMARY - START
$Product_T=mysql_query("SELECT * FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."'  AND cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' GROUP BY productid ORDER BY pob_id"); // PRODUCT DETAILS	
	while($P_T=mysql_fetch_object($Product_T)){
			$Prodview1=mysql_query("SELECT * FROM product WHERE id='".$P_T->productid."'"); // PRODUCT DETAILS	
		$Prodview_row1=mysql_fetch_object($Prodview1);
	
	$INDIVIDUAL_PRODUCT = mysql_query("SELECT IFNULL(SUM(qty),0) Q FROM pobbooking WHERE productid='".$Prodview_row1->id."' AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' ORDER BY pobbooking.pob_id");
	$Y3=mysql_fetch_object($INDIVIDUAL_PRODUCT);	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y3->Q);
	$col++;
	// $yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOT);

// TOTAL SUMMARY - END
$row++;
// SUMMARY REPORT - START

	$Consolidated = mysql_query("SELECT COUNT( DISTINCT client_id ) TOT_CALLS FROM pobbooking WHERE pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."'");
	$C3=mysql_fetch_object($Consolidated);
	$Consolidated1 = mysql_query("SELECT COUNT(DISTINCT client_id) Positive FROM pobbooking WHERE qty>0 AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($_REQUEST['from_date']))."'");
	$C4=mysql_fetch_object($Consolidated1);
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(100);
	$yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, $row, "TOTAL CALLS FOR THE DAY = ".$C3->TOT_CALLS);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, "PRODUCTIVE CALLS = ".$C4->Positive);	
// 	echo ROUND((($C4->Positive/$C3->TOT_CALLS)*100),0)."%";
// exit();
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, "PRODUCTIVE CALLS PERCENTAGE = ".ROUND((($C4->Positive/$C3->TOT_CALLS)*100),0)."%");
	$Client_details2 = mysql_query("SELECT ROUND(SUM(pobbooking.qty*product.pts),2) pts FROM `product`, pobbooking WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate BETWEEN '".date("Y-m-01")."' AND '".date("Y-m-d")."'");
	$YC3=mysql_fetch_object($Client_details2);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, "CUMULATIVE VALUE OF SEC. ORDER MTD @ NSR = ".ROUND($YC3->pts,0));
	// $yuvaraj->getActiveSheet()->getStyle('C'.$row.':E'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
// SUMMARY REPORT - END	
//prepare download
$filename=strtoupper($R->rep_name)." Daily_Sales_Report ".date("Y-m-d",strtotime($_REQUEST['from_date'])).".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>