<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];
$morningevening=$_REQUEST['morningevening'];



$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,tbl_customer_master.owner_name,tbl_customer_master.shop_name,tbl_customer_master.mobile_no,tbl_customer_master.customer_address FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc='C' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND tbl_work_plan.morningevening='$morningevening' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id";

$objQuery = $je->prepare($strSQL);
	
	$objQuery ->execute();
	
	

$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($array);
?>