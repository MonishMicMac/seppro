<?php

include("connect.php"); 



$reporteddate=$_REQUEST['reporteddate'];

$strSQL = "SELECT * FROM tbl_work_plan,doctors,reportnowforrep,representative WHERE tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_id=reportnowforrep.wpid AND  tbl_work_plan.managerstatus='0' AND  tbl_work_plan.wp_rep_id=representative.id AND reportnowforrep.worktype='2' GROUP BY tbl_work_plan.wp_id";

$objQuery = $je->prepare($strSQL);
	
$objQuery ->execute();	

$ashok= $objQuery->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($ashok);
?>