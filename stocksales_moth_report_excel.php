<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
error_reporting(0);
/*include("include/function.php");
$conn=mysql_connect("localhost","root","");
mysql_select_db("xylo");*/
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
$REP = mysql_query("SELECT id,rep_name FROM representative WHERE id='".$_REQUEST['rep_name']."'");
$R=mysql_fetch_object($REP);
$from_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$from_date."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);

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
$yuvaraj->getActiveSheet()->mergeCells('A1:E1');
// $yuvaraj->getActiveSheet()->getStyle('A1:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, strtoupper($R->rep_name)." - STOCK AND SALES FOR REP - ".$_REQUEST["from_date"]);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "DATE");
$yuvaraj->getActiveSheet()->getStyle('A3:CX3')->getFont()->setBold(true);
// $yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('C4:CX99')->getAlignment()->setWrapText(true);  
$yuvaraj->getActiveSheet()->getStyle('C4:CX99')->getFont()->setBold(false);
// $yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('C4:CX99')->getAlignment()->setWrapText(true);
mytemplate_design_fcolor('C4:CX99','00bf73');
$col=1;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, "CLIENT NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
$col=2;
$Product=mysql_query("SELECT * FROM productinsertt WHERE repid='".$_REQUEST['rep_name']."' AND (cdate between '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."') GROUP BY proid ORDER BY cast(proid as unsigned) "); // PRODUCT DETAILS	
while($P=mysql_fetch_object($Product)){

	$Prodview=mysql_query("SELECT * FROM product WHERE id='".$P->proid."'"); // PRODUCT DETAILS	
		$Prodview_row=mysql_fetch_object($Prodview);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, strtoupper($Prodview_row->pro_name));
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX99')->getFont()->setBold(true);
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$col++;	
	// $yuvaraj->getActiveSheet()->getStyle('A3:BX3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
}

// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, 3, "NSR VALUE IN RS");
// CLIENT POB - START
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DATE");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "AREA COVERED");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "KMS");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "ALLOWANCE");
// $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(35);
// $yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
// $yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
// $yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
// $yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $yuvaraj->getActiveSheet()->freezePane('A4');	
// mytemplate_design_bg('A3:E3','eceeef');	
// CLIENT POB - START
$row=4;$YP = 1;
$TOT=0;
$i=1;
$totexp=0;
$sqlsqq=mysql_query("SELECT rep_hq_wages FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
$aqq=mysql_fetch_array($sqlsqq);


$Daysperiod=mysql_query("select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."' ");
while($D=mysql_fetch_object($Daysperiod)){	


		$col=0;
		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
		// $col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("Y-m-d",strtotime($D->selected_date)));
		$col=1;	
		$sqlss1=mysql_query("SELECT GROUP_CONCAT(DISTINCT clientid) as clientid FROM productinsertt WHERE repid='".$_REQUEST['rep_name']."' AND cdate = '".date("Y-m-d",strtotime($D->selected_date))."' ");
		$rowss=mysql_fetch_array($sqlss1);	
			$cli='';
			$cli= $rowss['clientid'];
			$sdw = explode(",",$cli);
			$h=0;
			for($h=0;$h< count($sdw);$h++)
			{	
				// echo "SELECT  name,pincode,companyname  FROM clinetcreation WHERE id='".$sdw[$h]."'";
				$sqlss1=mysql_query("SELECT  name,pincode,companyname  FROM clinetcreation WHERE id='".$sdw[$h]."'");
				$rowss1=mysql_fetch_object($sqlss1);
				if($rowss1->companyname!='' || $rowss1->pincode!='')
				{
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $rowss1->companyname.'('.$rowss1->pincode.')');
				}
				else
				{
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $rowss1->companyname);	
				}
				
				


		// echo "SELECT id,pro_name,IFNULL((SELECT stockist from productinsertt WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND proid=product.id AND clientid='".$sdw[$h]."' LIMIT 1),'NA') AS Q,IFNULL((SELECT sales from productinsertt WHERE repid='2' AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND clientid='".$sdw[$h]."' AND proid=product.id LIMIT 1),'NA') AS p FROM product WHERE id IN (SELECT proid FROM productinsertt WHERE repid='".$_REQUEST['rep_name']."' ) ORDER BY cast(product.id as unsigned)";
		$Client_details = mysql_query("SELECT id,pro_name,(SELECT sum(stockist) AS stockist  from productinsertt WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND proid=product.id AND clientid='".$sdw[$h]."' LIMIT 1) AS Q,(SELECT sum(sales) AS sales from productinsertt WHERE repid='2' AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND clientid='".$sdw[$h]."' AND proid=product.id LIMIT 1) AS p FROM product WHERE id IN (SELECT proid FROM productinsertt WHERE repid='".$_REQUEST['rep_name']."' ) ORDER BY cast(product.id as unsigned)");
			$col=2;
		while($C1=mysql_fetch_object($Client_details)){		
			
			if($C1->Q!='' || $C1->p!='')
			{
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCK :".$C1->Q.'-'."SALES :".$C1->p);
			}
			else
			{
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->Q.'-'.$C1->p);
			}
		
			$col++;

			// $yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);		
		}
			
		// $sqls=mysql_query("SELECT GROUP_CONCAT(wp_dc_id) as pids,GROUP_CONCAT(latitude) as latitude,GROUP_CONCAT(longitude) as longitude FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND attendancestatus='1' AND wp_rep_id='".$_REQUEST['rep_name']."' AND latitude!='0' AND longitude!='0' AND latitude!='0.0' AND longitude!='0.0'")or die(mysql_error());
		// $a=mysql_fetch_array($sqls); 
		// if($a['pids']=='')
		// {
		
		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "no visit");
		// $col++;
		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0 KM");
		// $col++;
		// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0");
		// $col++;
		// }
		// else
		// {
		//  $totexp=$totexp+$aqq['rep_hq_wages'];
		// $sqlsq=mysql_query("SELECT GROUP_CONCAT(doc_pin_id) as pinid FROM doctors where id IN('".$a['pids']."')")or die(mysql_error());
		// 	$aq=mysql_fetch_array($sqlsq);
			


		// 	$sqlsqs=mysql_query("SELECT GROUP_CONCAT(area_name) as areaname FROM pincode_list where pin_id IN('".$aq['pinid']."')")or die(mysql_error());
		// 	$aqs=mysql_fetch_array($sqlsqs);
			
		// 	$sqlsqslalo=mysql_query("SELECT GROUP_CONCAT(dr_latitude) as dr_latt,GROUP_CONCAT(dr_longitude) as dr_long FROM doctors where id IN('".$a['pids']."') AND dr_latitude!='0' AND dr_longitude!='0' AND dr_latitude!='0.0' AND dr_longitude!='0.0' ")or die(mysql_error());
		// 	$aqslalo=mysql_fetch_array($sqlsqslalo);
		// 	 if($aqs['areaname']=='')
		// 	 {
		// 	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "no Area name");
		// 	 	$col++;
		// 	 }
		// 	 else
		// 	 {
		// 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $aqs['areaname']);
		// 	$col++;
		// 	}	
		// 	 $a['latitude'];
		// 	 $a['longitude'];
			  
		// 		 if($a['latitude']!='' && $a['longitude']!='' && $aqslalo['dr_latt']!='' && $aqslalo['dr_long']!=''){ 
        
  //         $DISTANCE = calculateDistance($aqslalo['dr_latt'], $aqslalo['dr_long'], $a['latitude'], $a['longitude']);   
       
  //       } 
		// 	 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $DISTANCE." KM");
		// 	 $col++;
	
		// 	 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $aqq['rep_hq_wages']);
		// 	 $col++;
			
		// }
	
	$YP++;$row++;
	$i++;
}
}
// exit();
// 	$col--;	
// 	$col--;	
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total");
// 	$col++;	
	
// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totexp);



$filename=strtoupper($R->rep_name)." stock_sales_rep_report ".date("d/m/Y H:i:s").".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>