<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
session_start();



ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
error_reporting(0);

$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls"); 

$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$objWorkSheet='';
$j=0;

$objWorkSheet=$yuvaraj->createSheet($j);

$objWorkSheet->mergeCells('A1:K1');

$objWorkSheet->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$objWorkSheet->getStyle('A1:K1')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(1)->setRowHeight(20);
$objWorkSheet->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objWorkSheet->getStyle('A1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:K1','eceeef');
mytemplate_design_fcolor('A1:K1','000000');

$objWorkSheet->mergeCells('A2:K2');
$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Distributor List");
$objWorkSheet->getStyle('A2:K2')->getFont()->setSize(10);
$objWorkSheet->getStyle('A2:K2')->getAlignment()->setShrinkToFit(true);
$objWorkSheet->getStyle('A2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objWorkSheet->getStyle('A2:K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objWorkSheet->getStyle('A2:K2')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(2)->setRowHeight(20);

$objWorkSheet->setCellValueByColumnAndRow(0, 3, "S.No");
$objWorkSheet->getColumnDimensionByColumn(0)->setWidth(7);
$objWorkSheet->setCellValueByColumnAndRow(1, 3, "Distributor Name");
$objWorkSheet->getColumnDimensionByColumn(1)->setWidth(40);
$objWorkSheet->setCellValueByColumnAndRow(2, 3, "Distributor Code");
$objWorkSheet->getColumnDimensionByColumn(2)->setWidth(15);
$objWorkSheet->setCellValueByColumnAndRow(3, 3, "Country");
$objWorkSheet->getColumnDimensionByColumn(3)->setWidth(12);
$objWorkSheet->setCellValueByColumnAndRow(4, 3, "State");
$objWorkSheet->getColumnDimensionByColumn(4)->setWidth(12);
$objWorkSheet->setCellValueByColumnAndRow(5, 3, "District");
$objWorkSheet->getColumnDimensionByColumn(5)->setWidth(12);
$objWorkSheet->setCellValueByColumnAndRow(6, 3, "Town");
$objWorkSheet->getColumnDimensionByColumn(6)->setWidth(12);
$objWorkSheet->setCellValueByColumnAndRow(7, 3, "Distributor Beat");
$objWorkSheet->getColumnDimensionByColumn(7)->setWidth(25);
$objWorkSheet->setCellValueByColumnAndRow(8, 3, "Distributor Rep");
$objWorkSheet->getColumnDimensionByColumn(8)->setWidth(25);
$objWorkSheet->setCellValueByColumnAndRow(9, 3, "Contact Person");
$objWorkSheet->getColumnDimensionByColumn(9)->setWidth(18);
$objWorkSheet->setCellValueByColumnAndRow(10, 3, "Contact Number");
$objWorkSheet->getColumnDimensionByColumn(10)->setWidth(18);

$objWorkSheet->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objWorkSheet->getStyle('A3:K3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objWorkSheet->getStyle('A3:K3')->getFont()->setBold(true);
$objWorkSheet->getRowDimension(3)->setRowHeight(20);

mytemplate_design_bg('A3:K3','eceeef');
mytemplate_design_fcolor('A3:K3','000000');
$objWorkSheet->freezePane('A4');

$stockist_name='';
if(@$_REQUEST['stockist_name']!=''){
	$stockist_name="AND doctor_name LIKE '%".$_REQUEST['stockist_name']."%'";
}
$mobile_number='';
if(@$_REQUEST['mobile_number']!=''){
	$mobile_number="AND doc_contact_no='".$_REQUEST['mobile_number']."'";
}
$country='';
if(@$_REQUEST['country']!=''){
	$country="AND country='".$_REQUEST['country']."'";
}
$state='';
if(@$_REQUEST['state']!=''){
	$state="AND state='".$_REQUEST['state']."'";
}
$district='';
if(@$_REQUEST['district']!=''){
	$district="AND district='".$_REQUEST['district']."'";
}
$town='';
if(@$_REQUEST['town']!=''){
	$town="AND town='".$_REQUEST['town']."'";
}
$area='';
if(@$_REQUEST['area']!=''){
	$area="AND beatid='".$_REQUEST['area']."'";
}
$representative='';
if(@$_REQUEST['representative']!=''){
	$representative="AND rep_assign='".$_REQUEST['representative']."'";
}

$i=1;
$row=4;
$sql_distributor=mysql_query("SELECT * FROM doctors1 WHERE id!='' $stockist_name $mobile_number $country $state $district $town $area $representative ".$repmgrid3." ORDER BY id DESC");
while($row_distributor=mysql_fetch_array($sql_distributor))
{
	$sql_country=mysql_query("SELECT id,country_name FROM mst_countries WHERE  id='".$row_distributor['country']."'");
	$row_country=mysql_fetch_array($sql_country);

	$sql_state=mysql_query("SELECT state_id,state_name FROM master_state WHERE state_id='".$row_distributor['state']."'");
	$row_state=mysql_fetch_array($sql_state);
	
	$sql_district=mysql_query("SELECT district_id,district_name FROM master_district WHERE district_id='".$row_distributor['district']."'");
	$row_district=mysql_fetch_array($sql_district);
	
	$sql_town=mysql_query("SELECT id,area_name FROM pincode_list WHERE id='".$row_distributor['town']."'");
	$row_town=mysql_fetch_array($sql_town);
	
	$sql_beat=mysql_query("SELECT name as beat_name FROM beadname where id='".$row_distributor['beatid']."'");
	$row_beat=mysql_fetch_array($sql_beat);

	$sql_rep=mysql_query("SELECT * FROM representative where id='".$row_distributor['rep_id']."'");
	$row_rep=mysql_fetch_array($sql_rep);

	$col=0;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $i);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_distributor['doctor_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_distributor['doc_specilist_id']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_country['country_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_state['state_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_district['district_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_town['area_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_beat['beat_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_rep['rep_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_distributor['doc_hospital_clinic_name']);
	$col++;
	$objWorkSheet->setCellValueByColumnAndRow($col, $row, $row_distributor['doc_contact_no']);
	$col++;

	$row++;
	$i++;
}

$num=$i+2;
$objWorkSheet->getStyle('A1:K'.$num)->applyFromArray($styleArray);

$objWorkSheet->setTitle("Distributor List");

$yuvaraj->setActiveSheetIndex(0);	

//prepare download
$filename="Distributor List.xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');//downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');

exit; //done.. exiting!

?>
