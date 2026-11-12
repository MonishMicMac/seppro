<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$dummy_id=$_REQUEST['dummy_id'];


$strSQL = "SELECT id,product_group FROM product  group by mark_id order by id Asc";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>