<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
error_reporting(0);
include("include/function.php");

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
$REP = mysql_query("SELECT id,rep_name FROM representative WHERE id='".$_REQUEST['rep_name']."'");
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

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:E1','9d9b9b');
mytemplate_design_fcolor('A1:E1','FFFFFF');


$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, strtoupper($R->rep_name)." - ATTENDANCE FOR ".date("Y-m-d",strtotime($from_date))." TO ".date("Y-m-d",strtotime($R_MDATE->LastDay)));
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

$col=1;


$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "DAY");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "PLAN");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "REASON");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(35);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');	
mytemplate_design_bg('A3:E3','eceeef');	
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
// CLIENT POB - START
$row=4;$YP = 1;
$TOT=0;
$i=1;
$num=3;
$totexp=0;
$sqlsqq=mysql_query("SELECT * FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
$aqq=mysql_fetch_array($sqlsqq);


$Daysperiod=mysql_query("select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' ");
$num_rows=mysql_num_rows($Daysperiod);
	$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
while($D=mysql_fetch_object($Daysperiod)){	
	$col=0;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("Y-m-d",strtotime($D->selected_date)));
		$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date('l', strtotime($D->selected_date)));
		
		// echo "SELECT * from repgivenasleave where leaveapplieddate='".date("Y-m-d",strtotime($D->selected_date))."' AND `repid`='".$_REQUEST['rep_name']."'";
		$SQL=mysql_query("SELECT * from repgivenasleave where leaveapplieddate='".date("Y-m-d",strtotime($D->selected_date))."' AND `repid`='".$_REQUEST['rep_name']."'");
		$Y=mysql_num_rows($SQL);
		if($Y > 0)
		{
		$Y=mysql_fetch_object($SQL);

		$col=3;
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->expenses);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->reason);
		$col++;
		
		}
		else
		{
			 $clientcheck=mysql_query("SELECT  wp_dc_id from tbl_work_plan WHERE wp_date ='".date("Y-m-d",strtotime($D->selected_date))."' AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND attendancestatus='1'");
            $clientcheck_row=mysql_num_rows($clientcheck);
            if($clientcheck_row > 0)
	            {
	            $SQLdoc=mysql_query("SELECT GROUP_CONCAT(wp_dc_id) AS dcid  from tbl_work_plan WHERE wp_date ='".date("Y-m-d",strtotime($D->selected_date))."' AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND attendancestatus='1' ");
                $SQLdoc_row=mysql_fetch_object($SQLdoc);  
               
                 $SQLpin=mysql_query("SELECT GROUP_CONCAT(doc_pin_id) AS dcpin from doctors WHERE `rep_id`='".$_REQUEST['rep_name']."' AND id IN (".$SQLdoc_row->dcid.")");
                $SQLpin_row=mysql_fetch_object($SQLpin);  
               
                 $SQLstn=mysql_query("SELECT distinct(station) AS plandre from stationplanforrep where `repid`='".$_REQUEST['rep_name']."' AND pinid IN (".$SQLpin_row->dcpin.")");
                $SQLstn_row=mysql_fetch_object($SQLstn); 

                  if($SQLstn_row->plandre=='local')
                   { 
                   		$col=3;		
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SQLstn_row->plandre);
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SQLstn_row->plandre);
						$col++;                  
                   }
                   else
                   { 
                   		$col=3;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "out");
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "out");
						$col++;
                   }
	            }
            else
            	{
      			$col=3;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "-");
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "-");
				$col++;
				}
		}
		
		

	
	$YP++;$row++;
	$i++;

}

// exit();
$filename=strtoupper($R->rep_name)." attendance_report ".date("d/m/Y H:i:s").".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>