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
$promoted_products=$_REQUEST['promoted_products'];
$promotion_service=$_REQUEST['promotion_service'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$sql1=$je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date=CURDATE() AND wp_dc='D' AND wp_dc_id='$dr_id' AND wp_rep_id='$rep_id' AND attendancestatus='0'")or die(mysql_error());
$sql1->execute();
if($sql1->fetchColumn()>0)  
{
	$strSQL3 = $je->prepare("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue',promoted_products='$promoted_products',promotion_service='$promotion_service' WHERE wp_dc_id='$dr_id' AND wp_rep_id='$rep_id' and wp_date='$c_date'")or die(mysql_error());
		$strSQL3->execute();
}
else
{
	/*$strSQL = $je->prepare("INSERT INTO tbl_work_plan(wp_dc,wp_rep_id,wp_dc_id,attendancestatus,latitude,longitude,areaname,reporteddate,reportedtime,drunavailable,reportstatus,drunavailablereason,jointworkby,prescriptionvalue,promoted_products,promotion_service,wp_date,c_date,c_time)VALUES('D','$rep_id','$dr_id','1','$latitude','$longitude','$address','$c_date','$c_time','$drunavailable','$drunavailable','$drunavailablereason','$jointworkby','$prescriptionvalue','$promoted_products','$promotion_service',CURDATE(),CURDATE(),CURTIME())")or die(mysql_error());*/
//$strSQL->execute();
}




?>