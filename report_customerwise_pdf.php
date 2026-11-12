<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '40M');
ini_set('post_max_size', '40M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
$html = "<table style=\"width:100%\"><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">".@$_SESSION["CNAME"]."</tr><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\"></td></tr><tr><td colspan=\"3\" align=\"center\"  style=\"background:#ea3511; color:#FFFFFF; border:none;\">Customer Wise Report</td></tr><tr><td colspan=\"3\" align=\"center\"  style=\"color:#000000; border:none;\">Period: ".date("d/m/Y",strtotime($_REQUEST["from_date"]))." - ".date("d/m/Y",strtotime($_REQUEST["to_date"]))." / [Total: ";

$cyp = mysql_query("SELECT SUM(net_amount) AS NTAMOUNT FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != ''" ); $YP = mysql_fetch_object($cyp);

$html.=round($YP->NTAMOUNT,2)."]</tr>";
			
			$a=mysql_query("SELECT areawise_temp.pincode, areawise_temp.net_amount,areawise_temp.bill_date, pincode_list.pincode, pincode_list.area_name, areawise_temp.our_cust_id, master_district.district_id,  master_district.district_name, pincode_list.dist_id FROM areawise_temp,pincode_list,master_district WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.pincode=pincode_list.pincode AND master_district.district_id= pincode_list.dist_id AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' GROUP BY areawise_temp.pincode  ORDER BY areawise_temp.id ");
        while($customer=mysql_fetch_object($a)){			
			// First ROW - Start		
				
			$html.="<tr page-break-before=\"always\" style=\"background:#333333;\"><td style=\"background:#333333; color:#FFFFFF;\"><strong>".$customer->pincode."</strong></td><td style=\"background:#333333; color:#FFFFFF;\">".$customer->area_name." | ".$customer->district_name."</td><td align=\"right\"  style=\"background:#333333; color:#FFFFFF; float:right;\"><strong>Area Total Sales: ";
			$c1=mysql_query("SELECT SUM(net_amount) AS NETAT  FROM areawise_temp WHERE  pincode='".$customer->pincode."' AND (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_cust_id   != '' AND our_product_id   != ''"); while($customers1=mysql_fetch_object($c1)){
			$html.=round($customers1->NETAT,2)."</td></tr>";
			
			}
			// First ROW - End
			
		   // Second ROW - Start
			$b=mysql_query("SELECT DISTINCT(cust_name) AS CNAME, area_name AS ANAME  FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode=".$customer->pincode.""); while($customer1=mysql_fetch_object($b)){
			$html.="<tr><td style=\"background:#C6E2FF\">".$customer1->CNAME."</td><td style=\"background:#C6E2FF\">".$customer1->ANAME."</td><td  align=\"right\" style=\"background:#C6E2FF\"><strong>Total Sales:";
			$sql_sub = mysql_query("SELECT SUM(net_amount) AS NETAMOUNT FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND cust_name='".$customer1->CNAME."' AND pincode=".$customer->pincode."");while($customer_y=mysql_fetch_object($sql_sub)){ 
			$html.=round($customer_y->NETAMOUNT,2)."</strong></td>";			
			}
			$html.="</tr>";
			
			$b3=mysql_query("SELECT pro_name FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND  cust_name='".$customer1->CNAME."' AND pincode=".$customer->pincode." Group By pro_name"); while($customer3=mysql_fetch_object($b3)){
				// 2.2 ROW - Start
				$html.="<tr><td  style=\"color:#3399CC; background:#eaeaea\" colspan=\"1\">".$customer3->pro_name."</td>";
				
				// 2.3 ROW - Start - Product Details
				$html.="<td  colspan=\"2\"><table  style=\"border:1px solid #333333;border-collapse: collapse;\"><tr><td style=\"background:#FFE4B5;border-right:1px solid #333333;\">Distributor Name</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;\">Doctor Type</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;\">Quantity</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;\">Free Quantity</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;\">Replace Quantity</td><td style=\"background:#FFE4B5;border-right:1px solid #333333;\">Sale Value</td><td style=\"background:#FFE4B5;border-bottom:1px solid #333333;\">Net Amount</td></tr>";
				
				$b4=mysql_query("SELECT dist_id AS dist_id, SUM(quantity) AS quantity, SUM(free_quantity) AS free_quantity, SUM(replace_quantity) AS replace_quantity, SUM(sale_value) AS sale_value, SUM(net_amount) AS net_amount FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pro_name='".$customer3->pro_name."' AND  cust_name='".$customer1->CNAME."' AND pincode=".$customer->pincode." GROUP BY dist_id, '".$customer3->pro_name."'"); while($customer4=mysql_fetch_object($b4)){
				$html.="<tr><td style=\"border-right:1px solid #333333;border-top:1px solid #333333;\">";
				$sql1 = mysql_query("SELECT * FROM distributor WHERE dis_id =".$customer4->dist_id.""); $r1=mysql_fetch_object($sql1);
				$html.=$r1->dis_name."</td><td style=\"border-right:1px solid #333333;border-top:1px solid #333333;\">Floating</td><td  style=\"border-right:1px solid #333333;border-top:1px solid #333333;\" align=\"center\">".$customer4->quantity."</td><td  style=\"border-right:1px solid #333333;border-top:1px solid #333333;\" align=\"center\">".$customer4->free_quantity."</td><td  style=\"border-right:1px solid #333333;border-top:1px solid #333333;\" align=\"center\">".$customer4->replace_quantity."</td><td  style=\"border-right:1px solid #333333;border-top:1px solid #333333;\" align=\"right\">".$customer4->sale_value."</td><td  style=\"border-top:1px solid #333333;\" align=\"right\">".$customer4->net_amount."</td></tr>";
					//$subtotal = 0; $subtotal=$subtotal+$customer4->net_amount;
				
				}
				$b9=mysql_query("SELECT SUM(net_amount) AS net_amount FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pro_name='".$customer3->pro_name."' AND  cust_name='".$customer1->CNAME."' AND pincode=".$customer->pincode." GROUP BY '".$customer3->pro_name."'"); $customer9=mysql_fetch_object($b9);
				$html.="<tr style=\"color:#000000;border-top:1px solid #333333;font-weight:bold\"><td colspan=\"6\" style=\"background:#BDFCC9;border-top:1px solid #333333;\">Sub Total</td><td colspan=\"1\"  align=\"right\" style=\"background:#BDFCC9;border-top:1px solid #333333;\">".round($customer9->net_amount,2)."</td></tr>";
				
				// 2.3 ROW - End - Product Details
				$html.="</table></td></tr>";
				
				}	// 2.2 ROW - End
			}		   
			// Second ROW - End
			
			
		}
		
$html.="</table>";


$html.="<table style=\"width:100%;border:1px solid #333333;border-collapse:collapse;\"><tr><td align=\"center\"  colspan=\"8\" style=\"background:#ea3511; color:#FFFFFF; border:none;\">Customerwise Summary</tr>";
		$html.="<tr><th style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">Product</th><th style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">No of Pincodes</th><th style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">No of Customers</th><th style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">Sale QTY</th><th style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">Free QTY</th><th style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">Replace QTY</th><th style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">Sale AMT</th><th style=\"border-bottom:1px solid #333333;\">Net AMT</th></tr>";
		$b6=mysql_query("SELECT pro_name FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' Group By pro_name"); while($customer6=mysql_fetch_object($b6)){				
				$b7=mysql_query("SELECT COUNT(DISTINCT(pincode)) AS SPIN, COUNT(DISTINCT(cust_name)) AS CUSTNAME, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY,  SUM(sale_value) AS SAMT, SUM(net_amount) AS NAMT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != '' AND pro_name = '".$customer6->pro_name."' "); $customer7=mysql_fetch_object($b7);
				//$html.="<tr><td>Product</td></tr>";
				$html.="<tr><td style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$customer6->pro_name."</td><td align=\"center\" style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer7->SPIN."</td><td  align=\"center\" style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$customer7->CUSTNAME."</td><td style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer7->QTY."</td><td style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\" align=\"center\">".$customer7->FQTY."</td><td align=\"center\" style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">".$customer7->RQTY."</td><td  align=\"right\" style=\"border-right:1px solid #333333;border-bottom:1px solid #333333;\">".round($customer7->SAMT,2)."</td><td align=\"right\" style=\"border-bottom:1px solid #333333;\">".round($customer7->NAMT,2)."</td></tr>";
				//}
				}
				$html.="</table>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','',9); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->keep_table_proportions = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>