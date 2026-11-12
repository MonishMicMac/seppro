<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
error_reporting(0);
/*include("include/function.php");
$conn=mysql_connect("localhost","root","");
mysql_select_db("xylo");*/
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
// $REP = mysql_query("SELECT id,rep_name FROM representative WHERE id='".$_REQUEST['repname']."'");
// $R=mysql_fetch_object($REP);
// $from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
// $MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
// $R_MDATE=mysql_fetch_object($MDATE);

function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {    
  $theta = $longitude1 - $longitude2;           
  $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
  $miles = acos($miles);
  $miles = rad2deg($miles);
  $miles = $miles * 60 * 1.1515;
  return round($miles * 1.609344,2);
}

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
$yuvaraj->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->calculateColumnWidths();
$yuvaraj->getActiveSheet()->mergeCells('A1:G1');
// $yuvaraj->getActiveSheet()->getStyle('A1:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

$yuvaraj->getActiveSheet()->mergeCells('A2:G2');
if($_REQUEST['status']=='1')
{
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "CURRENT DATE CALLS REPORT FOR".date("Y-m-d"));

}
elseif($_REQUEST['status']=='2')
{
  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "SELECTED DATE CALLS REPORT FOR ".date("Y-m-d",strtotime($_REQUEST["from_date"]))." TO ".date("Y-m-d",strtotime($_REQUEST["to_date"])));

}
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Date");
$yuvaraj->getActiveSheet()->getStyle('A3:G2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('A3:G2')->getAlignment()->setWrapText(true);
$col=1;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Name");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "Feedback");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "Product Name");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "Type");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "Date/Rep Name");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "Status");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setAutoSize(true);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "CLAIMABLE FARE");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(25);
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A4'); 
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );
// mytemplate_design_bg('A3:E3','eceeef');  
// CLIENT POB - START
$row=4;$YP = 1;
$TOT=0;
$P=1;
$totexp=0;
$num=0;
$fareamount1=0;
// $sqlsqq=mysql_query("SELECT rep_hq_wages FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
// $aqq=mysql_fetch_array($sqlsqq);


// $Daysperiod=mysql_query("select * from 
// (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
//  (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
//  (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
//  (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
//  (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
//  (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
// where selected_date BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."' ");
// $num_rows=mysql_num_rows($Daysperiod);
//   $num=$num+$num_rows+4;
//     $yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
//     $yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
//     $yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
//     $yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
//     $yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
//     $yuvaraj->getActiveSheet()->getStyle('F1:F'.$num)->applyFromArray($styleArray);
// while($D=mysql_fetch_object($Daysperiod)){  


$col=0;
//     $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $P);
//     $col++;
//     $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("Y-m-d",strtotime($D->selected_date)));
//     $col=2; 
if($_REQUEST['status']=='1')
{
 $replist = mysql_query("SELECT * FROM marketing_sales_call,databaseclient_new WHERE marketing_sales_call.m_client_id=databaseclient_new.db_id AND  marketing_sales_call.m_updatetime LIKE '%".date('Y-m-d')."%'")or die(mysql_error());
}
elseif($_REQUEST['status']=='2')
{
  $replist = mysql_query("SELECT * FROM marketing_sales_call,databaseclient_new WHERE marketing_sales_call.m_client_id=databaseclient_new.db_id AND  (marketing_sales_call.m_updatetime BETWEEN '".date('Y-m-d',strtotime($_REQUEST['from_date']))."' AND '".date('Y-m-d',strtotime($_REQUEST['to_date']))."') ")or die(mysql_error());
}
$jj=1;

$num_rows=mysql_num_rows($replist);
$num=$num+$num_rows+3;
$yuvaraj->getActiveSheet()->getStyle('A1:G'.$num)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
// $yuvaraj->getActiveSheet()->getStyle('F1:F'.$num)->applyFromArray($styleArray);

