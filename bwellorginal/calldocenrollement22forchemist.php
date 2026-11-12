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

$shopname=$_REQUEST['shopname'];
$pinid=$_REQUEST['pinid'];
$districtid=$_REQUEST['districtid'];
$cusname=$_REQUEST['cusname'];
$mobileno=$_REQUEST['mobileno'];
$landlineno=$_REQUEST['landlineno'];
$drugno=$_REQUEST['drugno'];
$pincodee=$_REQUEST['pincodee'];

$customer_address=$_REQUEST['customer_address'];
$owner_name=$_REQUEST['owner_name'];
$typeofdoctor=$_REQUEST['typeofdoctor'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$a=$je->prepare("insert into doctors(doctor_name,doc_specilist_id,doc_qualification,doc_regis_no,doctor_addrs,doc_contact_no,doc_hospital_clinic_name,doc_district_id,doc_pin_id,dr_latitude,dr_longitude,rep_id,rep_assign,doc_status,c_date,c_time,doc_specific,time_specific,years,otheraddress,otherhosname,typeofdoctor)values('$doctor_name','$doc_specilist_id','$doc_qualification','$doc_regis_no','$doctor_addrs','$doc_contact_no','$doc_hospital_clinic_name','$doc_district_id','$doc_pin_id','$dr_latitude','$dr_longitude','$rep_id','$rep_id',$doc_status,'$c_date','$c_time','$doc_specific','$time_specific','$years','$otheraddress','$otherhosname','$typeofdoctor')")or die(mysql_error());

$a->execute();


$id =$je->lastInsertId();




$b=$je->prepare("insert into tbl_customer_master(owner_name,shop_name,customer_name,mobile_no,landlineno,customer_address,drug_lincense_no1,district_id,pin_id,rep_id,doctor_id,pincode)values('$owner_name','$shopname','$cusname','$mobileno','$landlineno','$customer_address','$drugno','$districtid','$pinid','$rep_id','$id','$pincodee')")or die(mysql_error());

$b->execute();

$id1 = $je->lastInsertId();


$c=$je->prepare("insert into tbl_doctor_chemist(doctor_id,chemist_id,rep_id,status)values('$id','$id1','$rep_id','0')")or die(mysql_error());

$c->execute();
?>
