<?php
include("include/connect.php");
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$total=0;
$rep1 = explode("-",$_REQUEST["rep"]);	
$rep_sqls1=mysql_query("SELECT id,rep_name FROM representative WHERE id = '".$_REQUEST["rep"]."' ");
$r1=mysql_fetch_object($rep_sqls1);
$html="<table style=\"width:100%\"><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">".@$_SESSION["CNAME"]."</tr><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / ".strtoupper($r1->rep_name);
$a1=mysql_query("SELECT SUM(quantity*ptr) AS PTR, SUM(quantity*pts) AS PTS FROM areawise_temp WHERE rep_id = ".$r1->id." AND our_cust_id<>'' AND our_product_id<>'' AND (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')")or die(mysql_error());$customer11=mysql_fetch_object($a1);

$html.=" <br> [PTR Value: ".round($customer11->PTR,2)."</span> <span class=\"btn btn-success\">PTS: Value: ".round($customer11->PTS,2)."]";
$html.="</tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">Representative Wise[Individual] Report</td></tr>";
$rep = explode("-",$_REQUEST["rep"]);	
			$rep_sqls=mysql_query("SELECT id FROM representative WHERE id = '".$_REQUEST["rep"]."' ");
			$r=mysql_fetch_object($rep_sqls);
			$areatotal=0;
			
        $a=mysql_query("SELECT product.pro_name AS PNAME, areawise_temp.our_product_id AS PID, SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR, SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS FROM areawise_temp, product WHERE areawise_temp.rep_id = ".$r->id." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND product.id=areawise_temp.our_product_id GROUP BY areawise_temp.our_product_id ORDER BY product.pro_name")or die(mysql_error());
while($customer=mysql_fetch_object($a)){

// First Row - Start

$html.="<tr><td style=\"background:#FDEAE0;\">".$customer->PNAME."</td><td style=\"background:#FDEAE0;text-align:right\">PTR:".round($customer->PTR,2)." / PTS : ".round($customer->PTS,2)."</td></tr>"; // First Row - END

// Second Row - Start
$sql = mysql_query("SELECT areawise_temp.pin_id AS PIN, master_pincode.pincode AS pincode FROM areawise_temp,master_pincode WHERE areawise_temp.rep_id = ".$r->id." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$customer->PID."' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY areawise_temp.pin_id");
			while($baba=mysql_fetch_object($sql)){
				$TQ=""; $TF=""; $TR=""; $TPTR=""; $TPTS="";
$html.="<tr valign=\"top\"><td style=\"background:#ea3511;width:17%\" valign=\"top\">".$baba->pincode."</td><td><table style=\"width:100%;border-collapse:collapse;border:1px solid #333333;\"><tr><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Customer</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Batch</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Distributor</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">QTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">FQTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">RQTY</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTR S.Value</th><th style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">PTS S.Value</th></tr>";
$subtotal = 0; $sql_customer = "SELECT tbl_customer_master.shop_name AS CNAME, GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH, areawise_temp.our_cust_id AS CID, (SELECT dis_name FROM distributor WHERE dis_id=areawise_temp.dist_id) AS DID,  areawise_temp.pincode as PIN, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.replace_quantity) AS R, SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.quantity*areawise_temp.ptr) AS CPTR, SUM(areawise_temp.quantity*areawise_temp.pts) AS CPTS FROM areawise_temp,product,tbl_customer_master WHERE areawise_temp.rep_id = ".$r->id." AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_product_id='".$customer->PID."' AND areawise_temp.pin_id='".$baba->PIN."' AND product.id='".$customer->PID."' AND tbl_customer_master.id=areawise_temp.our_cust_id GROUP BY our_cust_id"; $rs_customer = mysql_query($sql_customer); while($y_customer=mysql_fetch_object($rs_customer)){

	$TQ+=$y_customer->Q; $TF+=$y_customer->F; $TR+=$y_customer->R; $TPTR+=round($y_customer->CPTR,2); $TPTS+=round($y_customer->CPTS,2);

$html.="<tr><td style=\"text-align:left;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->CNAME."</td>";

$html.="<td style=\"text-align:left;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->BATCH."</td><td style=\"text-align:left;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->DID."</td><td style=\"text-align:center;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->Q."</td><td style=\"text-align:center;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->F."</td><td style=\"text-align:center;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->R."</td><td style=\"text-align:right;border-right:1px solid #333333;border-bottom:1px solid #333333;\">".round($y_customer->CPTR,2)."</td><td style=\"text-align:right;border-top:1px solid #333333;\">".round($y_customer->CPTS,2)."</td></tr>";
}

$html.="<tr><td style=\"background:#BDFCC9;border-right:1px solid #333333;\" colspan=\"3\"><strong>Sub Total</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;text-align:center\" colspan=\"1\" align=\"center\"><strong>".$TQ."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;text-align:center\" align=\"center\"><strong>".$TF."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;text-align:center\" align=\"center\"><strong>".$TR."</strong></td><td style=\"background:#BDFCC9;border-right:1px solid #333333;text-align:right\" colspan=\"1\" align=\"right\"><strong>".$TPTR."</strong></td><td style=\"background:#BDFCC9;border-top:1px solid #333333;text-align:right\" colspan=\"1\" align=\"right\"><strong>".$TPTS."</strong></td></tr>";
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