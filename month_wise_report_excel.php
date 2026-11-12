<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
error_reporting(0);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls"); 

$repid = $_REQUEST["checkbox"];
$date = $_REQUEST["from_date"];
$fromdate=explode("-",$date);

$_REQUEST["from_date1"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date1"]."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

 $stdate=$fromdate[0]."-".$fromdate[1]."-"."01";

$errr=$fromdate[2]-1;

 $eddate=$fromdate[0]."-".$fromdate[1]."-".$errr;


$length = count($repid);
for ($ir = 0; $ir < $length; $ir++) {
   $rep_id=$repid[$ir];


$total=0;

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
	
		$col=0;
		$row_1 = 1;	


$objWorkSheet='';
		$j=0;
	$tpr=0;
		$a=mysql_query("SELECT * FROM representative WHERE id='".$rep_id."'");
        while($y_customer=mysql_fetch_array($a)){		
		$col=0;
		$row_1 = 4;	

					$objWorkSheet = $yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:E1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:E1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:E1','9d9b9b');
					mytemplate_design_fcolor('A1:E1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".$rep_id."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:E2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"])));
					$objWorkSheet->getStyle('A2:E2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:E2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:E2','0e7cd8');

					$objWorkSheet->mergeCells('A3:E3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, $y_customer["rep_name"].'_'."REPORT");
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:E3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					// $objWorkSheet->freezePane('A4');


					$objWorkSheet->getStyle('A1:E36')->applyFromArray($styleArray);
					// $objWorkSheet->getStyle('A2:E2')->applyFromArray($styleArray);
					// $objWorkSheet->getStyle('A3:E3')->applyFromArray($styleArray);
					// $objWorkSheet->getStyle('A3:E3')->applyFromArray($styleArray);

					$num1=4;
					$s_no1=1;				
					
					
						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(30);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(15);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(25);	
						// $objWorkSheet->getColumnDimensionByColumn(5)->setWidth(20);	
						// $objWorkSheet->getColumnDimensionByColumn(6)->setWidth(15);	
						// $objWorkSheet->getColumnDimensionByColumn(7)->setWidth(15);	
						// $objWorkSheet->getColumnDimensionByColumn(8)->setWidth(15);	
						

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "SI NO");
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "Date");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "Total No Of Call");
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "Order Placed");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "Amount");
						// $objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "TIME SPENT");
						// $objWorkSheet->setCellValueByColumnAndRow(6, $row_1, "GIFT GIVEN");
						// $objWorkSheet->setCellValueByColumnAndRow(7, $row_1, "REMARKS");
						// $objWorkSheet->setCellValueByColumnAndRow(8, $row_1, "ORDER VALUE");

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('A'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('A'.$row_1.':E'.$row_1,'eceeef');	

						$row_1++;
					$Daysperiod=mysql_query("select * from 
								(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
								where selected_date BETWEEN  '".$_REQUEST["from_date1"]."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."' ");
								while($D=mysql_fetch_object($Daysperiod)){	


										$col_1=0;
										$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col_1, $row_1, $i);
										$col_1++;
										$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col_1, $row_1, date("Y-m-d",strtotime($D->selected_date)));
										$col_1=2;	
										// echo "SELECT count(wp_dc_id) AS calls FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1'";
											$SQLC=mysql_query("SELECT count(wp_dc_id) AS calls FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1'")or die(mysql_error());
											$SQLC_row=mysql_fetch_object($SQLC);
											// echo $SQLC_row->calls;
										$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col_1, $row_1, $SQLC_row->calls);
										$col_1=3;	
										// echo "SELECT count(client_id) AS pcalls FROM pobbooking where client_id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1') AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' GROUP BY client_id";
									
											$sqlpr=mysql_query("SELECT count(client_id) AS pcalls FROM pobbooking where client_id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1') AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' GROUP BY client_id");
											$sqlpr_row=mysql_fetch_object($sqlpr);
										if($sqlpr_row->pcalls!='')
										{
										$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col_1, $row_1, $sqlpr_row->pcalls);
										}
										else
										{
											$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col_1, $row_1, "0");
										}

										$col_1++;	
										// echo "SELECT DISTINCT(client_id),productid,qty FROM pobbooking where client_id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1') AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' ";
										$pdt=mysql_query("SELECT client_id,productid,qty FROM pobbooking where client_id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1') AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND qty!='0' ")or die(mysql_error());
										$pr=0;
									while($pdt_row=mysql_fetch_object($pdt))
									{	
										 "SELECT pro_mrp FROM product where id='".$pdt_row->productid."'";
							 		 $pdtamt=mysql_query("SELECT pro_mrp FROM product where id='".$pdt_row->productid."'");
										$pdtamt_row=mysql_fetch_object($pdtamt);
									

										$rt=$pdt_row->qty*$pdtamt_row->pro_mrp;
								

							 $pr=($pr+$rt);
										
									}
										$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col_1, $row_1, $pr);
									 $tpr=$tpr+$pr;
									
									$YP++;$row_1++;
									$i++;

								}
								$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col_1--, $row_1, "Total      -     ".$tpr);
					
				
							// exit();
						


					$objWorkSheet->setTitle($y_customer["rep_name"]);
					$j++;					
}	
}
		// exit();
$yuvaraj->setActiveSheetIndex(0);	

//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"])).".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>
  ?>