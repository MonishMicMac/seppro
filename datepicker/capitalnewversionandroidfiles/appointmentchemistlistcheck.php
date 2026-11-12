<?php

include("connect.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];



$strSQL = "SELECT * FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_dc='C' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.drunavailable='0'";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>