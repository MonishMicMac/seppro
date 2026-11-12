<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);








$sql2="SELECT product.pro_name, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM `areawise_temp`,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.pincode='".$_REQUEST["pincode"]."' AND areawise_temp.our_cust_id='".$_REQUEST["our_cust_id"]."' AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id";$result2=mysql_query($sql2);while($customers1=mysql_fetch_assoc($result2)){$json1[]=$customers1;}

echo json_encode($json1);



?>