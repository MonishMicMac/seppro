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

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "MEYER ORGANICS");
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');

$sv=0;
$total=0;
$SQL = mysql_query("SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id  FROM rep_area GROUP BY pin_id) GROUP BY pincode");
			while($RS=mysql_fetch_assoc($SQL)){
				@$YUVI.=$RS["pincode"].",";
			}
			$mama=@$YUVI; // VACANT PINCODE
			$SQL1=mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM `areawise_temp`,product WHERE `pincode` NOT IN (".substr(@$mama,0,-1).") AND pincode>0 AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id");		
          $customer11 = mysql_fetch_array($SQL1);
$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / [Total : ".round($customer11["PTR"],2)." PTS ".round($customer11["PTS"],2)."] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:I2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:I3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Vacant Pincode Product Wise Report");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PINCODE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(10);
$yuvaraj->getActiveSheet()->getStyle('B5:B65536')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "PRODUCT");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "CUSTOMER NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(30);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "DISTRIBUTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "PTR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "PTS");
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:I4','eceeef');	

$row = 5;


$SQL2=mysql_query("SELECT `pincode` FROM `areawise_temp` WHERE `pincode` NOT IN (".substr(@$mama,0,-1).") AND pincode>0 GROUP BY pincode ORDER BY pincode");
while($RS2=mysql_fetch_assoc($SQL2)){
	$col=0;
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS2["pincode"]);
	
	$col=1;
	$product=mysql_query("SELECT product.pro_name AS PNAME, product.id AS PID,SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE areawise_temp.pincode='".$RS2["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id");
	
	while($RS3=mysql_fetch_assoc($product)){
		$col=1;
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(35);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS3["PNAME"]);
		
		$details = mysql_query("SELECT tbl_customer_master.shop_name AS SNAME,distributor.dis_name,SUM(areawise_temp.quantity) AS QTY,SUM(areawise_temp.free_quantity) AS FQTY,SUM(areawise_temp.replace_quantity) AS RQTY, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product,tbl_customer_master,distributor WHERE areawise_temp.our_product_id='".$RS3["PID"]."' AND areawise_temp.pincode='".$RS2["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND tbl_customer_master.id=areawise_temp.our_cust_id AND areawise_temp.our_product_id=product.id AND distributor.dis_id=areawise_temp.dist_id GROUP BY dist_id"); while($RS4=mysql_fetch_assoc($details)){
			$col=2;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS4["SNAME"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS4["dis_name"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS4["QTY"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS4["FQTY"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS4["RQTY"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS4["PTR"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS4["PTS"]);
			$row++;
		}
		$col=1;
		$title = array(
	'font' => array(
		'bold' => true,   
		'color' => array(
			'rgb' => '0e7cd8'
		),
	), 	    
	);
	$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title);
		$details1 = mysql_query("SELECT SUM(areawise_temp.quantity) AS QTY,SUM(areawise_temp.free_quantity) AS FQTY,SUM(areawise_temp.replace_quantity) AS RQTY, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE areawise_temp.our_product_id='".$RS3["PID"]."' AND areawise_temp.pincode='".$RS2["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id"); $RS5=mysql_fetch_array($details1);
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"PRODUCT TOTAL : ".$RS3["PNAME"]);
		$col+=3;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS5["QTY"]);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS5["FQTY"]);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS5["RQTY"]);
		$col++;		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS5["PTR"]);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS5["PTS"]);
		$row++; // NEXT PRODUCT
		
	}
	$col=0;	
	$title1 = array(
	'font' => array(
		'bold' => true,   
		'color' => array(
			'rgb' => 'FF0000'
		),
	), 	    
	);
	$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title1);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"PINCODE TOTAL : ".$RS2["pincode"]);
	$col++;
	$product1=mysql_query("SELECT product.pro_name AS PNAME, product.id AS PID,SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE areawise_temp.pincode='".$RS2["pincode"]."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id");
	
	$RS6=mysql_fetch_assoc($product1);
	$col+=6;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS6["PTR"]);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$RS6["PTS"]);
	$row++;
}
		

//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / [PTR : ".round($customer11["PTR"],2)." PTS : ".round($customer11["PTS"],2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>