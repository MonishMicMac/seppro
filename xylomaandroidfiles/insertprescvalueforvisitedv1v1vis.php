<?php
include("connect23.php");

$wp_id=$_REQUEST['wp_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");

mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue' WHERE wp_id='$wp_id'")or die(mysql_error());



if($drunavailable == 0){



$strSQLup = mysql_query("SELECT wp_dc_id,c_date,c_time,wp_rep_id FROM tbl_work_plan  WHERE wp_id='$wp_id'")or die(mysql_error());
$strSQLup_res=mysql_fetch_array($strSQLup);

mysql_query("UPDATE v1visitmissed SET attendace='1' WHERE dc_id='".$strSQLup_res['wp_dc_id']."' AND date='".$strSQLup_res['c_date']."' AND time='".$strSQLup_res['c_time']."' AND repid='".$strSQLup_res['wp_rep_id']."'")or die(mysql_error());



}


?>