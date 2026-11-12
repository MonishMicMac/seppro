<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');


$strSQL = "SELECT representative.id,representative.rep_name,representative.rep_id,representative.repcurrentstatus,representative.lasttime,representative.waiting,representative.rep_activatedeactivate,representative.status,representative.rep_lat,representative.rep_long,representative.lastdate FROM representative,assigningreptomanager WHERE  representative.rep_activatedeactivate='0' and representative.id=assigningreptomanager.repid";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>