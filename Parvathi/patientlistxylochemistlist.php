<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
$doctor_id=$_REQUEST['doctor_id'];
$strSQL = "SELECT * FROM tbl_customer_master WHERE rep_id='$pid' and doctor_id='$doctor_id'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>