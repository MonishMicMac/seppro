<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:E1','9d9b9b');
mytemplate_design_fcolor('A1:E1','FFFFFF');
$from_date=date("Y-m",strtotime($_REQUEST["month_year"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

$repname=mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST['mgr']."' ");
$repname_row=mysql_fetch_array($repname);

$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $repname_row['rep_name'].' - '.date("F Y",strtotime($_REQUEST["month_year"])));
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "REP NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "HQ ID");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "JWT");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "NO OF DOCTORS");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "FIRST DR TIME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "LAST DR TIME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "SWP");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "SWP DR MEET");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(35);

// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 3, "SWP DR MEET");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(35);

// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 3, "SWP DR MEET");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(35);
$yuvaraj->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');	
mytemplate_design_bg('A3:K3','eceeef');	

$row = 4;	
$i=1;
$totpr=0;


$Daysperiod=mysql_query("select * from 
	(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
		(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
		(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
		(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
		(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
		(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where (selected_date BETWEEN  '".date("Y-m-d",strtotime($from_date))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') ");

while($D=mysql_fetch_array($Daysperiod)){ 
	$pp=0;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $D["selected_date"]);						
		
		// echo "SELECT assigningreptomanager.repid,representative.rep_name FROM assigningreptomanager,representative WHERE assigningreptomanager.managerid = '".$_REQUEST['mgr']."'AND assigningreptomanager.repid=representative.id ";
		$a5 = mysql_query("SELECT assigningreptomanager.repid,representative.rep_name FROM assigningreptomanager,representative WHERE assigningreptomanager.managerid = '".$_REQUEST['mgr']."'AND assigningreptomanager.repid=representative.id ");

	while($a5_row=mysql_fetch_array($a5))
	{

	// echo "SELECT GROUP_CONCAT( jointworkby ) AS jointbynew, min(reportedtime) AS firstdrtime,max(reportedtime) AS seconddrtime,concat((case when group_concat(latitude)!='' then group_concat(latitude) else '0' end),' - ',(case when group_concat(longitude)!='' then group_concat(longitude) else '0' end))  as lat_lon FROM tbl_work_plan WHERE reporteddate = '".date("Y-m-d",strtotime($D["selected_date"]))."' AND wp_rep_id = '".$a5_row['repid']."' AND attendancestatus='1' ";
		$a6 = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id = '".$a5_row['repid']."' ");
	$a6_row=mysql_fetch_array($a6);
	$a7 = mysql_query("SELECT sum(case when mtp='1' then '1' else '0' end) as total_swp,sum(case when mtp='1' and attendancestatus='1' and drunavailable='0' then '1' else '0' end) as total_swp_visit FROM tbl_work_plan WHERE wp_date='".date("Y-m-d",strtotime($D["selected_date"]))."' AND wp_rep_id = '".$a5_row['repid']."'");
	$a7_row=mysql_fetch_array($a7);

	$a1 = mysql_query("SELECT GROUP_CONCAT( jointworkby ) AS jointbynew, min(reportedtime) AS firstdrtime,max(reportedtime) AS seconddrtime FROM tbl_work_plan WHERE reporteddate = '".date("Y-m-d",strtotime($D["selected_date"]))."' AND wp_rep_id = '".$a5_row['repid']."' AND attendancestatus='1' ");
	$a1_row=mysql_fetch_array($a1);
	// 	echo $a1_row['firstdrtime'];
	// echo  $a1_row['seconddrtime'];
	$SQL1=mysql_query("SELECT (case  when id='7' then 'GM' else 'BPM' end) as rep_name FROM representative WHERE id IN (".$a1_row['jointbynew'].")");
	$num_rows1=mysql_num_rows($SQL1);

	if($num_rows1==0){
		$rep2='NO JWE';
	}
	else
	{
		while($row1=mysql_fetch_array($SQL1))
		{
			if($pp==0)
			{
				$rep1=$row1['rep_name'];
				$rep2=$rep1;
			}
			elseif($pp==1)
			{
				$rep2=$rep1.'('.$row1['rep_name'].')';
			}
			$pp++;

		}
	}


	$a = mysql_query("SELECT count(wp_dc_id) AS utwp FROM unapprovedtbl_work_plan WHERE reporteddate = '".date("Y-m-d",strtotime($D["selected_date"]))."' AND wp_rep_id = '".$a5_row['repid']."' AND attendancestatus='1' AND wp_dc='D' ");		
	$rownew=mysql_fetch_array($a);
	$a1 = mysql_query("SELECT count(wp_dc_id) AS twp FROM tbl_work_plan WHERE reporteddate = '".date("Y-m-d",strtotime($D["selected_date"]))."' AND wp_rep_id = '".$a5_row['repid']."' AND attendancestatus='1' AND wp_dc='D' ");		
	$rownew1=mysql_fetch_array($a1);
	$totdoctor=$rownew['utwp']+$rownew1['twp'];

	$col=1;
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
	// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
	// $col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $a5_row["rep_name"]);						
	$col++;						
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $a6_row["headquarters_name"]);						
	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rep2);						
	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totdoctor);						
	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $a1_row['firstdrtime']);						
	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $a1_row['seconddrtime']);						
	$col++;	

	// 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $a7_row['total_swp']);						
	// $col++;	
	// 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $a7_row['total_swp_visit']);						
	// $col++;


	$row++;
	
	
	// $i++;
	$allown1=$allown1+$allown;
}
}
// exit();

$col--;	

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $allown1);
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
$yuvaraj->getActiveSheet()->setTitle($repname_row["rep_name"]);
// prepare download
$filename="Product Report.xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$repname_row['rep_name'].' visit report".xls');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>