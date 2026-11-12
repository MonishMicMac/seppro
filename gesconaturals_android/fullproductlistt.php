<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$dummy_id=$_REQUEST['dummy_id'];


$strSQL = "SELECT id,pro_name,pts,ptr,pro_mrp FROM product WHERE dummyid='$dummy_id' AND pro_name!=100";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>