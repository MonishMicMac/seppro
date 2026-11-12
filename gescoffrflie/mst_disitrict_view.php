<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$id=$_REQUEST['id'];
$strSQL = "SELECT DISTINCT district_id,district_name FROM master_district WHERE state_id='$id'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>