while($replist_res = mysql_fetch_array($replist))
{

  if($replist_res['m_pdt_name']!='')
  {
   $replist10 = mysql_query("select GROUP_CONCAT(pro_name) AS pdtname from product where id IN (".$replist_res['m_pdt_name'].")")or die(mysql_error());
   $replist10_count = mysql_fetch_array($replist10);
 }

  // if($replist_res['db_category']=='1') // Architects
  // {
  //   $nameall=$replist_res['db_architect_name'];
  //   $contactall=$replist_res['db_architect_contact_number '];
  // }
  //   elseif($replist_res['db_category']=='2' ||  $replist_res['db_category']=='6') // Builders & Newspaper
  //   {
  //    $nameall=$replist_res['db_builder_name'];
  //    $contactall=$replist_res['db_builder_contact_number'];
  //  }
  //  elseif($replist_res['db_category']=='3' || $replist_res['db_category']=='4') // Streetscan & Arihant
  //  {
  //    $nameall=$replist_res['db_client_name'];
  //    $contactall=$replist_res['db_client_contact_number'];
  //  }   
  //  elseif($replist_res['db_category']=='5' || $replist_res['db_category']=='7') // Play Area & Reference
  //  {
  //    $nameall=$replist_res['db_contact_name'];
  //    $contactall=$replist_res['db_contact_number'];
  //  }

   $col=0;
    // $output.= '{"value":"'.$day.'*no visit'.'*0'.'"},';
   $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $jj);
   $col++;
   $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res['db_contact_name']);
   $col++;
   $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist_res['m_feedback']);
   $col++;
   $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $replist10_count['pdtname']);
   $col++;
   if($replist_res['m_call_status']=='1'){ $typeofinout="RESCHEDULED"; $viewtype=$replist_res['m_date']; }elseif($replist_res['m_call_status']=='2'){ $typeofinout="SALES"; 



   $repid_data = mysql_query("select representative.rep_name from reorting,representative where reorting.clientid=(select id from clinetcreation where data_client_id='".$replist_res['m_client_id']."') AND reorting.repid=representative.id")or die(mysql_error());
   $repid_data_row = mysql_fetch_array($repid_data);
   $viewtype=$repid_data_row['rep_name']; }elseif($replist_res['m_call_status']=='3'){ $typeofinout="SHOW ROOM"; $viewtype='';}
   $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $typeofinout);
   $col++;

   $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $viewtype);
   $col++;
   if($replist_res['m_inandnotin']=='1'){ $inoutstatus="INTEREST"; }elseif($replist_res['m_inandnotin']=='2'){ $inoutstatus="NOT INTEREST";}
   $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $inoutstatus);
   $col++;

    // $Client_details = mysql_query("SELECT id,pro_name,IFNULL((SELECT qty from pobbooking WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND productid=product.id LIMIT 1),'NA') AS Q FROM product WHERE id IN (SELECT productid FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."') ORDER BY product.id");
    // while($C1=mysql_fetch_object($Client_details)){    
    //  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->Q);
    //  $col++;
    //  // $yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);   
    // }
    // echo "SELECT IFNULL(ROUND(SUM(pobbooking.qty*product.pts),2),0) pts FROM `product`, pobbooking WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($D->selected_date))."' ";
  //  $Client_details1 = mysql_query("SELECT IFNULL(ROUND(SUM(pobbooking.qty*product.pts),2),0) pts FROM `product`, pobbooking WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($D->selected_date))."' ");
  // $C2=mysql_fetch_object($Client_details1);
  // $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C2->pts);
  // $TOT+=$C2->pts;  

   $YP++;$row++;
   $P++;
   $jj++;
 }


// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total - ".$clwag);

// $col=1;
// // TOTAL SUMMARY - START
//  $Product_T=mysql_query("SELECT * FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."' GROUP BY productid ORDER BY pob_id"); // PRODUCT DETAILS 
//  while($P_T=mysql_fetch_object($Product_T)){
//      $Prodview1=mysql_query("SELECT * FROM product WHERE id='".$P_T->productid."'"); // PRODUCT DETAILS  
//    $Prodview_row1=mysql_fetch_object($Prodview1);

//    $INDIVIDUAL_PRODUCT = mysql_query("SELECT IFNULL(SUM(qty),0) Q FROM pobbooking WHERE productid='".$Prodview_row1->id."' AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' ORDER BY pobbooking.pob_id");
//    $Y3=mysql_fetch_object($INDIVIDUAL_PRODUCT);  
//    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y3->Q);
//    $col++;
//    // $yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//  }$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOT);
//  $row++;
// exit();
// CLIENT POB - END

//prepare download
 if($_REQUEST['status']=='1')
 {
  $filename="MARKETING_CALLS_REPORT ".date("Y-m-d").".xls";
}
elseif($_REQUEST['status']=='2')
{
  $filename="MARKETING_CALLS_REPORT ".date("Y-m-d",strtotime($_REQUEST["from_date"]))." TO ".date("Y-m-d",strtotime($_REQUEST["to_date"])).".xls";
}

 //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>