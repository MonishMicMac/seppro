<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
error_reporting(0);
/*include("include/function.php");
$conn=mysql_connect("localhost","root","");
mysql_select_db("xylo");*/
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
$REP = mysql_query("SELECT id,companyname FROM clinetcreation WHERE id='".$_REQUEST['cli_name']."'");
$R=mysql_fetch_object($REP);
$from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

  function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {  	
				    $theta = $longitude1 - $longitude2;				    
				    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
				    $miles = acos($miles);
				    $miles = rad2deg($miles);
				    $miles = $miles * 60 * 1.1515;
				    return round($miles * 1.609344,2);
				}
function cellsToMergeByColsRow($start = NULL, $end = NULL, $row = NULL){
    $merge = 'C3:C3';
    if($start && $end && $row){
        $start = PHPExcel_Cell::stringFromColumnIndex($start);
        $end = PHPExcel_Cell::stringFromColumnIndex($end);
        $merge = "$start{$row}:$end{$row}";

    }

    return $merge;
}
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->calculateColumnWidths();
$yuvaraj->getActiveSheet()->mergeCells('A1:I1');
// $yuvaraj->getActiveSheet()->getStyle('A1:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, strtoupper($R->companyname)." - STOCK AND SALES FOR Client - ".$_REQUEST["from_date"]);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->mergeCells('A3:A4');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "DATE");
$yuvaraj->getActiveSheet()->getStyle('A3:CX3')->getFont()->setBold(true);
// $yuvaraj->getActiveSheet()->getStyle('A4:CX3')->getFont()->setBold(true);
// $yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('C5:CX99')->getAlignment()->setWrapText(true);  
$yuvaraj->getActiveSheet()->getStyle('C5:CX99')->getFont()->setBold(false);
// $yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('C5:CX99')->getAlignment()->setWrapText(true);
mytemplate_design_fcolor('C5:CX99','00bf73');
$col=1;
$yuvaraj->getActiveSheet()->mergeCells('B3:B4');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, "");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
$col=2;
// echo "SELECT * FROM productinsertt WHERE clientid='".$_REQUEST['cli_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned) ";
// echo "SELECT * FROM product WHERE id IN (SELECT * FROM productinsertt WHERE clientid='".$_REQUEST['cli_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned)) GROUP BY pro_short_code";
// $i=0;
// $Product=mysql_query("SELECT * FROM product WHERE id IN (SELECT proid FROM productinsertt WHERE clientid='".$_REQUEST['cli_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned)) GROUP BY pro_short_code"); // PRODUCT DETAILS	
// while($Prodview_row=mysql_fetch_object($Product)){

	

// 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, substr($Prodview_row->pro_name,0,-3));
	

// 	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(5);
	
// 	$i++;
// }
// exit();

$row=5;$YP = 1;
$TOT=0;
$i=1;
$totexp=0;

$Daysperiod=mysql_query("SELECT  DISTINCT(our_product_id),pro_name,(sum(`quantity`)*`pts`) AS qty from areawise_temp where rep_id='".$_REQUEST['rep_name']."' AND (c_date BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY our_product_id ");
while($D=mysql_fetch_object($Daysperiod)){	


		$col=0;
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $D->pro_name);
		$col=1;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $D->qty);
		$row++;
		
		
					
	// 	$Client_details = mysql_query("SELECT id,pro_name,(SELECT sum(stockist) AS stockist  from productinsertt WHERE cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND proid=product.id AND clientid='".$_REQUEST['cli_name']."' LIMIT 1) AS Q,(SELECT sum(sales) AS sales from productinsertt WHERE cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND clientid='".$_REQUEST['cli_name']."' AND proid=product.id LIMIT 1) AS p FROM product WHERE pro_short_code IN (SELECT pro_short_code FROM product WHERE id IN (SELECT proid FROM productinsertt WHERE clientid='".$_REQUEST['cli_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned)) GROUP BY pro_short_code) ORDER BY cast(product.id as unsigned)");
	// 		$col=2;
	// 	while($C1=mysql_fetch_object($Client_details)){		
			
			
	// 				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row-1, $C1->Q);			
	// 				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->p);	
	// 		$col++;

	// 		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->p);	
	// 		// $col++;
		
	// 	}
			
	
	
	// $YP++;$row++;
	// $i++;

}
// exit();



$filename=strtoupper($R->companyname)." stock_sales_Client_report ".date("d/m/Y H:i:s").".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>