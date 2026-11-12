<?php
	
$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);

$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);


$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.state_id='1'"); 
 $Rs_Sales=mysql_fetch_array($Sales); //echo "PTR :".round($Rs_Sales["TOTPTR"],2)."PTS:".round($Rs_Sales["TOTPTS"],2); 

echo '[{"TOTPTR":"'.round($Rs_Sales["TOTPTR"],2).'","TOTPTS":"'.round($Rs_Sales["TOTPTS"],2).'"}]';

?>