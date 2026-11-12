<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getActiveSheet()->mergeCells('A1:F1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:F1','9d9b9b');
mytemplate_design_fcolor('A1:F1','FFFFFF');

$from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

$repname=mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST['rep_name']."' ");
	$repname_row=mysql_fetch_array($repname);

$yuvaraj->getActiveSheet()->mergeCells('A2:F2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $repname_row['rep_name'].' - '.$_REQUEST["from_date"].' to '.$R_MDATE->LastDay);
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DR NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "AREA");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "PINCODE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "DAY OF visit");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "NO OF COUNT");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(25);
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');	
mytemplate_design_bg('A3:F3','eceeef');	

$row = 4;	
$i=1;
$totpr=0;
$SQL=mysql_query("SELECT * from doctors where  `rep_id`='".$_REQUEST['rep_name']."' AND id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_name']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
while($Y=mysql_fetch_object($SQL)){	
		$pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$Y->doc_pin_id."' ");	
			$pinarea_res=mysql_fetch_object($pinarea);
			$visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
		 		$visitcount_res=mysql_fetch_object($visitcount);
		
	$col=0;
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->doctor_name);						
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $pinarea_res->area_name);						
	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $pinarea_res->pincode);						
	$col++;	
	$cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	// while($cldate_res=mysql_fetch_object($cldate)){
	$cldate_res=mysql_fetch_object($cldate);				
									
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cldate_res->rpdate.',');
	
	// }
	$col++;							
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $visitcount_res->clid);
	$col++;	
	$row++;
	
	
	$i++;
}

	$col--;	
	
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totpr);
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
$row=$row-1;
$yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('F1:F'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->setTitle($repname_row["rep_name"]);
//prepare download
$filename="Product Report.xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$repname_row['rep_name'].' visit report".xls');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>