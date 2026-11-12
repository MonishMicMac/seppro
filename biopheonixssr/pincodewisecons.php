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

$SQL=mysql_query("SELECT cust_name AS CUST, our_cust_id AS CUSTID, COUNT(DISTINCT(our_product_id)) AS PRODUCT, SUM(areawise_temp.quantity*product.ptr) AS PTR, SUM(areawise_temp.quantity*product.pts) AS PTS FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '$frommonth' AND '$tomonth') AND pincode='".$_REQUEST["pincode"]."' AND our_cust_id <>'' AND our_product_id <> '' AND our_cust_id IN (SELECT DISTINCT(our_cust_id) AS CUST FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '$frommonth' AND '$tomonth') AND pincode='".$_REQUEST["pincode"]."' AND our_cust_id <>'' AND our_product_id <> '') AND areawise_temp.our_product_id=product.id GROUP BY our_cust_id");

while($RS=mysql_fetch_assoc($SQL)){
	$json1[]=$RS;	
}

echo json_encode($json1);

?>