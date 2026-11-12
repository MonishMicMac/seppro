<?php

include("connect.php"); 

$month=$_REQUEST['month'];
$repid=$_REQUEST['repid'];
$year=$_REQUEST['year'];

$date =$year."-".$month; 



$strSQL = "SELECT tbl_work_plan.wp_date,tbl_work_plan.reporteddate,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doctor_addrs FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_date LIKE '$date%' AND tbl_work_plan.wp_rep_id='$repid'  AND doctors.id=tbl_work_plan.wp_dc_id";

$objQuery = $je->prepare($strSQL);
	
	$objQuery ->execute();
	
$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);
?>