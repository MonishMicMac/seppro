<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];




$strSQL = $je->prepare("SELECT tbl_work_plan.wp_id,tbl_work_plan.wp_dc_id,doctors.doctor_name,doctors.doc_hospital_clinic_name,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification FROM tbl_work_plan,tbl_customer_master,tbl_doctor_chemist,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id AND tbl_customer_master.id=tbl_doctor_chemist.chemist_id AND doctors.id=tbl_doctor_chemist.doctor_id GROUP BY tbl_work_plan.wp_id");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>