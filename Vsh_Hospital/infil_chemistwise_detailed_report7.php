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

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(6);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "STOCKIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "STOCKIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "OTHER HQ");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "CHEMIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "PINCODE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "AREA");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "CHEMIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 1, "MR NAME");
$DCHEMIST = mysql_query("SELECT local_stockist Stockist FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]." GROUP BY headquarters_id");
$DCHY=mysql_fetch_object($DCHEMIST);

$rep_id_array=array();
$OHQ = mysql_query("SELECT rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
while($OHQ_ROW = mysql_fetch_array($OHQ)){
	if($OHQ_ROW['rep_id']!=''){
		$rep_id_array[]=$OHQ_ROW['rep_id'];
	}
}
$rep_id=implode(",",$rep_id_array);

$col=0;$row=2;	
$PRODUCT = mysql_query("SELECT id,pro_name FROM product");
while($Prod=mysql_fetch_object($PRODUCT)){ // PRODUCT
	$Stockist_CNT12017 = mysql_query("SELECT sum(areawise_temp.quantity) Q,ROUND(sum(areawise_temp.quantity*areawise_temp.pts),0) PTS FROM `areawise_temp` WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$DCHY->Stockist.") AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.")");$Prod2017=mysql_fetch_object($Stockist_CNT12017);

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Prod->pro_name)." [Q: ".$Prod2017->Q.", PTS:".$Prod2017->PTS."]");
	$col++;	
	$Stockist_CNT = mysql_query("SELECT distributor.dis_name DNAME,areawise_temp.dist_id dist_id,sum(areawise_temp.quantity) Q FROM `areawise_temp`,distributor WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$DCHY->Stockist.") AND `areawise_temp`.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.`dist_id`");
	while($Stockist=mysql_fetch_object($Stockist_CNT)){  // STOCKIST
		$col=1;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->DNAME));		
		$col++;		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->Q));
		$col++;	
		$DCHEMISTR11 = mysql_query("SELECT rep_id,infil_name FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]."");
		while($DCHYR1=mysql_fetch_object($DCHEMISTR11)){
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR1->Q));
			$col++;
			$col=3;
			$Stockist_CNT10 = mysql_query("SELECT sum(areawise_temp.quantity) Q FROM `areawise_temp` WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$Stockist->dist_id.") AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$DCHYR1->rep_id.")");
			while($DCHYR10=mysql_fetch_object($Stockist_CNT10)){
				if($DCHYR10->Q>0){
					$col=3;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR1->infil_name)." ".strtoupper($DCHYR10->Q));		
					$Stockist_CNT120 = mysql_query("SELECT ifnull((select rep_name from representative where id=areawise_temp.rep_id),'vacant') as rep_name,cust_name,area_id,sum(areawise_temp.quantity) Q,ROUND(sum(areawise_temp.quantity*areawise_temp.pts),0) PTS FROM `areawise_temp` WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$Stockist->dist_id.") AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$DCHYR1->rep_id.") GROUP BY cust_name,pincode");
					while($DCHYR120=mysql_fetch_object($Stockist_CNT120)){
						$col=4;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->cust_name));
						$col++;
						$AREA = mysql_query("SELECT pincode_list.pincode PINCODE,pincode_list.area_name AREA,master_district.district_name DISTNAME FROM pincode_list,master_district WHERE pincode_list.id=".$DCHYR120->area_id." AND pincode_list.dist_id=master_district.district_id");
						$A=mysql_fetch_object($AREA);
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($A->PINCODE));
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($A->AREA).", ".strtoupper($A->DISTNAME));
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->Q));
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->PTS));
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->rep_name));
						$row++;
					}		
					$col=3;
					$row++;
				}
				$col=3;
			}
		}
	}
	$col=0;
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