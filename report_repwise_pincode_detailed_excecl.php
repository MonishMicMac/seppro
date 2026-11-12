<?php
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1'); 
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:N1');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, @$_SESSION["CNAME"]);
$yuvaraj->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_bg('A1:N1','9d9b9b');
mytemplate_design_fcolor('A1:N1','FFFFFF');
$SQL = mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST["rep_id"]."'");
$RS = mysql_fetch_object($SQL);
$b = mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND rep_id=".$_REQUEST["rep_id"]." AND our_cust_id!='' AND our_product_id!=''")or die(mysql_error());
$row_data = mysql_fetch_assoc($b);

$yuvaraj->getActiveSheet()->mergeCells('A2:N2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$RS->rep_name." / [PTR : ".round($row_data["PTR"],2)." PTS : ".round($row_data["PTS"],2)." ] ");

$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:N2','0e7cd8');

$yuvaraj->getActiveSheet()->mergeCells('A3:3');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Representative wise Offer Tracking");
$yuvaraj->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "PINCODE");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "CUSTOMER NAME");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "DOCTOR NAME");
$yuvaraj->getActiveSheet()->getStyle('A4:A4')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "PRODUCT NAME");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(35);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 4, "BATCH");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 4, "QTY");
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(50);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 4, "Q Split");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 4, "FQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 4, "RQTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 4, "PTR");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 4, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(11, 4, "BQ");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, 4, "BQF");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(12, 4, "EXCESS");
$yuvaraj->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A4:N4')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$yuvaraj->getActiveSheet()->freezePane('A5');   
mytemplate_design_bg('A4:N4','eceeef'); 

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ); 

$row = 5;
$row1 = 5;
$row_num0 = 0;

