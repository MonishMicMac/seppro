<?php
include("include/connect.php");
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$SQL = mysql_query("SELECT pin_id FROM master_pincode WHERE pincode='".$_REQUEST["pincode"]."' ");
$RS = mysql_fetch_object($SQL);
$b=mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != ''")or die(mysql_error());  $p = mysql_fetch_object($b);
         $html="<table style=\"width:100%\"><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">".$_SESSION["DIVISION"]."</tr><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["pincode"]." / [PTR Value: ".round($p->PTR,2)."</span> <span class=\"btn btn-success\">PTS: Value: ".round($p->PTS,2)."]</tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">
		 Pincode Wise[Individual] Report</td></tr>";
		 		
				

	 $a=mysql_query("SELECT DISTINCT(areawise_temp.our_product_id) AS PID, product.pro_name AS PNAME FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.pin_id=".$RS->pin_id." AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != ''  AND areawise_temp.our_product_id=product.id ")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){ 
$html.="<tr><td valign=\"top\" style=\"background:#ea3511;\">".$customer->PNAME."</td><td><table style=\" border-collapse:collapse;border:1px solid #333333;width:100%\"><tr><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Customer Name</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Distributor</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Batch</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Doctor</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Quantity</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Free Quantity</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Replace Quantity</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTR S.Value</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTS S.Value</th></tr>";
 $b=mysql_query("SELECT dist_id AS DID,tbl_customer_master.shop_name AS cust_name, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, tbl_customer_master.doctor_id AS DRID, SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR  FROM areawise_temp, tbl_customer_master WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$customer->PID."' AND areawise_temp.pin_id=".$RS->pin_id." AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.cust_name,areawise_temp.pin_id ORDER BY areawise_temp.dist_id"); echo mysql_error(); while($customer1=mysql_fetch_object($b)){
$DOCTOR=mysql_query("SELECT doctor_name as DRNAME FROM doctors WHERE id IN ('".$customer1->DRID."')"); $IDDR=mysql_fetch_object($DOCTOR);
if($customer1->DRID!=""){ $DTYPE = $IDDR->DRNAME;} else{ $DTYPE = "Floating";}
 
 $html.=" <tr><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$customer1->cust_name."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">";
 $subtotal = 0;
 $sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$customer1->DID."");
  $rd=mysql_fetch_object($sqld);
   $html.="".$rd->dis_name."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$customer1->BATCH."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$DTYPE."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->QTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->FQTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->RQTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"right\">";
   $html.=round($customer1->PTR,2);
   $html.="</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"right\">";
   $html.=round($customer1->PTS,2);   
   $html.="</td></tr>";
}
 $b1=mysql_query("SELECT SUM(quantity) AS YQTY, SUM(free_quantity) AS YFQTY, SUM(replace_quantity) AS YRQTY, SUM(quantity*pts) AS YPTS, SUM(quantity*ptr) AS YPTR FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_product_id='".$customer->PID."' AND pin_id=".$RS->pin_id." AND our_cust_id != '' AND our_product_id != ''"); $customer3=mysql_fetch_object($b1); 
$html.="<tr><td style=\"background:#BDFCC9;\" colspan=\"4\"><strong>Sub Total</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"center\"><strong>".round($customer3->YQTY,2)."</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"center\"><strong>".round($customer3->YRQTY,2)."</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"center\"><strong>".round($customer3->YRQTY,2)."</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"right\"><strong>".round($customer3->YPTR,2)."</strong></td><td style=\"background:#BDFCC9;\" colspan=\"1\" align=\"right\"><strong>".round($customer3->YPTS,2)."</strong></td></tr>";

$html.="</table></td></tr>";
}


$html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9,'Times'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>