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

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "STOCKIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "STOCKIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "CHEMIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "PINCODE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "AREA");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "CHEMIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "MR NAME");

$stockist_array=array();
$rep_id_array=array();
$OHQ = mysql_query("SELECT local_stockist,local_rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
while($OHQ_ROW = mysql_fetch_array($OHQ)){
	if($OHQ_ROW['local_stockist']!=''){
		$stockist_array[]=$OHQ_ROW['local_stockist'];
	}
	if($OHQ_ROW['local_rep_id']!=''){
		$rep_id_array[]=$OHQ_ROW['local_rep_id'];
	}
}
$stockist1=implode(",",$stockist_array);
$rep_id=implode(",",$rep_id_array);

$col=0;$row=2;	
$PRODUCT = mysql_query("SELECT id,pro_name FROM product");
while($Prod=mysql_fetch_object($PRODUCT)){ // PRODUCT
	$PRODUCTCNT = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id in (".$stockist1.") ");
	$ProdCNT=mysql_fetch_object($PRODUCTCNT);	
	if($ProdCNT->Q>0){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Prod->pro_name));
		$col++;	
		$Stockist_CNT = mysql_query("SELECT distributor.dis_name DNAME,areawise_temp.dist_id dist_id,sum(areawise_temp.quantity) Q,ifnull((select rep_name from representative where id=areawise_temp.rep_id),'vacant') as rep_name,cust_name,area_id,ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp,distributor WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id in (".$stockist1.") AND areawise_temp.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.dist_id,areawise_temp.rep_id,areawise_temp.our_cust_id order by areawise_temp.dist_id,areawise_temp.cust_name");
		while($Stockist=mysql_fetch_object($Stockist_CNT)){
			if($Stockist->Q>0){
				if($dist_id!=$Stockist->dist_id){
					$col=1;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->DNAME));		
					$col++;
					
					$sql_quan=mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp,distributor WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id='".$Stockist->dist_id."' AND areawise_temp.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.dist_id");
					$row_quan=mysql_fetch_object($sql_quan);

					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($row_quan->Q));
					$dist_id=$Stockist->dist_id;
				}

				$col=3;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->cust_name));		
				$col++;
				$AREA = mysql_query("SELECT pincode_list.pincode PINCODE,pincode_list.area_name AREA,master_district.district_name DISTNAME FROM pincode_list,master_district WHERE pincode_list.id=".$Stockist->area_id." AND pincode_list.dist_id=master_district.district_id");
				$A=mysql_fetch_object($AREA);
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $A->PINCODE);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($A->AREA).", ".strtoupper($A->DISTNAME));
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->Q));
				$col++;$totq=$totq+$Stockist->Q;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->PTS));
				$col++;$tot=$tot+$Stockist->PTS;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->rep_name));
				$row++;
			}
		}
		$col=5;
		$yuvaraj->getActiveSheet()->getStyle("F".$row.":H".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('F28A8B');
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT TOTAL");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totq);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot);	
		$row++;$col=0;	$totq=0;$tot=0;
	} // PRODUCT CNT
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