$a=mysql_query("SELECT master_pincode.pin_id,(select area_name from pincode_list where pin_id=areawise_temp.pin_id group by pin_id) as area_name,master_pincode.pincode, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR FROM areawise_temp,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id=".$_REQUEST["rep_id"]." AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY master_pincode.pincode")or die(mysql_error());
while($customer=mysql_fetch_assoc($a)){
    $col=0;
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(45);
    $yuvaraj->getActiveSheet()->getStyle('A'.$row.':A'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer["pincode"]."-".$customer["area_name"]." PTR : [".round($customer["PTR"],2)."] PTS : [".round($customer["PTS"],2)."]");
    $row++;
    $col++;

    $b=mysql_query("SELECT IFNULL((select doctor_name from doctors where id IN (select doctor_id from tbl_doctor_chemist where chemist_id=tbl_customer_master.id group by chemist_id)),'FLOATING') as doc_name, tbl_customer_master.id, tbl_customer_master.shop_name AS cust_name FROM areawise_temp,tbl_customer_master WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep_id"]."' AND areawise_temp.pin_id='".$customer['pin_id']."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_cust_id ORDER BY areawise_temp.our_cust_id");
    $num=mysql_num_rows($b);
    $prev_row=$row-1;

    while ($customer1=mysql_fetch_assoc($b)) {
        $YQTY=0; $YFQTY=0; $YRQTY=0; $YPTR=0; $YPTS=0; $texp=0;  $tqty=0;  $tfree=0;
        $col=1;
        $row=$row-1;
        $prev_row1=$row;

        mytemplate_design_bg('B'.$row.':B'.$row,'FDEAE0');
        $yuvaraj->getActiveSheet()->getStyle('B'.$row.':B'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, rtrim($customer1["cust_name"],","));
        $col++;
        $yuvaraj->getActiveSheet()->getStyle('B'.$row.':B'.$row)->getAlignment()->setWrapText(true); 


        mytemplate_design_bg('C'.$row.':C'.$row,'FDEAE0');
        $yuvaraj->getActiveSheet()->getStyle('C'.$row.':C'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, rtrim($customer1["doc_name"],","));
        $col++;
        $yuvaraj->getActiveSheet()->getStyle('C'.$row.':C'.$row)->getAlignment()->setWrapText(true); 

        $c=mysql_query("SELECT product.pro_name, product.id, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep_id"]."' AND areawise_temp.pin_id='".$customer['pin_id']."' AND areawise_temp.our_cust_id='".$customer1['id']."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id ORDER BY areawise_temp.our_product_id");
        $num1=mysql_num_rows($c);
        $row_num1=$row+$num1;
        $pre_row_num1=$row;
        
        $chy_total=0;
        while ($customer2=mysql_fetch_object($c)) {
            $col=3;
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer2->pro_name);
            $col++;
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer2->BATCH);
            $col++;
            $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer2->QTY);
            $col++;

            $cy=mysql_query("SELECT CONCAT( '(', SUM( quantity ) , ') ', distributor.dis_name ) dname  FROM areawise_temp,product,distributor WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep_id"]."' AND areawise_temp.pin_id='".$customer['pin_id']."' AND areawise_temp.our_cust_id='".$customer1['id']."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_product_id='".$customer2->id."' AND areawise_temp.our_product_id=product.id and distributor.dis_id=areawise_temp.dist_id  GROUP BY dist_id ORDER BY areawise_temp.our_product_id");
            $cy_cnt=mysql_num_rows($cy);
            $hi=0;
            if($cy_cnt>1){
                $merge_row=$row+$cy_cnt-1;
                $yuvaraj->getActiveSheet()->mergeCells('D'.$row.':D'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('E'.$row.':E'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('F'.$row.':F'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('H'.$row.':H'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('I'.$row.':I'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('J'.$row.':J'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('K'.$row.':K'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('L'.$row.':L'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('M'.$row.':M'.$merge_row);
                $yuvaraj->getActiveSheet()->mergeCells('N'.$row.':N'.$merge_row);

                $yuvaraj->getActiveSheet()->getStyle('D'.$row.':D'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('E'.$row.':E'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('F'.$row.':F'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('H'.$row.':H'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('I'.$row.':I'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('J'.$row.':J'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('K'.$row.':K'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('L'.$row.':L'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('M'.$row.':M'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $yuvaraj->getActiveSheet()->getStyle('N'.$row.':N'.$merge_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

                $chy_total=$chy_total+$cy_cnt-1;
            }

            while($CHY=mysql_fetch_object($cy)){
                $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $CHY->dname);
            
                if($hi==0){
                $col++;
                $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer2->FQTY);
                $col++;
                $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $customer2->RQTY);
                $col++;
                $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($customer2->PTR,2));
                $col++;
                $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($customer2->PTS,2));
                $col++;
                    // $offerdate=date("Y/m/d",strtotime($F->S1)).'-';
                                        // echo "SELECT off_qty,off_free  FROM product_offer_tracking WHERE off_date like '%".$offerdate."%' off_doc_id='".$customer1->id."'  AND off_pdt_id='".$customer2->id."' AND off_rep_id='".$_REQUEST["rep"]."' ";
                                        $cyoffer=mysql_query("SELECT off_qty,off_free  FROM product_offer_tracking WHERE (off_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND off_doc_id='".$customer1->id."'  AND off_pdt_id='".$customer2->id."' AND off_rep_id='".$_REQUEST["rep"]."' AND off_id=(select max(off_id) from product_offer_tracking WHERE off_pdt_id='".$customer2->id."') ");
                                        $count_cyoffer=mysql_num_rows($cyoffer);
                                          if($count_cyoffer==0) {
                                // echo "SELECT gen_qty,gen_free  FROM product_offer_gemeral WHERE (gen_date BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')   AND gen_pdt_id='".$customer2->id."' AND gen_id=(select max(gen_id) from product_offer_gemeral WHERE gen_pdt_id='".$customer2->id."' ) ";
                                            $cyoffergen=mysql_query("SELECT gen_qty,gen_free  FROM product_offer_gemeral WHERE (gen_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')   AND gen_pdt_id='".$customer2->id."' AND gen_id=(select max(gen_id) from product_offer_gemeral WHERE gen_pdt_id='".$customer2->id."') ");
                                            $count_cyoffergen=mysql_num_rows($cyoffergen);
                                            if($count_cyoffergen==0) {
                                                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0");
                $col++;
                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0");
                $col++;
                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0");
                $col++;
                $tqty=$tqty+0;
                $tfree=$tfree+0;
                $texp=$texp+0;
                                            
                                            }
                                            else
                                            {
                                                $CHY_cyoffergen=mysql_fetch_object($cyoffergen);
                                                    $bqty=$CHY_cyoffergen->gen_qty; $bfree=$CHY_cyoffergen->gen_free;
                                                    $cqty=$customer2->QTY; $cfree=$customer2->FQTY;
                                                    $bdiv=$cfree-($bfree*($cqty/$bqty));
                                                    // echo $cqty/$bqty.',';
                                                    //  echo $bfree.',';
                                                    //   echo $cfree.',';
                                                 $bdiv;
                                                                
                                                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CHY_cyoffergen->gen_qty);
                $col++;
                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CHY_cyoffergen->gen_free);
                $col++;
                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $bdiv);
                $col++;
                $tqty=$tqty+$CHY_cyoffergen->gen_qty;
                $tfree=$tfree+$CHY_cyoffergen->gen_free;
                $texp=$texp+$texp+$bdiv;
                                         
                                          }
                                      }
                                          else
                                          {
                                              $CHY_cyoffer=mysql_fetch_object($count_cyoffer);
                                                     $bqty=$CHY_cyoffer->off_qty; $bfree=$CHY_cyoffer->off_free;
                                                    $cqty=$customer2->QTY; $cfree=$customer2->FQTY;
                                                    $bdiv=$cfree-($bfree*($cqty/$bqty));
                                                    // echo $cqty/$bqty.',';
                                                    //  echo $bfree.',';
                                                    //   echo $cfree.',';
                                                 $bdiv;
                                                                  
                                                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CHY_cyoffer->off_qty);
                $col++;
                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CHY_cyoffer->off_free);
                $col++;
                  $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $bdiv);
                $col++;
                $tqty=$tqty+$CHY_cyoffer->off_qty;
                $tfree=$tfree+$CHY_cyoffer->off_free;
                $texp=$texp+$texp+$bdiv;
                                          }  

                if($cy_cnt==1){ $row++; }
                }
                if($cy_cnt>1){ $row++; }
                $hi++;
            }
            $YQTY=$YQTY+$customer2->QTY;
            $YFQTY=$YFQTY+$customer2->FQTY;
            $YRQTY=$YRQTY+$customer2->RQTY;
            $YPTR=$YPTR+$customer2->PTR;
            $YPTS=$YPTS+$customer2->PTS;
        }

        if($chy_total!=0){
            $final_val=$row_num1+$chy_total;
            $yuvaraj->getActiveSheet()->mergeCells('B'.$pre_row_num1.':B'.$final_val);
            $yuvaraj->getActiveSheet()->mergeCells('C'.$pre_row_num1.':C'.$final_val);
        } else {
            $yuvaraj->getActiveSheet()->mergeCells('B'.$pre_row_num1.':B'.$row_num1);
            $yuvaraj->getActiveSheet()->mergeCells('C'.$pre_row_num1.':C'.$row_num1);
        }

        $col=3;
        mytemplate_design_fcolor('D'.$row.':N'.$row,'0e7cd8');
        $yuvaraj->getActiveSheet()->mergeCells('D'.$row.':E'.$row);
        $yuvaraj->getActiveSheet()->getStyle('D'.$row.':E'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Sub Total");
        $col=$col+2;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $YQTY);
        $col=$col+2;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $YFQTY);
        $col++;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $YRQTY);
        $col++; 
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $YPTR);
        $col++; 
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $YPTS);
        $col++; 
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $tqty);
        $col++; 
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $tfree);
        $col++; 
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $texp);
        $row=$row+2;

        $row_sub=$row-2;
        $yuvaraj->getActiveSheet()->getStyle('B'.$prev_row1.':N'.$row_sub)->applyFromArray($styleArray);
        $yuvaraj->getActiveSheet()->getStyle('B'.$prev_row1.':B'.$row_sub)->getFont()->setBold(true);
    }
    $row_num=$row-2;

    $yuvaraj->getActiveSheet()->mergeCells('A'.$prev_row.':A'.$row_num);
    $yuvaraj->getActiveSheet()->getStyle('A'.$prev_row.':A'.$row_num)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('A'.$prev_row.':A'.$row_num)->getFont()->setSize(12);
    $yuvaraj->getActiveSheet()->getStyle('A'.$prev_row.':A'.$row_num)->getFont()->setBold(true);
}


//prepare download
$filename="Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." TO ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$RS->rep_name." / [PTR : ".round($row_data["PTR"],2)." PTS : ".round($row_data["PTS"],2)." ] ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>