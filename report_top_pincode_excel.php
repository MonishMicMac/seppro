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

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:I1','9d9b9b');
mytemplate_design_fcolor('A1:I1','FFFFFF');


				/*	if(@$_REQUEST["division_id"]!=""){
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
                    }*/

$total=0;
$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id ='".$_REQUEST["dist_id"]."'"); $rd=mysql_fetch_object($sqld);
$a1=mysql_query("SELECT SUM(a.quantity) AS SQTY, SUM(a.free_quantity) AS SFQTY, SUM(a.replace_quantity) AS SRQTY, SUM(a.quantity*a.pts) AS TOTPTS, SUM(a.quantity*a.ptr) AS TOTPTR FROM areawise_temp a WHERE (a.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND a.dist_id = '".$_REQUEST["dist_id"]."' ".$division_default." ".$state_check)or die(mysql_error());
$customer11=mysql_fetch_object($a1);

$yuvaraj->getActiveSheet()->mergeCells('A2:I2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))."");
//$yuvaraj->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(8);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:I2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:I3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Top Pincode Report");
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "Pincode");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "PTR");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "PTS");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "Sales Product Qty");
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:I4','eceeef');	

$row = 5;	

 if(@$_REQUEST["division_id"]!=""){
                            $division_default = "and areawise_temp.division_id='".@$_REQUEST['division_id']."' ";
                        } else {
                         
                            $division_default = "";
                        }
                        if(@$_REQUEST["state_id"]!=""){
                            $state_default = "and areawise_temp.state_id='".@$_REQUEST['state_id']."' ";
                        } else{
                            $state_default="";
                        }
 

                        $sqltp=mysql_query("SELECT areawise_temp.pincode AS PIN, round(SUM(areawise_temp.quantity*areawise_temp.ptr)) AS TOTPTR, round(SUM(areawise_temp.quantity*areawise_temp.pts)) AS TOTPTS,COUNT(DISTINCT(areawise_temp.our_cust_id)) as cust_qty FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.pincode ORDER BY TOTPTR DESC LIMIT 10");

        while($y_customer=mysql_fetch_assoc($sqltp)){		
		$col=0;
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["PIN"]);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["TOTPTR"]);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["TOTPTS"]);						
					$col++;						
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["cust_qty"]);						
					$col++;						
				
						
			
						$row++;
				}
				// }
			# BABA - END
			/*$col=1;
			$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
				$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
					$title1 = array(
				'font' => array(
					'bold' => true,   
					'color' => array(
						'rgb' => 'FF0000'
					),
				), 	    
				);
				$yuvaraj->getActiveSheet()->getStyle($row)->applyFromArray($title1);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Total: ");	
			$col+=3;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SFQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->SRQTY);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->TOTPTS);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer11->TOTPTR);	
			$col=1;	*/			
			//}
			//$row++;
			
		//}

	
		
//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." Top Pincode List".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>