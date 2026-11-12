<?php
include("include/connect.php");
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M'); 
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$sql=mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND rep_id=".$_REQUEST["rep_id"]." AND our_cust_id!='' AND our_product_id!=''")or die(mysql_error()); $row = mysql_fetch_object($sql);

$sql1 = mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST["rep_id"]."'");
$row1 = mysql_fetch_object($sql1);

$html="<table style=\"width:100%\">
        <tr>
          <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">
        </tr>
        <tr>
          <td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$row1->rep_name." / [PTR Value: ".round($row->PTR,2)."</span> <span class=\"btn btn-success\">PTS: Value: ".round($row->PTS,2)."]</tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\"> Representative Pincode wise Detailed Report</td>
        </tr>
      </table>";

$html.="<table style=\"width:100%\">
    <tr style=\"background-color: #dcdcdc;\">
      <th>PINCODE</th>
      <th style=\"text-align:left;\">CUSTOMER</th>
    </tr>";
$a=mysql_query("SELECT master_pincode.pin_id,master_pincode.pincode, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR FROM areawise_temp,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id=".$_REQUEST["rep_id"]." AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY master_pincode.pincode")or die(mysql_error());
while($customer=mysql_fetch_object($a)){ 
    
$html.="<tr>
      <td style=\"background-color: #dcdcdc;\">
        <strong style='font-size: 25px;'>".$customer->pincode."</strong><br><div style=\"margin-top:5px\" style=\"background-color: #43a1da;\">PTR : ".round($customer->PTR,2)."</div><br><div style=\"margin-top:5px\" style=\"background-color: #73a839;\">PTS : ".round($customer->PTS,2)."</div>

      </td>
        <td>
          <table>";
                
                $b=mysql_query("SELECT IFNULL((select doctor_name from doctors where id IN (select doctor_id from tbl_doctor_chemist where chemist_id=tbl_customer_master.id group by chemist_id)),'FLOATING') as doc_name, tbl_customer_master.id, tbl_customer_master.shop_name AS cust_name, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR  FROM areawise_temp,tbl_customer_master WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep_id"]."' AND areawise_temp.pin_id='".$customer->pin_id."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_cust_id ORDER BY areawise_temp.our_cust_id");
                while ($customer1=mysql_fetch_object($b)) {
                  $YQTY=0; $YFQTY=0; $YRQTY=0; $YPTR=0; $YPTS=0;
                

                $html.="<tr>
                  <td style=\"background:#FDEAE0;border-bottom:1px solid #333333;border-top:1px solid #333333;border-left:1px solid #333333;border-right:1px solid #333333;\">".rtrim($customer1->cust_name,",")."</td>
                  <td style=\"background:#FDEAE0;border-bottom:1px solid #333333;border-top:1px solid #333333;border-left:1px solid #333333;border-right:1px solid #333333;\">".rtrim($customer1->doc_name,",")."</td>
                  <td style=\"text-align:center;\">
                    <table style=\"border-collapse:collapse;border:1px solid #333333;width:100%\">
                    <tr>
                      <th style=\"background:#FFE4B5;text-align:center;border:1px solid #333333;\">Product</th>
                      <th style=\"background:#FFE4B5;text-align:center;border:1px solid #333333;\">Batch</th>
                      <th style=\"background:#FFE4B5;text-align:center;border:1px solid #333333;\">Quantity</th>
                      <th style=\"background:#FFE4B5;text-align:center;border:1px solid #333333;\">Free Quantity</th>
                      <th style=\"background:#FFE4B5;text-align:center;border:1px solid #333333;\">Replace Quantity</th>
                      <th style=\"background:#FFE4B5;text-align:center;border:1px solid #333333;\">PTR S.Value</th>
                      <th style=\"background:#FFE4B5;text-align:center;border:1px solid #333333;\">PTS S.Value</th>
                    </tr>";
                      
                      $c=mysql_query("SELECT product.pro_name, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.rep_id='".$_REQUEST["rep_id"]."' AND areawise_temp.pin_id='".$customer->pin_id."' AND areawise_temp.our_cust_id='".$customer1->id."' AND areawise_temp.our_cust_id!='' AND areawise_temp.our_product_id!='' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id ORDER BY areawise_temp.our_product_id");
                      while ($customer2=mysql_fetch_object($c)) {
                      
                      $html.="<tr>
                        <td style=\"text-align:left;border:1px solid #333333;\">".$customer2->pro_name."</td>
                        <td style=\"text-align:center;border:1px solid #333333;\">".$customer2->BATCH."</td>
                        <td style=\"text-align:center;border:1px solid #333333;\">".$customer2->QTY."</td>
                        <td style=\"text-align:center;border:1px solid #333333;\">".$customer2->FQTY."</td>
                        <td style=\"text-align:center;border:1px solid #333333;\">".$customer2->RQTY."</td>
                        <td style=\"text-align:right;border:1px solid #333333;\">".round($customer2->PTR,2)."</td>
                        <td style=\"text-align:right;border:1px solid #333333;\">".round($customer2->PTS,2)."</td>
                      </tr>";

                      $YQTY=$YQTY+$customer2->QTY;
                      $YFQTY=$YFQTY+$customer2->FQTY;
                      $YRQTY=$YRQTY+$customer2->RQTY;
                      $YPTR=$YPTR+$customer2->PTR;
                      $YPTS=$YPTS+$customer2->PTS;
                      }

                      $html.="<tr>
                        <td style=\"background:#BDFCC9;\" colspan=\"2\"><strong>Sub Total</strong></td>
                        <td style=\"background:#BDFCC9;text-align:center\" align=\"right\"><strong>".round($YQTY,2)."</strong></td>
                        <td style=\"background:#BDFCC9;text-align:center\" align=\"right\"><strong>".round($YFQTY,2)."</strong></td>
                        <td style=\"background:#BDFCC9;text-align:center\" align=\"right\"><strong>".round($YRQTY,2)."</strong></td>
                        <td style=\"background:#BDFCC9;text-align:right\" align=\"right\"><strong>".round($YPTR,2)."</strong></td>
                        <td style=\"background:#BDFCC9;text-align:right\" align=\"right\"><strong>".round($YPTS,2)."</strong></td>";
                      $html.="</tr>
                  </table>
                  </td>
                </tr>";
                }
            $html.="</table>
        </td>
    </tr>";
} 
$html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9,'Times'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>