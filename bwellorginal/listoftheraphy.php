<?php

include("connect.php"); 

 define('WP_MEMORY_LIMIT', '512M');


$strSQL = "SELECT DISTINCT theraphy_id,theraphy FROM mst_theraphy";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($antony);
?>