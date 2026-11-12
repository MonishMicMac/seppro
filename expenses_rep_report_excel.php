<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
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
$yuvaraj->getActiveSheet()->mergeCells('A1:F1');
// $yuvaraj->getActiveSheet()->getStyle('A1:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

$yuvaraj->getActiveSheet()->mergeCells('A2:F2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, strtoupper($R->rep_name)." - EXPENSES FOR ".date("Y-m-d",strtotime($from_date))." TO ".date("Y-m-d",strtotime($R_MDATE->LastDay)));
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Date");
$yuvaraj->getActiveSheet()->getStyle('A3:F2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(60);
$yuvaraj->getActiveSheet()->getStyle('A3:F2')->getAlignment()->setWrapText(true);
$col=1;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(5);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DATE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "AREA COVERED");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(120);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "KMS");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "ALLOWANCE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "CLAIMABLE FARE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(25);
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
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
$sqlsqq=mysql_query("SELECT rep_hq_wages,(rep_ex_wages+rep_out_wages) AS outstrep FROM representative where id='".$_REQUEST['rep_name']."'")or die(mysql_error());
$aqq=mysql_fetch_array($sqlsqq);


$Daysperiod=mysql_query("select * from 
	(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
	where selected_date BETWEEN  '".$from_date."' AND '".date("Y-m-d",strtotime($R_MDATE->LastDay))."' ");
$num_rows=mysql_num_rows($Daysperiod);
$num=$num+$num_rows+4;
$yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
$yuvaraj->getActiveSheet()->getStyle('F1:F'.$num)->applyFromArray($styleArray);
while($D=mysql_fetch_object($Daysperiod)){	


	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $P);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("Y-m-d",strtotime($D->selected_date)));
	$col=2;	

	$sqls=mysql_query("SELECT GROUP_CONCAT(wp_dc_id) as pids,GROUP_CONCAT(latitude) as latitude,GROUP_CONCAT(longitude) as longitude FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($D->selected_date))."' AND attendancestatus='1' AND wp_rep_id='".$_REQUEST['rep_name']."' AND latitude!='0' AND longitude!='0' AND latitude!='0.0' AND longitude!='0.0'")or die(mysql_error());
	$a=mysql_fetch_array($sqls); 
	if($a['pids']=='')
	{
		// $output.= '{"value":"'.$day.'*no visit'.'*0'.'"},';
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "no visit");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0 KM");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0");
		$col++;
	}
	else
	{
		 // $totexp=$totexp+$aqq['rep_hq_wages'];
		$sqlsq=mysql_query("SELECT GROUP_CONCAT(doc_pin_id) as pinid FROM doctors where id IN(".$a['pids'].")")or die(mysql_error());
		$aq=mysql_fetch_array($sqlsq);



		$sqlsqs=mysql_query("SELECT GROUP_CONCAT(area_name) as areaname FROM pincode_list where pin_id IN(".$aq['pinid'].")")or die(mysql_error());
		$aqs=mysql_fetch_array($sqlsqs);

			// $sqlsqslalo=mysql_query("SELECT GROUP_CONCAT(dr_latitude) as dr_latt,GROUP_CONCAT(dr_longitude) as dr_long FROM doctors where id IN('".$a['pids']."') AND dr_latitude!='0' AND dr_longitude!='0' AND dr_latitude!='0.0' AND dr_longitude!='0.0' ")or die(mysql_error());
			// $aqslalo=mysql_fetch_array($sqlsqslalo);
		if($aqs['areaname']=='')
		{
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "no Area name");
			$col++;
		}
		else
		{
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $aqs['areaname']);
			$col++;
		}	
		$a['latitude'];
		$a['longitude'];

				 // if($a['latitude']!='' && $a['longitude']!='' && $aqslalo['dr_latt']!='' && $aqslalo['dr_long']!=''){ 

     //      $DISTANCE = calculateDistance($aqslalo['dr_latt'], $aqslalo['dr_long'], $a['latitude'], $a['longitude']);   

     //    } 
		$sql1new=mysql_query("SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST["rep_name"]."' and date='".date("Y/m/d",strtotime($D->selected_date))."'");
		$row1new=mysql_fetch_object($sql1new);
		$location=explode(":", $row1new->latandlong);
		$j=1;
		$total=0;
		for ($i=0; $i<count($location)-1; $i++) { 
			if($location[$j]!=''){
				$loc=explode(",", $location[$i]);
				$loc1=explode(",", $location[$j]);
				if(calculateDistance($loc[0],$loc[1],$loc1[0],$loc1[1])>0){
					$total=$total+calculateDistance($loc[0],$loc[1],$loc1[0],$loc1[1]);
				}
				$j++;
			}
		}
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($total)." KM");
		$col++;
		$sqlsqsnew=mysql_query("SELECT station FROM stationplanforrep where pinid IN (".$aq['pinid'].") GROUP BY station")or die(mysql_error());
		$aqsnew=mysql_num_rows($sqlsqsnew);
		if($aqsnew=='1')
		{
			$aqsnew=mysql_fetch_object($sqlsqsnew); if($aqsnew->station=='local') {  $totall=$aqq['rep_hq_wages']; } elseif($aqsnew->station=='out') {  $totall=$aqq['outstrep']; } }
			elseif($aqsnew=='2') {  $totall=$aqq['outstrep']; }
			else {  $totall=$aqq['rep_hq_wages']; }

			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totall);
			$col++;

			$wag=$wag+$totall;
			
			$cl_exp=mysql_query("SELECT sum(fareamount) AS clfare FROM expenses where reporteddate='".date("Y-m-d",strtotime($D->selected_date))."' AND repid='".$_REQUEST['rep_name']."'")or die(mysql_error());
			$cl_exp_row=mysql_fetch_object($cl_exp);
			if($cl_exp_row->clfare!='')
			{
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $cl_exp_row->clfare);
				$col++;
				$clwag=$clwag+$cl_exp_row->clfare;
			}
			else
			{
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0");
				$col++;
			}
			
		}
		// $Client_details = mysql_query("SELECT id,pro_name,IFNULL((SELECT qty from pobbooking WHERE repid='".$_REQUEST['rep_name']."' AND cdate='".date("Y-m-d",strtotime($D->selected_date))."' AND productid=product.id LIMIT 1),'NA') AS Q FROM product WHERE id IN (SELECT productid FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."') ORDER BY product.id");
		// while($C1=mysql_fetch_object($Client_details)){		
		// 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C1->Q);
		// 	$col++;
		// 	// $yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);		
		// }
		// echo "SELECT IFNULL(ROUND(SUM(pobbooking.qty*product.pts),2),0) pts FROM `product`, pobbooking WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($D->selected_date))."' ";
	// 	$Client_details1 = mysql_query("SELECT IFNULL(ROUND(SUM(pobbooking.qty*product.pts),2),0) pts FROM `product`, pobbooking WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate='".date("Y-m-d",strtotime($D->selected_date))."' ");
	// $C2=mysql_fetch_object($Client_details1);
	// $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $C2->pts);
	// $TOT+=$C2->pts;	

		$YP++;$row++;
		$P++;

	}
	$col--;	
	$col--;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total - ".$wag);
	$col++;	
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total - ".$clwag);

