<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');





$sql2="SELECT pincode,area_name, SUM(net_amount) AS NT FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '2015/02/20' AND '2015/02/28') AND our_cust_id<>'' AND our_product_id<>'' AND pincode IN (SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id FROM rep_area WHERE rep_id = 1) GROUP BY pincode) GROUP BY pincode";

$result2=mysql_query($sql2);while($customers1=mysql_fetch_assoc($result2)){$json1[]=$customers1;}

echo json_encode($json1);



?>