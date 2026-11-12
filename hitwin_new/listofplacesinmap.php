<?php

include("connect2.php"); 

 define('WP_MEMORY_LIMIT', '512M');


$strSQL = "SELECT * FROM representative WHERE rep_lat!= '0' AND rep_activatedeactivate='0'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>