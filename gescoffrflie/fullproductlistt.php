<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');




$strSQL = "SELECT id,pro_name,pts,ptr,pro_mrp,dummyname FROM product WHERE id IN (1,89) ";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>