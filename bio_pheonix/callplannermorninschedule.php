<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];
$morningevening=$_REQUEST['morningevening'];



$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND tbl_work_plan.morningevening='$morningevening' AND doctors.id=tbl_work_plan.wp_dc_id";

$objQuery = $je->prepare($strSQL);
$objQuery ->execute();
	

$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);	
	
	echo json_encode($array);
?>