<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 300000000);
ini_set('max_execution_time', 150000000);
set_time_limit(0);
error_reporting(0);


ob_end_clean();
header("Connection: close\r\n");
header("Content-Encoding: none\r\n");
ignore_user_abort(true);
ob_start();
echo "Loading";
$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush();
flush();
ob_end_clean();


$_REQUEST["from_date"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";

$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);

function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}
$mgr_id=$_REQUEST['mgr_id'];
$mgr_sql=mysql_query("SELECT id,rep_name FROM representative WHERE rep_id>'0' AND id='$mgr_id'");
$mgr_row=mysql_fetch_array($mgr_sql);

$j=0;
$rep_sql=mysql_query("SELECT id,rep_name FROM representative WHERE rep_id='0' AND id IN (select rep_assign from doctors group by rep_assign) AND id IN (select repid from assigningreptomanager where managerid='$mgr_id')");
while ($rep_row=mysql_fetch_array($rep_sql)) {

	$objWorkSheet=$yuvaraj->createSheet($j);
	$row=2; $col=0;
	$last_date=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($_REQUEST["from_date"])),date("Y",strtotime($_REQUEST["from_date"])))+1;

	$cust_cnt_sql=mysql_query("SELECT id,doctor_name FROM doctors WHERE rep_id='".$rep_row["id"]."' ORDER BY doctor_name ASC");
	$cust_cnt=mysql_num_rows($cust_cnt_sql);

	$objWorkSheet->setCellValueByColumnAndRow(0, 1, $rep_row['rep_name'].' - '.date("F Y",strtotime($_REQUEST["from_date"])));

	$objWorkSheet->getStyle('A2:B2')->getFont()->setBold(true);
	$objWorkSheet->getStyle('A1:B1')->getFont()->setSize(13);
	$objWorkSheet->getStyle(2)->getFont()->setBold(true);
	$objWorkSheet->getStyle(3)->getFont()->setBold(true);

	$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(5);
	$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(35);
	$objWorkSheet->getStyle(2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objWorkSheet->getStyle(3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objWorkSheet->freezePane('A5');

	$objWorkSheet->mergeCells('A2:A4');
	$objWorkSheet->mergeCells('B2:B4');

	$objWorkSheet->mergeCells('A1:'.getNameFromNumber($last_date+1).'1');
	$objWorkSheet->getStyle('A1:B1')->getFont()->setBold(true);
	$objWorkSheet->getStyle('A1:'.getNameFromNumber($last_date+1).'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objWorkSheet->getStyle('C4:'.getNameFromNumber($last_date+1).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objWorkSheet->getRowDimension(1)->setRowHeight(20);

	$objWorkSheet->getStyle('C2:'.getNameFromNumber($last_date).'2')->applyFromArray(
	    array(
	        'font'  => array(
		        'color' => array('rgb' => 'ffffff')
		    )
	    )
	);

	$objWorkSheet->getStyle('C2:'.getNameFromNumber($last_date).'2')->applyFromArray(
	    array(
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '000000')
	        )
	    )
	);

	$objWorkSheet->getStyle('A2:B3')->applyFromArray(
	    array(
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'a6a6a6')
	        )
	    )
	);

	$objWorkSheet->getStyle('A2:B3')->applyFromArray(
		array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => 'ffffff')
	            )
	        )
	    )
	);

	$objWorkSheet->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$w=1;
	for ($i=0; $i <= $last_date; $i++) { 
		if($i==0) {
			$objWorkSheet->setCellValueByColumnAndRow($col, $row, "S.NO");
			$col++;
		} elseif($i==1) {
			$objWorkSheet->setCellValueByColumnAndRow($col, $row, "NAME");
			$col++;
		} else {
			$t=$i-1;
			if($t<10){
				$date='0'.$t;
				$m_date=date("Y-m",strtotime($_REQUEST["from_date"])).'-'.$date;
				$week=date("l",strtotime($m_date));
			} else {
				$date=$t;
				$m_date=date("Y-m",strtotime($_REQUEST["from_date"])).'-'.$date;
				$week=date("l",strtotime($m_date));
			}

			if($w==1){
				$color='ffd966';
			} elseif($w==2) {
				$color='a9d08e';
			} elseif($w==3) {
				$color='aeaaaa';
			} elseif($w==4) {
				$color='b4c6e7';
			} elseif($w==5) {
				$color='c68fd5';

			}

			$objWorkSheet->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+4))->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => $color)
			        )
			    )
			);

			if($week=='Sunday'){
				$objWorkSheet->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+4))->applyFromArray(
				    array(
				        'fill' => array(
				            'type' => PHPExcel_Style_Fill::FILL_SOLID,
				            'color' => array('rgb' => 'f74537')
				        )
				    )
				);
				$w++;
			} else {
				$sql4=mysql_query("SELECT count(*) as cnt FROM repgivenasleave WHERE leaveapplieddate='$m_date' AND reason='holiday' AND repid='".$rep_row["id"]."'");
				$row4=mysql_fetch_array($sql4);
				if($row4['cnt']>0){
					$objWorkSheet->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+4))->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'ffc000')
					        )
					    )
					);
				}
			}

			$objWorkSheet->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+4))->applyFromArray(
				array(
			        'borders' => array(
			            'allborders' => array(
			                'style' => PHPExcel_Style_Border::BORDER_THIN,
			                'color' => array('rgb' => 'ffffff')
			            )
			        )
			    )
			);

			$week_day=substr($week,0,1);
			$objWorkSheet->getColumnDimensionByColumn($col)->setWidth(4.5);
			$objWorkSheet->setCellValueByColumnAndRow($col, $row, $week_day);
			$col++;
		}
	}

	$row++;
	$col=2;
	for ($i=0; $i <= $last_date; $i++) { 
		if($i>1){
			$t=$i-1;
			if($t<10){
				$date='0'.$t;
			} else {
				$date=$t;
			}
			$objWorkSheet->setCellValueByColumnAndRow($col, $row, $date);
			$col++;
		}
	}
	$row++;

	$last_date=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($_REQUEST["from_date"])),date("Y",strtotime($_REQUEST["from_date"])));

	$col=2;
	for ($i=1; $i <= $last_date; $i++) {
		if($i<10){
			$h='0'.$i;
		} else {
			$h=$i;
		}

		$date1=date("Y-m",strtotime($_REQUEST["from_date"])).'-'.$h;
		$sql4=mysql_query("SELECT reason FROM repgivenasleave WHERE leaveapplieddate='$date1' AND repid='".$rep_row["id"]."'");
		$row4=mysql_fetch_array($sql4);
		if(strtoupper(substr($row4['reason'], 0,2))=='' || strtoupper(substr($row4['reason'], 0,2))=='FALSE'){ $value1=''; } else { $value1=strtoupper(substr($row4['reason'], 0,2)); }
		$objWorkSheet->setCellValueByColumnAndRow($col, $row, $value1);
		$col++;
	}
	$row++;


	$z=1;
	$col=0;
	$sql1=mysql_query("SELECT id,doctor_name FROM doctors WHERE rep_id='".$rep_row["id"]."' ORDER BY doctor_name ASC");
	while ($row1=mysql_fetch_array($sql1)) {
		$col=0;
		$objWorkSheet->setCellValueByColumnAndRow($col, $row, $z);
		$col++;
		$objWorkSheet->getRowDimension($row)->setRowHeight(20);
		$objWorkSheet->setCellValueByColumnAndRow($col, $row, strtoupper($row1['doctor_name']));
		$col++;
		for ($i=1; $i <= $last_date; $i++) { 
			if($i<10){
				$h='0'.$i;
			} else {
				$h=$i;
			}

			$date1=date("Y-m",strtotime($_REQUEST["from_date"])).'-'.$h;
			$sql2=mysql_query("SELECT count(*) as cnt FROM tbl_work_plan WHERE wp_date='$date1' AND attendancestatus='1' AND wp_rep_id='".$rep_row["id"]."' AND wp_dc_id='".$row1['id']."'");
			$row2=mysql_fetch_array($sql2);
			if($row2['cnt']==0){ $value=''; } else { $value='P'; }
			$objWorkSheet->setCellValueByColumnAndRow($col, $row, $value);
			$col++;
		}
		$row++;
		$z++;
	}
	if(strpos($rep_row["rep_name"], "(")>0){
		$title_card=substr($rep_row["rep_name"], 0, strpos($rep_row["rep_name"], "("));
	} else {
		$title_card=$rep_row["rep_name"];
	}

	$objWorkSheet->setTitle($title_card);
	$j++;
}

