<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');
$rep_imeino=$_REQUEST['rep_imeino'];

$strSQL = "SELECT id,rep_name,rep_id,rep_imeino FROM representative where rep_imeino='$rep_imeino'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>