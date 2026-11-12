<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');



$strSQL = "SELECT DISTINCT id,pro_name,pts,ptr,dummyid,packing FROM product WHERE id!=100 AND dummyid='2'";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>