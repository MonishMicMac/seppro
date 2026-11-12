<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];
$attendancestatus=$_REQUEST['attendancestatus'];




$strSQL = $je->prepare("SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_pincode,doctors.doc_contact_no,doctors.prescriber,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.attendancestatus='$attendancestatus'");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>