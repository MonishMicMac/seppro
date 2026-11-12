<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

// echo "SELECT * FROM representative WHERE rep_lat!= '0' AND rep_activatedeactivate='0'";

$strSQL = "SELECT * FROM representative WHERE rep_lat!= '' AND rep_activatedeactivate='' AND id IN (select repid from assigningreptomanager where managerid='".$_REQUEST['rep_id']."')";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>