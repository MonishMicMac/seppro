<?php
include("include/connect.php");
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);

$baba = mysql_query("SELECT id FROM product WHERE pro_name='".$_REQUEST["product_name"]."'"); $SREEP = mysql_fetch_object($baba); 
$html="<table style=\"width:100%;border:1px solid #333333;\"><tr><td colspan=\"8\" align=\"center\"  style=\"color:#000000; border:none;\">INEX</tr><tr><td colspan=\"8\" align=\"center\"  style=\"color:#000000;border:1px solid #333333;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["product_name"];
$a1=mysql_query("SELECT SUM(areawise_temp.quantity) AS SQTY, SUM(areawise_temp.free_quantity) AS SFQTY, SUM(areawise_temp.replace_quantity) AS SRQTY,SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id GROUP BY areawise_temp.our_product_id")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$html.=" <br> [PTR Value: ".round($customer11->TOTPTR,2)."</span> <span class=\"btn btn-success\">PTS Value: ".round($customer11->TOTPTS,2)."]";
$html.="</tr><tr><td colspan=\"8\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">Product Wise[Individual] Report</td></tr>";

$html.="<tr><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">Rep Name</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of Pincodes Covered</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">No of Customers Covered</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">QTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">FQTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">RQTY</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">PTR</th><th align=\"center\" style=\"text-align:center;border:1px solid #333333;\">PTS</th></tr>";

        $a=mysql_query("SELECT  count(DISTINCT(areawise_temp.pin_id)) AS PIN,count(DISTINCT(areawise_temp.our_cust_id)) AS CUST, areawise_temp.rep_id AS RNAME,  areawise_temp.rep_id AS RID, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY,SUM(areawise_temp.quantity*product.ptr) AS YPTR, SUM(areawise_temp.quantity*product.pts) AS YPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id AND areawise_temp.rep_id>0 GROUP BY areawise_temp.our_product_id, areawise_temp.rep_id")or die(mysql_error());
while($customer=mysql_fetch_object($a)){
// First Row - Start
$SQL = mysql_query("SELECT rep_name FROM representative WHERE id='".$customer->RNAME."'");
$RS = mysql_fetch_object($SQL);
$html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">".$RS->rep_name."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->PIN."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->CUST."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->QTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->FQTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->RQTY."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer->YPTR,2)."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer->YPTS,2)."</td></tr>"; // First Row - END

}
$a1=mysql_query("SELECT  count(DISTINCT(areawise_temp.pin_id)) AS PIN,count(DISTINCT(areawise_temp.our_cust_id)) AS CUST, areawise_temp.rep_id AS RNAME,  areawise_temp.rep_id AS RID, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY,SUM(areawise_temp.quantity*product.ptr) AS YPTR, SUM(areawise_temp.quantity*product.pts) AS YPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.`our_cust_id` <> '' AND areawise_temp.`our_product_id` <> '' AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.our_product_id = product.id AND areawise_temp.rep_id=0 GROUP BY areawise_temp.our_product_id, areawise_temp.rep_id")or die(mysql_error());
$customer1=mysql_fetch_object($a1);
$html.="<tr><td style=\"background:#FDEAE0;border:1px solid #333333;\">Vacant / Unassigned </td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer1->PIN."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer1->CUST."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer1->QTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer1->FQTY."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer1->RQTY."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer1->YPTR,2)."</td><td style=\"background:#FDEAE0;text-align:right;border:1px solid #333333;\">".round($customer1->YPTS,2)."</td></tr>";

$html.="<tr><td colspan=\"3\"><strong>Total</strong></td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SQTY."</td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SFQTY."</td><td style=\"text-align:center;border:1px solid #333333;\" align=\"center\">".$customer11->SRQTY."</td><td align=\"right\" style=\"text-align:right;border:1px solid #333333;\">".round($customer11->TOTPTR,2)."</td><td style=\"text-align:right;border:1px solid #333333;\">".round($customer11->TOTPTS,2)."</td></tr>";
$html.="</table>";
include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>