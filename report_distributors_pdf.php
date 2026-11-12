<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$total=0;
$sqld = mysql_query("SELECT * FROM distributor WHERE dis_id ='".$_REQUEST["dist_id"]."'"); $rd=mysql_fetch_object($sqld);
$html="<table cellspacing=\"0\" cellpadding=\"5\" style=\"width:100%;border:1px solid #333333;\"><tr><td align=\"center\"  colspan=\"8\" style=\"color:#000000; border:none;\">".@$_SESSION["CNAME"]."</tr><tr><td align=\"center\"  colspan=\"8\" style=\"color:#000000;border:1px solid #333333;\">Period: ".date("d/m/Y",strtotime($_REQUEST["dist_sdate"]))." - ".date("d/m/Y",strtotime($_REQUEST["dist_edate"]))." / ".$_REQUEST["cur"];
$html.="</tr><tr><td  colspan=\"8\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF;\">DISTRIBUTOR COVERED REPORT</td></tr>";
$html.="<tr><th align=\"center\" style=\"border:1px solid #333333;text-align:center\">SL. NO</th><th align=\"left\" style=\"border:1px solid #333333;text-align:left\">DISTRIBUTOR</th><th align=\"left\" style=\"border:1px solid #333333;text-align:center\">PRODUCTS COVERED</th><th align=\"center\" style=\"border:1px solid #333333;text-align:center\">SQTY</th><th align=\"center\" style=\"border:1px solid #333333;text-align:center\">FQTY</th><th align=\"center\" style=\"border:1px solid #333333;text-align:center\">RQTY</th><th align=\"center\" style=\"border:1px solid #333333;text-align:center\">PTS</th><th align=\"center\" style=\"border:1px solid #333333;text-align:center\">PTR</th></tr>";
		$I=1;

        $SQL = mysql_query("SELECT dis_name, dis_id FROM distributor");
		while($RS=mysql_fetch_object($SQL)){
		$a=mysql_query("SELECT DISTINCT(areawise_temp.dist_id) AS DID,COUNT(DISTINCT(areawise_temp.our_product_id)) AS PROD, SUM(areawise_temp.quantity) AS Q,SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.replace_quantity) AS R,SUM(areawise_temp.quantity*product.pts) AS PTS, SUM(areawise_temp.quantity*product.ptr) AS PTR FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["dist_sdate"]."' AND '".@$_REQUEST["dist_edate"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.dist_id='".$RS->dis_id."'   AND areawise_temp.our_product_id=product.id GROUP BY '".$RS->dis_id."'");
        while($customer=mysql_fetch_object($a)){
		$TPTS+=round($customer->PTS,2); $TPTR+=round($customer->PTR,2);
// First Row - Start

$html.="<tr><td style=\"text-align:left;border:1px solid #333333;\">".$I."</td><td style=\"text-align:left;border:1px solid #333333;\">".$RS->dis_name."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->PROD."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->Q."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->F."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".$customer->R."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".round($customer->PTS,2)."</td><td style=\"background:#FDEAE0;text-align:center;border:1px solid #333333;\">".round($customer->PTR,2)."</td></tr>"; // First Row - END
$I++;
}
}
$J=1;
$html.="<tr><td colspan=\"6\" style=\"background:#99FFFF;\"><strong>TOTAL</strong></td><td  style=\"background:#99FFFF;text-align:center;\"><strong>".$TPTS."</strong></td><td style=\"background:#99FFFF;text-align:center;\"><strong>".$TPTR."</strong></td></tr>";
$html.="</table>";
$html.="<div>&nbsp;</div>";
$html.="<table cellspacing=\"0\" cellpadding=\"5\" style=\"width:100%;border:1px solid #333333;\"><tr><td align=\"center\" style=\"background:#ea3511; color:#FFFFFF;\"><strong>Distributor Uncovered</strong></td></tr></table>";
$html.="<table cellspacing=\"0\" cellpadding=\"5\" style=\"width:100%;border:1px solid #333333;\"><tr><th align=\"center\" style=\"border:1px solid #CCCCCC;text-align:center\">SL. NO</th><th align=\"left\" style=\"border:1px solid #CCCCCC;text-align:left\">DISTRIBUTOR</th><th align=\"left\" style=\"border:1px solid #CCCCCC;text-align:center\">PRODUCTS COVERED</th><th align=\"center\" style=\"border:1px solid #CCCCCC;text-align:center\">SQTY</th><th align=\"center\" style=\"border:1px solid #CCCCCC;text-align:center\">FQTY</th><th align=\"center\" style=\"border:1px solid #CCCCCC;text-align:center\">RQTY</th><th align=\"center\" style=\"border:1px solid #CCCCCC;text-align:center\">PTS</th><th align=\"center\" style=\"border:1px solid #CCCCCC;text-align:center\">PTR</th></tr>";
 $UC=mysql_query("SELECT dis_name FROM distributor WHERE dis_id NOT IN (SELECT `dist_id` FROM `areawise_temp` WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["dist_sdate"]."' AND '".@$_REQUEST["dist_edate"]."') GROUP BY `dist_id`)"); while($ucustomer=mysql_fetch_object($UC)){
 	$html.="<tr style=\"border:1px solid #CCCCCC; border-collapse:collapse\"><td style=\"border:1px solid #CCCCCC; text-align:center\">".$J."</td><td style=\"border:1px solid #CCCCCC;\">".$ucustomer->dis_name."</td><td style=\"border:1px solid #CCCCCC; text-align:center\">0</td><td style=\"border:1px solid #CCCCCC; text-align:center\">0</td><td style=\"border:1px solid #CCCCCC; text-align:center\">0</td><td style=\"border:1px solid #CCCCCC; text-align:center\">0</td><td style=\"border:1px solid #CCCCCC; text-align:center\">0</td><td style=\"border:1px solid #CCCCCC; text-align:center\">0</td></tr>";
 $J++;}
 $html.="</table>";
include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>