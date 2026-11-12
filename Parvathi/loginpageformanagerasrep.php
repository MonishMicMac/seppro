<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$rep_id=$_REQUEST['rep_id'];

$strSQL = "SELECT * FROM representative WHERE (rep_imeino='$rep_id' OR rep_imeino1='$rep_id') AND rep_id!='0'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>