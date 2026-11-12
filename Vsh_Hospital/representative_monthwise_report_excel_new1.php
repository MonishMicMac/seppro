<?php
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3000000);
ini_set('max_execution_time', 1500000);
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
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");

$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);

///////////////////////////////// GET KMs /////////////////////////////////
function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
	$theta = $longitude1 - $longitude2;
	$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	$miles = acos($miles);
	$miles = rad2deg($miles);
	$miles = $miles * 60 * 1.1515;
	return round($miles * 1.609344,2);
}
///////////////////////////////// GET KMs /////////////////////////////////

$month_year=explode('-', $_REQUEST['month_year']);
$month=date("m",strtotime($month_year[0]));
$year=$month_year[1];
$date=$year.'-'.$month;

$objWorkSheet=0;
$j=1;
 // IN (SELECT wp_rep_id FROM tbl_work_plan WHERE DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' GROUP BY wp_rep_id)
$a=mysql_query("SELECT * FROM representative WHERE id ='".$_REQUEST['mgr']."'");
while($y_customer=mysql_fetch_assoc($a)){
	$col=0;
	$row_1 = 4;	
	$repid=$y_customer["id"];

	$num1=5;
	$s_no1=1;

	$SQL=mysql_query("SELECT IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name,(case when favourite='0' then 'NF' else 'F' end) as favourite,doc_contact_no,(select GROUP_CONCAT(jointworkby) from tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and wp_rep_id='$repid' and attendancestatus='1' and drunavailable='0' and wp_dc='D') AS jointworkby,dr_latitude,dr_longitude,visitcardclinicphoto,dob,anniversary,doctor_name,doc_specilist_id,(SELECT concat((case when group_concat(latitude)!='' then group_concat(latitude) else '0' end),' - ',(case when group_concat(longitude)!='' then group_concat(longitude) else '0' end)) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and wp_rep_id='$repid' and attendancestatus='1' and drunavailable='0' and wp_dc='D') as lat_lon,doc_qualification,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='' then group_concat(DATE_FORMAT(wp_date,'%d')) else 'Not Met' end) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and wp_rep_id='$repid' and attendancestatus='1' and drunavailable='0' and wp_dc='D') as days FROM doctors WHERE rep_id='$repid'");
	$num_rows1=mysql_num_rows($SQL);

	if($num_rows1 > 0){
		$objWorkSheet=$yuvaraj->createSheet($j);

		$objWorkSheet->mergeCells('A1:M1');
		$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
		$objWorkSheet->getStyle('A1:M1')->getFont()->setBold(true);
		$objWorkSheet->getRowDimension(1)->setRowHeight(17);
		$objWorkSheet->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objWorkSheet->getStyle('A1:M1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
		mytemplate_design_bg('A1:J1','9d9b9b');
		mytemplate_design_fcolor('A1:J1','FFFFFF');

		$objWorkSheet->mergeCells('A2:M2');
		$objWorkSheet->setCellValueByColumnAndRow(0,2, $y_customer["rep_name"]." LIST");
		$objWorkSheet->getRowDimension(2)->setRowHeight(22);
		$objWorkSheet->getStyle('A2:M2')->getFont()->setSize(13);
		$objWorkSheet->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objWorkSheet->getStyle('A2:M2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		mytemplate_design_fcolor('A2:M2','317eac');

		$objWorkSheet->mergeCells('A3:M3');
		$objWorkSheet->setCellValueByColumnAndRow(0, 3, "Overall Visit Report (".$date.")");
		$objWorkSheet->getStyle('A3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
		$objWorkSheet->getStyle('A3:M3')->getFont()->setBold(true);
		$objWorkSheet->getRowDimension(3)->setRowHeight(20);
		$objWorkSheet->getStyle('A3:M3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objWorkSheet->getStyle('A4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
		$objWorkSheet->getStyle('A4:M4')->getFont()->setBold(true);
		$objWorkSheet->getRowDimension(4)->setRowHeight(20);
		$objWorkSheet->getStyle('A4:M4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objWorkSheet->freezePane('A5');

		$num1=$num1+$num_rows1-1;
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

		$objWorkSheet->getStyle('A1:M'.$num1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objWorkSheet->getStyle('A1:M'.$num1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objWorkSheet->getColumnDimensionByColumn(1)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(2)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(3)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(4)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(5)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(6)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(7)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(8)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(9)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(10)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(11)->setAutoSize(true);
		$objWorkSheet->getColumnDimensionByColumn(12)->setAutoSize(true);
		$objWorkSheet->setCellValueByColumnAndRow(0, $row_1, "S.NO");
		$objWorkSheet->setCellValueByColumnAndRow(1, $row_1, strtoupper($_SESSION["LABEL"])." NAME");
		$objWorkSheet->setCellValueByColumnAndRow(2, $row_1, "VISITED DAYS");
		$objWorkSheet->setCellValueByColumnAndRow(3, $row_1, "FAVOURITE");
		$objWorkSheet->setCellValueByColumnAndRow(4, $row_1, "PLACE");
		$objWorkSheet->setCellValueByColumnAndRow(5, $row_1, "PHONE NUMBER");
		$objWorkSheet->setCellValueByColumnAndRow(6, $row_1, "RX PAD");
		$objWorkSheet->setCellValueByColumnAndRow(7, $row_1, "DOB");
		$objWorkSheet->setCellValueByColumnAndRow(8, $row_1, "ANNIVERSARY");
		$objWorkSheet->setCellValueByColumnAndRow(9, $row_1, "QUALIFICATION");
		$objWorkSheet->setCellValueByColumnAndRow(10, $row_1, "SPECIALITY");
		$objWorkSheet->setCellValueByColumnAndRow(11, $row_1, "KMs");
		$objWorkSheet->setCellValueByColumnAndRow(12, $row_1, "JWE");

		$objWorkSheet->getRowDimension($row_1)->setRowHeight(20);
		$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getFont()->setBold(true);
		$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objWorkSheet->getStyle('A'.$row_1.':M'.$row_1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		mytemplate_design_bg('A'.$row_1.':M'.$row_1,'eceeef');
		mytemplate_design_fcolor('A5:M'.$num1,'008000');
		$row_1++;

		while ($row1=mysql_fetch_array($SQL)) {
			$dr_lat=$row1['dr_latitude'];
			$dr_lon=$row1['dr_longitude'];
			$lat_lon=explode(" - ", $row1['lat_lon']);
			$lat_and_long='';

			if(stripos($lat_lon[0],",")=='0'){
				$latitude=$lat_lon[0];
				$longitude=$lat_lon[1];
				if($latitude!='0' && $longitude!='0'){
					$lat_and_long=calculateDistance($dr_lat, $dr_lon, $latitude, $longitude).' KM';
				}
			} else {
				$latitude=explode(",", $lat_lon[0]);
				$longitude=explode(",", $lat_lon[1]);

				for ($i=0; $i < count($latitude); $i++) {
					if($latitude[$i]!='0' && $longitude[$i]!='0'){
						$lat_and_long1.=calculateDistance($dr_lat, $dr_lon, $latitude[$i], $longitude[$i]).' KM,';
					}
				}
				$lat_and_long=rtrim($lat_and_long1,",");
			}

			$col_1 = 0;	
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $s_no1);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doctor_name']);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['days']);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['favourite']);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['area_name']);
			$col_1++;
			if($row1['doc_contact_no']!=''){
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_contact_no']);
				mytemplate_design_fcolor('F'.$row_1,'ff0000');
			} else {
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "NO NUMBER");
			}
			$col_1++;

			if($row1['visitcardclinicphoto']!=''){
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "http://seppro.net/zinniaandroidfiles/leaveform/".$row1['visitcardclinicphoto']);
				mytemplate_design_fcolor('G'.$row_1,'ff0000');
			} else {
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "NO");
			}			
			$col_1++;

			if($row1['dob']!='0000-00-00'){
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['dob']);
				mytemplate_design_fcolor('H'.$row_1,'ff0000');
			} else {
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "NO");
			}	
			$col_1++;

			if($row1['anniversary']!='0000-00-00'){
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['anniversary']);
				mytemplate_design_fcolor('I'.$row_1,'ff0000');
			} else {
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "NO");
			}
			$col_1++;

			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_qualification']);
			$col_1++;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $row1['doc_specilist_id']);
			$col_1++;
			if($lat_and_long!=''){
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $lat_and_long);
				mytemplate_design_fcolor('L'.$row_1,'ff0000');
			} else {
				$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, "NO KMs");
			}
			$col_1++;
			// echo "SELECT (case id when '7' then 'GM' when '0' then 'NO JWE' else 'BPM' end) as rep_name FROM representative WHERE id IN (".$row1['jointworkby'].")";
			// exit();
			$pp=0;
			$SQL51=mysql_query("SELECT (case  when id='7' then 'GM' else 'BPM' end) as rep_name FROM representative WHERE id IN (".$row1['jointworkby'].")");
			$num_rows1=mysql_num_rows($SQL51);

			if($num_rows1==0){
				$rep2='NO JWE';
			}
			else
			{
				while($row151=mysql_fetch_array($SQL51))
				{
					if($pp==0)
					{
						$rep1=$row151['rep_name'];
						$rep2=$rep1;
					}
					elseif($pp==1)
					{
						$rep2=$rep1.'('.$row151['rep_name'].')';
					}
					$pp++;

				}
			}
			// echo $rep2;
			$objWorkSheet->setCellValueByColumnAndRow($col_1, $row_1, $rep2);
			$col_1++;

			$s_no1++;
			$row_1++;
		}

		if(strpos($y_customer["rep_name"], "(")>0){
			$title_card=substr($y_customer["rep_name"], 0, strpos($y_customer["rep_name"], "("));
		} else {
			$title_card=$y_customer["rep_name"];
		}

		$objWorkSheet->setTitle($title_card);

		$j++;
	}
}
// exit();
$yuvaraj->setActiveSheetIndex(1);
$SQL5=mysql_query("SELECT * FROM representative WHERE id ='".$_REQUEST['mgr']."'");
$row15=mysql_fetch_array($SQL5);
//prepare download
$filename="Overall Visit Report - ".date("F Y").".xls";
//$filename=$row15["rep_name"]."Overall Visit Report (".$date.").xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
//$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
$objWriter->save(str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/'.$filename,__FILE__));
$_SESSION['file_name_DCU']=$filename;
$_SESSION['success_msg_DCU']="Success";
exit; //done.. exiting!

?>