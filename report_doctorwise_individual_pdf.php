<?php
include("include/connect.php");
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$DR = explode("-",$_REQUEST["doctor"]);
		$SQL = mysql_query("SELECT pin_id FROM master_pincode WHERE pincode='".$DR[0]."' ");
		$RS = mysql_fetch_object($SQL);
		$DOCTORID = mysql_query("SELECT chemist_id FROM doctors WHERE doctor_name='".$DR[1]."' AND doc_pin_id='".$RS->pin_id."'");
		$DRID = mysql_fetch_object($DOCTORID);
$b=mysql_query("SELECT SUM(areawise_temp.quantity*product.pts) AS PTS, SUM(areawise_temp.quantity*product.ptr) AS PTR FROM `areawise_temp`, product WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id IN (".$DRID->chemist_id.") AND our_cust_id   != '' AND our_product_id   != '' AND areawise_temp.our_product_id=product.id ")or die(mysql_error());  $p = mysql_fetch_object($b);
         $html="<table style=\"width:100%\"><tr><td colspan=\"2\" align=\"center\"  style=\"color:#000000; border:none;\">".@$_SESSION["CNAME"]."</tr><tr><td colspan=\"2\" align=\"center\"  style=\"color:#000000; border:none;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["pincode"]." / [PTR Value: ".round($p->PTR,2)."</span> <span class=\"btn btn-success\">PTS: Value: ".round($p->PTS,2)."]</tr><tr><td colspan=\"2\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">
		 Doctor Wise[Individual] Report</td></tr>";
		 		
				

	 $a=mysql_query("SELECT id, shop_name FROM tbl_customer_master WHERE id IN (".$DRID->chemist_id.")")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){ 
		//$PRICE = mysql_query("SELECT pts,ptr FROM product WHERE id = ".$customer->PID.""); $PT = mysql_fetch_object($PRICE);
$html.="<tr><td valign=\"top\" style=\"background:#ea3511;\">".$customer->shop_name."</td><td><table style=\" border-collapse:collapse;border:1px solid #333333;width:100%\"><tr><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Product Name</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Distributor</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Quantity</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Free Quantity</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Replace Quantity</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTR S.Value</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTS S.Value</th></tr>";
 $b=mysql_query("SELECT dist_id AS DID,product.pro_name AS cust_name, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(quantity*ptr) AS ptr, SUM(quantity*pts) AS pts  FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id ='".$customer->id."' AND areawise_temp.pin_id=".$RS->pin_id." AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id"); echo mysql_error(); while($customer1=mysql_fetch_object($b)){
 
 $html.=" <tr><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$customer1->cust_name."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">";
 $subtotal = 0;
 $sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$customer1->DID."");
  $rd=mysql_fetch_object($sqld);
   $html.="".$rd->dis_name."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->QTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->FQTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->RQTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"right\">".round($customer1->ptr,2)."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"right\">".round($customer1->pts,2)."</td></tr>";
}
 $b1=mysql_query("SELECT SUM(areawise_temp.quantity) AS YQTY, SUM(areawise_temp.free_quantity) AS YFQTY, SUM(areawise_temp.replace_quantity) AS YRQTY, SUM(areawise_temp.quantity*product.pts) AS YPTS, SUM(areawise_temp.quantity*product.ptr) AS YPTR FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id ='".$customer->id."' AND areawise_temp.pin_id=".$RS->pin_id." AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND areawise_temp.our_product_id=product.id "); $customer3=mysql_fetch_object($b1); 
$html.="<tr><td style=\"background:#BDFCC9;\" colspan=\"2\"><strong>Sub Total</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"center\"><strong>".round($customer3->YQTY,2)."</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"center\"><strong>".round($customer3->YRQTY,2)."</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"center\"><strong>".round($customer3->YRQTY,2)."</strong></td><td style=\"background:#BDFCC9;border-collapse:collapse;border:1px solid #333333;\" colspan=\"1\" align=\"right\"><strong>".round($customer3->YPTR,2)."</strong></td><td style=\"background:#BDFCC9;\" colspan=\"1\" align=\"right\"><strong>".round($customer3->YPTS,2)."</strong></td></tr>";

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