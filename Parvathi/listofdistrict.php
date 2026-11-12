<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');


$strSQL = "SELECT DISTINCT district_id,district_name FROM master_district";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>