<?php
include("connect.php"); 

$doctor_name=$_REQUEST['doctor_name'];
$doc_specilist_id=$_REQUEST['doc_specilist_id'];
$doc_qualification=$_REQUEST['doc_qualification'];
$doc_regis_no=$_REQUEST['doc_regis_no'];
$doctor_addrs=$_REQUEST['doctor_addrs'];
$doc_contact_no=$_REQUEST['doc_contact_no'];


$doc_hospital_clinic_name=$_REQUEST['doc_hospital_clinic_name'];
$doc_district_id=$_REQUEST['doc_district_id'];
$doc_pin_id=$_REQUEST['doc_pin_id'];

$sql=$je->prepare("SELECT rep_id FROM rep_area WHERE pin_id='".$_REQUEST['doc_pin_id']."'");
$objQuery ->execute();
$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

//$Y=mysql_fetch_object($sql);

$dr_latitude=$_REQUEST['dr_latitude'];
$dr_longitude=$_REQUEST['dr_longitude'];
$doc_status='1';







$a=$je->prepare("insert into doctors(doctor_name,doc_specilist_id,doc_qualification,doc_regis_no,doctor_addrs,doc_contact_no,doc_hospital_clinic_name,doc_district_id,doc_pin_id,dr_latitude,dr_longitude,rep_id,doc_status)values('$doctor_name','$doc_specilist_id','$doc_qualification','$doc_regis_no','$doctor_addrs','$doc_contact_no','$doc_hospital_clinic_name','$doc_district_id','$doc_pin_id','$dr_latitude','$dr_longitude','$antony['rep_id']',$doc_status)")or die(mysql_error());

$a->execute();

?>
