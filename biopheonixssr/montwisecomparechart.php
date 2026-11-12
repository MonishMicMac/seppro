<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);

 


for($i=12;$i>=1;$i--){	
				$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");				
				
while($RS=mysql_fetch_object($SQL)){ 
if($i==12)
{
echo '[';
}
 echo '{"month":'.'"'.date("M y",strtotime($RS->FirstDay)).'"';
 
 
 $SQL1 = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL1)){
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id  AND areawise_temp.state_id=1  ");  $Rs_Sales=mysql_fetch_array($Sales); 


if($i==1)
{
 echo ',"PTS":'.'"'.round($Rs_Sales["TOTPTR"],2).'"}]';
}
else
{
 echo ',"PTS":'.'"'.round($Rs_Sales["TOTPTR"],2).'"},';
}

				}
						
						
} }


	
	
?>