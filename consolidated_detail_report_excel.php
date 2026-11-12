<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 150000);
//load Excel template file
//Worked Nirmal
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:G1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Be Well Hospitals - No 20 Maharaja Surya Road,Alwarpet Chennai-600018.date - ".date('Y-m-d'));
$yuvaraj->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:G1','9d9b9b');
mytemplate_design_fcolor('A1:G1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:G2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:G2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:G3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPORTS");
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "BRANCH NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "REPRESENTATIVE NAME");
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "MANAGER NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "VISIT DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "PRODUCT DISCUSSED WITH DOCTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "FEED BACK OF THE MEETING");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(35);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "COMPITETOR DETAILS");
$yuvaraj->getActiveSheet()->getStyle('A4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:G4','eceeef');	

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
		$branch=$_REQUEST["branch"];
			
		$a=mysql_query("SELECT representative.id AS R,representative.rep_name AS REP,representative.rep_state_status AS BRANCH,COUNT(DISTINCT CASE WHEN `wp_dc`= 'D' THEN `wp_dc_id` END) as D,COUNT(DISTINCT CASE WHEN `wp_dc`= 'C' THEN `wp_dc_id` END) as C FROM `tbl_work_plan`,representative WHERE (`tbl_work_plan`.wp_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST["from_date"]))."' AND '".date('Y-m-d',strtotime($_REQUEST["to_date"]))."') AND `tbl_work_plan`.`wp_rep_id` IN($branch) AND `tbl_work_plan`.`wp_rep_id`=representative.id GROUP BY `tbl_work_plan`.`wp_rep_id` ORDER BY `tbl_work_plan`.`wp_rep_id`");
		$num_rows=mysql_num_rows($a);
        $num=$num+$num_rows;
		
	
	
        while($y_customer=mysql_fetch_assoc($a)){
		
		        $col=0;
		        $row_1 = 1;	
				
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
					$col++;
		
		            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$y_customer["BRANCH"]);						
					$col++;	
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$y_customer["REP"]);						
					$col++;	
		
		
		
		$SQL=mysql_query("SELECT doctors.doctor_name,doctors.doc_pincode,doctors.com_name,reporteddate,reportedtime,productname,drunavailablereason FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST["from_date"]))."' AND '".date('Y-m-d',strtotime($_REQUEST["to_date"]))."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");
		
		$num_rows=mysql_num_rows($SQL);
     	$yuvaraj->getActiveSheet()->mergeCells('B'.$row.':B'.($row+$num_rows-1));
     	$yuvaraj->getActiveSheet()->mergeCells('C'.$row.':C'.($row+$num_rows-1));
		
		
		
		while($fetch_row=mysql_fetch_assoc($SQL))
		{
		$select_product=mysql_query("SELECT id,pro_name from product WHERE id='".$fetch_row["productname"]."'");
		$fetch_product=mysql_fetch_assoc($select_product);
		
		$select_comepetitors=mysql_query("SELECT c_id,com_name from comepetitors WHERE c_id='".$fetch_row["com_name"]."'");
		$fetch_comepetitors=mysql_fetch_assoc($select_comepetitors);
		
		    $col=0;
		    $row_1 = 1;	
				
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('F1:F'.$row)->applyFromArray($styleArray)->getAlignment()
    ->setWrapText(true);
		$yuvaraj->getActiveSheet()->getStyle('G1:G'.$row)->applyFromArray($styleArray);
		
		        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
					$col++;
					
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $fetch_row['reporteddate']);						
					$col++;
									
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $fetch_product["pro_name"]);						
					$col++;						
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $fetch_row["drunavailablereason"]);						
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
					$col++;
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $fetch_comepetitors["com_name"]);						
					$col++;
					
					$row++;
					$i++;
					}
				
              }      
           

$yuvaraj->setActiveSheetIndex(0);
	
		
//prepare download
$filename="Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])).".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>