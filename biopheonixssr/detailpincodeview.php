<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);

$from=date('Y/m/d', strtotime($_REQUEST["from_date"]));
$to=date('Y/m/d', strtotime($_REQUEST["to_date"]));


						$CUST=mysql_query("SELECT product.pro_name AS PNAME, areawise_temp.`our_cust_id` AS CID, (SELECT dis_name FROM distributor WHERE dis_id=areawise_temp.dist_id) AS DID,  areawise_temp.`pincode` as PIN, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.replace_quantity) AS R, SUM(areawise_temp.free_quantity) AS F, SUM(`areawise_temp`.quantity*product.ptr) AS CPTR, SUM(`areawise_temp`.quantity*product.pts) AS CPTS FROM `areawise_temp`,product WHERE `areawise_temp`.rep_id = '".$_REQUEST["rep_id"]."' AND `areawise_temp`.`our_cust_id`<>'' AND `areawise_temp`.`our_product_id`<>'' AND (`areawise_temp`.`bill_date` BETWEEN '$from' AND '$to')  AND `areawise_temp`.pin_id='".$_REQUEST["pin_id"]."' AND product.id=areawise_temp.our_product_id GROUP BY `our_product_id`");
						while($CUST_R=mysql_fetch_assoc($CUST)){$pincode1[]=$CUST_R;}
echo json_encode($pincode1);

?>