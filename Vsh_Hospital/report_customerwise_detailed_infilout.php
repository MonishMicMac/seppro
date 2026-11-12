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

$_REQUEST["hq_name"] = 4;


$_REQUEST["from_date"]="2017/01/01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);
$totq=0;$tot=0;


function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}
$HQNAME = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id='".$_REQUEST["hq_name"]."'");
$HQN = mysql_fetch_object($HQNAME);
$HEADQUARTERNAME = strtoupper($HQN->headquarters_name);

$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);
$yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAMEERODE INFIL OUT CHEMISTWISE DETAILS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAMEERODE INFIL OUT CHEMISTWISE DETAILS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "HQ");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "PINCODE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "CHEMIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "STOCKIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 2, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 2, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 2, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 2, "MR NAME");
 $col = 0; $row = 3;
 $MASTER = mysql_query("SELECT group_concat(DISTINCT pin_id) Pincode,ifnull(group_concat(DISTINCT rep_id),'Vacant') Rep,group_concat(DISTINCT dist_id) Stockist, ifnull((select headquarters_name from distributor,mst_headquarters where distributor.dis_id=areawise_temp.dist_id and distributor.headquarters_id=mst_headquarters.headquarters_id),'VACANT') HQ, sum(quantity) Q, round(sum(quantity*pts),0) PTS FROM `areawise_temp` WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') and dist_id NOT IN (SELECT `dis_id` FROM `distributor` WHERE `headquarters_id` IN (".$_REQUEST["hq_name"].")) AND rep_id IN (SELECT `id` FROM `representative` WHERE `headquarter_id` IN (".$_REQUEST["hq_name"]."))group by HQ HAVING sum(quantity) > 0");
	while($Y = mysql_fetch_object($MASTER)){
		$HQTOTAL = mysql_query("SELECT round(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$Y->Stockist.") AND rep_id IN (".$Y->Rep.") and (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') ");
		$HQTOTALY = mysql_fetch_object($HQTOTAL);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->HQ." [ TOTAL SALE : ".$HQTOTALY->PTS." ]");
		$col++;
		$PIN_ID = explode(",",$Y->Pincode);
		foreach($PIN_ID as $PINID){
			$col = 1;
			$PINCODE_DETAILS = mysql_query("SELECT pincode_list.pincode,pincode_list.area_name,master_district.district_name FROM pincode_list,master_district WHERE pincode_list.pin_id = ".$PINID." and pincode_list.dist_id=master_district.district_id GROUP BY pincode_list.pin_id");
			$PINCODEDETAILS = mysql_fetch_object($PINCODE_DETAILS);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PINCODEDETAILS->pincode." [ ".strtoupper($PINCODEDETAILS->area_name).", ".strtoupper($PINCODEDETAILS->district_name)." ]");
			$col++;
								
			// Chemist
			$CHEMIST_DETAILS = mysql_query("SELECT cust_name,our_cust_id,sum(quantity) Q, round(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND pin_id = ".$PINID." AND rep_id IN (".$Y->Rep.") AND dist_id IN (".$Y->Stockist.") group by our_cust_id,pin_id");
			while($CHEMISTDETAILS=mysql_fetch_object($CHEMIST_DETAILS)){
				$col = 2;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($CHEMISTDETAILS->cust_name)." [ Q : ".$CHEMISTDETAILS->Q.", PTS : ".$CHEMISTDETAILS->PTS." ] ");
				$col++;
				$STOCKIST_DETAILS = mysql_query("SELECT areawise_temp.dist_id,distributor.dis_name FROM areawise_temp,distributor WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.pin_id = ".$PINID." AND areawise_temp.our_cust_id IN (".$CHEMISTDETAILS->our_cust_id.") AND areawise_temp.rep_id IN (".$Y->Rep.") AND areawise_temp.dist_id IN (".$Y->Stockist.") AND areawise_temp.dist_id=distributor.dis_id group by areawise_temp.dist_id");
				while($STOCKISTDETAILS=mysql_fetch_object($STOCKIST_DETAILS)){
					$col = 3;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($STOCKISTDETAILS->dis_name));
					$col++;
					
					$PRODUCT_DETAILS = mysql_query("SELECT (SELECT pro_name FROM product WHERE product.id=areawise_temp.our_product_id) PNAME,sum(quantity) Q, round(SUM(quantity*pts),0) PTS,(SELECT rep_name FROM representative WHERE representative.id=areawise_temp.rep_id) REP FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.pin_id = ".$PINID." AND areawise_temp.our_cust_id IN (".$CHEMISTDETAILS->our_cust_id.") AND areawise_temp.rep_id IN (".$Y->Rep.") AND areawise_temp.dist_id IN (".$STOCKISTDETAILS->dist_id.") group by areawise_temp.our_product_id,areawise_temp.our_cust_id,areawise_temp.pin_id");
					while($PRODUCTDETAILS=mysql_fetch_object($PRODUCT_DETAILS)){
						$col = 4;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($PRODUCTDETAILS->PNAME));
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PRODUCTDETAILS->Q);
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PRODUCTDETAILS->PTS);
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($PRODUCTDETAILS->REP));
						$row++;
					}				
					//$row++;
				}
				
				$row++;$col = 2;
			}						
			$row++;$col = 1;
						
		}
		$row++;$col = 0;
	}




//prepare download
$filename=" Daily_Sales_Report ".date("d/m/Y H:i:s").".csv"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>