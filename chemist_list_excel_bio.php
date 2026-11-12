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
	$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);
	$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	mytemplate_design_bg('A1:E1','9d9b9b');
	mytemplate_design_fcolor('A1:E1','FFFFFF');

	$repname=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST['repid']."' ");
		$repname_row=mysql_fetch_array($repname);

	$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $repname_row['rep_name'].'_'."CHEMIST LIST REPORT");
	$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
	$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
	$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "REPRESENTATIVE NAME");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(30);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "SHOP NAME");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(30);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "PINCODE");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(25);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "DOCTOR NAME");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(20);
	
	$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
	$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
	$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$yuvaraj->getActiveSheet()->freezePane('A4');	
	mytemplate_design_bg('A3:E3','eceeef');	

	$row = 4;	
	$i=1;

	if (empty($_REQUEST['repid'])) {
        $promoters_data = mysql_query("SELECT tbl_customer_master.*, doctors.doctor_name, doctors.doc_pincode, doctors.rep_id, representative.rep_name, representative.id as ids FROM tbl_customer_master 
            LEFT JOIN doctors ON tbl_customer_master.doctor_id = doctors.id
            LEFT JOIN representative ON tbl_customer_master.rep_id = representative.id");
    } else {
        // Note the correction in the WHERE clause
        $repId = $_REQUEST['repid']; // Avoid SQL injection by sanitizing user input
        $promoters_data = mysql_query("SELECT tbl_customer_master.*, doctors.doctor_name, doctors.doc_pincode, doctors.rep_id, representative.rep_name, representative.id as ids FROM tbl_customer_master 
            LEFT JOIN doctors ON tbl_customer_master.doctor_id = doctors.id
            LEFT JOIN representative ON tbl_customer_master.rep_id = representative.id
            WHERE tbl_customer_master.rep_id = '$repId'");
    }
    
    $i = 1; // Initialize $i
    
    while ($y_customer = mysql_fetch_assoc($promoters_data)) {
        $col = 0;
        $yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
        $col++;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["rep_name"]);
        $col++;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["shop_name"]);
        $col++;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["doc_pincode"]);
        $col++;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["doctor_name"]);
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
	$yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);

	$full_name = $repname_row["rep_name"];

	$name_place=	explode('(', $full_name);

	$name_part_exp = explode(' ', $name_place[0]);

	$name = $name_part_exp[0];

	$place = str_replace(")","",$name_place[1]);

	$rep_name_new = $name . '-'. $place ;

	$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->getAlignment()->setWrapText(true); 
	if($_REQUEST['repid']=='')
	{

	}else{
		// $yuvaraj->getActiveSheet()->setTitle($repname_row["rep_name"]);
		$yuvaraj->getActiveSheet()->setTitle($rep_name_new);
	}

	

	//prepare download
	$filename="Chemist List.xls"; //just some random filename
	header('Content-Type: application/vnd.ms-excel');
	if($_REQUEST['repid']=='')
	{
		header('Content-Disposition: attachment;filename="chemistlist".xls');
	}
	else
	{
		header('Content-Disposition: attachment;filename="'.$repname_row['rep_name'].'chemistlist".xls');

	}
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
	$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
	
	exit; //done.. exiting!

?>