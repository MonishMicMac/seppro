<?php

include("connect.php"); 


$strSQL = "SELECT * FROM tbl_product_adde_slide ORDER BY id ASC";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>