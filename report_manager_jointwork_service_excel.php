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

$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:E1','9d9b9b');
mytemplate_design_fcolor('A1:E1','FFFFFF');

$total=0;
$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["mgr"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Manager : ".$customer11->rep_name);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:E2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:E3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "MANAGER JOINT WORK REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');		

$row = 4;	

   
		$a=mysql_query("SELECT reporteddate,count(DISTINCT(repid)) as REP, count(clientid) as DR FROM reorting WHERE (reporteddate BETWEEN '".@date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".@date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND attendance = 1 and jointworkby like '%".@$_REQUEST['mgr']."%' GROUP BY reporteddate");
	
        while($y_customer=mysql_fetch_assoc($a)){	

    	
        	$SQL=mysql_query("SELECT name as name,clinetcreation.latts as latitude,clinetcreation.longgs as longtitude,rep_name,reorting.reporteddate,reorting.reportedtime,reorting.drunavailablereason  FROM reorting,representative,clinetcreation WHERE reorting.reporteddate='".$y_customer["reporteddate"]."' AND reorting.attendance = 1 AND reorting.repid=representative.id AND reorting.clientid=clinetcreation.id and jointworkby like '%".$_REQUEST['mgr']."%'");
        
        	$CNT=mysql_num_rows($SQL); 

        	if($CNT>0){
				$col=0;
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("d-m-Y",strtotime($y_customer["reporteddate"])));

						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'REP : '.$y_customer["REP"].' DR : '.$y_customer["DR"]);
					

					$yuvaraj->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A'.$row.':E'.$row,'006535');
					mytemplate_design_fcolor('A'.$row.':E'.$row,'FFFFFF');
					$col++;	
					$row++;

					$col=0;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "S.NO");
					$col++;	
					$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "REPRESENTATIVE");
					$col++;	
					$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($_SESSION["LABEL"])." NAME");
					$col++;	
					$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "FEEDBACK");
					$col++;	
					$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "REPORTED TIME");
					$col++;	

					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getFont()->setBold(true);
					$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_bg('A'.$row.':E'.$row,'eceeef');
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);

					$row++;

					$i=1;
					while($RS=mysql_fetch_array($SQL)){
						$col=0;
						$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["rep_name"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["name"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["drunavailablereason"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["reportedtime"]);
						$col++;	

						$row++;
						$i++;
					}
					
					$row++;
			}
		}


		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$row=$row-2;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);
	
		
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Manager : ".$customer11->rep_name.".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>