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

$yuvaraj->getActiveSheet()->mergeCells('A1:F1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:F1','9d9b9b');
mytemplate_design_fcolor('A1:F1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:F2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:F2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:F3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE MISSED REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");
if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0) {	
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, strtoupper($_SESSION["LABEL"])." MISSED");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, strtoupper($_SESSION["LABEL1"]));
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, strtoupper($_SESSION["LABEL1"])." MISSED");
} else {
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, strtoupper($_SESSION["LABEL"])." MISSED");
}
$yuvaraj->getActiveSheet()->getStyle('A4:F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:F4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:F4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:F4','eceeef');	
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
		$i=1;
		$a=mysql_query("SELECT (SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id =representative.id AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (`tbl_work_plan`.wp_date BETWEEN '".date("Y/m/d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id=representative.id GROUP BY wp_dc_id)) dc_missed,(SELECT COUNT(*) AS CHEMIST FROM tbl_customer_master WHERE rep_id =representative.id AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (`tbl_work_plan`.wp_date BETWEEN '".date("Y/m/d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='C' AND wp_rep_id=representative.id GROUP BY wp_dc_id)) chem_missed,(select COUNT(*) FROM doctors WHERE rep_id=representative.id) as doc_count,(select COUNT(*) FROM tbl_customer_master WHERE rep_id=representative.id) chem_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN wp_dc= 'D' THEN wp_dc_id END) as D,COUNT(DISTINCT CASE WHEN wp_dc= 'C' THEN wp_dc_id END) as C FROM tbl_work_plan,representative WHERE (tbl_work_plan.wp_date BETWEEN '".date("Y/m/d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND tbl_work_plan.wp_rep_id=representative.id GROUP BY tbl_work_plan.wp_rep_id ORDER BY tbl_work_plan.wp_rep_id");
		$num_rows=mysql_num_rows($a);

		$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('F1:F'.$num)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_assoc($a)){	
			
			// print_r($y_customer);exit();
		$col=0;
		$row_1 = 1;	
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["REP"]);	
					$col++;											
					if($_SESSION['doc_cnt']>0){
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["D"].'('.$y_customer["doc_count"].')');						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["dc_missed"]);
					$col++;						
					}					
					if($_SESSION['chem_cnt']>0){
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["C"].'('.$y_customer["chem_count"].')');
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["chem_missed"]);
					$col++;	
					}
					
					$row++;
					$i++;
				}



				//////////////sheet 2/////////


