<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];



$strSQL = "SELECT tbl_work_plan.wp_dc_id FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='S' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.drunavailable='0'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>