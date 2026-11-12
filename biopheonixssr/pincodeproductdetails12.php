<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);





 $a = explode("/",$_REQUEST["from_date"]);
 $flen = strlen($a[1]);

if($flen != '2')
{
 $frommonth = $a[0]."/"."0".$a[1]."/".$a[2];
}
else
{
 $frommonth = $_REQUEST["from_date"];
}

$b = explode("/",$_REQUEST["to_date"]);
 $tlen = strlen($b[1]);

if($tlen != '2')
{
 $tomonth = $b[0]."/"."0".$b[1]."/".$b[2];
}
else
{
 $tomonth = $_REQUEST["to_date"];
}



$sql2="SELECT product.pro_name, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.free_quantity) AS FQTY, SUM(areawise_temp.replace_quantity) AS RQTY, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM `areawise_temp`,product WHERE (areawise_temp.bill_date BETWEEN '$frommonth' AND '$tomonth')  AND areawise_temp.our_cust_id='".$_REQUEST["our_cust_id"]."' AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id";
$result2=mysql_query($sql2);
while($customers1=mysql_fetch_assoc($result2))
{
$json1[]=$customers1;
}

echo json_encode($json1);



?>