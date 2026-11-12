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
$i=0;
$Product=mysql_query("SELECT * FROM product WHERE id IN (SELECT proid FROM productinsertt WHERE clientid='".$_REQUEST['cli_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned)) GROUP BY pro_short_code"); // PRODUCT DETAILS	
while($Prodview_row=mysql_fetch_object($Product)){

	// $Prodview=mysql_query("SELECT * FROM product WHERE id='".$P->proid."' GROUP BY pro_short_code"); // PRODUCT DETAILS	
	// 	$Prodview_row=mysql_fetch_object($Prodview);
		// $yuvaraj->getActiveSheet()->mergeCells($col+5);
		// $yuvaraj->mergeCells(cellsToMergeByColsRow($col, $col+5));
		// $yuvaraj->mergeCells(cellsToMergeByColsRow($col, 3));
	// echo substr($Prodview_row->pro_name,0,-3);
	if($i==0){
		$adjustedColumn1='C';
	}

	$adjustment = $col+4;
	$currentColumn = 'A';

	$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	$adjustedColumnIndex = $columnIndex + $adjustment;
	$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);

	// echo $adjustedColumn1.' - '.$adjustedColumn;
	$yuvaraj->getActiveSheet()->mergeCells($adjustedColumn1.'3:'.$adjustedColumn.'3');

	$adjustment1 = $adjustment+1;
	$currentColumn1 = 'A';

	$columnIndex1 = PHPExcel_Cell::columnIndexFromString($currentColumn1);
	$adjustedColumnIndex1 = $columnIndex1 + $adjustment1;
	$adjustedColumn1 = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex1 - 1);

	// echo $adjustedColumn.' - '.$adjustedColumn1;

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, substr($Prodview_row->pro_name,0,-3));
	// $col++;
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(5);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 4, "L");
	$col++;
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(5);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 4, "Q");
	$col++;
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(5);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 4, "P");
	$col++;
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(5);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 4, "N");
	$col++;
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(5);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 4, "D");
	$col++;

	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(5);
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX99')->getFont()->setBold(true);
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// $col=$col+5;	
	// $row++;
	// $yuvaraj->getActiveSheet()->mergeCells($col:$col+5);
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$i++;
}
// exit();
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, "NSR VALUE IN RS");
// CLIENT POB - START
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DATE");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "AREA COVERED");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "KMS");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "ALLOWANCE");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(35);
// $yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
// $yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
// $yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
// $yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $yuvaraj->getActiveSheet()->freezePane('A4');	
// mytemplate_design_bg('A3:E3','eceeef');	
// CLIENT POB - START
$row=5;$YP = 1;
$TOT=0;
$i=1;
$totexp=0;
$sqlsqq=mysql_query("SELECT rep_hq_wages FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
$aqq=mysql_fetch_array($sqlsqq);

$Daysperiod=mysql_query("SELECT  cdate AS selected_date from productinsertt where clientid='".$_REQUEST['cli_name']."' AND (cdate BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY cdate ");
while($D=mysql_fetch_object($Daysperiod)){


		$col=0;
		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
		// $col++;
		 // $row;
		 // $row1=$row+1;
		$row1=$row+1;
		$yuvaraj->getActiveSheet()->mergeCells("A".$row.":A".$row1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("Y-m-d",strtotime($D->selected_date)));
		$row++;
		$col=1;	
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row-1, "STOCK");
		$row++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row-1, "SALES");
		$row--;
		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCK");
		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "SALES");
		// echo "SELECT pro_short_code FROM product WHERE id IN (SELECT proid FROM productinsertt WHERE clientid='".$_REQUEST['cli_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned)) GROUP BY pro_short_code";
		
					
		$Client_details = mysql_query("SELECT id,pro_name,(SELECT sum(stockist) AS stockist  from productinsertt WHERE cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND proid=product.id AND clientid='".$_REQUEST['cli_name']."' LIMIT 1) AS Q,(SELECT sum(sales) AS sales from productinsertt WHERE cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND clientid='".$_REQUEST['cli_name']."' AND proid=product.id LIMIT 1) AS p FROM product WHERE pro_short_code IN (SELECT pro_short_code FROM product WHERE id IN (SELECT proid FROM productinsertt WHERE clientid='".$_REQUEST['cli_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned)) GROUP BY pro_short_code) ORDER BY cast(product.id as unsigned)");
			$col=2;
		while($C1=mysql_fetch_object($Client_details)){		
			
			
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row-1, $C1->Q);			
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->p);	
			$col++;

			// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->p);	
			// $col++;
		
		}
			
	
	
	$YP++;$row++;
	$i++;

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