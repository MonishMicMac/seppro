<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 150000);
//load Excel template file
//Worked Nirmal
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:E1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "BRINTON.date - ".date('Y-m-d'));
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:E1','9d9b9b');
mytemplate_design_fcolor('A1:E1','FFFFFF');

$total=0;

$yuvaraj->getActiveSheet()->mergeCells('A2:E2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(10);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:E2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:E3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "REPORTS");
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "RANK");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "REPRESENTATIVE NAME");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "STATE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "NO OF COVERED PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "COVERED PRODUCT");
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 5, "PRODUCT NAME QUANTITY PINCODE");
/*$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 5, "PRODUCT NAME");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 5, "QUANTITY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 5, "PINCODE");*/

$yuvaraj->getActiveSheet()->getStyle('A4:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:E3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');	
mytemplate_design_bg('A4:E3','eceeef');	

$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);


$row = 5;	
$num=4;

    if(@$_REQUEST['state_id']==''){

                        if(@$_REQUEST["division_id"]!=""){
                            $division_default = "and b.division_id='".@$_REQUEST['division_id']."' ";
                        } else {
                         
                            $division_default = "";
                        }
                        if(@$_REQUEST["state_id"]!=""){
                            $state_default = "and a.state_id='".@$_REQUEST['state_id']."' ";
                        } else{
                            $state_default="";
                        }



		$i=1;
		
		$a=mysql_query("SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(a.`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC");
		
        while($y_customer=mysql_fetch_assoc($a)){
	
		    $state=mysql_query("SELECT * from master_state where state_id='".$y_customer['state_id']."'"); 
            $row_state=mysql_fetch_assoc($state);
			
		        $col=0;
		        //$row_1 = 1;	
				
				
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
					$col++;
		
		            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$y_customer["repname"]);						
					$col++;	
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$row_state["state_name"]);						
					$col++;	
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$y_customer["PROD"]);						
					$col++;
		

		      $pro=mysql_query("SELECT (SELECT `pro_name` FROM `product` WHERE id=our_product_id) as proname,COUNT(DISTINCT(quantity)) as pro_qty,COUNT(DISTINCT(pin_id)) as pro_pinid FROM areawise_temp WHERE rep_id='".$y_customer['rep_id']."' AND `our_product_id`!='' AND (bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') GROUP BY `our_product_id`");
			  
			       
				   $num_rows=mysql_num_rows($pro);
				   
				   $yuvaraj->getActiveSheet()->mergeCells('A'.$row.':A'.($row+$num_rows-1));
				   $yuvaraj->getActiveSheet()->mergeCells('B'.$row.':B'.($row+$num_rows-1));
				   $yuvaraj->getActiveSheet()->mergeCells('C'.$row.':C'.($row+$num_rows-1));
				   $yuvaraj->getActiveSheet()->mergeCells('D'.$row.':D'.($row+$num_rows-1));
				 
				   $yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);
				   
				   while ($pro_details=mysql_fetch_assoc($pro)) {
					
			   /*$col=4;
		       $row_1 = 1;	*/
			   
	 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$pro_details["proname"]."  ".$pro_details["pro_qty"]."  ".$pro_details["pro_pinid"]);						
					//$col++;
		            $row++;
					}
			
		    $i++;
					
              } 
			  
			  }
			  
			  
			  
			  
	if(@$_REQUEST['state_id']!=''){

			if(@$_REQUEST["division_id"]!=""){
			$division_default = "and b.division_id='".$_REQUEST['division_id']."' ";
		} else {
		  
				$division_default = "";
		}
		if(@$_REQUEST["state_id"]!=""){
			$state_default = "and a.state_id='".$_REQUEST['state_id']."' ";
		} else{
			$state_default="";
		}


			   

		$i=1;
		
		$a=mysql_query("SELECT a.rep_id,b.rep_name as repname, a.state_id, COUNT(DISTINCT(a.`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` a,`representative` b WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (a.bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') ".$state_default." ".$division_default." and a.rep_id!=0  AND a.rep_id=b.id GROUP BY a.rep_id ORDER BY PTS DESC");
		
        while($y_customer=mysql_fetch_assoc($a)){
	
		    $state=mysql_query("SELECT * from master_state where state_id='".$y_customer['state_id']."'"); 
            $row_state=mysql_fetch_assoc($state);
			
				$col=0;
				
					$yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
					$col++;
		
		            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$y_customer["repname"]);						
					$col++;	
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$row_state["state_name"]);						
					$col++;	
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$y_customer["PROD"]);						
					$col++;
		           
		
		
		      $pro=mysql_query("SELECT (SELECT `pro_name` FROM `product` WHERE id=our_product_id) as proname,COUNT(DISTINCT(quantity)) as pro_qty,COUNT(DISTINCT(pin_id)) as pro_pinid FROM areawise_temp WHERE rep_id='".$y_customer['rep_id']."' AND `our_product_id`!='' AND (bill_date BETWEEN '".$_REQUEST['from_date']."' AND '".$_REQUEST['to_date']."') GROUP BY `our_product_id`");
			  
			       
				   $num_rows=mysql_num_rows($pro);
                   $num=$num+$num_rows;
				   
				   
				   $yuvaraj->getActiveSheet()->mergeCells('A'.$row.':A'.($row+$num_rows-1));
				   $yuvaraj->getActiveSheet()->mergeCells('B'.$row.':B'.($row+$num_rows-1));
				   $yuvaraj->getActiveSheet()->mergeCells('C'.$row.':C'.($row+$num_rows-1));
				   $yuvaraj->getActiveSheet()->mergeCells('D'.$row.':D'.($row+$num_rows-1));
				   
				   $yuvaraj->getActiveSheet()->getStyle('A1:A'.$num)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('B1:B'.$num)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('C1:C'.$num)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('D1:D'.$num)->applyFromArray($styleArray);
				   $yuvaraj->getActiveSheet()->getStyle('E1:E'.$num)->applyFromArray($styleArray);
				   
				   while ($pro_details=mysql_fetch_assoc($pro)) {
					
			   /* $col=4;
		       $row_1 = 1;*/
			   
	 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$pro_details["proname"]."  ".$pro_details["pro_qty"]."  ".$pro_details["pro_pinid"]);		
	 
		            $row++;
					}
			
		    $i++;
					
              } 
			  
			  } 

$yuvaraj->setActiveSheetIndex(0);
	
		
//prepare download
$filename="Period: ".date("d-m-Y",strtotime($_REQUEST["from_date"]))." TO ".date("d-m-Y",strtotime($_REQUEST["to_date"])).".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>