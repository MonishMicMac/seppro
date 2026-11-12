<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$stateid=$_REQUEST['stateid'];
$strSQL = "SELECT DISTINCT master_pincode.pin_id,master_pincode.pincode,master_pincode.state_id FROM master_pincode WHERE state_id='$stateid'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>