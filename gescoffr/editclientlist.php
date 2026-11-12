<?php
include("connect1.php"); 

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

$doc_contact_no=$_REQUEST['doc_contact_no'];

$doc_specific=$_REQUEST['doc_specific'];
$time_specific=$_REQUEST['time_specific'];
$dob=$_REQUEST['dob'];
$ann=$_REQUEST['ann'];
$favourite=$_REQUEST['favourite'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");



mysql_query("UPDATE doctors SET doctor_name='$doctor_name',doctor_addrs='$doctor_addrs',doc_hospital_clinic_name='$doc_hospital_clinic_name',doc_specilist_id='$doc_specilist_id',doc_qualification='$doc_qualification',visitintervaltovisit='$patientpervisit',doc_gender='$prescriber',c_date='$c_date',c_time='$c_time',dob='$dob',anniversary='$ann',doc_contact_no='$doc_contact_no',favourite='$favourite' WHERE id = '$id'")or die(mysql_error());

$specalist_id=mysql_query("SELECT id FROM specilist_list WHERE specilist_name LIKE '%$doc_specilist_id%'")or die(mysql_error());

$spec_id_res=mysql_fetch_array($specalist_id);

mysql_query("UPDATE doctors SET specialistid='".$spec_id_res['id']."' WHERE id='$id'")or die(mysql_error());


?>
