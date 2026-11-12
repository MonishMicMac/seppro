<?php

	require_once "Classes/PHPExcel/IOFactory.php";
	session_start();
	include("include/connect.php");
	ini_set('memory_limit', '-1'); 
	
	$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
	$yuvaraj->setActiveSheetIndex(0);
	
	$col=0;$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
	$col=1;$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PACKING");
	$col=2;$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PTS");
	$col=0;$row=3;
	$Product = mysql_query("SELECT id,pro_name,packing,pts FROM product");
	while($P = mysql_fetch_object($Product)){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($P->pro_name));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($P->packing));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($P->pts));
		$row++;
		$col=0;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
	$col = 3; $row = 1;$row1 = 3;$col1 = 3;
	$MASTER = mysql_query("SELECT group_concat(DISTINCT pin_id) Pincode,group_concat(DISTINCT dist_id) Stockist,ifnull(group_concat(DISTINCT rep_id),'Vacant') Rep,ifnull((select headquarters_name from representative,mst_headquarters where representative.id=areawise_temp.rep_id and representative.headquarter_id=mst_headquarters.headquarters_id and representative.headquarter_id>0),'VACANT') HQ FROM `areawise_temp` WHERE dist_id IN (SELECT dis_id FROM distributor WHERE headquarters_id IN (4)) and (bill_date between '2017/02/01' and '2017/02/28') AND rep_id NOT IN (10, 11, 12, 13, 14, 15, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32) and rep_id>0 group by HQ");	
	while($Y = mysql_fetch_object($MASTER)){
		$row = 1;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->HQ);
		$row++;
		$Stockist_id = explode(",",$Y->Stockist);		
		
		
		foreach($Stockist_id as $S){
			$row = 2;
			$Stockist = mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$S.") group by dis_id");
			$S1 = mysql_fetch_object($Stockist);			
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->dis_name);
			$col++;
		}
		$row = 1;
	}
	$col = 3;$row = 3;
	$ProductY = mysql_query("SELECT id FROM product");
	while($PY = mysql_fetch_object($ProductY)){
	$MASTER1 = mysql_query("SELECT group_concat(DISTINCT pin_id) Pincode,group_concat(DISTINCT dist_id) Stockist,ifnull(group_concat(DISTINCT rep_id),'Vacant') Rep,ifnull((select headquarters_name from representative,mst_headquarters where representative.id=areawise_temp.rep_id and representative.headquarter_id=mst_headquarters.headquarters_id and representative.headquarter_id>0),'VACANT') HQ FROM `areawise_temp` WHERE dist_id IN (SELECT dis_id FROM distributor WHERE headquarters_id IN (4)) and (bill_date between '2017/02/01' and '2017/02/28') AND rep_id NOT IN (SELECT GROUP_CONCAT(`id`) FROM `representative` WHERE `headquarter_id` IN (4)) and rep_id>0 group by HQ");	
	while($Y1 = mysql_fetch_object($MASTER1)){		
		$Stockist_id1 = explode(",",$Y1->Stockist);
		foreach($Stockist_id1 as $S1){
			$Product_Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE rep_id IN (".$Y1->Rep.") AND our_product_id = '".$PY->id."' AND dist_id IN (".$S1.") and (bill_date between '2017/02/01' and '2017/02/28')");
			$PS = mysql_fetch_object($Product_Sales);						
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PS->Q);
			$col++;
		}
	}$row++;$col = 3;
}
// TOTAL INFIL OUT
	$col = 3;
	$row = 181;
	$MASTER11 = mysql_query("SELECT group_concat(DISTINCT pin_id) Pincode,group_concat(DISTINCT dist_id) Stockist,ifnull(group_concat(DISTINCT rep_id),'Vacant') Rep,ifnull((select headquarters_name from representative,mst_headquarters where representative.id=areawise_temp.rep_id and representative.headquarter_id=mst_headquarters.headquarters_id and representative.headquarter_id>0),'VACANT') HQ FROM `areawise_temp` WHERE dist_id IN (SELECT dis_id FROM distributor WHERE headquarters_id IN (4)) and (bill_date between '2017/02/01' and '2017/02/28') AND rep_id NOT IN (SELECT GROUP_CONCAT(`id`) FROM `representative` WHERE `headquarter_id` IN (4)) and rep_id>0 group by HQ");	
	while($Y11 = mysql_fetch_object($MASTER11)){		
		$Stockist_id11 = explode(",",$Y11->Stockist);
		foreach($Stockist_id11 as $S11){
			$Product_Sales = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id IN (".$Y11->Rep.") AND dist_id IN (".$S11.") and (bill_date between '2017/02/01' and '2017/02/28')");
			$PS = mysql_fetch_object($Product_Sales);						
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PS->Q);
			$col++;
		}
	}

	
	
	//prepare download
	$filename="INFIL.csv"; //just some random filename
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
	$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
	 
	exit; //done.. exiting!
	

?>