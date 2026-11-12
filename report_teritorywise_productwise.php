<?php
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');

$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);

$yuvaraj->getActiveSheet()->mergeCells('A1:L1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "BIOPHONIX ");
$yuvaraj->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->getStyle('A1:L1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->mergeCells('A2:L2');
$yuvaraj->getActiveSheet()->getStyle('A2:L2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:L2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

mytemplate_design_fcolor('A2:L2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:L3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Teritorywise Product Report");
$yuvaraj->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A3:L3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "MONTH");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "PRODUCT");

$TCNT=0;
$Y=2;
$row=4;
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);

$Teritory=mysql_query("SELECT * FROM mst_tertiary");
$TCNT=mysql_num_rows($Teritory);
$yuvaraj->getActiveSheet()->getStyle("A4:B5")->getFont()->setBold(true);
while($T=mysql_fetch_object($Teritory)){
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($Y)->setWidth(15);	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($Y, 4, $T->tertiary_name);
	$Y++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($TCNT+2, 4, "VACNAT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($TCNT+3, 4, "TOTAL");
$yuvaraj->getActiveSheet()->getStyle('A3:L5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$yuvaraj->getActiveSheet()->getStyle('A3:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A3:L5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->freezePane('A5');
$col=0;
$row=5;
$Product=mysql_query("SELECT * FROM product WHERE 1 limit 3");
$cnt=mysql_num_rows($Product);
while($P=mysql_fetch_object($Product)){
	$Sale3=mysql_query("SELECT COALESCE(SUM(quantity),0) Q,SUM(free_quantity) F,SUM(replace_quantity) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."'");	
	$S3=mysql_fetch_object($Sale3);
	$col=0;
	$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+1))->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->getStyle("B".($row+0).":B".($row+$cnt+2))->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
	$yuvaraj->getActiveSheet()->mergeCells("A".($row).":L".($row));
	$yuvaraj->getActiveSheet()->getStyle("A".($row).":L".($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle("A".($row).":L".($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle("A".($row).":L".($row))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($P->pro_name)." Q ".$S3->Q." F ".$S3->F." R ".$S3->R." PTS ".round($S3->PTS,2)." PTR ".round($S3->PTR,2));
	$row++;
	
	$Monthwise=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
		('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
	$cnt1=mysql_num_rows($Monthwise); 
	while($M=mysql_fetch_object($Monthwise)){	
		$col=0;
		$yuvaraj->getActiveSheet()->mergeCells("A".($row+0).":A".($row+$cnt1+3));
		$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt1+1))->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt1+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt1+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$yuvaraj->getActiveSheet()->getStyle("A".($row).":L".($row+$cnt1+1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date('M Y',strtotime($M->S1)));
		$col=1;	
		$Nrow=$row;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Q");
		$row++;	
		$Nrow1=$row;
		$col1=$col;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "F");
		$row++;
		$Nrow2=$row;
		$col2=$col;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "R");
		$row++;	
		$Nrow3=$row;
		$col3=$col;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PTS");
		$row++;	
		$Nrow4=$row;
		$col4=$col;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PTR");

		$col=2;
		$Teritory1=mysql_query("SELECT * FROM mst_tertiary"); 
		while($T1=mysql_fetch_object($Teritory1)){	
			$Sale=mysql_query("SELECT rep_id,IFNULL(SUM(quantity),0) Q,IFNULL(SUM(free_quantity),0) F,IFNULL(SUM(replace_quantity),0) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".date("Y/m/d",strtotime($M->S))."' AND '".date("Y/m/d",strtotime($M->S1))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."' AND rep_id ='".$T1->rep_id."'");
			while($S=mysql_fetch_object($Sale)){			

				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $Nrow, $S->Q);			
				$col++;						
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col1+1, $Nrow1, $S->F);			
				$col1++;	
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col2+1, $Nrow2, $S->R);
				$col2++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col3+1, $Nrow3, round($S->PTS,2));
				$col3++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col4+1, $Nrow4, round($S->PTR,2));
				$col4++;	

			}	
		}
		$Sale1=mysql_query("SELECT COALESCE(SUM(quantity),0) Q,COALESCE(SUM(free_quantity),0) F,COALESCE(SUM(replace_quantity),0) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".date("Y/m/d",strtotime($M->S))."' AND '".date("Y/m/d",strtotime($M->S1))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."' AND rep_id='0'");
		$S1=mysql_fetch_object($Sale1);
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $Nrow, $S1->Q);			
		$col++;						
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col1+1, $Nrow1, $S1->F);			
		$col1++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col2+1, $Nrow2, $S1->R);
		$col2++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col3+1, $Nrow3, round($S1->PTS,2));
		$col3++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col4+1, $Nrow4, round($S1->PTR,2));
		$col4++;	
		$Sale2=mysql_query("SELECT COALESCE(SUM(quantity),0) Q,COALESCE(SUM(free_quantity),0) F,COALESCE(SUM(replace_quantity),0) R,SUM(quantity*ptr) PTR,SUM(quantity*pts) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".date("Y/m/d",strtotime($M->S))."' AND '".date("Y/m/d",strtotime($M->S1))."') AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$P->id."'");
		$S2=mysql_fetch_object($Sale2);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $Nrow, $S2->Q);			
		$col++;						
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col1+1, $Nrow1, $S2->F);			
		$col1++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col2+1, $Nrow2, $S2->R);
		$col2++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col3+1, $Nrow3, round($S2->PTS,2));
		$col3++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col4+1, $Nrow4, round($S2->PTR,2));
		$col4++;

		$row++;
	}
	
	$row++;
}


$filename="Period.xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit;

?>