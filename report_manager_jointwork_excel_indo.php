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

$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:E1','9d9b9b');
mytemplate_design_fcolor('A1:E1','FFFFFF');

$total=0;
$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["mgr"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Manager : ".$customer11->rep_name);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:E2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:E3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "MANAGER JOINT WORK REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');		

$row = 4;	

if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){			
	$a=mysql_query("SELECT count(DISTINCT(repid))  as REP,date AS reporteddate FROM `managerjoinworkplans` WHERE (date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and `managerid`='".$_REQUEST['mgr']."' GROUP BY date")or die(mysql_error())or die(mysql_error());
} else {         
	$a=mysql_query("SELECT count(DISTINCT(repid)) as REP,repid,date AS reporteddate FROM `managerjoinworkplans` WHERE (date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and `managerid`='".$_REQUEST['mgr']."' GROUP BY date")or die(mysql_error())or die(mysql_error());
}

while($customer=mysql_fetch_object($a)){
	// echo "SELECT count(DISTINCT(wp_dc_id)) AS DR,Group_concat(wp_dc_id) AS sr FROM tbl_work_plan WHERE reporteddate='".$customer->reporteddate."' AND wp_rep_id='".$customer->repid."' AND attendancestatus='1'";
	$sa51 =  mysql_query("SELECT count(DISTINCT(wp_dc_id)) AS DR,Group_concat(wp_dc_id) AS sr FROM tbl_work_plan WHERE reporteddate='".$customer->reporteddate."' AND wp_rep_id='".$customer->repid."' AND attendancestatus='1'")or die(mysql_error());
	$data51 = mysql_fetch_object($sa51);	
// echo $data51->sr;
	$sa5 =  mysql_query("SELECT Group_concat(`repid`) as rep FROM `managerjoinworkplans` WHERE date ='".$customer->reporteddate."' and `managerid`='".$_REQUEST['mgr']."'")or die(mysql_error());
	$data5 = mysql_fetch_object($sa5);
	$r=$data5->rep;


if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){ 
        $SQL=mysql_query("SELECT doctors.favourite,doctors.id,doctors.doc_hospital_clinic_name,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.doctor_addrs,doctors.doc_specific,doctors.time_specific,representative.rep_name FROM doctors,representative WHERE representative.id=doctors.rep_assign AND doctors.rep_assign IN (".$r.") AND doctors.id IN (".$data51->sr.") ORDER BY doctors.favourite DESC"); 
    } else {
        $SQL=mysql_query("SELECT doctors.favourite,doctors.id,doctors.doc_hospital_clinic_name,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.doctor_addrs,doctors.doc_specific,doctors.time_specific,representative.rep_name FROM doctors,representative WHERE representative.id=doctors.rep_assign AND doctors.rep_assign IN (".$r.") AND doctors.id IN (".$data51->sr.") ORDER BY doctors.favourite DESC"); 
    }

	$CNT=mysql_num_rows($SQL); 

	if($CNT>0){
		$col=0;
		$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("d-m-Y",strtotime($customer->reporteddate)));

		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){ 
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'REP : '.$customer->REP.' CHY : '.$data51->DR);
		} else {
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'REP : '.$customer->REP.' DR : '.$data51->DR);
		}


		$yuvaraj->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
		$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
		mytemplate_design_bg('A'.$row.':E'.$row,'006535');
		mytemplate_design_fcolor('A'.$row.':E'.$row,'FFFFFF');
		$col++;	
		$row++;

		$col=0;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "S.NO");
		$col++;	
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "REPRESENTATIVE");
		$col++;	
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($_SESSION["LABEL"])." NAME");
		$col++;	
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "FEEDBACK");
		$col++;	
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "REPORTED TIME");
		$col++;	

		$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
		$yuvaraj->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		mytemplate_design_bg('A'.$row.':E'.$row,'eceeef');
		$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);

		$row++;

		$i=1;

		while($RS=mysql_fetch_object($SQL)){
			   $sa15 =  mysql_query("SELECT * FROM `tbl_work_plan` WHERE wp_rep_id ='".$customer->repid."' and `reporteddate`='".$customer->reporteddate."' AND wp_dc_id='".$RS->id."'")or die(mysql_error());
$data15 = mysql_fetch_object($sa15);
if($RS->favourite=='1'){
		mytemplate_design_bg('A'.$row.':E'.$row,'d1ea6d');
			$col=0;
			$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($RS->rep_name));
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($RS->doctor_name));
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data15->drunavailablereason);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data15->reportedtime);
			$col++;	

			$row++;
		}
		else
		{
				$col=0;
			$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($RS->rep_name));
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($RS->doctor_name));
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data15->drunavailablereason);
			$col++;	
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data15->reportedtime);
			$col++;	

			$row++;
		}
			$i++;
		}

		$row++;
	}
}


$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);
$row=$row-2;
$yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);

// exit();
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Manager : ".$customer11->rep_name.".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>