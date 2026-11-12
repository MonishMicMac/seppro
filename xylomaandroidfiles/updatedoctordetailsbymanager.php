<?php
include("connect.php"); 

$id=$_REQUEST['id'];
$doctor_name=$_REQUEST['doctor_name'];
$doctor_addrs=$_REQUEST['doctor_addrs'];
$doc_hospital_clinic_name=$_REQUEST['doc_hospital_clinic_name'];
$managerlat=$_REQUEST['managerlat'];
$managerlong=$_REQUEST['managerlong'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$b = $je->prepare("UPDATE doctors SET doctor_name='$doctor_name',doctor_addrs='$doctor_addrs',doc_hospital_clinic_name='$doc_hospital_clinic_name',managerlat='$managerlat',managerlong='$managerlong',managerdate='$c_date',managertime='$c_time',approvedby='1' WHERE id = '$id'")or die(mysql_error());

$b->execute();

?>
