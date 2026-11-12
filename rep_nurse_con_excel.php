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

$yuvaraj->getActiveSheet()->mergeCells('A1:D1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:D1','9d9b9b');
mytemplate_design_fcolor('A1:D1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:D2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:D2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:D3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE VISIT REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "/DATE");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));


$yuvaraj->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:D4','eceeef');	

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
		$a=mysql_query("SELECT inouttime_nurse.*,patient_details.*, COUNT(*) AS CHEMIST
        FROM `inouttime_nurse` 
         LEFT JOIN patient_details on patient_details.id=inouttime_nurse.patient_id
        --  JOIN inouttime_nurse on inouttime_nurse.nurse_id=nurse_assign.nurse_id
        
        Where  inouttime_nurse.date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' 
            GROUP BY `inouttime_nurse`.`nurse_id` ORDER BY `inouttime_nurse`.`nurse_id` 
         ");
		$num_rows=mysql_num_rows($a);

		$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_assoc($a)){	
            
$ass=mysql_query("SELECT nurse_details.* FROM `nurse_details` 
 
Where  nurse_details.id='".$y_customer["nurse_id"]."' 
 ");
 $DRCNT=mysql_fetch_object($ass);

//  print_r($y_customer);exit();

		// $DR=mysql_query("SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id='".$Y->R."'");
        // $DRCNT=mysql_fetch_object($DR);

		$CHY=mysql_query("SELECT COUNT(*) AS CHEMIST FROM inouttime_nurse WHERE nurse_id='".$DRCNT->id."'");
        $CHYCNT=mysql_fetch_object($CHY);
        // print_r($CHYCNT);exit();

		$col=0;
		$row_1 = 1;	
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;			
                    // print_r($DRCNT);exit();
					// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $DRCNT->date);
								
					// $col++;	
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $DRCNT->nurse_name);
								
					$col++;						
					// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["D"].'('.$y_customer["doc_count"].')');	
				
					// $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer['CHEMIST']);
				
					$row++;

					$i++;

				}
               

$objWorkSheet='';

		$j=1;

		$a=mysql_query("SELECT inouttime_nurse.*,patient_details.*
        FROM `inouttime_nurse` 
         LEFT JOIN patient_details on patient_details.id=inouttime_nurse.patient_id
        --  JOIN inouttime_nurse on inouttime_nurse.nurse_id=nurse_assign.nurse_id
        
        Where  inouttime_nurse.date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' 
            GROUP BY `inouttime_nurse`.`nurse_id` ORDER BY `inouttime_nurse`.`nurse_id` 
         ");

        while($y_customer=mysql_fetch_assoc($a)){	
            // print_r($y_customer);exit();
     
            $ass=mysql_query("SELECT nurse_details.* FROM `nurse_details` 
 
            Where  nurse_details.id='".$y_customer["nurse_id"]."' 
             ");
             $DRCNT=mysql_fetch_object($ass);
            
            //  print_r($DRCNT);exit();
            
                    // $DR=mysql_query("SELECT COUNT(*) AS DOCTOR FROM doctors WHERE rep_id='".$Y->R."'");
                    // $DRCNT=mysql_fetch_object($DR);
            
                    $CHY=mysql_query("SELECT COUNT(*) AS CHEMIST FROM inouttime_nurse WHERE nurse_id='".$DRCNT->id."'");
                    $CHYCNT=mysql_fetch_object($CHY);
                    // print_r($y_customer);exit();

		$col=0;
		$row_1 = 4;	

					$objWorkSheet=$yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:G1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:G1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:G1','9d9b9b');
					mytemplate_design_fcolor('A1:G1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:G2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
					$objWorkSheet->getStyle('A2:G2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:G2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:G2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:G2','0e7cd8');

					$objWorkSheet->mergeCells('A3:G3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE VISIT REPORT");
					$objWorkSheet->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:G3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');	

					$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
					$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
					$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(23);
					$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	

					///////////////////////////////////////////// Doctor List /////////////////////////////////////////////
				
						$num1=5;
						$s_no1=1;
						$SQL=mysql_query("SELECT inouttime_nurse.*,patient_details.*
                        FROM `inouttime_nurse` 
                         LEFT JOIN patient_details on patient_details.id=inouttime_nurse.patient_id
                        --  JOIN inouttime_nurse on inouttime_nurse.nurse_id=nurse_assign.nurse_id
                        
                        Where inouttime_nurse.date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."' AND inouttime_nurse.nurse_id=$DRCNT->id
                              ORDER BY inouttime_nurse.id DESC
                         ");
						$num_rows1=mysql_num_rows($SQL);
                        // $row1=mysql_fetch_array($SQL);
					
							
							$num1=$num1+$num_rows1;
							$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('E1:D'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('F1:D'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('G1:D'.$num1)->applyFromArray($styleArray);
							// $objWorkSheet->getStyle('H1:D'.$num1)->applyFromArray($styleArray);

							$objWorkSheet->mergeCells('A'.$row_1.':G'.$row_1);
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $DRCNT->nurse_name." - ".strtoupper($_SESSION["LABEL"])." LIST");
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':G'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(20);
							$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(23);
							$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(34);	
							$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(34);	
							$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(34);	
							$objWorkSheet->getColumnDimensionByColumn(7)->setWidth(34);	
							// $objWorkSheet->getColumnDimensionByColumn(7)->setWidth(34);	

							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
							$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "PATIENT NAME");
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "DATE");
							$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "INTIME");
							$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "OUTTIME");
							$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "REMARKS");
							$objWorkSheet->setCellValueByColumnAndRow(6, $row_1, "LATITUDE");
							$objWorkSheet->setCellValueByColumnAndRow(7, $row_1, "LONGITUTE");

							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':G'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':G'.$row_1,'eceeef');	
							$row_1++;
					
						while ($row1=mysql_fetch_array($SQL)) {

                            // print_r($row1);exit();
							$col_1 = 0;	
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['patient_name']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['date']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['intime']);
							$col_1++;
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['outtime']);
							$col_1++;
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['remarks']);
							$col_1++;
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['latitude']);
							$col_1++;
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['longtitude']);
							$col_1++;
							

							$s_no1++;
							$row_1++;
						}
					
					///////////////////////////////////////////// Chemist List /////////////////////////////////////////////
				
					if(strpos($DRCNT->nurse_name, "(")>0){
						$title_card=substr($DRCNT->nurse_name, 0, strpos($DRCNT->nurse_name, "("));
					} else {
						$title_card=$DRCNT->nurse_name;
					}

					$objWorkSheet->setTitle($title_card);
                    // print_r($y_customer);exit();

					$j++;
}

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