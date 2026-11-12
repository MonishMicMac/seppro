<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3000000);
ini_set('max_execution_time', 1500000);
set_time_limit(0);
error_reporting(0);

ob_end_clean();
header("Connection: close\r\n");
header("Content-Encoding: none\r\n");
ignore_user_abort(true);
ob_start();
echo "Loading";
$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush();
flush();
ob_end_clean();
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:H1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');



if(@$_REQUEST["division_id"]!=""){
	$division_default = "and areawise_temp.division_id='".@$_REQUEST["division_id"]."'";
} else {
	if($_SESSION["division_id"]!="ALL"){
		$division_default = " and areawise_temp.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
	} else {
		$division_default = "";
	}
}

if(@$_REQUEST["state_id"]) {
	$state_check = "and areawise_temp.state_id='".(@$_REQUEST["state_id"])."'";
} else {
	if($_SESSION["state_id"]!="ALL") {
		$state_check = " and areawise_temp.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
	} else {
		$state_check = "";
	}
}



$total=0;
$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id ='".$_REQUEST["dist_id"]."'"); $rd=mysql_fetch_object($sqld);

$a1=mysql_query("SELECT SUM(areawise_temp.quantity) AS SQTY, SUM(areawise_temp.free_quantity) AS SFQTY, SUM(areawise_temp.replace_quantity) AS SRQTY, SUM(areawise_temp.quantity*areawise_temp.pts) AS TOTPTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS TOTPTR FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' $division_default $state_check")or die(mysql_error());
$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."");
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:I2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:I3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Top Product  Report");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PRODUCT_NAME");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "PTR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "QTY");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "No customer Covered");
/*$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "No of Rep Covered");
*/$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:I4','eceeef');	

$row = 5;	

$sqltp=mysql_query("SELECT  product.pro_name AS PNAME, SUM(areawise_temp.quantity*areawise_temp.ptr) AS TOTPTR, SUM(areawise_temp.quantity*areawise_temp.pts) AS TOTPTS,round(SUM(areawise_temp.quantity)) as pro_qty,COUNT(DISTINCT(areawise_temp.our_cust_id)) as cust_id FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id $division_default $state_check GROUP BY areawise_temp.our_product_id ORDER BY TOTPTR DESC LIMIT 0, 10");

while($y_customer=mysql_fetch_assoc($sqltp)){		
	$col=0;
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["PNAME"]);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($y_customer["TOTPTR"],2));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($y_customer["TOTPTS"],2));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["pro_qty"]);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["cust_id"]);						
	$col++;
	$row++;
}


$filename="Top Product Report - ".date("F Y").".xls";

// $filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." Top Product List".".xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');
//$objWriter->save('php://output');
$objWriter->save(str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/'.$filename,__FILE__));
$_SESSION['file_name_DCU']=$filename;
$_SESSION['success_msg_DCU']="Success"; 
exit;

?>