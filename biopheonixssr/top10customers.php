<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);

$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);

$product_top = mysql_query("SELECT  tbl_customer_master.shop_name AS CNAME, SUM(areawise_temp.our_product_id) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, tbl_customer_master, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.our_cust_id=tbl_customer_master.id  AND areawise_temp.state_id=1 GROUP BY areawise_temp.our_cust_id  ORDER BY TOTPTS DESC LIMIT 0, 5"); $CNT = mysql_num_rows($product_top);
 



$num_rows = mysql_num_rows($product_top);



echo '[';


while($top_product =mysql_fetch_object($product_top)){



echo '{"product":'.'"'.$top_product->CNAME.'-'.$top_product->QTY.'",';

if($num_rows==1)
{
echo '"value":'.'"'.round($top_product->TOTPTS,2).'"}]';
}
else
{
echo '"value":'.'"'.round($top_product->TOTPTS,2).'"},';
}

$num_rows--;

}


 				
				
?>