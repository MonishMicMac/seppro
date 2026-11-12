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

$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$length = count($repid);
for ($ir = 0; $ir < $length; $ir++) {
   $rep_id=$repid[$ir];


$total=0;




$row = 5;		
$num=4;

		$i=1;
	
		$col=0;
		$row_1 = 1;	


$objWorkSheet='';
		$j=0;
		
	
		$a=mysql_query("SELECT rep_name FROM representative WHERE id='".$rep_id."'");
        while($y_customer=mysql_fetch_array($a)){		
		$col=0;
		$row_1 = 4;	
		$drmetnew=0;
		$drmetext=0;
		$drmet=0;
		$trmet=0;
		$pdcl=0;
		$clmet=0;
		$pobt=0;
					$objWorkSheet = $yuvaraj->createSheet($j);

					$objWorkSheet->mergeCells('A1:K1');

					$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
					$objWorkSheet->getStyle('A1:K1')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('A1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					mytemplate_design_bg('A1:K1','9d9b9b');
					mytemplate_design_fcolor('A1:K1','FFFFFF');

					$a1=mysql_query("SELECT rep_name FROM representative WHERE id='".$rep_id."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

					$objWorkSheet->mergeCells('A2:K2');
					// $objWorkSheet->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]."-".date("d/m/Y",strtotime($_REQUEST["to_date"])))));
					$objWorkSheet->getStyle('A2:K2')->getFont()->setSize(10);
					$objWorkSheet->getStyle('A2:K2')->getAlignment()->setShrinkToFit(true);
					$objWorkSheet->getStyle('A2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A2:K2')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(2)->setRowHeight(20);
					$objWorkSheet->getStyle('A2:K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					mytemplate_design_fcolor('A2:K2','0e7cd8');

					$objWorkSheet->mergeCells('A3:K3');
					$objWorkSheet->setCellValueByColumnAndRow(0, 3, $y_customer["rep_name"].'_'."REPORT");
					$objWorkSheet->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
					$objWorkSheet->getStyle('A3:K3')->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(3)->setRowHeight(20);
					$objWorkSheet->getStyle('A3:K3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objWorkSheet->freezePane('A4');


					$objWorkSheet->getStyle('A1:K1')->applyFromArray($styleArray);
					$objWorkSheet->getStyle('A2:K2')->applyFromArray($styleArray);
					$objWorkSheet->getStyle('A3:K3')->applyFromArray($styleArray);

					$num1=4;
					$s_no1=1;
						
						
				
					// $SQLC=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')AND wp_dc='D' AND wp_rep_id='".$rep_id."'")or die(mysql_error());
					$SQLCr=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."' ")or die(mysql_error());
					 $numcr_rows1=mysql_num_rows($SQLCr);
				
				
				
					
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
						$objWorkSheet->getStyle('J1:J'.$num1)->applyFromArray($styleArray);
							$objWorkSheet->getStyle('K1:K'.$num1)->applyFromArray($styleArray);
						// $objWorkSheet->mergeCells('A'.$row_1.':I'.$row_1);
						// $objWorkSheet->setCellValueByColumnAndRow(0, $row_1, $y_customer["rep_name"]." - CUSTOMER MISSED LIST");
						// $objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
						// $objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getFont()->setSize(13);
						// $objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
						// $objWorkSheet->getStyle('A'.$row_1.':I'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						// mytemplate_design_fcolor('A'.$row_1.':I'.$row_1,'317eac');
						// $row_1++;
					// exit();
						$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(8);
							$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(30);
						$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(15);
						$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(25);	
						$objWorkSheet->getColumnDimensionByColumn(7)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(8)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(9)->setWidth(15);	
						$objWorkSheet->getColumnDimensionByColumn(10)->setWidth(15);	

						$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "SI NO");
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "DATE");
						$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "CUSTOMER NAME");
						$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "PHONE NO");
						$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "NEW/EX");
						$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "DR/RET");
						$objWorkSheet->setCellValueByColumnAndRow(6, $row_1, "PLACE");
						$objWorkSheet->setCellValueByColumnAndRow(7, $row_1, "TIME SPENT");
						$objWorkSheet->setCellValueByColumnAndRow(8, $row_1, "GIFT GIVEN");
						$objWorkSheet->setCellValueByColumnAndRow(9, $row_1, "REMARKS");
						$objWorkSheet->setCellValueByColumnAndRow(10, $row_1, "POB");

						$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
						$objWorkSheet->getStyle('A'.$row_1.':K'.$row_1)->getFont()->setBold(true);
						$objWorkSheet->getStyle('A'.$row_1.':K'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('A'.$row_1.':K'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('A'.$row_1.':K'.$row_1,'eceeef');	

						$row_1++;
						
				
						// $SQLCr=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."' ")or die(mysql_error());
					while($numcrr_rows1=mysql_fetch_array($SQLCr))
					{
						
							$SQL=mysql_query("SELECT exsnew,drorchemist,doc_contact_no,id,doctor_name,doc_pincode,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors where id='".$numcrr_rows1['wp_dc_id']."'")or die(mysql_error());
								while($row1=mysql_fetch_array($SQL))
								{
					
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
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $numcrr_rows1['wp_date']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doctor_name']);
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_contact_no']);
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
				$row_1++;
				$objWorkSheet->mergeCells('B'.$row_1.':I'.$row_1);

					$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "SUMMARY");
					$objWorkSheet->getStyle('B'.$row_1.':I'.$row_1)->getFont()->setBold(true);
					$objWorkSheet->getRowDimension(1)->setRowHeight(17);
					$objWorkSheet->getStyle('B'.$row_1.':I'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objWorkSheet->getStyle('B'.$row_1.':I'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					$objWorkSheet->getStyle('B'.$row_1.':I'.$row_1)->applyFromArray($styleArray);
					mytemplate_design_bg('B'.$row_1.':I'.$row_1,'000000');
					mytemplate_design_fcolor('B'.$row_1.':I'.$row_1,'FFFFFF');
					
					$s_no3=1;
					// $SQL=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."' GROUP BY wp_date ");
					$SQLCrdate=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."' GROUP BY wp_date ")or die(mysql_error());
					$num_rows3=mysql_num_rows($SQLCrdate);

					if($num_rows3 > 0){
						$row_1=$row_1+1;

						$num3=$row_1;
						$num3=$num3+$num_rows3+1;

						// echo 'B'.$row_1.':B'.$num3;
						$objWorkSheet->getStyle('B'.$row_1.':B'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('C'.$row_1.':C'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('D'.$row_1.':D'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('E'.$row_1.':E'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('F'.$row_1.':F'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('G'.$row_1.':G'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('H'.$row_1.':H'.$num3)->applyFromArray($styleArray);
						$objWorkSheet->getStyle('I'.$row_1.':I'.$num3)->applyFromArray($styleArray);

						// $objWorkSheet->mergeCells('B'.$row_1.':E'.$row_1);
						// $objWorkSheet->setCellValueByColumnAndRow(1, $row_1, $y_customer["rep_name"]." - CUSTOMER LIST");
						// $objWorkSheet->getRowDimension($row_1)->setRowHeight(22);
						// $objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getFont()->setSize(13);
						// $objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
						// $objWorkSheet->getStyle('B'.$row_1.':E'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						// mytemplate_design_fcolor('B'.$row_1.':E'.$row_1,'317eac');
						// $row_1++;
						// exit();
						$col_1=1;
						$row_2=$row_1;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "DATE");
						$col_1++;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "DR'S MET");
						$col_1++;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "RETAILERS MET");
						$col_1++;	
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "CALL MADE");
						$col_1++;	
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "NEW CALL");
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "EXISTING CALL");
						$col_1++;
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "PRODUCTIVE CALL");
						$col_1++;	
						
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "POB");
						$col_1++;	
						$row_1++;
						// $SQLCrdate=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."' GROUP BY wp_date ")or die(mysql_error());
					while($SQLCrdate_rows1=mysql_fetch_array($SQLCrdate))
					{
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, $SQLCrdate_rows1['wp_date']);
						$row_1++;
					}
						// $objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "TODAY");
						// $objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "B/F");
						$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, "TOTAL");

						$objWorkSheet->getRowDimension($row_2)->setRowHeight(20);

						$objWorkSheet->getStyle('B'.$row_2.':I'.$row_2)->getFont()->setBold(true);
						$objWorkSheet->getStyle('B'.$row_2.':I'.$row_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						$objWorkSheet->getStyle('B'.$row_2.':I'.$row_2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						mytemplate_design_bg('B'.$row_2.':I'.$row_2,'eceeef');	
					$row_3=$row_2+1;
	$SQLCrdatesumm=mysql_query("SELECT wp_dc_id,drunavailablereason,gift,wp_id,attendancestatus,checkintime,wp_date FROM tbl_work_plan where (wp_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."' GROUP BY wp_date")or die(mysql_error());
					while($SQLCrdatesumm_rows1=mysql_fetch_array($SQLCrdatesumm))
					{
						// echo "SELECT COUNT(*) AS new FROM doctors where id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date ='".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1') AND exsnew='NEW'";

						$sqlsnew=mysql_query("SELECT COUNT(*) AS new FROM doctors where id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date ='".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1') AND exsnew='NEW'")or die(mysql_error());
						$anew=mysql_fetch_array($sqlsnew);
						 $drcaallnew=$anew['new'];
						 $drmetnew=$drmetnew+$drcaallnew;

						 $sqlsext=mysql_query("SELECT COUNT(*) AS existing FROM doctors where id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date ='".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' AND attendancestatus='1') AND exsnew='EXISTING'")or die(mysql_error());
						$aext=mysql_fetch_array($sqlsext);
						 $drcaallext=$aext['existing'];
						 $drmetext=$drmetext+$drcaallext;
						
						$sqls=mysql_query("SELECT COUNT(*) AS CNTS FROM doctors,tbl_work_plan where tbl_work_plan.wp_date = '".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND doctors.drorchemist='DOCTOR' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$a=mysql_fetch_array($sqls);
						 $drcaall=$a['CNTS'];
						 $drmet=$drmet+$drcaall;

						$sqlsw=mysql_query("SELECT COUNT(*) AS CNTSw FROM doctors,tbl_work_plan where tbl_work_plan.wp_date ='".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."'  AND doctors.drorchemist='SHOP' AND tbl_work_plan.wp_rep_id='".$rep_id."' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
						$aw=mysql_fetch_array($sqlsw);
						$chemistcall=$aw['CNTSw'];
						 $trmet=$trmet+$chemistcall;

						$sumofco=($drcaall+$chemistcall);
						$clmet=$clmet+$sumofco;

						// ECHO "SELECT count(*) AS CNTSwq FROM pobbooking1 where cdate = '".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND client_id='".$SQLCrdatesumm_rows1['wp_dc_id']."'  AND repid='$rep_id' GROUP BY client_id, cdate";

						$sqlswq=mysql_query("SELECT count(*) AS CNTSwq FROM pobbooking1 where cdate = '".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."'   AND repid='$rep_id' GROUP BY client_id, cdate")or die(mysql_error());
						$chemistcallq=mysql_num_rows($sqlswq);
						$pdcl=$pdcl+$chemistcallq;
						// $chemistcallq=$awq['CNTSwq'];


						$prwwe=0;
						// echo "SELECT productid,qty FROM pobbooking1 where cdate= '".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND client_id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date = '".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."') AND wp_dc='D' AND wp_rep_id='".$rep_id."' ) AND repid='".$rep_id."'";
						 $sqlwwe=mysql_query("SELECT productid,qty FROM pobbooking1 where cdate= '".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND client_id IN (SELECT wp_dc_id FROM tbl_work_plan where wp_date = '".date("Y-m-d",strtotime($SQLCrdatesumm_rows1['wp_date']))."' AND wp_dc='D' AND wp_rep_id='".$rep_id."' ) AND repid='".$rep_id."'");
								
								while($rowwwe=mysql_fetch_array($sqlwwe))
								{	
									// echo "SELECT pro_mrp FROM product where id='".$rowwwe['productid']."'";
						 		 $sqlprwwe=mysql_query("SELECT pro_mrp FROM product where id='".$rowwwe['productid']."'");
									$rowprwwe=mysql_fetch_array($sqlprwwe);
										

									$rtwwe=$rowwwe['qty']*$rowprwwe['pro_mrp'];

									$prwwe=$prwwe+$rtwwe;
								}
								// echo $prwwe;
								$pobt=$pobt+$prwwe;
						
					
						
							
						$col_1=2;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_3, $drcaall); 
					
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_3, $chemistcall); 
					
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_3, $sumofco);  
		
						$col_1++;

						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_3, $drcaallnew);  
					
						$col_1++;

						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_3, $drcaallext);  
						// $objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $sumofcotoba); 
						// $objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $sumofcoto); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_3, $chemistcallq);
						// $objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $chemistcallqtoba);   
						// $objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $chemistcallqto); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_3, $prwwe);  
						// $objWorkSheet->setCellValueByColumnAndRow(3, $row_1, $prwwetoba); 
						// $objWorkSheet->setCellValueByColumnAndRow(2, $row_1, $prwweto); 
						

						// 	$objWorkSheet->getRowDimension($col_1)->setRowHeight(20);
						// $objWorkSheet->getStyle('B'.$col_1)->getFont()->setBold(true);
						// $objWorkSheet->getStyle('B'.$col_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
						// $objWorkSheet->getStyle('B'.$col_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
					$row_3++;
					}
					// 	$objWorkSheet->getStyle('B'.$row_4.':G'.$row_4)->getFont()->setBold(true);
					// $objWorkSheet->getRowDimension(1)->setRowHeight(17);
					// $objWorkSheet->getStyle('B'.$row_4.':G'.$row_4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// $objWorkSheet->getStyle('B'.$row_4.':G'.$row_4)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
					// $objWorkSheet->getStyle('B'.$row_4.':G'.$row_4)->applyFromArray($styleArray);
					

					$row_4=$row_3;
						$col_1=2;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_4, $drmet); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_4, $trmet); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_4, $clmet); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_4, $drmetnew); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_4, $drmetext); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_4, $pdcl); 
						$col_1++;
						$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_4, $pobt); 
					mytemplate_design_bg('B'.$row_4.':I'.$row_4,'000000');
					mytemplate_design_fcolor('B'.$row_4.':I'.$row_4,'FFFFFF');
					}
							// exit();
						


					$objWorkSheet->setTitle($y_customer["rep_name"]);
					$j++;					
}	
}
		// exit();
$yuvaraj->setActiveSheetIndex(0);	

//prepare download
$filename="Period Wise Report: ".$y_customer["rep_name"]."-".date("d/m/Y",strtotime($_REQUEST["from_date"]))."to".date("d/m/Y",strtotime($_REQUEST["to_date"])).".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>
  ?>