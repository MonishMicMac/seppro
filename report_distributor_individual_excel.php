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

$yuvaraj->getActiveSheet()->mergeCells('A1:H1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Capital");
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');

$total=0;
$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id ='".$_REQUEST["dist_id"]."'"); $rd=mysql_fetch_object($sqld);
$a1=mysql_query("SELECT SUM(quantity) AS SQTY, SUM(free_quantity) AS SFQTY, SUM(replace_quantity) AS SRQTY, SUM(quantity*pts) AS TOTPTS, SUM(quantity*ptr) AS TOTPTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Distributor : ".$rd->dis_name." / [ PTR : ".round($customer11->TOTPTR,2)." PTS : ".round($customer11->TOTPTS,2)." ] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:I2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:I3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Distributor Wise Individual Report");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "BATCH");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "NO OF PINCODES COVERED");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "NO OF CUSTOMER COVERED");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "PTS S.Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "PTR S.Value");
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:I4','eceeef');	

$row = 5;	

       $DISTRIBUTOR=mysql_query("SELECT our_id FROM dist_prod WHERE dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_id");
		while($pid=mysql_fetch_object($DISTRIBUTOR)){
		
		
		$a=mysql_query("SELECT COUNT(DISTINCT(areawise_temp.pincode)) AS PIN, COUNT(DISTINCT(areawise_temp.our_cust_id)) AS CUST,product.pro_name AS PRODUCT, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, (SELECT sum(areawise_temp.quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS QTY, (SELECT sum(areawise_temp.free_quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS FQTY,(SELECT sum(areawise_temp.replace_quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS RQTY, (SELECT sum(quantity*ptr) FROM areawise_temp WHERE our_product_id='".$pid->our_id."' AND (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_product_id) AS PTR, (SELECT sum(quantity*pts) FROM areawise_temp WHERE our_product_id='".$pid->our_id."' AND (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_product_id) AS PTS FROM product,dist_prod,areawise_temp WHERE dist_prod.dist_id='".$_REQUEST["dist_id"]."' AND dist_prod.our_id=product.id AND product.id=areawise_temp.our_product_id AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' AND dist_prod.our_id='".$pid->our_id."' GROUP BY dist_prod.our_id,areawise_temp.our_product_id");
        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["PRODUCT"]);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["BATCH"]);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["PIN"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["CUST"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["QTY"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["FQTY"]);
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["RQTY"]);					
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["PTS"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["PTR"]);	
						
			
						$row++;
				}
				}
			# BABA - END
			$col=1;
			$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
				$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
					$title1 = array(
				'font' => array(
					'bold' => true,   
					'color' => array(
						'rgb' => 'FF0000'
					),
				), 	    
				);
				$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title1);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Total: ");	
			$col+=3;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SFQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SRQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->TOTPTS);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->TOTPTR);	
			$col=1;				
			//}
			//$row++;
			
		//}

	
		
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Distributor : ".$rd->dis_name." / [PTR : ".round($customer11->TOTPTR,2)." PTS : ".round($customer11->TOTPTS,2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>