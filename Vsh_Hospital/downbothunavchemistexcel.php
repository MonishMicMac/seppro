<?php

include("connect.php"); 


$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$date=$year.'-'.$month;
$repid=$_REQUEST['repid'];
$status=$_REQUEST['status'];


$strSQL = "SELECT shop_name,mobile_no,pincode,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='' then group_concat(DATE_FORMAT(wp_date,'%d')) else 'Not Met' end) FROM tbl_work_plan WHERE wp_dc_id= tbl_customer_master.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and attendancestatus='1' and drunavailable='$status' and wp_dc='C') as days FROM tbl_customer_master WHERE rep_id='$repid'";




$objQuery = $je->prepare($strSQL);
	
	$objQuery ->execute();
	
$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);
?>