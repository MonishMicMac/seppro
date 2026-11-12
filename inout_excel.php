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

date_default_timezone_set("Asia/Kolkata");


$yuvaraj->getActiveSheet()->mergeCells('A1:H1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:H1','9d9b9b');
mytemplate_design_fcolor('A1:H1','FFFFFF');
// print_r($_REQUEST["rep_id"]);exit();
$total=0;
$a1=mysql_query("SELECT nurse_name FROM nurse_details WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:H2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$customer11->nurse_name);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:H2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:H3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "INOUT REPORT ");

$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "PATIENT NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "INTIME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "OUTTIME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(25);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "REMARKS");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "LATITUDE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "LONGTITUDE");
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:H4','eceeef');	
$yuvaraj->getActiveSheet()->setTitle("Inout Report");
$row = 5;	
$num_rr1=8;
$i=1;
	// if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
	// 	$a=mysql_query("SELECT wp_date, sum(case when UP='P' then 1 else 0 end) as planned, sum(case when UP='U' then 1 else 0 end) as unplanned, sum(case when attendancestatus='1' then 1 else 0 end) as visited, sum(case when attendancestatus='0' then 1 else 0 end) as missed, (SELECT COUNT(wp_dc_id) FROM tbl_work_plan WHERE wp_date=a.wp_date AND attendancestatus = 1 and wp_dc='C' and wp_rep_id=a.wp_rep_id) as REPORT_REP FROM tbl_work_plan as a WHERE wp_rep_id='".@$_REQUEST["rep_id"]."' AND wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' and wp_dc='C' GROUP BY wp_date ORDER BY wp_date desc");
	// } else {

		// $a=mysql_query("SELECT telecaller_assign_manager.,telecaller_assign_manager.assigned_to as ass,mst_customer_mapping. FROM telecaller_assign_manager 
        // LEFT JOIN mst_customer_mapping on mst_customer_mapping.id=telecaller_assign_manager.site_id
            
        //      WHERE telecaller_id='".$_REQUEST["rep_id"]."' AND c_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."'");
	// }
	// $a=mysql_query("SELECT telecaller_assign_manager.,telecaller_assign_manager.assigned_to as ass,mst_customer_mapping.,doctors.* FROM telecaller_assign_manager 
	// LEFT JOIN mst_customer_mapping on mst_customer_mapping.id=telecaller_assign_manager.site_id
	// LEFT JOIN doctors on doctors.id=mst_customer_mapping.shop_id
	
		
	// 	 WHERE telecaller_id='".$_REQUEST["rep_id"]."' 
    //  AND telecaller_assign_manager.c_date BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."'
	//  ORDER BY telecaller_assign_manager.id DESC

	// 	 ");

    $a= mysql_query("SELECT inouttime_nurse.*,patient_details.*
    FROM `inouttime_nurse` 
     LEFT JOIN patient_details on patient_details.id=inouttime_nurse.patient_id
    --  JOIN inouttime_nurse on inouttime_nurse.nurse_id=nurse_assign.nurse_id
    
    Where inouttime_nurse.nurse_id='".$_REQUEST["rep_id"]."' 
     AND inouttime_nurse.date BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."' 
          ORDER BY inouttime_nurse.id DESC
     ");
    
		$num_rows1=mysql_num_rows($a);
// echo"<pre>";print_r($num_rows1);exit();   
       

		$styleArray = array(
					      'borders' => array(
					          'allborders' => array(
					              'style' => PHPExcel_Style_Border::BORDER_THIN
					          )
					      )
		);
		$num_rr1=$num_rr1+$num_rows1;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num_rr1)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num_rr1)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num_rr1)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num_rr1)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('E1:E'.$num_rr1)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('F1:F'.$num_rr1)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('G1:G'.$num_rr1)->applyFromArray($styleArray);
        $yuvaraj->getActiveSheet()->getStyle('H1:H'.$num_rr1)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('I1:I'.$num_rr1)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('J1:J'.$num_rr1)->applyFromArray($styleArray);
	
		// $yuvaraj->getActiveSheet()->getStyle('I1:I'.$num_rr1)->applyFromArray($styleArray);


        while($y_customer=mysql_fetch_assoc($a)){	
            // print_r($y_customer);exit();	
			$col=0;

            $yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
            $col++;
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["date"]);
            $col++;
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["patient_name"]);						
            $col++;						
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["intime"]);						
            $col++;						
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["outtime"]);						
            $col++;						
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["remarks"]);
            $col++;
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["latitude"]);
            $col++;
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["longtitude"]);
            $col++;
           
            $row++;

            $i++;
		}


		// $objWorkSheet = $yuvaraj->createSheet(1);

		// $objWorkSheet->mergeCells('A1:G1');

		// $objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
		// $objWorkSheet->getStyle('A1:G1')->getFont()->setBold(true);
		// $objWorkSheet->getRowDimension(1)->setRowHeight(17);
		// $objWorkSheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $objWorkSheet->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
		// mytemplate_design_bg('A1:G1','9d9b9b');
		// mytemplate_design_fcolor('A1:G1','FFFFFF');

		// $a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

		// $objWorkSheet->mergeCells('A2:G2');
		// $objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$customer11->rep_name);
		// $objWorkSheet->getStyle('A2:G2')->getFont()->setSize(10);
		// $objWorkSheet->getStyle('A2:G2')->getAlignment()->setShrinkToFit(true);
		// $objWorkSheet->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
		// $objWorkSheet->getStyle('A2:G2')->getFont()->setBold(true);
		// $objWorkSheet->getRowDimension(2)->setRowHeight(20);
		// $objWorkSheet->getStyle('A2:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// mytemplate_design_fcolor('A2:G2','0e7cd8');

		// $objWorkSheet->mergeCells('A3:G3');
		// $objWorkSheet->setCellValueByColumnAndRow(0, 3, "TELECALLER REPORT ".strtoupper($_SESSION["LABEL"])."");

		// $objWorkSheet->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
		// $objWorkSheet->getStyle('A3:G3')->getFont()->setBold(true);
		// $objWorkSheet->getRowDimension(3)->setRowHeight(20);
		// $objWorkSheet->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		// $objWorkSheet->getColumnDimensionByColumn(0)->setWidth(12);
		// $objWorkSheet->getColumnDimensionByColumn(1)->setWidth(30);
		// $objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
		// $objWorkSheet->getColumnDimensionByColumn(3)->setWidth(35);
		// $objWorkSheet->getColumnDimensionByColumn(4)->setWidth(18);
		// $objWorkSheet->getColumnDimensionByColumn(5)->setWidth(18);
		// $objWorkSheet->getColumnDimensionByColumn(6)->setWidth(18);
		// $objWorkSheet->setCellValueByColumnAndRow(0, 4, "DATE");
		// $objWorkSheet->setCellValueByColumnAndRow(1, 4, "PINCODE - AREA");
		// $objWorkSheet->setCellValueByColumnAndRow(2, 4, "".strtoupper($_SESSION["LABEL"])." NAME");
		// $objWorkSheet->setCellValueByColumnAndRow(3, 4, "REPORT");
		// $objWorkSheet->setCellValueByColumnAndRow(4, 4, "IN TIME");
		// $objWorkSheet->setCellValueByColumnAndRow(5, 4, "OUT TIME");
		// $objWorkSheet->setCellValueByColumnAndRow(6, 4, "Spend TIME");
		// $objWorkSheet->getStyle('A4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
		// $objWorkSheet->getStyle('A4:G4')->getFont()->setBold(true);
		// $objWorkSheet->getRowDimension(4)->setRowHeight(20);
		// $objWorkSheet->getStyle('A4:G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// $objWorkSheet->freezePane('A5');	
		// mytemplate_design_bg('A4:G4','eceeef');	


		// $col1 = 0;
		// $row_new = 5;
		// $row_new1 = 5;
		// $row_1=5;
		// $color='DDEBF7';
		// $num_rr=4;

		// if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
		// $sql=mysql_query("SELECT wp_date,wp_rep_id FROM tbl_work_plan as a WHERE wp_rep_id='".@$_REQUEST["rep_id"]."' AND wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' and wp_dc='C' GROUP BY wp_date");
		// } else {
		// $sql=mysql_query("SELECT wp_date,wp_rep_id FROM tbl_work_plan as a WHERE wp_rep_id='".@$_REQUEST["rep_id"]."' AND wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' and wp_dc='D' GROUP BY wp_date");
		// }
		// while($row=mysql_fetch_assoc($sql)){
		// 	$date=$row["wp_date"];
		// 	$rep_id=$row["wp_rep_id"];
		// 	if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
		// 		$sql1=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=tbl_customer_master.pincode GROUP BY pincode) as area_name,tbl_customer_master.shop_name as name,tbl_customer_master.pincode as pincode,tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,tbl_work_plan.reporteddate,tbl_work_plan.in_time FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.reporteddate='$date' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_dc='C' order by tbl_customer_master.pincode asc");
		// 	} else {
		// 		$sql1=mysql_query("SELECT (select area_name FROM pincode_list WHERE pincode=doctors.doc_pincode GROUP BY pincode) as area_name,doctors.doctor_name as name,doctors.doc_pincode as pincode,tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,tbl_work_plan.reporteddate,tbl_work_plan.in_time FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.reporteddate='$date' AND doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_dc='D' order by tbl_work_plan.in_time asc");
		// 	}
		// 	$num_rows=mysql_num_rows($sql1);

		// 	if($num_rows > 0) {
		// 		$objWorkSheet->setCellValueByColumnAndRow($col1, $row_new, $date);
		// 		$rows=0;
		// 		$rows=$row_new+$num_rows-1;
		// 		$objWorkSheet->mergeCells('A'.$row_new.':A'.$rows);
		// 		$objWorkSheet->getStyle('A'.$row_new.':A'.$rows)->getFont()->setBold(true);
		// 		$objWorkSheet->getStyle('A'.$row_new.':A'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		// 		$objWorkSheet->getStyle('A'.$row_new.':A'.$rows)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// 		$row_new=$row_new+$num_rows;

		// 		$styleArray = array(
		// 			'borders' => array(
		// 				'allborders' => array(
		// 					'style' => PHPExcel_Style_Border::BORDER_THIN
		// 				)
		// 			)
		// 		);
		// 		$num_rr=$num_rr+$num_rows;
		// 		$objWorkSheet->getStyle('A1:A'.$num_rr)->applyFromArray($styleArray);
		// 		$objWorkSheet->getStyle('B1:B'.$num_rr)->applyFromArray($styleArray);
		// 		$objWorkSheet->getStyle('C1:C'.$num_rr)->applyFromArray($styleArray);
		// 		$objWorkSheet->getStyle('D1:D'.$num_rr)->applyFromArray($styleArray);
		// 		$objWorkSheet->getStyle('E1:E'.$num_rr)->applyFromArray($styleArray);
		// 		$objWorkSheet->getStyle('F1:F'.$num_rr)->applyFromArray($styleArray);
		// 		$objWorkSheet->getStyle('G1:G'.$num_rr)->applyFromArray($styleArray);

		// 		$j=1;

		// 		while($row1=mysql_fetch_array($sql1)){
		// 			$spendtime=0;
		// 			$col_1=1;
		// 			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['pincode'].' - '.$row1['area_name']);
		// 			$col_1++;
		// 			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['name']);
		// 			$col_1++;
		// 			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['drunavailablereason']);
		// 			$col_1++;
		// 			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['in_time']);
		// 			$col_1++;
		// 			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['reportedtime']);
		// 			$col_1++;
		// 			// echo "hi";
					

		// 			// echo hai($row1['in_time'],$row1['reportedtime']);
		// 			if($row1['in_time']!='' && $row1['reportedtime']!='')
		// 			{
		// 				$datetime1 = new DateTime($row1['in_time']);
		// 				$datetime2 = new DateTime($row1['reportedtime']);
		// 				$interval = $datetime1->diff($datetime2);
		// 				$spendtime=$interval->format('%H:%I:%S');
		// 			}
		// 				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $spendtime);
		// 				$row_1++;
		// 				$j++;
		// 		}

		// 		if($_SESSION['doc_cnt']==0 && $_SESSION['chem_cnt']>0){
		// 			$sql2=mysql_query("SELECT count(tbl_customer_master.pincode) as cnt FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.reporteddate='$date' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_dc='C' group by tbl_customer_master.pincode order by tbl_customer_master.pincode asc");
		// 		} else {
		// 			$sql2=mysql_query("SELECT count(doctors.doc_pincode) as cnt FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.reporteddate='$date' AND doctors.id=tbl_work_plan.wp_dc_id and tbl_work_plan.wp_dc='D' group by doctors.doc_pincode order by doctors.doc_pincode asc");
		// 		}
		// 		while($row2=mysql_fetch_array($sql2)){
		// 			$num_rows1=$row2['cnt'];
		// 			$rows1=0;
		// 			$rows1=$row_new1+$num_rows1-1;
		// 			$objWorkSheet->mergeCells('B'.$row_new1.':B'.$rows1);
		// 			$objWorkSheet->getStyle('B'.$row_new1.':B'.$rows1)->getFont()->setBold(true);
		// 			$objWorkSheet->getStyle('B'.$row_new1.':B'.$rows1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		// 			$objWorkSheet->getStyle('B'.$row_new1.':B'.$rows1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// 			if($color=='BDD7EE') {
		// 				$color='DDEBF7';
		// 			} elseif($color=='DDEBF7') {
		// 				$color='BDD7EE';
		// 			}
		// 			mytemplate_design_bg('B'.$row_new1.':B'.$rows1, $color);
		// 			mytemplate_design_bg('C'.$row_new1.':C'.$rows1, $color);
		// 			mytemplate_design_bg('D'.$row_new1.':D'.$rows1, $color);
		// 			mytemplate_design_bg('E'.$row_new1.':E'.$rows1, $color);
		// 			mytemplate_design_bg('F'.$row_new1.':F'.$rows1, $color);
		// 			mytemplate_design_bg('G'.$row_new1.':G'.$rows1, $color);
		// 			$row_new1=$row_new1+$num_rows1;
		// 		}
		// 		$objWorkSheet->setTitle("Comments");
		// 	}
		// }
// exit();
$yuvaraj->setActiveSheetIndex(0);

//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$customer11->nurse_name.".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>