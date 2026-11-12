<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:J1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Capital");
$yuvaraj->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:J1','9d9b9b');
mytemplate_design_fcolor('A1:J1','FFFFFF');
$SQL = mysql_query("SELECT pin_id FROM master_pincode WHERE pincode='".$_REQUEST["pincode"]."' ");
$RS = mysql_fetch_object($SQL);
$b = mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != ''")or die(mysql_error());
$row_data = mysql_fetch_assoc($b);

$yuvaraj->getActiveSheet()->mergeCells('A2:J2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["pincode"]." / [PTS S.VALUE : ".round($row_data["PTS"],2)." PTR S.VALUE : ".round($row_data["PTR"],2)." ] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:J2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:J3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Pincode Wise Individual Report");
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PRODUCT");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "CUSTOMER NAME");
$yuvaraj->getActiveSheet()->getStyle('A4:A4')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "DOCTOR");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "DISTRIBUTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "BATCH");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "PTR S.Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 4, "PTS S.Value");
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:J4','eceeef');	

$row = 5;
$rowcnt = 2;
$cmerge = 1;
$a=mysql_query("SELECT DISTINCT(areawise_temp.our_product_id) AS PID, product.pro_name AS PNAME FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.pin_id=".$RS->pin_id." AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != ''  AND areawise_temp.our_product_id=product.id ")or die(mysql_error());
        while($customer=mysql_fetch_assoc($a)){		
		$col =0;		
    //foreach($customer as $key=>$value) {
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(40);						
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer["PNAME"]);	# Product Value - Display	
		//mytemplate_design_bg($col,'eceeef');
		//$yuvaraj->getActiveSheet()->getStyle($col)->getFill()->getStartColor()->setRGB('eceeef');		
		$col =1;			
		$yuvaraj->getActiveSheet()->getStyle($col)->getFill()->getStartColor()->setRGB('B7B7B7');
		$b1=mysql_query("SELECT dist_id AS DID,tbl_customer_master.shop_name AS cust_name, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY,tbl_customer_master.doctor_id AS DRID,SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR  FROM areawise_temp, tbl_customer_master WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$customer["PID"]."' AND areawise_temp.pin_id=".$RS->pin_id." AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.cust_name,areawise_temp.pin_id ORDER BY areawise_temp.dist_id ");
		$cnt = mysql_num_rows($b1);		
		$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);	
		//$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getFill()->getStartColor()->setRGB('eceeef');
		
		$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getFill()->applyFromArray(array(
		
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => 'eceeef'
        )
    ));
	
	$styleArray = array(
  'borders' => array(
  	
    'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => PHPExcel_Style_Color::COLOR_WHITE	  
    ))
  )
);

$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->applyFromArray($styleArray);
unset($styleArray);
		
			
		$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->mergeCells("A".($row+0).":A".($row+$cnt)); # Row Merge Cell	
			
		while($customers1=mysql_fetch_assoc($b1)){	
				$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$customers1["DID"].""); $rd=mysql_fetch_assoc($sqld);
				$DOCTOR=mysql_query("SELECT doctor_name as DRNAME FROM doctors WHERE id IN ('".$customers1['DRID']."')"); $IDDR=mysql_fetch_assoc($DOCTOR);
				if($customers1['DRID']!=""){ $DTYPE = $IDDR["DRNAME"];} else{ $DTYPE = "Floating";}
				//$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
				$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customers1["cust_name"]);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$DTYPE);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rd["dis_name"]);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customers1["BATCH"]);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customers1["QTY"]);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customers1["FQTY"]);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customers1["RQTY"]);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customers1["PTR"]);				
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customers1["PTS"]);
			$col =1;						
			$row++;				
		}
        $col++;
			$b2=mysql_query("SELECT SUM(quantity) AS YQTY, SUM(free_quantity) AS YFQTY, SUM(replace_quantity) AS YRQTY, SUM(quantity*pts) AS YPTS, SUM(quantity*ptr) AS YPTR FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_product_id='".$customer["PID"]."' AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != ''"); $customer3=mysql_fetch_assoc($b2); 			
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
			$col =1;
			$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(35);							
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sub Total");
			
			$col+=4;	
			$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);					
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $customer3["YQTY"]);						
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $customer3["YFQTY"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $customer3["YRQTY"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $customer3["YPTR"]);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $customer3["YPTS"]);
			
			
		//}
	$row++;	
} 
	$title2 = array(
	'font' => array(
		'bold' => true,   
		'color' => array(
			'rgb' => 'FF0000'
		),
	), 	    
	);
	$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title2);
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
	$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle($row+0)->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col-6,$row, "TOT AMT");	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col-1,$row,round($row_data["PTR"],2));
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, round($row_data["PTS"],2));
	
		
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["pincode"]." / [PTR : ".round($row_data["PTR"],2)." PTS : ".round($row_data["PTS"],2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>