<?php
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1'); 
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:I1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');
$SQL = mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST["rep_id"]."'");
$RS = mysql_fetch_object($SQL);

$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$RS->rep_name);

$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:I2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:I3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Pincode wise Product Report");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$i=1;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PRODUCT \ PINCODE");
$sql1=mysql_query("SELECT pincode FROM areawise_temp WHERE rep_id=".$_REQUEST['rep_id']." AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') GROUP BY pincode");
while($row1=mysql_fetch_array($sql1)){
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($i, 4, $row1['pincode']);
    $i++;
}


$yuvaraj->getActiveSheet()->getStyle('A4:CC4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:CC4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:CC4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');  

$styleArray = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
); 

$row = 5;

$sql=mysql_query("SELECT id,pro_name FROM product WHERE pro_name!='' ORDER BY pro_name")or die(mysql_error());
while($row_sql=mysql_fetch_array($sql)){
    $col = 0;
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(50);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_sql["pro_name"]);
    $col++;

    $sql2=mysql_query("SELECT pincode FROM areawise_temp WHERE rep_id='".$_REQUEST['rep_id']."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') GROUP BY pincode");
    while($row2=mysql_fetch_array($sql2)){
        $sql3=mysql_query("SELECT SUM(quantity) as qty FROM areawise_temp WHERE rep_id='".$_REQUEST['rep_id']."' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_product_id='".$row_sql['id']."' AND pincode='".$row2['pincode']."' GROUP BY pincode,our_product_id");
        $row3=mysql_fetch_array($sql3);
        if($row3['qty']==''){ $qty='0'; } else { $qty=$row3['qty']; }
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $qty);
        $col++;
    }
    $row++;
}

//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$RS->rep_name." / [PTR : ".round($row_data["PTR"],2)." PTS : ".round($row_data["PTS"],2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>