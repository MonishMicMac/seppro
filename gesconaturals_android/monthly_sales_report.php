<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("connect1.php");
/*include("include/function.php");
$conn=mysql_connect("localhost","root","");
mysql_select_db("xylo");*/
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3000000);
ini_set('max_execution_time', 1500000);
set_time_limit(0);
$REP = mysql_query("SELECT id,rep_name FROM representative WHERE id='".$_REQUEST['rep_name']."'");
$R=mysql_fetch_object($REP);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->calculateColumnWidths();
$yuvaraj->getActiveSheet()->mergeCells('A1:H1');
$yuvaraj->getActiveSheet()->getStyle('A1:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "SRI VISHNU");
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->mergeCells('A2:H2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, strtoupper($R->rep_name)." - MONTHLY SALES REPORT on ".date("Y-m",strtotime($_REQUEST["from_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Date");
$yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('A3:BX99')->getAlignment()->setWrapText(true);
$col=1;
$Product=mysql_query("SELECT * FROM product"); // PRODUCT DETAILS	
while($P=mysql_fetch_object($Product)){
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, strtoupper($P->pro_name));
	$yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$col++;	
	$yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, "NSR VALUE IN RS");
// CLIENT POB - START
$row=4;$YP = 1;
$TOT=0;

$yuvaraj->getActiveSheet()->freezePaneByColumnAndRow(2,4);

$Daysperiod=mysql_query("select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date LIKE '%".date("Y-m",strtotime($_REQUEST["from_date"]))."%'");
while($D=mysql_fetch_object($Daysperiod)){	
		$col=0;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("d-m-Y",strtotime($D->selected_date)));
		$col=1;	
		$Client_details = mysql_query("SELECT id,pro_name,IFNULL(SUM(pobbooking.qty),'NA') Q FROM `product` LEFT OUTER JOIN pobbooking ON product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($D->selected_date))."' GROUP BY product.id ORDER BY product.id");
		while($C1=mysql_fetch_object($Client_details)){		
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->Q);
			$col++;
			$yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);		
		}
		$Client_details1 = mysql_query("SELECT IFNULL(ROUND(SUM(pobbooking.qty*product.pts),2),0) pts FROM `product`, pobbooking WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($D->selected_date))."'");
	$C2=mysql_fetch_object($Client_details1);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C2->pts);
	$TOT+=$C2->pts;		
	$row++;
	$col=1;
// TOTAL SUMMARY - START
	$Product_T=mysql_query("SELECT * FROM product"); // PRODUCT DETAILS	
	while($P_T=mysql_fetch_object($Product_T)){
		$INDIVIDUAL_PRODUCT = mysql_query("SELECT IFNULL(SUM(qty),0) Q FROM pobbooking WHERE productid='".$P_T->id."' AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate LIKE '%".date("Y-m",strtotime($_REQUEST["from_date"]))."%'");
		$Y3=mysql_fetch_object($INDIVIDUAL_PRODUCT);	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y3->Q);
		$col++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	}$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOT);
}
// CLIENT POB - END

//prepare download
$filename=strtoupper($R->rep_name)." Daily_Sales_Report ".date("d/m/Y H:i:s").".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>