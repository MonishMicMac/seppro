<?php
include("connect.php"); 

$id=$_REQUEST['id'];
$doctor_name=$_REQUEST['doctor_name'];
$doctor_addrs=$_REQUEST['doctor_addrs'];
$doc_hospital_clinic_name=$_REQUEST['doc_hospital_clinic_name'];
$managerlat=$_REQUEST['managerlat'];
$managerlong=$_REQUEST['managerlong'];

$doc_specilist_id=$_REQUEST['doc_specilist_id'];
$doc_qualification=$_REQUEST['doc_qualification'];
$patientpervisit=$_REQUEST['patientpervisit'];
$prescriber=$_REQUEST['prescriber'];

$doc_specific=$_REQUEST['doc_specific'];
$time_specific=$_REQUEST['time_specific'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$b = $je->prepare("UPDATE doctors SET doctor_name='$doctor_name',doctor_addrs='$doctor_addrs',doc_hospital_clinic_name='$doc_hospital_clinic_name',doc_specilist_id='$doc_specilist_id',doc_qualification='$doc_qualification',patientpervisit='$patientpervisit',prescriber='$prescriber',c_date='$c_date',c_time='$c_time',doc_specific='$doc_specific',time_specific='$time_specific' WHERE id = '$id'")or die(mysql_error());

$b->execute();

$c = $je->prepare("UPDATE doctors SET managerapprovestatus='0' WHERE id = '$id'")or die(mysql_error());

$c->execute();

?>
