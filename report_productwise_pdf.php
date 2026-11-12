<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$html = "<table style=\"width:100%;\"><tr><td colspan=\"2\" align=\"center\"  style=\"color:#000000; border:none;\">".@$_SESSION["CNAME"]."</tr><tr><td colspan=\"2\" align=\"center\"  style=\"color:#000000; border:none;\">Thiru Nagar, II Street, Vadapalani, Chennai - 600026</tr><tr><td colspan=\"2\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">Product Wise (Rep-wise) Report</td></tr>";
$ptotal = 0;	
		$a1=mysql_query("SELECT  SUM(net_amount) AS NPTOT FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM `rep_area`) GROUP BY pincode) AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pro_name  ORDER BY pro_name, pincode"); while($p = mysql_fetch_object($a1)){  $ptotal+=$p->NPTOT;}
$html.="<tr><td>Period : ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." To ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." </td><td align=\"right\">"." Total : ".$ptotal."</td></tr>";		
		$a=mysql_query("SELECT  pro_name AS PRODUCT, SUM(net_amount) AS NAMT, pincode AS PINCODE FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM `rep_area`) GROUP BY pincode) AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pro_name  ORDER BY pro_name, pincode");
		while($product=mysql_fetch_object($a)){ 
        $html.="<tr style=\"background:#ea3511; color:#FFFFFF; border:none;\"><td style=\"background:#ea3511; color:#FFFFFF;border:none;\">".$product->PRODUCT."</td><td style=\"background:#ea3511; color:#FFFFFF;border:none;float:right;\"  align=\"right\">Product Net Total:".round($product->NAMT,2)."</td></tr>";  
		 $repwise = mysql_query("SELECT representative.rep_name AS rep, pincode_list.pincode AS pincodes FROM representative, rep_area, pincode_list, areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND representative.id = rep_area.rep_id AND pincode_list.pin_id = rep_area.pin_id AND areawise_temp.pincode = pincode_list.pincode AND areawise_temp.pro_name = '".$product->PRODUCT."' GROUP BY pincode_list.pincode"); while($repwise_rs = mysql_fetch_object($repwise)){  
		 $html.="
		 <tr><td colspan=\"2\">
		 <table style=\"width:100%;\">
		 <tr style=\"background:#3D3C3A; color:#FFFFFF;\">
		 <td style=\"background:#3D3C3A; color:#FFFFFF;\"><strong>Rep Name: $repwise_rs->rep</strong> </td>
		 <td style=\"background:#3D3C3A; color:#FFFFFF;float:right;\"><strong>Rep Total :";
		 $reptotal = mysql_query("SELECT SUM(net_amount) AS RTOT FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pro_name = '".$product->PRODUCT."' AND pincode = ".$repwise_rs->pincodes." AND `our_cust_id` <> '' AND `our_product_id` <> ''"); while($reptotal_rs=mysql_fetch_object($reptotal)){
		 	$html.=" ".round($reptotal_rs->RTOT,2);
		 }
		 $html.="</td></table></td></tr>";
		 $html.="<tr style=\"background:#DEB887;\"><td colspan=\"2\" style=\"background:#DEB887;\"><strong>".$repwise_rs->pincodes."</strong></td></tr>";
		 $html.="<tr><td colspan=\"2\"><table style=\"width:100%;border:1px solid #999999;padding:5px;border-collapse: collapse;\"><tr><th style=\"background:#fbd8d1;border-right:1px solid #999999;\">Customer Name</th><th style=\"background:#fbd8d1;border-right:1px solid #999999;\">Distributor</th><th style=\"background:#fbd8d1;border-right:1px solid #999999;\">Doctor Type</th><th style=\"background:#fbd8d1;border-right:1px solid #999999;\">Quantity</th><th style=\"background:#fbd8d1;border-right:1px solid #999999;\">Free Quantity</th><th style=\"background:#fbd8d1;border-right:1px solid #999999;\">Replace Quantity</th><th style=\"background:#fbd8d1;border-right:1px solid #999999;\">Sale Value</th><th style=\"background:#fbd8d1\">Net Amount</th></tr>";
		 $sql1 = "SELECT cust_name,dist_id,SUM(quantity) AS Q,SUM(free_quantity) AS F,SUM(replace_quantity) AS R,SUM(sale_value) AS S,SUM(net_amount) AS N  FROM `areawise_temp` WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `pro_name` = '".$product->PRODUCT."' AND pincode = ".$repwise_rs->pincodes." AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY cust_name, dist_id ORDER BY dist_id"; $rs1 = mysql_query($sql1); while($res1 = mysql_fetch_object($rs1)){		 
		  $html.="<tr><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\">".$res1->cust_name."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\">";
		  $sqld = mysql_query("SELECT * FROM distributor WHERE dis_id =".$res1->dist_id.""); $rd=mysql_fetch_object($sqld);
		  $html.="".$rd->dis_name."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\">Floating</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"center\">".$res1->Q."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"center\">".$res1->F."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"center\">".$res1->R."</td><td align=\"right\" style=\"border-top:1px solid #999999;border-right:1px solid #999999;\">".round($res1->S,2)."</td><td style=\"border-top:1px solid #999999;\"  align=\"right\">".round($res1->N,2)."</td></tr>";
		  }
		  $html.="</table></td></tr>";
		  $html.="<tr><td colspan=\"2\"><table width=\"100%\"><tr style=\"background:#DEB887;\"><td style=\"background:#DEB887;\">".$repwise_rs->pincodes."- Subtotal</td><td style=\"background:#DEB887;float:right;\"  align=\"right\">";
		  $rtot=0; $sql2 = "SELECT SUM(net_amount) AS Y  FROM `areawise_temp` WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND `pro_name` = '".$product->PRODUCT."' AND pincode = ".$repwise_rs->pincodes." AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pincode"; $rs2 = mysql_query($sql2); while($res3 = mysql_fetch_object($rs2)){ $rtot+= $res3->Y;
		  $html.="".round($rtot,2);
		  }
		  $html.="</table></td></tr>";
	 }}
	 //$html.="<div>Report Summary</div>";
	 $html.="<table style=\"border:1px solid #999999;border-collapse: collapse;\"><tr><td colspan=\"6\" align=\"center\"><strong>Report Summary</strong></td></tr>";
	 $html.="<tr style=\"background:#ea3511; color:#FFFFFF; border:none;\"><td  style=\"background:#ea3511;color:#FFFFFF;border-right:1px solid #999999;\">Product Name</td><td  style=\"background:#ea3511;color:#FFFFFF;border-right:1px solid #999999;\">Sale QTY</td><td  style=\"background:#ea3511;color:#FFFFFF;border-right:1px solid #999999;\">Free</td><td  style=\"background:#ea3511;color:#FFFFFF;border-right:1px solid #999999;\">Replace</td><td  style=\"background:#ea3511;color:#FFFFFF;border-right:1px solid #999999;\">Sale Value</td><td style=\"background:#ea3511; color:#FFFFFF;border:none;\">Net Amount</td></tr>";
	 $aa=mysql_query("SELECT  pro_name AS PRODUCTa, SUM(net_amount) AS NAMTa, pincode AS PINCODEa, SUM(quantity) AS Q, SUM(free_quantity) AS F, SUM(replace_quantity) AS R, SUM(sale_value) AS S, SUM(net_amount) AS N FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM `rep_area`) GROUP BY pincode) AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pro_name  ORDER BY pro_name, pincode");
		while($producta=mysql_fetch_object($aa)){ 
       $html.="<tr><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\">".$producta->PRODUCTa."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"center\">".$producta->Q."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"center\">".$producta->F."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"center\">".$producta->R."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"right\">".round($producta->S,2)."</td><td style=\"border-top:1px solid #999999;border-right:1px solid #999999;\" align=\"right\">".round($producta->N,2)."</td></tr>";  
		
		}
		$ptotal1 = 0; $SV1 = 0; $aa1=mysql_query("SELECT  SUM(sale_value) AS SV, SUM(net_amount) AS NPTOT1 FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM `rep_area`) GROUP BY pincode) AND `our_cust_id` <> '' AND `our_product_id` <> '' GROUP BY pro_name  ORDER BY pro_name, pincode"); while($p1 = mysql_fetch_object($aa1)){  $SV1+=$p1->SV; $ptotal1+=$p1->NPTOT1;}
		$html.="<tr><td colspan=\"4\" style=\"background:#ea3511;border-top:1px solid #999999;border-right:1px solid #999999;color:#FFFFFF;\" align=\"left\">Total</td><td style=\"background:#ea3511;border-top:1px solid #999999;color:#FFFFFF;border-right:1px solid #999999;\" align=\"right\">".$SV1."</td><td  style=\"background:#ea3511;color:#FFFFFF;border-top:1px solid #999999;\" align=\"right\">".$ptotal1."</td></tr></table>";
$html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',12,'Times'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>