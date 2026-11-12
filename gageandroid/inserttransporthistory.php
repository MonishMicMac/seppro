<?php
include("../includes/connect_db.php"); 

$stu_transport_id=$_REQUEST['stu_transport_id'];
$stu_id=$_REQUEST['stu_id'];
$stu_guardian_name=$_REQUEST['stu_guardian_name'];
$stu_guardian_contactno=$_REQUEST['stu_guardian_contactno'];
$stu_remarks=$_REQUEST['stu_remarks'];
$mobile_no=$_REQUEST['mobile_no'];


$a=mysql_query("insert into tbl_transport_history(stu_id,stu_guardian_name,stu_guardian_contactno,stu_remarks,stu_pd_datetime)values('$stu_id','$stu_guardian_name','$stu_guardian_contactno','$stu_remarks','".date("Y-m-d")."')")or die(mysql_error());





$message2="".$stu_guardian_name."%0A";
$message3='Your child is picked up by ';

$com_message=$message3.$message2;


$message=urlencode($com_message);
$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A6a9262142bef144b83b5baa6fe0eda67&to=".$mobile_no."&sender=KALIGI&message=".$com_message);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$data = curl_exec($ch);

?>