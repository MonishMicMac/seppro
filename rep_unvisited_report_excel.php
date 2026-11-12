<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3000000);
ini_set('max_execution_time', 1500000);
set_time_limit(0);
error_reporting(E_ALL);//load Excel template file
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:C1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:C1','9d9b9b');
mytemplate_design_fcolor('A1:C1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:C2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:C2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:C3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE UNVISITED REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "UNVISITED");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "CHEMIST");
$yuvaraj->getActiveSheet()->getStyle('A4:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:C3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:C3','eceeef');	

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
		$a=mysql_query("SELECT representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT CASE WHEN `wp_dc`= 'D' THEN `wp_dc_id` END) as D,COUNT(DISTINCT CASE WHEN `wp_dc`= 'C' THEN `wp_dc_id` END) as C FROM `tbl_work_plan`,representative WHERE (`tbl_work_plan`.wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `tbl_work_plan`.`wp_rep_id`=representative.id GROUP BY `tbl_work_plan`.`wp_rep_id` ORDER BY `tbl_work_plan`.`wp_rep_id`");
		$num_rows=mysql_num_rows($a);

		$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 1;	
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["REP"]);						
					$col++;						
					$Missed=mysql_query("SELECT COUNT(attendancestatus) AS missed FROM tbl_work_plan WHERE wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND attendancestatus='0' and wp_dc='D' ");
			$M=mysql_fetch_assoc($Missed);

					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  $M["missed"]);						
					$col++;						
					// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["C"].'('.$y_customer["chem_count"].')');
					
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

					$objWorkSheet->mergeCells('A1:D1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, "ayurveda");
					$objWorkSheet->getStyle('A1:D1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:D1','9d9b9b');
					mytemplate_design_fcolor('A1:D1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:D2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
					$objWorkSheet->getStyle('A2:D2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:D2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:D2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:D2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:D2','0e7cd8');

					$objWorkSheet->mergeCells('A3:D3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE UNVISITED REPORT");
					$objWorkSheet->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:D3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');	

					$num1=5;
					$s_no1=1;
					$SQL=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=doctors.doc_pincode GROUP BY pincode) as area_name,doctors.doctor_name,doctors.doc_pincode,reporteddate,reportedtime,drunavailablereason,wp_date FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".$_REQUEST["from_date"]."' AND attendancestatus='0' AND '".$_REQUEST["to_date"]."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY doctors.doctor_name, tbl_work_plan.wp_id DESC");
					$num_rows1=mysql_num_rows($SQL);


					if($num_rows1 > 0){
						
						$num1=$num1+$num_rows1;
						$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
						// $objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);

						$objWorkSheet->mergeCells('A'.$row_1.':D'.$row_1);
						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - CUSTOMER MISSED LIST");
						$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getFont()->setSize(13);
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_fcolor('A'.$row_1.':D'.$row_1,'317eac');
						$row_1++;

						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(23);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	
						

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "CUSTOMER");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "DATE");						
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "PINCODE - AREA");

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objWorkSheet->getStyle('A'.$row_1.':D'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('A'.$row_1.':D'.$row_1,'eceeef');	
						$row_1++;
					}
					while ($row1=mysql_fetch_array($SQL)) {
						$col_1 = 0;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doctor_name']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['wp_date']);
						$col_1++;
					
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_pincode'].' - '.$row1['area_name']);
						$col_1++;

						$s_no1++;
						$row_1++;
						 $row1['wp_date'];
					}


					$objWorkSheet->setTitle($y_customer["REP"]);

					$j++;
}
// exit();
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