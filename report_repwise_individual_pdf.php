<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$total=0;
$TQ=""; $TF=""; $TR=""; $TPTR=""; $TPTS="";
$rep1 = explode("-",$_REQUEST["rep"]);	
$rep_sqls1=mysql_query("SELECT id FROM representative WHERE id = '".$_REQUEST["rep"]."' ");
$r1=mysql_fetch_object($rep_sqls1);
$html="<table style=\"width:100%\"><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Capital</tr><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".$_REQUEST["rep"];
$a1=mysql_query("SELECT SUM(quantity*ptr) AS PTR, SUM(quantity*pts) AS PTS FROM areawise_temp WHERE rep_id = ".$r1->id." AND our_cust_id<>'' AND our_product_id<>'' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')")or die(mysql_error());$customer11=mysql_fetch_object($a1);
$html.=" / PTR : ".round($customer11->PTR,2)." PTS : ".round($customer11->PTS,2)."</td>";

$html.="</tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">Representative Wise[Individual] Report</td></tr>";
$rep = explode("-",$_REQUEST["rep"]);	
$m_id16=$_REQUEST["m_id16"];
			$rep_sqls=mysql_query("SELECT id FROM representative WHERE id = '".$_REQUEST["rep"]."' ");
			$r=mysql_fetch_object($rep_sqls);
			$areatotal=0; $PINTOT = 0;
        $a=mysql_query("SELECT master_pincode.pincode AS PINCODE, areawise_temp.pin_id AS PIN, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR,SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS FROM areawise_temp,master_pincode WHERE rep_id=".$r->id." AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id<>'' AND our_product_id<>'' AND master_pincode.pin_id=areawise_temp.pin_id GROUP BY areawise_temp.pin_id ")or die(mysql_error());
while($customer=mysql_fetch_object($a)){
// First Row - Start

$html.="<tr><td style=\"background:#FDEAE0;\">".$customer->PINCODE."</td><td style=\"background:#FDEAE0;text-align:right\">PTR Value: ".round($customer->PTR,2)."  PTS Value: ".round($customer->PTS,2);

$html.="</td></tr>"; // First Row - END

// Second Row - Start
$sql = mysql_query("SELECT product.pro_name AS PRODNAME, product.id AS PID FROM areawise_temp,product WHERE rep_id=".$r->id." AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id<>'' AND our_product_id<>'' AND areawise_temp.our_product_id=product.id AND areawise_temp.pin_id='".$customer->PIN."'  GROUP BY areawise_temp.our_product_id");
			while($baba=mysql_fetch_object($sql)){
			$SUBTOT = 0; $SUBPTS = 0;
$html.="<tr><td style=\"background:#ea3511;width:17%\" valign=\"top\">".$baba->PRODNAME."</td><td><table style=\"width:100%;border-collapse:collapse;border:1px solid #333333;\"><tr><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Customer</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Batch</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Distributor</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">QTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">FQTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">RQTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTR S.Value</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTS S.Value</th></tr>";
$subtotal = 0; $sql_customer = "SELECT tbl_customer_master.shop_name AS CNAME, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, areawise_temp.our_cust_id AS CID, (SELECT dis_name FROM distributor WHERE dis_id=areawise_temp.dist_id) AS DID,  areawise_temp.pincode as PIN, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.replace_quantity) AS R, SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.quantity*areawise_temp.ptr) AS CPTR, SUM(areawise_temp.quantity*areawise_temp.pts) AS CPTS FROM areawise_temp,product,tbl_customer_master WHERE areawise_temp.rep_id = ".$r->id." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$baba->PID."' AND areawise_temp.pin_id='".$customer->PIN."' AND product.id='".$baba->PID."' AND tbl_customer_master.id=areawise_temp.our_cust_id GROUP BY our_cust_id"; $rs_customer = mysql_query($sql_customer); while($y_customer=mysql_fetch_object($rs_customer)){
$html.="<tr><td style=\"text-align:left;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->CNAME."</td>";

$TQ+=$y_customer->Q; $TF+=$y_customer->F; $TR+=$y_customer->R; $TPTR+=round($y_customer->CPTR,2); $TPTS+=round($y_customer->CPTS,2);

$html.="<td style=\"text-align:left;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->BATCH."</td><td style=\"text-align:left;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->DID."</td><td style=\"text-align:center;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->Q."</td><td style=\"text-align:center;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->F."</td><td style=\"text-align:center;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->R."</td><td style=\"text-align:right;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".round($y_customer->CPTR,2)."</td><td style=\"text-align:right;border-top:1px solid #333333;\">".round($y_customer->CPTS,2)."</td></tr>";
}
$html.="<tr><td style=\"background:#BDFCC9;border-right:1px solid #333333;border-bottom:1px solid #333333;\" colspan=\"3\"><strong>Sub Total</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;border-bottom:1px solid #333333;text-align:center\" align=\"center\"><strong>".$TQ."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;border-bottom:1px solid #333333;text-align:center\" align=\"center\"><strong>".$TF."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;border-bottom:1px solid #333333;text-align:center\" align=\"center\"><strong>".$TR."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;border-bottom:1px solid #333333;text-align:right\" align=\"right\"><strong>".$TPTR."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;border-bottom:1px solid #333333;border-top:1px solid #333333;text-align:right\" align=\"right\"><strong>".$TPTS."</strong></td></tr>";
$html.="</table></td></tr>";
}
// Second Row - End
}
$html.="</table>";
include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>