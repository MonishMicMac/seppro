<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$pid=$_REQUEST['pid'];


$strSQL = "SELECT * FROM tbl_customer_master WHERE length(pincode)<4 AND rep_id='$pid'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>