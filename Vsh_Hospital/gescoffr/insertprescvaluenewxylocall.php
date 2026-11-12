<?php
include("connect.php"); 

$wp_id=$_REQUEST['wp_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$dr_id=$_REQUEST['dr_id'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");



$strSQL = $je->prepare("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue' WHERE wp_id='$wp_id'")or die(mysql_error());

$strSQL->execute();

$strSQL1 = $je->prepare("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$dr_id'")or die(mysql_error());

$strSQL1->execute();


if($drunavailable == 0){
$strSQL2 = $je->prepare("UPDATE dropenforschedule SET status='1' WHERE drid='$dr_id'")or die(mysql_error());
$strSQL2->execute();
}




?>