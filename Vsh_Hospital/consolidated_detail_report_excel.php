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
$branch=$_REQUEST["branch"];
$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

// mytemplate_design_bg('A1:D1','9d9b9b');
// mytemplate_design_fcolor('A1:D1','FFFFFF');

$total=0;
// echo "hi";
// exit();
$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// mytemplate_design_fcolor('A2:D2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:E3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE DETAILED REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(15);
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(40);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(15);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(40);


$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");
if($_SESSION['doc_cnt']>0 && $_SESSION['chem_cnt']>0) {	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, strtoupper($_SESSION["LABEL1"]));
} else {
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "BRANCH NAME");
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "MANAGER NAME");
}
$yuvaraj->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:E4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
// mytemplate_design_bg('A4:D4','eceeef');	

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
$a=mysql_query("SELECT representative.id AS R,representative.rep_name AS REP,representative.rep_state_status AS brannmae,COUNT(DISTINCT CASE WHEN wp_dc= 'D' THEN wp_dc_id END) as D,COUNT(DISTINCT CASE WHEN wp_dc= 'C' THEN wp_dc_id END) as C FROM tbl_work_plan,representative WHERE (tbl_work_plan.wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')  AND tbl_work_plan.wp_rep_id IN ($branch) AND `tbl_work_plan`.`wp_rep_id`=representative.id GROUP BY tbl_work_plan.wp_rep_id ORDER BY tbl_work_plan.wp_rep_id");
$num_rows=mysql_num_rows($a);

$num=$num+$num_rows;
$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);


					// $objWorkSheet->getColumnDimensionByColumn(5)->setWidth(24);	

while($y_customer=mysql_fetch_assoc($a)){		
	$DR=mysql_query("SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id='".$Y->R."'");$DRCNT=mysql_fetch_object($DR);
	$CHY=mysql_query("SELECT COUNT(*) AS CHEMIST FROM tbl_customer_master WHERE rep_id='".$Y->R."'");$CHYCNT=mysql_fetch_object($CHY);
	$col=0;
	$row_1 = 1;	
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
	$col++;				
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["REP"]);	
	if($_SESSION['doc_cnt']>0){						
		$col++;						
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["D"].'('.$DRCNT->DOCTOR.')');	
		$col++;
	}					
	if($_SESSION['chem_cnt']>0){
		$col++;						
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["C"].'('.$CHYCNT->CHEMIST.')');
		
		$col++;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["brannmae"]);	
	
	$col++;
	// echo "SELECT rep_name FROM representative WHERE ID=(select managerid from assigningreptomanager where repid='".$y_customer["R"]."') AND `rep_state_status`='".$y_customer["brannmae"]."' AND `rep_id`!=0 order by id limit 1";
	$SQLPROman=mysql_query("SELECT rep_name FROM representative WHERE ID IN (select managerid from assigningreptomanager where repid='".$y_customer["R"]."') AND `rep_state_status`='".$y_customer["brannmae"]."' AND `rep_id`!=0 order by id limit 1");
	$SQLPROman_ROW=mysql_fetch_array($SQLPROman);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SQLPROman_ROW["rep_name"]);	
	$col++;
	$row++;
	$i++;
}
// exit();

$objWorkSheet = $yuvaraj->createSheet(1);
 // echo "hi"; 
$objWorkSheet->mergeCells('A1:H1');

$objWorkSheet->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);

$objWorkSheet->getStyle('A1:H1')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(1)->setRowHeight(17);
$objWorkSheet->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objWorkSheet->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
// mytemplate_design_bg('A1:I1','9d9b9b');
// mytemplate_design_fcolor('A1:I1','FFFFFF');

$total=0;
// echo "hi";
$objWorkSheet->mergeCells('A2:H2');
$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])));
$objWorkSheet->getStyle('A2:H2')->getFont()->setSize(10);
$objWorkSheet->getStyle('A2:H2')->getAlignment()->setShrinkToFit(true);
$objWorkSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$objWorkSheet->getStyle('A2:H2')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(2)->setRowHeight(20);
$objWorkSheet->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// mytemplate_design_fcolor('A2:I2','0e7cd8');

