<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');

$specialist=$_REQUEST['specialist'];
$group_name=$_REQUEST['group_name'];
$rep_id=$_REQUEST['rep_id'];
$doc_id=$_REQUEST['doc_id'];



$strSQL = "SELECT IFNULL((select id from promoted_products where rep_id='$rep_id' AND  doc_id='$doc_id' AND promoted_products.product_id=product.id order by id asc limit 1),'0') as status,product.pro_name,product.id FROM specialist_grouping,product WHERE specialist_grouping.specialist='$specialist' AND specialist_grouping.group_name='$group_name' AND product.id=specialist_grouping.product";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);
?>