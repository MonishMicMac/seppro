<?php
//include PHPExcel library
// echo "hi";
// exit();
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
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
// mytemplate_design_bg('A1:E1','9d9b9b');
// mytemplate_design_fcolor('A1:E1','FFFFFF');

// $from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
// $MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
// $R_MDATE=mysql_fetch_object($MDATE);

if($_REQUEST['from_date']!='')
{   
	$_REQUEST["from_date"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
	$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);
}
else
{
	$_REQUEST["month_year"]=date("Y-m",strtotime($_REQUEST["month_year"]))."-01";
	$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["month_year"]."',interval 0 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);
}

if($_REQUEST['doctor_checking']=="All")
{
	$repname=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["representative"]."'")or die(mysql_error());
}

elseif($_REQUEST['doctor_checking']=="Regular visit")
{
	$repname=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["representative"]."'")or die(mysql_error());
}
elseif($_REQUEST['doctor_checking']=="Surgery")
{
	$repname=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["representative"]."'")or die(mysql_error());
}
else
{
	$repname=mysql_query("SELECT rep_name,id FROM representative WHERE id='".$_REQUEST['rep_name']."' ");
}   

//$repname=mysql_query("SELECT rep_name,id FROM representative WHERE id='".$_REQUEST['rep_name']."' ");
$repname_row=mysql_fetch_array($repname);

$yuvaraj->getActiveSheet()->mergeCells('A2:J2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $repname_row['rep_name'].' - '.$_REQUEST["from_date"].' to '.$R_MDATE->LastDay);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(5);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DOCTOR NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "HOSPITAL NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "AREA");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "NO OF COUNT");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(20);


if($_REQUEST['doctor_checking']=="All")
{
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "ALL DAYS");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(15);
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "REGULAR COUNT");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(20);

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "REGULAR DAYA");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(20);

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "SURGERY COUNT");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(20);

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 3, "SURGERY DAYS");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(20);
}
if($_REQUEST['doctor_checking']=="Regular visit")
{	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "REGULAR COUNT");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(20);
}
if($_REQUEST['doctor_checking']=="Surgery")
{
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "REGULAR DAYS");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(15);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "TRAY DETAILS");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(20);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "NO OF CARES");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(20);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "VALUES");
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(20);
}
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $yuvaraj->getActiveSheet()->freezePane('A4');	
// mytemplate_design_bg('A3:E3','eceeef');	

$row = 4;	
$i=1;
$totpr=0;
// $SQL=mysql_query("SELECT * from doctors where  id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_name']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");

if($_REQUEST['doctor_checking']=="All")
{
	$SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."')) ORDER BY doctor_name ASC");

}
elseif ($_REQUEST['doctor_checking']=="Regular visit") 
{
	$SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND promotion_service='".$_REQUEST['doctor_checking']."' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."')) ORDER BY doctor_name ASC");
}

elseif ($_REQUEST['doctor_checking']=="Surgery") 
{
	$SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND promotion_service='".$_REQUEST['doctor_checking']."' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."')) ORDER BY doctor_name ASC");
}
else
{

	$SQL=mysql_query("SELECT * from doctors where   id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_name']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."')) ORDER BY doctor_name ASC");

}

while($Y=mysql_fetch_object($SQL)){	
	$pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$Y->doc_pin_id."' ");	
	$pinarea_res=mysql_fetch_object($pinarea);
	
	if($_REQUEST['doctor_checking']=="All")
	{
		// echo "SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ";
		$visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid,SUM(CASE WHEN promotion_service = 'Surgery' THEN 1 ELSE 0 END) AS surgery,SUM(CASE WHEN promotion_service = 'Regular visit' THEN 1 ELSE 0  END) AS regular
			from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	}


	elseif($_REQUEST['doctor_checking']=="Regular visit")
	{
		$visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	}


	elseif($_REQUEST['doctor_checking']=="Surgery")
	{
		$visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	}
	else
	{
		$visitcount=mysql_query("SELECT Count(wp_dc_id) AS clid from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	}
	$visitcount_res=mysql_fetch_object($visitcount);

	$col=0;
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->doctor_name);						
	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->doc_hospital_clinic_name);						
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $pinarea_res->area_name);						
	$col++;	

	if($_REQUEST['doctor_checking']=="All")
	{

		$cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");

		 $cldatereg=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='Regular visit' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
        // while($cldate_res=mysql_fetch_object($cldate)){
         $cldate_resreg=mysql_fetch_object($cldatereg);

         $cldatesug=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate,reporteddate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='Surgery' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
        // while($cldate_res=mysql_fetch_object($cldate)){
         $cldate_ressug=mysql_fetch_object($cldatesug);
	}	

	elseif($_REQUEST['doctor_checking']=="Regular visit")
	{

		$cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	}	 

	elseif($_REQUEST['doctor_checking']=="Surgery")
	{
		$cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate,reporteddate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."'  AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND promotion_service='".$_REQUEST['doctor_checking']."' AND `wp_rep_id`='".$_REQUEST['representative']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	}	

	else
	{
		$cldate=mysql_query("SELECT group_concat(date_format(reporteddate,'%d')) AS rpdate from tbl_work_plan where (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') AND `wp_rep_id`='".$_REQUEST['rep_name']."' AND wp_dc_id='".$Y->id."' AND attendancestatus='1' ");
	}
	// while($cldate_res=mysql_fetch_object($cldate)){
	$cldate_res=mysql_fetch_object($cldate);	

		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $visitcount_res->clid);
	$col++;				

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cldate_res->rpdate.',');
	
	// }
	$col++;							

	if($_REQUEST['doctor_checking']=="All")
	{
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $visitcount_res->regular);
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cldate_resreg->rpdate.',');
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $visitcount_res->surgery);
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cldate_ressug->rpdate.',');
		$col++;	
	}
	if($_REQUEST['doctor_checking']=="Surgery")
	{
		$doc=mysql_query("SELECT * from tbl_work_plan where wp_dc_id='".$Y->id."' AND reporteddate='".$cldate_res->reporteddate."'");
		$doc_res=mysql_fetch_array($doc);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $doc_res['tray_details']);
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $doc_res['cares']);
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $doc_res['values_info']);
		$col++;	
	}
	$row++;
	
	
	$i++;
}
// exit();
$col--;	

// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totpr);
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);
$row=$row-1;
$yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('F1:F'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('G1:G'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('H1:H'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('I1:I'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('J1:J'.$row)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->setTitle($repname_row["rep_name"]);
$yuvaraj->getActiveSheet()->setTitle("visited");

$objWorkSheet=$yuvaraj->createSheet(1);
		// echo "SELECT * from doctors where  `rep_id`='".$_REQUEST['rep_name']."' AND id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_name']."' AND attendancestatus='0' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))";
		// exit();
// $a=mysql_query("SELECT * from doctors where  `rep_id`='".$_REQUEST['rep_name']."' AND id IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_name']."' AND attendancestatus='0' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
// while($y_customer=mysql_fetch_assoc($a)){		
$col=0;
$row_1 = 4;	



$objWorkSheet->mergeCells('A1:E1');

$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$objWorkSheet->getStyle('A1:E1')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(1)->setRowHeight(17);
$objWorkSheet->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objWorkSheet->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					// mytemplate_design_bg('A1:D1','9d9b9b');
					// mytemplate_design_fcolor('A1:D1','FFFFFF');

if($_REQUEST['doctor_checking']=="All")
{
	$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["representative"]."'")or die(mysql_error());
}

elseif($_REQUEST['doctor_checking']=="Regular visit")
{
	$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["representative"]."'")or die(mysql_error());
}
elseif($_REQUEST['doctor_checking']=="Surgery")
{
	$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["representative"]."'")or die(mysql_error());
}
else
{
	$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_name"]."'")or die(mysql_error());
}
$customer11=mysql_fetch_object($a1);

$objWorkSheet->mergeCells('A2:E2');
$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("Y-m-d",strtotime($_REQUEST["from_date"]))." TO ".date("Y-m-d",strtotime($R_MDATE->LastDay)));
$objWorkSheet->getStyle('A2:E2')->getFont()->setSize(10);
$objWorkSheet->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:E2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// mytemplate_design_fcolor('A2:D2','0e7cd8');

					$objWorkSheet->mergeCells('A3:E3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE MISSED CALL REPORT");
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:E3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');	

					// $objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
					// $objWorkSheet->getColumnDimensionByColumn(1)->setWidth(30);
					// $objWorkSheet->getColumnDimensionByColumn(2)->setWidth(30);
					// $objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	

					///////////////////////////////////////////// Doctor List /////////////////////////////////////////////
					
					$num1=5;
					$s_no1=1;
					if($_REQUEST['doctor_checking']=="All")
					{
						$SQL=mysql_query("SELECT * from doctors where  `rep_id`='".$_REQUEST['representative']."' AND id NOT IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
					}
					elseif($_REQUEST['doctor_checking']=="Regular visit")
					{
						$SQL=mysql_query("SELECT * from doctors where  `rep_id`='".$_REQUEST['representative']."' AND id NOT IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND promotion_service='".$_REQUEST['doctor_checking']."' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
					}
					elseif($_REQUEST['doctor_checking']=="Surgery")
					{
						$SQL=mysql_query("SELECT * from doctors where  `rep_id`='".$_REQUEST['representative']."' AND id NOT IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['representative']."' AND attendancestatus='1' AND promotion_service='".$_REQUEST['doctor_checking']."' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["month_year"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
					}
					else
					{
						$SQL=mysql_query("SELECT * from doctors where  `rep_id`='".$_REQUEST['rep_name']."' AND id NOT IN (select wp_dc_id from tbl_work_plan WHERE wp_rep_id='".$_REQUEST['rep_name']."' AND attendancestatus='1' AND (reporteddate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."'))");
					}
					$num_rows1=mysql_num_rows($SQL);
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
								)
							)
						);

					if($num_rows1 > 0){

						$num1=$num1+$num_rows1;

						$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);

						$objWorkSheet->mergeCells('A'.$row_1.':E'.$row_1);

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $customer11->rep_name." - MISSED ".strtoupper($_SESSION["LABEL"])." LIST");
						// 	echo "hi";
						// exit();
						$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getFont()->setSize(13);
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							// mytemplate_design_fcolor('A'.$row_1.':D'.$row_1,'317eac');
						$row_1++;

						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(30);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(30);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(20);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(20);	

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "DOCTOR NAME");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "HOSPITAL NAME");
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "AREA");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "PINCODE");

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							// mytemplate_design_bg('A'.$row_1.':D'.$row_1,'eceeef');	
						$row_1++;
					}


					while ($row1=mysql_fetch_array($SQL)) {
						$pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$row1["doc_pin_id"]."' ");	
						$pinarea_res=mysql_fetch_object($pinarea);
						$col_1 = 0;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doctor_name']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_hospital_clinic_name']);
						$col_1++;

						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $pinarea_res->area_name);
						
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_pincode']);
						$col_1++;

						$s_no1++;
						$row_1++;
					}
					
					$objWorkSheet->setTitle("missed");
					$yuvaraj->setActiveSheetIndex(0);

//prepare download
// $filename="Product Report.xls"; //just some random filename
					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="'.$repname_row['rep_name'].' visit report".xls');
					header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>