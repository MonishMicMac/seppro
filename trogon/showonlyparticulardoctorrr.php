<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$repid=$_REQUEST['repid'];


$strSQL = "SELECT * FROM doctors WHERE rep_id='$repid'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	
	
	echo json_encode($antony);
?>