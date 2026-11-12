<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
	
$yuvaraj->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Customer ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Representative ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Division ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Distributor ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "Distributor Customer ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "Customer Name");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "State ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "District ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 1, "Area ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 1, "Pin ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, 1, "Pincode");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, 1, "Address");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, 1, "Contact No");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(14, 1, "Email ID");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(15, 1, "Customer License");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(16, 1, "validity");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(17, 1, "Status");

$yuvaraj->getActiveSheet()->setTitle("Distributor List");
$row = 2;	

		$SQL=mysql_query("SELECT id, our_cust_id, rep_id, division_id, distributor_id, dis_cust_id, customer_name, state_id, district_id, area_id, pin_id, pincode, address, contact_no, email_id, cust_license, validity, status FROM distributor_customer");
		while($RS=mysql_fetch_array($SQL)){
			$col=0;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["our_cust_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["rep_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["division_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["distributor_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["dis_cust_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["customer_name"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["state_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["district_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["area_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["pin_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["pincode"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["address"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["contact_no"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["email_id"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["cust_license"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["validity"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["status"]);
			$col++;	

			$row++;
			$i++;
		}


$yuvaraj->setActiveSheetIndex(1);
$yuvaraj->getActiveSheet(1)->setTitle("Pincode List");	

$yuvaraj->getActiveSheet(1)->getStyle('A1:G1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow(0, 1, "ID");
$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow(1, 1, "State ID");
$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow(2, 1, "State Name");
$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow(3, 1, "District ID");
$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow(4, 1, "Area Name");
$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow(5, 1, "Pin ID");
$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow(6, 1, "Pincode");

$yuvaraj->getActiveSheet(1)->setTitle("Pincode List");
$row = 2;	

		$SQL1=mysql_query("SELECT id, state_id, state_name, dist_id, area_name, pin_id, pincode FROM pincode_list");
		while($RS1=mysql_fetch_array($SQL1)){
			$col=0;
			$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow($col, $row, $RS1["id"]);
			$col++;	
			$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow($col, $row, $RS1["state_id"]);
			$col++;	
			$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow($col, $row, $RS1["state_name"]);
			$col++;	
			$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow($col, $row, $RS1["dist_id"]);
			$col++;	
			$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow($col, $row, $RS1["area_name"]);
			$col++;	
			$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow($col, $row, $RS1["pin_id"]);
			$col++;	
			$yuvaraj->getActiveSheet(1)->setCellValueByColumnAndRow($col, $row, $RS1["pincode"]);
			$col++;

			$row++;
			$i++;
		}

//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Manager : ".$customer11->rep_name.".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>