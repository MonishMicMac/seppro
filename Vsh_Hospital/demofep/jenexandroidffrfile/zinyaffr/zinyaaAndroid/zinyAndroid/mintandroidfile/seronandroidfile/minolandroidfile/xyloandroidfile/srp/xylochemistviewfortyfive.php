<?php

include("connect.php"); 

 

$doctorid=$_REQUEST['doctorid'];

$strSQL = "SELECT * 
FROM tbl_work_plan,tbl_customer_master WHERE tbl_work_plan.wp_rep_id=  '$doctorid' AND tbl_work_plan.drunavailablereason!='' AND tbl_work_plan.wp_dc='C' AND tbl_customer_master.id=tbl_work_plan.wp_dc_id  ORDER BY wp_id DESC LIMIT 45";





$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	
	echo json_encode($antony);
?>