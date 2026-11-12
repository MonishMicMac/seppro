<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];



$strSQL = $je->prepare("SELECT unapprovedtbl_work_plan.wp_id,unapprovedtbl_work_plan.attendancestatus,unapprovedtbl_work_plan.reportstatus,unapprovedtbl_work_plan.wp_dc_id,unapprovedtbl_work_plan.c_time,unapproveddoctors.dr_latitude,unapproveddoctors.dr_longitude,unapproveddoctors.doctor_name,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.doc_contact_no,unapproveddoctors.doctor_addrs,unapproveddoctors.doc_specilist_id,unapproveddoctors.doc_qualification,unapproveddoctors.doc_pincode FROM unapprovedtbl_work_plan,unapproveddoctors WHERE unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.wp_date='$date' AND unapprovedtbl_work_plan.wp_rep_id='$repid' AND unapproveddoctors.id=unapprovedtbl_work_plan.wp_dc_id");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);



?>