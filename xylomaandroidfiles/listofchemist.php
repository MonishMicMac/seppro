<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');


$strSQL = "SELECT DISTINCT id,pincode,customer_name FROM tbl_customer_master";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>