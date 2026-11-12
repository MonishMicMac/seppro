<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);

$from=date('Y/m/d', strtotime($_REQUEST["from_date"]));
$to=date('Y/m/d', strtotime($_REQUEST["to_date"]));

$a=mysql_query("SELECT master_pincode.pincode AS PINCODE, areawise_temp.pin_id AS PIN, SUM(areawise_temp.`quantity`*product.ptr) AS PTR,SUM(areawise_temp.`quantity`*product.pts) AS PTS FROM `areawise_temp`,product,master_pincode WHERE `rep_id`='".$_REQUEST["rep_id"]."' AND (`areawise_temp`.`bill_date` BETWEEN '$from' AND '$to') AND `our_cust_id`<>'' AND `our_product_id`<>'' AND `areawise_temp`.`our_product_id`=product.id AND master_pincode.pin_id=areawise_temp.pin_id GROUP BY areawise_temp.`pin_id` ")or die(mysql_error());
        while($customer=mysql_fetch_assoc($a)){$pincode1[] = $customer; }


echo json_encode($pincode1);

?>