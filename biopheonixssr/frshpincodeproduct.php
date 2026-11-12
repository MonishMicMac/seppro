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

$a1=mysql_query("SELECT DISTINCT(areawise_temp.our_product_id) AS PID, product.pro_name AS PNAME FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '$frommonth' AND '$tomonth') AND areawise_temp.pincode=".$_REQUEST["pincode"]." AND areawise_temp.our_cust_id   != '' AND areawise_temp.our_product_id   != ''  AND areawise_temp.our_product_id=product.id ")or die(mysql_error());
        while($customer1=mysql_fetch_assoc($a1)){
$b1=mysql_query("SELECT areawise_temp.our_product_id AS PID, count(areawise_temp.our_product_id) AS CPID, product.pro_name AS PNAME, SUM(areawise_temp.quantity) AS YQTY, SUM(areawise_temp.free_quantity) AS YFQTY, SUM(areawise_temp.replace_quantity) AS YRQTY, SUM(areawise_temp.quantity*product.pts) AS YPTS, SUM(areawise_temp.quantity*product.ptr) AS YPTR FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '$frommonth' AND '$tomonth') AND areawise_temp.our_product_id='".$customer1["PID"]."' AND areawise_temp.pincode=".$_REQUEST["pincode"]." AND areawise_temp.our_cust_id != '' AND areawise_temp.our_product_id != '' AND areawise_temp.our_product_id=product.id");
 $customer3=mysql_fetch_assoc($b1); 
 
 $pincode1[] = $customer3;
}
echo json_encode($pincode1);

?>