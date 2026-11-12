<?php

include("connect.php"); 


$strSQL = "SELECT distinct imagevideoname FROM tbl_product_adde_slide ORDER BY imagevideoname";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>