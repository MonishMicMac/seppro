<?php
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
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, " REPWISE CUSTOMER LIST ");
	
	$col=0;$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PINCODE");
	$col=1;$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
	$col=2;$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CHEMIST");
	
	$CONSOLIDATE = mysql_query("SELECT COUNT(DISTINCT our_cust_id) CUSTOMER,COUNT(DISTINCT pincode) PINCODE,COUNT(DISTINCT dist_id) STOCKIST  FROM areawise_temp WHERE rep_id='".$_REQUEST["rep_name"]."' AND our_cust_id<>''");
	$C = mysql_fetch_object($CONSOLIDATE);
	$col=0;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C->PINCODE);
	$col=1;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C->STOCKIST);
	$col=2;$row=3;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C->CUSTOMER);
	
	$col=0;$row=4;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PINCODE");
	$col=1;$row=4;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
	$col=2;$row=4;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CHEMIST");
	$col=0;$row=5;
	
	$CONSOLIDATEDETAILS = mysql_query("SELECT COUNT(DISTINCT our_cust_id) CUSTOMER,pincode,COUNT(DISTINCT dist_id) STOCKIST FROM areawise_temp WHERE rep_id='".$_REQUEST["rep_name"]."' GROUP BY pincode ORDER BY pincode");
	while($CDETAILS = mysql_fetch_object($CONSOLIDATEDETAILS)){	
		$col=0;
		$AREA = mysql_query("SELECT pincode_list.pincode PINCODE,pincode_list.area_name AREA,master_district.district_name DISTNAME FROM pincode_list,master_district WHERE pincode_list.pincode=".$CDETAILS->pincode." AND pincode_list.dist_id=master_district.district_id GROUP BY pincode_list.pincode");
		$A=mysql_fetch_object($AREA);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CDETAILS->pincode." - ".strtoupper($A->AREA).", ".strtoupper($A->DISTNAME)." [ CHY : ".$CDETAILS->CUSTOMER." / STK : ".$CDETAILS->STOCKIST." ] ");
		$col++;
		$REPPINSTOCKIST = mysql_query("SELECT areawise_temp.dist_id,distributor.dis_name FROM areawise_temp,distributor WHERE rep_id='".$_REQUEST["rep_name"]."' AND areawise_temp.pincode = '".$CDETAILS->pincode."' AND areawise_temp.dist_id=distributor.dis_id GROUP BY areawise_temp.pincode,areawise_temp.dist_id ORDER BY areawise_temp.pincode");
		while($REPPINSTK = mysql_fetch_object($REPPINSTOCKIST)){
			$col=1;		
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($REPPINSTK->dis_name));
			$col++;
			$REPPINCHEMIST = mysql_query("SELECT tbl_customer_master.shop_name FROM areawise_temp,tbl_customer_master WHERE areawise_temp.rep_id='".$_REQUEST["rep_name"]."' AND areawise_temp.pincode = '".$CDETAILS->pincode."' AND areawise_temp.dist_id='".$REPPINSTK->dist_id."' AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_cust_id ORDER BY tbl_customer_master.shop_name");
			while($REPPINCHY = mysql_fetch_object($REPPINCHEMIST)){
				$col=2;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($REPPINCHY->shop_name));
				$row++;
			}
			$row++;
		}
		
		
		/*$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CDETAILS->CUSTOMER);
		$row++;	*/
	}		
	
	$filename=" REPWISE CUSTOMER LIST ".date("d/m/Y H:i:s").".csv"; //just some random filename
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
	$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
	 
	exit;
	
?>