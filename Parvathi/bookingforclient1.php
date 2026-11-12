<?php
include("connect1.php"); 

$pob_type=$_REQUEST['pob_type'];
$stockistid=$_REQUEST['stockistid'];
$client_id=$_REQUEST['client_id'];
$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];
$paymentterms=$_REQUEST['paymentterms'];

$repid=$_REQUEST['repid'];


$latitude=$_REQUEST['latitude'];



$longitude=$_REQUEST['longitude'];


$wp_id=$_REQUEST['wp_id'];

$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$dr_id=$_REQUEST['dr_id'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];

$gift=$_REQUEST['gift'];

$podate=$_REQUEST['podate'];




date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);


global $leaverepid,$repname,$leavedate,$leavereason;


if($productid=='JUST')
{
}
else
{
for($i=0;$i< count($proid);$i++)
{
mysql_query("insert into pobbooking(pob_type,client_id,stockistid,productid,qty,cdate,ctime,repid,paymentterms,latitude,longitude)values('$pob_type','$client_id','$stockistid','$proid[$i]','$qtyid[$i]','$podate','$c_time','$repid','$paymentterms','$latitude','$longitude')")or die(mysql_error());
}
}





mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address',gift='$gift',reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue' WHERE wp_id='$wp_id'")or die(mysql_error());

$pobchwk=mysql_query("SELECT * FROM doctors WHERE dr_longitude='' AND dr_longitude='' AND id='$dr_id'")or die(mysql_error());
$pobchwk_cnt=mysql_num_rows($pobchwk);
if($pobchwk_cnt>0)
{
mysql_query("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$dr_id'")or die(mysql_error());



}
else
{


}











?>