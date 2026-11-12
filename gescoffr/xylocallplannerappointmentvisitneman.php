<?php
include("connect.php"); 

$wp_id=$_REQUEST['wp_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];

$promoted_products=$_REQUEST['promoted_products'];
date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");



$strSQL = $je->prepare("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',promoted_products='$promoted_products' WHERE wp_id='$wp_id'")or die(mysql_error());

$strSQL->execute();

if($drunavailable == 0){
$sql = $je->prepare("SELECT wp_dc_id FROM tbl_work_plan WHERE wp_id='$wp_id'")or die(mysql_error());
$sql->execute();
$dr_id = $sql->fetchColumn();

$strSQL2 = $je->prepare("UPDATE dropenforschedule SET status='1' WHERE drid='$dr_id'")or die(mysql_error());
$strSQL2->execute();
}

?>