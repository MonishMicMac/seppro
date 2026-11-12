<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
//load Excel template file
$objPHPExcel = PHPExcel_IOFactory::load("yuvaraj.xls");
$objPHPExcel->setActiveSheetIndex(0);

$full_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$rep_id=$_REQUEST["rep_id"];
$total_date=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

$sql1=mysql_query("SELECT rep_name FROM representative WHERE id='".$rep_id."'")or die(mysql_error());$row1=mysql_fetch_array($sql1);
$row=1;

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Date");
$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "SWP");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, "DCR");
$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, "SWP Visited");
$objPHPExcel->getActiveSheet()->mergeCells('H1:J1');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "DCR Visited");
$objPHPExcel->getActiveSheet()->mergeCells('K1:M1');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, "SWP Missed");

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth(16);


// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$sql_g=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='".$rep_id."' ORDER BY id DESC LIMIT 1");
$row_g=mysql_fetch_array($sql_g);
$last_date=$row_g['last_date'];
$last_day=substr($row_g['last_day'], -1);

if($last_day!=''){
	$next_first_date=$full_date;
	$prev_first_date='';

	$d=1;
	while ($prev_first_date < $next_first_date) {
		$prev_day=date('l', strtotime($last_date . ' +'.$d.' day'));
		if($prev_day=='Sunday'){
			if($last_day==1){
				$last_day='2';
			} elseif($last_day==2){
				$last_day='1';
			}
		}
		$prev_first_date=date('Y-m-d', strtotime($last_date . ' +'.$d.' day'));
		$d++;
	}
} else {
	$last_day=1;
}
$last=$last_day;

$row=2;
for ($i=0; $i < $total_date; $i++) { 
	$col=0;
	$date=date('Y-m-d',strtotime($full_date.'+'.$i.' day'));
	$day=date('l',strtotime($date));
	$h=date('d',strtotime($date));

	if($day=='Sunday' && $h!='1'){
		if($last=='1'){
			$last=2;
		} elseif($last=='2'){
			$last=1;
		}
	}

	$value='0';
	if($day!='Sunday'){
		$week_day=$day.$last;
		$sql2=mysql_query("SELECT count(*) as cnt,GROUP_CONCAT(wp_dc_id) as wp_dc_id FROM mst_tour_plan WHERE wp_day='$week_day' AND wp_rep_id='$rep_id'");
		$row2=mysql_fetch_array($sql2);
		$value=$row2['cnt'];
		$wp_dc_id=$row2['wp_dc_id'];

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date('d-m-Y',strtotime($date)));
		$col++;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		$col++;
		$sql_t=mysql_query("SELECT (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doc_name FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_date='$date' AND wp_rep_id='$rep_id' AND wp_dc_id IN ($wp_dc_id)");
		$num_row_t=mysql_num_rows($sql_t);

		if($num_row_t!=''){ $cnt=number_format(($num_row_t/$value)*100,2); } else { $cnt='0'; }
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cnt);
		$col++;


		$sql_t1=mysql_query("SELECT (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doc_name FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='0' AND wp_date='$date' AND wp_rep_id='$rep_id' AND wp_dc_id NOT IN ($wp_dc_id)");
		$num_row_t1=mysql_num_rows($sql_t1);

		if($num_row_t1!=''){ $cnt1=$num_row_t1; } else { $cnt1='0'; }
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cnt1);
		$col++;

		$pre_row_t=$row;

		$pre_col_t=$col;
		$t=1;
		while ($row_t=mysql_fetch_array($sql_t)) {

			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($row_t['doc_name']));
			$col++;
			if($t%3==0){
				$row++;
				$col=$pre_col_t;
			}
			$t++;
		}

		$t=$t-1;
		if($t%3==0 && $t>2){
			$row=$row-1;
		}

		if($pre_row_t<$row){
			$objPHPExcel->getActiveSheet()->mergeCells("A$pre_row_t:A$row");
			$objPHPExcel->getActiveSheet()->mergeCells("B$pre_row_t:B$row");
			$objPHPExcel->getActiveSheet()->mergeCells("C$pre_row_t:C$row");
			$objPHPExcel->getActiveSheet()->mergeCells("D$pre_row_t:D$row");
		}

		$col=7;
		$pre_col_t1=$col;
		$t1=1;
		while ($row_t1=mysql_fetch_array($sql_t1)) {

			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($row_t1['doc_name']));
			$col++;
			if($t1%3==0){
				$row++;
				$col=$pre_col_t1;
			}
			$t1++;
		}

		$t1=$t1-1;
		if($t1%3==0 && $t1>2){
			$row=$row-1;
		}

		if($pre_row_t<$row){
			$objPHPExcel->getActiveSheet()->mergeCells("A$pre_row_t:A$row");
			$objPHPExcel->getActiveSheet()->mergeCells("B$pre_row_t:B$row");
			$objPHPExcel->getActiveSheet()->mergeCells("C$pre_row_t:C$row");
			$objPHPExcel->getActiveSheet()->mergeCells("D$pre_row_t:D$row");
		}

		$col=10;
		$pre_col_t2=$col;
		$t2=1;
		$sql_t2=mysql_query("SELECT (select doctor_name from doctors where id=tbl_work_plan.wp_dc_id) as doc_name FROM tbl_work_plan WHERE attendancestatus='1' AND drunavailable='1' AND wp_date='$date' AND wp_rep_id='$rep_id' AND wp_dc_id IN ($wp_dc_id)");
		while ($row_t2=mysql_fetch_array($sql_t2)) {

			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($row_t2['doc_name']));
			$col++;
			if($t2%3==0){
				$row++;
				$col=$pre_col_t2;
			}
			$t2++;
		}

		$t2=$t2-1;
		if($t2%3==0 && $t2>2){
			$row=$row-1;
		}
		if($pre_row_t<$row){
			$objPHPExcel->getActiveSheet()->mergeCells("A$pre_row_t:A$row");
			$objPHPExcel->getActiveSheet()->mergeCells("B$pre_row_t:B$row");
			$objPHPExcel->getActiveSheet()->mergeCells("C$pre_row_t:C$row");
			$objPHPExcel->getActiveSheet()->mergeCells("D$pre_row_t:D$row");
		}

		$row++;
	}
	$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(16);
}

$objPHPExcel->getActiveSheet()->getStyle('A1:D'.($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:M'.($row-1))->applyFromArray(
	array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000')
				)
			)
		)
	);
$objPHPExcel->getActiveSheet()->getStyle('A1:M'.($row-1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

//prepare download
$filename=$row1['rep_name']." - SWP Vs DCR Report"." - ".date("F Y",strtotime($full_date)).".xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>