$yuvaraj->setActiveSheetIndex(0);

$filename=$mgr_row['rep_name']." - Visited"." - ".date("F Y",strtotime($_REQUEST["from_date"])).".xls";
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');
$objWriter->save(str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/'.$filename,__FILE__));



require("class.phpmailer.php");
require("class.smtp.php");
$mail = new PHPMailer();
$subject=$mgr_row['rep_name']." - Visited";
$message="Overall TP Visited Report for ".$mgr_row['rep_name'];

$mail->PluginDir='./';
$mail->IsSMTP();
$mail->Mailer="smtp";
$mail->SMTPDebug=1;
$mail->SMTPSecure='ssl';
$mail->Host="smtp.gmail.com"; 
$mail->Port=465; 
$mail->FromName="Overall TP Download"; 
$mail->Addaddress("hrzinniacbe@gmail.com");
$mail->Addaddress("knradha@hotmail.com");
$mail->SMTPAuth=true;
$mail->Username="harish10010@gmail.com";
$mail->Password="steve-rogers007";
$mail->Subject=$subject;
$mail->Body=$message;

$path_and_file=str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/'.$filename,__FILE__);
$mail->AddAttachment($path_and_file);

$mail->WordWrap = 500;
$mail->IsHTML(true);
if($mail->Send()){
	$_SESSION['success_msg']="Success";
} else {
	echo $mail->ErrorInfo();
}
exit;
?>