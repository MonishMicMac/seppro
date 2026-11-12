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

$yuvaraj->getActiveSheet()->mergeCells('A1:G1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:G1','9d9b9b');
mytemplate_design_fcolor('A1:G1','FFFFFF');

$total=0;
$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["mgr"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:G2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Manager : ".$customer11->rep_name);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:G2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:G3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "MANAGER JOINT WORK REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4');		

$row = 4;	

    if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){ 
		$a=mysql_query("SELECT reporteddate,count(DISTINCT(wp_rep_id)) as REP, count(wp_dc) as DR FROM tbl_work_plan WHERE (reporteddate BETWEEN '".@date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".@date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND attendancestatus = 1 and jointworkby like '%".@$_REQUEST['mgr']."%' and wp_dc='C' GROUP BY reporteddate");
	} else {
		$a=mysql_query("SELECT reporteddate,count(DISTINCT(wp_rep_id)) as REP, count(wp_dc) as DR FROM tbl_work_plan WHERE (reporteddate BETWEEN '".@date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".@date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND attendancestatus = 1 and jointworkby like '%".@$_REQUEST['mgr']."%' and wp_dc='D' GROUP BY reporteddate");
	}
        while($y_customer=mysql_fetch_assoc($a)){	

    	if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){ 
        	$SQL=mysql_query("SELECT tbl_customer_master.shop_name as name,tbl_customer_master.chemist_latitude as latitude,tbl_customer_master.chemist_longtitude as longtitude,rep_name,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.pobvalue,tbl_work_plan.drunavailable  FROM tbl_work_plan,representative,tbl_customer_master WHERE tbl_work_plan.reporteddate='".$y_customer["reporteddate"]."' AND tbl_work_plan.attendancestatus = 1 AND tbl_work_plan.wp_rep_id=representative.id AND tbl_work_plan.wp_dc_id=tbl_customer_master.id and jointworkby like '%".$_REQUEST['mgr']."%'  and wp_dc='C'");
        } else {
        	$SQL=mysql_query("SELECT doctor_name as name,doctors.dr_latitude as latitude,doctors.dr_longitude as longtitude,rep_name,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.drunavailablereason,tbl_work_plan.prescriptionvalue,tbl_work_plan.pobvalue,tbl_work_plan.drunavailable  FROM tbl_work_plan,representative,doctors WHERE tbl_work_plan.reporteddate='".$y_customer["reporteddate"]."' AND tbl_work_plan.attendancestatus = 1 AND tbl_work_plan.wp_rep_id=representative.id AND tbl_work_plan.wp_dc_id=doctors.id and jointworkby like '%".$_REQUEST['mgr']."%'  and wp_dc='D'");
        }
        	$CNT=mysql_num_rows($SQL); 

        	if($CNT>0){
				$col=0;
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("d-m-Y",strtotime($y_customer["reporteddate"])));

	    			if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){ 
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'REP : '.$y_customer["REP"].' CHY : '.$y_customer["DR"]);
					} else {
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'REP : '.$y_customer["REP"].' DR : '.$y_customer["DR"]);
					}

					$yuvaraj->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A'.$row.':G'.$row,'006535');
					mytemplate_design_fcolor('A'.$row.':G'.$row,'FFFFFF');
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
					$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRESCRIPTION VALUE");
					$col++;
					$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "POB VALUE");
					$col++;	

					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setBold(true);
					$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
					$yuvaraj->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_bg('A'.$row.':G'.$row,'eceeef');
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);

					$row++;

					$i=1;
					while($RS=mysql_fetch_array($SQL)){

						if ($RS['drunavailable'] == '0') { 
							// print_r('jjj');exit();
							// For rows where drunavailable is '0', set cell background to a specific color
							$color = 'FFFFFF'; // white
						} elseif ($RS['drunavailable'] == '1') {
							// print_r('ddd');exit();

							// For rows where drunavailable is '1', set cell background to a different color
							$color = 'FF0000'; // Red
						}
			
						mytemplate_design_bg('A' . $row . ':G' . $row, $color);
						// print_r($row1);exit();

						$col=0;
						$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["rep_name"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["name"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["drunavailablereason"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["reportedtime"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["prescriptionvalue"]);
						$col++;	
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RS["pobvalue"]);
						$col++;	

						$row++;
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
		$yuvaraj->getActiveSheet()->getStyle('F1:F'.$row)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('G1:G'.$row)->applyFromArray($styleArray);

	
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Manager : ".$customer11->rep_name.".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>