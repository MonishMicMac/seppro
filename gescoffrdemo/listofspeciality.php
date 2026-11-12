<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$specialist=$_REQUEST['specialist'];


$strSQL = "SELECT * FROM specialist_grouping WHERE specialist='$specialist' GROUP BY group_name";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>