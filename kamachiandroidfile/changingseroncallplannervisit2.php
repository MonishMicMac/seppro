<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];
$Status=$_REQUEST['Status'];


if($Status==1)
{
$strSQL = $je->prepare("SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.prescriber,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND doctors.id=tbl_work_plan.wp_dc_id");

$strSQL->execute();
}
else if($Status==2)
{
$strSQL = $je->prepare("SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.prescriber,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' and tbl_work_plan.attendancestatus='0' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND doctors.id=tbl_work_plan.wp_dc_id");

$strSQL->execute();
}
else if($Status==3)
{
	$strSQL = $je->prepare("SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.prescriber,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' and tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND doctors.id=tbl_work_plan.wp_dc_id");

$strSQL->execute();
}




$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>