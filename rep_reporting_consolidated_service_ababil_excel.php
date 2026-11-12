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

/*
$yuvaraj->getActiveSheet()->mergeCells('A1:C1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:C1','9d9b9b');
mytemplate_design_fcolor('A1:C1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:C2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:C2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:C3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE VISIT REPORT");
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE");

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));
    

$yuvaraj->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:C4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
*/
mytemplate_design_bg('A4:C4','eceeef');	

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
		$a=mysql_query("SELECT (select COUNT(*) FROM clinetcreation WHERE id=representative.id) as doc_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT(reorting.clientid)) as D FROM reorting,representative WHERE (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid=representative.id GROUP BY reorting.repid ORDER BY reorting.repid");
		$num_rows=mysql_num_rows($a);

		/*$num=$num+$num_rows;
		$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
		$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 1;	
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["REP"]);	
					
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["D"]);
					
					$row++;
					$i++;
				}
*/

$objWorkSheet='';
		$j=0;
		$a=mysql_query("SELECT (select COUNT(*) FROM clinetcreation WHERE id=representative.id) as doc_count,representative.id AS R,representative.rep_name AS REP,COUNT(DISTINCT(reorting.clientid)) as D FROM reorting,representative WHERE (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND reorting.repid=representative.id GROUP BY reorting.repid ORDER BY reorting.repid");
        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
		$row_1 = 4;	

					$objWorkSheet=$yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:M1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:M1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:M1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:M1','9d9b9b');
					mytemplate_design_fcolor('A1:M1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$y_customer['R']."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:M2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"])));
					$objWorkSheet->getStyle('A2:M2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:M2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:M2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:M2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:M2','0e7cd8');

					$objWorkSheet->mergeCells('A3:M3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE CONSOLIDATE VISIT REPORT");
					$objWorkSheet->getStyle('A3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:M3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:M3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');	

					$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
					$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(25);
					$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(23);
					$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(34);	
                    
					///////////////////////////////////////////// Doctor List /////////////////////////////////////////////
					
						$num1=5;
						$s_no1=1;
						
						//$SQL=mysql_query("SELECT (select pincode FROM master_pincode WHERE pincode=clinetcreation.pincode GROUP BY pincode) as area_name,clinetcreation.name,clinetcreation.companyname,clinetcreation.pincode,reporteddate,reportedtime,repremarks FROM reorting,clinetcreation WHERE reorting.clientid=clinetcreation.id AND reorting.repid='".$y_customer["R"]."' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')  GROUP BY reorting.clientid ORDER BY  reorting.id DESC");
                        
                        
                        $SQL=mysql_query("SELECT * FROM reorting as a WHERE repid='".$y_customer["R"]."' AND tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by tdate asc ");
                        
                        
                        
                        
						$num_rows1=mysql_num_rows($SQL);


						if($num_rows1 > 0){
							
							$num1=$num1+$num_rows1;
							$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('F1:F'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('G1:G'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('H1:H'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('I1:I'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('J1:J'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('K1:K'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('L1:L'.$num1)->applyFromArray($styleArray);
                            $objWorkSheet->getStyle('M1:M'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->mergeCells('A'.$row_1.':M'.$row_1);
							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["REP"]." - ".strtoupper($_SESSION["LABEL"])." LIST");
							$objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
							$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getFont()->setSize(13);
							$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
							$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_fcolor('A'.$row_1.':M'.$row_1,'317eac');
							$row_1++;

							$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(5);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(14);
							$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
							$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(23);
							$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(18);
                            $objWorkSheet->getColumnDimensionByColumn(5)->setWidth(20);
                            $objWorkSheet->getColumnDimensionByColumn(6)->setWidth(14);
                            $objWorkSheet->getColumnDimensionByColumn(7)->setWidth(18);
                            $objWorkSheet->getColumnDimensionByColumn(8)->setWidth(14);
                            $objWorkSheet->getColumnDimensionByColumn(9)->setWidth(15);
                            $objWorkSheet->getColumnDimensionByColumn(10)->setWidth(25);
                            $objWorkSheet->getColumnDimensionByColumn(11)->setWidth(15);
                            $objWorkSheet->getColumnDimensionByColumn(12)->setWidth(18);	

							$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
                            $objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "DATE");
							$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "HOSPITAL NAME");
                           	$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "ADDRESS/LOCATION");
							$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "CONTACT PERSON");
							$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "DESIGNATION");
                            $objWorkSheet->setCellValueByColumnAndRow(6, $row_1, "CALL DATE");
                            $objWorkSheet->setCellValueByColumnAndRow(7, $row_1, "CONTACT NUMBER");
                            $objWorkSheet->setCellValueByColumnAndRow(8, $row_1, "CALL TYPE");
                            $objWorkSheet->setCellValueByColumnAndRow(9, $row_1, "REMARKS");
                            $objWorkSheet->setCellValueByColumnAndRow(10, $row_1, "PRODUCT DISCUSSED");
                            $objWorkSheet->setCellValueByColumnAndRow(11, $row_1, "LEAD STAGE");
                            $objWorkSheet->setCellValueByColumnAndRow(12, $row_1, "FOLLOWUP DATE");
                            

							$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
							$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getFont()->setBold(true);
							$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
							$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							mytemplate_design_bg('A'.$row_1.':M'.$row_1,'eceeef');	
							$row_1++;
						}
						while ($row1=mysql_fetch_array($SQL)) {
							$col_1 = 0;	
                            
                            $doc1=mysql_query("SELECT * FROM clinetcreation WHERE id='".$row1["clientid"]."'")or die(mysql_error());
                            $client=mysql_fetch_array($doc1);
                            
                            $pro_arr = mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name from product where id IN (".$row1['productrequested'].")");
        $prod_name=mysql_fetch_array($pro_arr); 
        
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1["tdate"]);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $client['companyname']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $client['address'].",".$client['Addrtess_line1'].",".$client['Addrtess_line2']);
							$col_1++;
							$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $client['name']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $client['desgination']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['tdate']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $client['mobileno']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['typeofcall']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['remarks']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $prod_name['pro_name']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['prospect_stage']);
							$col_1++;
                            
                            $objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['scheduleddate']);
							$col_1++;

							$s_no1++;
							$row_1++;
						}
					
					
					if(strpos($y_customer["REP"], "(")>0){
						$title_card=substr($y_customer["REP"], 0, strpos($y_customer["REP"], "("));
					} else {
						$title_card=$y_customer["REP"];
					}

					$objWorkSheet->setTitle($title_card);

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