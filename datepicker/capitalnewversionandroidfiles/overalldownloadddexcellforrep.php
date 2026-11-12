<?php

include("connect.php"); 


$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$date=$year.'-'.$month;
$repid=$_REQUEST['repid'];
$status=$_REQUEST['status'];


$strSQL = "SELECT IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name,favourite,doctor_name,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='' then group_concat(DATE_FORMAT(wp_date,'%d')) else 'Not Met' end) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and attendancestatus='1' and drunavailable='$status' and wp_dc='D') as days FROM doctors WHERE rep_id='$repid'  ";





$objQuery = $je->prepare($strSQL);
	
	$objQuery ->execute();
	
$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($array);
?>