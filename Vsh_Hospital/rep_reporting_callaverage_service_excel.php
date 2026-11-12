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

$yuvaraj->getActiveSheet()->mergeCells('A1:D1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:D1','9d9b9b');
mytemplate_design_fcolor('A1:D1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:D2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:D2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:D3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CALL AVERAGE REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");


$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, strtoupper($_SESSION["LABEL"])." CALL AVERAGE");


$yuvaraj->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:D4','eceeef');	
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
$row = 5;	
$num=4;

		$AVERAGE=mysql_query("SELECT DATEDIFF('".$_REQUEST["to_date"]."', '".$_REQUEST["from_date"]."') AS days");$A=mysql_fetch_object($AVERAGE);	
		$from_date=date("Y-m-d",strtotime($_REQUEST["from_date"]));
		$to_date=date("Y-m-d",strtotime($_REQUEST["to_date"] . " +1 days"));

		$begin = new DateTime($from_date);
		$end = new DateTime($to_date);

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		$cnt_days=0;
		foreach ( $period as $dt ){
		  if($dt->format("l") != 'Sunday'){
		  	$cnt_days++;

		  	$leave=mysql_query("SELECT * FROM mst_leave_dates WHERE leave_date='".$dt->format("Y-m-d")."'");
			if(mysql_num_rows($leave)>0){
				$cnt_days--;
			}
		  }
		}

		$i=1;
		$a=mysql_query("SELECT reorting.tdate,(select COUNT(*) FROM clinetcreation WHERE id=representative.id) as doc_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT(reorting.clientid)) as D FROM reorting,representative WHERE (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid=representative.id GROUP BY reorting.repid ORDER BY reorting.repid");
		$num_rows=mysql_num_rows($a);

		$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('F1:F'.$num)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 1;

			$cnt_leave_add=$cnt_days;
			$leave_cnt=mysql_query("SELECT * FROM mst_leave_dates WHERE leave_date='".$y_customer["repid"]."'");
			if(mysql_num_rows($leave_cnt) == 0){
				$cnt_leave_add=$cnt_days+1;
			}
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["REP"]);	
										
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["D"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($y_customer["D"]/$cnt_leave_add));
					

					$row++;
					$i++;
				}



$objWorkSheet='';
		$j=1;
		$a=mysql_query("SELECT (select COUNT(*) FROM clinetcreation WHERE id=representative.id) as doc_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT(reorting.clientid)) as D FROM reorting,representative WHERE (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid=representative.id GROUP BY reorting.repid ORDER BY reorting.repid");
        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 4;	

					$objWorkSheet=$yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:E1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:E1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:E1','9d9b9b');
					mytemplate_design_fcolor('A1:E1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$y_customer['R']."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:E2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
					$objWorkSheet->getStyle('A2:E2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:E2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:E2','0e7cd8');

					$objWorkSheet->mergeCells('A3:E3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE VISIT REPORT");
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:E3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');	

					$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
					$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
					$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(23);
					$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	

					///////////////////////////////////////////// Doctor List /////////////////////////////////////////////
					
						$num1=5;
						$s_no1=1;
						
						$SQL=mysql_query("SELECT (select pincode FROM master_pincode WHERE pincode=clinetcreation.pincode GROUP BY pincode) as area_name,clinetcreation.name,clinetcreation.pincode,reporteddate,reportedtime,repremarks FROM reorting,clinetcreation WHERE reorting.clientid=clinetcreation.id AND reorting.repid='".$y_customer["R"]."' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')  GROUP BY reorting.clientid ORDER BY  reorting.id DESC");
						$num_rows1=mysql_num_rows($SQL);


						if($num_rows1 > 0){
							
							$num1=$num1+$num_rows1;
							$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->mergeCells('A'.$row_1.':E'.$row_1);
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL"])." LIST");
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':E'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(23);
							$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(34);	

							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"]));
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "REMARKS");
							$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "LAST VISITED");
							$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "PINCODE - AREA");

							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':E'.$row_1,'eceeef');	
							$row_1++;
						}
						while ($row1=mysql_fetch_array($SQL)) {
							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['name']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['repremarks']);
							$col_1++;
							if($row1['reporteddate'] != ''){ 
								$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, date("d/m/Y",strtotime($row1['reporteddate']))." ".$row1['reportedtime']);
							} else {
								$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, '');
							}
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['pincode']);
							$col_1++;

							$s_no1++;
							$row_1++;
						}
					
					
					if(strpos($y_customer["REP"], "(")>0){
						$title_card=substr($y_customer["REP"], 0, strpos($y_customer["REP"], "("));
					} else {
						$title_card=$y_customer["REP"];
					}

					$objWorkSheet->setTitle($title_card);

					$j++;
}

$yuvaraj->setActiveSheetIndex(0);
		
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])).".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>