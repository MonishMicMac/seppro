<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$rep_id=$_REQUEST['rep_id'];
$strSQL = "SELECT DISTINCT master_pincode.pin_id,master_pincode.pincode FROM master_pincode";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>