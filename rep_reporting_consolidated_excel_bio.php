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
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE VISIT REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");
if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0) {	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, strtoupper($_SESSION["LABEL1"]));
} else {
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
}
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
		$i=1;
		$a=mysql_query("SELECT (select COUNT(*) FROM doctors WHERE rep_id=representative.id) as doc_count,(select COUNT(*) FROM tbl_customer_master WHERE rep_id=representative.id) chem_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN wp_dc= 'D' THEN wp_dc_id END) as D,COUNT(DISTINCT CASE WHEN wp_dc= 'C' THEN wp_dc_id END) as C FROM tbl_work_plan,representative WHERE (tbl_work_plan.wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND tbl_work_plan.wp_rep_id=representative.id GROUP BY tbl_work_plan.wp_rep_id ORDER BY tbl_work_plan.wp_rep_id");
		$num_rows=mysql_num_rows($a);

		$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 1;	
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["REP"]);	
					if($_SESSION['doc_cnt']>0){						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["D"].'('.$y_customer["doc_count"].')');	
					}					
					if($_SESSION['chem_cnt']>0){
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["C"].'('.$y_customer["chem_count"].')');
					}
					$row++;
					$i++;
				}


$objWorkSheet='';
		$j=1;
		$a=mysql_query("SELECT (select COUNT(*) FROM doctors WHERE rep_id=representative.id) as doc_count,(select COUNT(*) FROM tbl_customer_master WHERE rep_id=representative.id) chem_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN wp_dc= 'D' THEN wp_dc_id END) as D,COUNT(DISTINCT CASE WHEN wp_dc= 'C' THEN wp_dc_id END) as C FROM tbl_work_plan,representative WHERE (tbl_work_plan.wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND tbl_work_plan.wp_rep_id=representative.id GROUP BY tbl_work_plan.wp_rep_id ORDER BY tbl_work_plan.wp_rep_id");
        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 4;	


					$objWorkSheet=$yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:F1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:F1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:F1','9d9b9b');
					mytemplate_design_fcolor('A1:F1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:F2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
					$objWorkSheet->getStyle('A2:F2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:F2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:F2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:F2','0e7cd8');

					$objWorkSheet->mergeCells('A3:F3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE VISIT REPORT");
					$objWorkSheet->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:F3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');	

					$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
					$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
					$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(23);
					$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	
					$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(34);	
					$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(34);	



					///////////////////////////////////////////// Doctor List /////////////////////////////////////////////
					if($_SESSION['doc_cnt']>0){
						$num1=5;
						$s_no1=1;
						$SQL=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=doctors.doc_pincode GROUP BY pincode) as area_name,doctors.doctor_name,doctors.doc_pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue,drunavailable FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate asc");
						$num_rows1=mysql_num_rows($SQL);


						if($num_rows1 > 0){
							
							$num1=$num1+$num_rows1;
							$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('F1:F'.$num1)->applyFromArray($styleArray);


							$objWorkSheet->mergeCells('A'.$row_1.':F'.$row_1);
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL"])." LIST");
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':F'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(23);
							$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	
							$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(34);	
							$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(34);	


							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"]));
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "LAST VISITED");
							$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "PINCODE - AREA");
							$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "PRESCRIPTION VALE");
							$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "POB VALUE");


							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':F'.$row_1,'eceeef');	
							$row_1++;

							// Define a style object for text color

						}

						while ($row1=mysql_fetch_array($SQL)) {

							
							if ($row1['drunavailable'] == '0') { 
								// For rows where drunavailable is '0', set cell background to a specific color
								$color = 'FFFFFF'; // white
							} elseif ($row1['drunavailable'] == '1') {
								// For rows where drunavailable is '1', set cell background to a different color
								$color = 'FF0000'; // Red
							}
				
							mytemplate_design_bg('C' . $row_1 . ':F' . $row_1, $color);
							// print_r($row1);exit();
							
							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doctor_name']);
							$col_1++;
							if($row1['reporteddate'] != ''){ 
								$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, date("d/m/Y",strtotime($row1['reporteddate']))." ".$row1['reportedtime']);
							} else {
								$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, '');
							}
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_pincode'].' - '.$row1['area_name']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['prescriptionvalue']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['pobvalue']);
							$col_1++;

							$s_no1++;
							$row_1++;

						
						}
					}

					///////////////////////////////////////////// Chemist List /////////////////////////////////////////////
					if($_SESSION['chem_cnt']>0){
						$s_no2=1;
						$SQL1=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=tbl_customer_master.pincode GROUP BY pincode) as area_name,tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue,drunavailable FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");
						$num_rows2=mysql_num_rows($SQL1);

						if($num_rows2 > 0){
							$row_1=$row_1+2;

							$num2=$row_1;
							$num2=$num2+$num_rows2+1;
							$objWorkSheet->getStyle('A'.$row_1.':A'.$num2)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B'.$row_1.':B'.$num2)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C'.$row_1.':C'.$num2)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('D'.$row_1.':D'.$num2)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('E'.$row_1.':E'.$num2)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('F'.$row_1.':F'.$num2)->applyFromArray($styleArray);


							$objWorkSheet->mergeCells('A'.$row_1.':F'.$row_1);
						if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL1"])." LIST");
						} else {
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL"])." LIST");
						}
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':F'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
						if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL1"]));
						} else {
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"]));
						}
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "LAST VISITED");
							$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "PINCODE - AREA");
							$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "PRESCRIPTION VALUE");
							$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "POB VALUE");


							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':F'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':F'.$row_1,'eceeef');	

							$row_1++;
						}
						while ($row2=mysql_fetch_array($SQL1)) {

							if ($row2['drunavailable'] == '0') { 
								// For rows where drunavailable is '0', set cell background to a specific color
								$color = 'FFFFFF'; // white
							} elseif ($row2['drunavailable'] == '1') {
								// For rows where drunavailable is '1', set cell background to a different color
								$color = 'FF0000'; // Red
							}
				
							mytemplate_design_bg('C' . $row_1 . ':F' . $row_1, $color);
							// print_r($row1);exit();

							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no2);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['shop_name']);
							$col_1++;
							if($row2['reporteddate'] != ''){ 
								$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, date("d/m/Y",strtotime($row2['reporteddate']))." ".$row2['reportedtime']);
							} else {
								$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, '');
							}
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['pincode'].' - '.$row2['area_name']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['prescriptionvalue']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['pobvalue']);
							$col_1++;

							$s_no2++;
							$row_1++;
						}


					}
					// if(strpos($y_customer["REP"], "(")>0){
					// 	$title_card=substr($y_customer["REP"], 0, strpos($y_customer["REP"], "("));
					// } else {
					// 	$title_card=$y_customer["REP"];
					// }

					// $objWorkSheet->setTitle($title_card);

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