<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 150000);
//load Excel template file
//Worked Nirmal
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:C1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Be Well Hospitals - No 20 Maharaja Surya Road,Alwarpet Chennai-600018.date - ".date('Y-m-d'));
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:C1','9d9b9b');
mytemplate_design_fcolor('A1:C1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:C2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:C2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:C3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "LIST OF DOCTOR REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "DOCTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "PATIENT");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "CHEMIST");
$yuvaraj->getActiveSheet()->getStyle('A4:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:C3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:C3','eceeef');	

$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);


$row = 5;	
$num=4;
$i=1;
$a=mysql_query("select doctor_id,group_concat(chemist_id) as chemist,rep_id,cdatee from patientvisit where `rep_id`='".$_REQUEST["representative"]."' AND `cdatee` BETWEEN '".date('Y-m-d',strtotime($_REQUEST["from_date"]))."' AND '".date('Y-m-d',strtotime($_REQUEST["to_date"]))."' group by `doctor_id`");
$num_rows=mysql_num_rows($a);

$num=$num+$num_rows;
$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);

while($y_customer=mysql_fetch_assoc($a)){

	$DR=mysql_query("SELECT * from doctors WHERE id='".$y_customer['doctor_id']."'");
	$doctors=mysql_fetch_array($DR);
	$chem=$y_customer['chemist'];
	$count_patients=mysql_query("SELECT COUNT(*) AS count FROM doctors WHERE id IN($chem)");
	$patients=mysql_fetch_array($count_patients);	
	$col=0;
	$row_1 = 1;	
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $doctors["doctor_name"]);						
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $patients["count"]);						
	$col++;						
					// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["C"].'('.$y_customer["chem_count"].')');

	$row++;
	$i++;
}


$objWorkSheet='';
$j=1;
$a=mysql_query("select doctor_id,group_concat(chemist_id) as chemist,rep_id,cdatee from patientvisit where `rep_id`='".$_REQUEST["representative"]."' AND `cdatee` BETWEEN '".date('Y-m-d',strtotime($_REQUEST["from_date"]))."' AND '".date('Y-m-d',strtotime($_REQUEST["to_date"]))."' group by `doctor_id`");
while($y_customer=mysql_fetch_array($a)){	
	$DR=mysql_query("SELECT * from doctors WHERE id='".$y_customer['doctor_id']."'");
	$doctors=mysql_fetch_array($DR);	
	$col=0;
	$row_1 = 4;	

	$objWorkSheet=$yuvaraj->createSheet($j);

	$objWorkSheet->mergeCells('A1:H1');

	$objWorkSheet->setCellValueByColumnAndRow(0, 1, "Be Well Hospitals - No 20 Maharaja Surya Road,Alwarpet Chennai-600018.date - ".date('Y-m-d'));
	$objWorkSheet->getStyle('A1:H1')->getFont()->setBold(true);
	$objWorkSheet->getRowDimension(1)->setRowHeight(17);
	$objWorkSheet->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objWorkSheet->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	mytemplate_design_bg('A1:H1','9d9b9b');
	mytemplate_design_fcolor('A1:H1','FFFFFF');

	$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["representative"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

	$objWorkSheet->mergeCells('A2:H2');
	$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])));
	$objWorkSheet->getStyle('A2:H2')->getFont()->setSize(10);
	$objWorkSheet->getStyle('A2:H2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:H2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:H2','0e7cd8');

					$objWorkSheet->mergeCells('A3:H3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "LIST OF DOCTOR REPORT");
					$objWorkSheet->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:H3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');	

					$num1=5;
					$s_no1=1;

					$SQL=mysql_query("SELECT tbl_customer_master.shop_name,tbl_customer_master.customer_address,tbl_customer_master.landlineno,tbl_customer_master.owner_name,tbl_customer_master.mobile_no,patientvisit.cdatee,patientvisit.doctor_id FROM `tbl_customer_master`,patientvisit WHERE tbl_customer_master.`id`=patientvisit.chemist_id AND patientvisit.doctor_id='".$y_customer['doctor_id']."' AND patientvisit.`cdatee` BETWEEN '".date('Y-m-d',strtotime($_REQUEST["from_date"]))."' AND '".date('Y-m-d',strtotime($_REQUEST["to_date"]))."' GROUP BY patientvisit.`doctor_id` , patientvisit.`cdatee`,patientvisit.chemist_id");
					$num_rows1=mysql_num_rows($SQL);


					if($num_rows1 > 0){
						
						$num1=$num1+$num_rows1;
						$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('F1:F'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('G1:G'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('H1:H'.$num1)->applyFromArray($styleArray);

						$objWorkSheet->mergeCells('A'.$row_1.':H'.$row_1);
						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $doctors["doctor_name"]." - PATIENT LIST");
						$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getFont()->setSize(13);
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_fcolor('A'.$row_1.':H'.$row_1,'317eac');
						$row_1++;

						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(12);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(25);	
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(12);
						$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(7)->setWidth(34);

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "DATE");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "CLIENT NAME");
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "PATIENTS");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "AGE");
						$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "PATIENT UHID");
						$objWorkSheet->setCellValueByColumnAndRow(6, $row_1, "MOBILE NO");
						$objWorkSheet->setCellValueByColumnAndRow(7, $row_1, "ADDRESS");

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objWorkSheet->getStyle('A'.$row_1.':H'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('A'.$row_1.':H'.$row_1,'eceeef');	
						$row_1++;
					}
					while ($row1=mysql_fetch_array($SQL)) {

						$count_patients5=mysql_query("SELECT * FROM doctors WHERE id='".$y_customer['doctor_id']."' ");
						$patients5=mysql_fetch_array($count_patients5);	

						$col_1 = 0;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, date('d-m-Y',strtotime($row1['cdatee'])));
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $patients5['doctor_name']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['shop_name']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['mobile_no']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['owner_name']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['landlineno']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['customer_address']);
						$col_1++;
						$s_no1++;
						$row_1++;
					}

					$objWorkSheet->setTitle($doctors["doctor_name"]);
					$j++;
				}
				$yuvaraj->setActiveSheetIndex(0);


//prepare download
$filename="Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])).".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>