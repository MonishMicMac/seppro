<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$doc_id=$_REQUEST['doc_id'];


$strSQL = "SELECT promoted_products.product_id,product.pro_name,promoted_products.group_name  FROM promoted_products,product WHERE promoted_products.doc_id='$doc_id' AND product.id=promoted_products.product_id";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>