<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
$drid=$_REQUEST['drid'];

$strSQL = "SELECT * FROM tbl_customer_master WHERE rep_id='$pid' and id NOT IN (SELECT chemist_id FROM tbl_doctor_chemist WHERE doctor_id='$drid')";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>