<?php
include("connect1.php"); 

$pob_type=$_REQUEST['pob_type'];
$stockistid=$_REQUEST['stockistid'];
$client_id=$_REQUEST['client_id'];
$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];


$repid=$_REQUEST['repid'];








date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);





for($i=0;$i< count($proid);$i++)
{
mysql_query("insert into pobbooking1(pob_type,client_id,stockistid,productid,qty,cdate,ctime,repid,paymentterms,latitude,longitude)values('$pob_type','$client_id','$stockistid','$proid[$i]','$qtyid[$i]','$c_date','$c_time','$repid','cash','$latitude','$longitude')")or die(mysql_error());
}















?>