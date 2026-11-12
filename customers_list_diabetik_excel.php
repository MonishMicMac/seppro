<?php
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
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
$yuvaraj->getActiveSheet()->mergeCells('A1:I1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');

$repname=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST['repid']."' ");
	$repname_row=mysql_fetch_array($repname);

$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $repname_row['rep_name'].'_'."CUSTOMER LIST REPORT");
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DR NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "CNT NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "EMAIL");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "HOSPITAL NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "ADDRESS");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "PINCODE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(7)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "TYPE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(8)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "NEW/EX");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');	
mytemplate_design_bg('A3:I3','eceeef');	

$row = 4;	
$i=1;
	if($_REQUEST['repid']=='')
{
	$a=mysql_query("SELECT * FROM clinetcreation WHERE 1 ")or die(mysql_error());
}
else{
$a=mysql_query("SELECT * FROM clinetcreation WHERE 1 AND repid='".@$_REQUEST['repid']."'")or die(mysql_error());
}

while($y_customer=mysql_fetch_assoc($a)){
	
	$col=0;
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["name"]);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["mobileno"]);
	$col++;							
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["emailid"]);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["companyname"]);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["address"].','.$y_customer["Addrtess_line1"].','.$y_customer["Addrtess_line2"]);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["pincode"]);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["type"]);
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["typeofcustomer"]);
	$col++;	
	$row++;

	$i++;
}
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
$row=$row-1;
$yuvaraj->getActiveSheet()->getStyle('A1:I'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('F1:F'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('G1:G'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('H1:H'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('I1:I'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('J1:J'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('K1:K'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('L1:L'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('I1:M'.$row)->applyFromArray($styleArray);

$yuvaraj->getActiveSheet()->getStyle('I1:I'.$row)->getAlignment()->setWrapText(true); 
if($_REQUEST['repid']=='')
	{
		}
		else{
$yuvaraj->getActiveSheet()->setTitle($repname_row["rep_name"]);
}
//prepare download
$filename="Customer List.xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
	if($_REQUEST['repid']=='')
	{
		header('Content-Disposition: attachment;filename="clientlist".xls');

	}
else
{
	header('Content-Disposition: attachment;filename="'.$repname_row['rep_name'].'clientlist".xls');

}
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>