<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
ini_set('memory_limit', '-1');

function mytemplate_design_bg($range,$bg){
	global $yuvaraj;
	$title = array(    	
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $bg,
        	),
    	),
	);
	$yuvaraj->getActiveSheet()->getStyle($range)->applyFromArray($title);
}

function mytemplate_design_fcolor($range,$fcolor){
	global $yuvaraj;
	$title = array(
    'font' => array(
	    'bold' => true,   
        'color' => array(
            'rgb' => $fcolor
        ),
    ), 	    
	);
	$yuvaraj->getActiveSheet()->getStyle($range)->applyFromArray($title);
}

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:H1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Capital");
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:H1','9d9b9b');
mytemplate_design_fcolor('A1:H1','FFFFFF');
$customer2 = explode("-",@$_REQUEST["cust_name"]);	
$b = mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND pincode=".@$customer2[0]." AND our_cust_id IN (SELECT DISTINCT(id) FROM tbl_customer_master WHERE shop_name = '".@$customer2[1]."') AND our_cust_id <> '' AND our_product_id <> ''")or die(mysql_error());  $p = mysql_fetch_assoc($b);

$yuvaraj->getActiveSheet()->mergeCells('A2:H2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["cust_name"]." / [PTR Value: ".round($p["PTR"],2)." PTS Value: ".round($p["PTS"],2)." ] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:H2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:H3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Customer Wise Individual Report");
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "DISTRIBUTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "BATCH");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "PTR S.Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "PTS S.Value");
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:H4','eceeef');	
$customer = explode("-",$_REQUEST["cust_name"]);
$row = 5;
$rowcnt = 2;
$cmerge = 1;
$a=mysql_query("SELECT DISTINCT(areawise_temp.our_product_id) AS PID, areawise_temp.our_cust_id AS CID, product.pro_name AS PNAME FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.pincode=".$customer[0]." AND areawise_temp.our_cust_id  IN (SELECT DISTINCT(id) FROM tbl_customer_master WHERE shop_name = '".@$customer2[1]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id")or die(mysql_error());
        while($customer=mysql_fetch_assoc($a)){		
		$col =0;		
    //foreach($customer as $key=>$value) {
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(35);						
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer["PNAME"]);	# Product Value - Display	
		//mytemplate_design_bg($col,'eceeef');
		//$yuvaraj->getActiveSheet()->getStyle($col)->getFill()->getStartColor()->setRGB('eceeef');	
		$col =1;			
		$yuvaraj->getActiveSheet()->getStyle($col)->getFill()->getStartColor()->setRGB('B7B7B7');
		$customer1 = explode("-",$_REQUEST["cust_name"]);
		$b1=mysql_query("SELECT dist_id AS DID, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH,SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(sale_value) AS SV, SUM(net_amount) AS NV, SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR  FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode='".$customer1[0]."' AND our_cust_id= '".$customer["CID"]."' and our_cust_id   != '' AND our_product_id   != '' AND our_product_id ='".$customer["PID"]."' GROUP BY dist_id");
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
			//$PTS = $PT["pts"]*$customer1["QTY"];$PTR = $PT["ptr"]*$customer1["QTY"];
			//foreach($customers1 as $key1=>$value1) {
				$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
				$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
				//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value1); # Product Details - Display
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
			//}				
			$col =1;
			
			//$col =1;						
			$row++;				
			
		}
		$b1=mysql_query("SELECT SUM(quantity) AS DQTY, SUM(free_quantity) AS DFQTY, SUM(replace_quantity) AS DRQTY,SUM(quantity*pts) AS YPTS, SUM(quantity*ptr) AS YPTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND pincode=".@$customer2[0]." AND our_product_id ='".$customer["PID"]."' AND our_cust_id <> '' AND our_product_id <> '' AND our_cust_id = '".$customer["CID"]."'")or die(mysql_error());  $p1 = mysql_fetch_assoc($b1);
			$title3 = array(
	'font' => array(
		'bold' => true,   
		'color' => array(
			'rgb' => '0e7cd8'
		),
	), 	    
	);
	$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title3);
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
	$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$yuvaraj->getActiveSheet()->getStyle($row+0)->getFont()->setBold(true);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "SUB TOT");
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+2,$row, round($p1["DQTY"],2));
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+3,$row, round($p1["DFQTY"],2));
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+4,$row, round($p1["DRQTY"],2));	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+5,$row, round($p1["YPTR"],2));
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+6,$row, round($p1["YPTS"],2));
       		$col++;	
		
		//}
	$row++;	
} 
	$col =1;
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
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "TOT AMT");	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+5,$row, round($p["PTR"],2));
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+6,$row, round($p["PTS"],2));
	
		
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["cust_name"]." / [PTR Value: ".round($p["PTR"],2)." PTS Value: ".round($p["PTS"],2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>