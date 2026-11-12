<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$baba1 = mysql_query("SELECT id FROM product WHERE pro_name='".$_REQUEST["product_name"]."'"); $SREEP = mysql_fetch_object($baba1);

$yuvaraj->getActiveSheet()->mergeCells('A1:H1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');

$baba = mysql_query("SELECT SUM(areawise_temp.quantity) AS SQTY, SUM(areawise_temp.free_quantity) AS SFQTY, SUM(areawise_temp.replace_quantity) AS SRQTY,SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id GROUP BY areawise_temp.our_product_id")or die(mysql_error());$customer11=mysql_fetch_object($baba);

$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Distributor : ".$_REQUEST["product_name"]." / [ PTR : ".round($customer11->TOTPTR,2)." PTS : ".round($customer11->TOTPTS,2)." ] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:I2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:I3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Product Wise Individual Report");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "REP NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "NO OF PINCODES COVERED");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "NO OF CUSTOMER COVERED");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "PTR S.Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "PTS S.Value");
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:I4','eceeef');	

$row = 5;	

        $a=mysql_query("SELECT  count(DISTINCT(areawise_temp.pin_id)) AS PIN,count(DISTINCT(areawise_temp.our_cust_id)) AS CUST, areawise_temp.rep_id AS RNAME,  areawise_temp.rep_id AS RID, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY,SUM(areawise_temp.quantity*product.ptr) AS YPTR, SUM(areawise_temp.quantity*product.pts) AS YPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id AND areawise_temp.rep_id>0 GROUP BY areawise_temp.our_product_id, areawise_temp.rep_id")or die(mysql_error());
        while($y_customer=mysql_fetch_assoc($a)){
		$SQL = mysql_query("SELECT rep_name FROM representative WHERE id='".$y_customer["RNAME"]."'");
		$RS = mysql_fetch_object($SQL);
				
		$col=0;
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS->rep_name);
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
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["YPTR"]);						
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["YPTS"]);
					$row++;
				}
				
			# BABA - END
			$col=0;
               $a1=mysql_query("SELECT  count(DISTINCT(areawise_temp.pin_id)) AS PIN,count(DISTINCT(areawise_temp.our_cust_id)) AS CUST, areawise_temp.rep_id AS RNAME,  areawise_temp.rep_id AS RID, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY,SUM(areawise_temp.quantity*product.ptr) AS YPTR, SUM(areawise_temp.quantity*product.pts) AS YPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id AND areawise_temp.rep_id=0 GROUP BY areawise_temp.our_product_id");
        $y_customer1=mysql_fetch_assoc($a1);
                        
			$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Vacant / Unassigned");
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["PIN"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["CUST"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["QTY"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["FQTY"]);
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["RQTY"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["YPTR"]);						
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["YPTS"]);
					$row++;
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
			$col+=2;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SFQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SRQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($customer11->TOTPTR,2));
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round($customer11->TOTPTS,2));	
			$col=1;				
			//}
			//$row++;
			
		//}

	
		
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Product : ".$_REQUEST["product_name"]." / [PTR : ".round($customer11->TOTPTR,2)." PTS : ".round($customer11->TOTPTS,2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>