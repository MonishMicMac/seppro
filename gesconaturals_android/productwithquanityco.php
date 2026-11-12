<?php

include("connect1.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$res;
echo '[';


$sum='0';



$product=mysql_query("SELECT * FROM product WHERE id!='100' AND dummyid='".$_REQUEST['dummyid']."'")or die(mysql_error());
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