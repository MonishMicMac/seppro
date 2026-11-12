<?php

include("connect.php"); 

$pid=$_REQUEST['pid'];
$strSQL = "SELECT * FROM tbl_customer_master WHERE rep_id='$pid'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();

$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>