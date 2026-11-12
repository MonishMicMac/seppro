<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);



echo "[";					
	$PRODUCT=mysql_query("SELECT id, pro_name FROM product");
	$CNT=mysql_num_rows($PRODUCT);
	while($R=mysql_fetch_array($PRODUCT)){
	echo "{\"PRODUCT\":\"".$R["pro_name"]."\",";
	
	//$product[]=$R["pro_name"];
	for($i=12;$i>=1;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_array($SQL)){						
						$QTY = mysql_query("SELECT SUM(areawise_temp.quantity) AS TOTQTY FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS['FirstDay']))."' AND '".date("Y/m/d",strtotime($RS['LastDay']))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id  AND areawise_temp.state_id=1 AND areawise_temp.our_product_id='".$R["id"]."' GROUP BY '".$R["id"]."'");
						$Rs_Sales=mysql_fetch_array($QTY);
						if($Rs_Sales['TOTQTY']==""){$Rs_Sales['TOTQTY']=0;}	
						if($CNT==1){
							
							if($i==1){echo "\"month$i\":\"".date("M y",strtotime($RS['FirstDay']))."\",\"QTY$i\":\"".$Rs_Sales['TOTQTY']."\"}]";}
							else{echo "\"month$i\":\"".date("M y",strtotime($RS['FirstDay']))."\",\"QTY$i\":\"".$Rs_Sales['TOTQTY']."\",";}
							
						}
						else{
							if($i==1){echo "\"month$i\":\"".date("M y",strtotime($RS['FirstDay']))."\",\"QTY$i\":\"".$Rs_Sales['TOTQTY']."\"},";}
							else{echo "\"month$i\":\"".date("M y",strtotime($RS['FirstDay']))."\",\"QTY$i\":\"".$Rs_Sales['TOTQTY']."\",";}
						}					
						//echo "\"month$i\":\"".date("M y",strtotime($RS['FirstDay']))."\",\"QTY$i\":\"".$Rs_Sales['TOTQTY']."\",";
						
						}
						}
						$CNT--;
						}
 				
				
?>