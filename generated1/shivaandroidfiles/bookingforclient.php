<?php
include("connect23.php"); 

$pob_type=$_REQUEST['pob_type'];
$stockistid=$_REQUEST['stockistid'];
$client_id=$_REQUEST['client_id'];
$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];
$paymentterms=$_REQUEST['paymentterms'];

$repid=$_REQUEST['repid'];


$latitude=$_REQUEST['latitude'];



$longitude=$_REQUEST['longitude'];





date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);


global $leaverepid,$repname,$leavedate,$leavereason;

for($i=0;$i< count($proid);$i++)
{
mysql_query("insert into pobbooking(pob_type,client_id,stockistid,productid,qty,cdate,ctime,repid,paymentterms,latitude,longitude)values('$pob_type','$client_id','$stockistid','$proid[$i]','$qtyid[$i]','$c_date','$c_time','$repid','$paymentterms','$latitude','$longitude')")or die(mysql_error());


$chk=mysql_query("SELECT qty FROM mst_pob WHERE dc_id='$stockistid' AND productid='$proid[$i]' AND repid='$repid' AND cdate='$c_date'")or die(mysql_error());

$chk_res=mysql_fetch_array($chk);



$qtyres=$chk_res['qty']-$qtyid[$i];
if($qtyres<0)
{
  $finalqty=0;
}
else
{
$finalqty=$qtyres;
}
mysql_query("UPDATE  mst_pob SET qty='$finalqty' WHERE dc_id='$stockistid' AND productid='$proid[$i]' AND repid='$repid' AND cdate='$c_date'")or die(mysql_error());

}










?>