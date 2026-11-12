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

$yuvaraj->getActiveSheet()->mergeCells('A1:N1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:N1','9d9b9b');
mytemplate_design_fcolor('A1:N1','FFFFFF');

$total=0;
$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:N2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$customer11->rep_name);
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:L2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:N3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE PROSPECT REPORT ".strtoupper($_SESSION["LABEL"])."");

$yuvaraj->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth('12');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "SALES EGINEER NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth('20');
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "UNPLANNED");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "HOSPITAL NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth('20');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "ADDRESS/LOCATION");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth('25');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "TOWN");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth('25');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "CONTACT PERSON");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth('20');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "DESIGNATION");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth('20');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "CONTACT NUMBER");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth('20');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "CALL DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth('15');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 4, "PRODUCT DISCUSSED");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth('30');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 4, "CALL TYPE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth('20');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, 4, "PROSPECT / LEAD STAGE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth('30');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, 4, "DISCUSSION HAPPENED (REMARKS)");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth('30');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(13, 4, "NEXT FOLLOWUP DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(13)->setWidth('15');
$yuvaraj->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:N4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:N4','eceeef');	
$yuvaraj->getActiveSheet()->setTitle("Daily Report");
$row = 5;	
$num_rr1=4;

	
		$a=mysql_query("SELECT * FROM reorting as a WHERE repid='".@$_REQUEST["rep_id"]."' AND tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by tdate asc ");
        
        //$a=mysql_query("SELECT tdate, COUNT(tdate) as planned, sum(case when attendance='1' then 1 else 0 end) as visited, sum(case when attendance='0' then 1 else 0 end) as missed, (SELECT COUNT(DISTINCT(clientid)) FROM reorting WHERE tdate=a.tdate AND attendance = 1  and repid=a.repid) as REPORT_REP FROM reorting as a WHERE repid='".@$_REQUEST["rep_id"]."' AND tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."'  GROUP BY tdate");
	
		$num_rows1=mysql_num_rows($a);


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
        $yuvaraj->getActiveSheet()->getStyle('I1:I'.$num_rr1)->applyFromArray($styleArray);
        $yuvaraj->getActiveSheet()->getStyle('J1:J'.$num_rr1)->applyFromArray($styleArray);
        $yuvaraj->getActiveSheet()->getStyle('K1:K'.$num_rr1)->applyFromArray($styleArray);
        $yuvaraj->getActiveSheet()->getStyle('L1:L'.$num_rr1)->applyFromArray($styleArray);
        $yuvaraj->getActiveSheet()->getStyle('M1:M'.$num_rr1)->applyFromArray($styleArray);
        $yuvaraj->getActiveSheet()->getStyle('N1:N'.$num_rr1)->applyFromArray($styleArray);
		// $yuvaraj->getActiveSheet()->getStyle('F1:F'.$num_rr1)->applyFromArray($styleArray);

        while($y_customer=mysql_fetch_assoc($a)){		
		$col=0;
        
        $doc1=mysql_query("SELECT * FROM clinetcreation WHERE id='".$y_customer["clientid"]."'")or die(mysql_error());
        $client=mysql_fetch_object($doc1);
        
        $pro_arr = mysql_query("SELECT GROUP_CONCAT(pro_name) as pro_name from product where id IN (".$y_customer['productrequested'].")");
        $prod_name=mysql_fetch_object($pro_arr);

					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["tdate"]);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->rep_name);						
					$col++;						
					// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["unplanned"]);						
					// $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $client->companyname);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $client->address.",".$client->Addrtess_line1.",".$client->Addrtess_line2);
					$col++;						
                    
                    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $client->Addrtess_line2);
					$col++;						
					
                    
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $client->name);
                    $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $client->desgination);
					
                     $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $client->mobileno);
                    
                    
                    $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["tdate"]);
                    
                    $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $prod_name->pro_name);
                    
                   
                    $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["typeofcall"]);
                    
                    
                    $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["prospect_stage"]);
                    
                    $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["remarks"]);
                    
                    
                    $col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["scheduleddate"]);
                    
					
					
					$row++;
				}


$objWorkSheet = $yuvaraj->createSheet(1);

$objWorkSheet->mergeCells('A1:E1');

$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$objWorkSheet->getStyle('A1:E1')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(1)->setRowHeight(17);
$objWorkSheet->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objWorkSheet->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:E1','9d9b9b');
mytemplate_design_fcolor('A1:E1','FFFFFF');

$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST["rep_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$objWorkSheet->mergeCells('A2:E2');
$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$customer11->rep_name);
$objWorkSheet->getStyle('A2:E2')->getFont()->setSize(10);
$objWorkSheet->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
$objWorkSheet->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$objWorkSheet->getStyle('A2:E2')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(2)->setRowHeight(20);
$objWorkSheet->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:E2','0e7cd8');

