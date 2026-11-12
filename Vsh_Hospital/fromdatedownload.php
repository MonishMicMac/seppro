<?php

include("connect.php"); 


$repid=$_REQUEST['repid'];






$strSQL = "SELECT tbl_work_plan.wp_date,tbl_work_plan.reporteddate,tbl_work_plan.wp_dc_id,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doctor_addrs FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST['fromdate']))."' AND '".date('Y-m-d',strtotime($_REQUEST['todate']))."' AND tbl_work_plan.wp_rep_id='$repid'  AND doctors.id=tbl_work_plan.wp_dc_id";

$objQuery = $je->prepare($strSQL);
	
	$objQuery ->execute();
	
$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);
?>