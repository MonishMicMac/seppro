<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3000000);
ini_set('max_execution_time', 1500000);
set_time_limit(0);
error_reporting(0);

// ob_end_clean();
// header("Connection: close\r\n");
// header("Content-Encoding: none\r\n");
// ignore_user_abort(true);
// ob_start();
// echo "Loading";
// $size = ob_get_length();
// header("Content-Length: $size");
// ob_end_flush();
// flush();
// ob_end_clean();

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

if(@$_REQUEST["hq"]=='All'){
	$sql_hq=mysql_query("SELECT group_concat(headquarters_id) as hq_id FROM mst_headquarters");
	$row_hq=mysql_fetch_array($sql_hq);
	$_REQUEST["hq"]=$row_hq['hq_id'];
}

if(@$_REQUEST["division_id"]==''){
	$sql_div1=mysql_query("SELECT group_concat(division_id) as division_id FROM mst_division");
	$row_div1=mysql_fetch_array($sql_div1);
	$_REQUEST["division_id"]=$row_div1['division_id'];
}

if(@$_REQUEST["state"]==''){
	$sql_state1=mysql_query("SELECT group_concat(state_id) as state_id FROM master_state");
	$row_state1=mysql_fetch_array($sql_state1);
	$_REQUEST["state"]=$row_state1['state_id'];
}


//load Excel template file
$objPHPExcel = PHPExcel_IOFactory::load("yuvaraj.xls");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "DIVISION");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "STATE");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "DISTRIBUTOR");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "HQ");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(13);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "PRODUCT");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(35);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "CHEMIST");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "Q");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(5);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "F");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(5);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "R");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(5);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, "PTS");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(9);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, "PTR");
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(9);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);
$styleArrayBColor = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => "a6a6a6")
		)
	);
$styleArrayFColor = array(
	'font'  => array(
		'color' => array('rgb' => 'ffffff')
		)
	);

$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];

$row=2;
$sql_div=mysql_query("SELECT division_id,(select division_name from mst_division where division_id=areawise_temp.division_id) as division_name FROM areawise_temp WHERE division_id IN (".$_REQUEST["division_id"].") and bill_date between '".date('Y/m/d',strtotime($from_date))."' and '".date('Y/m/d',strtotime($to_date))."' group by division_id");
while ($row_div=mysql_fetch_array($sql_div)) {
	$col=0;
	$prev_row=$row;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_div["division_name"]);
	$sql_st=mysql_query("SELECT state_id,(SELECT state_name FROM master_state WHERE state_id=areawise_temp.state_id) as state_name FROM areawise_temp WHERE state_id IN (".$_REQUEST["state"].") and division_id='".$row_div["division_id"]."' AND bill_date between '".date('Y/m/d',strtotime($from_date))."' and '".date('Y/m/d',strtotime($to_date))."' group by state_id");
	while ($row_st=mysql_fetch_array($sql_st)) {
		$prev_row1=$row;
		$col=1;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_st["state_name"]);
		$sql_dist=mysql_query("SELECT id,dis_name,state_id,headquarters_id,(select headquarters_name from mst_headquarters where headquarters_id=distributor.headquarters_id) as hq_name FROM distributor WHERE id IN (select dist_id from areawise_temp where division_id='".$row_div["division_id"]."' AND dist_id = '".$_REQUEST["dist_id"]."' and bill_date between '".date('Y/m/d',strtotime($from_date))."' and '".date('Y/m/d',strtotime($to_date))."' group by dist_id) and headquarters_id IN (".$_REQUEST["hq"].") and state_id='".$row_st["state_id"]."'");
		while ($row_dist=mysql_fetch_array($sql_dist)) {
			$prev_row2=$row;
			$col=2;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_dist["dis_name"]);
			$col=3;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_dist["hq_name"]);

			$sql_prod=mysql_query("SELECT our_product_id,(select pro_name from product where id=areawise_temp.our_product_id) as pro_name FROM areawise_temp WHERE division_id='".$row_div["division_id"]."' and state_id='".$row_st["state_id"]."' and dist_id='".$row_dist["id"]."' and bill_date between '".date('Y/m/d',strtotime($from_date))."' and '".date('Y/m/d',strtotime($to_date))."' group by our_product_id");
			$tot_qty=0;
			$tot_fqty=0;
			$tot_rqty=0;
			$tot_ptr=0;
			$tot_pts=0;
			while ($row_prod=mysql_fetch_array($sql_prod)) {
				$prev_row3=$row;
				$col=4;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_prod["pro_name"]);
				$sql_chem=mysql_query("SELECT our_cust_id,(select shop_name from tbl_customer_master where id=areawise_temp.our_cust_id) as cust_name,SUM(quantity) AS Q,SUM(free_quantity) AS F, SUM(replace_quantity) AS R,SUM(quantity*ptr) AS PTR, SUM(quantity*pts) AS PTS FROM areawise_temp WHERE division_id='".$row_div["division_id"]."' AND state_id='".$row_st["state_id"]."' AND dist_id='".$row_dist["id"]."' AND our_product_id='".$row_prod["our_product_id"]."' AND bill_date between '".date('Y/m/d',strtotime($from_date))."' AND '".date('Y/m/d',strtotime($to_date))."' GROUP BY our_cust_id");
				while ($row_chem=mysql_fetch_array($sql_chem)) {
					$col=5;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_chem["cust_name"]);
					$col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_chem["Q"]);
					$tot_qty+=$row_chem["Q"];
					$col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_chem["F"]);
					$tot_fqty+=$row_chem["F"];
					$col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_chem["R"]);
					$tot_rqty+=$row_chem["R"];
					$col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_chem["PTS"]);
					$tot_pts+=$row_chem["PTS"];
					$col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_chem["PTR"]);
					$tot_ptr+=$row_chem["PTR"];
					$row++;
				}
				$objPHPExcel->getActiveSheet()->mergeCells('E'.$prev_row3.':E'.($row-1));
			}
			$col=2;
			$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':F'.$row);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sub Total");
			$col=6;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot_qty);
			$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot_fqty);
			$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot_rqty);
			$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot_pts);
			$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot_ptr);

			$objPHPExcel->getActiveSheet()->getStyle('C'.$row.':K'.$row)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$row.':K'.$row)->applyFromArray($styleArrayBColor);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$row.':K'.$row)->applyFromArray($styleArrayFColor);
			$objPHPExcel->getActiveSheet()->mergeCells('C'.$prev_row2.':C'.($row-1));
			$objPHPExcel->getActiveSheet()->mergeCells('D'.$prev_row2.':D'.($row-1));
			$row++;
		}
		if($prev_row1<$row){
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$prev_row1.':B'.($row-1));
		}
	}
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$prev_row.':A'.($row-1));
}
$num=$row-1;
$objPHPExcel->getActiveSheet()->getStyle('A2:D'.$num)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$num)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:K'.$num)->applyFromArray($styleArray);

$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / Distributor : ".$rd->dis_name." / [PTR : ".round($customer11->TOTPTR,2)." PTS : ".round($customer11->TOTPTS,2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

// $filename="Distributor Covered-Uncovered Report - ".date("F Y").".xls";
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
// $objWriter->save(str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/'.$filename,__FILE__));
// $_SESSION['file_name_DCU']=$filename;
// $_SESSION['success_msg_DCU']="Success";
exit;

?>