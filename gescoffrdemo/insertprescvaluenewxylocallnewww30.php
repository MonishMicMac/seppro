<?php


include("connect.php"); 
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);

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
$user_type=$_REQUEST['user_type'];
$billno=$_REQUEST['billno'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$sql=$je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date=CURDATE() AND wp_dc='D' AND wp_dc_id='$dr_id' AND wp_rep_id='$rep_id'")or die(mysql_error());
$sql->execute();
if($sql->fetchColumn()>0) 
{
	
	$strSQL3=$je->prepare("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue',promoted_products='$promoted_products',promotion_service='$promotion_service',productname='$productname',cash_type='$cash_type',cash_amount='$cash_amount',cheque_no='$cheque_no',user_type='$user_type',billno='$billno' WHERE wp_dc_id='$dr_id' AND wp_rep_id='$rep_id' and wp_date='$c_date'")or die(mysql_error());
		$strSQL3->execute();
}



$sql=$je->prepare("SELECT dr_latitude,dr_longitude FROM doctors WHERE id='$dr_id'")or die(mysql_error());
$sql->execute();
$data = $sql->fetch();
if($data['dr_latitude']=='')
{
	$strSQL1 = $je->prepare("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$dr_id'")or die(mysql_error());
	$strSQL1->execute();
}

?>