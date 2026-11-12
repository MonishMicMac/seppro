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

$yuvaraj->getActiveSheet()->mergeCells('A1:H1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:H1','9d9b9b');
mytemplate_design_fcolor('A1:H1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:H2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date('m-Y'));
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:H2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:H3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "AMC / WARRENTY CURRENT MONTH SERVICE ".date('m-Y'));
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "S.NO");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "Company Name");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "Mobile Number");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "Address");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "Product");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "Type");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "Start Date");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "End Date");


	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, strtoupper($_SESSION["LABEL"]));

$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:H4','eceeef');	

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
		// echo "SELECT clinetcreation.name,clinetcreation.address,clinetcreation.pincode,clinetcreation.mobileno,clinetcreation.companyname,client_product_list.product,client_product_list.clientid,client_product_list.model_no,client_product_list.purchase_date,client_product_list.start_date,client_product_list.end_date,client_product_list.brand_name,client_product_list.capacity,client_product_list.type FROM client_product_list,clinetcreation WHERE clinetcreation.id=client_product_list.clientid AND client_product_list.type IN ('AMC','warranty') AND '".date('d-m-Y')."' < client_product_list.end_date";
$selectquery = mysql_query("SELECT clinetcreation.name,clinetcreation.address,clinetcreation.pincode,clinetcreation.mobileno,clinetcreation.companyname,client_product_list.product,client_product_list.clientid,client_product_list.model_no,client_product_list.purchase_date,client_product_list.start_date,client_product_list.end_date,client_product_list.brand_name,client_product_list.capacity,client_product_list.type FROM client_product_list,clinetcreation WHERE clinetcreation.id=client_product_list.clientid AND client_product_list.type IN ('AMC','warranty') AND '".date('d-m-Y')."' < client_product_list.end_date")or die(mysql_error());
// $replist_res = mysql_fetch_array($replist);

  $replist = mysql_query("SELECT * FROM product_category_master")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($selectquery))
    {  
      for($i=3;$i<100;$i=$i+3)
{
  // echo $replist_res['start_date'];
  // echo "SELECT DATE_ADD('".date("Y-m-d",strtotime($replist_res['start_date']))."', INTERVAL '".$i."' MONTH) as date";
     $var1=mysql_query("SELECT DATE_ADD('".date("Y-m-d",strtotime($replist_res['start_date']))."', INTERVAL '".$i."' MONTH) as date")or die(mysql_error());
     while($var_res = mysql_fetch_array($var1))
     {
      $amcdate=date("m-Y",strtotime($var_res['date']));
      // echo date('m-Y').$amcdate;
     if(date('m-Y')==$amcdate)
     {
	
		$col=0;
		$row_1 = 1;	
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res["companyname"]);	
					
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res["mobileno"]);
					
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res["address"]);

					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res["product"]);

					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res["type"]);

					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res["start_date"]);

					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res["end_date"]);
					$row++;
					$i++;
				}

			}
		}
		$i++;
	}

$yuvaraj->setActiveSheetIndex(0);
	
		
//prepare download
$filename="amc/warrenty service: ".date('d-m-Y').".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>