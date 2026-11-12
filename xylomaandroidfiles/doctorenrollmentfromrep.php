<?php
include("connect.php"); 

$doctor_name=$_REQUEST['doctor_name'];
$doc_specilist_id=$_REQUEST['doc_specilist_id'];
$doc_qualification=$_REQUEST['doc_qualification'];
$doc_regis_no=$_REQUEST['doc_regis_no'];
$doctor_addrs=$_REQUEST['doctor_addrs'];
$doc_contact_no=$_REQUEST['doc_contact_no'];

$doc_specific=$_REQUEST['doc_specific'];
$time_specific=$_REQUEST['time_specific'];

$doc_hospital_clinic_name=$_REQUEST['doc_hospital_clinic_name'];
$doc_district_id=$_REQUEST['doc_district_id'];
$doc_pin_id=$_REQUEST['doc_pin_id'];



$dr_latitude=$_REQUEST['dr_latitude'];
$dr_longitude=$_REQUEST['dr_longitude'];
$doc_status='1';
$rep_id=$_REQUEST['rep_id'];

$years=$_REQUEST['years'];
$otheraddress=$_REQUEST['otheraddress'];
$otherhosname=$_REQUEST['otherhosname'];



date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$a=$je->prepare("insert into doctors(doctor_name,doc_specilist_id,doc_qualification,doc_regis_no,doctor_addrs,doc_contact_no,doc_hospital_clinic_name,doc_district_id,doc_pin_id,dr_latitude,dr_longitude,rep_id,rep_assign,doc_status,c_date,c_time,doc_specific,time_specific,years,otheraddress,otherhosname)values('$doctor_name','$doc_specilist_id','$doc_qualification','$doc_regis_no','$doctor_addrs','$doc_contact_no','$doc_hospital_clinic_name','$doc_district_id','$doc_pin_id','$dr_latitude','$dr_longitude','$rep_id','$rep_id',$doc_status,'$c_date','$c_time','$doc_specific','$time_specific','$years','$otheraddress','$otherhosname')")or die(mysql_error());

$a->execute();


?>
