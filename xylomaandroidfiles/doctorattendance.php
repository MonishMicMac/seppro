<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$rep_id=$_REQUEST['rep_id'];

$strSQL = "SELECT * FROM doctors WHERE doc_status='0' AND rep_id='$rep_id'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>