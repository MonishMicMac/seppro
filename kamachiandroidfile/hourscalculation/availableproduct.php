<?php

include("connect2.php"); 




$strSQL = "SELECT id,pro_name,pro_mrp FROM product";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>