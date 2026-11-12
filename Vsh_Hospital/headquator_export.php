<?php
 
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");

// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 
// Initialise the Excel row number

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Pincode");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Rep Name");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Division Customer");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Distributor");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Customer");


$rowCount = 2; 


$heq=$_REQUEST['hq_name'];
$repa = mysql_query("SELECT GROUP_CONCAT(`id`) as sid FROM `representative` WHERE `headquarter_id` = $heq");
$rep_rows = mysql_fetch_array($repa);
$repID = $rep_rows['sid'];

$cust_mst = mysql_query("SELECT `pincode`, id,rep_id FROM `tbl_customer_master` WHERE `rep_id` IN ($repID) and pincode !=0 and pincode !='' ORDER BY pincode ASC");

while($cust_row = mysql_fetch_array($cust_mst)) :

    $fd = $cust_row['id'];
    $cid = explode(",", $fd);  
    $pin_code = $cust_row['pincode'];

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $pin_code); 

     $rep_ch = mysql_query("SELECT rep_name  FROM `representative` where id = ".$cust_row['rep_id']."");
     $rep_ch_row = mysql_fetch_array($rep_ch);

    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $rep_ch_row['rep_name']); 

    foreach($cid as $sid) :
      $cust_ch = mysql_query("SELECT shop_name  FROM `tbl_customer_master` where id = $sid");
      $cust_ch_row = mysql_fetch_array($cust_ch);
     $cust_ch_row['shop_name'];
     $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $cust_ch_row['shop_name']); 
      $dist_cust = mysql_query("SELECT b.dis_name as dis_name,a.`customer_name` as customer_name,a.id as id FROM `distributor_customer` a LEFT JOIN distributor b ON a.distributor_id=b.dis_id WHERE `our_cust_id`=$sid");
        while($distrow=mysql_fetch_array($dist_cust)) :

   $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$distrow['dis_name']); 

    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$distrow['customer_name']);

        endwhile;
    endforeach;
$rowCount++; 
endwhile;

// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
// Write the Excel file to filename some_excel_file.xlsx in the current directory

$hq = mysql_query("SELECT headquarters_name FROM `mst_headquarters` WHERE `headquarters_id` = $heq");
$hq_rows = mysql_fetch_array($hq);
$filename = $hq_rows['headquarters_name'].".xls";

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$filename.'"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

 
?>