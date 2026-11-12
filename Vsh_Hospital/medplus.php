<?php
	// MEDPLUS - START
	
	require_once "Classes/PHPExcel/IOFactory.php";
	include("include/connect.php");
	ini_set('memory_limit', '-1');
	ini_set('upload_max_filesize', '1024M');
	ini_set('post_max_size', '1024M');
	ini_set('max_input_time', 300000000);
	ini_set('max_execution_time', 150000000);
	set_time_limit(0);
	error_reporting(E_ALL);
	$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
	$yuvaraj->setActiveSheetIndex(0);
	$_REQUEST["from_date"]=date("Y/m",strtotime($_REQUEST["from_date"]))."/01";
	$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, " MEDPLUS ".date("F Y",strtotime($_REQUEST["from_date"])));
	
	$col=0;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
	$col=1;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
	$col=2;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRICE");
	$col=3;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL Q");
	
	$col=4;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL PTS");
	
	$col=5;$row=3;
	$MedplusRep = mysql_query("SELECT rep_name FROM representative WHERE sales_credit>0 ORDER BY id");
	while($R = mysql_fetch_object($MedplusRep)){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name)." Q");
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name)." PTS");
		$col++;
	}
	// AMMA
	$col=0;	$row=4;
	$Medplus = mysql_query("SELECT areawise_temp.our_product_id,product.pro_name,product.packing,product.pts,SUM(areawise_temp.quantity) Q, SUM(areawise_temp.quantity*areawise_temp.pts) PTS FROM areawise_temp,product WHERE areawise_temp.rep_id='57' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') and areawise_temp.our_product_id=product.id and areawise_temp.our_product_id <> '' AND areawise_temp.our_cust_id <> '' group by areawise_temp.our_product_id");
	while($M = mysql_fetch_object($Medplus)){
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $M->pro_name);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $M->packing);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $M->pts);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $M->Q);
			$col++;			
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($M->PTS,0));
			$col++;
			
			$MedplusRep1 = mysql_query("SELECT sales_credit FROM representative WHERE sales_credit>0 ORDER BY id");
			while($R1= mysql_fetch_object($MedplusRep1)){
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($M->Q*($R1->sales_credit/100),0));
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(round($M->Q*$R1->sales_credit/100,2)*$M->pts,0));
				$col++;		
			}
			
			//$col++;
			$col=0;
			$row++;
	}
	$col=3;
	for($col=3;$col<=94;$col++){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
	}
	
	// AMMA
	
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
	
	
	$filename=" Medplus ".date("d/m/Y H:i:s").".csv"; //just some random filename
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
	$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
	 
	exit;
	
	// MEDPLUS - END
?>