$objWorkSheet->mergeCells('A3:E3');
$objWorkSheet->setCellValueByColumnAndRow(0, 3, "REPRESENTATIVE DAILY REPORT ".strtoupper($_SESSION["LABEL"])."");

$objWorkSheet->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$objWorkSheet->getStyle('A3:E3')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(3)->setRowHeight(20);
$objWorkSheet->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(12);
$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(30);
$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(25);
$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(35);
$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(18);
$objWorkSheet->setCellValueByColumnAndRow(0, 4, "DATE");
$objWorkSheet->setCellValueByColumnAndRow(1, 4, "PINCODE");
$objWorkSheet->setCellValueByColumnAndRow(2, 4, "".strtoupper($_SESSION["LABEL"])." NAME");
$objWorkSheet->setCellValueByColumnAndRow(3, 4, "REPORT");
$objWorkSheet->setCellValueByColumnAndRow(4, 4, "REPORTED TIME");
$objWorkSheet->getStyle('A4:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$objWorkSheet->getStyle('A4:E4')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(4)->setRowHeight(20);
$objWorkSheet->getStyle('A4:E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objWorkSheet->freezePane('A5');	
mytemplate_design_bg('A4:E4','eceeef');	


$col1 = 0;
$row_new = 5;
$row_new1 = 5;
$row_1=5;
$color='DDEBF7';
$num_rr=4;


$sql=mysql_query("SELECT tdate,repid FROM reorting as a WHERE repid='".@$_REQUEST["rep_id"]."' AND tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."'  GROUP BY tdate");

while($row=mysql_fetch_assoc($sql)){
	$date=$row["tdate"];
	$rep_id=$row["repid"];
	
		$sql1=mysql_query("SELECT (select pincode FROM master_pincode WHERE pincode=clinetcreation.pincode GROUP BY pincode) as area_name,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.reportedtime,reorting.reporteddate FROM reorting,clinetcreation WHERE reorting.repid='$rep_id' AND reorting.reporteddate='$date' AND clinetcreation.id=reorting.clientid order by clinetcreation.pincode asc");
	
	$num_rows=mysql_num_rows($sql1);

	if($num_rows > 0) {
		$objWorkSheet->setCellValueByColumnAndRow($col1, $row_new, $date);
		$rows=0;
		$rows=$row_new+$num_rows-1;
		$objWorkSheet->mergeCells('A'.$row_new.':A'.$rows);
		$objWorkSheet->getStyle('A'.$row_new.':A'.$rows)->getFont()->setBold(true);
		$objWorkSheet->getStyle('A'.$row_new.':A'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objWorkSheet->getStyle('A'.$row_new.':A'.$rows)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$row_new=$row_new+$num_rows;

		$styleArray = array(
		      'borders' => array(
		          'allborders' => array(
		              'style' => PHPExcel_Style_Border::BORDER_THIN
		          )
		      )
		  );
		$num_rr=$num_rr+$num_rows;
		$objWorkSheet->getStyle('A1:A'.$num_rr)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('B1:B'.$num_rr)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('C1:C'.$num_rr)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('D1:D'.$num_rr)->applyFromArray($styleArray);
		$objWorkSheet->getStyle('E1:E'.$num_rr)->applyFromArray($styleArray);

		$j=1;

		while($row1=mysql_fetch_array($sql1)){
			$col_1=1;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['pincode']);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['name']);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['serviceremarks']);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['reportedtime']);
			$row_1++;
			$j++;
		}
	
		$sql2=mysql_query("SELECT count(clinetcreation.pincode) as cnt FROM reorting,clinetcreation WHERE reorting.repid='$rep_id' AND reorting.reporteddate='$date' AND clinetcreation.id=reorting.clientid group by clinetcreation.pincode order by clinetcreation.pincode asc");
	
		while($row2=mysql_fetch_array($sql2)){
			$num_rows1=$row2['cnt'];
			$rows1=0;
			$rows1=$row_new1+$num_rows1-1;
			$objWorkSheet->mergeCells('B'.$row_new1.':B'.$rows1);
			$objWorkSheet->getStyle('B'.$row_new1.':B'.$rows1)->getFont()->setBold(true);
			$objWorkSheet->getStyle('B'.$row_new1.':B'.$rows1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
			$objWorkSheet->getStyle('B'.$row_new1.':B'.$rows1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			if($color=='BDD7EE') {
				$color='DDEBF7';
			} elseif($color=='DDEBF7') {
				$color='BDD7EE';
			}
			mytemplate_design_bg('B'.$row_new1.':B'.$rows1, $color);
			mytemplate_design_bg('C'.$row_new1.':C'.$rows1, $color);
			mytemplate_design_bg('D'.$row_new1.':D'.$rows1, $color);
			mytemplate_design_bg('E'.$row_new1.':E'.$rows1, $color);
			$row_new1=$row_new1+$num_rows1;
		}
		$objWorkSheet->setTitle("Comments");
	}
}

$yuvaraj->setActiveSheetIndex(0);

//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Representative : ".$customer11->rep_name.".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>