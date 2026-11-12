<?php

include("connect1.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$res;
echo '[';


$cmnth=date('Y-m-');

date_default_timezone_set("Asia/Kolkata");
$c_datex=date('Y-m-d');



$totalsum=mysql_query("SELECT pts,qty FROM pobbooking,product WHERE product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['repid']."' AND pobbooking.qty>0 AND pobbooking.cdate LIKE '$cmnth%' ")or die(mysql_error());
while($totalsum_res=mysql_fetch_array($totalsum))
{
  
$sum+=$totalsum_res['pts']*$totalsum_res['qty'];

}



$product=mysql_query("SELECT product.id,product.pro_name,product.packing FROM product,pobbooking WHERE product.id!='100' AND product.id=pobbooking.productid AND pobbooking.repid='".$_REQUEST['repid']."' AND pobbooking.qty>=0 AND pobbooking.cdate='$c_datex' GROUP BY pobbooking.productid")or die(mysql_error());
while($product_res=mysql_fetch_array($product))
{

$productqty=mysql_query("SELECT IFNULL(sum(qty), '0') AS sqty FROM pobbooking WHERE repid='".$_REQUEST['repid']."' AND cdate='".date('Y-m-d')."' AND productid ='".$product_res['id']."' ")or die(mysql_error());


$productqty_res=mysql_fetch_array($productqty);

if(strlen($productqty_res['sqty'])<1)
{
$qty=0;
}
else
{
 $qty=$productqty_res['sqty'];
}

$res.='{"proname":"'.$product_res['pro_name'].'","qty":"'.$qty.'","tot":"'.$sum.'"},';

}

echo substr($res,0,-1).']';

?>