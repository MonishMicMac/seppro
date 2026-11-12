<?php
 
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");

// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 
// Initialise the Excel row number


function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
function fontColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
        'font' => array(
            'color' => array(
                'rgb' => $color
            )
        )
    ));
}


$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
cellColor('A1:H1','8c8c8c');
fontColor('A1:H1','FFFFFF');

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Pincode");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Chemist Name");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Representative");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Product Name");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Quantity");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "Free");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "Replace");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "PTR Value");



$rowCount = 2; 



$cust_mst = mysql_query("SELECT b.pincode as pincode, a.pin_id as pin_id FROM `areawise_temp` a left join pincode_list b on a.pin_id=b.pin_id WHERE (a.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and a.dist_id = '".$_REQUEST["stockist"]."' and a.pin_id !=0 and a.pin_id !='' GROUP BY a.pin_id");
while($cust_row = mysql_fetch_array($cust_mst)) :

    $pin_code = $cust_row['pincode'];
    $pin_id = $cust_row['pin_id'];
    $count_pin = 0;
    $count_shop = array();
    $shop_array = array();
    $rep_array = array();
    $product_array = array();
    $quantity_array = array();
    $free_array = array();
    $replace_array = array();
    $ptr_array = array();
    $did_array = array();
    $j = 0;
    
    $cust_mst1 = mysql_query("SELECT b.shop_name as shop_name, a.our_cust_id as cust_id, case when a.rep_id =0 then 'VACANT' else c.rep_name end as rep_name FROM `areawise_temp` a left join tbl_customer_master b on a.our_cust_id=b.id left join representative c on a.rep_id=c.id WHERE (a.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and a.dist_id = '".$_REQUEST["stockist"]."' and a.pin_id ='".$pin_id."' GROUP BY a.our_cust_id");
    if(mysql_num_rows($cust_mst1)>0) :
      while($cust_row1 = mysql_fetch_array($cust_mst1)) :
        $shop_array[] =$cust_row1['shop_name'];
        $rep_array[] =$cust_row1['rep_name'];

        
        $dist_cust2 = mysql_query("SELECT b.pro_name as product_name, sum(a.quantity) as quantity, sum(a.free_quantity) as free, sum(a.replace_quantity) as `replace`, a.ptr FROM `areawise_temp` a left join product b on a.our_product_id=b.id WHERE (a.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') and a.dist_id = '".$_REQUEST["stockist"]."' and a.pin_id ='".$pin_id."' and a.our_cust_id='".$cust_row1['cust_id']."' GROUP BY a.our_product_id");
        $count_shop[$j] = 0;
        if(mysql_num_rows($dist_cust2)>0) :
          while($distrow=mysql_fetch_array($dist_cust2)) :
            $product_array[$j][] = $distrow['product_name'];
            $quantity_array[$j][] = $distrow['quantity'];
            $free_array[$j][] = $distrow['free'];
            $replace_array[$j][] = $distrow['replace'];
            $ptr_array[$j][] = (double)$distrow['ptr']*(int)$distrow['quantity'];

            $count_pin++;
            $count_shop[$j]++;
          endwhile;
        else :
          $product_array[$j][] = '';
          $quantity_array[$j][] = '';
          $free_array[$j][] = '';
          $replace_array[$j][] = '';
          $ptr_array[$j][] = '';

          $count_pin++;
          $count_shop[$j]++;
        endif;
        $j++;
      endwhile;
    else :
      $shop_array[] ='';
      $rep_array[] ='';
      $product_array[$j][] = '';
      $quantity_array[$j][] = '';
      $free_array[$j][] = '';
      $replace_array[$j][] = '';
      $ptr_array[$j][] = '';

      $count_pin++;
      $count_shop[$j]++;
      $j++;

    endif;

    $objPHPExcel->getActiveSheet()->mergeCells("A".$rowCount.":A".(($rowCount+(($count_pin=='0')?1:$count_pin))-1));
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $pin_code); 
    $objPHPExcel->getActiveSheet()->getStyle("A".$rowCount.":A".(($rowCount+(($count_pin=='0')?1:$count_pin))-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

    for ($i=0; $i < count($shop_array); $i++) :
      

	    $objPHPExcel->getActiveSheet()->mergeCells("B".$rowCount.":B".(($rowCount+(($count_shop[$i]=='0')?1:$count_shop[$i]))-1));
	    $objPHPExcel->getActiveSheet()->mergeCells("C".$rowCount.":C".(($rowCount+(($count_shop[$i]=='0')?1:$count_shop[$i]))-1));
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $shop_array[$i]); 
	    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $rep_array[$i]);
      $objPHPExcel->getActiveSheet()->getStyle("B".$rowCount.":B".(($rowCount+(($count_shop[$i]=='0')?1:$count_shop[$i]))-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
      $objPHPExcel->getActiveSheet()->getStyle("C".$rowCount.":C".(($rowCount+(($count_shop[$i]=='0')?1:$count_shop[$i]))-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

      if($rep_array[$i] == "VACANT") :
        cellColor("B".$rowCount.":B".(($rowCount+(($count_shop[$i]=='0')?1:$count_shop[$i]))-1),"ffa4a4");
        cellColor("C".$rowCount.":C".(($rowCount+(($count_shop[$i]=='0')?1:$count_shop[$i]))-1),"ffa4a4");
      endif;

      for ($o=0; $o < $count_shop[$i]; $o++) :
          $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $product_array[$i][$o]);
          $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $quantity_array[$i][$o]);
          $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $free_array[$i][$o]);
          $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $replace_array[$i][$o]);
          $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $ptr_array[$i][$o]);

          if($rep_array[$i] == "VACANT") :
            cellColor('D'.$rowCount,"ffa4a4");
            cellColor('E'.$rowCount,"ffa4a4");
            cellColor('F'.$rowCount,"ffa4a4");
            cellColor('G'.$rowCount,"ffa4a4");
            cellColor('H'.$rowCount,"ffa4a4");
          endif;

          $rowCount++;
      endfor;
    endfor;
endwhile;

$borderStyleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A1:H'.$rowCount-1)->applyFromArray($borderStyleArray);



$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 


$filename = "Stockist Report - ".$_REQUEST["stockist"]."(".$_REQUEST["from_date"]." to ".$_REQUEST["to_date"].").xls";

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$filename.'"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

 
?>