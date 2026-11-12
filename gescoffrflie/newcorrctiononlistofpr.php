<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$dummyid=$_REQUEST['dummyid'];


$strSQL = "SELECT DISTINCT id,pro_name,pts,ptr FROM product WHERE id!=100 AND dummyid='$dummyid'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>