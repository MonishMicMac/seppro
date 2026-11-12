<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);




$baba = array();
$b=mysql_query("SELECT (SELECT dis_name FROM distributor WHERE areawise_temp.dist_id=distributor.dis_id) AS DID, cust_name, SUM(quantity) AS QTY, SUM(free_quantity) AS FQTY, SUM(replace_quantity) AS RQTY, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND our_product_id='".$_REQUEST["PID"]."' AND pincode=".$_REQUEST["pincode"]." AND our_cust_id   != '' AND our_product_id   != '' AND areawise_temp.our_product_id = product.id GROUP BY cust_name,pincode,dist_id ORDER BY dist_id "); echo mysql_error(); while($customer1=mysql_fetch_assoc($b)){ $baba[] = $customer1; }

echo json_encode($baba);
?>