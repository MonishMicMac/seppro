<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$html = "<table style=\"width:100%\"><tr><td colspan=\"2\" align=\"center\"  style=\"color:#000000; border:none;\">".@$_SESSION["CNAME"]."</tr><tr><td colspan=\"2\" align=\"center\"  style=\"color:#000000; border:none;\"></tr><tr><td colspan=\"2\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">Representative Wise Report</td></tr><tr><td colspan=\"2\" align=\"center\"  style=\"color:#333333; border:none;\">Period : ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." To ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." [Total:";
$total=0;
$a1=mysql_query("SELECT SUM(areawise_temp.net_amount) AS REPTOT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.Pincode IN (SELECT pincode_list.pincode FROM pincode_list WHERE pincode_list.pin_id IN (SELECT rep_area.pin_id FROM rep_area) GROUP BY pincode_list.pincode)")or die(mysql_error());while($customer11=mysql_fetch_object($a1)){ $total+=$customer11->REPTOT;}
$html.=round($total,2);
$html.="]</td></tr>";
//$html="<table >";
		$areatotal=0;
		$repname = mysql_query("SELECT rep_name, id FROM representative");while($rn=mysql_fetch_object($repname)){	
		$html.="<tr><td style=\"background:#333333; color:#FFFFFF;\">Representative Name: <strong>".$rn->rep_name."</strong></td><td align=\"right\" style=\"background:#333333; color:#FFFFFF\">Rep Total:<strong>";
		$rtotal = 0;$reptotal = mysql_query("SELECT SUM(areawise_temp.net_amount) AS NETAMOUNT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.Pincode IN (SELECT pincode_list.pincode FROM pincode_list WHERE pincode_list.pin_id IN (SELECT rep_area.pin_id FROM rep_area WHERE rep_area.rep_id = ".$rn->id." ) GROUP BY pincode_list.pincode) GROUP BY areawise_temp.pincode"); while($reptot = mysql_fetch_object($reptotal)){ $rtotal+= $reptot->NETAMOUNT; }
		$html.="".round($rtotal,2)."</strong></td></tr>";
		 $a=mysql_query("SELECT areawise_temp.pincode, areawise_temp.pro_name, areawise_temp.net_amount FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.Pincode IN (SELECT pincode_list.pincode FROM pincode_list WHERE pincode_list.pin_id IN (SELECT rep_area.pin_id FROM rep_area WHERE rep_area.rep_id = ".$rn->id." ) GROUP BY pincode_list.pincode) GROUP BY areawise_temp.pincode")or die(mysql_error());
        while($customer=mysql_fetch_object($a)){
		$html.="<tr><td style=\"background:#FDEAE0;\">".$customer->pincode."</td><td  align=\"right\" style=\"background:#FDEAE0;\">Total:";
		$sqlnet=mysql_query("SELECT SUM(net_amount) AS NETAMT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND pincode=".$customer->pincode.""); while($yuvaraj=mysql_fetch_object($sqlnet)){
		 $html.=round($yuvaraj->NETAMT,2);
		 }
		 
		 //$html.="<tr><td colspan=\"2\"><table>";
		 $sql = mysql_query("SELECT pro_name FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND pincode = ".$customer->pincode." GROUP BY pro_name");
			while($baba=mysql_fetch_object($sql)){
		 $html.="<tr><td  style=\"background:#ea3511;width:15%\">".$baba->pro_name."</td><td><table  style=\" border-collapse:collapse;border:1px solid #333333;width:100%\"><tr style=\"\"><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Customer</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">Distributor</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">QTY</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">FQTY</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">RQTY</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;border-bottom:1px solid #333333;\">SV</td><td style=\"background:#FFE4B5;border-bottom:1px solid #333333;\">Net Amt</td></tr>";
		 $subtotal = 0; $sql_customer = "SELECT cust_name,dist_id, SUM(quantity) AS quantity, SUM(free_quantity) AS free_quantity, SUM(replace_quantity) AS replace_quantity, SUM(sale_value) AS sale_value, SUM(net_amount) AS net_amount FROM areawise_temp WHERE pro_name = '".$baba->pro_name."' AND (areawise_temp.bill_date BETWEEN '".@$_REQUEST["from_date"]."' AND '".@$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND pincode = ".$customer->pincode." GROUP BY cust_name, dist_id ORDER BY dist_id"; $rs_customer = mysql_query($sql_customer); while($y_customer=mysql_fetch_object($rs_customer)){
		 $html.="<tr><td style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$y_customer->cust_name."</td><td style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">";
		 $sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$y_customer->dist_id.""); $rd=mysql_fetch_object($sqld);
		 $html.=$rd->dis_name."</td><td  style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$y_customer->quantity."</td><td  style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$y_customer->free_quantity."</td><td  style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$y_customer->replace_quantity."</td><td  style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"right\">".$y_customer->sale_value."</td><td  style=\"border-bottom:1px solid #333333;\" align=\"right\">".round($y_customer->net_amount,2)."</td></tr>";
		 $subtotal+=$y_customer->net_amount;
		 }
		 $html.="<tr><td style=\"background:#BDFCC9;\" colspan=\"6\"><strong>Sub Total</strong></td><td style=\"background:#BDFCC9;\" align=\"right\" colspan=\"1\"><strong>".round($subtotal,2)."</strong></td></tr></table></td></tr>";
		 }
		 $html.="</tr>";
		 }
		 //$html.="</table></td></tr>";
		}
$html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>