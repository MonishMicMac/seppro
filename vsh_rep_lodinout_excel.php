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
 if(@$_SESSION['state_idhead']!=""){ 

        $state_select = "AND representative.stateid=".$_SESSION['state_idhead'];

    } else {
        $state_select = "";
    }
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "REP LOGINOUT REPORT");
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
// mytemplate_design_bg('A1:E1','9d9b9b');
// mytemplate_design_fcolor('A1:E1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".$_REQUEST["from_date"]);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// mytemplate_design_fcolor('A2:E2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:E3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE LOGIN AND LOGOUT REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "DATE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "LOGIN");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "LOGOUT");
$yuvaraj->getActiveSheet()->getStyle('A4:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
// mytemplate_design_bg('A4:E3','eceeef');	

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
$from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

// print_r($R_MDATE);exit();

$km_data=mysql_query("SELECT * FROM rep_inouttime Where (rep_inouttime.cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') ");




   

	$num_rows=mysql_num_rows($km_data);

	$num=$num+$num_rows;
	$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);

	while($obResult=mysql_fetch_object($km_data)){		
		$col=0;
		$row_1 = 1;	
		
        $drcaall=$obResult->rep_id;
        $objQuery=mysql_query("SELECT rep_name,id FROM representative where id  IN (".$drcaall.")");
    
          $inout_row=mysql_fetch_object($objQuery); 

            //   $inouttimemin=mysql_query("SELECT reportedtime,wp_rep_id FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' AND  `reportedtime` !=  '' AND wp_rep_id ='".$obResult->id."' AND  wp_id='".$inout_row->minid."' ")or die(mysql_error());
            // $inouttimemin_row=mysql_fetch_object($inouttimemin); 
            // $inouttimemax=mysql_query("SELECT  reportedtime,wp_rep_id FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($_REQUEST['from_date']))."' AND  `reportedtime` !=  '' AND wp_rep_id ='".$obResult->id."' AND wp_id='".$inout_row->maxid."' ")or die(mysql_error());
            // $inouttimemax_row=mysql_fetch_object($inouttimemax); 

		$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
		$col++;						
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $inout_row->rep_name);						
		$col++;						
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("Y-m-d",strtotime($obResult->cdate)));						
		$col++;	

		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  $obResult->intime);						
		$col++;		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  $obResult->outtime);						
		$col++;					
					// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["C"].'('.$y_customer["chem_count"].')');
		
		$row++;
		$i++;
	}
	$row++;



// exit();
$yuvaraj->setActiveSheetIndex(0);


//prepare download
$filename="LoginAndLogoutReport: ".$_REQUEST["from_date"].".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>