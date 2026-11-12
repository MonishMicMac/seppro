<?php
include("connect.php"); 

$dr_id=$_REQUEST['dr_id'];
$rep_id=$_REQUEST['rep_id'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];

$promotion_service=$_REQUEST['promotion_service'];
$promoted_products=$_REQUEST['promoted_products'];
date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");



$strSQL = $je->prepare("INSERT INTO tbl_work_plan(wp_dc,wp_rep_id,wp_dc_id,attendancestatus,latitude,longitude,areaname,reporteddate,reportedtime,drunavailable,reportstatus,drunavailablereason,jointworkby,prescriptionvalue,promoted_products,promotion_service,wp_date,c_date,c_time)VALUES('D','$rep_id','$dr_id','1','$latitude','$longitude','$address','$c_date','$c_time','$drunavailable','$drunavailable','$drunavailablereason','$jointworkby','$prescriptionvalue','$promoted_products','$promotion_service',CURDATE(),CURDATE(),CURTIME())")or die(mysql_error());

$strSQL->execute();

if($drunavailable == 0){
$sql = $je->prepare("SELECT wp_dc_id FROM tbl_work_plan WHERE wp_id='$wp_id'")or die(mysql_error());
$sql->execute();
$dr_id = $sql->fetchColumn();

$strSQL2 = $je->prepare("UPDATE dropenforschedule SET status='1' WHERE drid='$dr_id'")or die(mysql_error());
$strSQL2->execute();
}

?>