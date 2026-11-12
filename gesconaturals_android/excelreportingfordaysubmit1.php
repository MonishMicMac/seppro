<?php

include("connect1.php"); 

 define('WP_MEMORY_LIMIT', '512M');




 




  
$yu=1;

$client=mysql_query("SELECT  client_id FROM pobbooking WHERE  repid='".$_REQUEST['repid']."' AND cdate='".$_REQUEST['pdate']."' GROUP BY client_id")or die(mysql_error());
$count=mysql_num_rows($client);
if($count>0)
{
$res;
echo '[';
while($client_res=mysql_fetch_array($client))
{
$res1='';
$productname='';
$proname='';
$clientname='';
$clientpincode='';
$quantity='';
$qty='';
$totalqty='';
$totqty='';
$tqty='';




$chk=mysql_query("SELECT pro_name,pts,doctor_name,doc_pincode,qty FROM pobbooking,doctors,product WHERE  repid='".$_REQUEST['repid']."' AND cdate='".$_REQUEST['pdate']."' AND pobbooking.client_id='".$client_res['client_id']."' AND pobbooking.productid=product.id AND pobbooking.client_id=doctors.id ORDER BY client_id")or die(mysql_error());


  while($chk_res=mysql_fetch_array($chk))
  {
    $productname.=$chk_res['pro_name']."@";
    $proname=substr($productname,0,-1);
    $clientname=$chk_res['doctor_name'];
    $clientpincode=$chk_res['doc_pincode'];
    $quantity.=$chk_res['qty']."@";
    $qty=substr($quantity,0,-1);
$quantityss=$chk_res['qty'];
    $totalqty=$chk_res['pts']*$quantityss;
    $totqty.=$totalqty."@";
   $tqty=substr($totqty,0,-1);

  }

if($yu==$count)
{
$res1.='{"clientname":"'.$clientname.'","clientpincode":"'.$clientpincode.'","pro_name":"'.$proname.'","QTY":"'.$qty.'","PRICE":"'.$tqty.'","email":""}';
}
else
{
$res1.='{"clientname":"'.$clientname.'","clientpincode":"'.$clientpincode.'","pro_name":"'.$proname.'","QTY":"'.$qty.'","PRICE":"'.$tqty.'","email":""},';
}
echo $res1;
$yu++;




     

}
echo ']';

}
else
{
echo ']';
}











?>