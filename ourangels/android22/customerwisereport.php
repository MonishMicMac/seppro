<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');





$sql2="SELECT pincode, SUM(net_amount) AS NETAT, AREA_NAME  FROM areawise_temp WHERE  (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND pincode=".$_REQUEST["pincode"]." AND our_cust_id<>'' AND our_product_id<>''";$result2=mysql_query($sql2);while($customers1=mysql_fetch_assoc($result2)){$json1[]=$customers1;}

echo json_encode($json1);



?>