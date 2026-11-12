<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];
$morningevening=$_REQUEST['morningevening'];



$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,distributor.dis_name,distributor.dis_abb,distributor.reg_addr,distributor.dis_abb,distributor.corp_pin FROM tbl_work_plan,distributor WHERE tbl_work_plan.wp_dc='S' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND tbl_work_plan.morningevening='$morningevening' AND distributor.id=tbl_work_plan.wp_dc_id";

$objQuery = $je->prepare($strSQL);
$objQuery ->execute();
	

$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);	
	
	echo json_encode($array);
?>