$objWorkSheet->mergeCells('A3:H3');
$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE DETAILED REPORT");
$objWorkSheet->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$objWorkSheet->getStyle('A3:H3')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(3)->setRowHeight(20);
$objWorkSheet->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(25);
// $yuvaraj->setCellValueByColumnAndRow(0, 4, "");
$objWorkSheet->setCellValueByColumnAndRow(0, 4, "BRANCH NAME");
$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
$objWorkSheet->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE NAME");
//$yuvaraj->setCellValueByColumnAndRow(3, 4, "MANAGER NAME");
$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
$objWorkSheet->setCellValueByColumnAndRow(3, 4, "VISIT DATE");
$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(25);
$objWorkSheet->setCellValueByColumnAndRow(3, 4, strtoupper($_SESSION["LABEL"]));
$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(25);
$objWorkSheet->setCellValueByColumnAndRow(4, 4, "PIN CODE");
$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(35);
$objWorkSheet->setCellValueByColumnAndRow(5, 4, "PRODUCT DISCUSSED WITH DOCTOR");
$objWorkSheet->setCellValueByColumnAndRow(6, 4, "FEED BACK OF THE MEETING");
$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(35);
$objWorkSheet->getColumnDimensionByColumn(7)->setWidth(25);
$objWorkSheet->setCellValueByColumnAndRow(7, 4, "COMPITETOR DETAILS");
$objWorkSheet->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$objWorkSheet->getStyle('A4:H4')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(4)->setRowHeight(20);
$objWorkSheet->getStyle('A4:H4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objWorkSheet->freezePane('A5');	
// mytemplate_design_bg('A4:I4','eceeef');	

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

	$objWorkSheet->getRowDimension($row)->setRowHeight(17);
					// $yuvaraj->setCellValueByColumnAndRow($col, $row, $i);
					// $col++;

	$objWorkSheet->setCellValueByColumnAndRow($col, $row,$y_customer["BRANCH"]);						
	$col++;	

	$objWorkSheet->setCellValueByColumnAndRow($col, $row,$y_customer["REP"]);						
	$col++;	



	$SQL=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=doctors.doc_pincode GROUP BY pincode) as area_name,doctors.doctor_name,doctors.doc_pincode,doctors.com_name,reporteddate,reportedtime,productname,drunavailablereason FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc_id=doctors.id AND wp_rep_id='".$y_customer["R"]."' AND (wp_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST["from_date"]))."' AND '".date('Y-m-d',strtotime($_REQUEST["to_date"]))."') AND wp_dc ='D' GROUP BY tbl_work_plan.wp_dc_id ORDER BY tbl_work_plan.reporteddate DESC");

	$num_rows=mysql_num_rows($SQL);
	$objWorkSheet->mergeCells('A'.$row.':A'.($row+$num_rows-1));
	$objWorkSheet->mergeCells('B'.$row.':B'.($row+$num_rows-1));



	while($fetch_row=mysql_fetch_assoc($SQL))
	{
		$select_product=mysql_query("SELECT id,pro_name from product WHERE id='".$fetch_row["productname"]."'");
		$fetch_product=mysql_fetch_assoc($select_product);
		
		$select_comepetitors=mysql_query("SELECT c_id,com_name from comepetitors WHERE c_id='".$fetch_row["com_name"]."'");
		$fetch_comepetitors=mysql_fetch_assoc($select_comepetitors);
		
		$col=0;
		$row_1 = 1;	

		$objWorkSheet->getStyle('A1:A'.$row)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('B1:B'.$row)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('C1:C'.$row)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('D1:D'.$row)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('E1:E'.$row)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('F1:F'.$row)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('G1:G'.$row)->applyFromArray($styleArray)->getAlignment()
		->setWrapText(true);
		$objWorkSheet->getStyle('H1:H'.$row)->applyFromArray($styleArray);
		// $yuvaraj->getStyle('I1:I'.$row)->applyFromArray($styleArray);
		
		        // $yuvaraj->setCellValueByColumnAndRow($col, $row, $i);
					// $col++;

		$objWorkSheet->setCellValueByColumnAndRow(2, $row, $fetch_row['reporteddate']);						
		$col++;
		$objWorkSheet->setCellValueByColumnAndRow(3, $row, $fetch_row['doctor_name']);						
		$col++;
		$objWorkSheet->setCellValueByColumnAndRow(4, $row, $fetch_row['doc_pincode'].' - '.$fetch_row['area_name']);						
		$col++;

		$objWorkSheet->setCellValueByColumnAndRow(5, $row, $fetch_product["pro_name"]);						
		$col++;						

		$objWorkSheet->setCellValueByColumnAndRow(6, $row, $fetch_row["drunavailablereason"]);						
		$objWorkSheet->getRowDimension($row)->setRowHeight(-1);
		$col++;

		$objWorkSheet->setCellValueByColumnAndRow(7, $row, $fetch_comepetitors["com_name"]);						
		$col++;

		$row++;
		$i++;
	}

}     

$objWorkSheet->setTitle("comments");
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