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
	
		$a=mysql_query("SELECT * FROM representative WHERE id='".$rep_id."'");
        while($y_customer=mysql_fetch_array($a)){		
		$col=0;
		$row_1 = 4;	

					$objWorkSheet = $yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:I1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:I1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:I1','9d9b9b');
					mytemplate_design_fcolor('A1:I1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".$rep_id."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:I2');
					$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"])));
					$objWorkSheet->getStyle('A2:I2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:I2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:I2','0e7cd8');

					$objWorkSheet->mergeCells('A3:I3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, $y_customer["rep_name"].'_'."REPORT");
					$objWorkSheet->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:I3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');


					$objWorkSheet->getStyle('A1:I1')->applyFromArray($styleArray);
					$objWorkSheet->getStyle('A2:I2')->applyFromArray($styleArray);
					$objWorkSheet->getStyle('A3:I3')->applyFromArray($styleArray);

					$num1=4;
					$s_no1=1;
						
				
						$SQLC=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus FROM tbl_work_plan where wp_date= '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."'")or die(mysql_error());
					 $numcr_rows1=mysql_num_rows($SQLC);
					// exit();
				
				
					
						  $num1=$num1+$numcr_rows1;
						$objWorkSheet->getStyle('A1:A'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('B1:B'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C1:C'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D1:D'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E1:E'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('F1:F'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('G1:G'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('H1:H'.$num1)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('I1:I'.$num1)->applyFromArray($styleArray);
						
						// $objWorkSheet->mergeCells('A'.$row_1.':I'.$row_1);
						// $objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["rep_name"]." - CUSTOMER MISSED LIST");
						// $objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
						// $objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getFont()->setSize(13);
						// $objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
						// $objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						// mytemplate_design_fcolor('A'.$row_1.':I'.$row_1,'317eac');
						// $row_1++;
					
						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
						$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(30);
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(15);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(25);	
						$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(20);	
						$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(7)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(8)->setWidth(15);	
						

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "SI NO");
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "CUSTOMER NAME");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "NEW/EX");
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "DR/RET");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "PLACE");
						$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "TIME SPENT");
						$objWorkSheet->setCellValueByColumnAndRow(6, $row_1, "GIFT GIVEN");
						$objWorkSheet->setCellValueByColumnAndRow(7, $row_1, "REMARKS");
						$objWorkSheet->setCellValueByColumnAndRow(8, $row_1, "POB");

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('A'.$row_1.':I'.$row_1,'eceeef');	

						$row_1++;
					// while ($row1=mysql_fetch_array($SQL)) {
						// echo "SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."'";
						$SQLCr=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where wp_date = '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."'  AND wp_dc='D' AND wp_rep_id='".$rep_id."' ")or die(mysql_error());
					while($numcrr_rows1=mysql_fetch_array($SQLCr))
					{
						// echo "SELECT dob,exsnew,drorchemist,doctor_addrs,doc_specilist_id,doc_contact_no,doc_qualification,id,doc_contact_no,doctor_name,doc_pincode,doc_qualification,doc_specilist_id,favourite,doc_hospital_clinic_name,dr_latitude,dr_longitude,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors where id='".$numcrr_rows1['wp_dc_id']."' ";
							$SQL=mysql_query("SELECT dob,exsnew,drorchemist,doctor_addrs,doc_specilist_id,doc_contact_no,doc_qualification,id,doc_contact_no,doctor_name,doc_pincode,doc_qualification,doc_specilist_id,favourite,doc_hospital_clinic_name,dr_latitude,dr_longitude,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors where id='".$numcrr_rows1['wp_dc_id']."'")or die(mysql_error());
								while($row1=mysql_fetch_array($SQL))
								{
					// echo "SELECT productid,qty FROM pobbooking1 where client_id='".$row1['id']."' AND cdate='".date("Y-m-d",strtotime($numcrr_rows1['wp_date']))."'";
						    $sqlpr=mysql_query("SELECT productid,qty FROM pobbooking1 where client_id='".$row1['id']."' AND cdate ='".date("Y-m-d",strtotime($numcrr_rows1['wp_date']))."' AND repid='".$rep_id."'")or die(mysql_error());
								$pr=0;

									while($row=mysql_fetch_array($sqlpr))
									{	
										// echo "hi";
										// echo "SELECT pro_mrp FROM product where id='".$row['productid']."'";
							 		 $sqlpr1=mysql_query("SELECT pro_mrp FROM product where id='".$row['productid']."'");
										$rowpr=mysql_fetch_array($sqlpr1);
											

										$rt=$row['qty']*$rowpr['pro_mrp'];

							$pr=($pr+$rt);
										
									}
									
						$col_1 = 0;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doctor_name']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['exsnew']);
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['drorchemist']);
						$col_1++;
					
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['area_name']);
						$col_1++;
					
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $numcrr_rows1['checkintime']);
						$col_1++;
				
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $numcrr_rows1['gift']);
						$col_1++;
					
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $numcrr_rows1['drunavailablereason']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $pr);
						$col_1++;

						$s_no1++;
						$row_1++;
					}
				}
				// exit();
			

					$s_no3=1;
					$SQL=mysql_query("SELECT * FROM representative WHERE id='".$rep_id."'");
					$num_rows3=mysql_num_rows($SQL);

					if($num_rows3 > 0){
						$row_1=$row_1+1;

						$num3=$row_1;
						$num3=$num3+$num_rows3+4;

						
						$objWorkSheet->getStyle('B'.$row_1.':B'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C'.$row_1.':C'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D'.$row_1.':D'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E'.$row_1.':E'.$num3)->applyFromArray($styleArray);

						// $objWorkSheet->mergeCells('B'.$row_1.':E'.$row_1);
						// $objWorkSheet->setCellValueByColumnAndRow(1, $row_1, $y_customer["rep_name"]." - CUSTOMER LIST");
						// $objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
						// $objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getFont()->setSize(13);
						// $objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
						// $objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						// mytemplate_design_fcolor('B'.$row_1.':E'.$row_1,'317eac');
						// $row_1++;
						$col_1=1;
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "SUMMARY");

						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "TODAY");
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "B/F");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "TOTAL");

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('B'.$row_1.':E'.$row_1,'eceeef');	


						$sqls=mysql_query("SELECT COUNT(*) AS CNTS FROM doctors,tbl_work_plan where (tbl_work_plan.wp_date BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."') AND doctors.drorchemist='DOCTOR' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$a=mysql_fetch_array($sqls);
						$drcaall=$a['CNTS'];

						$sqlsw=mysql_query("SELECT COUNT(*) AS CNTSw FROM doctors,tbl_work_plan where (tbl_work_plan.wp_date BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')  AND doctors.drorchemist='SHOP' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$aw=mysql_fetch_array($sqlsw);
						$chemistcall=$aw['CNTSw'];

						$sumofco=($drcaall+$chemistcall);
						$sqlswq=mysql_query("SELECT count(*) AS CNTSwq FROM pobbooking1 where (cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."') AND repid='$rep_id' GROUP BY client_id, cdate")or die(mysql_error());
						$chemistcallq=mysql_num_rows($sqlswq);
						// $chemistcallq=$awq['CNTSwq'];


						$prwwe=0;
						 $sqlwwe=mysql_query("SELECT productid,qty FROM pobbooking1 where (cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."') AND repid='".$rep_id."'");
								
								while($rowwwe=mysql_fetch_array($sqlwwe))
								{	

						 		 $sqlprwwe=mysql_query("SELECT pro_mrp FROM product where id='".$rowwwe['productid']."'");
									$rowprwwe=mysql_fetch_array($sqlprwwe);
										

									$rtwwe=$rowwwe['qty']*$rowprwwe['pro_mrp'];

									$prwwe=($prwwe+$rtwwe);
								}

						$sqlstoba=mysql_query("SELECT COUNT(*) AS CNTS FROM doctors,tbl_work_plan where (tbl_work_plan.wp_date BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime('-1 day', strtotime($_REQUEST["from_date"])))."') AND doctors.drorchemist='DOCTOR' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$atoba=mysql_fetch_array($sqlstoba);
						$drcaalltoba=$atoba['CNTS'];

						$sqlswtoba=mysql_query("SELECT COUNT(*) AS CNTSw FROM doctors,tbl_work_plan where (tbl_work_plan.wp_date BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime('-1 day', strtotime($_REQUEST["from_date"])))."')  AND doctors.drorchemist='SHOP' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$awtoba=mysql_fetch_array($sqlswtoba);
						$chemistcalltoba=$awtoba['CNTSw'];

						$sumofcotoba=($drcaalltoba+$chemistcalltoba);
						// echo "SELECT count(*) AS CNTSwq FROM pobbooking1 where (cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime('-1 day', strtotime($_REQUEST["from_date"])))."') AND repid='$rep_id' GROUP BY client_id, cdate";

						$sqlswqtoba=mysql_query("SELECT count(*) AS CNTSwq FROM pobbooking1 where (cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime('-1 day', strtotime($_REQUEST["from_date"])))."') AND repid='$rep_id' GROUP BY client_id, cdate")or die(mysql_error());
						$chemistcallqtoba=mysql_num_rows($sqlswqtoba);
						// $chemistcallqtoba=$awqtoba['CNTSwq'];


						$prwwetoba=0;
						 $sqlwwetoba=mysql_query("SELECT productid,qty FROM pobbooking1 where (cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime('-1 day', strtotime($_REQUEST["from_date"])))."') AND repid='".$rep_id."'");
								
								while($rowwwetoba=mysql_fetch_array($sqlwwetoba))
								{	

						 		 $sqlprwwetoba=mysql_query("SELECT pro_mrp FROM product where id='".$rowwwetoba['productid']."'");
									$rowprwwetoba=mysql_fetch_array($sqlprwwetoba);
										

									$rtwwetoba=$rowwwetoba['qty']*$rowprwwetoba['pro_mrp'];

									$prwwetoba=($prwwetoba+$rtwwetoba);
								}

						$sqlsto=mysql_query("SELECT COUNT(*) AS CNTS FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND doctors.drorchemist='DOCTOR' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$ato=mysql_fetch_array($sqlsto);
						$drcaallto=$ato['CNTS'];

						$sqlswto=mysql_query("SELECT COUNT(*) AS CNTSw FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='".date("Y-m-d",strtotime($_REQUEST["from_date"]))."'  AND doctors.drorchemist='SHOP' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$awto=mysql_fetch_array($sqlswto);
						$chemistcallto=$awto['CNTSw'];

						$sumofcoto=($drcaallto+$chemistcallto);

						
						// echo "SELECT count(*) AS CNTSwq FROM pobbooking1 where (cdate BETWEEN  '".date("Y-m-d",strtotime($_REQUEST["from_date1"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."') AND repid='$rep_id' GROUP BY client_id, cdate";

						$sqlswqto=mysql_query("SELECT count(*) AS CNTSwq FROM pobbooking1 where cdate='".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND repid='$rep_id' GROUP BY client_id, cdate")or die(mysql_error());
						$chemistcallqto=mysql_num_rows($sqlswqto);
						// $chemistcallqto=$awqto['CNTSwq'];


						$prwweto=0;
						 $sqlwweto=mysql_query("SELECT productid,qty FROM pobbooking1 where cdate='".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND repid='".$rep_id."'");
								
								while($rowwweto=mysql_fetch_array($sqlwweto))
								{	

						 		 $sqlprwweto=mysql_query("SELECT pro_mrp FROM product where id='".$rowwweto['productid']."'");
									$rowprwweto=mysql_fetch_array($sqlprwweto);
										

									$rtwweto=$rowwweto['qty']*$rowprwweto['pro_mrp'];

									$prwweto=($prwweto+$rtwweto);
								}

						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "SUMMARY");
						$row_1++;					
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "TOTAL DR'S MET");
						$row_1++;	

						$row1=mysql_fetch_array($SQL);
						
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "TOTAL RETAILERS MET");
						$row_1++;	
						
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "TOTAL CALL MADE");
						$row_1++;	
						
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "TOTAL PRODUCTIVE CALL");
						$row_1++;	
						
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "TOTAL POB");
						$row_1++;	
						
						$row_1--;
						$row_1--;
						$row_1--;
						$row_1--;
						$row_1--;
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, $drcaall); 
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $drcaalltoba);  
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $drcaallto); 
						$row_1++;
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, $chemistcall); 
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $chemistcalltoba);  
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $chemistcallto); 
						$row_1++;
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, $sumofco);  
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $sumofcotoba); 
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $sumofcoto); 
						$row_1++;
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, $chemistcallq);
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $chemistcallqtoba);   
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $chemistcallqto); 
						$row_1++;
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, $prwwe);  
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $prwwetoba); 
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $prwweto); 
						

							$objWorkSheet->getRowDimension($col_1)->setRowHeight(20);
						$objWorkSheet->getStyle('B'.$col_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('B'.$col_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('B'.$col_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
			
					}
					
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