<?php
include("connect.php"); 
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$dr_id=$_REQUEST['dr_id'];
$rep_id=$_REQUEST['rep_id'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];
$promoted_products=$_REQUEST['promoted_products'];
$promotion_service=$_REQUEST['promotion_service'];
$productname=$_REQUEST['productname'];


$cash_type=$_REQUEST['cash_type'];
$cash_amount=$_REQUEST['cash_amount'];
$cheque_no=$_REQUEST['cheque_no'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$sql=$je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date=CURDATE() AND wp_dc='D' AND wp_dc_id='$dr_id' AND wp_rep_id='$rep_id' AND attendancestatus='0'")or die(mysql_error());
$sql->execute();
if($sql->fetchColumn()>0) 
{
	
	$strSQL3=$je->prepare("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue',promoted_products='$promoted_products',promotion_service='$promotion_service',productname='$productname',cash_type='$cash_type',cash_amount='$cash_amount',cheque_no='$cheque_no' WHERE wp_dc_id='$dr_id' AND wp_rep_id='$rep_id' and wp_date='$c_date'")or die(mysql_error());
		$strSQL3->execute();
}
else
{
	/*$strSQL=$je->prepare("INSERT INTO tbl_work_plan(wp_dc,wp_rep_id,wp_dc_id,attendancestatus,latitude,longitude,areaname,reporteddate,reportedtime,drunavailable,reportstatus,drunavailablereason,jointworkby,prescriptionvalue,promoted_products,promotion_service,wp_date,c_date,c_time)VALUES('D','$rep_id','$dr_id','1','$latitude','$longitude','$address','$c_date','$c_time','$drunavailable','$drunavailable','$drunavailablereason','$jointworkby','$prescriptionvalue','$promoted_products','$promotion_service',CURDATE(),CURDATE(),CURTIME())")or die(mysql_error());*/

//$strSQL->execute();
}

// exit();

$strSQL1 = $je->prepare("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$dr_id'")or die(mysql_error());

$strSQL1->execute();


if($drunavailable == 0){
$strSQL2 = $je->prepare("UPDATE dropenforschedule SET status='1' WHERE drid='$dr_id'")or die(mysql_error());
$strSQL2->execute();
}




?>