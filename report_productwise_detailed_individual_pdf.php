<?php
include("include/connect.php");
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 150000);

$baba = mysql_query("SELECT id FROM product WHERE pro_name='".$_REQUEST["product_name"]."'"); $SREEP = mysql_fetch_object($baba); 
$html="<table width=\"100%\"><tr><td colspan=\"3\" style=\"text-align:center\">".@$_SESSION["DIVISION"]."</td></tr>"; // ROOT - START
$baba = mysql_query("SELECT id FROM product WHERE pro_name='".$_REQUEST["product_name"]."'"); $SREEP = mysql_fetch_object($baba); 	
		$a1 = mysql_query("SELECT SUM(quantity*ptr) AS TOTPTR, SUM(quantity*pts) AS TOTPTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND our_product_id = '".$SREEP->id."' AND rep_id>0 GROUP BY our_product_id");
		$customer11=mysql_fetch_object($a1);
		$html.="<tr><td colspan=\"3\" style=\"text-align:center\">".$_REQUEST["product_name"]." - ".date("d/m/Y",strtotime(@$_REQUEST["from_date"]))." TO "." ".date("d/m/Y",strtotime(@$_REQUEST["to_date"]))." - [ PTR : ".round($customer11->TOTPTR,2)." / PTS : ".round($customer11->TOTPTS,2)." ]</td></tr>";
$html.="<tr><td colspan=\"3\" style=\"text-align:center;background:#ff9600;color:#FFFFFF;\">".strtoupper("Individidual Product wise Report")."</td></tr>";

	$a=mysql_query("SELECT rep_id, SUM(quantity*ptr) AS PTR,SUM(quantity*pts) AS PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND our_product_id = '".$SREEP->id."' AND rep_id>0 GROUP BY rep_id");				
		while($YUVARAJ=mysql_fetch_object($a)){ // FIRST ROW - START
			$SQL=mysql_query("SELECT rep_name FROM representative WHERE id=".$YUVARAJ->rep_id.""); $R=mysql_fetch_object($SQL);
			$html.="<tr style=\"border:1px solid #CCCCCC\"><td style=\"border:1px solid #CCCCCC;background:#5e5e5e;color:#FFFFFF;\"> <strong>".strtoupper($R->rep_name)."</strong></td><td style=\"border:1px solid #CCCCCC;background:#e1881e;color:#FFFFFF;text-align:right;\"> PTR ".round($YUVARAJ->PTR,2)." / PTS ".round($YUVARAJ->PTS,2)."</td></tr>";
			$PIN=mysql_query("SELECT master_pincode.pincode AS PINCODE,master_pincode.pin_id AS pin_id  FROM areawise_temp,master_pincode WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.pin_id=master_pincode.pin_id GROUP BY areawise_temp.rep_id, areawise_temp.pin_id");
			while($P=mysql_fetch_object($PIN)){ // SECOND ROW - START
				$html.="<tr><td valign=\"top\" style=\";border-collapse:collapse;border:1px solid #CCCCCC;background:#d0cfce;color:#000000;text-align:right;letter-spacing:0.08em;\"><strong>".$P->PINCODE."</strong></td>";
				$html.="<td><table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" style=\";border-collapse:collapse;border:1px solid #CCCCCC\"><tr><th style=\"background:#73A839; color:#FFFFFF\">CUSTOMER</th><th style=\"background:#73A839; color:#FFFFFF\">BATCH</th><th style=\"background:#73A839; color:#FFFFFF\">DISTRIBUTOR</th><th style=\"text-align:center;background:#73A839; color:#FFFFFF\">Q</th><th style=\"text-align:center;background:#73A839; color:#FFFFFF\">F</th><th style=\"text-align:center;background:#73A839; color:#FFFFFF\">R</th><th style=\"text-align:right;background:#73A839; color:#FFFFFF\">PTR</th><th style=\"text-align:right;background:#73A839; color:#FFFFFF\">PTS</th></tr>";
				$R=mysql_query("SELECT tbl_customer_master.shop_name AS cust_name,GROUP_CONCAT(DISTINCT(areawise_temp.batch_id)) as BATCH,distributor.dis_name AS DID, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.free_quantity) AS F, SUM(areawise_temp.replace_quantity) AS R,SUM(areawise_temp.quantity*areawise_temp.ptr) AS PTR,SUM(areawise_temp.quantity*areawise_temp.pts) AS PTS FROM areawise_temp,tbl_customer_master,distributor WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.rep_id=".$YUVARAJ->rep_id." AND areawise_temp.our_product_id = '".$SREEP->id."' AND areawise_temp.pin_id=".$P->pin_id." AND tbl_customer_master.id=areawise_temp.our_cust_id AND distributor.dis_id=areawise_temp.dist_id GROUP BY areawise_temp.our_cust_id");
                 while($R1=mysql_fetch_object($R)){
				 	$html.="<tr><td valign=\"top\" style=\"border:1px solid #CCCCCC;border-collapse:collapse;\">".strtoupper($R1->cust_name)."</td><td style=\"border:1px solid #CCCCCC;border-collapse:collapse;\" valign=\"top\">".$R1->BATCH."</td><td style=\"border:1px solid #CCCCCC;border-collapse:collapse;\" valign=\"top\">".$R1->DID."</td><td valign=\"top\" style=\"text-align:center; border:1px solid #CCCCCC;border-collapse:collapse;\">".$R1->Q."</td><td valign=\"top\" style=\"text-align:center; border:1px solid #CCCCCC;border-collapse:collapse;\">".$R1->F."</td><td style=\"text-align:center; border:1px solid #CCCCCC;border-collapse:collapse;\" valign=\"top\">".$R1->R."</td><td style=\"text-align:right; border:1px solid #CCCCCC;border-collapse:collapse;\" valign=\"top\">".round($R1->PTR,2)."</td><td style=\"text-align:right; border:1px solid #CCCCCC;border-collapse:collapse;\" valign=\"top\">".round($R1->PTS,2)."</td></tr>";
				 }
				  $D=mysql_query("SELECT SUM(quantity) AS Q, SUM(free_quantity) AS F, SUM(replace_quantity) AS R,SUM(quantity*ptr) AS PTR,SUM(quantity*pts) AS PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id <> '' AND our_product_id <> '' AND rep_id=".$YUVARAJ->rep_id." AND our_product_id = '".$SREEP->id."' AND pin_id=".$P->pin_id." GROUP BY our_product_id");
                   $D1=mysql_fetch_object($D);
				   $html.="<tr style=\"background:#00CCFF\"><td colspan=\"3\"  style=\"border:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF\">SUB TOTAL</td><td style=\"text-align:center;border:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF\">".$D1->Q."</td><td style=\"text-align:center;border:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF\">".$D1->F."</td><td style=\"text-align:center;border:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF\">".$D1->R."</td><td style=\"text-align:right;border:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF\">".round($D1->PTR,2)."</td><td style=\"text-align:right;border:1px solid #CCCCCC; background:#369BD7; color:#FFFFFF\">".round($D1->PTS,2)."</td></tr>";
				$html.="</table></td>";
				$html.="</tr>";
			} // SECOND ROW - END
		} // FIRST ROW - END

$html.="</table>"; // ROOT - END
include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>