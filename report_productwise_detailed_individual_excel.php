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

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Capital");
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:J1','9d9b9b');
mytemplate_design_fcolor('A1:J1','FFFFFF');

$baba = mysql_query("SELECT SUM(quantity) AS SQTY, SUM(free_quantity) AS SFQTY, SUM(replace_quantity) AS SRQTY,SUM(quantity*ptr) AS TOTPTR, SUM(quantity*pts) AS TOTPTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND our_product_id = '".$SREEP->id."' AND rep_id>0 GROUP BY our_product_id")or die(mysql_error());$customer11=mysql_fetch_object($baba);

$yuvaraj->getActiveSheet()->mergeCells('A2:J2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Product : ".$_REQUEST["product_name"]." / [ PTR : ".round($customer11->TOTPTR,2)." PTS : ".round($customer11->TOTPTS,2)." ] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:J2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:J3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Product Wise Individual Report");
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "REP NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(10);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "PINCODE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(50);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "CUSTOMER");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "BATCH");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "DISTRIBUTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "F");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "R");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "PTR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 4, "PTS");
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:J4','eceeef');	

$row = 5;	

       $a=mysql_query("SELECT rep_id, SUM(quantity*ptr) AS PTR,SUM(quantity*pts) AS PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND our_product_id = '".$SREEP->id."' AND rep_id>0 GROUP BY rep_id");				
		while($YUVARAJ=mysql_fetch_object($a)){
		$SQL=mysql_query("SELECT rep_name FROM representative WHERE id=".$YUVARAJ->rep_id.""); $R=mysql_fetch_object($SQL);
				
		$col=0;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name));
		$col=1;
		$PIN=mysql_query("SELECT master_pincode.pincode AS PINCODE,master_pincode.pin_id AS pin_id  FROM areawise_temp,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY areawise_temp.rep_id, areawise_temp.pin_id");
		while($P=mysql_fetch_object($PIN)){
			$col=1;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$P->PINCODE); // PINCODE
			//$row++;
			$R=mysql_query("SELECT tbl_customer_master.shop_name AS cust_name,GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH,distributor.dis_name AS DID, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.replace_quantity) AS R,SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR,SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS FROM areawise_temp,tbl_customer_master,distributor,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.pin_id=".$P->pin_id." AND tbl_customer_master.id=areawise_temp.our_cust_id AND distributor.dis_id=areawise_temp.dist_id AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_cust_id");
             while($R1=mysql_fetch_object($R)){
			 	$col=2;
			 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,strtoupper($R1->cust_name));
				$col++;
			 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,strtoupper($R1->BATCH));
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,strtoupper($R1->DID));
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$R1->Q);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$R1->F);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$R1->R);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round($R1->PTR,2));
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round($R1->PTS,2));
				$row++;			 	
			 }
			 $col=2;	
			 $yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
			$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
				$title1 = array(
			'font' => array(
				'bold' => true,   
				'color' => array(
					'rgb' => '0030ff'
				),
			), 	    
			);
			$D=mysql_query("SELECT SUM(quantity) AS Q, SUM(free_quantity) AS F, SUM(replace_quantity) AS R,SUM(quantity*ptr) AS PTR,SUM(quantity*pts) AS PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND rep_id=".$YUVARAJ->rep_id." AND our_product_id = '".$SREEP->id."' AND pin_id=".$P->pin_id." GROUP BY our_product_id");
             $D1=mysql_fetch_object($D);
			 $yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title1);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"SUB TOTAL - ".$P->PINCODE);
			$col+=3;			
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$D1->Q);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$D1->F);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$D1->R);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round($D1->PTR,2));
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round($D1->PTS,2));		
			$row++;
		}
		$SQL1=mysql_query("SELECT rep_name FROM representative WHERE id=".$YUVARAJ->rep_id.""); $R1=mysql_fetch_object($SQL1);
		$col=2;
		 $yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
			$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
				$title2 = array(
			'font' => array(
				'bold' => true,   
				'color' => array(
					'rgb' => 'f41630'
				),
			), 	    
			);
		$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title2);	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"REP TOTAL - ".$R1->rep_name);
		$col+=6;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round($YUVARAJ->PTR,2));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round($YUVARAJ->PTS,2));			
		$row++;
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