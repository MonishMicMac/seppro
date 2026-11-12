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

$yuvaraj->getActiveSheet()->mergeCells('A1:J1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:J1','9d9b9b');
mytemplate_design_fcolor('A1:J1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:J2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:J2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:J3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE VISITED CALL REPORTED");
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(20);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"])." COVERED");

$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:J4','eceeef');	
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$row = 5;
$num=4;	

		$i=1;
		
		$a=mysql_query("SELECT representative.id AS R,representative.rep_name AS REP FROM reorting,representative WHERE (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid=representative.id GROUP BY reorting.repid ORDER BY reorting.repid");
		$num_rows=mysql_num_rows($a);

		$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('F1:F'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('G1:G'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('H1:H'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('I1:I'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('J1:J'.$num)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_object($a)){	
        $DR1=mysql_query("SELECT count(clientid) as cnt FROM reorting WHERE (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')  AND repid='".$y_customer->R."' AND attendance='1'"); $DRCNT1=mysql_fetch_object($DR1);	
		$col=0;
		$row_1 = 1;	
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer->REP);						
					$col++;						
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $DRCNT1->cnt);						
					$col++;						
										
					
					
					$row++;
					$i++;
				}





		$j=1;
		$a=mysql_query("SELECT representative.id AS R,representative.rep_name AS REP FROM reorting,representative WHERE (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid=representative.id GROUP BY reorting.repid ORDER BY reorting.repid");
        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 4;	
					$objWorkSheet = $yuvaraj->createSheet($j);


					$objWorkSheet->mergeCells('A1:G1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, "XYLO");
					$objWorkSheet->getStyle('A1:G1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:G1','9d9b9b');
					mytemplate_design_fcolor('A1:G1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".$y_customer["id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:G2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
					$objWorkSheet->getStyle('A2:G2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:G2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:G2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:G2','0e7cd8');

					$objWorkSheet->mergeCells('A3:G3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE VISITED CALL REPORTED");
					$objWorkSheet->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:G3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');



					$num1=4;
					$s_no1=1;
					echo "SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1'  AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND repid='".$y_customer["id"]."' GROUP BY clientid HAVING D=1) AS B GROUP BY R";
					exit();
					$SQL1=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1'  AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND repid='".$y_customer["id"]."' GROUP BY clientid HAVING D=1) AS B GROUP BY R");
				
					$num_rows1=mysql_num_rows($SQL1);

					if($num_rows1 > 0){
						$num1=$num1+$num_rows1;
						$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('F1:F'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('G1:G'.$num1)->applyFromArray($styleArray);
						
						$merge1=$row_1+$num_rows1;
						$objWorkSheet->mergeCells('A'.$row_1.':A'.$merge1);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge1)->getAlignment()->setWrapText(true);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						mytemplate_design_bg('A'.$row_1.':A'.$merge1,'bdd7ee');	

						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(30);

						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(15);
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(30);	
						$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(22);	
						$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(34);	

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "ONE TIME VISIT LISTED ".strtoupper($_SESSION["LABEL"]));
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "S.NO");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, strtoupper($_SESSION["LABEL"]));
						
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "REPORTED");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "LAST VISITED");
						$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "PINCODE - AREA");
					

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('B'.$row_1.':G'.$row_1,'eceeef');	

						$row_1++;
					}
					$D=mysql_query("SELECT reorting.serviceremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) AS D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid='".$y_customer["id"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D=1 ORDER BY reorting.id DESC");
					while ($row1=mysql_fetch_array($D)) {
						$col_1 = 1;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['name']);
						$col_1++;
					
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_qualification']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['serviceremarks']);
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


					$s_no2=1;
				
					$SQL2=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND repid='".$y_customer["id"]."' GROUP BY clientid HAVING D=2) AS B GROUP BY R");
			
					$num_rows2=mysql_num_rows($SQL2);

					if($num_rows2 > 0){
						$row_1=$row_1+2;
						$merge2=$row_1+$num_rows2;

						$num2=$row_1;
						$num2=$num2+$num_rows2;
						$objWorkSheet->getStyle('A'.$row_1.':A'.$num2)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B'.$row_1.':B'.$num2)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C'.$row_1.':C'.$num2)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D'.$row_1.':D'.$num2)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E'.$row_1.':E'.$num2)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('F'.$row_1.':F'.$num2)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('G'.$row_1.':G'.$num2)->applyFromArray($styleArray);

						$objWorkSheet->mergeCells('A'.$row_1.':A'.$merge2);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge2)->getAlignment()->setWrapText(true);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						mytemplate_design_bg('A'.$row_1.':A'.$merge2,'bdd7ee');	

						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(30);

						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(15);
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(30);	
						$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(22);	
						$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(34);	

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "TWO TIME VISIT LISTED ".strtoupper($_SESSION["LABEL"]));
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "S.NO");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, strtoupper($_SESSION["LABEL"]));
						
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "REPORTED");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "LAST VISITED");
						$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "PINCODE - AREA");
					

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('B'.$row_1.':G'.$row_1,'eceeef');	
						$row_1++;
					}
					$D1=mysql_query("SELECT reorting.serviceremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) as D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid='".$y_customer["id"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D=2 ORDER BY reorting.id DESC");
					while ($row2=mysql_fetch_array($D1)) {
						$col_1 = 1;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no2);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['name']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['doc_qualification']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['serviceremarks']);
						$col_1++;
					if($row2['reporteddate'] != ''){ 
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, date("d/m/Y",strtotime($row2['reporteddate']))." ".$row2['reportedtime']);
					} else {
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, '');
					}
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['pincode']);
						$col_1++;

						$s_no2++;
						$row_1++;
					}


					$s_no3=1;
				
					$SQL3=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND repid='".$y_customer["id"]."' GROUP BY clientid HAVING D=3) AS B GROUP BY R");
				
					$num_rows3=mysql_num_rows($SQL3);

					if($num_rows3 > 0){
						$row_1=$row_1+2;

						$num3=$row_1;
						$num3=$num3+$num_rows3;
						$objWorkSheet->getStyle('A'.$row_1.':A'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B'.$row_1.':B'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C'.$row_1.':C'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D'.$row_1.':D'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E'.$row_1.':E'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('F'.$row_1.':F'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('G'.$row_1.':G'.$num3)->applyFromArray($styleArray);


						$merge3=$row_1+$num_rows3;
						$objWorkSheet->mergeCells('A'.$row_1.':A'.$merge3);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge3)->getAlignment()->setWrapText(true);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						mytemplate_design_bg('A'.$row_1.':A'.$merge3,'bdd7ee');	

						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(30);

						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(15);
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(30);	
						$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(22);	
						$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(34);	
						
						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "THREE TIME VISIT LISTED ".strtoupper($_SESSION["LABEL"]));
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "S.NO");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, strtoupper($_SESSION["LABEL"]));
					
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "REPORTED");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "LAST VISITED");
						$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "PINCODE - AREA");
						

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('B'.$row_1.':G'.$row_1,'eceeef');	
						$row_1++;
					}
						$D2=mysql_query("SELECT reorting.serviceremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) as D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid='".$y_customer["id"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D=3 ORDER BY reorting.id DESC");
		
					while ($row3=mysql_fetch_array($D2)) {
						$col_1 = 1;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no3);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row3['name']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row3['doc_qualification']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row3['serviceremarks']);
						$col_1++;
					if($row3['reporteddate'] != ''){ 
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, date("d/m/Y",strtotime($row3['reporteddate']))." ".$row3['reportedtime']);
					} else {
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, '');
					}
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row3['pincode']);
						$col_1++;

						$s_no3++;
						$row_1++;
					}


					$s_no4=1;
				
					$SQL4=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND repid='".$y_customer["id"]."' GROUP BY clientid HAVING D>3) AS B GROUP BY R");
				
					$num_rows4=mysql_num_rows($SQL4);

					if($num_rows4 > 0){
						$row_1=$row_1+2;

						$num4=$row_1;
						$num4=$num4+$num_rows4;
						$objWorkSheet->getStyle('A'.$row_1.':A'.$num4)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B'.$row_1.':B'.$num4)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C'.$row_1.':C'.$num4)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D'.$row_1.':D'.$num4)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E'.$row_1.':E'.$num4)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('F'.$row_1.':F'.$num4)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('G'.$row_1.':G'.$num4)->applyFromArray($styleArray);

						$merge4=$row_1+$num_rows4;
						$objWorkSheet->mergeCells('A'.$row_1.':A'.$merge4);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge4)->getAlignment()->setWrapText(true);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$objWorkSheet->getStyle('A'.$row_1.':A'.$merge4)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						mytemplate_design_bg('A'.$row_1.':A'.$merge4,'bdd7ee');	

						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(30);

						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(15);
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(30);	
						$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(22);	
						$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(34);	
						
						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "MORE THAN 3 TIME VISIT LISTED ".strtoupper($_SESSION["LABEL"]));
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "S.NO");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, strtoupper($_SESSION["LABEL"]));
						
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "REPORTED");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "LAST VISITED");
						$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "PINCODE - AREA");
						

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('B'.$row_1.':G'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('B'.$row_1.':G'.$row_1,'eceeef');	
						$row_1++;
					}
					$D3=mysql_query("SELECT reorting.serviceremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) as D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid='".$y_customer["id"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D>3 ORDER BY reorting.id DESC");
		
					while ($row4=mysql_fetch_array($D3)) {
						$col_1 = 1;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no4);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row4['name']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row4['doc_qualification']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row4['serviceremarks']);
						$col_1++;
					if($row4['reporteddate'] != ''){ 
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, date("d/m/Y",strtotime($row4['reporteddate']))." ".$row4['reportedtime']);
					} else {
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, '');
					}
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row4['pincode']);
						$col_1++;

						$s_no4++;
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