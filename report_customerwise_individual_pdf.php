<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$customer = explode("-",$_REQUEST["cust_name"]);
         $html="<table><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Capital</tr><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;font-size:12px;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["cust_name"];
		 $customer2 = explode("-",@$_REQUEST["cust_name"]);			
        $b=mysql_query("SELECT SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND pincode=".@$customer2[0]." AND our_cust_id IN (SELECT DISTINCT(id) FROM tbl_customer_master WHERE shop_name = '".@$customer2[1]."' AND pincode=".@$customer2[0].") AND our_cust_id <> '' AND our_product_id <> ''")or die(mysql_error());  $p = mysql_fetch_object($b);  
		$html.=" <br> [PTR Value: ".round($p->PTR,2)."</span> <span class=\"btn btn-success\">PTS: Value: ".round($p->PTS,2)."]"; 
		
		 $html.="</td></tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">
		 Customer Wise[Individual] Report</td></tr>";
		
		$html.="<tr><td colspan=\"3\"><table>";
			$tot = '';				
        $a=mysql_query("SELECT DISTINCT(areawise_temp.our_product_id) AS PID, areawise_temp.our_cust_id AS CID, product.pro_name AS PNAME FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.pincode='".$customer[0]."' AND areawise_temp.our_cust_id IN (SELECT DISTINCT(id) FROM tbl_customer_master WHERE shop_name = '".@$customer2[1]."') AND areawise_temp.our_cust_id != '' AND areawise_temp.our_product_id != '' AND areawise_temp.our_product_id=product.id")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){ 
	$PRICE = mysql_query("SELECT pts,ptr FROM product WHERE id = ".$customer->PID.""); $PT = mysql_fetch_object($PRICE);
 $html.="<tr><td valign=\"top\" style=\"background:#ea3511;width:15%;\">".$customer->PNAME."</td><td><table  style=\" border-collapse:collapse;border:1px solid #333333;width:101%\"><tr><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Distributor</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Batch</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Doctor Type</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">QTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">FQTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">RQTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTR S.Value</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTS S.Value</th></tr>";
$customer1 = explode("-",$_REQUEST["cust_name"]); $b=mysql_query("SELECT dist_id AS DID, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH,SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(sale_value) AS SV, SUM(net_amount) AS NV,SUM(quantity*pts) AS PTS, SUM(quantity*ptr) AS PTR  FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode='".$customer1[0]."' AND our_cust_id= '".$customer->CID."' and our_cust_id   != '' AND our_product_id   != '' AND our_product_id ='".$customer->PID."' GROUP BY dist_id"); while($customer1=mysql_fetch_object($b)){
$html.="<tr><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">";
$subtotal = 0;$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$customer1->DID.""); 
$rd=mysql_fetch_object($sqld);
$html.="$rd->dis_name";
$html.="</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->BATCH."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Floating</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->QTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->FQTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer1->RQTY."</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"right\">";
$PTR = $customer1->PTR;
$SUBTOT = round($PTR,2);
$subtotal=round($customer1->PTS,2); $tot = $subtotal+$tot;
 @$total = $SUBTOT+$total;
$html.=round($PTR,2);
$html.="</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"right\">";  $html.=round($customer1->PTS,2);
$subtotal+=$customer1->NV; 
$html.="</td></tr>";
}
$b1=mysql_query("SELECT SUM(quantity) AS DQTY, SUM(free_quantity) AS DFQTY, SUM(replace_quantity) AS DRQTY, SUM(quantity*pts) AS YPTS, SUM(quantity*ptr) AS YPTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND pincode=".@$customer2[0]." AND our_product_id ='".$customer->PID."' AND our_cust_id <> '' AND our_product_id <> '' AND our_cust_id = '".$customer->CID."'")or die(mysql_error());  $p1 = mysql_fetch_assoc($b1); 

$html.="<tr><td style=\"background:#BDFCC9;border-right:1px solid #333333;\" colspan=\"3\"><strong>Sub Total</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;text-align:center\"><strong>".round($p1["DQTY"],2)."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;text-align:center\"><strong>".round($p1["DFQTY"],2)."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;text-align:center\"><strong>".round($p1["DRQTY"],2)."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;\" colspan=\"1\" align=\"right\"><strong>".round($p1["YPTR"],2)."</strong></td><td style=\"background:#BDFCC9;\" colspan=\"1\" align=\"right\"><strong>".round($p1["YPTS"],2)."</strong></td></tr>";
	$html.="</table></td></tr>";

   }
   $html.="</table></td></tr>";
$html.="</table>";
include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>