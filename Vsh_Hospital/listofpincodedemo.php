<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$id=$_REQUEST['id'];
$strSQL = "SELECT DISTINCT pin_id,pincode FROM master_pincode";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>