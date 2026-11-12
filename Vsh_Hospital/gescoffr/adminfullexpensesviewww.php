<?php

include("connect.php"); 



 $strSQL = "SELECT id,rep_name FROM representative";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>