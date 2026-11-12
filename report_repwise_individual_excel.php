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

$yuvaraj->getActiveSheet()->mergeCells('A1:H1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:J1','9d9b9b');
mytemplate_design_fcolor('A1:J1','FFFFFF');

$sv=0;
$total=0;
$rep1 = explode("-",$_REQUEST["rep"]);	
$rep_sqls1=mysql_query("SELECT id,rep_name FROM representative WHERE id = '".$_REQUEST["rep"]."' ");
$r1=mysql_fetch_object($rep_sqls1);
$a1=mysql_query("SELECT SUM(quantity*ptr) AS PTR, SUM(quantity*pts) AS PTS FROM areawise_temp WHERE rep_id = ".$r1->id." AND our_cust_id<>'' AND our_product_id<>'' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')")or die(mysql_error());$customer11=mysql_fetch_assoc($a1);
$yuvaraj->getActiveSheet()->mergeCells('A2:J2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".strtoupper($r1->rep_name)." / [Total : ".round($customer11["PTR"],2)." PTS ".round($customer11["PTS"],2)."] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:J2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:J3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Representative Wise Individual Report");
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(10);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PINCODE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->getStyle('B5:B65536')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "PRODUCT");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "CUSTOMER NAME");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "BATCH");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(30);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "DISTRIBUTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "PTR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 4, "PTS");
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:J4','eceeef');		

$row = 5;
$rep = explode("-",$_REQUEST["rep"]);	
			$rep_sqls=mysql_query("SELECT id FROM representative WHERE id = '".$_REQUEST["rep"]."' ");
			$r=mysql_fetch_object($rep_sqls);
			
        $a=mysql_query("SELECT master_pincode.pincode AS PINCODE, areawise_temp.pin_id AS PIN, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR,SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS FROM areawise_temp,master_pincode WHERE rep_id=".$r->id." AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id<>'' AND our_product_id<>'' AND master_pincode.pin_id=areawise_temp.pin_id GROUP BY areawise_temp.pin_id ")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){
		$col=0;
		
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer->PINCODE);
			
			$sql = mysql_query("SELECT product.pro_name AS PRODNAME, product.id AS PID FROM areawise_temp,product WHERE rep_id=".$r->id." AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id<>'' AND our_product_id<>'' AND areawise_temp.our_product_id=product.id AND areawise_temp.pin_id='".$customer->PIN."'  GROUP BY areawise_temp.our_product_id");
			while($baba=mysql_fetch_assoc($sql)){
				$col=1;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $baba["PRODNAME"]);
				
				
				
				$subtotal = 0; $sql_customer = "SELECT tbl_customer_master.shop_name AS CNAME, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, areawise_temp.our_cust_id AS CID, (SELECT dis_name FROM distributor WHERE dis_id=areawise_temp.dist_id) AS DID,  areawise_temp.pincode as PIN, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.replace_quantity) AS R, SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.quantity*areawise_temp.ptr) AS CPTR, SUM(areawise_temp.quantity*areawise_temp.pts) AS CPTS FROM areawise_temp,product,tbl_customer_master WHERE areawise_temp.rep_id = ".$r->id." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$baba["PID"]."' AND areawise_temp.pin_id='".$customer->PIN."' AND product.id='".$baba["PID"]."' AND tbl_customer_master.id=areawise_temp.our_cust_id GROUP BY our_cust_id"; $rs_customer = mysql_query($sql_customer);
				
				$cnt1=mysql_num_rows($rs_customer);
				
				$yuvaraj->getActiveSheet()->mergeCells("B".($row+0).":B".($row+$cnt1));
				$yuvaraj->getActiveSheet()->getStyle("B".($row+0).":B".($row+$cnt1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$yuvaraj->getActiveSheet()->getStyle("B".($row+0).":B".($row+$cnt1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				while($y_customer=mysql_fetch_assoc($rs_customer)){
					$col=2;
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["CNAME"]);
					$col++;					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["BATCH"]);
					$col++;					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["DID"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["Q"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["F"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["R"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["CPTR"]);						
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["CPTS"]);
						
					
				$yuvaraj->getActiveSheet()->mergeCells("A".($row+0).":A".($row+2));
				$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$row++;
				}
				$col=2;
				$sql_customer1 = "SELECT SUM(quantity) AS YQTY, SUM(free_quantity) AS YFQTY, SUM(replace_quantity) AS YRQTY, SUM(quantity*pts) AS YPTS, SUM(quantity*ptr) AS YPTR FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND rep_id = ".$r->id." AND our_product_id='".$baba["PID"]."' AND pin_id='".$customer->PIN."' AND our_cust_id   != '' AND our_product_id   != '' GROUP BY our_product_id"; $rs_customer1 = mysql_query($sql_customer1); 
			while($y_customer1=mysql_fetch_assoc($rs_customer1)){
				$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
				$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
					$title1 = array(
				'font' => array(
					'bold' => true,   
					'color' => array(
						'rgb' => '0e7cd8'
					),
				), 	    
				);
				$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title1);
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sub Total");
				$col+=3;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer1["YQTY"]);
				$col++;	
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $y_customer1["YFQTY"]);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $y_customer1["YRQTY"]);
				$col++;	
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $y_customer1["YPTR"]);
				$col++;	
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $y_customer1["YPTS"]);
				}
				$col=1;				
				$row++;
				}
			$col++;
				$col=2;
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
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "PINCODE Total: ".$customer->PINCODE);	
				$col+=6;
				/*$sqlnet=mysql_query("SELECT SUM(sale_value) AS SV, SUM(net_amount) AS NETAMT FROM areawise_temp WHERE pro_name = '".$customer["pro_name"]."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND Pincode IN (SELECT pincode_list.pincode FROM pincode_list WHERE pincode_list.pin_id IN (SELECT rep_area.pin_id FROM rep_area WHERE rep_id = ".$r->id.") GROUP BY pincode_list.pincode) GROUP BY areawise_temp.pro_name");
		 $yuvaraj1=mysql_fetch_assoc($sqlnet);*/				
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer->PTR);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer->PTS);				
			
			$row++;
			
		}

//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$_REQUEST["rep"]." / [PTR : ".round($customer11["PTR"],2)." PTS : ".round($customer11["PTS"],2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>