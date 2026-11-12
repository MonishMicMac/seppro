<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$stateid=$_REQUEST['stateid'];
$strSQL = "SELECT * FROM specilist_list ";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>