$objWorkSheet='';

		$j=1;

		$AVERAGE=mysql_query("SELECT DATEDIFF('".$_REQUEST["to_date"]."', '".$_REQUEST["from_date"]."') AS days");$A=mysql_fetch_object($AVERAGE);	

		$a=mysql_query("SELECT (SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id =representative.id AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (`tbl_work_plan`.wp_date BETWEEN '".date("Y/m/d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id=representative.id GROUP BY wp_dc_id)) dc_missed,(SELECT COUNT(*) AS CHEMIST FROM tbl_customer_master WHERE rep_id =representative.id AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (`tbl_work_plan`.wp_date BETWEEN '".date("Y/m/d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='C' AND wp_rep_id=representative.id GROUP BY wp_dc_id)) chem_missed,(select COUNT(*) FROM doctors WHERE rep_id=representative.id) as doc_count,(select COUNT(*) FROM tbl_customer_master WHERE rep_id=representative.id) chem_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN wp_dc= 'D' THEN wp_dc_id END) as D,COUNT(DISTINCT CASE WHEN wp_dc= 'C' THEN wp_dc_id END) as C FROM tbl_work_plan,representative WHERE (tbl_work_plan.wp_date BETWEEN '".date("Y/m/d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y/m/d",strtotime($_REQUEST["to_date"]))."') AND tbl_work_plan.wp_rep_id=representative.id GROUP BY tbl_work_plan.wp_rep_id ORDER BY tbl_work_plan.wp_rep_id");

        while($y_customer=mysql_fetch_assoc($a)){		

		$col=0;
		$row_1 = 4;	

					$objWorkSheet = $yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:E1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:E1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:E1','9d9b9b');
					mytemplate_design_fcolor('A1:E1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:E2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$customer11->rep_name);
					$objWorkSheet->getStyle('A2:E2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:E2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:E2','0e7cd8');

					$objWorkSheet->mergeCells('A3:E3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE MISSED REPORT");
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:E3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');


					$objWorkSheet->getStyle('A1:E1')->applyFromArray($styleArray);
					$objWorkSheet->getStyle('A2:E2')->applyFromArray($styleArray);
					$objWorkSheet->getStyle('A3:E3')->applyFromArray($styleArray);
					$objWorkSheet->getStyle('A4:E4')->applyFromArray($styleArray);


					///////////////////////////////////////////// Doctor Missed List /////////////////////////////////////////////
					if($_SESSION['doc_cnt']>0){

						$num1=5;
						$s_no1=1;
						// $SQL=mysql_query("SELECT (select pincode_list.area_name FROM pincode_list WHERE pincode_list.pincode=doctors.doc_pincode GROUP BY pincode_list.pincode) as area_name,doctors.doctor_name,doctors.doc_pincode FROM doctors WHERE doctors.rep_id ='".$y_customer["R"]."' AND doctors.id NOT IN (SELECT tbl_work_plan.wp_dc_id FROM tbl_work_plan WHERE (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='".$y_customer["R"]."' GROUP BY tbl_work_plan.wp_dc_id)");

						// $SQL=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=doctors.doc_pincode GROUP BY pincode) as area_name,doctors.doctor_name,doctors.doc_pincode,reporteddate,reportedtime,prescriptionvalue,pobvalue FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");
						$SQL=mysql_query("SELECT doctor_name,doc_pincode FROM doctors WHERE rep_id ='".$y_customer["R"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='D' AND wp_rep_id='".$y_customer["R"]."' GROUP BY wp_dc_id)");
						// $SQL=mysql_query("SELECT  pincode_list.area_name,pincode_list.pincode
						// -- ,doctors.doctor_name,doctors.doc_pincode,doctors.rep_id,doctors.doc_pincode,tbl_work_plan.wp_dc,tbl_work_plan.wp_date,tbl_work_plan.wp_rep_id
						// FROM pincode_list 
						// -- ,doctors,tbl_work_plan
						// WHERE pincode_list.pincode=doctors.doc_pincode AND doctors.rep_id ='".$y_customer["R"]."' 
						// AND 
						// tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='".$y_customer["R"]."'
						//  ");
						//  print_r('jj');exit();

						// $test=mysql_fetch_array($SQL);

						$num_rows1=mysql_num_rows($SQL);
						if($num_rows1 > 0){

							$num1=$num1+$num_rows1;

							$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
			
							
							$objWorkSheet->mergeCells('A'.$row_1.':C'.$row_1);
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL"])." MISSED LIST");
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':C'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(34);


							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"]));
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "PINCODE - AREA");


							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':C'.$row_1,'eceeef');	

							$row_1++;
						}
						while ($row1=mysql_fetch_array($SQL)) {
                            $rrr=$row1['doc_pincode'];
							$AREA=mysql_query("SELECT area_name FROM pincode_list WHERE pincode='$rrr' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
						// print_r($areaname);exit();

							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doctor_name']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_pincode'].' - '.$areaname->area_name);
							$col_1++;
					

							$s_no1++;
							$row_1++;
						}
					}

					///////////////////////////////////////////// Chemist Missed List /////////////////////////////////////////////
					if($_SESSION['chem_cnt']>0){

						$s_no2=1;
						// $SQL1=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=tbl_customer_master.pincode GROUP BY pincode) as area_name,shop_name,pincode FROM tbl_customer_master WHERE rep_id ='".$y_customer["R"]."' AND id NOT IN (SELECT wp_dc_id FROM tbl_work_plan WHERE (tbl_work_plan.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc='C' AND wp_rep_id='".$y_customer["R"]."' GROUP BY wp_dc_id)");

						$SQL1=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=doctors.doc_pincode GROUP BY pincode) as area_name, tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_customer_master.shop_name");
						$num_rows2=mysql_num_rows($SQL1);

						if($num_rows2 > 0){
							$row_1=$row_1+2;

							$num2=$row_1;
							$num2=$num2+$num_rows2+1;
							$objWorkSheet->getStyle('A'.$row_1.':A'.$num2)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B'.$row_1.':B'.$num2)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C'.$row_1.':C'.$num2)->applyFromArray($styleArray);
					


							$objWorkSheet->mergeCells('A'.$row_1.':C'.$row_1);
						if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL1"])." MISSED LIST");
						} else {
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL"])." MISSED LIST");
						}
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':C'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(34);
					


							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
						if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL1"]));
						} else {
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"]));
						}
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "PINCODE - AREA");

					

							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':C'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':C'.$row_1,'eceeef');	

							$row_1++;
						}

						while ($row2=mysql_fetch_array($SQL1)) {
							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no2);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['shop_name']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row2['pincode'].' - '.$row2['area_name']);
							$col_1++;
					

							$s_no2++;
							$row_1++;
						}
					}

					///////////////////////////////////////////// Doctor List /////////////////////////////////////////////
					if($_SESSION['doc_cnt']>0){

						$s_no3=1;
						$SQL=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=doctors.doc_pincode GROUP BY pincode) as area_name,doctors.doctor_name,doctors.doc_pincode,reporteddate,reportedtime FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");
						$num_rows3=mysql_num_rows($SQL);


						if($num_rows3 > 0){
							$row_1=$row_1+2;

							$num3=$row_1;
							$num3=$num3+$num_rows3+1;
							$objWorkSheet->getStyle('A'.$row_1.':A'.$num3)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B'.$row_1.':B'.$num3)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C'.$row_1.':C'.$num3)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('D'.$row_1.':D'.$num3)->applyFromArray($styleArray);
				


							$objWorkSheet->mergeCells('A'.$row_1.':D'.$row_1);
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - VISITED ".strtoupper($_SESSION["LABEL"])." LIST");
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':D'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(34);
							$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	
	


							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"]));
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "LAST VISITED");
							$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "PINCODE - AREA");
				

							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':D'.$row_1,'eceeef');	

							$row_1++;
						}

						while ($row1=mysql_fetch_array($SQL)) {
							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no3);
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
					
							$s_no3++;
							$row_1++;
						}
					}

					///////////////////////////////////////////// Chemist List /////////////////////////////////////////////
					if($_SESSION['chem_cnt']>0){

						$s_no4=1;
						$SQL1=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=tbl_customer_master.pincode GROUP BY pincode) as area_name,tbl_customer_master.shop_name,tbl_customer_master.pincode,reporteddate,reportedtime FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc_id=tbl_customer_master.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND wp_dc ='C' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");
						$num_rows4=mysql_num_rows($SQL1);

						if($num_rows4 > 0){
							$row_1=$row_1+2;

							$num4=$row_1;
							$num4=$num4+$num_rows4+1;
							$objWorkSheet->getStyle('A'.$row_1.':A'.$num4)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B'.$row_1.':B'.$num4)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C'.$row_1.':C'.$num4)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('D'.$row_1.':D'.$num4)->applyFromArray($styleArray);


							$objWorkSheet->mergeCells('A'.$row_1.':D'.$row_1);
						if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - VISITED ".strtoupper($_SESSION["LABEL1"])." LIST");
						} else {
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - VISITED ".strtoupper($_SESSION["LABEL"])." LIST");
						}
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':D'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(34);
							$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	
				

							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
						if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0){
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL1"]));
						} else {
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"]));
						}
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "LAST VISITED");
							$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "PINCODE - AREA");
						

							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':D'.$row_1,'eceeef');	

							$row_1++;
						}
						while ($row2=mysql_fetch_array($SQL1)) {
							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no4);
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
						

							$s_no4++;
							$row_1++;
						}
					}

					
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