// $col=1;
// // TOTAL SUMMARY - START
// 	$Product_T=mysql_query("SELECT * FROM pobbooking WHERE repid='".$_REQUEST['rep_name']."' GROUP BY productid ORDER BY pob_id"); // PRODUCT DETAILS	
// 	while($P_T=mysql_fetch_object($Product_T)){
// 			$Prodview1=mysql_query("SELECT * FROM product WHERE id='".$P_T->productid."'"); // PRODUCT DETAILS	
// 		$Prodview_row1=mysql_fetch_object($Prodview1);

// 		$INDIVIDUAL_PRODUCT = mysql_query("SELECT IFNULL(SUM(qty),0) Q FROM pobbooking WHERE productid='".$Prodview_row1->id."' AND pobbooking.repid='".$_REQUEST['rep_name']."' AND pobbooking.cdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' ORDER BY pobbooking.pob_id");
// 		$Y3=mysql_fetch_object($INDIVIDUAL_PRODUCT);	
// 		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y3->Q);
// 		$col++;
// 		// $yuvaraj->getActiveSheet()->getStyle('A'.$row.':BX'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
// 	}$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOT);
// 	$row++;
// exit();
// CLIENT POB - END

//prepare download
$filename=strtoupper($R->rep_name)." expenses_report ".date("d/m/Y H:i:s").".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

exit; //done.. exiting!

?>