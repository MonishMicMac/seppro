<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$total=0;
$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id ='".$_REQUEST["dist_id"]."'"); $rd=mysql_fetch_object($sqld);
$html="<table style=\"width:100%;border:1px solid #333333;\"><tr><td colspan=\"9\" align=\"center\"  style=\"color:#000000; border:none;\">Capital</tr><tr><td colspan=\"9\" align=\"center\"  style=\"color:#000000;border:1px solid #333333;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$rd->dis_name;
$a1=mysql_query("SELECT SUM(quantity) AS SQTY, SUM(free_quantity) AS SFQTY, SUM(replace_quantity) AS SRQTY, SUM(quantity*pts) AS TOTPTS, SUM(quantity*ptr) AS TOTPTR FROM areawise_temp WHERE (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."'")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$html.=" <br> [PTR Value: ".round($customer11->TOTPTR,2)."</span> <span class=\"btn btn-success\">PTS Value: ".round($customer11->TOTPTS,2)."]";
$html.="</tr><tr><td colspan=\"9\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">Representative Wise[Individual] Report</td></tr>";

$html.="<tr><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Product Name</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Batch</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of Pincodes Covered</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of Customers Covered</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">QTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">FQTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">RQTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">PTS</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">PTR</th></tr>";

        $DISTRIBUTOR=mysql_query("SELECT our_id FROM dist_prod WHERE dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_id");
		while($pid=mysql_fetch_object($DISTRIBUTOR)){
		
		
		$a=mysql_query("SELECT COUNT(DISTINCT(areawise_temp.pincode)) AS PIN, COUNT(DISTINCT(areawise_temp.our_cust_id)) AS CUST, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH,product.pro_name AS PRODUCT, (SELECT sum(areawise_temp.quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS QTY, (SELECT sum(areawise_temp.free_quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS FQTY,(SELECT sum(areawise_temp.replace_quantity) FROM `areawise_temp` WHERE our_product_id='".$pid->our_id."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' GROUP BY `our_product_id`) AS RQTY, (SELECT sum(quantity*ptr) FROM areawise_temp WHERE our_product_id='".$pid->our_id."' AND (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_product_id) AS PTR, (SELECT sum(quantity*pts) FROM areawise_temp WHERE our_product_id='".$pid->our_id."' AND (bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND dist_id = '".$_REQUEST["dist_id"]."' GROUP BY our_product_id) AS PTS  FROM product,dist_prod,areawise_temp WHERE dist_prod.dist_id='".$_REQUEST["dist_id"]."' AND dist_prod.our_id=product.id AND product.id=areawise_temp.our_product_id AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id = '".$_REQUEST["dist_id"]."' AND dist_prod.our_id='".$pid->our_id."' GROUP BY dist_prod.our_id,areawise_temp.our_product_id");
while($customer=mysql_fetch_object($a)){

// First Row - Start

$html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$customer->PRODUCT."</td><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$customer->BATCH."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->PIN."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->CUST."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->QTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->FQTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->RQTY."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer->PTR,2)."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer->PTS,2)."</td></tr>"; // First Row - END

}
}
$html.="<tr><td colspan=\"4\"><strong>Total</strong></td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SQTY."</td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SFQTY."</td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SRQTY."</td><td align=\"right\" style=\"text-align:right;border:1px solid #333333;\">".round($customer11->TOTPTR,2)."</td><td style=\"text-align:right;border:1px solid #333333;\">".round($customer11->TOTPTS,2)."</td></tr>";
$html.="</table>";
include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>