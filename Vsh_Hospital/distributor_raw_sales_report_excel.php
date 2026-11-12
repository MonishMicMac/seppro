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

$_REQUEST["from_date"]=date("Y/m",strtotime($_REQUEST["from_date"]))."/01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);
$totq=0;$tot=0;

$HQ = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id = '".$_REQUEST["hq_name2"]."'");
$HQNAME = mysql_fetch_object($HQ);


//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");

$yuvaraj->setActiveSheetIndex(0);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "CHEMIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "PINCODE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "SUBAREA");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "MAINAREA");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "DISTRICT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "MR NAME");

$yuvaraj->getActiveSheet()->freezePane('A2');
$col=0;$row=2;

$Stockist_CNT = mysql_query("SELECT (SELECT DISTINCT distributor.dis_id FROM distributor WHERE distributor.dis_id=areawise_temp.`dist_id`) STOCKISTID, (SELECT DISTINCT distributor.dis_name FROM distributor WHERE distributor.dis_id=areawise_temp.`dist_id`) STOCKIST, IFNULL(SUM(quantity),0) Q FROM `areawise_temp` WHERE `dist_id` in (SELECT dis_id FROM distributor WHERE headquarters_id ='".$_REQUEST["hq_name2"]."') and (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') GROUP BY areawise_temp.dist_id ORDER BY areawise_temp.dist_id");
while($Stockist=mysql_fetch_object($Stockist_CNT)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->STOCKIST)." [ TOTAL Q : ".$Stockist->Q." ] ");		
	$col++;	
	$STK_CHY = mysql_query("SELECT cust_name CHEMIST, pincode PINCODE, IFNULL(SUM(quantity),0) Q FROM `areawise_temp` WHERE `dist_id` in (".$Stockist->STOCKISTID.") and (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') GROUP BY areawise_temp.dist_id,areawise_temp.cust_name,areawise_temp.pincode ORDER BY areawise_temp.dist_id,areawise_temp.cust_name");
	while($STKCHY=mysql_fetch_object($STK_CHY)){
		$col=1;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($STKCHY->CHEMIST)." [ TOTAL Q : ".$STKCHY->Q." ]");
		$col++;
		  $STK_CHY_DETAILS = mysql_query("SELECT pro_name PRODUCT, SUM(quantity) Q,`pincode` PINCODE,REPLACE(`area_name`,',','') SUBAREA,IFNULL((SELECT replace(pincode_list.area_name,',','') FROM pincode_list WHERE pincode_list.pin_id = areawise_temp.pin_id group by pincode_list.pin_id),0) MAINAREA,IFNULL((SELECT replace(master_district.district_name,',','') FROM master_district WHERE master_district.district_id = areawise_temp.district_id),0) DISTRICT,IFNULL((SELECT representative.rep_name FROM representative WHERE representative.id=areawise_temp.`rep_id`),'VACANT') MRNAME,rep_id,pin_id FROM `areawise_temp` WHERE pincode = '".$STKCHY->PINCODE."' AND `dist_id` in (".$Stockist->STOCKISTID.") and (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND cust_name='".$STKCHY->CHEMIST."' GROUP BY areawise_temp.pro_name ORDER BY areawise_temp.pro_name");	      
		while($STKCHYDETAILS=mysql_fetch_object($STK_CHY_DETAILS)){
			$col=2;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($STKCHYDETAILS->PRODUCT));
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $STKCHYDETAILS->Q);					
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $STKCHYDETAILS->PINCODE);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $STKCHYDETAILS->SUBAREA);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $STKCHYDETAILS->MAINAREA);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $STKCHYDETAILS->DISTRICT);
			$col++;
			 if($STKCHYDETAILS->rep_id>82){
	                $ASSUMESPIN = mysql_query("SELECT representative.rep_name FROM rep_area,representative WHERE rep_area.pin_id = ".$STKCHYDETAILS->pin_id." AND rep_area.rep_id=representative.id GROUP BY rep_area.pin_id");
	                $APCNT = mysql_num_rows($ASSUMESPIN);
	                if($APCNT>0){
	                    $AP = mysql_fetch_object($ASSUMESPIN);
	                    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $AP->rep_name);
	                }
	                if($APCNT==0){
	                    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "VACANT");
	                    $yuvaraj->getActiveSheet()->getStyle("A".$row.":I".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffd966');
	                }                
	                
	            }
	            if($STKCHYDETAILS->rep_id<=82){
	                $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($STKCHYDETAILS->MRNAME));
	            }
	            	
			// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($STKCHYDETAILS->MRNAME));
			// if($STKCHYDETAILS->MRNAME=='VACANT'){
			// 	$yuvaraj->getActiveSheet()->getStyle("A".$row.":I".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffd966');
			// }
			$row++;
		}				
		$row++;
	}
	$row++;
}

//prepare download
$filename=strtoupper($HQNAME->headquarters_name)." HQ STOCKISTWISE RAW SALES STATEMENTS".date("d/m/Y H:i:s").".csv"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>