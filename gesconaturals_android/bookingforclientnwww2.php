<?php
include("connect1.php"); 
//secondary
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






date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);


global $leaverepid,$repname,$leavedate,$leavereason;





for($i=0;$i< count($proid);$i++)
{
	$monthpobtotal1s1=mysql_query("SELECT * FROM `pobbooking_second` WHERE `client_id`='".$client_id."' AND productid='".$proid[$i]."' AND repid ='$repid' AND cdate='$c_date'");
if(mysql_num_rows($monthpobtotal1s1)==0)
{


	mysql_query("insert into pobbooking_second(pob_type,client_id,stockistid,productid,qty,cdate,ctime,repid,paymentterms,latitude,longitude)values('$pob_type','$client_id','$stockistid','$proid[$i]','$qtyid[$i]','$c_date','$c_time','$repid','$paymentterms','$latitude','$longitude')")or die(mysql_error());


}



}

// $monthpobtotal1=mysql_query("SELECT * FROM `tbl_work_plan` WHERE `wp_dc_id`='".$dr_id."' AND wp_rep_id='".$repid."' AND wp_date LIKE '%".$c_date."%' ");
// if(mysql_num_rows($monthpobtotal1)!=0)
// {

// // mysql_query("insert into tbl_work_plan(attendancestatus,areaname,reporteddate,reportedtime,drunavailable,reportstatus,drunavailablereason,wp_rep_id,wp_date,latitude,longitude,wp_dc,wp_dc_id,c_date,c_time)values('1','$address','$c_date','$c_time','$drunavailable','$drunavailable','$drunavailablereason','$repid','$c_date','$latitude','$longitude','D','$dr_id','$c_date','$c_time')")or die(mysql_error());

// mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue' WHERE wp_id='$wp_id'")or die(mysql_error());

// }
/*
mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue' WHERE wp_id='$wp_id'")or die(mysql_error());

*/



















?>