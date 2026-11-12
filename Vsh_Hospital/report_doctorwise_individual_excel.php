<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
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


function mytemplate_design_bg($range,$bg){
	global $yuvaraj;
	$title = array(    	
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => $bg,
				),
			),
		);
	$yuvaraj->getActiveSheet()->getStyle($range)->applyFromArray($title);
}

function mytemplate_design_fcolor($range,$fcolor){
	global $yuvaraj;
	$title = array(
		'font' => array(
			'bold' => true,   
			'color' => array(
				'rgb' => $fcolor
				),
			), 	    
		);
	$yuvaraj->getActiveSheet()->getStyle($range)->applyFromArray($title);
}




if(@$_REQUEST["division_id"]!=""){
	$division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
} else {
	if($_SESSION["division_id"]!="ALL")
		$division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
	else 
		$division_default = "";
}



if(@$_REQUEST["state"]) {
	$state_check = "and a.state_id='".(@$_REQUEST["state"])."'";
	$state_url = "&state_id=".(@$_REQUEST["state"]);
} else {

	if($_SESSION["state_id"]!="ALL") {
		$state_check = " and a.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
	} else {
		$state_check = "";
	}

	$state_url = "";
}





//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:I1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Capital");
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');
$DR = explode("-",$_REQUEST["doctor"]);

$SQL = mysql_query("SELECT pin_id FROM master_pincode WHERE pincode='".$DR[0]."' ");
$RS = mysql_fetch_object($SQL);
$DOCTORID = mysql_query("SELECT chemist_id FROM doctors WHERE doctor_name='".$DR[1]."' AND doc_pin_id='".$RS->pin_id."'");
$DRID = mysql_fetch_object($DOCTORID);	

$b=mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp a WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id IN (".$DRID->chemist_id.") AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != '' ".$division_default." ".$state_check)or die(mysql_error()); 

$p = mysql_fetch_assoc($b);

$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["cust_name"]." / [PTR Value: ".round($p["PTR"],2)." PTS Value: ".round($p["PTS"],2)." ] ");
//$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:I2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:I3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Doctorwise Individual Report");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "DOCTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "DISTRIBUTOR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "BATCH");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "PTR S.Value");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "PTS S.Value");
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:I4','eceeef');	
$customer = explode("-",$_REQUEST["cust_name"]);
$row = 5;
$rowcnt = 2;
$cmerge = 1;

//echo "SELECT id, shop_name FROM tbl_customer_master WHERE id IN (".$DRID->chemist_id.")"; exit;
$a=mysql_query("SELECT id, shop_name FROM tbl_customer_master WHERE id IN (".$DRID->chemist_id.")")or die(mysql_error());
while($customer=mysql_fetch_assoc($a)){		
	$col =0;		
    //foreach($customer as $key=>$value) {
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(35);						
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer["shop_name"]);	# Product Value - Display	
		//mytemplate_design_bg($col,'eceeef');
		//$yuvaraj->getActiveSheet()->getStyle($col)->getFill()->getStartColor()->setRGB('eceeef');	
        $col =1;			
        $yuvaraj->getActiveSheet()->getStyle($col)->getFill()->getStartColor()->setRGB('B7B7B7');
      
      // echo "SELECT dist_id AS DID,(select pro_name from product where id=a.our_product_id) AS cust_name, GROUP_CONCAT(DISTINCT(batch_id)) as BATCH, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(quantity*ptr) AS ptr, SUM(quantity*pts) AS pts  FROM areawise_temp a WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id ='".$customer['id']."' AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != '' ".$division_default." ".$state_check." GROUP BY our_product_id"; exit;

      $b=mysql_query("SELECT dist_id AS DID,(select pro_name from product where id=a.our_product_id) AS cust_name, GROUP_CONCAT(DISTINCT(batch_id)) as BATCH, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(quantity*ptr) AS ptr, SUM(quantity*pts) AS pts  FROM areawise_temp a WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id ='".$customer['id']."' AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != '' ".$division_default." ".$state_check." GROUP BY our_product_id"); echo mysql_error(); 
         //while($customer1=mysql_fetch_assoc($b)){
        $cnt = mysql_num_rows($b);		
        $yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);	
		//$yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getFill()->getStartColor()->setRGB('eceeef');

        $yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getFill()->applyFromArray(array(

        	'type' => PHPExcel_Style_Fill::FILL_SOLID,
        	'startcolor' => array(
        		'rgb' => 'eceeef'
        		)
        	));

        $styleArray = array(
        	'borders' => array(

        		'bottom' => array(
        			'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => PHPExcel_Style_Color::COLOR_WHITE	  
        				))
        		)
        	);

        $yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->applyFromArray($styleArray);
        unset($styleArray);


        $yuvaraj->getActiveSheet()->getStyle("A".($row+0).":A".($row+$cnt))->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->mergeCells("A".($row+0).":A".($row+$cnt)); # Row Merge Cell	

		while($customer1=mysql_fetch_assoc($b)){
		 //echo "SELECT * FROM distributor WHERE dis_id ='".$customer1['DID']."'"; 
			$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id ='".$customer1['DID']."'"); 
			$rd=mysql_fetch_assoc($sqld);	
			//$PTS = $PT["pts"]*$customer1["QTY"];$PTR = $PT["ptr"]*$customer1["QTY"];
			//foreach($customers1 as $key1=>$value1) {
			$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
			$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
				//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value1); # Product Details - Display
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer1["cust_name"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rd["dis_name"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer1["BATCH"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer1["QTY"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer1["FQTY"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer1["RQTY"]);				
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer1["ptr"]);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer1["pts"]);
			//}				
			$col =1;
			
			//$col =1;						
			$row++;				
			
		}
		$b1=mysql_query("SELECT SUM(a.quantity) AS YQTY, SUM(a.free_quantity) AS YFQTY, SUM(a.replace_quantity) AS YRQTY, SUM(a.quantity*a.pts) AS YPTS, SUM(a.quantity*a.ptr) AS YPTR FROM areawise_temp a,product WHERE (a.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND a.our_cust_id ='".$customer['id']."' AND a.pin_id=".$RS->pin_id." AND a.our_cust_id != '' AND a.our_product_id   != '' AND a.our_product_id=product.id ".$division_default." ".$state_check)or die(mysql_error());  $p1 = mysql_fetch_assoc($b1);
		$title3 = array(
			'font' => array(
				'bold' => true,   
				'color' => array(
					'rgb' => '0e7cd8'
					),
				), 	    
			);
		$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title3);
		$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
		$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$yuvaraj->getActiveSheet()->getStyle($row+0)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "SUB TOT");
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+3,$row, round($p1["YQTY"],2));
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+4,$row, round($p1["YFQTY"],2));
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+5,$row, round($p1["YRQTY"],2));	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+6,$row, round($p1["YPTR"],2));
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+7,$row, round($p1["YPTS"],2));
		$col++;	
		
		//}
		$row++;	
	} 
	$col =1;
	$title2 = array(
		'font' => array(
			'bold' => true,   
			'color' => array(
				'rgb' => 'FF0000'
				),
			), 	    
		);
	$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title2);
	$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
	$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$yuvaraj->getActiveSheet()->getStyle($row+0)->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "TOT AMT");	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+6,$row, round($p["PTR"],2));
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col+7,$row, round($p["PTS"],2));
	

//prepare download
	$filename="Doctor Wise Individual Report - ".date("F Y").".xls";
// $filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["cust_name"]." / [PTR Value: ".round($p["PTR"],2)." PTS Value: ".round($p["PTS"],2)." ] ".".xls"; //just some random filename
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