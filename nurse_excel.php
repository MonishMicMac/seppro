<?php
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 300000000);
ini_set('max_execution_time', 150000000);
set_time_limit(0);
error_reporting(E_ALL);
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:E1','9d9b9b');
mytemplate_design_fcolor('A1:E1','FFFFFF');

// $repname=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST['repid']."' ");
// 	$repname_row=mysql_fetch_array($repname);

$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "NURSE LIST");
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "NURSE NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "PHONE NUMBER");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(20);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "GENDER");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(40);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "ADDRESS");
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');	
mytemplate_design_bg('A3:E3','eceeef');	

$row = 4;	
$i=1;
// 	if($_REQUEST['repid']=='')
// {
	// echo "SELECT * FROM doctors WHERE doctor_name!='' ";
	$a=mysql_query("SELECT *
	FROM nurse_details WHERE action!='1' ORDER BY id DESC ");
// else{
// $a=mysql_query("SELECT * FROM doctors WHERE doctor_name!='' AND rep_id='".@$_REQUEST['repid']."'  ")or die(mysql_error());
// }

while($y_customer=mysql_fetch_object($a)){
	
	$sql1=mysql_query("SELECT area_name FROM pincode_list WHERE pin_id='".$y_customer->pin_id."' order by id asc limit 1");
	$row1=mysql_fetch_array($sql1);

	$col=0;
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer->nurse_name);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer->phone_no);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer->gender);
	$col++;						
							
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer->address);

	$row++;

	$i++;

}
// echo "hi";
// 	exit();
// echo "hi";
// exit();
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
// $yuvaraj->getActiveSheet()->getStyle('F1:F'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('G1:G'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('H1:H'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('I1:I'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('J1:J'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('K1:K'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('L1:L'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('M1:M'.$row)->applyFromArray($styleArray);

$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->getAlignment()->setWrapText(true); 
// if($_REQUEST['repid']=='')
// 	{
// 		}
// 		else{
// $yuvaraj->getActiveSheet()->setTitle($repname_row["rep_name"]);
// }
//prepare download
$filename="Customer List.xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
	// if($_REQUEST['repid']=='')
	// {
		header('Content-Disposition: attachment;filename="Nurselist".xls');

// 	}
// else
// {
// 	header('Content-Disposition: attachment;filename="'.$repname_row['rep_name'].'clientlist".xls');

// }
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>